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

// Define Stylesheet
foreach ($styles as $style) {
    $GLOBALS['xoTheme']->addStylesheet($style, null);
}
// Add scripts
foreach ($scripts as $script) {
    $GLOBALS['xoTheme']->addScript($script);
}

//$GLOBALS['xoTheme']->addStylesheet(\WGSIMPLEACC_URL . '/assets/css/startmin.css', null);
//$GLOBALS['xoTheme']->addStylesheet(\WGSIMPLEACC_URL . '/assets/css/wgsa_startmin.css', null);

//$GLOBALS['xoTheme']->addScript(\WGSIMPLEACC_URL . '/assets/js/metisMenu.min.js');
//$GLOBALS['xoTheme']->addScript(\WGSIMPLEACC_URL . '/assets/js/startmin.js');

$GLOBALS['xoopsTpl']->assign('indexHeader', $helper->getConfig('index_header'));
$GLOBALS['xoopsTpl']->assign('permGlobalView', $permissionsHandler->getPermGlobalView());
/*
$GLOBALS['xoopsTpl']->assign('permGlobalApprove', $permissionsHandler->getPermGlobalApprove());
$GLOBALS['xoopsTpl']->assign('permTransactionsSubmit', $permissionsHandler->getPermTransactionsSubmit());
$GLOBALS['xoopsTpl']->assign('permTransactionsView', $permissionsHandler->getPermTransactionsView());
$GLOBALS['xoopsTpl']->assign('permAllocationsSubmit', $permissionsHandler->getPermAllocationsSubmit());
$GLOBALS['xoopsTpl']->assign('permAllocationsView', $permissionsHandler->getPermAllocationsView());
$GLOBALS['xoopsTpl']->assign('permAccountsSubmit', $permissionsHandler->getPermAccountsSubmit());
$GLOBALS['xoopsTpl']->assign('permAccountsView', $permissionsHandler->getPermAccountsView());
$GLOBALS['xoopsTpl']->assign('permAssetsSubmit', $permissionsHandler->getPermAssetsSubmit());
$GLOBALS['xoopsTpl']->assign('permAssetsView', $permissionsHandler->getPermAssetsView());
$GLOBALS['xoopsTpl']->assign('permBalancesSubmit', $permissionsHandler->getPermBalancesSubmit());
$GLOBALS['xoopsTpl']->assign('permBalancesView', $permissionsHandler->getPermBalancesView());
$GLOBALS['xoopsTpl']->assign('permTratemplatesSubmit', $permissionsHandler->getPermTratemplatesSubmit());
$GLOBALS['xoopsTpl']->assign('permTratemplatesView', $permissionsHandler->getPermTratemplatesView());
$GLOBALS['xoopsTpl']->assign('permOuttemplatesSubmit', $permissionsHandler->getPermOuttemplatesSubmit());
$GLOBALS['xoopsTpl']->assign('permOuttemplatesView', $permissionsHandler->getPermOuttemplatesView());
$GLOBALS['xoopsTpl']->assign('permClientsSubmit', $permissionsHandler->getPermClientsSubmit());
$GLOBALS['xoopsTpl']->assign('permClientsView', $permissionsHandler->getPermClientsView());
*/
$GLOBALS['xoopsTpl']->assign('wgsimpleacc_icon_url_32', WGSIMPLEACC_ICONS_URL . '/32/');
$GLOBALS['xoopsTpl']->assign('wgsimpleacc_image_url', WGSIMPLEACC_IMAGE_URL);

$currentUser = '';
$uid = isset($GLOBALS['xoopsUser']) && \is_object($GLOBALS['xoopsUser']) ? $GLOBALS['xoopsUser']->getVar('uid') : 0;
if ($uid > 0) {
    $currentUser = $GLOBALS['xoopsUser']::getUnameFromId($uid);
}
$GLOBALS['xoopsTpl']->assign('currentUser', $currentUser);

