<?php

/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

use XoopsModules\Wgsimpleacc\Helper;

/**
 * wgSimpleAcc module for xoops
 *
 * @copyright      2020 XOOPS Project (https://xooops.org)
 * @license        GPL 2.0 or later
 * @package        wgsimpleacc
 * @since          1.0
 * @min_xoops      2.5.10
 * @author         Goffy - XOOPS Development Team - Email:<webmaster@wedega.com> - Website:<https://xoops.wedega.com>
 * @param $template
 * @param $outParams
 * @return string
 */

/**
 * function to execute output
 * @param $template
 * @param $outParams
 * @return string
 */

if (\file_exists($tcpdf = \XOOPS_ROOT_PATH . '/Frameworks/tcpdf/')) {
    require_once $tcpdf . 'tcpdf.php';
} else {
    \redirect_header('transactions.php', 2, \_MA_WGSIMPLEACC_NO_PDF_LIBRARY);
}

// Permissions
if (!$permissionsHandler->getPermOuttemplatesView()) {
    \redirect_header('index.php', 0);
}

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

    /**
     * @var mixed
     */
    public $htmlHeader = '';

    /**
     * @var mixed
     */
    public $htmlFooter = '';

    //Page header
    public function Header() {
        //add my custom header
        $this->writeHTMLCell(0, 0, '', '', $this->htmlHeader, 0, 1, 0, true, 'top', true);
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        //add my custom footer
        $this->MultiCell(0,0, $this->htmlFooter,0,'J', false, 1, '', '', true, 0, true);
    }
}

function execute_output ($template, $outParams)
{
    $helper = \XoopsModules\Wgsimpleacc\Helper::getInstance();

    if (\file_exists($tcpdf = \XOOPS_ROOT_PATH . '/Frameworks/tcpdf/')) {
        require_once $tcpdf . 'tcpdf.php';
    } else {
        \redirect_header('transactions.php', 2, \_MA_WGSIMPLEACC_NO_PDF_LIBRARY);
    }
    require_once $tcpdf . 'config/tcpdf_config.php';

    $myts = MyTextSanitizer::getInstance();

    // Set defaults
    $pdfFilename = $outParams['file_name'];
    $title = $GLOBALS['xoopsConfig']['sitename'];
    //$subject = 'Pdf Subject';

    // Read data from table and create pdfData
    $pdfData['date'] = $outParams['date'];
    $pdfData['author'] = $outParams['submitter'];
    $pdfData['title'] = \strip_tags($myts->undoHtmlSpecialChars($title));
    $pdfData['content'] = $myts->undoHtmlSpecialChars($template['body']);
    $pdfData['fontname'] = PDF_FONT_NAME_MAIN;
    $pdfData['fontsize'] = PDF_FONT_SIZE_MAIN;

    // Get Config
    $pdfData['creator'] = $GLOBALS['xoopsConfig']['sitename'];
    $pdfData['subject'] = $GLOBALS['xoopsConfig']['slogan'];
    $pdfData['keywords'] = $helper->getConfig('keywords');

    // Defines
    \define('WGSIMPLEACC_CREATOR', $pdfData['creator']);
    \define('WGSIMPLEACC_AUTHOR', $pdfData['author']);
    \define('WGSIMPLEACC_HEADER_TITLE', '');
    \define('WGSIMPLEACC_HEADER_STRING', '');
    \define('WGSIMPLEACC_HEADER_LOGO', '');
    \define('WGSIMPLEACC_IMAGES_PATH', '');

    // Create pdf
    $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, _CHARSET, false);
    // Remove/add default header/footer
    $pdf->htmlHeader = $template['header'];
    $pdf->htmlFooter = $template['footer'];
    $pdf->setPrintHeader(true);
    $pdf->setPrintFooter(true);
    // Set document information
    $pdf->SetCreator($pdfData['creator']);
    $pdf->SetAuthor($pdfData['author']);
    $pdf->SetTitle($title);
    $pdf->SetKeywords($pdfData['keywords']);
    // Set default header data
    $pdf->setHeaderData('', PDF_HEADER_LOGO_WIDTH, WGSIMPLEACC_HEADER_TITLE, WGSIMPLEACC_HEADER_STRING);
    // Set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP + 10, PDF_MARGIN_RIGHT);
    // Set auto page breaks
    $pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);
    $pdf->setHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->setFooterMargin(PDF_MARGIN_FOOTER);
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
    $lang = \XOOPS_ROOT_PATH . '/Frameworks/tcpdf/lang/eng.php';
    if (@\is_file($lang)) {
        require_once $lang;
        $pdf->setLanguageArray($lang);
    }
    // Add Page document
    $pdf->AddPage();
    // Output
    $pdf->writeHTML($pdfData['content'], true, false, true, false, '');

    if ($outParams['auto_add']) {
        // create file in temp folder for adding automatically to transaction
        $pdf->Output($outParams['file_temp'], 'F');
    }

    return $pdf->Output($pdfFilename, 'D');
}
