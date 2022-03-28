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
$GLOBALS['xoopsTpl']->assign('template_sub', 'db:wgsimpleacc_allocations.tpl');
require __DIR__ . '/navbar.php';

// Permissions
if (!$permissionsHandler->getPermAllocationsView()) {
    \redirect_header('index.php', 0);
}

$op    = Request::getCmd('op', 'list');
$start = Request::getInt('start');
$limit = Request::getInt('limit', $helper->getConfig('userpager'));
$allId = Request::getInt('all_id');

$GLOBALS['xoopsTpl']->assign('wgsimpleacc_icon_url_16', \WGSIMPLEACC_ICONS_URL . '/16/');
$GLOBALS['xoopsTpl']->assign('xoops_icons32_url', \XOOPS_ICONS32_URL);
$GLOBALS['xoopsTpl']->assign('wgsimpleacc_url', \WGSIMPLEACC_URL);

$keywords = [];

$permAllocationsSubmit = $permissionsHandler->getPermAllocationsSubmit();

$GLOBALS['xoopsTpl']->assign('showItem', $allId > 0);

$allocationsCount = $allocationsHandler->getCount();
$GLOBALS['xoopsTpl']->assign('allocationsCount', $allocationsCount);

switch ($op) {
    case 'list':
    default:
        if ($allocationsCount > 0) {
            $GLOBALS['xoTheme']->addStylesheet(\WGSIMPLEACC_URL . '/assets/css/nestedsortable.css');
            if ($permAllocationsSubmit) {
                // add scripts
                $GLOBALS['xoTheme']->addScript(\WGSIMPLEACC_URL . '/assets/js/jquery-ui.min.js');
                $GLOBALS['xoTheme']->addScript(\WGSIMPLEACC_URL . '/assets/js/sortable-allocations.js');
                $GLOBALS['xoTheme']->addScript(\WGSIMPLEACC_URL . '/assets/js/jquery.mjs.nestedSortable.js');

                // add list for sorting
                $allocationlist_sort = $allocationsHandler->getListOfAllocationsEdit(0);
            } else {
                // add list for sorting
                $allocationlist_sort = $allocationsHandler->getListOfAllocations(0);
            }
            // var_dump($allocationlist_sort);
            $GLOBALS['xoopsTpl']->assign('allocationlist_sort', $allocationlist_sort);
            $GLOBALS['xoopsTpl']->assign('allocations_submit', $permAllocationsSubmit);
        }

        // Breadcrumbs
        $xoBreadcrumbs[] = ['title' => \_MA_WGSIMPLEACC_ALLOCATIONS];
        break;
    case 'save':
        // Security Check
        if (!$GLOBALS['xoopsSecurity']->check()) {
            \redirect_header('allocations.php', 3, \implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        // Check permissions
        if (!$permAllocationsSubmit) {
            \redirect_header('allocations.php?op=list', 3, \_NOPERM);
        }
        if ($allId > 0) {
            $allocationsObj = $allocationsHandler->get($allId);
        } else {
            $allocationsObj = $allocationsHandler->create();
        }
        $allPid = Request::getInt('all_pid');
        $allocationsObj->setVar('all_pid', $allPid);
        $allocationsObj->setVar('all_name', Request::getString('all_name'));
        $allocationsObj->setVar('all_desc', Request::getString('all_desc'));
        $allocationsObj->setVar('all_online', Request::getInt('all_online'));
        $level = 1;
        if ($allPid > 0) {
            $allParentObj = $allocationsHandler->get($allPid);
            $level = $allParentObj->getVar('all_level') + 1;
        }
        unset($allParentObj);
        $allocationsObj->setVar('all_level', $level);
        $allocationsObj->setVar('all_weight', Request::getInt('all_weight'));
        $allocationsObj->setVar('all_datecreated', \time());
        $allocationsObj->setVar('all_submitter', Request::getInt('all_submitter'));
        // Insert Data
        if ($allocationsHandler->insert($allocationsObj)) {
            // redirect after insert
            \redirect_header('allocations.php', 2, \_MA_WGSIMPLEACC_FORM_OK);
        }
        // Get Form Error
        $GLOBALS['xoopsTpl']->assign('error', $allocationsObj->getHtmlErrors());
        $form = $allocationsObj->getFormAllocations();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'new':
        // Check permissions
        if (!$permAllocationsSubmit) {
            \redirect_header('allocations.php?op=list', 3, \_NOPERM);
        }
        // Form Create
        $allocationsObj = $allocationsHandler->create();
        $form = $allocationsObj->getFormAllocations();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());

        // Breadcrumbs
        $xoBreadcrumbs[] = ['title' => \_MA_WGSIMPLEACC_ALLOCATIONS, 'link' => 'allocations.php?op=list'];
        $xoBreadcrumbs[] = ['title' => \_MA_WGSIMPLEACC_ALLOCATION_ADD];
        break;
    case 'edit':
        // Check params
        if (0 == $allId) {
            \redirect_header('allocations.php?op=list', 3, \_MA_WGSIMPLEACC_INVALID_PARAM);
        }
        // Check permissions
        $allocationsObj = $allocationsHandler->get($allId);
        if (!$permissionsHandler->getPermAllocationsEdit($allocationsObj->getVar('all_submitter'))) {
            \redirect_header('allocations.php?op=list', 3, \_NOPERM);
        }
        // Get Form

        $form = $allocationsObj->getFormAllocations();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());

        // Breadcrumbs
        $xoBreadcrumbs[] = ['title' => \_MA_WGSIMPLEACC_ALLOCATIONS, 'link' => 'allocations.php?op=list'];
        $xoBreadcrumbs[] = ['title' => \_MA_WGSIMPLEACC_ALLOCATION_EDIT];
        break;
    case 'delete':
        // Check params
        if (0 == $allId) {
            \redirect_header('allocations.php?op=list', 3, \_MA_WGSIMPLEACC_INVALID_PARAM);
        }
        // Check permissions
        $allocationsObj = $allocationsHandler->get($allId);
        if (!$permissionsHandler->getPermAllocationsEdit($allocationsObj->getVar('all_submitter'))) {
            \redirect_header('allocations.php?op=list', 3, \_NOPERM);
        }
        // Check whether allocation is already used
        $crTransactions = new \CriteriaCompo();
        $crTransactions->add(new \Criteria('tra_allid', $allId));
        $transactionsCount = $transactionsHandler->getCount($crTransactions);
        if ($transactionsCount > 0) {
            \redirect_header('allocations.php?op=list', 3, \_MA_WGSIMPLEACC_ALLOCATION_ERR_DELETE1);
        }
        unset($crTransactions);
        // Check whether allocation has sub allocations
        $crAllocations = new \CriteriaCompo();
        $crAllocations->add(new \Criteria('all_pid', $allId));
        $allocationsCount = $allocationsHandler->getCount($crAllocations);
        if ($allocationsCount > 0) {
            \redirect_header('allocations.php?op=list', 3, \_MA_WGSIMPLEACC_ALLOCATION_ERR_DELETE2);
        }
        unset($crAllocations);
        $allocationsObj = $allocationsHandler->get($allId);
        $allName = $allocationsObj->getVar('all_name');
        if (isset($_REQUEST['ok']) && 1 == $_REQUEST['ok']) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                \redirect_header('allocations.php', 3, \implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            if ($allocationsHandler->delete($allocationsObj)) {
                \redirect_header('allocations.php', 3, \_MA_WGSIMPLEACC_FORM_DELETE_OK);
            } else {
                $GLOBALS['xoopsTpl']->assign('error', $allocationsObj->getHtmlErrors());
            }
        } else {
            $customConfirm = new Common\Confirm(
                ['ok' => 1, 'all_id' => $allId, 'op' => 'delete'],
                $_SERVER['REQUEST_URI'],
                \sprintf(\_MA_WGSIMPLEACC_FORM_SURE_DELETE, $allocationsObj->getVar('all_name')));
            $form = $customConfirm->getFormConfirm();
            $GLOBALS['xoopsTpl']->assign('form', $form->render());

            // Breadcrumbs
            $xoBreadcrumbs[] = ['title' => \_MA_WGSIMPLEACC_ALLOCATIONS, 'link' => 'allocations.php?op=list'];
            $xoBreadcrumbs[] = ['title' => \_MA_WGSIMPLEACC_ALLOCATION_EDIT];
        }
        break;
    case 'order':
        $aorder = $_POST['menuItem'];
        $i      = 0;
        foreach (\array_keys($aorder) as $key) {
            $allPid = (int)$aorder[$key];
            $allocationsObj = $allocationsHandler->get($key);
            $allocationsObj->setVar('all_pid', $allPid);
            $level = 1;
            if ($allPid > 0) {
                $allParentObj = $allocationsHandler->get($allPid);
                $level = $allParentObj->getVar('all_level') + 1;
            }
            unset($allParentObj);
            $allocationsObj->setVar('all_level', $level);
            $allocationsObj->setVar('all_weight', $i + 1);
            $allocationsHandler->insert($allocationsObj);
            unset($allocationsObj);
            if ($allPid > 0) {
                $allocationsObj = $allocationsHandler->get($allPid);
                $allocationsHandler->insert($allocationsObj);
                unset($allocationsObj);
            }
            $i++;
        }
        break;
}

// Keywords
wgsimpleaccMetaKeywords($helper->getConfig('keywords') . ', ' . \implode(',', $keywords));
unset($keywords);

// Description
wgsimpleaccMetaDescription(\_MA_WGSIMPLEACC_ALLOCATIONS_DESC);
$GLOBALS['xoopsTpl']->assign('xoops_mpageurl', \WGSIMPLEACC_URL . '/allocations.php');
$GLOBALS['xoopsTpl']->assign('wgsimpleacc_upload_url', \WGSIMPLEACC_UPLOAD_URL);

require __DIR__ . '/footer.php';
