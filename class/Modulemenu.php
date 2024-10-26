<?php

namespace XoopsModules\Wgsimpleacc;

/*
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * @copyright    XOOPS Project https://xoops.org/
 * @license      GNU GPL 2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 * @author       Goffy - XOOPS Development Team
 */
//\defined('\XOOPS_ROOT_PATH') || die('Restricted access');

/**
 * Class Modulemenu
 */
class Modulemenu
{

    /** function to create an array for XOOPS main menu
     *
     * @return array
     */
    public function getMenuitemsDefault()
    {

        $moduleDirName = \basename(\dirname(__DIR__));
        $subcount      = 1;
        $pathname      = \XOOPS_ROOT_PATH . '/modules/' . $moduleDirName . '/';
        $urlModule     = \XOOPS_URL . '/modules/' . $moduleDirName . '/';

        require_once $pathname . 'include/common.php';
        $helper = \XoopsModules\Wgsimpleacc\Helper::getInstance();

        //load necesaary language files from this module
        $helper->loadLanguage('common');
        $helper->loadLanguage('main');

        // start creation of link list as array
        $items = [];
        $items[$subcount]['name']  = \_MA_WGSIMPLEACC_DASHBOARD;
        $items[$subcount]['url'] =  $urlModule . 'index.php';

        $permissionsHandler = $helper->getHandler('Permissions');
        if ($permissionsHandler->getPermTransactionsView()) {
            $subcount++;
            $items[$subcount]['name']  = \_MA_WGSIMPLEACC_TRANSACTIONS_LIST;
            $items[$subcount]['url'] =  $urlModule . 'transactions.php?op=list';
            if ($permissionsHandler->getPermTransactionsSubmit()) {
                $subcount++;
                $items[$subcount]['name']  = \_MA_WGSIMPLEACC_TRANSACTION_SUBMIT_INCOME;
                $items[$subcount]['url'] =  $urlModule . 'transactions.php?op=new&tra_type=3';
                $subcount++;
                $items[$subcount]['name']  = \_MA_WGSIMPLEACC_TRANSACTION_SUBMIT_EXPENSE;
                $items[$subcount]['url'] =  $urlModule . 'transactions.php?op=new&tra_type=2';
                if ($permissionsHandler->getPermTransactionsApprove()) {
                    $subcount++;
                    $items[$subcount]['name']  = \_MA_WGSIMPLEACC_TRAHISTORY_DELETED;
                    $items[$subcount]['url'] =  $urlModule . 'transactions.php?op=listhist';
                }
            }
        }
        if ($permissionsHandler->getPermClientsView() && $helper->getConfig('use_clients')) {
            $subcount++;
            $items[$subcount]['name']  = \_MA_WGSIMPLEACC_CLIENTS_LIST;
            $items[$subcount]['url'] =  $urlModule . 'clients.php?op=list';
            if ($permissionsHandler->getPermClientsSubmit()) {
                $subcount++;
                $items[$subcount]['name']  = \_MA_WGSIMPLEACC_CLIENT_SUBMIT;
                $items[$subcount]['url'] =  $urlModule . 'clients.php?op=new';
            }
        }
        if ($permissionsHandler->getPermAllocationsView()) {
            $subcount++;
            $items[$subcount]['name']  = \_MA_WGSIMPLEACC_ALLOCATIONS_LIST;
            $items[$subcount]['url'] =  $urlModule . 'allocations.php?op=list';
            if ($permissionsHandler->getPermAllocationsSubmit()) {
                if ((bool)$helper->getConfig('use_cascadingacc')) {
                    $subcount++;
                    $items[$subcount]['name']  = \_MA_WGSIMPLEACC_ALLOCATION_ACCOUNTS_COMPARE;
                    $items[$subcount]['url'] =  $urlModule . 'allocations.php?op=compare_accounts';
                }
                $subcount++;
                $items[$subcount]['name']  = \_MA_WGSIMPLEACC_ALLOCATION_SUBMIT;
                $items[$subcount]['url'] =  $urlModule . 'allocations.php?op=new';
            }
        }
        if ($permissionsHandler->getPermAccountsView()) {
            $subcount++;
            $items[$subcount]['name']  = \_MA_WGSIMPLEACC_ACCOUNTS_LIST;
            $items[$subcount]['url'] =  $urlModule . 'accounts.php?op=list';
            if ($permissionsHandler->getPermAccountsSubmit()) {
                if ((bool)$helper->getConfig('use_cascadingacc')) {
                    $subcount++;
                    $items[$subcount]['name']  = \_MA_WGSIMPLEACC_ALLOCATION_ACCOUNTS_COMPARE;
                    $items[$subcount]['url'] =  $urlModule . 'accounts.php?op=compare_alloc';
                }
                $subcount++;
                $items[$subcount]['name']  = \_MA_WGSIMPLEACC_ACCOUNT_SUBMIT;
                $items[$subcount]['url'] =  $urlModule . 'accounts.php?op=new';
            }
        }
        if ($permissionsHandler->getPermAssetsView()) {
            $subcount++;
            $items[$subcount]['name']  = \_MA_WGSIMPLEACC_ASSETS_LIST;
            $items[$subcount]['url'] =  $urlModule . 'assets.php?op=list';
            if ($permissionsHandler->getPermAssetsSubmit()) {
                $subcount++;
                $items[$subcount]['name']  = \_MA_WGSIMPLEACC_ASSET_SUBMIT;
                $items[$subcount]['url'] =  $urlModule . 'assets.php?op=new';
            }
        }
        if ($permissionsHandler->getPermTratemplatesView() || $permissionsHandler->getPermOuttemplatesView()) {
            $subcount++;
            $items[$subcount]['name']  = \_MA_WGSIMPLEACC_TRATEMPLATES_LIST;
            $items[$subcount]['url'] =  $urlModule . 'tratemplates.php?op=list';
            if ($permissionsHandler->getPermTratemplatesSubmit()) {
                $subcount++;
                $items[$subcount]['name']  = \_MA_WGSIMPLEACC_TRATEMPLATE_SUBMIT;
                $items[$subcount]['url'] =  $urlModule . 'tratemplates.php?op=new';
            }
            $subcount++;
            $items[$subcount]['name']  = \_MA_WGSIMPLEACC_OUTTEMPLATES_LIST;
            $items[$subcount]['url'] =  $urlModule . 'outtemplates.php?op=list';
            if ($permissionsHandler->getPermOuttemplatesSubmit()) {
                $subcount++;
                $items[$subcount]['name']  = \_MA_WGSIMPLEACC_OUTTEMPLATE_SUBMIT;
                $items[$subcount]['url'] =  $urlModule . 'outtemplates.php?op=new';
            }
        }
        if ($permissionsHandler->getPermBalancesView()) {
            $subcount++;
            $items[$subcount]['name']  = \_MA_WGSIMPLEACC_BALANCES_LIST;
            $items[$subcount]['url'] =  $urlModule . 'balances.php?op=list';
            if ($permissionsHandler->getPermBalancesSubmit()) {
                $subcount++;
                $items[$subcount]['name']  = \_MA_WGSIMPLEACC_BALANCE_SUBMIT;
                $items[$subcount]['url'] =  $urlModule . 'balances.php?op=new';
            }
        }
        if ($permissionsHandler->getPermGlobalView()) {
            if ($permissionsHandler->getPermTransactionsView()) {
                $subcount++;
                $items[$subcount]['name']  = \_MA_WGSIMPLEACC_STATISTICS . ' ' . \_MA_WGSIMPLEACC_ALLOCATIONS;
                $items[$subcount]['url'] =  $urlModule . 'statistics.php?op=allocations';
                $subcount++;
                $items[$subcount]['name']  = \_MA_WGSIMPLEACC_STATISTICS . ' ' . \_MA_WGSIMPLEACC_ASSETS;
                $items[$subcount]['url'] =  $urlModule . 'statistics.php?op=assets';
                $subcount++;
                $items[$subcount]['name']  = \_MA_WGSIMPLEACC_STATISTICS . ' ' . \_MA_WGSIMPLEACC_ACCOUNTS_LINECHART;
                $items[$subcount]['url'] =  $urlModule . 'statistics.php?op=accounts';
                $subcount++;
                $items[$subcount]['name']  = \_MA_WGSIMPLEACC_STATISTICS . ' ' . \_MA_WGSIMPLEACC_ACCOUNTS_BARCHART;
                $items[$subcount]['url'] =  $urlModule . 'statistics.php?op=hbar_accounts';
            }
            if ($permissionsHandler->getPermBalancesView()) {
                $subcount++;
                $items[$subcount]['name']  = \_MA_WGSIMPLEACC_STATISTICS . ' ' . \_MA_WGSIMPLEACC_BALANCES;
                $items[$subcount]['url'] =  $urlModule . 'statistics.php?op=balances';
            }
        }
        if ($permissionsHandler->getPermFileDirView()) {
            $subcount++;
            $items[$subcount]['name']  = \_MA_WGSIMPLEACC_FILES_LIST;
            $items[$subcount]['url'] =  $urlModule . 'files.php?op=list';
            if ($permissionsHandler->getPermFileDirSubmit()) {
                $subcount++;
                $items[$subcount]['name']  = \_MA_WGSIMPLEACC_FILE_ADD;
                $items[$subcount]['url'] =  $urlModule . 'files.php?op=filedir_new';
            }
        }
        if ($permissionsHandler->getPermGlobalView()) {
            $nav_items2 = [];
            if ($permissionsHandler->getPermTransactionsView()) {
                $subcount++;
                $items[$subcount]['name']  = \_MA_WGSIMPLEACC_OUTPUTS . ' ' . \_MA_WGSIMPLEACC_TRANSACTIONS_LIST;
                $items[$subcount]['url'] =  $urlModule . 'outputs.php?op=transactions';
            }
            if ($permissionsHandler->getPermBalancesView()) {
                $subcount++;
                $items[$subcount]['name']  = \_MA_WGSIMPLEACC_OUTPUTS . ' ' . \_MA_WGSIMPLEACC_BALANCES;
                $items[$subcount]['url'] =  $urlModule . 'outputs.php?op=balances';
            }
        }
        // end creation of link list as array

        return $items;
    }

