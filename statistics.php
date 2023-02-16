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
    Utility
};

require __DIR__ . '/header.php';
require_once \XOOPS_ROOT_PATH . '/header.php';
$GLOBALS['xoopsTpl']->assign('template_sub', 'db:wgsimpleacc_statistics.tpl');
require __DIR__ . '/navbar.php';

// Permissions
if (!$permissionsHandler->getPermGlobalView()) {
    \redirect_header('index.php', 0);
}

$op         = Request::getCmd('op', 'list');
$allId      = Request::getInt('all_id');
$allPid     = Request::getInt('all_pid');
$accId      = Request::getInt('acc_id');
$accPid     = Request::getInt('acc_pid');
$level      = Request::getInt('level', 1);
$dateFrom   = Request::getInt('dateFrom', \DateTime::createFromFormat('Y-m-d', \date('Y') . '-1-1')->getTimestamp());
$dateTo     = Request::getInt('dateTo',\time());
$dateFrom   = Request::getInt('dateFrom', \DateTime::createFromFormat('Y-m-d', \date('Y') . '-1-1')->getTimestamp());
if (Request::hasVar('filterFrom')) {
    $dateFrom = \DateTime::createFromFormat(\_SHORTDATESTRING, Request::getString('filterFrom'))->getTimestamp();
}
$dateTo = Request::getInt('dateTo', \time());
if (Request::hasVar('filterTo')) {
    $dateTo = \DateTime::createFromFormat(\_SHORTDATESTRING, Request::getString('filterTo'))->getTimestamp();
}

$keywords = [];

$GLOBALS['xoopsTpl']->assign('xoops_icons32_url', \XOOPS_ICONS32_URL);
$GLOBALS['xoopsTpl']->assign('wgsimpleacc_url', \WGSIMPLEACC_URL);
$GLOBALS['xoopsTpl']->assign('refer', 'statistics');
$GLOBALS['xoopsTpl']->assign('op', $op);
$colors = Utility::getColors();
$GLOBALS['xoopsTpl']->assign('colors', $colors);

