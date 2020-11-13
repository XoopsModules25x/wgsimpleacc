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
    Utility,
    Common
};

require __DIR__ . '/header.php';
$GLOBALS['xoopsOption']['template_main'] = 'wgsimpleacc_main_startmin.tpl';
require_once \XOOPS_ROOT_PATH . '/header.php';
$GLOBALS['xoopsTpl']->assign('template_sub', 'db:wgsimpleacc_assets.tpl');
require __DIR__ . '/navbar.php';

// Permissions
if (!$permissionsHandler->getPermGlobalView()) {
    $GLOBALS['xoopsTpl']->assign('error', _NOPERM);
    require __DIR__ . '/footer.php';
}

$op    = Request::getCmd('op', 'list');
$start = Request::getInt('start', 0);
$limit = Request::getInt('limit', $helper->getConfig('userpager'));
$asId = Request::getInt('as_id', 0);

// Define Stylesheet
$GLOBALS['xoTheme']->addStylesheet($style, null);
$GLOBALS['xoopsTpl']->assign('wgsimpleacc_icon_url_16', WGSIMPLEACC_ICONS_URL . '/16/');
$GLOBALS['xoopsTpl']->assign('xoops_icons32_url', XOOPS_ICONS32_URL);
$GLOBALS['xoopsTpl']->assign('wgsimpleacc_url', WGSIMPLEACC_URL);

$keywords = [];

$GLOBALS['xoopsTpl']->assign('showItem', $asId > 0);

$permSubmit = $permissionsHandler->getPermAssetsSubmit();
$assetsCount = $assetsHandler->getCount();
$crAssets = new \CriteriaCompo();
if ($asId > 0) {
    $crAssets->add(new \Criteria('as_id', $asId));
}
$crAssets->add(new \Criteria('as_online', 1));
$assetsCount = $assetsHandler->getCount($crAssets);
$GLOBALS['xoopsTpl']->assign('assetsCount', $assetsCount);

