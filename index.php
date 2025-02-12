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
$GLOBALS['xoopsTpl']->assign('template_sub', 'db:wgsimpleacc_index.tpl');

foreach ($styles as $style) {
    $GLOBALS['xoTheme']->addStylesheet($style, null);
}

$op       = Request::getCmd('op', 'list');
$allPid   = Request::getInt('all_pid');
$level    = Request::getInt('level', 1);
$dateFrom = \DateTime::createFromFormat('Y-m-d', \date('Y') . '-1-1')->getTimestamp();
$dateTo   = \time();
$filterType      = Request::getInt('filterType', Constants::FILTER_TYPEALL);

// Permissions
if (!$permissionsHandler->getPermGlobalView()) {
    $GLOBALS['xoopsTpl']->assign('errorPerm', _NOPERM);
    showLogin();
    require __DIR__ . '/footer.php';
    exit;
}

$keywords = [];
//
$GLOBALS['xoopsTpl']->assign('refer', 'index');
$GLOBALS['xoopsTpl']->assign('op', $op);
$colors = Utility::getColors();
$GLOBALS['xoopsTpl']->assign('colors', $colors);

$indexTrahbar        = $helper->getConfig('index_trahbar');
$indexTraInExSums    = $helper->getConfig('index_trainexsums');
$indexTraInExPie     = $helper->getConfig('index_trainexpie');
$indexAssetsPie      = $helper->getConfig('index_assetspie');
$indexAssetsPieTotal = $helper->getConfig('index_assetspietotal');
$GLOBALS['xoopsTpl']->assign('indexTrahbar', $indexTrahbar);
$GLOBALS['xoopsTpl']->assign('indexTraInExSums', $indexTraInExSums);
$GLOBALS['xoopsTpl']->assign('indexTraInExPie', $indexTraInExPie);
$GLOBALS['xoopsTpl']->assign('indexAssetsPie', $indexAssetsPie);
$GLOBALS['xoopsTpl']->assign('indexAssetsPieTotal', $indexAssetsPieTotal);

//create filter for
// - transaction hbar chart
// - assets pie chart

