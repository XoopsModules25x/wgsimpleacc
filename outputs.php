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
    Export\Simplexlsxgen,
    Export\Simplecsv,
};

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

require __DIR__ . '/header.php';
$GLOBALS['xoopsOption']['template_main'] = 'wgsimpleacc_main_startmin.tpl';
require_once \XOOPS_ROOT_PATH . '/header.php';
$GLOBALS['xoopsTpl']->assign('template_sub', 'db:wgsimpleacc_outputs.tpl');
require_once __DIR__ . '/navbar.php';

// Permissions
if (!$permissionsHandler->getPermGlobalView()) {
    $GLOBALS['xoopsTpl']->assign('error', _NOPERM);
    require __DIR__ . '/footer.php';
}

// Define Stylesheet
$GLOBALS['xoTheme']->addStylesheet($style, null);

$op      = Request::getCmd('op', 'none');
$traId   = Request::getInt('tra_id', 0);
$traType = Request::getInt('tra_type', 0);
$allId   = Request::getInt('all_id', 0);
$accId   = Request::getInt('acc_id', 0);
$asId    = Request::getInt('as_id', 0);
$outType = Request::getString('output_type', 'none');

$period_type = $helper->getConfig('balance_period');
$GLOBALS['xoopsTpl']->assign('displayfilter', 1);

