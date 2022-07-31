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
use XoopsModules\Wgsimpleacc\Common;

require __DIR__ . '/header.php';
require_once \XOOPS_ROOT_PATH . '/header.php';
$GLOBALS['xoopsTpl']->assign('template_sub', 'db:wgsimpleacc_outtemplates.tpl');
require __DIR__ . '/navbar.php';

// Permissions
if (!$permissionsHandler->getPermOuttemplatesView()) {
    \redirect_header('index.php', 0);
}

$op    = Request::getCmd('op', 'list');
$start = Request::getInt('start');
$limit = Request::getInt('limit', $helper->getConfig('userpager'));
$otplId = Request::getInt('otpl_id');
$traId  = Request::getInt('tra_id');

$GLOBALS['xoopsTpl']->assign('xoops_icons32_url', \XOOPS_ICONS32_URL);
$GLOBALS['xoopsTpl']->assign('wgsimpleacc_url', \WGSIMPLEACC_URL);
$GLOBALS['xoopsTpl']->assign('wgsimpleacc_icons_url_32', \WGSIMPLEACC_ICONS_URL . '/32/');
$GLOBALS['xoopsTpl']->assign('showItem', $otplId > 0);
$permSubmitOTpl = $permissionsHandler->getPermOuttemplatesSubmit();
$permSubmitTra = $permissionsHandler->getPermTransactionsSubmit();
$GLOBALS['xoopsTpl']->assign('permSubmit', $permSubmitOTpl);

$keywords = [];

$useFooter = true;