    /** function to create a list of nested sublinks
     *
     * @return array
     */
    public function getMenuitemsStartmin()
    {
        $moduleDirName = \basename(\dirname(__DIR__));
        $subcount      = 1;
        $pathname      = \XOOPS_ROOT_PATH . '/modules/' . $moduleDirName . '/';

        require_once $pathname . 'include/common.php';
        $helper = \XoopsModules\Wgsimpleacc\Helper::getInstance();
        $helper->loadLanguage('common');
        $helper->loadLanguage('main');

        $permissionsHandler = $helper->getHandler('Permissions');

        /*read navbar items related to perms of current user*/
        $nav_items1 = [];
        $nav_items1[] = ['href' => 'index.php', 'aclass' => 'active', 'icon' => '<i class="fa fa-dashboard fa-tachometer-alt fa-fw fa-lg"></i>', 'label' => \_MA_WGSIMPLEACC_DASHBOARD];
        if ($permissionsHandler->getPermTransactionsView()) {
            $nav_items2 = [];
            if ($permissionsHandler->getPermTransactionsSubmit()) {
                $nav_items2[] = ['href' => 'transactions.php?op=list', 'icon' => '<i class="fa fa-list-ol fa-fw fa-lg"></i>', 'label' => \_MA_WGSIMPLEACC_TRANSACTIONS_LIST, 'sub_items3' => []];
                $nav_items2[] = ['href' => 'transactions.php?op=new&tra_type=3', 'icon' => '<i class="fa fa-plus-square fa-fw fa-lg"></i>', 'label' => \_MA_WGSIMPLEACC_TRANSACTION_SUBMIT_INCOME, 'sub_items3' => []];
                $nav_items2[] = ['href' => 'transactions.php?op=new&tra_type=2', 'icon' => '<i class="fa fa-plus-square fa-fw fa-lg"></i>', 'label' => \_MA_WGSIMPLEACC_TRANSACTION_SUBMIT_EXPENSE, 'sub_items3' => []];
                if ($permissionsHandler->getPermTransactionsApprove()) {
                    $nav_items2[] = ['href' => 'transactions.php?op=listhist', 'icon' => '<i class="fa fa-trash fa-fw fa-lg"></i>', 'label' => \_MA_WGSIMPLEACC_TRAHISTORY_DELETED, 'sub_items3' => []];
                }
                $nav_items1[] = ['href' => '#', 'icon' => '<i class="fa fa-money fa-fw fa-lg"></i>', 'label' => \_MA_WGSIMPLEACC_TRANSACTIONS, 'sublinks' => $nav_items2];
            } else {
                $nav_items1[] = ['href' => 'transactions.php', 'icon' => '<i class="fa fa-money fa-fw fa-lg"></i>', 'label' => \_MA_WGSIMPLEACC_TRANSACTIONS_LIST];
            }
        }

        if ($permissionsHandler->getPermClientsView() && $helper->getConfig('use_clients')) {
            $nav_items2 = [];
            if ($permissionsHandler->getPermClientsSubmit()) {
                $nav_items2[] = ['href' => 'clients.php?op=list', 'icon' => '<i class="fa fa-list-ol fa-fw fa-lg"></i>', 'label' => \_MA_WGSIMPLEACC_CLIENTS_LIST, 'sub_items3' => []];
                $nav_items2[] = ['href' => 'clients.php?op=new', 'icon' => '<i class="fa fa-plus-square fa-fw fa-lg"></i>', 'label' => \_MA_WGSIMPLEACC_CLIENT_SUBMIT, 'sub_items3' => []];
                $nav_items1[] = ['href' => '#', 'icon' => '<i class="fa fa-users fa-fw fa-lg"></i>', 'label' => \_MA_WGSIMPLEACC_CLIENTS, 'sublinks' => $nav_items2];
            } else {
                $nav_items1[] = ['href' => 'clients.php', 'icon' => '<i class="fa fa-users fa-fw fa-lg"></i>', 'label' => \_MA_WGSIMPLEACC_CLIENTS_LIST];
            }
        }
        if ($permissionsHandler->getPermAllocationsView()) {
            $nav_items2 = [];
            if ($permissionsHandler->getPermAllocationsSubmit()) {
                $nav_items2[] = ['href' => 'allocations.php?op=list', 'icon' => '<i class="fa fa-list-ol fa-fw fa-lg"></i>', 'label' => \_MA_WGSIMPLEACC_ALLOCATIONS_LIST, 'sub_items3' => []];
                if ((bool)$helper->getConfig('use_cascadingacc')) {
                    $nav_items2[] = ['href' => 'allocations.php?op=compare_accounts', 'icon' => '<i class="fa fa-link fa-fw fa-lg"></i>', 'label' => \_MA_WGSIMPLEACC_ALLOCATION_ACCOUNTS_COMPARE, 'sub_items3' => []];
                }
                $nav_items2[] = ['href' => 'allocations.php?op=new', 'icon' => '<i class="fa fa-plus-square fa-fw fa-lg"></i>', 'label' => \_MA_WGSIMPLEACC_ALLOCATION_SUBMIT, 'sub_items3' => []];
                $nav_items1[] = ['href' => '#', 'icon' => '<i class="fa fa-sitemap fa-fw fa-lg"></i>', 'label' => \_MA_WGSIMPLEACC_ALLOCATIONS, 'sublinks' => $nav_items2];
            } else {
                $nav_items1[] = ['href' => 'allocations.php', 'icon' => '<i class="fa fa-sitemap fa-fw fa-lg"></i>', 'label' => \_MA_WGSIMPLEACC_ALLOCATIONS_LIST];
            }
        }
        if ($permissionsHandler->getPermAccountsView()) {
            $nav_items2 = [];
            if ($permissionsHandler->getPermAccountsSubmit()) {
                $nav_items2[] = ['href' => 'accounts.php?op=list', 'icon' => '<i class="fa fa-list-ol fa-fw fa-lg"></i>', 'label' => \_MA_WGSIMPLEACC_ACCOUNTS_LIST, 'sub_items3' => []];
                if ((bool)$helper->getConfig('use_cascadingacc')) {
                    $nav_items2[] = ['href' => 'accounts.php?op=compare_alloc', 'icon' => '<i class="fa fa-link fa-fw fa-lg"></i>', 'label' => \_MA_WGSIMPLEACC_ALLOCATION_ACCOUNTS_COMPARE, 'sub_items3' => []];
                }
                $nav_items2[] = ['href' => 'accounts.php?op=new', 'icon' => '<i class="fa fa-plus-square fa-fw fa-lg"></i>', 'label' => \_MA_WGSIMPLEACC_ACCOUNT_SUBMIT, 'sub_items3' => []];
                $nav_items1[] = ['href' => '#', 'icon' => '<i class="fa fa-table fa-fw fa-lg"></i>', 'label' => \_MA_WGSIMPLEACC_ACCOUNTS, 'sublinks' => $nav_items2];
            } else {
                $nav_items1[] = ['href' => 'accounts.php', 'icon' => '<i class="fa fa-table fa-fw fa-lg"></i>', 'label' => \_MA_WGSIMPLEACC_ACCOUNTS_LIST];
            }
        }
        if ($permissionsHandler->getPermAssetsView()) {
            $nav_items2 = [];
            if ($permissionsHandler->getPermAssetsSubmit()) {
                $nav_items2[] = ['href' => 'assets.php?op=list', 'icon' => '<i class="fa fa-list-ol fa-fw fa-lg"></i>', 'label' => \_MA_WGSIMPLEACC_ASSETS_LIST, 'sub_items3' => []];
                $nav_items2[] = ['href' => 'assets.php?op=new', 'icon' => '<i class="fa fa-plus-square fa-fw fa-lg"></i>', 'label' => \_MA_WGSIMPLEACC_ASSET_SUBMIT, 'sub_items3' => []];
                $nav_items1[] = ['href' => '#', 'icon' => '<i class="fa fa-credit-card fa-fw fa-lg"></i>', 'label' => \_MA_WGSIMPLEACC_ASSETS, 'sublinks' => $nav_items2];
            } else {
                $nav_items1[] = ['href' => 'assets.php', 'icon' => '<i class="fa fa-credit-card fa-fw fa-lg"></i>', 'label' => \_MA_WGSIMPLEACC_ASSETS_LIST];
            }
        }
        if ($permissionsHandler->getPermTratemplatesView() || $permissionsHandler->getPermOuttemplatesView()) {
            $nav_items2 = [];
            $nav_items3 = [];
            if ($permissionsHandler->getPermTratemplatesSubmit()) {
                $nav_items3[] = ['href' => 'tratemplates.php?op=list', 'icon' => '<i class="fa fa-list-ol fa-fw fa-lg"></i>', 'label' => \_MA_WGSIMPLEACC_TRATEMPLATES_LIST, 'sub_items4' => []];
                $nav_items3[] = ['href' => 'tratemplates.php?op=new', 'icon' => '<i class="fa fa-plus-square fa-fw fa-lg"></i>', 'label' => \_MA_WGSIMPLEACC_TRATEMPLATE_SUBMIT, 'sub_items4' => []];
                $nav_items2[] = ['href' => '#', 'icon' => '<i class="fa fa-paste fa-fw fa-lg"></i>', 'label' => \_MA_WGSIMPLEACC_TRATEMPLATES, 'sub_items3' => $nav_items3];
            } else {
                $nav_items2[] = ['href' => 'tratemplates.php', 'icon' => '<i class="fa fa-paste fa-fw fa-lg"></i>', 'label' => \_MA_WGSIMPLEACC_TRATEMPLATES, 'sub_items3' => $nav_items3];
            }
            $nav_items3 = [];
            if ($permissionsHandler->getPermOuttemplatesSubmit()) {
                $nav_items3[] = ['href' => 'outtemplates.php?op=list', 'icon' => '<i class="fa fa-list-ol fa-fw fa-lg"></i>', 'label' => \_MA_WGSIMPLEACC_OUTTEMPLATES_LIST, 'sub_items4' => []];
                $nav_items3[] = ['href' => 'outtemplates.php?op=new', 'icon' => '<i class="fa fa-plus-square fa-fw fa-lg"></i>', 'label' => \_MA_WGSIMPLEACC_OUTTEMPLATE_SUBMIT, 'sub_items4' => []];
                $nav_items2[] = ['href' => '#', 'icon' => '<i class="fa fa-paste fa-fw fa-lg"></i>', 'label' => \_MA_WGSIMPLEACC_OUTTEMPLATES, 'sub_items3' => $nav_items3];
            } else {
                $nav_items2[] = ['href' => 'outtemplates.php', 'icon' => '<i class="fa fa-paste fa-fw fa-lg"></i>', 'label' => \_MA_WGSIMPLEACC_OUTTEMPLATES, 'sub_items3' => $nav_items3];
            }
            $nav_items1[] = ['href' => '#', 'icon' => '<i class="fa fa-paste fa-fw fa-lg"></i>', 'label' => \_MA_WGSIMPLEACC_TEMPLATES, 'sublinks' => $nav_items2];
        }
        if ($permissionsHandler->getPermBalancesView()) {
            $nav_items2 = [];
            if ($permissionsHandler->getPermBalancesSubmit()) {
                $nav_items2[] = ['href' => 'balances.php?op=list', 'icon' => '<i class="fa fa-list-ol fa-fw fa-lg"></i>', 'label' => \_MA_WGSIMPLEACC_BALANCES_LIST, 'sub_items3' => []];
                $nav_items2[] = ['href' => 'balances.php?op=new', 'icon' => '<i class="fa fa-plus-square fa-fw fa-lg"></i>', 'label' => \_MA_WGSIMPLEACC_BALANCE_SUBMIT, 'sub_items3' => []];
                $nav_items1[] = ['href' => '#', 'icon' => '<i class="fa fa-tasks fa-fw fa-lg"></i>', 'label' => \_MA_WGSIMPLEACC_BALANCES, 'sublinks' => $nav_items2];
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
                $nav_items1[] = ['href' => '#', 'icon' => '<i class="fa fa-bar-chart-o fa-fw fa-lg"></i>', 'label' => \_MA_WGSIMPLEACC_STATISTICS, 'sublinks' => $nav_items2];
            }
        }
        if ($permissionsHandler->getPermFileDirView()) {
            $nav_items2 = [];
            if ($permissionsHandler->getPermFileDirSubmit()) {
                $nav_items2[] = ['href' => 'files.php?op=filedir_list', 'icon' => '<i class="fa fa-list-ol fa-fw fa-lg"></i>', 'label' => \_MA_WGSIMPLEACC_FILES_LIST, 'sub_items3' => []];
                $nav_items2[] = ['href' => 'files.php?op=filedir_new', 'icon' => '<i class="fa fa-plus-square fa-fw fa-lg"></i>', 'label' => \_MA_WGSIMPLEACC_FILE_ADD, 'sub_items3' => []];
                $nav_items1[] = ['href' => '#', 'icon' => '<i class="fa fa-files-o fa-fw fa-lg"></i>', 'label' => \_MA_WGSIMPLEACC_FILES, 'sublinks' => $nav_items2];
            } else {
                $nav_items1[] = ['href' => 'files.php?op=filedir_list', 'icon' => '<i class="fa fa-files-o fa-fw fa-lg"></i>', 'label' => \_MA_WGSIMPLEACC_FILES_LIST];
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
                $nav_items1[] = ['href' => '#', 'icon' => '<i class="fa fa-download fa-fw fa-lg"></i>', 'label' => \_MA_WGSIMPLEACC_OUTPUTS, 'sublinks' => $nav_items2];
            }
        }

        return $nav_items1;
    }