if ($indexTrahbar || $indexTraInExSums || $indexAssetsPie) {
//******************************
// handle transaction hbar chart
//******************************
    $transactionsCount = $transactionsHandler->getCountTransactions();
    $GLOBALS['xoopsTpl']->assign('transactionsCount', $transactionsCount);
    $count = 1;
    $filter = '';
    if ($transactionsCount > 0) {
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
        $allocationsAll = $allocationsHandler->getAll($crAllocations);
        $transactions_datain1 = '';
        $transactions_datain2 = '';
        $transactions_dataout1 = '';
        $transactions_dataout2 = '';
        $transactions_labels = '';
        $transactions_total_in = 0;
        $transactions_total_out = 0;
        $tra_allocs_list = [];
        $allPidName = '';
        if ($allocationsCount > 0) {
            if ($allPid > 0) {
                //read current allocations
                $allocCurrObj = $allocationsHandler->get($allPid);
                $allPidName = $allocCurrObj->getVar('all_name');
                $sumAmountin1 = 0; //approved
                $sumAmountout1 = 0; //approved
                $sumAmountin2 = 0; //submitted
                $sumAmountout2 = 0; //submitted
                $crTransactions = new \CriteriaCompo();
                $crTransactions->add(new \Criteria('tra_allid', $allPid));
                $crTransactions->add(new \Criteria('tra_date', $dateFrom, '>='));
                $crTransactions->add(new \Criteria('tra_date', $dateTo, '<='));
                $crTransactions->add(new \Criteria('tra_status', Constants::TRASTATUS_SUBMITTED, '>='));
                $transactionsAll = $transactionsHandler->getAll($crTransactions);
                foreach (\array_keys($transactionsAll) as $i) {
                    if (Constants::TRASTATUS_APPROVED == $transactionsAll[$i]->getVar('tra_status')) {
                        $sumAmountin1 += $transactionsAll[$i]->getVar('tra_amountin');
                        $sumAmountout1 += $transactionsAll[$i]->getVar('tra_amountout');
                    } elseif (Constants::TRASTATUS_SUBMITTED == $transactionsAll[$i]->getVar('tra_status')) {
                        $sumAmountin2 += $transactionsAll[$i]->getVar('tra_amountin');
                        $sumAmountout2 += $transactionsAll[$i]->getVar('tra_amountout');
                    }
                    $transactions_total_in += $transactionsAll[$i]->getVar('tra_amountin');
                    $transactions_total_out += $transactionsAll[$i]->getVar('tra_amountout');
                }

                if ((float)$sumAmountin1 > 0 || (float)$sumAmountout1 > 0 || (float)$sumAmountin2 > 0 || (float)$sumAmountout2 > 0) {
                    $transactions_datain1 .= $sumAmountin1 . ',';
                    $transactions_datain2 .= $sumAmountin2 . ',';
                    $transactions_dataout1 .= $sumAmountout1 . ',';
                    $transactions_dataout2 .= $sumAmountout2 . ',';
                    $transactions_labels .= "'" . \str_replace('%s', $allPidName, \_MA_WGSIMPLEACC_ALLOCATION_CURRID) . "',";
                }

                unset($crAllocCur, $allocCurObj, $crTransactions);
            }
            // Go through all allocations
            $crAlloc2 = new \CriteriaCompo();
            $crAlloc2->add(new \Criteria('all_id', $allPid));
            $alloc2Count = $allocationsHandler->getCount($crAlloc2);
            if ($alloc2Count > 0) {
                $alloc2All = $allocationsHandler->getAll($crAlloc2);
                // Go through all allocations
                foreach (\array_keys($alloc2All) as $j) {
                    $pidReturn = $alloc2All[$j]->getVar('all_pid');
                }
            }
            if ($level > 1) {
                $href = 'index.php?op=' . $op . '&amp;all_pid=0&amp;level=1' . $filter;
                $tra_allocs_list[] = ['all_id' => 0, 'all_name' => ' << ', 'allSubs' => 0, 'href' => $href];
            }
            if ($level > 2) {
                $href = 'index.php?op=' . $op . '&amp;all_pid=' . $pidReturn . '&amp;level=' . ($level - 1) . $filter;
                $tra_allocs_list[] = ['all_id' => 0, 'all_name' => ' < ', 'allSubs' => 0, 'href' => $href];
            }
            foreach (\array_keys($allocationsAll) as $i) {
                $allId = $allocationsAll[$i]->getVar('all_id');
                $allName = $allocationsAll[$i]->getVar('all_name');
                $transactions_labels .= "'" . $allName . "',";
                $sumAmountin1 = 0; //approved
                $sumAmountout1 = 0; //approved
                $sumAmountin2 = 0; //submitted
                $sumAmountout2 = 0; //submitted
                $subAllIds = $allocationsHandler->getSubsOfAllocations($allId);
                foreach ($subAllIds as $subAllId) {
                    $crTransactions = new \CriteriaCompo();
                    $crTransactions->add(new \Criteria('tra_allid', $subAllId));
                    $crTransactions->add(new \Criteria('tra_date', $dateFrom, '>='));
                    $crTransactions->add(new \Criteria('tra_date', $dateTo, '<='));
                    $crTransactions->add(new \Criteria('tra_status', Constants::TRASTATUS_SUBMITTED, '>='));
                    $transactionsCount = $transactionsHandler->getCount($crTransactions);
                    $transactionsAll = $transactionsHandler->getAll($crTransactions);
                    if ($transactionsCount > 0) {
                        foreach (\array_keys($transactionsAll) as $t) {
                            if (Constants::TRASTATUS_APPROVED == $transactionsAll[$t]->getVar('tra_status')) {
                                $sumAmountin1 += $transactionsAll[$t]->getVar('tra_amountin');
                                $sumAmountout1 += $transactionsAll[$t]->getVar('tra_amountout');
                            } elseif (Constants::TRASTATUS_SUBMITTED == $transactionsAll[$t]->getVar('tra_status')) {
                                $sumAmountin2 += $transactionsAll[$t]->getVar('tra_amountin');
                                $sumAmountout2 += $transactionsAll[$t]->getVar('tra_amountout');
                            }
                            $transactions_total_in += $transactionsAll[$t]->getVar('tra_amountin');
                            $transactions_total_out += $transactionsAll[$t]->getVar('tra_amountout');
                        }
                    }
                    unset($crTransactions);
                }
                $href = 'index.php?op=' . $op . '&amp;all_pid=' . $allId . '&amp;level=' . ($level + 1) . $filter;
                $tra_allocs_list[] = ['all_id' => $allId, 'all_name' => $allName, 'allSubs' => \count($subAllIds), 'href' => $href];
                $transactions_datain1 .= $sumAmountin1 . ',';
                $transactions_datain2 .= $sumAmountin2 . ',';
                $transactions_dataout1 .= $sumAmountout1 . ',';
                $transactions_dataout2 .= $sumAmountout2 . ',';
            }
        }
        unset($crAllocations);
        $headerTra = '';
        $headerTraSums = '';
        if ('' !== $allPidName) {
            $headerTra .= "'" . $allPidName . "'<br>";
            $headerTraSums .= "'" . $allPidName . "'<br>";
        }
        $headerTra .= \_MA_WGSIMPLEACC_TRANSACTIONS_OVERVIEW . ': ' . \date('Y', $dateFrom);
        $headerTraSums .= \_MA_WGSIMPLEACC_CHART_TRAINEXSUMS . ': ' . \date('Y', $dateFrom);
        $GLOBALS['xoopsTpl']->assign('header_transactions', $headerTra);
        $GLOBALS['xoopsTpl']->assign('header_transactions_sums', $headerTraSums);
        $GLOBALS['xoopsTpl']->assign('tra_allocs_list', $tra_allocs_list);
        $GLOBALS['xoopsTpl']->assign('transactions_datain1', $transactions_datain1);
        $GLOBALS['xoopsTpl']->assign('transactions_datain2', $transactions_datain2);
        $GLOBALS['xoopsTpl']->assign('transactions_dataout1', $transactions_dataout1);
        $GLOBALS['xoopsTpl']->assign('transactions_dataout2', $transactions_dataout2);
        $GLOBALS['xoopsTpl']->assign('transactions_labels', $transactions_labels);
        $GLOBALS['xoopsTpl']->assign('transactions_total_in', Utility::FloatToString($transactions_total_in));
        $GLOBALS['xoopsTpl']->assign('transactions_total_in_val', $transactions_total_in);
        $GLOBALS['xoopsTpl']->assign('transactions_total_out', Utility::FloatToString($transactions_total_out));
        $GLOBALS['xoopsTpl']->assign('transactions_total_out_val', $transactions_total_out);
        $GLOBALS['xoopsTpl']->assign('transactions_total', Utility::FloatToString($transactions_total_in - $transactions_total_out));
        $GLOBALS['xoopsTpl']->assign('label_datain1', \_MA_WGSIMPLEACC_TRANSACTIONS_INCOMES . ' (' . \_MA_WGSIMPLEACC_TRASTATUS_APPROVED .')');
        $GLOBALS['xoopsTpl']->assign('label_datain2', \_MA_WGSIMPLEACC_TRANSACTIONS_INCOMES . ' (' . \_MA_WGSIMPLEACC_TRASTATUS_SUBMITTED .')');
        $GLOBALS['xoopsTpl']->assign('label_dataout1', \_MA_WGSIMPLEACC_TRANSACTIONS_EXPENSES . ' (' . \_MA_WGSIMPLEACC_TRASTATUS_APPROVED .')');
        $GLOBALS['xoopsTpl']->assign('label_dataout2', \_MA_WGSIMPLEACC_TRANSACTIONS_EXPENSES . ' (' . \_MA_WGSIMPLEACC_TRASTATUS_SUBMITTED .')');
    }
    unset($count);
}