switch ($op) {
    case 'show':
    case 'list':
    default:
        $GLOBALS['xoopsTpl']->assign('showList', true);
        $crOuttemplates = new \CriteriaCompo();
        if ($otplId > 0) {
            $crOuttemplates->add(new \Criteria('otpl_id', $otplId));
        }
        $outtemplatesCount = $outtemplatesHandler->getCount($crOuttemplates);
        $GLOBALS['xoopsTpl']->assign('outtemplatesCount', $outtemplatesCount);
        $crOuttemplates->setStart($start);
        $crOuttemplates->setLimit($limit);
        $outtemplatesAll = $outtemplatesHandler->getAll($crOuttemplates);
        if ($outtemplatesCount > 0) {
            $outtemplates = [];
            // Get All Outtemplates
            foreach (\array_keys($outtemplatesAll) as $i) {
                $outtemplates[$i] = $outtemplatesAll[$i]->getValuesOuttemplates();
                $outtemplates[$i]['edit'] = $permissionsHandler->getPermOuttemplatesEdit($outtemplates[$i]['otpl_submitter']);
                $keywords[$i] = $outtemplatesAll[$i]->getVar('otpl_name');
            }
            $GLOBALS['xoopsTpl']->assign('outtemplates', $outtemplates);
            unset($outtemplates);
            // Display Navigation
            if ($outtemplatesCount > $limit) {
                include_once \XOOPS_ROOT_PATH . '/class/pagenav.php';
                $pagenav = new \XoopsPageNav($outtemplatesCount, $limit, $start, 'start', 'op=list&limit=' . $limit);
                $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav());
            }
        }
        $GLOBALS['xoopsTpl']->assign('table_type', $helper->getConfig('table_type'));
        // Breadcrumbs
        $xoBreadcrumbs[] = ['title' => \_MA_WGSIMPLEACC_OUTTEMPLATES];
        break;
    case 'save':
        // Security Check
        if (!$GLOBALS['xoopsSecurity']->check()) {
            \redirect_header('outtemplates.php', 3, \implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        if ($otplId > 0) {
            $outtemplatesObj = $outtemplatesHandler->get($otplId);
            // Check permissions
            if (!$permissionsHandler->getPermOuttemplatesSubmit($outtemplatesObj->getVar('otpl_submitter'))) {
                \redirect_header('outtemplates.php?op=list', 3, \_NOPERM);
            }
        } else {
            // Check permissions
            if (!$permSubmitOTpl) {
                \redirect_header('outtemplates.php?op=list', 3, \_NOPERM);
            }
            $outtemplatesObj = $outtemplatesHandler->create();
        }
        $outtemplatesObj->setVar('otpl_name', Request::getString('otpl_name'));
        $outtemplatesObj->setVar('otpl_type', Request::getInt('otpl_type'));
        $outtemplatesObj->setVar('otpl_header', Request::getText('otpl_header'));
        $outtemplatesObj->setVar('otpl_body', Request::getText('otpl_body'));
        $outtemplatesObj->setVar('otpl_footer', Request::getText('otpl_footer'));
        $arrAllid = Request::getArray('otpl_allid');
        if (0 == (int)$arrAllid[0]) {
            $otpl_allid = serialize([0]);
        } else {
            $otpl_allid = serialize($arrAllid);
        }
        $outtemplatesObj->setVar('otpl_allid', $otpl_allid);
        $arrAccid = Request::getArray('otpl_accid');
        if (0 == (int)$arrAccid[0]) {
            $otpl_accid = serialize([0]);
        } else {
            $otpl_accid = serialize($arrAccid);
        }
        $outtemplatesObj->setVar('otpl_accid', $otpl_accid);
        $outtemplatesObj->setVar('otpl_online', Request::getInt('otpl_online'));
        $outtemplateDatecreatedObj = \DateTime::createFromFormat(_SHORTDATESTRING, Request::getString('otpl_datecreated'));
        $outtemplatesObj->setVar('otpl_datecreated', $outtemplateDatecreatedObj->getTimestamp());
        $outtemplatesObj->setVar('otpl_submitter', Request::getInt('otpl_submitter'));
        // Insert Data
        if ($outtemplatesHandler->insert($outtemplatesObj)) {
            // redirect after insert
            \redirect_header('outtemplates.php', 2, \_MA_WGSIMPLEACC_FORM_OK);
        }
        // Get Form Error
        $GLOBALS['xoopsTpl']->assign('error', $outtemplatesObj->getHtmlErrors());
        $form = $outtemplatesObj->getFormOuttemplates();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'new':
        // Check permissions
        if (!$permSubmitOTpl) {
            \redirect_header('outtemplates.php?op=list', 3, \_NOPERM);
        }
        // Form Create
        $outtemplatesObj = $outtemplatesHandler->create();
        $form = $outtemplatesObj->getFormOuttemplates();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());

        // Breadcrumbs
        $xoBreadcrumbs[] = ['title' => \_MA_WGSIMPLEACC_OUTTEMPLATES, 'link' => 'outtemplates.php?op=list'];
        $xoBreadcrumbs[] = ['title' => \_MA_WGSIMPLEACC_OUTTEMPLATE_ADD];
        break;
    case 'edit':
        // Check params
        if (0 == $otplId) {
            \redirect_header('outtemplates.php?op=list', 3, \_MA_WGSIMPLEACC_INVALID_PARAM);
        }
        // Get Form
        $outtemplatesObj = $outtemplatesHandler->get($otplId);
        // Check permissions
        if (!$permissionsHandler->getPermOuttemplatesSubmit($outtemplatesObj->getVar('otpl_submitter'))) {
            \redirect_header('outtemplates.php?op=list', 3, \_NOPERM);
        }
        $form = $outtemplatesObj->getFormOuttemplates();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());

        // Breadcrumbs
        $xoBreadcrumbs[] = ['title' => \_MA_WGSIMPLEACC_OUTTEMPLATES, 'link' => 'outtemplates.php?op=list'];
        $xoBreadcrumbs[] = ['title' => \_MA_WGSIMPLEACC_OUTTEMPLATE_EDIT];
        break;
    case 'delete':
        // Check permissions
        if (!$permSubmitOTpl) {
            \redirect_header('outtemplates.php?op=list', 3, \_NOPERM);
        }
        // Check params
        if (0 == $otplId) {
            \redirect_header('outtemplates.php?op=list', 3, \_MA_WGSIMPLEACC_INVALID_PARAM);
        }
        $outtemplatesObj = $outtemplatesHandler->get($otplId);
        $otplName = $outtemplatesObj->getVar('otpl_name');
        if (isset($_REQUEST['ok']) && 1 == $_REQUEST['ok']) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                \redirect_header('outtemplates.php', 3, \implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            if ($outtemplatesHandler->delete($outtemplatesObj)) {
                \redirect_header('outtemplates.php', 3, \_MA_WGSIMPLEACC_FORM_DELETE_OK);
            } else {
                $GLOBALS['xoopsTpl']->assign('error', $outtemplatesObj->getHtmlErrors());
            }
        } else {
            $customConfirm = new Common\Confirm(
                ['ok' => 1, 'otpl_id' => $otplId, 'op' => 'delete'],
                $_SERVER['REQUEST_URI'],
                \sprintf(\_MA_WGSIMPLEACC_FORM_SURE_DELETE, $outtemplatesObj->getVar('otpl_name')));
            $form = $customConfirm->getFormConfirm();
            $GLOBALS['xoopsTpl']->assign('form', $form->render());

            // Breadcrumbs
            $xoBreadcrumbs[] = ['title' => \_MA_WGSIMPLEACC_OUTTEMPLATES, 'link' => 'outtemplates.php?op=list'];
            $xoBreadcrumbs[] = ['title' => \_MA_WGSIMPLEACC_OUTTEMPLATE_EDIT];
        }
        break;
