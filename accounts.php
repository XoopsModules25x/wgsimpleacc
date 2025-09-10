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
    Common
};

require __DIR__ . '/header.php';
require_once \XOOPS_ROOT_PATH . '/header.php';
$GLOBALS['xoopsTpl']->assign('template_sub', 'db:wgsimpleacc_accounts.tpl');

foreach ($styles as $style) {
    $GLOBALS['xoTheme']->addStylesheet($style, null);
}

// Permissions
if (!$permissionsHandler->getPermAccountsView()) {
    \redirect_header('index.php', 0);
}

$op    = Request::getCmd('op', 'list');
$start = Request::getInt('start');
$limit = Request::getInt('limit', $helper->getConfig('userpager'));
$accId = Request::getInt('acc_id');

$permAccountsSubmit = $permissionsHandler->getPermAccountsSubmit();

$keywords = [];

$GLOBALS['xoopsTpl']->assign('showItem', $accId > 0);

$accountsCount = $accountsHandler->getCount();
$GLOBALS['xoopsTpl']->assign('accountsCount', $accountsCount);

switch ($op) {
    case 'list':
    default:
        $accountsCount = $accountsHandler->getCount();
        $GLOBALS['xoopsTpl']->assign('wgsimpleacc_icon_url', \WGSIMPLEACC_ICONS_URL);
        if ($accountsCount > 0) {
            $GLOBALS['xoTheme']->addStylesheet(\WGSIMPLEACC_URL . '/assets/css/nestedsortable.css');
            if ($permAccountsSubmit) {
                // add scripts
                $GLOBALS['xoTheme']->addScript('browse.php?Frameworks/jquery/jquery.js');
                $GLOBALS['xoTheme']->addScript(\WGSIMPLEACC_URL . '/assets/js/jquery-ui.min.js');
                $GLOBALS['xoTheme']->addScript(\WGSIMPLEACC_URL . '/assets/js/sortable-accounts.js');
                $GLOBALS['xoTheme']->addScript(\WGSIMPLEACC_URL . '/assets/js/jquery.mjs.nestedSortable.js');
                // add list for sorting
                $accountlist_sort = $accountsHandler->getListOfAccountsEdit(0);
            } else {
                // add list for sorting
                $accountlist_sort = $accountsHandler->getListOfAccounts(0);
            }
            //new collabpsible list
            $accountlist_coll= $accountsHandler->getArrayTreeOfAccounts(0);
            $GLOBALS['xoopsTpl']->assign('accountlist_collapsible', $accountlist_coll);
            //use allocationlist_sort only for older xoops and bootstrap3
            //$GLOBALS['xoopsTpl']->assign('accountlist_sort', $accountlist_sort);
            $GLOBALS['xoopsTpl']->assign('accounts_submit', $permAccountsSubmit);
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
        }

        // Breadcrumbs
        $xoBreadcrumbs[] = ['title' => \_MA_WGSIMPLEACC_ACCOUNTS];
        break;

    case 'compare_alloc':
        $accountsCount = $accountsHandler->getCountAccounts();
        $GLOBALS['xoopsTpl']->assign('accounts_count', $accountsCount);
        // Table view accounts
        if ($accountsCount > 0) {
            $accountsAll = $accountsHandler->getAllAccounts($start, $limit);
            foreach (\array_keys($accountsAll) as $acc) {
                $allocationsAll = $allocationsHandler->getAllAllocations();
                $accUsedIn = [];
                foreach (\array_keys($allocationsAll) as $all) {
                    $arrAccounts = \unserialize($allocationsAll[$all]->getVar('all_accounts'), ['allowed_classes' => false]);
                    if (\is_array($arrAccounts) && \in_array($acc, $arrAccounts)) {
                        $accUsedIn[] = [
                            'id' => $all,
                            'name' => $allocationsAll[$all]->getVar('all_name'),
                            'online' => $allocationsAll[$all]->getVar('all_online'),
                            'online_text' => $allocationsAll[$all]->getVar('all_online') > 0 ? _MA_WGSIMPLEACC_ONLINE : _MA_WGSIMPLEACC_OFFLINE
                        ];
                    }
                }
                $account = $accountsAll[$acc]->getValuesAccounts();
                $account['allocations'] = $accUsedIn;
                $GLOBALS['xoopsTpl']->append('compare_list', $account);
                unset($account);
            }
            // Display Navigation
            if ($accountsCount > $limit) {
                require_once \XOOPS_ROOT_PATH . '/class/pagenav.php';
                $pagenav = new \XoopsPageNav($accountsCount, $limit, $start, 'start', 'op=compare_alloc&limit=' . $limit);
                $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav());
            }
        } else {
            $GLOBALS['xoopsTpl']->assign('error', \_MA_WGSIMPLEACC_THEREARENT_ACCOUNTS);
        }
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
        $accPid = Request::getInt('acc_pid');
        $accountsObj->setVar('acc_pid', $accPid);
        $accountsObj->setVar('acc_key', Request::getString('acc_key'));
        $accountsObj->setVar('acc_name', Request::getString('acc_name'));
        $accountsObj->setVar('acc_desc', Request::getString('acc_desc'));
        $accountsObj->setVar('acc_classification', Request::getInt('acc_classification'));
        $accountsObj->setVar('acc_color', Request::getString('acc_color'));
        $accountsObj->setVar('acc_iecalc', Request::getInt('acc_iecalc'));
        $accountsObj->setVar('acc_online', Request::getInt('acc_online'));
        $accountsObj->setVar('acc_allocations', \serialize(Request::getArray('acc_allocations')));
        $level = 1;
        $accWeight = Request::getInt('acc_weight');
        if ($accPid > 0) {
            $accParentObj = $accountsHandler->get($accPid);
            $level = $accParentObj->getVar('acc_level') + 1;
            if (9999 === $accWeight) {
                $accWeight = $accParentObj->getVar('acc_weight');
            }
        }
        unset($accParentObj);
        $accountsObj->setVar('acc_level', $level);
        $accountsObj->setVar('acc_weight', $accWeight);
        $accountsObj->setVar('acc_datecreated', \time());
        $accountsObj->setVar('acc_submitter', Request::getInt('acc_submitter'));
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
        if ($accId > 0) {
            $accountsObj->setVar('acc_pid', $accId);
        }
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
            \redirect_header('accounts.php?op=list', 3, \_MA_WGSIMPLEACC_ACCOUNT_ERR_DELETE1);
        }
        unset($crTransactions);
        // Check whether account has sub accounts
        $crAccounts = new \CriteriaCompo();
        $crAccounts->add(new \Criteria('acc_pid', $accId));
        $accountsCount = $accountsHandler->getCount($crAccounts);
        if ($accountsCount > 0) {
            \redirect_header('accounts.php?op=list', 3, \_MA_WGSIMPLEACC_ACCOUNT_ERR_DELETE2);
        }
        $accountsObj = $accountsHandler->get($accId);
        $accKey = $accountsObj->getVar('acc_key');
        if (isset($_REQUEST['ok']) && 1 == $_REQUEST['ok']) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                \redirect_header('accounts.php', 3, \implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            // Check whether account is already used in transaction hist
            $crTrahistories = new \CriteriaCompo();
            $crTrahistories->add(new \Criteria('tra_accid', $accId));
            $trahistoriesCount = $trahistoriesHandler->getCount($crTrahistories);
            if ($trahistoriesCount > 0) {
                // if allocation is used in transaction hist then only hide the allocation
                $accountsObj->setVar('acc_online', Constants::ONOFF_HIDDEN);
                if ($accountsHandler->insert($accountsObj)) {
                    \redirect_header('accounts.php', 3, \_MA_WGSIMPLEACC_FORM_DELETE_OK);
                } else {
                    $GLOBALS['xoopsTpl']->assign('error', $accountsObj->getHtmlErrors());
                }
            } else {
                if ($accountsHandler->delete($accountsObj)) {
                    \redirect_header('accounts.php', 3, \_MA_WGSIMPLEACC_FORM_DELETE_OK);
                } else {
                    $GLOBALS['xoopsTpl']->assign('error', $accountsObj->getHtmlErrors());
                }
            }
        } else {
            $customConfirm = new Common\Confirm(
                ['ok' => 1, 'acc_id' => $accId, 'op' => 'delete'],
                $_SERVER['REQUEST_URI'],
                \sprintf(\_MA_WGSIMPLEACC_FORM_SURE_DELETE, $accountsObj->getVar('acc_key') . ' ' . $accountsObj->getVar('acc_name')), _MA_WGSIMPLEACC_FORM_DELETE_CONFIRM, _MA_WGSIMPLEACC_FORM_DELETE_LABEL);
            $form = $customConfirm->getFormConfirm();
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
