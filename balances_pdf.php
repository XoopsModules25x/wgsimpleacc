<?php
/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

/**
 * wgSimpleAcc module for xoops
 *
 * @copyright      2020 XOOPS Project (https://xooops.org)
 * @license        GPL 2.0 or later
 * @package        wgsimpleacc
 * @since          1.0
 * @min_xoops      2.5.10
 * @author         Goffy - XOOPS Development Team - Email:<webmaster@wedega.com> - Website:<https://xoops.wedega.com>
 */

use Xmf\Request;
use XoopsModules\Wgsimpleacc;
use XoopsModules\Wgsimpleacc\{
    Constants,
    Utility
};

require __DIR__ . '/header.php';
require_once \XOOPS_ROOT_PATH . '/header.php';
if (\file_exists($tcpdf = \XOOPS_ROOT_PATH.'/Frameworks/tcpdf/')) {
    require_once $tcpdf . 'tcpdf.php';
} else {
    \redirect_header('index.php', 2, \_MA_WGSIMPLEACC_NO_PDF_LIBRARY);
}

require_once $tcpdf . 'config/tcpdf_config.php';
// Get new template
require_once \XOOPS_ROOT_PATH . '/class/template.php';
$pdfTpl = new $xoopsTpl();

$balIds       = explode(',',Request::getString('balIds'));
$levelAlloc   = Request::getInt('level_alloc');
$levelAccount = Request::getInt('level_account');

//add custom styles, astcpdf doesnt support a lot of css
$pdfStyleTh = 'font-weight:bold;border-bottom:1px solid #ddd;';
$pdfStyleThC = $pdfStyleTh . 'text-align:center;';
$pdfStyleThR = $pdfStyleTh . 'text-align:right;';
$pdfTpl->assign('pdfStyleTh', $pdfStyleTh);
$pdfTpl->assign('pdfStyleThC', $pdfStyleThC);
$pdfTpl->assign('pdfStyleThR', $pdfStyleThR);
$pdfStyleTd = 'border-bottom:1px solid #ddd;';
$pdfStyleTdC = $pdfStyleTd . 'text-align:center;';
$pdfStyleTdR = $pdfStyleTd . 'text-align:right;';
$pdfTpl->assign('pdfStyleTd', $pdfStyleTd);
$pdfTpl->assign('pdfStyleTdC', $pdfStyleTdC);
$pdfTpl->assign('pdfStyleTdR', $pdfStyleTdR);

$pdfTpl->assign('displayBalOutput', 1);

$balances = $outputsHandler->getListBalances($balIds);
$sumTotal = 0;
$sumAmountin = 0;
$sumAmountout = 0;
foreach ($balances as $balance) {
    $sumTotal += ($balance['bal_amountend'] - $balance['bal_amountstart']);
    $sumAmountin += $balance['bal_amountstart'];
    $sumAmountout += $balance['bal_amountend'];
}
$pdfTpl->assign('balancesTotal', Utility::FloatToString($sumTotal));
$pdfTpl->assign('balancesAmountIn', Utility::FloatToString($sumAmountin));
$pdfTpl->assign('balancesAmountOut', Utility::FloatToString($sumAmountout));
$pdfTpl->assign('balancesCount', \count($balances));
$pdfTpl->assign('balances', $balances);

if ($levelAccount > 0) {
    $accounts = $outputsHandler->getListAccountsValues($balIds);
    $sumTotal = 0;
    $sumAmountin = 0;
    $sumAmountout = 0;
    foreach ($accounts as $account) {
        $sumTotal += $account['total_val'];
        $sumAmountin += $account['amountin_val'];
        $sumAmountout += $account['amountout_val'];
    }
    $pdfTpl->assign('accountsTotal', Utility::FloatToString($sumTotal));
    $pdfTpl->assign('accountsAmountIn', Utility::FloatToString($sumAmountin));
    $pdfTpl->assign('accountsAmountOut', Utility::FloatToString($sumAmountout));
    $pdfTpl->assign('accountsCount', \count($accounts));
    $pdfTpl->assign('accounts', $accounts);
}

$allocations = [];
if (Constants::BALANCES_OUT_LEVEL_ALLOC1 === $levelAlloc) {
    $allocations = $outputsHandler->getLevelAllocations($balIds);
}
if (Constants::BALANCES_OUT_LEVEL_ALLOC2 === $levelAlloc) {
    $allocations = $outputsHandler->getListAllocationsValues($balIds);
}

