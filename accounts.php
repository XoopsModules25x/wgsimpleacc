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
    Common
};

require __DIR__ . '/header.php';
require_once \XOOPS_ROOT_PATH . '/header.php';
$GLOBALS['xoopsTpl']->assign('template_sub', 'db:wgsimpleacc_accounts.tpl');
require __DIR__ . '/navbar.php';

// Permissions
if (!$permissionsHandler->getPermAccountsView()) {
    \redirect_header('index.php', 0, '');
}

$op    = Request::getCmd('op', 'list');
$start = Request::getInt('start', 0);
$limit = Request::getInt('limit', $helper->getConfig('userpager'));
$accId = Request::getInt('acc_id', 0);

$permAccountsSubmit = $permissionsHandler->getPermAccountsSubmit();

$GLOBALS['xoopsTpl']->assign('wgsimpleacc_icon_url_16', \WGSIMPLEACC_ICONS_URL . '/16/');
$GLOBALS['xoopsTpl']->assign('xoops_icons32_url', \XOOPS_ICONS32_URL);
$GLOBALS['xoopsTpl']->assign('wgsimpleacc_url', \WGSIMPLEACC_URL);

$keywords = [];

$GLOBALS['xoopsTpl']->assign('showItem', $accId > 0);

$accountsCount = $accountsHandler->getCount();
$GLOBALS['xoopsTpl']->assign('accountsCount', $accountsCount);