switch ($op) {
    case 'allocations':
        $GLOBALS['xoopsTpl']->assign('header_allocs_bar', \_MA_WGSIMPLEACC_ALLOCATIONS_BARCHART);
        //*************************
        // handle transaction chart
        //*************************
        $transactionsCount = $transactionsHandler->getCountTransactions();
        $GLOBALS['xoopsTpl']->assign('transactionsCount', $transactionsCount);
        $count = 1;
        if ($transactionsCount > 0) {
            $GLOBALS['xoopsTpl']->assign('header_transactions', \_MA_WGSIMPLEACC_TRANSACTIONS_OVERVIEW );
            //get all allocations
            $crAllocations = new \CriteriaCompo();
            if ($allPid > 0) {
                $crAllocations->add(new \Criteria('all_pid', $allPid));
            }
            $crAllocations->add(new \Criteria('all_online', 1));
            $crAllocations->add(new \Criteria('all_level', $level));
            $crAllocations->setSort('all_weight ASC, all_id');
            $crAllocations->setOrder('ASC');
            $allocationsCount = $allocationsHandler->getCount($crAllocations);
            $allocationsAll   = $allocationsHandler->getAll($crAllocations);
            $transactions_datain = '';
            $transactions_dataout = '';
            $transactions_labels = '';
            $transactions_total_in = 0;
            $transactions_total_out = 0;
            $tra_allocs_list = [];
            $strFilter = "&amp;dateFrom=$dateFrom&amp;dateTo=$dateTo";
            if ($allocationsCount > 0) {
                if ($allPid > 0) {
                    //read current allocations
                    $allocCurrObj = $allocationsHandler->get($allPid);
                    $allName = $allocCurrObj->getVar('all_name');
                    $sumAmountin = 0;
                    $sumAmountout = 0;
                    //create filter
                    $crTransactions = new \CriteriaCompo();
                    $crTransactions->add(new \Criteria('tra_allid', $allPid));
                    $crTransactions->add(new \Criteria('tra_date', $dateFrom, '>='));
                    $crTransactions->add(new \Criteria('tra_date', $dateTo, '<='));
                    $crTransactions->add(new \Criteria('tra_status', Constants::TRASTATUS_SUBMITTED, '>'));
                    $transactionsAll   = $transactionsHandler->getAll($crTransactions);
                    foreach (\array_keys($transactionsAll) as $i) {
                        $sumAmountin += $transactionsAll[$i]->getVar('tra_amountin');
                        $sumAmountout += $transactionsAll[$i]->getVar('tra_amountout');
                        $transactions_total_in += $transactionsAll[$i]->getVar('tra_amountin');
                        $transactions_total_out += $transactionsAll[$i]->getVar('tra_amountout');
                    }

                    if ((float)$sumAmountin > 0 || (float)$sumAmountout > 0) {
                        $transactions_datain .= $sumAmountin . ',';
                        $transactions_dataout .= $sumAmountout . ',';
                        $allocations_list[] = ['all_id' => $allId, 'all_name' => $allName];
                        $transactions_labels .= "'" . \str_replace('%s', $allName, \_MA_WGSIMPLEACC_ALLOCATION_CURRID) . "',";
                    }

                    unset($crAllocCur, $allocCurObj, $crTransactions);
                }

                // Go through all allocations
                $crAlloc2 = new \CriteriaCompo();
                $crAlloc2->add(new \Criteria('all_id', $allPid));
                $alloc2Count = $allocationsHandler->getCount($crAlloc2);
                if ($alloc2Count > 0) {
                    $alloc2All   = $allocationsHandler->getAll($crAlloc2);
                    // Go through all allocations
                    foreach (\array_keys($alloc2All) as $j) {
                        $pidReturn = $alloc2All[$j]->getVar('all_pid');
                    }
                }
                if ($level > 1) {
                    $href = 'statistics.php?op=' . $op . '&amp;all_pid=0&amp;level=1' .  $strFilter;
                    $tra_allocs_list[] = ['all_id' => $allId, 'all_name' => ' << ', 'allSubs' => 0, 'href' => $href];
                }
                if ($level > 2) {
                    $href = 'statistics.php?op=' . $op . '&amp;all_pid=' . $pidReturn . '&amp;level=' . ($level - 1) . $strFilter;
                    $tra_allocs_list[] = ['all_id' => $allId, 'all_name' => ' < ', 'allSubs' => 0, 'href' => $href];
                }
                // Go through all allocations
                foreach (\array_keys($allocationsAll) as $i) {
                    $allId   = $allocationsAll[$i]->getVar('all_id');
                    $allName = $allocationsAll[$i]->getVar('all_name');
                    $allocations_list[] = ['all_id' => $allId, 'all_name' => $allName];
                    $transactions_labels .= "'" . $allName . "',";
                    $sumAmountin  = 0;
                    $sumAmountout = 0;
                    //create filter
                    $subAllIds = $allocationsHandler->getSubsOfAllocations($allId);
                    foreach ($subAllIds as $subAllId) {
                        $crTransactions = new \CriteriaCompo();
                        $crTransactions->add(new \Criteria('tra_allid', $subAllId));
                        $crTransactions->add(new \Criteria('tra_date', $dateFrom, '>='));
                        $crTransactions->add(new \Criteria('tra_date', $dateTo, '<='));
                        $crTransactions->add(new \Criteria('tra_status', Constants::TRASTATUS_SUBMITTED, '>'));
                        $transactionsCount = $transactionsHandler->getCount($crTransactions);
                        if ($transactionsCount > 0) {
                            $transactionsAll   = $transactionsHandler->getAll($crTransactions);
                            foreach (\array_keys($transactionsAll) as $j) {
                                $sumAmountin += $transactionsAll[$j]->getVar('tra_amountin');
                                $sumAmountout += $transactionsAll[$j]->getVar('tra_amountout');
                                $transactions_total_in += $transactionsAll[$j]->getVar('tra_amountin');
                                $transactions_total_out += $transactionsAll[$j]->getVar('tra_amountout');
                            }
                        }
                        unset($crTransactions);
                    }
                    $href = 'statistics.php?op=' . $op . '&amp;all_pid=' . $allId . '&amp;level=' . ($level + 1) . $strFilter;
                    $tra_allocs_list[] = ['all_id' => $allId, 'all_name' => $allName, 'allSubs' => \count($subAllIds), 'href' => $href];
                    $transactions_datain .= $sumAmountin . ',';
                    $transactions_dataout .= $sumAmountout . ',';
                }
            }
            unset($crAllocations);

            $GLOBALS['xoopsTpl']->assign('tra_allocs_list', $tra_allocs_list);
            $GLOBALS['xoopsTpl']->assign('transactions_datain1', $transactions_datain);
            $GLOBALS['xoopsTpl']->assign('transactions_dataout1', $transactions_dataout);
            $GLOBALS['xoopsTpl']->assign('transactions_labels', $transactions_labels);
            $GLOBALS['xoopsTpl']->assign('transactions_total_in', Utility::FloatToString($transactions_total_in));
            $GLOBALS['xoopsTpl']->assign('transactions_total_out', Utility::FloatToString($transactions_total_out));
            $GLOBALS['xoopsTpl']->assign('transactions_total', Utility::FloatToString($transactions_total_in - $transactions_total_out));
            $GLOBALS['xoopsTpl']->assign('label_datain1', \_MA_WGSIMPLEACC_TRANSACTIONS_INCOMES . ' (' . \_MA_WGSIMPLEACC_TRASTATUS_APPROVED .')');
            $GLOBALS['xoopsTpl']->assign('label_dataout1', \_MA_WGSIMPLEACC_TRANSACTIONS_EXPENSES . ' (' . \_MA_WGSIMPLEACC_TRASTATUS_APPROVED .')');
        }
        unset($count);

        //get form filter
        if (\count($tra_allocs_list) > 0) {
            $formFilter = Utility::getFormFilterPeriod($dateFrom, $dateTo, 'allocations');
            $GLOBALS['xoopsTpl']->assign('formTraFilter', $formFilter->render());
        }

        // Breadcrumbs
        $xoBreadcrumbs[] = ['title' => \_MA_WGSIMPLEACC_STATISTICS];
        $xoBreadcrumbs[] = ['title' => \_MA_WGSIMPLEACC_ALLOCATIONS];
        break;
    case 'assets':
        $GLOBALS['xoopsTpl']->assign('header_assets_pie', \_MA_WGSIMPLEACC_ASSETSTOTAL_CURRENT);
        $GLOBALS['xoopsTpl']->assign('header_assets_line', \_MA_WGSIMPLEACC_ASSETS_TIMELINE);
        //****************************
        // handle assets chart current
        //****************************
        $assetsCurrent = $assetsHandler->getCurrentAssetsValues();
        $assetsCount = \count($assetsCurrent);
        if ($assetsCount > 0) {
            $GLOBALS['xoopsTpl']->assign('assetsCount', $assetsCount);
            $assets_data   = '';
            $assets_labels = '';
            $assets_total  = 0;
            $pcolors       = [];
            $assetList     = [];
            foreach ($assetsCurrent as $asset) {
                $assets_data .= $asset['amount_val'] . ',';
                $assets_labels .= "'" . $asset['name'] . "',";
                $assets_total += $asset['amount_val'];
                $pcolors[] = Utility::getColorName($colors, $asset['color']);
                $assetList[] = $asset;
            }
            $GLOBALS['xoopsTpl']->assign('display_legend', 'false');
            $GLOBALS['xoopsTpl']->assign('assetList', $assetList);
            $GLOBALS['xoopsTpl']->assign('assets_data', $assets_data);
            $GLOBALS['xoopsTpl']->assign('assets_pcolors', $pcolors);
            $GLOBALS['xoopsTpl']->assign('assets_labels', $assets_labels);
            $GLOBALS['xoopsTpl']->assign('assets_total', Wgsimpleacc\Utility::FloatToString($assets_total));
        }
        //*****************************
        // handle assets chart timeline
        //*****************************
        $line_assets = [];
        $labels = [];
        //get all years
        $minYear = 0;
        $maxYear = 0;
        $crTransactions = new \CriteriaCompo();
        $crTransactions->add(new \Criteria('tra_status', Constants::TRASTATUS_SUBMITTED, '>'));
        $crTransactions->setSort('tra_year');
        $crTransactions->setOrder('ASC');
        $crTransactions->setStart();
        $crTransactions->setLimit(1);
        $transactionsAll   = $transactionsHandler->getAll($crTransactions);
        foreach (\array_keys($transactionsAll) as $i) {
            $minYear = $transactionsAll[$i]->getVar('tra_year');
        }
        $crTransactions->setOrder('DESC');
        $crTransactions->setStart();
        $crTransactions->setLimit(1);
        $transactionsAll   = $transactionsHandler->getAll($crTransactions);
        foreach (\array_keys($transactionsAll) as $i) {
            $maxYear = $transactionsAll[$i]->getVar('tra_year');
        }

        $assetsAll = $assetsHandler->getAll();
        foreach (\array_keys($assetsAll) as $i) {
            $asId = $assetsAll[$i]->getVar('as_id');
            $asName = $assetsAll[$i]->getVar('as_name');
            $asColor = Utility::getColorName($colors, $assetsAll[$i]->getVar('as_color'));
            $dataAmounts = '';
            $amount = 0;
            for ($y = $minYear; $y <= $maxYear; $y++) {
                // get all assets per year
                $sql = 'SELECT Sum(`tra_amountin`) AS Sum_tra_amountin, Sum(`tra_amountout`) AS Sum_tra_amountout ';
                $sql .= 'FROM ' . $xoopsDB->prefix('wgsimpleacc_transactions') . ' ';
                $sql .= 'WHERE (((' . $xoopsDB->prefix('wgsimpleacc_transactions') . '.tra_year)=' . $y;
                $sql .= ') AND ((' . $xoopsDB->prefix('wgsimpleacc_transactions') . '.tra_asid)=' . $asId . '));';
                $result = $xoopsDB->query($sql);
                while (list($sumIn, $sumOut) = $xoopsDB->fetchRow($result)) {
                    $amount += (float)($sumIn - $sumOut);
                    $dataAmounts .= round($amount, 2) . ',';
                    $labels[$y] = $y;
                    $line_assets[$asId] = ['name' => $asName, 'color' => $asColor, 'data' => $dataAmounts];
                }
            }
        }

        $line_labels = '';
        foreach($labels as $label) {
            $line_labels .= "'" . $label . "', ";
        }
        $GLOBALS['xoopsTpl']->assign('line_assets', $line_assets);
        $GLOBALS['xoopsTpl']->assign('line_labels', $line_labels);

        // Breadcrumbs
        $xoBreadcrumbs[] = ['title' => \_MA_WGSIMPLEACC_STATISTICS];
        $xoBreadcrumbs[] = ['title' => \_MA_WGSIMPLEACC_ASSETS];
        break;
    case 'balances':
        $GLOBALS['xoopsTpl']->assign('header_balances_line', \_MA_WGSIMPLEACC_BALANCES_TIMELINE);
        //*****************************
        // handle balances chart timeline
        //*****************************
        $line_balances = [];
        $labels = [];
        // get all balances in balances
        $result = $xoopsDB->query('SELECT `bal_asid` FROM ' . $xoopsDB->prefix('wgsimpleacc_balances') . ' GROUP BY `bal_asid`');
        while (list($balAsid) = $xoopsDB->fetchRow($result)) {
            $balAmounts = '';
            $assetsObj = $assetsHandler->get($balAsid);
            $asName = $assetsObj->getVar('as_name');
            $asColor = Utility::getColorName($colors, $assetsObj->getVar('as_color'));
            $crBalances = new \CriteriaCompo();
            $crBalances->add(new \Criteria('bal_asid', $balAsid));
            $balancesAll = $balancesHandler->getAll($crBalances);
            foreach (\array_keys($balancesAll) as $i) {
                $balAmounts .= $balancesAll[$i]->getVar('bal_amountend') . ',';
                $labelDate = $balancesAll[$i]->getVar('bal_to');
                $labels[$labelDate] = \formatTimestamp($labelDate, 's');
            }
            unset($crBalances);
            $line_balances[] = ['name' => $asName, 'color' => $asColor, 'data' => $balAmounts];
        }
        $GLOBALS['xoopsTpl']->assign('balancesCount', \count($line_balances));
        $line_labels = '';
        foreach($labels as $label) {
            $line_labels .= "'" . $label . "', ";
        }
        $GLOBALS['xoopsTpl']->assign('line_balances', $line_balances);
        $GLOBALS['xoopsTpl']->assign('line_labels', $line_labels);

        // Breadcrumbs
        $xoBreadcrumbs[] = ['title' => \_MA_WGSIMPLEACC_STATISTICS];
        $xoBreadcrumbs[] = ['title' => \_MA_WGSIMPLEACC_BALANCES];
        break;
    case 'accounts':
        $GLOBALS['xoopsTpl']->assign('header_accounts_line', \_MA_WGSIMPLEACC_ACCOUNTS_TIMELINE);
        //*****************************
        // handle accounts chart timeline(
        //*****************************
        $traAccid = 0;
        $dataAccounts = [];
        //current year minus max 5
        $minYearFrom = date('Y') - 5;
        $minDateFrom = \DateTime::createFromFormat('Y-m-d', (date('Y') - 5) . '-1-1')->getTimestamp();
        $crTransactions = new \CriteriaCompo();
        $crTransactions->add(new \Criteria('tra_status', Constants::TRASTATUS_SUBMITTED, '>'));
        $crTransactions->setSort('tra_date');
        $crTransactions->setOrder('ASC');
        $crTransactions->setStart();
        $crTransactions->setLimit(1);
        $transactionsAll   = $transactionsHandler->getAll($crTransactions);
        foreach (\array_keys($transactionsAll) as $i) {
            $minYear = date('Y', $transactionsAll[$i]->getVar('tra_date'));
            if ($minYear > $minYearFrom) {
                $minYearFrom = $minYear;
                $minDateFrom = \DateTime::createFromFormat('Y-m-d', $minYear . '-1-1')->getTimestamp();
            }
        }
        unset($crTransactions);

        $line_labels = '';
        for ($i = $minYearFrom; $i <= date('Y'); $i++) {
            $line_labels .= "'" . $i . "', ";
        }

        $crAccounts = new \CriteriaCompo();
        $crAccounts->setSort('acc_weight');
        $crAccounts->setOrder('ASC');
        //create array with 0 for all account/year combination
        $accountsCount = $accountsHandler->getCount();
        $GLOBALS['xoopsTpl']->assign('accountsCount', $accountsCount);
        if ($accountsCount > 0) {
            $accountsAll   = $accountsHandler->getAll($crAccounts);
            foreach (\array_keys($accountsAll) as $a) {
                if (1 === $level) {
                    $accTopLevel = $accountsHandler->getTopLevelAccount($a);
                    $dataAccounts[$accTopLevel['id']]['label'] = $accTopLevel['name'];
                    $dataAccounts[$accTopLevel['id']]['color'] = Utility::getColorName($colors, $accTopLevel['color']);
                } else {
                    $dataAccounts[$accountsAll[$a]->getVar('acc_id')]['label'] = $accountsAll[$a]->getVar('acc_name');
                    $dataAccounts[$accountsAll[$a]->getVar('acc_id')]['color'] = Utility::getColorName($colors, $accountsAll[$a]->getVar('acc_color'));
                }
                for ($i = $minYearFrom; $i <= date('Y'); $i++) {
                    if (1 === $level) {
                        $dataAccounts[$accTopLevel['id']]['values'][$i] = 0;
                    } else {
                        $dataAccounts[$accountsAll[$a]->getVar('acc_id')]['values'][$i] = 0;
                    }
                }
            }
        }
        $crTransactions = new \CriteriaCompo();
        $crTransactions->add(new \Criteria('tra_date', $minDateFrom, '>='));
        $crTransactions->add(new \Criteria('tra_status', Constants::TRASTATUS_SUBMITTED, '>'));
        $crTransactions->setSort('tra_accid ASC, tra_date');
        $crTransactions->setOrder('ASC');
        $transactionsCount = $transactionsHandler->getCount($crTransactions);
        $transactionsAll   = $transactionsHandler->getAll($crTransactions);
        if ($transactionsCount > 0) {
            foreach (\array_keys($transactionsAll) as $i) {
                $period = date('Y', $transactionsAll[$i]->getVar('tra_date'));
                $sum = $transactionsAll[$i]->getVar('tra_amountin') - $transactionsAll[$i]->getVar('tra_amountout');
                if (1 === $level) {
                    $accTopLevel = $accountsHandler->getTopLevelAccount($transactionsAll[$i]->getVar('tra_accid'));
                    $dataAccounts[$accTopLevel['id']]['values'][$period] += $sum;
                } else {
                    $dataAccounts[$transactionsAll[$i]->getVar('tra_accid')]['values'][$period] += $sum;
                }
            }
        }
        unset($crTransactions);

        $line_accounts = [];
        foreach ($dataAccounts as $data) {
            $dataSum = '';
            foreach($data['values'] as $val) {
                $dataSum .= $val . ', ';
            }
            $line_accounts[] = ['name' => $data['label'], 'color' => $data['color'], 'data' => $dataSum];
        }

        $GLOBALS['xoopsTpl']->assign('line_accounts', $line_accounts);
        $GLOBALS['xoopsTpl']->assign('line_labels', $line_labels);
        $GLOBALS['xoopsTpl']->assign('level', $level);

        // Breadcrumbs
        $xoBreadcrumbs[] = ['title' => \_MA_WGSIMPLEACC_STATISTICS];
        $xoBreadcrumbs[] = ['title' => \_MA_WGSIMPLEACC_ACCOUNTS];
        break;
    case 'hbar_accounts':
        $GLOBALS['xoopsTpl']->assign('header_accounts_bar', \_MA_WGSIMPLEACC_ACCOUNTS_BARCHART);
        //*************************
        // handle transaction chart
        //*************************
        $transactionsCount = $transactionsHandler->getCountTransactions();
        $GLOBALS['xoopsTpl']->assign('transactionsAccBarCount', $transactionsCount);
        $count = 1;
        if ($transactionsCount > 0) {
            $GLOBALS['xoopsTpl']->assign('header_transactions', \_MA_WGSIMPLEACC_TRANSACTIONS_OVERVIEW );
            //get all accounts
            $crAccounts = new \CriteriaCompo();
            if ($accPid > 0) {
                $crAccounts->add(new \Criteria('acc_pid', $accPid));
            }
            $crAccounts->add(new \Criteria('acc_online', 1));
            $crAccounts->add(new \Criteria('acc_level', $level));
            $crAccounts->setSort('acc_weight ASC, acc_id');
            $crAccounts->setOrder('ASC');
            $accountsCount = $accountsHandler->getCount($crAccounts);
            $GLOBALS['xoopsTpl']->assign('accountsBarCount', $accountsCount);
            $transactions_datain = '';
            $transactions_dataout = '';
            $transactions_labels = '';
            $transactions_total_in = 0;
            $transactions_total_out = 0;
            $tra_accounts_list = [];
            $strFilter = "&amp;dateFrom=$dateFrom&amp;dateTo=$dateTo";
            if ($accountsCount > 0) {
                $accountsAll   = $accountsHandler->getAll($crAccounts);
                if ($accPid > 0) {
                    //read current accounts
                    $accountCurrObj = $accountsHandler->get($accPid);
                    $accName = $accountCurrObj->getVar('acc_name');
                    $sumAmountin = 0;
                    $sumAmountout = 0;
                    //create filter
                    $crTransactions = new \CriteriaCompo();
                    $crTransactions->add(new \Criteria('tra_accid', $accPid));
                    $crTransactions->add(new \Criteria('tra_date', $dateFrom, '>='));
                    $crTransactions->add(new \Criteria('tra_date', $dateTo, '<='));
                    $crTransactions->add(new \Criteria('tra_status', Constants::TRASTATUS_SUBMITTED, '>'));
                    $transactionsAll   = $transactionsHandler->getAll($crTransactions);
                    foreach (\array_keys($transactionsAll) as $i) {
                        $sumAmountin += $transactionsAll[$i]->getVar('tra_amountin');
                        $sumAmountout += $transactionsAll[$i]->getVar('tra_amountout');
                        $transactions_total_in += $transactionsAll[$i]->getVar('tra_amountin');
                        $transactions_total_out += $transactionsAll[$i]->getVar('tra_amountout');
                    }

                    if ((float)$sumAmountin > 0 || (float)$sumAmountout > 0) {
                        $transactions_datain .= $sumAmountin . ',';
                        $transactions_dataout .= $sumAmountout . ',';
                        $accounts_list[] = ['acc_id' => $accId, 'acc_name' => $accName];
                        $transactions_labels .= "'" . \str_replace('%s', $accName, \_MA_WGSIMPLEACC_ACCOUNT_CURRID) . "',";
                    }

                    unset($crTransactions);
                }

                // Go through all accounts
                $crAccount2 = new \CriteriaCompo();
                $crAccount2->add(new \Criteria('acc_id', $accPid));
                $account2Count = $accountsHandler->getCount($crAccount2);
                if ($account2Count > 0) {
                    $account2All   = $accountsHandler->getAll($crAccount2);
                    // Go through all accounts
                    foreach (\array_keys($account2All) as $j) {
                        $pidReturn = $account2All[$j]->getVar('acc_pid');
                    }
                }
                if ($level > 1) {
                    $href = 'statistics.php?op=' . $op . '&amp;acc_pid=0&amp;level=1' .  $strFilter;
                    $tra_accounts_list[] = ['acc_id' => $accId, 'acc_name' => ' << ', 'accSubs' => 0, 'href' => $href];
                }
                if ($level > 2) {
                    $href = 'statistics.php?op=' . $op . '&amp;acc_pid=' . $pidReturn . '&amp;level=' . ($level - 1) . $strFilter;
                    $tra_accounts_list[] = ['acc_id' => $accId, 'acc_name' => ' < ', 'accSubs' => 0, 'href' => $href];
                }
                // Go through all accounts
                foreach (\array_keys($accountsAll) as $acc){
                    $accId   = $accountsAll[$acc]->getVar('acc_id');
                    $accName = $accountsAll[$acc]->getVar('acc_name');
                    $accounts_list[] = ['acc_id' => $accId, 'acc_name' => $accName];
                    $transactions_labels .= "'" . $accName . "',";
                    $sumAmountin  = 0;
                    $sumAmountout = 0;
                    //create filter
                    $subAccIds = $accountsHandler->getSubsOfAccounts($accId);
                    foreach ($subAccIds as $subAccId) {
                        $crTransactions = new \CriteriaCompo();
                        $crTransactions->add(new \Criteria('tra_accid', $subAccId));
                        $crTransactions->add(new \Criteria('tra_date', $dateFrom, '>='));
                        $crTransactions->add(new \Criteria('tra_date', $dateTo, '<='));
                        $crTransactions->add(new \Criteria('tra_status', Constants::TRASTATUS_SUBMITTED, '>'));
                        $transactionsCount = $transactionsHandler->getCount($crTransactions);
                        $transactionsAll   = $transactionsHandler->getAll($crTransactions);
                        if ($transactionsCount > 0) {
                            foreach (\array_keys($transactionsAll) as $i) {
                                $sumAmountin += $transactionsAll[$i]->getVar('tra_amountin');
                                $sumAmountout += $transactionsAll[$i]->getVar('tra_amountout');
                                $transactions_total_in += $transactionsAll[$i]->getVar('tra_amountin');
                                $transactions_total_out += $transactionsAll[$i]->getVar('tra_amountout');
                            }
                        }
                        unset($crTransactions);
                    }
                    $href = 'statistics.php?op=' . $op . '&amp;acc_pid=' . $accId . '&amp;level=' . ($level + 1) . $strFilter;
                    $tra_accounts_list[] = ['acc_id' => $accId, 'acc_name' => $accName, 'accSubs' => \count($subAccIds), 'href' => $href];
                    $transactions_datain .= $sumAmountin . ',';
                    $transactions_dataout .= $sumAmountout . ',';
                }
            }
            unset($crAccounts);

            $GLOBALS['xoopsTpl']->assign('tra_accounts_list', $tra_accounts_list);
            $GLOBALS['xoopsTpl']->assign('transactions_datain1', $transactions_datain);
            $GLOBALS['xoopsTpl']->assign('transactions_dataout1', $transactions_dataout);
            $GLOBALS['xoopsTpl']->assign('transactions_labels', $transactions_labels);
            $GLOBALS['xoopsTpl']->assign('transactions_total_in', Utility::FloatToString($transactions_total_in));
            $GLOBALS['xoopsTpl']->assign('transactions_total_out', Utility::FloatToString($transactions_total_out));
            $GLOBALS['xoopsTpl']->assign('transactions_total', Utility::FloatToString($transactions_total_in - $transactions_total_out));
            $GLOBALS['xoopsTpl']->assign('label_datain1', \_MA_WGSIMPLEACC_TRANSACTIONS_INCOMES . ' (' . \_MA_WGSIMPLEACC_TRASTATUS_APPROVED .')');
            $GLOBALS['xoopsTpl']->assign('label_dataout1', \_MA_WGSIMPLEACC_TRANSACTIONS_EXPENSES . ' (' . \_MA_WGSIMPLEACC_TRASTATUS_APPROVED .')');
        }
        unset($count);

        //get form filter year
        if (\count($tra_accounts_list) > 0) {
            $formFilter = Utility::getFormFilterPeriod($dateFrom, $dateTo, 'hbar_accounts');
            $GLOBALS['xoopsTpl']->assign('formTraFilter', $formFilter->render());
        }

        // Breadcrumbs
        $xoBreadcrumbs[] = ['title' => \_MA_WGSIMPLEACC_STATISTICS];
        $xoBreadcrumbs[] = ['title' => \_MA_WGSIMPLEACC_ACCOUNTS];
        break;
    case 'list':
    default:

        break;

}

// Keywords
wgsimpleaccMetaKeywords($helper->getConfig('keywords') . ', ' . \implode(',', $keywords));
unset($keywords);
// Description
wgsimpleaccMetaDescription(\_MA_WGSIMPLEACC_INDEX_DESC);
$GLOBALS['xoopsTpl']->assign('xoops_mpageurl', \WGSIMPLEACC_URL.'/index.php');
$GLOBALS['xoopsTpl']->assign('wgsimpleacc_upload_url', \WGSIMPLEACC_UPLOAD_URL);
require __DIR__ . '/footer.php';