/*read navbar items related to perms of current user*/
$nav_items1 = [];
$nav_items1[] = ['href' => 'index.php', 'aclass' => 'active',  'icon' => '<i class="fa fa-dashboard fa-fw fa-lg"></i>', 'label' => \_MA_WGSIMPLEACC_DASHBOARD];
if ($permissionsHandler->getPermTransactionsView()) {
    $nav_items2 = [];
    if ($permissionsHandler->getPermTransactionsSubmit()) {
        $nav_items2[] = ['href' => 'transactions.php?op=list', 'icon' => '<i class="fa fa-list-ol fa-fw fa-lg"></i>','label' => \_MA_WGSIMPLEACC_TRANSACTIONS_LIST, 'sub_items3' => []];
        $nav_items2[] = ['href' => 'transactions.php?op=new&tra_type=3', 'icon' => '<i class="fa fa-plus-square fa-fw fa-lg"></i>', 'label' => \_MA_WGSIMPLEACC_TRANSACTION_SUBMIT_INCOME, 'sub_items3' => []];
        $nav_items2[] = ['href' => 'transactions.php?op=new&tra_type=2', 'icon' => '<i class="fa fa-plus-square fa-fw fa-lg"></i>', 'label' => \_MA_WGSIMPLEACC_TRANSACTION_SUBMIT_EXPENSE, 'sub_items3' => []];
        if ($permissionsHandler->getPermGlobalApprove()) {
            $nav_items2[] = ['href' => 'transactions.php?op=listhist', 'icon' => '<i class="fa fa-trash fa-fw fa-lg"></i>', 'label' => \_MA_WGSIMPLEACC_TRAHISTORY_DELETED, 'sub_items3' => []];
        }
        $nav_items1[] = ['href' => '#', 'icon' => '<i class="fa fa-files-o fa-fw fa-lg"></i>', 'label' => \_MA_WGSIMPLEACC_TRANSACTIONS, 'sub_items2' => $nav_items2];
    } else {
        $nav_items1[] = ['href' => 'transactions.php', 'icon' => '<i class="fa fa-files-o fa-fw fa-lg"></i>', 'label' => \_MA_WGSIMPLEACC_TRANSACTIONS_LIST];
    }
}
if ($permissionsHandler->getPermClientsView() && $helper->getConfig('use_clients')) {
    $nav_items2 = [];
    if ($permissionsHandler->getPermClientsSubmit()) {
        $nav_items2[] = ['href' => 'clients.php?op=list', 'icon' => '<i class="fa fa-list-ol fa-fw fa-lg"></i>','label' => \_MA_WGSIMPLEACC_CLIENTS_LIST, 'sub_items3' => []];
        $nav_items2[] = ['href' => 'clients.php?op=new', 'icon' => '<i class="fa fa-plus-square fa-fw fa-lg"></i>', 'label' => \_MA_WGSIMPLEACC_CLIENT_SUBMIT, 'sub_items3' => []];
        $nav_items1[] = ['href' => '#', 'icon' => '<i class="fa fa-users fa-fw fa-lg"></i>', 'label' => \_MA_WGSIMPLEACC_CLIENTS, 'sub_items2' => $nav_items2];
    } else {
        $nav_items1[] = ['href' => 'clients.php', 'icon' => '<i class="fa fa-users fa-fw fa-lg"></i>', 'label' => \_MA_WGSIMPLEACC_CLIENTS_LIST];
    }
}
if ($permissionsHandler->getPermAllocationsView()) {
    $nav_items2 = [];
    if ($permissionsHandler->getPermAllocationsSubmit()) {
        $nav_items2[] = ['href' => 'allocations.php?op=list', 'icon' => '<i class="fa fa-list-ol fa-fw fa-lg"></i>','label' => \_MA_WGSIMPLEACC_ALLOCATIONS_LIST, 'sub_items3' => []];
        $nav_items2[] = ['href' => 'allocations.php?op=new', 'icon' => '<i class="fa fa-plus-square fa-fw fa-lg"></i>', 'label' => \_MA_WGSIMPLEACC_ALLOCATION_SUBMIT, 'sub_items3' => []];
        $nav_items1[] = ['href' => '#', 'icon' => '<i class="fa fa-sitemap fa-fw fa-lg"></i>', 'label' => \_MA_WGSIMPLEACC_ALLOCATIONS, 'sub_items2' => $nav_items2];
    } else {
        $nav_items1[] = ['href' => 'allocations.php', 'icon' => '<i class="fa fa-sitemap fa-fw fa-lg"></i>', 'label' => \_MA_WGSIMPLEACC_ALLOCATIONS_LIST];
    }
}
if ($permissionsHandler->getPermAccountsView()) {
    $nav_items2 = [];
    if ($permissionsHandler->getPermAccountsSubmit()) {
        $nav_items2[] = ['href' => 'accounts.php?op=list', 'icon' => '<i class="fa fa-list-ol fa-fw fa-lg"></i>','label' => \_MA_WGSIMPLEACC_ACCOUNTS_LIST, 'sub_items3' => []];
        $nav_items2[] = ['href' => 'accounts.php?op=new', 'icon' => '<i class="fa fa-plus-square fa-fw fa-lg"></i>', 'label' => \_MA_WGSIMPLEACC_ACCOUNT_SUBMIT, 'sub_items3' => []];
        $nav_items1[] = ['href' => '#', 'icon' => '<i class="fa fa-table fa-fw fa-lg"></i>', 'label' => \_MA_WGSIMPLEACC_ACCOUNTS, 'sub_items2' => $nav_items2];
    } else {
        $nav_items1[] = ['href' => 'accounts.php', 'icon' => '<i class="fa fa-table fa-fw fa-lg"></i>', 'label' => \_MA_WGSIMPLEACC_ACCOUNTS_LIST];
    }
}
if ($permissionsHandler->getPermAssetsView()) {
    $nav_items2 = [];
    if ($permissionsHandler->getPermAssetsSubmit()) {
        $nav_items2[] = ['href' => 'assets.php?op=list', 'icon' => '<i class="fa fa-list-ol fa-fw fa-lg"></i>','label' => \_MA_WGSIMPLEACC_ASSETS_LIST, 'sub_items3' => []];
        $nav_items2[] = ['href' => 'assets.php?op=new', 'icon' => '<i class="fa fa-plus-square fa-fw fa-lg"></i>', 'label' => \_MA_WGSIMPLEACC_ASSET_SUBMIT, 'sub_items3' => []];
        $nav_items1[] = ['href' => '#', 'icon' => '<i class="fa fa-credit-card fa-fw fa-lg"></i>', 'label' => \_MA_WGSIMPLEACC_ASSETS, 'sub_items2' => $nav_items2];
    } else {
        $nav_items1[] = ['href' => 'assets.php', 'icon' => '<i class="fa fa-credit-card fa-fw fa-lg"></i>', 'label' => \_MA_WGSIMPLEACC_ASSETS_LIST];
    }
}
if ($permissionsHandler->getPermTratemplatesView() || $permissionsHandler->getPermOuttemplatesView()) {
    $nav_items2 = [];
    $nav_items3 = [];
    if ($permissionsHandler->getPermTratemplatesSubmit()) {
        $nav_items3[] = ['href' => 'tratemplates.php?op=list', 'icon' => '<i class="fa fa-list-ol fa-fw fa-lg"></i>','label' => \_MA_WGSIMPLEACC_TRATEMPLATES_LIST, 'sub_items4' => []];
        $nav_items3[] = ['href' => 'tratemplates.php?op=new', 'icon' => '<i class="fa fa-plus-square fa-fw fa-lg"></i>', 'label' => \_MA_WGSIMPLEACC_TRATEMPLATE_SUBMIT, 'sub_items4' => []];
        $nav_items2[] = ['href' => '#', 'icon' => '<i class="fa fa-paste fa-fw fa-lg"></i>', 'label' => \_MA_WGSIMPLEACC_TRATEMPLATES, 'sub_items3' => $nav_items3];
    } else {
        $nav_items2[] = ['href' => 'tratemplates.php', 'icon' => '<i class="fa fa-paste fa-fw fa-lg"></i>', 'label' => \_MA_WGSIMPLEACC_TRATEMPLATES, 'sub_items3' => $nav_items3];
    }
    $nav_items3 = [];
    if ($permissionsHandler->getPermOuttemplatesSubmit()) {
        $nav_items3[] = ['href' => 'outtemplates.php?op=list', 'icon' => '<i class="fa fa-list-ol fa-fw fa-lg"></i>','label' => \_MA_WGSIMPLEACC_OUTTEMPLATES_LIST, 'sub_items4' => []];
        $nav_items3[] = ['href' => 'outtemplates.php?op=new', 'icon' => '<i class="fa fa-plus-square fa-fw fa-lg"></i>', 'label' => \_MA_WGSIMPLEACC_OUTTEMPLATE_SUBMIT, 'sub_items4' => []];
        $nav_items2[] = ['href' => '#', 'icon' => '<i class="fa fa-paste fa-fw fa-lg"></i>', 'label' => \_MA_WGSIMPLEACC_OUTTEMPLATES, 'sub_items3' => $nav_items3];
    } else {
        $nav_items2[] = ['href' => 'outtemplates.php', 'icon' => '<i class="fa fa-paste fa-fw fa-lg"></i>', 'label' => \_MA_WGSIMPLEACC_OUTTEMPLATES, 'sub_items3' => $nav_items3];
    }
    $nav_items1[] = ['href' => '#', 'icon' => '<i class="fa fa-paste fa-fw fa-lg"></i>', 'label' => \_MA_WGSIMPLEACC_TEMPLATES, 'sub_items2' => $nav_items2];
}
if ($permissionsHandler->getPermBalancesView()) {
    $nav_items2 = [];
    if ($permissionsHandler->getPermBalancesSubmit()) {
        $nav_items2[] = ['href' => 'balances.php?op=list', 'icon' => '<i class="fa fa-list-ol fa-fw fa-lg"></i>','label' => \_MA_WGSIMPLEACC_BALANCES_LIST, 'sub_items3' => []];
        $nav_items2[] = ['href' => 'balances.php?op=new', 'icon' => '<i class="fa fa-plus-square fa-fw fa-lg"></i>', 'label' => \_MA_WGSIMPLEACC_BALANCE_SUBMIT, 'sub_items3' => []];
        $nav_items1[] = ['href' => '#', 'icon' => '<i class="fa fa-tasks fa-fw fa-lg"></i>', 'label' => \_MA_WGSIMPLEACC_BALANCES, 'sub_items2' => $nav_items2];
    } else {
        $nav_items1[] = ['href' => 'balances.php', 'icon' => '<i class="fa fa-tasks fa-fw fa-lg"></i>', 'label' => \_MA_WGSIMPLEACC_BALANCES_LIST];
    }
}
if ($permissionsHandler->getPermGlobalView()) {
    $nav_items2 = [];
    $nav_items3 = [];
    if ($permissionsHandler->getPermTransactionsView()) {
        $nav_items2[] = ['href' => 'statistics.php?op=allocations', 'icon' => '<i class="fa fa-table fa-fw fa-lg"></i>', 'label' => \_MA_WGSIMPLEACC_ALLOCATIONS, 'sub_items3' => []];
        $nav_items2[] = ['href' => 'statistics.php?op=assets', 'icon' => '<i class="fa fa-credit-card fa-fw fa-lg"></i>', 'label' => \_MA_WGSIMPLEACC_ASSETS, 'sub_items3' => []];

        $nav_items3[] = ['href' => 'statistics.php?op=accounts', 'icon' => '<i class="fa fa-credit-card fa-fw fa-lg"></i>', 'label' => \_MA_WGSIMPLEACC_ACCOUNTS_LINECHART, 'sub_items4' => []];
        $nav_items3[] = ['href' => 'statistics.php?op=hbar_accounts', 'icon' => '<i class="fa fa-credit-card fa-fw fa-lg"></i>', 'label' => \_MA_WGSIMPLEACC_ACCOUNTS_BARCHART, 'sub_items4' => []];
        $nav_items2[] = ['href' => '#', 'icon' => '<i class="fa fa-credit-card fa-fw fa-lg"></i>', 'label' => \_MA_WGSIMPLEACC_ACCOUNTS, 'sub_items3' => $nav_items3];
    }
    if ($permissionsHandler->getPermBalancesView()) {
        $nav_items2[] = ['href' => 'statistics.php?op=balances', 'icon' => '<i class="fa fa-tasks fa-fw fa-lg"></i>', 'label' => \_MA_WGSIMPLEACC_BALANCES, 'sub_items3' => []];
    }
    if ($permissionsHandler->getPermTransactionsView() || $permissionsHandler->getPermBalancesView()) {
        $nav_items1[] = ['href' => '#', 'icon' => '<i class="fa fa-bar-chart-o fa-fw fa-lg"></i>', 'label' => \_MA_WGSIMPLEACC_STATISTICS, 'sub_items2' => $nav_items2];
    }
}
if ($permissionsHandler->getPermGlobalView()) {
    $nav_items2 = [];
    if ($permissionsHandler->getPermTransactionsView()) {
        $nav_items2[] = ['href' => 'outputs.php?op=transactions', 'icon' => '<i class="fa fa-files-o fa-fw fa-lg"></i>', 'label' => \_MA_WGSIMPLEACC_TRANSACTIONS_LIST, 'sub_items3' => []];
    }
    if ($permissionsHandler->getPermBalancesView()) {
        $nav_items2[] = ['href' => 'outputs.php?op=balances', 'icon' => '<i class="fa fa-tasks fa-fw fa-lg"></i>', 'label' => \_MA_WGSIMPLEACC_BALANCES, 'sub_items3' => []];
    }
    if ($permissionsHandler->getPermTransactionsView() || $permissionsHandler->getPermBalancesView()) {
        $nav_items1[] = ['href' => '#', 'icon' => '<i class="fa fa-download fa-fw fa-lg"></i>', 'label' => \_MA_WGSIMPLEACC_OUTPUTS, 'sub_items2' => $nav_items2];
    }
}

$GLOBALS['xoopsTpl']->assign('nav_items1', $nav_items1);
