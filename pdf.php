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
 * @author         XOOPS Development Team - Email:<webmaster@wedega.com> - Website:<https://xoops.wedega.com>
 */

use Xmf\Request;
use XoopsModules\Wgsimpleacc;
use XoopsModules\Wgsimpleacc\Constants;

require __DIR__ . '/header.php';
$imgId = Request::getInt('img_id');
if (\file_exists($tcpdf = \XOOPS_ROOT_PATH.'/Frameworks/tcpdf/tcpdf.php')) {
	require_once $tcpdf;
} else {
	\redirect_header('images.php', 2, \_MA_WGSIMPLEACC_NO_PDF_LIBRARY);
}
// Get Instance of Handler
$imagesHandler = $helper->getHandler('Images');

$pdfData['content'] = \strip_tags($imagesHandler->getVar('img_desc'));
$pdfData['date']    = \formatTimestamp($imagesHandler->getVar('img_datecreated'), 's');
$pdfData['author']  = \XoopsUser::getUnameFromId($imagesHandler->getVar('img_submitter'));

// Get Config
$pdfData['creator']   = $GLOBALS['xoopsConfig']['xoops_sitename'];
$pdfData['subject']   = $GLOBALS['xoopsConfig']['slogan'];
$pdfData['keywords']  = $GLOBALS['xoopsConfig']['keywords'];
// Defines
\define('WGSIMPLEACC_CREATOR', $pdfData['creator']);
\define('WGSIMPLEACC_AUTHOR', $pdfData['author']);
\define('WGSIMPLEACC_HEADER_TITLE', $pdfData['title']);
\define('WGSIMPLEACC_HEADER_STRING', $pdfData['subject']);
\define('WGSIMPLEACC_HEADER_LOGO', 'logo.gif');
\define('WGSIMPLEACC_IMAGES_PATH', \XOOPS_ROOT_PATH.'/images/');
$myts = MyTextSanitizer::getInstance();
$content = '';
$content .= $myts->undoHtmlSpecialChars($pdfData['content']);
$content = $myts->displayTarea($content);
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, _CHARSET, false);
$title = $myts->undoHtmlSpecialChars($pdfData['title']);
$keywords = $myts->undoHtmlSpecialChars($pdfData['keywords']);
$pdfData['fontsize'] = 12;
// For schinese
if ('cn' == _LANGCODE) {
	$pdf->SetFont('gbsn00lp', '', $pdfData['fontsize']);
} else {
	$pdf->SetFont($pdfData['fontname'], '', $pdfData['fontsize']);
}
// Set document information
$pdf->SetCreator($pdfData['creator']);
$pdf->SetAuthor($pdfData['author']);
$pdf->SetTitle($title);
$pdf->SetKeywords($keywords);
// Set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, WGSIMPLEACC_HEADER_TITLE, WGSIMPLEACC_HEADER_STRING);
// Set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP + 10, PDF_MARGIN_RIGHT);
// Set auto page breaks
$pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO); //set image scale factor
if ('cn' == _LANGCODE) {
	$pdf->setHeaderFont(array('gbsn00lp', '', $pdfData['fontsize']));
	$pdf->setFooterFont(array('gbsn00lp', '', $pdfData['fontsize']));
} else {
	$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
	$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
}
// Set some language-dependent strings (optional)
$lang = \XOOPS_ROOT_PATH.'/Frameworks/tcpdf/lang/eng.php';
if (@\file_exists($lang)) {
	require_once $lang;
	$pdf->setLanguageArray($lang);
}
// Initialize document
$pdf->AliasNbPages();
// Add Page document
$pdf->AddPage();
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $content, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
// Pdf Filename
// Output
$GLOBALS['xoopsTpl']->assign('pdfoutput', $pdf->Output('images.pdf', 'I'));
$GLOBALS['xoopsTpl']->display('db:wgsimpleacc_pdf.tpl');