if ($indexAssetsPie) {
//**************************
// handle assets chart total
//**************************
    $assetsCurrent = $assetsHandler->getAssetsValues($dateFrom, $dateTo, false, true);
    $assetsCount = \count($assetsCurrent);
    if ($assetsCount > 0) {
        $GLOBALS['xoopsTpl']->assign('assets_header', \_MA_WGSIMPLEACC_ASSETS_CURRENT  . ': ' . \date('Y', $dateFrom));
        $GLOBALS['xoopsTpl']->assign('assetsCount', $assetsCount);
        $assets_data = '';
        $assets_labels = '';
        $assets_total = 0;
        $pcolors = [];
        $assetList = [];
        foreach ($assetsCurrent as $asset) {
            if (1 === (int)$asset['iecalc']) {
                $amountVal = $asset['amount_end_val'] - $asset['amount_start_val'];
                $assets_data .= $amountVal . ',';
                $assets_labels .= "'" . $asset['name'] . "',";
                $assets_total += $amountVal;
                $pcolors[] = Utility::getColorName($colors, $asset['color']);
                $assetList[] = $asset;
            }
        }

        $GLOBALS['xoopsTpl']->assign('assets_displaylegend', 'false');
        $GLOBALS['xoopsTpl']->assign('assets_list', $assetList);
        $GLOBALS['xoopsTpl']->assign('assets_data', $assets_data);
        $GLOBALS['xoopsTpl']->assign('assets_pcolors', $pcolors);
        $GLOBALS['xoopsTpl']->assign('assets_labels', $assets_labels);
        $GLOBALS['xoopsTpl']->assign('assets_total', Wgsimpleacc\Utility::FloatToString($assets_total));
    }
}

