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
    Common,
    Utility
};

require __DIR__ . '/header.php';
// It recovered the value of argument op in URL$
$op = Request::getCmd('op', 'list');
// Request as_id
$asId = Request::getInt('as_id');
switch ($op) {
    case 'list':
    default:
        // Define Stylesheet
        $GLOBALS['xoTheme']->addStylesheet($style, null);
        $start = Request::getInt('start', 0);
        $limit = Request::getInt('limit', $helper->getConfig('adminpager'));
        $templateMain = 'wgsimpleacc_admin_assets.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('assets.php'));
        $adminObject->addItemButton(\_AM_WGSIMPLEACC_ADD_ASSET, 'assets.php?op=new', 'add');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        $assetsCount = $assetsHandler->getCountAssets();
        $assetsAll = $assetsHandler->getAllAssets($start, $limit);
        $GLOBALS['xoopsTpl']->assign('assets_count', $assetsCount);
        $GLOBALS['xoopsTpl']->assign('wgsimpleacc_url', \WGSIMPLEACC_URL);
        $GLOBALS['xoopsTpl']->assign('wgsimpleacc_upload_url', \WGSIMPLEACC_UPLOAD_URL);
        // Table view assets
        if ($assetsCount > 0) {
            foreach (\array_keys($assetsAll) as $i) {
                $asset = $assetsAll[$i]->getValuesAssets();
                $GLOBALS['xoopsTpl']->append('assets_list', $asset);
                unset($asset);
            }
            // Display Navigation
            if ($assetsCount > $limit) {
                require_once \XOOPS_ROOT_PATH . '/class/pagenav.php';
                $pagenav = new \XoopsPageNav($assetsCount, $limit, $start, 'start', 'op=list&limit=' . $limit);
                $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
            }
        } else {
            $GLOBALS['xoopsTpl']->assign('error', \_MA_WGSIMPLEACC_THEREARENT_ASSETS);
        }

        $GLOBALS['xoopsTpl']->assign('colors', Utility::getColors());
        break;
    case 'new':
        $templateMain = 'wgsimpleacc_admin_assets.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('assets.php'));
        $adminObject->addItemButton(\_AM_WGSIMPLEACC_LIST_ASSETS, 'assets.php', 'list');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        // Form Create
        $assetsObj = $assetsHandler->create();
        $form = $assetsObj->getFormAssets(false, true);
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'save':
        // Security Check
        if (!$GLOBALS['xoopsSecurity']->check()) {
            \redirect_header('assets.php', 3, \implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        if ($asId > 0) {
            $assetsObj = $assetsHandler->get($asId);
        } else {
            $assetsObj = $assetsHandler->create();
        }
        // Set Vars
        $assetsObj->setVar('as_name', Request::getString('as_name', ''));
        $assetsObj->setVar('as_descr', Request::getString('as_descr', ''));
        $assetsObj->setVar('as_reference', Request::getString('as_reference', ''));
        $assetsObj->setVar('as_color', Request::getString('as_color', ''));
        $assetsObj->setVar('as_iecalc', Request::getInt('as_iecalc', 0));
        $assetsObj->setVar('as_online', Request::getInt('as_online', 0));
        $assetDatecreatedObj = \DateTime::createFromFormat(_SHORTDATESTRING, Request::getString('as_datecreated'));
        $assetsObj->setVar('as_datecreated', $assetDatecreatedObj->getTimestamp());
        $assetsObj->setVar('as_submitter', Request::getInt('as_submitter', 0));
        // Insert Data
        if ($assetsHandler->insert($assetsObj)) {
            if (Request::getInt('as_primary', 0) > 0) {
                $newAsId = $assetsObj->getNewInsertedIdAssets();
                $asId = $asId > 0 ? $asId : $newAsId;
                $assetsHandler->setPrimaryAssets($asId);
            }
            \redirect_header('assets.php?op=list', 2, \_MA_WGSIMPLEACC_FORM_OK);
        }
        // Get Form
        $GLOBALS['xoopsTpl']->assign('error', $assetsObj->getHtmlErrors());
        $form = $assetsObj->getFormAssets();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'savecolor':
        if ($asId > 0) {
            $assetsObj = $assetsHandler->get($asId);
        } else {
            \redirect_header('assets.php', 3, \_MA_WGSIMPLEACC_INVALID_PARAM);
        }
        // Set Vars
        $assetsObj->setVar('as_color', '#' . Request::getString('as_color', ''));
        // Insert Data
        if ($assetsHandler->insert($assetsObj)) {
            \redirect_header('assets.php?op=list', 2, \_MA_WGSIMPLEACC_FORM_OK);
        }
        break;
    case 'edit':
        $templateMain = 'wgsimpleacc_admin_assets.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('assets.php'));
        $adminObject->addItemButton(\_AM_WGSIMPLEACC_ADD_ASSET, 'assets.php?op=new', 'add');
        $adminObject->addItemButton(\_AM_WGSIMPLEACC_LIST_ASSETS, 'assets.php', 'list');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        // Get Form
        $assetsObj = $assetsHandler->get($asId);
        $form = $assetsObj->getFormAssets(false, true);
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'delete':
        $templateMain = 'wgsimpleacc_admin_assets.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('assets.php'));
        $assetsObj = $assetsHandler->get($asId);
        $asName = $assetsObj->getVar('as_name');
        if (isset($_REQUEST['ok']) && 1 == $_REQUEST['ok']) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                \redirect_header('assets.php', 3, \implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            if ($assetsHandler->delete($assetsObj)) {
                \redirect_header('assets.php', 3, \_MA_WGSIMPLEACC_FORM_DELETE_OK);
            } else {
                $GLOBALS['xoopsTpl']->assign('error', $assetsObj->getHtmlErrors());
            }
        } else {
            $xoopsconfirm = new Common\XoopsConfirm(
                ['ok' => 1, 'as_id' => $asId, 'op' => 'delete'],
                $_SERVER['REQUEST_URI'],
                \sprintf(\_MA_WGSIMPLEACC_FORM_SURE_DELETE, $assetsObj->getVar('as_name')));
            $form = $xoopsconfirm->getFormXoopsConfirm();
            $GLOBALS['xoopsTpl']->assign('form', $form->render());
        }
        break;
}
require __DIR__ . '/footer.php';
