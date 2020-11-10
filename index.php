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
 * @author         XOOPS Development Team - Email:<webmaster@wedega.com> - Website:<https://xoops.wedega.com>
 */

use Xmf\Request;
use XoopsModules\Wgsimpleacc;
use XoopsModules\Wgsimpleacc\{
    Constants,
    Utility
};

require __DIR__ . '/header.php';
$GLOBALS['xoopsOption']['template_main'] = 'wgsimpleacc_main_startmin.tpl';
require_once \XOOPS_ROOT_PATH . '/header.php';
$GLOBALS['xoopsTpl']->assign('template_sub', 'db:wgsimpleacc_index.tpl');
require __DIR__ . '/navbar.php';

$op     = Request::getCmd('op', 'list');
$allPid = Request::getInt('all_pid', 0);
$level  = Request::getInt('level', 1);
$filterYear      = date('Y');
$filterMonthFrom = $helper->getConfig('balance_period_from');
$filterYearFrom  = date('Y');
$filterMonthTo   = $helper->getConfig('balance_period_from');
$filterYearTo    = date('Y');
$filterType      = Request::getInt('filterType', Constants::FILTER_TYPEALL);

$period_type = $helper->getConfig('balance_period');

// Define Stylesheet
$GLOBALS['xoTheme']->addStylesheet($style, null);

// Permissions
if (!$permissionsHandler->getPermGlobalView()) {
    $GLOBALS['xoopsTpl']->assign('error', _NOPERM);
    require __DIR__ . '/footer.php';
}

$keywords = [];
// 
$GLOBALS['xoopsTpl']->assign('xoops_icons32_url', XOOPS_ICONS32_URL);
$GLOBALS['xoopsTpl']->assign('wgsimpleacc_url', WGSIMPLEACC_URL);
$GLOBALS['xoopsTpl']->assign('refer', 'index');
$GLOBALS['xoopsTpl']->assign('op', $op);
$colors = Utility::getColors();
$GLOBALS['xoopsTpl']->assign('colors', $colors);
$GLOBALS['xoopsTpl']->assign('indexHeader', $helper->getConfig('index_header'));

//*************************
// handle transaction chart
//*************************
$transactionsCount = $transactionsHandler->getCountTransactions();
$GLOBALS['xoopsTpl']->assign('transactionsCount', $transactionsCount);
$count = 1;
$filter = '';
if ($transactionsCount > 0) {
    $GLOBALS['xoopsTpl']->assign('header_transactions', \_MA_WGSIMPLEACC_TRANSACTIONS_OVERVIEW . ': ' . $filterYear);
    //get all allocations
    $crAllocations           = new \CriteriaCompo();
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
    $tra_allocs_list = [];
    $strFilter = "&amp;filterYear=$filterYear&amp;filterType=$filterType";
    $strFilter .= "&amp;filterMonthFrom=$filterMonthFrom&amp;filterYearFrom=$filterYearFrom";
    $strFilter .= "&amp;filterMonthTo=$filterMonthTo&amp;filterYearTo=$filterYearTo";
    if ($allocationsCount > 0) {
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
            $href = 'index.php?op=' . $op . '&amp;all_pid=0&amp;level=1' .  $filter;
            $tra_allocs_list[] = ['all_id' => $allId, 'all_name' => ' << ', 'allSubs' => 0, 'href' => $href];
        }
        if ($level > 2) {
            $href = 'index.php?op=' . $op . '&amp;all_pid=' . $pidReturn . '&amp;level=' . ($level - 1) . $filter;
            $tra_allocs_list[] = ['all_id' => $allId, 'all_name' => ' < ', 'allSubs' => 0, 'href' => $href];
        }
        foreach (\array_keys($allocationsAll) as $i) {
            $allId   = $allocationsAll[$i]->getVar('all_id');
            $allName = $allocationsAll[$i]->getVar('all_name');
            $allocations_list[] = ['all_id' => $allId, 'all_name' => $allName];
            $transactions_labels .= "'" . $allName . "',";
            $sumAmountin  = 0;
            $sumAmountout = 0;
            //create filter
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
                if ($filterType > Constants::FILTER_TYPEALL) {
                    $dtime = \DateTime::createFromFormat('Y-m-d', "$filterYearFrom-$filterMonthFrom-1");
                    $tradateFrom = $dtime->getTimestamp();
                    $last = \DateTime::createFromFormat('Y-m-d', "$filterYearTo-$filterMonthTo-1")->format('Y-m-t');
                    $dtime = \DateTime::createFromFormat('Y-m-d', $last);
                    $tradateTo= $dtime->getTimestamp();
                }
            }

            $subAllIds = $allocationsHandler->getSubsOfAllocations($allId);
            foreach ($subAllIds as $subAllId) {
                $crTransactions = new \CriteriaCompo();
                $crTransactions->add(new \Criteria('tra_allid', $subAllId));
                $crTransactions->add(new \Criteria('tra_date', $tradateFrom, '>='));
                $crTransactions->add(new \Criteria('tra_date', $tradateTo, '<='));
                $transactionsCount = $transactionsHandler->getCount($crTransactions);
                $transactionsAll   = $transactionsHandler->getAll($crTransactions);
                if ($transactionsCount > 0) {
                    foreach (\array_keys($transactionsAll) as $i) {
                        $sumAmountin += $transactionsAll[$i]->getVar('tra_amountin');
                        $sumAmountout += $transactionsAll[$i]->getVar('tra_amountout');
                    }
                }
                unset($crTransactions);
            }
            $href = 'index.php?op=' . $op . '&amp;all_pid=' . $allId . '&amp;level=' . ($level + 1) . $filter;
            $tra_allocs_list[] = ['all_id' => $allId, 'all_name' => $allName, 'allSubs' => \count($subAllIds), 'href' => $href];
            $transactions_datain .= $sumAmountin . ',';
            $transactions_dataout .= $sumAmountout . ',';
        }
    }
    unset($crAllocations);
    $GLOBALS['xoopsTpl']->assign('tra_allocs_list', $tra_allocs_list);
    $GLOBALS['xoopsTpl']->assign('transactions_datain', $transactions_datain);
    $GLOBALS['xoopsTpl']->assign('transactions_dataout', $transactions_dataout);
    $GLOBALS['xoopsTpl']->assign('transactions_labels', $transactions_labels);
}
unset($count);

//*************************
// handle assets chart
//*************************
$assetsCurrent = $assetsHandler->getCurrentAssetsValues();
$assetsCount = \count($assetsCurrent);
if ($assetsCount > 0) {
    $GLOBALS['xoopsTpl']->assign('header_assets_pie', \_MA_WGSIMPLEACC_ASSETS_CURRENT);
    $GLOBALS['xoopsTpl']->assign('assetsCount', $assetsCount);
    $assets_data = '';
    $assets_labels = '';
    $assets_total = 0;
    $pcolors = [];
    $assetList = [];
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

// Breadcrumbs
$xoBreadcrumbs[] = ['title' => \_MA_WGSIMPLEACC_INDEX];
// Keywords
wgsimpleaccMetaKeywords($helper->getConfig('keywords') . ', ' . \implode(',', $keywords));
unset($keywords);
// Description
wgsimpleaccMetaDescription(\_MA_WGSIMPLEACC_INDEX_DESC);
$GLOBALS['xoopsTpl']->assign('xoops_mpageurl', WGSIMPLEACC_URL.'/index.php');
$GLOBALS['xoopsTpl']->assign('wgsimpleacc_upload_url', WGSIMPLEACC_UPLOAD_URL);
require __DIR__ . '/footer.php';