switch ($op) {
	case 'show':
	case 'list':
	default:
        $GLOBALS['xoopsTpl']->assign('assetsList', true);
		$GLOBALS['xoopsTpl']->assign('assetsCount', $assetsCount);
		$crAssets->setStart($start);
		$crAssets->setLimit($limit);
		$assetsAll = $assetsHandler->getAll($crAssets);
		if ($assetsCount > 0) {
			$assets = [];
			// Get All Assets
			foreach (\array_keys($assetsAll) as $i) {
				$assets[$i] = $assetsAll[$i]->getValuesAssets();
				$keywords[$i] = $assetsAll[$i]->getVar('as_name');
			}
			$GLOBALS['xoopsTpl']->assign('assets', $assets);
            $GLOBALS['xoopsTpl']->assign('permSubmit', $permSubmit);
			unset($assets);
			// Display Navigation
			if ($assetsCount > $limit) {
				require_once \XOOPS_ROOT_PATH . '/class/pagenav.php';
				$pagenav = new \XoopsPageNav($assetsCount, $limit, $start, 'start', 'op=list&limit=' . $limit);
				$GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
			}
		}
		break;
	case 'save':
		// Security Check
		if (!$GLOBALS['xoopsSecurity']->check()) {
			\redirect_header('assets.php', 3, \implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
		}
		// Check permissions
		if (!$permSubmit) {
			\redirect_header('assets.php?op=list', 3, _NOPERM);
		}
		if ($asId > 0) {
			$assetsObj = $assetsHandler->get($asId);
		} else {
			$assetsObj = $assetsHandler->create();
		}
		$assetsObj->setVar('as_name', Request::getString('as_name', ''));
		$assetsObj->setVar('as_descr', Request::getString('as_descr', ''));
        $assetsObj->setVar('as_reference', Request::getString('as_reference', ''));
        $assetsObj->setVar('as_color', Request::getString('as_color', ''));
        $assetsObj->setVar('as_online', Request::getInt('as_online', 0));
        $assetsObj->setVar('as_uuid', Request::getString('as_uuid', ''));
		$assetsObj->setVar('as_datecreated', Request::getInt('as_datecreated'));
		$assetsObj->setVar('as_submitter', Request::getInt('as_submitter', 0));
		// Insert Data
		if ($assetsHandler->insert($assetsObj)) {
            if (Request::getInt('as_primary', 0) > 0) {
                $newAsId = $assetsObj->getNewInsertedIdAssets();
                $asId = $asId > 0 ? $asId : $newAsId;
                $assetsHandler->setPrimaryAssets($asId);
            }
		    // redirect after insert
			\redirect_header('assets.php?op=list', 2, \_MA_WGSIMPLEACC_FORM_OK);
		}
		// Get Form Error
		$GLOBALS['xoopsTpl']->assign('error', $assetsObj->getHtmlErrors());
		$form = $assetsObj->getFormAssets();
		$GLOBALS['xoopsTpl']->assign('form', $form->render());
		break;
	case 'new':
		// Check permissions
		if (!$permSubmit) {
			\redirect_header('assets.php?op=list', 3, _NOPERM);
		}
		// Form Create
		$assetsObj = $assetsHandler->create();
		$form = $assetsObj->getFormAssets();
		$GLOBALS['xoopsTpl']->assign('form', $form->render());
		break;
	case 'edit':
		// Check params
		if (0 == $asId) {
			\redirect_header('assets.php?op=list', 3, \_MA_WGSIMPLEACC_INVALID_PARAM);
		}
        // Check permissions
        $assetsObj = $assetsHandler->get($asId);
        if (!$permissionsHandler->getPermAssetsEdit($assetsObj->getVar('as_submitter'))) {
            \redirect_header('assets.php?op=list', 3, _NOPERM);
        }
		// Get Form
		$assetsObj = $assetsHandler->get($asId);
		$form = $assetsObj->getFormAssets();
		$GLOBALS['xoopsTpl']->assign('form', $form->render());
		break;
	case 'delete':
		// Check params
		if (0 == $asId) {
			\redirect_header('assets.php?op=list', 3, \_MA_WGSIMPLEACC_INVALID_PARAM);
		}
        // Check permissions
        $assetsObj = $assetsHandler->get($asId);
        if (!$permissionsHandler->getPermAssetsEdit($accountsObj->getVar('as_submitter'))) {
            \redirect_header('assets.php?op=list', 3, _NOPERM);
        }
        // Check whether asset is primary asset
        if ($assetsObj->getVar('as_primary') > 0) {
            \redirect_header('assets.php?op=list', 3, \_MA_WGSIMPLEACC_ASSET_ERR_DELETE);
        }
		$asName = $assetsObj->getVar('as_name');
		if (isset($_REQUEST['ok']) && 1 == $_REQUEST['ok']) {
			if (!$GLOBALS['xoopsSecurity']->check()) {
				\redirect_header('assets.php', 3, \implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
			}
            // Check whether asset is already used
            $crTransactions = new \CriteriaCompo();
            $crTransactions->add(new \Criteria('tra_asid', $asId));
            $transactionsCount = $transactionsHandler->getCount($crTransactions);
            if ($transactionsCount > 0) {
                // set asset offline
                $assetsObj->setVar('as_online', 0);
                if ($assetsHandler->insert($assetsObj)) {
                    \redirect_header('assets.php', 3, \_MA_WGSIMPLEACC_FORM_DELETE_OK);
                } else {
                    $GLOBALS['xoopsTpl']->assign('error', $assetsObj->getHtmlErrors());
                }
            } else {
                // asset not used, delete it
                if ($assetsHandler->delete($assetsObj)) {
                    \redirect_header('assets.php', 3, \_MA_WGSIMPLEACC_FORM_DELETE_OK);
                } else {
                    $GLOBALS['xoopsTpl']->assign('error', $assetsObj->getHtmlErrors());
                }
            }
            unset($crTransactions);
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

// Breadcrumbs
$xoBreadcrumbs[] = ['title' => \_MA_WGSIMPLEACC_ASSETS];

// Keywords
wgsimpleaccMetaKeywords($helper->getConfig('keywords') . ', ' . \implode(',', $keywords));
unset($keywords);

// Description
wgsimpleaccMetaDescription(\_MA_WGSIMPLEACC_ASSETS_DESC);
$GLOBALS['xoopsTpl']->assign('xoops_mpageurl', WGSIMPLEACC_URL.'/assets.php');
$GLOBALS['xoopsTpl']->assign('wgsimpleacc_upload_url', WGSIMPLEACC_UPLOAD_URL);

require __DIR__ . '/footer.php';