switch ($op) {
    case 'none':
    default:
        break;
    case 'balances':
        $formFilter = $outputsHandler::getFormBalancesSelect();
        $GLOBALS['xoopsTpl']->assign('formFilter', $formFilter->render());
        break;
    case 'bal_output':
        $GLOBALS['xoopsTpl']->assign('displayBalOutput', 1);
        $balIds       = Request::getArray('bal_ids');
        $levelAlloc   = Request::getInt('level_alloc');
        $levelAccount = Request::getInt('level_account');

        $balances = $outputsHandler->getListBalances($balIds);
        $sumTotal = 0;
        $sumAmountin = 0;
        $sumAmountout = 0;
        foreach ($balances as $balance) {
            $sumTotal += ($balance['bal_amountend'] - $balance['bal_amountstart']);
            $sumAmountin += $balance['bal_amountstart'];
            $sumAmountout += $balance['bal_amountend'];
        }
        $GLOBALS['xoopsTpl']->assign('balancesTotal', $sumTotal);
        $GLOBALS['xoopsTpl']->assign('balancesAmountIn', $sumAmountin);
        $GLOBALS['xoopsTpl']->assign('balancesAmountOut', $sumAmountout);
        $GLOBALS['xoopsTpl']->assign('balancesCount', \count($balances));
        $GLOBALS['xoopsTpl']->assign('balances', $balances);

        if ($levelAccount > 0) {
            $accounts = $outputsHandler->getListAccountsValues($balIds);
            $sumTotal = 0;
            $sumAmountin = 0;
            $sumAmountout = 0;
            foreach ($accounts as $account) {
                $sumTotal += $account['total_val'];
                $sumAmountin += $account['amountin_val'];
                $sumAmountout += $account['amountout_val'];
            }
            $GLOBALS['xoopsTpl']->assign('accountsTotal', $sumTotal);
            $GLOBALS['xoopsTpl']->assign('accountsAmountIn', $sumAmountin);
            $GLOBALS['xoopsTpl']->assign('accountsAmountOut', $sumAmountout);
            $GLOBALS['xoopsTpl']->assign('accountsCount', \count($accounts));
            $GLOBALS['xoopsTpl']->assign('accounts', $accounts);
        }

        if ($levelAlloc > 0) {
            $allocations = $outputsHandler->getListAllocationsValues($balIds);
            $sumTotal = 0;
            $sumAmountin = 0;
            $sumAmountout = 0;
            foreach ($allocations as $allocation) {
                $sumTotal += $allocation['total_val'];
                $sumAmountin += $allocation['amountin_val'];
                $sumAmountout += $allocation['amountout_val'];
            }
            $GLOBALS['xoopsTpl']->assign('allocationsTotal', $sumTotal);
            $GLOBALS['xoopsTpl']->assign('allocationsAmountIn', $sumAmountin);
            $GLOBALS['xoopsTpl']->assign('allocationsAmountOut', $sumAmountout);
            $GLOBALS['xoopsTpl']->assign('allocationsCount', \count($allocations));
            $GLOBALS['xoopsTpl']->assign('allocations', $allocations);
        }
        break;
    case 'transactions';
        $filterYear = Request::getInt('filterYear', 0);
        $filterMonthFrom = Request::getInt('filterMonthFrom', 0);
        $filterYearFrom = Request::getInt('filterYearFrom', 0);
        $filterMonthTo = Request::getInt('filterMonthTo', 0);
        $filterYearTo = Request::getInt('filterYearTo', date('Y'));
        //get first and last year
        $transactionsHandler = $helper->getHandler('Transactions');
        $yearMin = date('Y');
        $yearMax = date('Y');
        $crTransactions = new \CriteriaCompo();
        $crTransactions->setSort('tra_date');
        $crTransactions->setOrder('ASC');
        $crTransactions->setStart(0);
        $crTransactions->setLimit(1);
        $transactionsAll = $transactionsHandler->getAll($crTransactions);
        foreach (\array_keys($transactionsAll) as $i) {
            $yearMin = date('Y', $transactionsAll[$i]->getVar('tra_date'));
        }
        $crTransactions->setSort('tra_date');
        $crTransactions->setOrder('DESC');
        $crTransactions->setStart(0);
        $crTransactions->setLimit(1);
        $transactionsAll = $transactionsHandler->getAll($crTransactions);
        foreach (\array_keys($transactionsAll) as $i) {
            $yearMax = date('Y', $transactionsAll[$i]->getVar('tra_date'));
        }
        $formFilter = $transactionsHandler::getFormFilterTransactions($allId, $filterYear, $filterMonthFrom, $filterYearFrom, $filterMonthTo, $filterYearTo, $yearMin, $yearMax, $asId, $accId, 'tra_output');
        $GLOBALS['xoopsTpl']->assign('formFilter', $formFilter->render());
        break;
    case 'tra_output';
        switch ($outType) {
            case 'csv':
            case 'xlsx':
                //$creator = ('' != $GLOBALS['xoopsUser']->getVar('name')) ? $GLOBALS['xoopsUser']->getVar('name') : $GLOBALS['xoopsUser']->getVar('uname');
                $filename = date('Ymd_H_i_s_', \time()) . \_MA_WGSIMPLEACC_TRANSACTIONS . '.' . $outType;

                $filterYear = Request::getInt('filterYear', 0);
                $filterMonthFrom = Request::getInt('filterMonthFrom', 0);
                $filterYearFrom = Request::getInt('filterYearFrom', 0);
                $filterMonthTo = Request::getInt('filterMonthTo', 0);
                $filterYearTo = Request::getInt('filterYearTo', date('Y'));

                // Add data
                $crTransactions = new \CriteriaCompo();
                $crTransactions->add(new \Criteria('tra_status', Constants::STATUS_OFFLINE, '>'));
                if ($traId > 0) {
                    $crTransactions->add(new \Criteria('tra_id', $traId));
                } else {
                    $tradateFrom = 0;
                    $tradateTo = \time();
                    if (Constants::FILTER_PYEARLY == $period_type) {
                        //filter data based on form select year
                        if ($filterYear > Constants::FILTER_TYPEALL) {
                            $dtime = \DateTime::createFromFormat('Y-m-d', "$filterYear-1-1");
                            $tradateFrom = $dtime->getTimestamp();
                            $dtime = \DateTime::createFromFormat('Y-m-d', "$filterYear-12-31");
                            $tradateTo = $dtime->getTimestamp();
                        }
                    } else {
                        //filter data based on form select month and year from/to
                        $dtime = \DateTime::createFromFormat('Y-m-d', "$filterYearFrom-$filterMonthFrom-1");
                        $tradateFrom = $dtime->getTimestamp();
                        $last = \DateTime::createFromFormat('Y-m-d', "$filterYearTo-$filterMonthTo-1")->format('Y-m-t');
                        $dtime = \DateTime::createFromFormat('Y-m-d', $last);
                        $tradateTo = $dtime->getTimestamp();
                    }
                    $crTransactions->add(new \Criteria('tra_date', $tradateFrom, '>='));
                    $crTransactions->add(new \Criteria('tra_date', $tradateTo, '<='));
                }
                if ($allId > 0) {
                    $crTransactions->add(new \Criteria('tra_allid', $allId));
                }
                if ($asId > 0) {
                    $crTransactions->add(new \Criteria('tra_asid', $asId));
                }
                if ($accId > 0) {
                    $crTransactions->add(new \Criteria('tra_accid', $accId));
                }
                $transactionsCount = $transactionsHandler->getCount($crTransactions);
                $GLOBALS['xoopsTpl']->assign('transactionsCount', $transactionsCount);
                $crTransactions->setSort('tra_id');
                $crTransactions->setOrder('DESC');
                $transactionsAll = $transactionsHandler->getAll($crTransactions);
                if ($transactionsCount > 0) {
                    //add field names
                    $data[] = [\_MA_WGSIMPLEACC_TRANSACTION_YEARNB, \_MA_WGSIMPLEACC_TRANSACTION_DESC, \_MA_WGSIMPLEACC_TRANSACTION_REFERENCE,
                        \_MA_WGSIMPLEACC_TRANSACTION_ACCID, \_MA_WGSIMPLEACC_TRANSACTION_ALLID, \_MA_WGSIMPLEACC_TRANSACTION_DATE,
                        \_MA_WGSIMPLEACC_TRANSACTION_AMOUNTIN, \_MA_WGSIMPLEACC_TRANSACTION_AMOUNTOUT, \_MA_WGSIMPLEACC_TRANSACTION_ASID];
                    $transactions = [];
                    // Get All Transactions
                    foreach (\array_keys($transactionsAll) as $i) {
                        $transactions[$i] = $transactionsAll[$i]->getValuesTransactions();
                        if ('xlsx' == $outType) {
                            $data[] = [
                                $transactions[$i]['year'] . '/' . $transactions[$i]['nb'],
                                $transactions[$i]['desc'],
                                $transactions[$i]['reference'],
                                $transactions[$i]['account'],
                                $transactions[$i]['allocation'],
                                $transactions[$i]['date'],
                                $transactions[$i]['amountin'],
                                $transactions[$i]['amountout'],
                                $transactions[$i]['asset']
                            ];
                        } else {
                            $data[] = [
                                '"' . $transactions[$i]['year'] . '/' . $transactions[$i]['nb'] . '"',
                                '"' . $transactions[$i]['desc'] . '"',
                                '"' . $transactions[$i]['reference'] . '"',
                                '"' . $transactions[$i]['account'] . '"',
                                '"' . $transactions[$i]['allocation'] . '"',
                                $transactions[$i]['date'],
                                $transactions[$i]['amountin'],
                                $transactions[$i]['amountout'],
                                '"' . $transactions[$i]['asset'] . '"'
                            ];
                        }

                    }
                    unset($transactions);
                }
                if ('xlsx' == $outType) {
                    $xlsx = Simplexlsxgen\SimpleXLSXGen::fromArray($data);
                    $xlsx->downloadAs($filename);
                } else {
                    $csv = Simplecsv\SimpleCSV::downloadAs( $data, $filename );
                }
                break;
            case 'none':
            default:
                break;
        }
        break;
}

require __DIR__ . '/footer.php';