/*
    case 'editpdf':
        // Check permissions
        if (!$permSubmitOTpl) {
            \redirect_header('outtemplates.php?op=list', 3, \_NOPERM);
        }
        // Form Create
        $form = $outtemplatesHandler::getFormEditTraOutput($otplId);
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
        */
    case 'exec_output':
        if (Request::hasVar('back')) {
            \redirect_header('transactions.php?op=list', 0);
        }
        // Check permissions
        if (!$permSubmitTra) {
            \redirect_header('outtemplates.php?op=list', 3, \_NOPERM);
        }
        $outParams = [];
        $template  = [];
        $outTarget = Request::getString('target');

        $outParams = $outtemplatesHandler->getOutParams($traId);
        $outParams['otpl_id']  = $otplId;
        $outParams['auto_add'] = Request::getBool('auto_add');

        if ('form_browser' == $outTarget || 'form_pdf' == $outTarget) {
            //data from form
            $template['header'] = Request::getText('otpl_header');
            $template['body'] = Request::getText('otpl_body');
            $template['footer'] = Request::getText('otpl_footer');
        } else {
            $template = $outtemplatesHandler::getFetchedOutput($outParams);
        }

        switch ($outTarget) {
            case 'browser':
            case 'form_browser':
            default:
                $GLOBALS['xoopsTpl']->assign('outputText', $template['header'] . $template['body'] . $template['footer']);
                break;
            case 'editoutput':
                // Form Create
                $form = $outtemplatesHandler::getFormEditTraOutput($template);
                $GLOBALS['xoopsTpl']->assign('form', $form->render());
                break;
            case 'pdf':
            case 'form_pdf':
                $useFooter = false;
                require_once __DIR__ . '/outtemplates_pdf.php';

                $filePdf = \str_replace(['%y', '%n'], [$outParams['tra_year'], $outParams['tra_nb']], \_MA_WGSIMPLEACC_PDF_TRANAME);
                $filePdf = $filePdf . '_' . time() . '.pdf';

                $outParams['file_name'] = $filePdf;
                if ($outParams['auto_add']) {
                    $tempPdf = \WGSIMPLEACC_UPLOAD_TEMP_PATH. '/' . $filePdf;
                    $outParams['file_temp'] = $tempPdf;
                    // delete if exists
                    if (\file_exists($tempPdf)) {
                        \unlink($tempPdf);
                    }
                }

                $result = execute_output($template, $outParams);
                if ($outParams['auto_add']) {
                    // move file to final destination
                    $filDest = \WGSIMPLEACC_UPLOAD_FILES_PATH . '/' . $filePdf;
                    \rename($tempPdf, $filDest);

                    // create file
                    $filesObj = $filesHandler->create();
                    $fileMimetype   = \mime_content_type($filDest);
                    $filesObj->setVar('fil_traid', $traId);
                    $filesObj->setVar('fil_name', $filePdf);
                    $filesObj->setVar('fil_type', $fileMimetype);
                    $filesObj->setVar('fil_desc', '');
                    $filesObj->setVar('fil_ip', $_SERVER['REMOTE_ADDR']);
                    $filesObj->setVar('fil_datecreated', \time());
                    $filesObj->setVar('fil_submitter', $GLOBALS['xoopsUser']->id());
                    // Insert Data
                    $filesHandler->insert($filesObj);
                }
                //\redirect_header('transactions.php?op=list&amp;filePdf=' . $filePdf, 3, \_MA_WGSIMPLEACC_OUTTEMPLATE_PDF_SUCCESS);
                break;
        }
        break;
}

// Keywords
wgsimpleaccMetaKeywords($helper->getConfig('keywords') . ', ' . \implode(',', $keywords));
unset($keywords);

$GLOBALS['xoopsTpl']->assign('xoops_mpageurl', \WGSIMPLEACC_URL . '/outtemplates.php');
$GLOBALS['xoopsTpl']->assign('wgsimpleacc_upload_url', \WGSIMPLEACC_UPLOAD_URL);

if ($useFooter) {
    require __DIR__ . '/footer.php';
}