if ($indexAssetsPieTotal) {
//**************************
// handle assets pie total
//**************************
    $assetsCurrent = $assetsHandler->getCurrentAssetsValues();
    $assetsTotalCount = \count($assetsCurrent);
    if ($assetsTotalCount > 0) {
        $GLOBALS['xoopsTpl']->assign('assetsTotal_header', \_MA_WGSIMPLEACC_ASSETSTOTAL_CURRENT);
        $GLOBALS['xoopsTpl']->assign('assetsTotalCount', $assetsTotalCount);
        $assets_data = '';
        $assets_labels = '';
        $assets_total = 0;
        $pcolors = [];
        $assetList = [];
        foreach ($assetsCurrent as $asset) {
            //if (1 === (int)$asset['iecalc'] && (float)$asset['amount_val'] <> 0) {
            if (1 === (int)$asset['iecalc']) {
                $assets_data .= $asset['amount_val'] . ',';
                $assets_labels .= "'" . $asset['name'] . "',";
                $assets_total += $asset['amount_val'];
                $pcolors[] = Utility::getColorName($colors, $asset['color']);
                $assetList[] = $asset;
            }
        }

        $GLOBALS['xoopsTpl']->assign('assetsTotal_displaylegend', 'false');
        $GLOBALS['xoopsTpl']->assign('assetsTotal_list', $assetList);
        $GLOBALS['xoopsTpl']->assign('assetsTotal_data', $assets_data);
        $GLOBALS['xoopsTpl']->assign('assetsTotal_pcolors', $pcolors);
        $GLOBALS['xoopsTpl']->assign('assetsTotal_labels', $assets_labels);
        $GLOBALS['xoopsTpl']->assign('assetsTotal_total', Wgsimpleacc\Utility::FloatToString($assets_total));
    }
}

// Breadcrumbs
$xoBreadcrumbs[] = ['title' => \_MA_WGSIMPLEACC_INDEX];
// Keywords
wgsimpleaccMetaKeywords($helper->getConfig('keywords') . ', ' . \implode(',', $keywords));
unset($keywords);
// Description
wgsimpleaccMetaDescription(\_MA_WGSIMPLEACC_INDEX_DESC);
$GLOBALS['xoopsTpl']->assign('xoops_mpageurl', \WGSIMPLEACC_URL . '/index.php');
$GLOBALS['xoopsTpl']->assign('wgsimpleacc_upload_url', \WGSIMPLEACC_UPLOAD_URL);
require __DIR__ . '/footer.php';

function showLogin() {
    global $xoopsConfig;
    xoops_loadLanguage('blocks', 'system');
    $GLOBALS['xoopsTpl']->assign('formLogin', true);
    $block                     = [];
    $block['lang_username']    = _USERNAME;
    $block['unamevalue']       = '';
    $block['lang_password']    = _PASSWORD;
    $block['lang_login']       = _LOGIN;
    $block['lang_lostpass']    = _MB_SYSTEM_LPASS;
    $block['lang_registernow'] = _MB_SYSTEM_RNOW;
    if ($xoopsConfig['use_ssl'] == 1 && $xoopsConfig['sslloginlink'] != '') {
        $block['sslloginlink'] = "<a href=\"javascript:openWithSelfMain('" . $xoopsConfig['sslloginlink'] . "', 'ssllogin', 300, 200);\">" . _MB_SYSTEM_SECURE . '</a>';
    } elseif ($GLOBALS['xoopsConfig']['usercookie']) {
        $block['lang_rememberme'] = _MB_SYSTEM_REMEMBERME;
    }
    $GLOBALS['xoopsTpl']->assign('block', $block);
}
