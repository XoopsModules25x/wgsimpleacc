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
use XoopsModules\Wgsimpleacc\Constants;

require __DIR__ . '/header.php';
require_once \XOOPS_ROOT_PATH . '/header.php';
if (\file_exists($tcpdf = \XOOPS_ROOT_PATH.'/Frameworks/tcpdf/')) {
    require_once $tcpdf . 'tcpdf.php';
} else {
    \redirect_header('transactions.php', 2, \_MA_WGSIMPLEACC_NO_PDF_LIBRARY);
}
require_once $tcpdf . 'config/tcpdf_config.php';
// Get new template
require_once \XOOPS_ROOT_PATH . '/class/template.php';
$pdfTpl = new $xoopsTpl();

// Get requests
$traId = Request::getInt('tra_id');
// Get Instance of Handler
$transactionsHandler = $helper->getHandler('Transactions');
$transactionsObj = $transactionsHandler->get($traId);

$myts = MyTextSanitizer::getInstance();

// Set defaults
$pdfFilename = \str_replace(['%y', '%n'], [$transactionsObj->getVar('tra_year'), $transactionsObj->getVar('tra_nb')], \_MA_WGSIMPLEACC_PDF_NAME) . '.pdf';
$title       = $GLOBALS['xoopsConfig']['sitename'];
$subject     = 'Pdf Subject';
$content     = '';

// Read data from table and create pdfData
$content = \strip_tags($transactionsObj->getVar('tra_desc'));
$pdfData['date']     = \formatTimestamp($transactionsObj->getVar('tra_date'), 's');
$pdfData['author']   = \XoopsUser::getUnameFromId($transactionsObj->getVar('tra_submitter'));
$pdfData['title']    = \strip_tags($myts->undoHtmlSpecialChars($title));
$pdfData['content']  = $myts->undoHtmlSpecialChars($content);
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

$pdfTpl->assign('content_header', \str_replace(['%y', '%n'], [$transactionsObj->getVar('tra_year'), $transactionsObj->getVar('tra_nb')], \_MA_WGSIMPLEACC_PDF_HEADER));
$transaction = $transactionsObj->getValuesTransactions();
$pdfTpl->assign('transaction', $transaction);
$pdfTpl->assign('logo', $transaction);
$pdfTpl->assign('useCurrencies', $helper->getConfig('use_currencies'));
$pdfTpl->assign('useTaxes', $helper->getConfig('use_taxes'));
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
$pdf->SetTitle($title);
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
$pdf->AddPage();
// Output
$template_path = WGSIMPLEACC_PATH . '/templates/wgsimpleacc_transactions_pdf.tpl';
$content = $pdfTpl->fetch($template_path);
//echo $content;die;
//$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $content, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=false);
$pdf->writeHTML($content, true, false, true, false, '');
$pdf->Output($pdfFilename, 'I');