switch ($op) {
    case 'list':
    default:
        $accountsCount = $accountsHandler->getCount();
        if ($accountsCount > 0) {
            $GLOBALS['xoTheme']->addStylesheet(\WGSIMPLEACC_URL . '/assets/css/nestedsortable.css');
            if ($permAccountsSubmit) {
                // add scripts
                $GLOBALS['xoTheme']->addScript(\WGSIMPLEACC_URL . '/assets/js/jquery-ui.min.js');
                $GLOBALS['xoTheme']->addScript(\WGSIMPLEACC_URL . '/assets/js/sortable-accounts.js');
                $GLOBALS['xoTheme']->addScript(\WGSIMPLEACC_URL . '/assets/js/jquery.mjs.nestedSortable.js');
                // add list for sorting
                $accountlist_sort = $accountsHandler->getListOfAccountsEdit(0);
            } else {
                // add list for sorting
                $accountlist_sort = $accountsHandler->getListOfAccounts(0);
            }
            $GLOBALS['xoopsTpl']->assign('accountlist_sort', $accountlist_sort);
            $GLOBALS['xoopsTpl']->assign('accounts_submit', $permAccountsSubmit);
        }

        // Breadcrumbs
        $xoBreadcrumbs[] = ['title' => \_MA_WGSIMPLEACC_ACCOUNTS];
        break;
    case 'save':
        // Security Check
        if (!$GLOBALS['xoopsSecurity']->check()) {
            \redirect_header('accounts.php', 3, \implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        // Check permissions
        if (!$permAccountsSubmit) {
            \redirect_header('accounts.php?op=list', 3, \_NOPERM);
        }
        if ($accId > 0) {
            $accountsObj = $accountsHandler->get($accId);
        } else {
            $accountsObj = $accountsHandler->create();
        }
        $accPid = Request::getInt('acc_pid', 0);
        $accountsObj->setVar('acc_pid', $accPid);
        $accountsObj->setVar('acc_key', Request::getString('acc_key', ''));
        $accountsObj->setVar('acc_name', Request::getString('acc_name', ''));
        $accountsObj->setVar('acc_desc', Request::getString('acc_desc', ''));
        $accountsObj->setVar('acc_classification', Request::getInt('acc_classification', 0));
        $accountsObj->setVar('acc_color', Request::getString('acc_color', ''));
        $accountsObj->setVar('acc_iecalc', Request::getInt('acc_iecalc', 0));
        $accountsObj->setVar('acc_online', Request::getInt('acc_online', 0));
        $level = 1;
        if ($accPid > 0) {
            $accParentObj = $accountsHandler->get($accPid);
            $level = $accParentObj->getVar('acc_level') + 1;
        }
        unset($accParentObj);
        $accountsObj->setVar('acc_level', Request::getInt('acc_level', 0));
        $accountsObj->setVar('acc_weight', Request::getInt('acc_weight', 0));
        $accountsObj->setVar('acc_datecreated', \time());
        $accountsObj->setVar('acc_submitter', Request::getInt('acc_submitter', 0));
        // Insert Data
        if ($accountsHandler->insert($accountsObj)) {
            \redirect_header('accounts.php?op=list', 2, \_MA_WGSIMPLEACC_FORM_OK);
        }
        // Get Form Error
        $GLOBALS['xoopsTpl']->assign('error', $accountsObj->getHtmlErrors());
        $form = $accountsObj->getFormAccounts();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'new':
        // Check permissions
        if (!$permAccountsSubmit) {
            \redirect_header('accounts.php?op=list', 3, \_NOPERM);
        }
        // Form Create
        $accountsObj = $accountsHandler->create();
        $form = $accountsObj->getFormAccounts();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());

        // Breadcrumbs
        $xoBreadcrumbs[] = ['title' => \_MA_WGSIMPLEACC_ACCOUNTS, 'link' => 'accounts.php?op=list'];
        $xoBreadcrumbs[] = ['title' => \_MA_WGSIMPLEACC_ACCOUNT_ADD];
        break;
    case 'edit':
        // Check params
        if (0 == $accId) {
            \redirect_header('accounts.php?op=list', 3, \_MA_WGSIMPLEACC_INVALID_PARAM);
        }
        // Check permissions
        $accountsObj = $accountsHandler->get($accId);
        if (!$permissionsHandler->getPermAccountsEdit($accountsObj->getVar('acc_submitter'))) {
            \redirect_header('accounts.php?op=list', 3, \_NOPERM);
        }
        // Get Form
        $form = $accountsObj->getFormAccounts();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());

        // Breadcrumbs
        $xoBreadcrumbs[] = ['title' => \_MA_WGSIMPLEACC_ACCOUNTS, 'link' => 'accounts.php?op=list'];
        $xoBreadcrumbs[] = ['title' => \_MA_WGSIMPLEACC_ACCOUNT_EDIT];
        break;
    case 'delete':
        // Check params
        if (0 == $accId) {
            \redirect_header('accounts.php?op=list', 3, \_MA_WGSIMPLEACC_INVALID_PARAM);
        }
        // Check permissions
        $accountsObj = $accountsHandler->get($accId);
        if (!$permissionsHandler->getPermAccountsEdit($accountsObj->getVar('acc_submitter'))) {
            \redirect_header('accounts.php?op=list', 3, \_NOPERM);
        }
        // Check whether account is already used
        $crTransactions = new \CriteriaCompo();
        $crTransactions->add(new \Criteria('tra_accid', $accId));
        $transactionsCount = $transactionsHandler->getCount($crTransactions);
        if ($transactionsCount > 0) {
            \redirect_header('accounts.php?op=list', 3, \_MA_WGSIMPLEACC_ACCOUNT_ERR_DELETE);
        }
        unset($crTransactions);
        $accountsObj = $accountsHandler->get($accId);
        $accKey = $accountsObj->getVar('acc_key');
        if (isset($_REQUEST['ok']) && 1 == $_REQUEST['ok']) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                \redirect_header('accounts.php', 3, \implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            if ($accountsHandler->delete($accountsObj)) {
                \redirect_header('accounts.php', 3, \_MA_WGSIMPLEACC_FORM_DELETE_OK);
            } else {
                $GLOBALS['xoopsTpl']->assign('error', $accountsObj->getHtmlErrors());
            }
        } else {
            $xoopsconfirm = new Common\XoopsConfirm(
                ['ok' => 1, 'acc_id' => $accId, 'op' => 'delete'],
                $_SERVER['REQUEST_URI'],
                \sprintf(\_MA_WGSIMPLEACC_FORM_SURE_DELETE, $accountsObj->getVar('acc_key')));
            $form = $xoopsconfirm->getFormXoopsConfirm();
            $GLOBALS['xoopsTpl']->assign('form', $form->render());
        }
        break;
    case 'order':
        $aorder = $_POST['menuItem'];
        $i      = 0;
        foreach (\array_keys($aorder) as $key) {
            $accPid = (int)$aorder[$key];
            $accountsObj = $accountsHandler->get($key);
            $accountsObj->setVar('acc_pid', $accPid);
            $accountsObj->setVar('acc_weight', $i + 1);
            $level = 1;
            if ($accPid > 0) {
                $accParentObj = $accountsHandler->get($accPid);
                $level = $accParentObj->getVar('acc_level') + 1;
            }
            unset($accParentObj);
            $accountsObj->setVar('acc_level', $level);
            $accountsHandler->insert($accountsObj);
            unset($accountsObj);
            if ($accPid > 0) {
                $accountsObj = $accountsHandler->get($accPid);
                $accountsHandler->insert($accountsObj);
                unset($accountsObj);
            }
            $i++;
        }
        break;
}

// Keywords
wgsimpleaccMetaKeywords($helper->getConfig('keywords') . ', ' . \implode(',', $keywords));
unset($keywords);

// Description
wgsimpleaccMetaDescription(\_MA_WGSIMPLEACC_ACCOUNTS_DESC);
$GLOBALS['xoopsTpl']->assign('xoops_mpageurl', \WGSIMPLEACC_URL . '/accounts.php');
$GLOBALS['xoopsTpl']->assign('wgsimpleacc_upload_url', \WGSIMPLEACC_UPLOAD_URL);

require __DIR__ . '/footer.php';