if ($levelAlloc > 0) {
    $sumTotal = 0;
    $sumAmountin = 0;
    $sumAmountout = 0;
    foreach ($allocations as $allocation) {
        $sumTotal += $allocation['total_val'];
        $sumAmountin += $allocation['amountin_val'];
        $sumAmountout += $allocation['amountout_val'];
    }
    $pdfTpl->assign('allocationsTotal', Utility::FloatToString($sumTotal));
    $pdfTpl->assign('allocationsAmountIn', Utility::FloatToString($sumAmountin));
    $pdfTpl->assign('allocationsAmountOut', Utility::FloatToString($sumAmountout));
    $pdfTpl->assign('allocationsCount', \count($allocations));
    $pdfTpl->assign('allocations', $allocations);
}

$myts = MyTextSanitizer::getInstance();

// Set defaults
$pdfFilename = \_MA_WGSIMPLEACC_PDF_BALNAME . '.pdf';
$title       = $GLOBALS['xoopsConfig']['sitename'];
$subject     = 'aaaa'._MA_WGSIMPLEACC_PDF_BALHEADER;
$content     = '';

$author = '';
if (isset($GLOBALS['xoopsUser']) && \is_object($GLOBALS['xoopsUser'])) {
    $author = \XoopsUser::getUnameFromId($GLOBALS['xoopsUser']->uid());
}

// Read data from table and create pdfData
//$pdfData['content']  = $myts->undoHtmlSpecialChars($content);
//$content = \strip_tags($transactionsObj->getVar('tra_desc'));
$pdfData['date']     = \formatTimestamp(time(), 's');
$pdfData['author']   = $author;
$pdfData['title']    = $title;
$pdfData['subject']   = $subject;
$pdfData['fontname'] = PDF_FONT_NAME_MAIN;
$pdfData['fontsize'] = PDF_FONT_SIZE_MAIN;

// Get Config
$pdfData['creator']   = $GLOBALS['xoopsConfig']['sitename'];
$pdfData['subject']   = $GLOBALS['xoopsConfig']['slogan'];
$pdfData['keywords']  = $helper->getConfig('keywords');

// Defines
\define('WGSIMPLEACC_CREATOR', $pdfData['creator']);
\define('WGSIMPLEACC_AUTHOR', $pdfData['author']);
\define('WGSIMPLEACC_HEADER_TITLE', $pdfData['title']);
\define('WGSIMPLEACC_HEADER_STRING', $pdfData['subject']);
\define('WGSIMPLEACC_HEADER_LOGO', 'logo.gif');
\define('WGSIMPLEACC_IMAGES_PATH', \XOOPS_ROOT_PATH.'/images/');

// Assign customs tpl fields
//$pdfTpl->assign('content_header', \str_replace(['%y', '%n'], [$transactionsObj->getVar('tra_year'), $transactionsObj->getVar('tra_nb')], \_MA_WGSIMPLEACC_PDF_TRAHEADER));
$logo = ['src' => WGSIMPLEACC_UPLOAD_IMAGES_URL . '/logoPdf.png', 'height' => '100px'];
$pdfTpl->assign('logo', $logo);
$pdfTpl->assign('header_title', \WGSIMPLEACC_HEADER_TITLE);
$pdfTpl->assign('header_string', \WGSIMPLEACC_HEADER_STRING);

// Create pdf
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, _CHARSET, false);
// Remove/add default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(true);
// Set document information
$pdf->SetCreator($pdfData['creator']);
$pdf->SetAuthor($pdfData['author']);
$pdf->SetTitle($pdfData['title']);
$pdf->SetKeywords($pdfData['keywords']);
// Set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, WGSIMPLEACC_HEADER_TITLE, WGSIMPLEACC_HEADER_STRING);
// Set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP + 10, PDF_MARGIN_RIGHT);
// Set auto page breaks
$pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO); //set image scale factor

// For chinese
if ('cn' == _LANGCODE) {
    $pdf->setHeaderFont(['gbsn00lp', '', $pdfData['fontsize']]);
    $pdf->SetFont('gbsn00lp', '', $pdfData['fontsize']);
    $pdf->setFooterFont(['gbsn00lp', '', $pdfData['fontsize']]);
} else {
    $pdf->setHeaderFont([PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN]);
    $pdf->SetFont($pdfData['fontname'], '', $pdfData['fontsize']);
    $pdf->setFooterFont([PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA]);
}
// Set some language-dependent strings (optional)
$lang = \XOOPS_ROOT_PATH.'/Frameworks/tcpdf/lang/eng.php';
if (@\file_exists($lang)) {
    require_once $lang;
    $pdf->setLanguageArray($lang);
}
// Add Page document
$pdf->AddPage('L');
// Output
$template_path = WGSIMPLEACC_PATH . '/templates/wgsimpleacc_balances_pdf.tpl';
$content = $pdfTpl->fetch($template_path);
//echo $content;die;
//$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $content, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=false);
$pdf->writeHTML($content, true, false, true, false, '');
$pdf->Output($pdfFilename, 'I');
