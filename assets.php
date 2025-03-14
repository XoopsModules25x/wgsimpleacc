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
require_once \XOOPS_ROOT_PATH . '/header.php';
$GLOBALS['xoopsTpl']->assign('template_sub', 'db:wgsimpleacc_assets.tpl');

foreach ($styles as $style) {
    $GLOBALS['xoTheme']->addStylesheet($style, null);
}

// Permissions
if (!$permissionsHandler->getPermAssetsView()) {
    \redirect_header('index.php', 0);
}

$op    = Request::getCmd('op', 'list');
$start = Request::getInt('start');
$limit = Request::getInt('limit', $helper->getConfig('userpager'));
$asId  = Request::getInt('as_id');

$keywords = [];

$GLOBALS['xoopsTpl']->assign('showItem', $asId > 0);

$permSubmit = $permissionsHandler->getPermAssetsSubmit();
$assetsCount = $assetsHandler->getCount();
$crAssets = new \CriteriaCompo();
if ($asId > 0) {
    $crAssets->add(new \Criteria('as_id', $asId));
}
if (!$permSubmit) {
    $crAssets->add(new \Criteria('as_online', 1));
}
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
                $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav());
            }
        }
        $minTra = 0;
        $crTransactions = new \CriteriaCompo();
        $crTransactions->setSort('tra_date');
        $crTransactions->setOrder('ASC');
        $crTransactions->setStart();
        $crTransactions->setLimit(1);
        if ($transactionsHandler->getCount($crTransactions) > 0) {
            $transactionsAll = $transactionsHandler->getAll($crTransactions);
            foreach (\array_keys($transactionsAll) as $i) {
                $minTra = (int)$transactionsAll[$i]->getVar('tra_date');
            }
        }
        $GLOBALS['xoopsTpl']->assign('dateFrom', $minTra);
        $GLOBALS['xoopsTpl']->assign('dateTo', \time());
        // Breadcrumbs
        $xoBreadcrumbs[] = ['title' => \_MA_WGSIMPLEACC_ASSETS];
        break;
    case 'save':
        // Security Check
        if (!$GLOBALS['xoopsSecurity']->check()) {
            \redirect_header('assets.php', 3, \implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        // Check permissions
        if (!$permSubmit) {
            \redirect_header('assets.php?op=list', 3, \_NOPERM);
        }
        if ($asId > 0) {
            $assetsObj = $assetsHandler->get($asId);
        } else {
            $assetsObj = $assetsHandler->create();
        }
        $assetsObj->setVar('as_name', Request::getString('as_name'));
        $assetsObj->setVar('as_descr', Request::getString('as_descr'));
        $assetsObj->setVar('as_reference', Request::getString('as_reference'));
        $assetsObj->setVar('as_color', Request::getString('as_color'));
        $assetsObj->setVar('as_iecalc', Request::getInt('as_iecalc'));
        $assetsObj->setVar('as_online', Request::getInt('as_online'));
        $assetsObj->setVar('as_balance', Request::getInt('as_balance'));
        $assetsObj->setVar('as_datecreated', Request::getInt('as_datecreated'));
        $assetsObj->setVar('as_submitter', Request::getInt('as_submitter'));
        // Insert Data
        if ($assetsHandler->insert($assetsObj)) {
            if (Request::getInt('as_primary') > 0) {
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
            \redirect_header('assets.php?op=list', 3, \_NOPERM);
        }
        // Form Create
        $assetsObj = $assetsHandler->create();
        $form = $assetsObj->getFormAssets();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());

        // Breadcrumbs
        $xoBreadcrumbs[] = ['title' => \_MA_WGSIMPLEACC_ASSETS, 'link' => 'assets.php?op=list'];
        $xoBreadcrumbs[] = ['title' => \_MA_WGSIMPLEACC_ASSET_ADD];
        break;
    case 'edit':
        // Check params
        if (0 == $asId) {
            \redirect_header('assets.php?op=list', 3, \_MA_WGSIMPLEACC_INVALID_PARAM);
        }
        // Check permissions
        $assetsObj = $assetsHandler->get($asId);
        if (!$permissionsHandler->getPermAssetsEdit($assetsObj->getVar('as_submitter'))) {
            \redirect_header('assets.php?op=list', 3, \_NOPERM);
        }
        // Get Form
        $assetsObj = $assetsHandler->get($asId);
        $form = $assetsObj->getFormAssets();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        // Breadcrumbs
        $xoBreadcrumbs[] = ['title' => \_MA_WGSIMPLEACC_ASSETS, 'link' => 'assets.php?op=list'];
        $xoBreadcrumbs[] = ['title' => \_MA_WGSIMPLEACC_ASSET_EDIT];
        break;
    case 'delete':
        // Check params
        if (0 == $asId) {
            \redirect_header('assets.php?op=list', 3, \_MA_WGSIMPLEACC_INVALID_PARAM);
        }
        // Check permissions
        $assetsObj = $assetsHandler->get($asId);
        if (!$permissionsHandler->getPermAssetsEdit($accountsObj->getVar('as_submitter'))) {
            \redirect_header('assets.php?op=list', 3, \_NOPERM);
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
            $customConfirm = new Common\Confirm(
                ['ok' => 1, 'as_id' => $asId, 'op' => 'delete'],
                $_SERVER['REQUEST_URI'],
                \sprintf(\_MA_WGSIMPLEACC_FORM_SURE_DELETE, $assetsObj->getVar('as_name')), _MA_WGSIMPLEACC_FORM_DELETE_CONFIRM, _MA_WGSIMPLEACC_FORM_DELETE_LABEL);
            $form = $customConfirm->getFormConfirm();
            $GLOBALS['xoopsTpl']->assign('form', $form->render());

            // Breadcrumbs
            $xoBreadcrumbs[] = ['title' => \_MA_WGSIMPLEACC_ASSETS, 'link' => 'assets.php?op=list'];
            $xoBreadcrumbs[] = ['title' => \_MA_WGSIMPLEACC_ASSET_EDIT];
        }
        break;
}

// Keywords
wgsimpleaccMetaKeywords($helper->getConfig('keywords') . ', ' . \implode(',', $keywords));
unset($keywords);

// Description
wgsimpleaccMetaDescription(\_MA_WGSIMPLEACC_ASSETS_DESC);
$GLOBALS['xoopsTpl']->assign('xoops_mpageurl', \WGSIMPLEACC_URL . '/assets.php');
$GLOBALS['xoopsTpl']->assign('wgsimpleacc_upload_url', \WGSIMPLEACC_UPLOAD_URL);

require __DIR__ . '/footer.php';