    /** function to create a list of nested sublinks
     *
     * @return array
     */
    public function getMenuitemsSbadmin5()
    {
        $moduleDirName = \basename(\dirname(__DIR__));
        $pathname      = \XOOPS_ROOT_PATH . '/modules/' . $moduleDirName . '/';
        $urlModule     = \XOOPS_URL . '/modules/' . $moduleDirName . '/';

        require_once $pathname . 'include/common.php';
        $helper = \XoopsModules\Wgsimpleacc\Helper::getInstance();

        //load necessary language files from this module
        $helper->loadLanguage('common');
        $helper->loadLanguage('main');

        // start creation of link list as array
        $permissionsHandler = $helper->getHandler('Permissions');

        $requestUri = $_SERVER['REQUEST_URI'];
        /*read navbar items related to perms of current user*/
        $nav_items1 = [];
        $nav_items1[] = [
            'highlight' => strpos($requestUri, $moduleDirName . '/index.php') > 0,
            'url' => $urlModule . 'index.php',
            'icon' => '<i class="fa fa-tachometer fa-fw fa-lg"></i>',
            'name' => \_MA_WGSIMPLEACC_DASHBOARD,
            'sublinks' => []
        ];

        if ($permissionsHandler->getPermTransactionsView()) {
            $nav_items2 = [];
            if ($permissionsHandler->getPermTransactionsSubmit()) {
                $nav_items2[] = [
                    'highlight' => strpos($requestUri, $moduleDirName . '/transactions.php?op=list') > 0,
                    'url' => $urlModule . 'transactions.php?op=list',
                    'icon' => '<i class="fa fa-list-ol fa-fw fa-lg"></i>',
                    'name' => \_MA_WGSIMPLEACC_TRANSACTIONS_LIST,
                    'sublinks' => []
                ];
                $nav_items2[] = [
                    'highlight' => strpos($requestUri, $moduleDirName . '/transactions.php?op=new&tra_type=3') > 0,
                    'url' => $urlModule . 'transactions.php?op=new&tra_type=3',
                    'icon' => '<i class="fa fa-plus-square fa-fw fa-lg"></i>',
                    'name' => \_MA_WGSIMPLEACC_TRANSACTION_SUBMIT_INCOME,
                    'sublinks' => []
                ];
                $nav_items2[] = [
                    'highlight' => strpos($requestUri, $moduleDirName . '/transactions.php?op=new&tra_type=2') > 0,
                    'url' => $urlModule . 'transactions.php?op=new&tra_type=2',
                    'icon' => '<i class="fa fa-plus-square fa-fw fa-lg"></i>',
                    'name' => \_MA_WGSIMPLEACC_TRANSACTION_SUBMIT_EXPENSE,
                    'sublinks' => []
                ];
                if ($permissionsHandler->getPermTransactionsApprove()) {
                    $nav_items2[] = [
                        'highlight' => strpos($requestUri, $moduleDirName . '/transactions.php?op=listhist') > 0,
                        'url' => $urlModule . 'transactions.php?op=listhist',
                        'icon' => '<i class="fa fa-trash fa-fw fa-lg"></i>',
                        'name' => \_MA_WGSIMPLEACC_TRAHISTORY_DELETED,
                        'sublinks' => []
                    ];
                }
                $nav_items1[] = [
                    'highlight' => strpos($requestUri, 'transactions.php') > 0,
                    'url' => '#',
                    'icon' => '<i class="fa fa-money fa-fw fa-lg"></i>',
                    'name' => \_MA_WGSIMPLEACC_TRANSACTIONS,
                    'sublinks' => $nav_items2
                ];
            } else {
                $nav_items1[] = [
                    'highlight' => strpos($requestUri, 'transactions.php') > 0,
                    'url' => $urlModule . 'transactions.php',
                    'icon' => '<i class="fa fa-money fa-fw fa-lg"></i>',
                    'name' => \_MA_WGSIMPLEACC_TRANSACTIONS_LIST,
                    'sublinks' => []
                ];
            }
        }

        if ($permissionsHandler->getPermClientsView() && $helper->getConfig('use_clients')) {
            $nav_items2 = [];
            if ($permissionsHandler->getPermClientsSubmit()) {
                $nav_items2[] = [
                    'highlight' => strpos($requestUri, 'clients.php?op=list') > 0,
                    'url' => $urlModule . 'clients.php?op=list',
                    'icon' => '<i class="fa fa-list-ol fa-fw fa-lg"></i>',
                    'name' => \_MA_WGSIMPLEACC_CLIENTS_LIST,
                    'sublinks' => []
                ];
                $nav_items2[] = [
                    'highlight' => strpos($requestUri, 'clients.php?op=new') > 0,
                    'url' => $urlModule . 'clients.php?op=new',
                    'icon' => '<i class="fa fa-plus-square fa-fw fa-lg"></i>',
                    'name' => \_MA_WGSIMPLEACC_CLIENT_SUBMIT,
                    'sublinks' => []
                ];
                $nav_items1[] = [
                    'highlight' => strpos($requestUri, 'clients.php') > 0,
                    'url' => '#',
                    'icon' => '<i class="fa fa-users fa-fw fa-lg"></i>',
                    'name' => \_MA_WGSIMPLEACC_CLIENTS,
                    'sublinks' => $nav_items2,
                ];
            } else {
                $nav_items1[] = [
                    'highlight' => strpos($requestUri, 'clients.php') > 0,
                    'url' => $urlModule . 'clients.php',
                    'icon' => '<i class="fa fa-users fa-fw fa-lg"></i>',
                    'name' => \_MA_WGSIMPLEACC_CLIENTS_LIST,
                    'sublinks' => []
                ];
            }
        }

        if ($permissionsHandler->getPermAllocationsView()) {
            $nav_items2 = [];
            if ($permissionsHandler->getPermAllocationsSubmit()) {
                $nav_items2[] = [
                    'highlight' => strpos($requestUri, 'allocations.php?op=list') > 0,
                    'url' => $urlModule . 'allocations.php?op=list',
                    'icon' => '<i class="fa fa-list-ol fa-fw fa-lg"></i>',
                    'name' => \_MA_WGSIMPLEACC_ALLOCATIONS_LIST,
                    'sublinks' => []
                ];
                if ((bool)$helper->getConfig('use_cascadingacc')) {
                    $nav_items2[] = [
                        'highlight' => strpos($requestUri, 'allocations.php?op=compare_accounts') > 0,
                        'url' => $urlModule . 'allocations.php?op=compare_accounts',
                        'icon' => '<i class="fa fa-link fa-fw fa-lg"></i>',
                        'name' => \_MA_WGSIMPLEACC_ALLOCATION_ACCOUNTS_COMPARE,
                        'sublinks' => []
                    ];
                }
                $nav_items2[] = [
                    'highlight' => strpos($requestUri, 'allocations.php?op=new') > 0,
                    'url' => $urlModule . 'allocations.php?op=new',
                    'icon' => '<i class="fa fa-plus-square fa-fw fa-lg"></i>',
                    'name' => \_MA_WGSIMPLEACC_ALLOCATION_SUBMIT,
                    'sublinks' => []
                ];
                $nav_items1[] = [
                    'highlight' => strpos($requestUri, 'allocations.php') > 0,
                    'url' => '#',
                    'icon' => '<i class="fa fa-sitemap fa-fw fa-lg"></i>',
                    'name' => \_MA_WGSIMPLEACC_ALLOCATIONS,
                    'sublinks' => $nav_items2
                ];
            } else {
                $nav_items1[] = [
                    'highlight' => strpos($requestUri, 'allocations.php') > 0,
                    'url' => $urlModule . 'allocations.php',
                    'icon' => '<i class="fa fa-sitemap fa-fw fa-lg"></i>',
                    'name' => \_MA_WGSIMPLEACC_ALLOCATIONS_LIST,
                    'sublinks' => []
                ];
            }
        }

        if ($permissionsHandler->getPermAccountsView()) {
            $nav_items2 = [];
            if ($permissionsHandler->getPermAccountsSubmit()) {
                $nav_items2[] = [
                    'highlight' => strpos($requestUri, 'accounts.php?op=list') > 0,
                    'url' => $urlModule . 'accounts.php?op=list',
                    'icon' => '<i class="fa fa-list-ol fa-fw fa-lg"></i>',
                    'name' => \_MA_WGSIMPLEACC_ACCOUNTS_LIST,
                    'sublinks' => []
                ];
                if ((bool)$helper->getConfig('use_cascadingacc')) {
                    $nav_items2[] = [
                        'highlight' => strpos($requestUri, 'accounts.php?op=compare_alloc') > 0,
                        'url' => $urlModule . 'accounts.php?op=compare_alloc',
                        'icon' => '<i class="fa fa-link fa-fw fa-lg"></i>',
                        'name' => \_MA_WGSIMPLEACC_ALLOCATION_ACCOUNTS_COMPARE,
                        'sublinks' => []
                    ];
                }
                $nav_items2[] = [
                    'highlight' => strpos($requestUri, 'accounts.php?op=new') > 0,
                    'url' => $urlModule . 'accounts.php?op=new',
                    'icon' => '<i class="fa fa-plus-square fa-fw fa-lg"></i>',
                    'name' => \_MA_WGSIMPLEACC_ACCOUNT_SUBMIT,
                    'sublinks' => []
                ];
                $nav_items1[] = [
                    'highlight' => strpos($requestUri, 'accounts.php') > 0,
                    'url' => '#',
                    'icon' => '<i class="fa fa-table fa-fw fa-lg"></i>',
                    'name' => \_MA_WGSIMPLEACC_ACCOUNTS,
                    'sublinks' => $nav_items2
                ];
            } else {
                $nav_items1[] = [
                    'highlight' => strpos($requestUri, 'accounts.php') > 0,
                    'url' => $urlModule . 'accounts.php',
                    'icon' => '<i class="fa fa-table fa-fw fa-lg"></i>',
                    'name' => \_MA_WGSIMPLEACC_ACCOUNTS_LIST,
                    'sublinks' => []
                ];
            }
        }
        
        if ($permissionsHandler->getPermAssetsView()) {
            $nav_items2 = [];
            if ($permissionsHandler->getPermAssetsSubmit()) {
                $nav_items2[] = [
                    'highlight' => strpos($requestUri, 'assets.php?op=list') > 0,
                    'url' => $urlModule . 'assets.php?op=list',
                    'icon' => '<i class="fa fa-list-ol fa-fw fa-lg"></i>',
                    'name' => \_MA_WGSIMPLEACC_ASSETS_LIST,
                    'sublinks' => []
                ];
                $nav_items2[] = [
                    'highlight' => strpos($requestUri, 'assets.php?op=new') > 0,
                    'url' => $urlModule . 'assets.php?op=new',
                    'icon' => '<i class="fa fa-plus-square fa-fw fa-lg"></i>',
                    'name' => \_MA_WGSIMPLEACC_ASSET_SUBMIT,
                    'sublinks' => []
                ];
                $nav_items1[] = [
                    'highlight' => strpos($requestUri, 'assets.php') > 0,
                    'url' => '#',
                    'icon' => '<i class="fa fa-credit-card fa-fw fa-lg"></i>',
                    'name' => \_MA_WGSIMPLEACC_ASSETS,
                    'sublinks' => $nav_items2
                ];
            } else {
                $nav_items1[] = [
                    'highlight' => strpos($requestUri, 'assets.php') > 0,
                    'url' => $urlModule . 'assets.php',
                    'icon' => '<i class="fa fa-credit-card fa-fw fa-lg"></i>',
                    'name' => \_MA_WGSIMPLEACC_ASSETS_LIST,
                    'sublinks' => []
                ];
            }
        }

        if ($permissionsHandler->getPermTratemplatesView() || $permissionsHandler->getPermOuttemplatesView()) {
            $nav_items2 = [];
            $nav_items3 = [];
            if ($permissionsHandler->getPermTratemplatesSubmit()) {
                $nav_items3[] = [
                    'highlight' => strpos($requestUri, 'tratemplates.php?op=list') > 0,
                    'url' => $urlModule . 'tratemplates.php?op=list',
                    'icon' => '<i class="fa fa-list-ol fa-fw fa-lg"></i>',
                    'name' => \_MA_WGSIMPLEACC_TRATEMPLATES_LIST,
                    'sublinks' => []
                ];
                $nav_items3[] = [
                    'highlight' => strpos($requestUri, 'tratemplates.php?op=new') > 0,
                    'url' => $urlModule . 'tratemplates.php?op=new',
                    'icon' => '<i class="fa fa-plus-square fa-fw fa-lg"></i>',
                    'name' => \_MA_WGSIMPLEACC_TRATEMPLATE_SUBMIT,
                    'sublinks' => []
                ];
                $nav_items2[] = [
                    'highlight' => strpos($requestUri, 'tratemplates.php') > 0,
                    'url' => '#',
                    'icon' => '<i class="fa fa-paste fa-fw fa-lg"></i>',
                    'name' => \_MA_WGSIMPLEACC_TRATEMPLATES,
                    'sublinks' => $nav_items3
                ];
            } else {
                $nav_items2[] = [
                    'highlight' => strpos($requestUri, 'tratemplates.php') > 0,
                    'url' => $urlModule . 'tratemplates.php',
                    'icon' => '<i class="fa fa-paste fa-fw fa-lg"></i>',
                    'name' => \_MA_WGSIMPLEACC_TRATEMPLATES,
                    'sublinks' => $nav_items3
                ];
            }
            $nav_items3 = [];
            if ($permissionsHandler->getPermOuttemplatesSubmit()) {
                $nav_items3[] = [
                    'highlight' => strpos($requestUri, 'outtemplates.php?op=list') > 0,
                    'url' => $urlModule . 'outtemplates.php?op=list',
                    'icon' => '<i class="fa fa-list-ol fa-fw fa-lg"></i>',
                    'name' => \_MA_WGSIMPLEACC_OUTTEMPLATES_LIST,
                    'sublinks' => []
                ];
                $nav_items3[] = [
                    'highlight' => strpos($requestUri, 'outtemplates.php?op=new') > 0,
                    'url' => $urlModule . 'outtemplates.php?op=new',
                    'icon' => '<i class="fa fa-plus-square fa-fw fa-lg"></i>',
                    'name' => \_MA_WGSIMPLEACC_OUTTEMPLATE_SUBMIT,
                    'sublinks' => []
                ];
                $nav_items2[] = [
                    'highlight' => strpos($requestUri, 'outtemplates.php') > 0,
                    'url' => '#',
                    'icon' => '<i class="fa fa-paste fa-fw fa-lg"></i>',
                    'name' => \_MA_WGSIMPLEACC_OUTTEMPLATES,
                    'sublinks' => $nav_items3
                ];
            } else {
                $nav_items2[] = [
                    'highlight' => strpos($requestUri, 'outtemplates.php') > 0,
                    'url' => $urlModule . 'outtemplates.php',
                    'icon' => '<i class="fa fa-paste fa-fw fa-lg"></i>',
                    'name' => \_MA_WGSIMPLEACC_OUTTEMPLATES,
                    'sublinks' => $nav_items3
                ];
            }
            $nav_items1[] = [
                'highlight' => strpos($requestUri, 'tratemplates.php') > 0 || strpos($requestUri, 'outtemplates.php') > 0,
                'url' => '#',
                'icon' => '<i class="fa fa-paste fa-fw fa-lg"></i>',
                'name' => \_MA_WGSIMPLEACC_TEMPLATES,
                'sublinks' => $nav_items2
            ];
        }

        $highlight1 = strpos($requestUri, 'balances.php') > 0;
        if ($permissionsHandler->getPermBalancesView()) {
            $nav_items2 = [];
            if ($permissionsHandler->getPermBalancesSubmit()) {
                $nav_items2[] = [
                    'highlight' => strpos($requestUri, 'balances.php?op=list') > 0,
                    'url' => $urlModule . 'balances.php?op=list',
                    'icon' => '<i class="fa fa-list-ol fa-fw fa-lg"></i>',
                    'name' => \_MA_WGSIMPLEACC_BALANCES_LIST,
                    'sublinks' => []
                ];
                $nav_items2[] = [
                    'highlight' => strpos($requestUri, 'balances.php?op=new') > 0,
                    'url' => $urlModule . 'balances.php?op=new',
                    'icon' => '<i class="fa fa-plus-square fa-fw fa-lg"></i>',
                    'name' => \_MA_WGSIMPLEACC_BALANCE_SUBMIT,
                    'sublinks' => []
                ];
                $nav_items1[] = [
                    'highlight' => strpos($requestUri, 'balances.php') > 0,
                    'url' => '#',
                    'icon' => '<i class="fa fa-tasks fa-fw fa-lg"></i>',
                    'name' => \_MA_WGSIMPLEACC_BALANCES,
                    'sublinks' => $nav_items2
                ];
            } else {
                $nav_items1[] = [
                    'highlight' => strpos($requestUri, 'balances.php') > 0,
                    'url' => $urlModule . 'balances.php',
                    'icon' => '<i class="fa fa-tasks fa-fw fa-lg"></i>',
                    'name' => \_MA_WGSIMPLEACC_BALANCES_LIST,
                    'sublinks' => []
                ];
            }
        }

        $highlight1 = strpos($requestUri, 'statistics.php') > 0;
        if ($permissionsHandler->getPermGlobalView()) {
            $nav_items2 = [];
            $nav_items3 = [];
            if ($permissionsHandler->getPermTransactionsView()) {
                $nav_items2[] = [
                    'highlight' => strpos($requestUri, 'statistics.php?op=allocations') > 0,
                    'url' => $urlModule . 'statistics.php?op=allocations',
                    'icon' => '<i class="fa fa-table fa-fw fa-lg"></i>',
                    'name' => \_MA_WGSIMPLEACC_ALLOCATIONS,
                    'sublinks' => []
                ];
                $nav_items2[] = [
                    'highlight' => strpos($requestUri, 'statistics.php?op=assets') > 0,
                    'url' => $urlModule . 'statistics.php?op=assets',
                    'icon' => '<i class="fa fa-credit-card fa-fw fa-lg"></i>',
                    'name' => \_MA_WGSIMPLEACC_ASSETS,
                    'sublinks' => []
                ];

                $nav_items3[] = [
                    'highlight' => strpos($requestUri, 'statistics.php?op=accounts') > 0,
                    'url' => $urlModule . 'statistics.php?op=accounts',
                    'icon' => '<i class="fa fa-credit-card fa-fw fa-lg"></i>',
                    'name' => \_MA_WGSIMPLEACC_ACCOUNTS_LINECHART,
                    'sublinks' => []
                ];
                $nav_items3[] = [
                    'highlight' => strpos($requestUri, 'statistics.php?op=hbar_accounts') > 0,
                    'url' => $urlModule . 'statistics.php?op=hbar_accounts',
                    'icon' => '<i class="fa fa-credit-card fa-fw fa-lg"></i>',
                    'name' => \_MA_WGSIMPLEACC_ACCOUNTS_BARCHART,
                    'sublinks' => []
                ];
                $nav_items2[] = [
                    'highlight' => strpos($requestUri, 'statistics.php?op=accounts') > 0 || strpos($requestUri, 'statistics.php?op=hbar_accounts') > 0,
                    'url' => '#', 'icon' => '<i class="fa fa-credit-card fa-fw fa-lg"></i>',
                    'name' => \_MA_WGSIMPLEACC_ACCOUNTS,
                    'sublinks' => $nav_items3
                ];
            }
            if ($permissionsHandler->getPermBalancesView()) {
                $nav_items2[] = [
                    'highlight' => strpos($requestUri, 'statistics.php?op=balances') > 0,
                    'url' => $urlModule . 'statistics.php?op=balances',
                    'icon' => '<i class="fa fa-tasks fa-fw fa-lg"></i>',
                    'name' => \_MA_WGSIMPLEACC_BALANCES,
                    'sublinks' => []
                ];
            }
            if ($permissionsHandler->getPermTransactionsView() || $permissionsHandler->getPermBalancesView()) {
                $nav_items1[] = [
                    'highlight' => strpos($requestUri, 'statistics.php') > 0,
                    'url' => '#',
                    'icon' => '<i class="fa fa-bar-chart-o fa-fw fa-lg"></i>',
                    'name' => \_MA_WGSIMPLEACC_STATISTICS,
                    'sublinks' => $nav_items2
                ];
            }
        }

        if ($permissionsHandler->getPermFileDirView()) {
            $nav_items2 = [];
            if ($permissionsHandler->getPermFileDirSubmit()) {
                $nav_items2[] = [
                    'highlight' => strpos($requestUri, 'files.php?op=filedir_list') > 0,
                    'url' => $urlModule . 'files.php?op=filedir_list',
                    'icon' => '<i class="fa fa-list-ol fa-fw fa-lg"></i>',
                    'name' => \_MA_WGSIMPLEACC_FILES_LIST,
                    'sublinks' => []
                ];
                $nav_items2[] = [
                    'highlight' => strpos($requestUri, 'files.php?op=filedir_new') > 0,
                    'url' => $urlModule . 'files.php?op=filedir_new',
                    'icon' => '<i class="fa fa-plus-square fa-fw fa-lg"></i>',
                    'name' => \_MA_WGSIMPLEACC_FILE_ADD,
                    'sublinks' => []
                ];
                $nav_items1[] = [
                    'highlight' => strpos($requestUri, 'files.php') > 0,
                    'url' => '#',
                    'icon' => '<i class="fa fa-files-o fa-fw fa-lg"></i>',
                    'name' => \_MA_WGSIMPLEACC_FILES,
                    'sublinks' => $nav_items2
                ];
            } else {
                $nav_items1[] = [
                    'highlight' => strpos($requestUri, 'files.php') > 0,
                    'url' => $urlModule . 'files.php?op=filedir_list',
                    'icon' => '<i class="fa fa-files-o fa-fw fa-lg"></i>',
                    'name' => \_MA_WGSIMPLEACC_FILES_LIST,
                    'sublinks' => []
                ];
            }
        }

        if ($permissionsHandler->getPermGlobalView()) {
            $nav_items2 = [];
            if ($permissionsHandler->getPermTransactionsView()) {
                $nav_items2[] = [
                    'highlight' => strpos($requestUri, 'outputs.php?op=transactions') > 0,
                    'url' => $urlModule . 'outputs.php?op=transactions',
                    'icon' => '<i class="fa fa-files-o fa-fw fa-lg"></i>',
                    'name' => \_MA_WGSIMPLEACC_TRANSACTIONS_LIST,
                    'sublinks' => []
                ];
            }
            if ($permissionsHandler->getPermBalancesView()) {
                $nav_items2[] = [
                    'highlight' => strpos($requestUri, 'outputs.php?op=balances') > 0,
                    'url' => $urlModule . 'outputs.php?op=balances',
                    'icon' => '<i class="fa fa-tasks fa-fw fa-lg"></i>',
                    'name' => \_MA_WGSIMPLEACC_BALANCES,
                    'sublinks' => []
                ];
            }
            if ($permissionsHandler->getPermTransactionsView() || $permissionsHandler->getPermBalancesView()) {
                $nav_items1[] = [
                    'highlight' => strpos($requestUri, 'outputs.php') > 0,
                    'url' => '#',
                    'icon' => '<i class="fa fa-download fa-fw fa-lg"></i>',
                    'name' => \_MA_WGSIMPLEACC_OUTPUTS,
                    'sublinks' => $nav_items2
                ];
            }
        }
        // end creation of link list as array

        return $nav_items1;
    }


}
