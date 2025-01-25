<?php

declare(strict_types=1);

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
 * @author         XOOPS Development Team - Email:<webmaster@wedega.com> - Website:<https://xoops.wedega.com>
 */

use Xmf\Request;
use XoopsModules\Wgsimpleacc;
use XoopsModules\Wgsimpleacc\Constants;
use XoopsModules\Wgsimpleacc\Common;

require __DIR__ . '/header.php';
// It recovered the value of argument op in URL$
$op = Request::getCmd('op', 'list');
// Request pro_id
$proId = Request::getInt('pro_id');
switch ($op) {
    case 'list':
    default:
        // Define Stylesheet
        $GLOBALS['xoTheme']->addStylesheet($style, null);
        $start = Request::getInt('start');
        $limit = Request::getInt('limit', $helper->getConfig('adminpager'));
        $templateMain = 'wgsimpleacc_admin_processing.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('processing.php'));
        $adminObject->addItemButton(\_AM_WGSIMPLEACC_ADD_PROCESSING, 'processing.php?op=new');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        $processingCount = $processingHandler->getCountProcessing();
        $processingAll = $processingHandler->getAllProcessing($start, $limit);
        $GLOBALS['xoopsTpl']->assign('processing_count', $processingCount);
        $GLOBALS['xoopsTpl']->assign('wgsimpleacc_url', \WGSIMPLEACC_URL);
        $GLOBALS['xoopsTpl']->assign('wgsimpleacc_upload_url', \WGSIMPLEACC_UPLOAD_URL);
        $GLOBALS['xoopsTpl']->assign('wgsimpleacc_icon_url', \WGSIMPLEACC_ICONS_URL);
        // Table view processing
        if ($processingCount > 0) {
            foreach (\array_keys($processingAll) as $i) {
                $processing = $processingAll[$i]->getValuesprocessing();
                $GLOBALS['xoopsTpl']->append('processing_list', $processing);
                unset($processing);
            }
            // Display Navigation
            if ($processingCount > $limit) {
                include_once \XOOPS_ROOT_PATH . '/class/pagenav.php';
                $pagenav = new \XoopsPageNav($processingCount, $limit, $start, 'start', 'op=list&limit=' . $limit);
                $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav());
            }
        } else {
            $GLOBALS['xoopsTpl']->assign('error', \_MA_WGSIMPLEACC_THEREARENT_PROCESSING);
        }
        break;
    case 'new':
        $templateMain = 'wgsimpleacc_admin_processing.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('processing.php'));
        $adminObject->addItemButton(\_AM_WGSIMPLEACC_LIST_PROCESSING, 'processing.php', 'list');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        // Form Create
        $processingObj = $processingHandler->create();
        $form = $processingObj->getFormprocessing();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'save':
        // Security Check
        if (!$GLOBALS['xoopsSecurity']->check()) {
            \redirect_header('processing.php', 3, \implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        if ($proId > 0) {
            $processingObj = $processingHandler->get($proId);
        } else {
            $processingObj = $processingHandler->create();
        }
        // Set Vars
        $processingObj->setVar('pro_text', Request::getString('pro_text'));
        $processingObj->setVar('pro_income', Request::getInt('pro_income'));
        $processingObj->setVar('pro_expenses', Request::getInt('pro_expenses'));
        $processingObj->setVar('pro_weight', Request::getInt('pro_weight'));
        $processingObj->setVar('pro_online', Request::getInt('pro_online'));
        $processingObj->setVar('pro_default', Request::getInt('pro_default'));
        $processingDatecreatedObj = \DateTime::createFromFormat(_SHORTDATESTRING, Request::getString('pro_datecreated'));
        $processingObj->setVar('pro_datecreated', $processingDatecreatedObj->getTimestamp());
        $processingObj->setVar('pro_submitter', Request::getInt('pro_submitter'));
        // Insert Data
        if ($processingHandler->insert($processingObj)) {
            \redirect_header('processing.php?op=list', 2, \_MA_WGSIMPLEACC_FORM_OK);
        }
        // Get Form
        $GLOBALS['xoopsTpl']->assign('error', $processingObj->getHtmlErrors());
        $form = $processingObj->getFormProcessing();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'edit':
        $templateMain = 'wgsimpleacc_admin_processing.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('processing.php'));
        $adminObject->addItemButton(\_AM_WGSIMPLEACC_ADD_PROCESSING, 'processing.php?op=new');
        $adminObject->addItemButton(\_AM_WGSIMPLEACC_LIST_PROCESSING, 'processing.php', 'list');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        // Get Form
        $processingObj = $processingHandler->get($proId);
        $form = $processingObj->getFormProcessing();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'delete':
        $templateMain = 'wgsimpleacc_admin_processing.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('processing.php'));
        $processingObj = $processingHandler->get($proId);
        $cliName = $processingObj->getVar('cli_name');
        if (isset($_REQUEST['ok']) && 1 == $_REQUEST['ok']) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                \redirect_header('processing.php', 3, \implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            if ($processingHandler->delete($processingObj)) {
                \redirect_header('processing.php', 3, \_MA_WGSIMPLEACC_FORM_DELETE_OK);
            } else {
                $GLOBALS['xoopsTpl']->assign('error', $processingObj->getHtmlErrors());
            }
        } else {
            $customConfirm = new Common\Confirm(
                ['ok' => 1, 'pro_id' => $proId, 'op' => 'delete'],
                $_SERVER['REQUEST_URI'],
                \sprintf(\_MA_WGSIMPLEACC_FORM_SURE_DELETE, $processingObj->getVar('pro_text')), _MA_WGSIMPLEACC_FORM_DELETE_CONFIRM, _MA_WGSIMPLEACC_FORM_DELETE_LABEL);
            $form = $customConfirm->getFormConfirm();
            $GLOBALS['xoopsTpl']->assign('form', $form->render());
        }
        break;
    case 'set_onoff':
        $paramOnoff = Request::getString('param_onoff', 'none');
        $processingObj = $processingHandler->get($proId);
        $valOld = (int)$processingObj->getVar('pro_' . $paramOnoff);
        if (1 === $valOld) {
            $processingObj->setVar('pro_' . $paramOnoff, 0);
        } else {
            $processingObj->setVar('pro_' . $paramOnoff, 1);
        }
        // Insert Data
        if ($processingHandler->insert($processingObj)) {
            \redirect_header('processing.php?op=list', 2, \_MA_WGSIMPLEACC_FORM_OK);
        } else {
            \redirect_header('processing.php?op=list', 2, \_MA_WGSIMPLEACC_ERROR_SAVE);
        }
        break;
}
require __DIR__ . '/footer.php';
