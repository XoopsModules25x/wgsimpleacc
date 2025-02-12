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
 * @package        wgsimpleaccw
 * @author         Goffy - XOOPS Development Team - Email:<webmaster@wedega.com> - Website:<https://xoops.wedega.com>
 */

use Xmf\Request;
use XoopsModules\Wgsimpleacc;
use XoopsModules\Wgsimpleacc\{
    Constants,
    Common,
    Utility
};

require __DIR__ . '/header.php';
require_once \XOOPS_ROOT_PATH . '/header.php';
$GLOBALS['xoopsTpl']->assign('template_sub', 'db:wgsimpleacc_transactions.tpl');

foreach ($styles as $style) {
    $GLOBALS['xoTheme']->addStylesheet($style, null);
}
$GLOBALS['xoTheme']->addScript('browse.php?Frameworks/jquery/jquery.js');

// Permissions
if (!$permissionsHandler->getPermTransactionsView()) {
    \redirect_header('index.php', 0);
}

$op            = Request::getCmd('op', 'list');
$start         = Request::getInt('start');
$limit         = Request::getInt('limit', $helper->getConfig('userpager'));
$traId         = Request::getInt('tra_id');
$traType       = Request::getInt('tra_type');
$allId         = Request::getInt('all_id');
$allSubs       = Request::getInt('allSubs');
$accId         = Request::getInt('acc_id');
$asId          = Request::getInt('as_id');
$cliId         = Request::getInt('cli_id');
$displayfilter = Request::getInt('displayfilter');
if ('listhist' === $op || 'showhist' === $op) {
    // if showing historical transactions then take full period
    $dateFrom = 1;
    $crTransactions = new \CriteriaCompo();
    $crTransactions->setSort('tra_id');
    $crTransactions->setOrder('ASC');
    $crTransactions->setStart();
    $crTransactions->setLimit(1);
    $transactionsAll = $transactionsHandler->getAll($crTransactions);
    if ($transactionsHandler->getCount($crTransactions) > 0) {
        foreach (\array_keys($transactionsAll) as $i) {
            $dateFrom = (int)$transactionsAll[$i]->getVar('tra_datecreated');
        }
    }
    $GLOBALS['xoopsTpl']->assign('histOp','hist');
} else {
    // if showing current transaction list then exent to one month before
    $dateFrom = Request::getInt('dateFrom', \time() - 60*60*24*365);
}
if (Request::hasVar('filterFrom')) {
    $dateFrom = \DateTime::createFromFormat(\_SHORTDATESTRING, Request::getString('filterFrom'))->getTimestamp();
}
$dateTo = Request::getInt('dateTo', \time() + 60*60*24*365);
if (Request::hasVar('filterTo')) {
    $dateTo = \DateTime::createFromFormat(\_SHORTDATESTRING, Request::getString('filterTo'))->getTimestamp();
}
$filterInvalid = Request::getInt('filterInvalid');
$traStatus = [];
if (Request::hasVar('filterStatus')) {
    $traStatus  = Request::getArray('filterStatus');
} else {
    $traStatus = \explode('_', Request::getString('tra_status'));
}
$traDesc = Request::getString('tra_desc');
$sortBy  = Request::getString('sortby', 'tra_id');
$order   = Request::getString('order', 'desc');

// create string with arguments for filtering/sorting
$traFilter = '&amp;all_id=' . $allId . '&amp;acc_id=' . $accId . '&amp;as_id=' . $asId;
$traFilter .= '&amp;dateFrom=' . $dateFrom . '&amp;dateTo=' . $dateTo;
$traFilter .= '&amp;displayfilter=' . $displayfilter . '&amp;allSubs=' . $allSubs . '&amp;filterInvalid=' . $filterInvalid;
$traFilter .= '&amp;cli_id=' . $cliId . '&amp;tra_type=' . $traType;
$traFilter .= '&amp;tra_status=' . \implode('_', $traStatus);

$traOpSorter = '&amp;start=' . $start . '&amp;limit=' . $limit . $traFilter;
$traOp = $traOpSorter . '&amp;sortby=' . $sortBy . '&amp;order=' . $order;

$GLOBALS['xoopsTpl']->assign('traOp',$traOp);
$GLOBALS['xoopsTpl']->assign('wgsimpleacc_upload_files_url', \WGSIMPLEACC_UPLOAD_FILES_URL);

$permSubmit = $permissionsHandler->getPermTransactionsSubmit();
$GLOBALS['xoopsTpl']->assign('permSubmit', $permSubmit);
$permApprove = $permissionsHandler->getPermTransactionsApprove();
$GLOBALS['xoopsTpl']->assign('permApprove', $permApprove);
$GLOBALS['xoopsTpl']->assign('showItem', $traId > 0);

if (0 == $displayfilter || $traId > 0) {
    $GLOBALS['xoopsTpl']->assign('displayfilter', 'none');
    $GLOBALS['xoopsTpl']->assign('btnfilter', \_MA_WGSIMPLEACC_FILTER_SHOW);
} else {
    $GLOBALS['xoopsTpl']->assign('btnfilter', \_MA_WGSIMPLEACC_FILTER_HIDE);
}
$GLOBALS['xoopsTpl']->assign('sepComma', $helper->getConfig('sep_comma'));
$GLOBALS['xoopsTpl']->assign('sepThousand', $helper->getConfig('sep_thousand'));

$keywords = [];

switch ($op) {
    case 'show':
    case 'showhist':
    case 'list':
    default:
        $GLOBALS['xoopsTpl']->assign('showList', true);
        $GLOBALS['xoopsTpl']->assign('listHead', \_MA_WGSIMPLEACC_TRANSACTIONS_LIST);
        $GLOBALS['xoopsTpl']->assign('permDelete', true);
        $GLOBALS['xoTheme']->addScript(\WGSIMPLEACC_URL . '/assets/js/forms.js');
        if (0 == $traId) {
            $formFilter = $transactionsHandler::getFormFilter($dateFrom, $dateTo, $allId, $asId, $accId, $cliId, 'list', $allSubs, $traStatus, $traDesc, $filterInvalid, $limit);
            $GLOBALS['xoopsTpl']->assign('formFilter', $formFilter->render());
        }
        $crTransactions = new \CriteriaCompo();
        $transactionsCountTotal = $transactionsHandler->getCount($crTransactions);
        if ($traId > 0) {
            $crTransactions->add(new \Criteria('tra_id', $traId));
        } else {
            $crTransactions->add(new \Criteria('tra_date', $dateFrom, '>='));
            $crTransactions->add(new \Criteria('tra_date', $dateTo, '<='));
        }
        if ($allId > 0) {
            if ($allSubs) {
                $subAllIds = $allocationsHandler->getSubsOfAllocations($allId);
                $critAllIds = '(' . \implode(',', $subAllIds) . ')';
                $crTransactions->add(new \Criteria('tra_allid', $critAllIds, 'IN'));
            } else {
                $crTransactions->add(new \Criteria('tra_allid', $allId));
            }
        }
        if ($asId > 0) {
            $crTransactions->add(new \Criteria('tra_asid', $asId));
        }
        if ($accId > 0) {
            $crTransactions->add(new \Criteria('tra_accid', $accId));
        }
        if ($cliId > 0) {
            $crTransactions->add(new \Criteria('tra_cliid', $cliId));
        }
        if (\count($traStatus) > 0 && '' !== (string)$traStatus[0]) {
            $critStatus = '(' . \implode(',', $traStatus) . ')';
            $crTransactions->add(new \Criteria('tra_status', $critStatus, 'IN'));
        } else {
            if ('showhist' !== $op) {
                $crTransactions->add(new \Criteria('tra_status', Constants::TRASTATUS_DELETED, '>'));
            }
        }

        if ('' !== $traDesc) {
            $crTransactions->add(new \Criteria('tra_desc', $traDesc, 'LIKE'));
        }
        $transactionsCount = $transactionsHandler->getCount($crTransactions);
        $GLOBALS['xoopsTpl']->assign('transactionsCount', $transactionsCount);
        if (0 === $traId) {
            $crTransactions->setStart($start);
            $crTransactions->setLimit($limit);
        }
        $crTransactions->setSort($sortBy);
        $crTransactions->setOrder($order);
        $transactionsAll = $transactionsHandler->getAll($crTransactions);
        if ($transactionsCount > 0) {
            $transactions = [];
            // Get All Transactions
            if ('list' === $op) {
                $sumAmountIn = ['total' => 0, 'submitted' => 0, 'approved' => 0];
                $sumAmountOut = ['total' => 0, 'submitted' => 0, 'approved' => 0];
            }
            foreach (\array_keys($transactionsAll) as $i) {
                $transactions[$i] = $transactionsAll[$i]->getValuesTransactions();
                $transactions[$i]['editable'] = $permissionsHandler->getPermTransactionsEdit($transactions[$i]['tra_submitter'], $transactions[$i]['tra_status'], $transactions[$i]['tra_balid']);
                $transactions[$i]['waiting'] = (Constants::TRASTATUS_SUBMITTED === (int)$transactions[$i]['tra_status']);
                if ($traId > 0) {
                    $transactions[$i]['tratemplate'] = $permissionsHandler->getPermTratemplatesSubmit();
                }
                if ('' !== (string)$transactions[$i]['tra_remarks']) {
                    $transactions[$i]['modaltitle'] = \str_replace('%s', $transactions[$i]['year_nb'], \_MA_WGSIMPLEACC_MODAL_TRATITLE);
                }
                // get list of possible output templates
                $outputTpls = [];
                //$outputTpls[] = ['href' => 'transactions_pdf.php?tra_id=', 'title' => \_MA_WGSIMPLEACC_DOWNLOAD, 'class' => 'fa fa-file-pdf-o fa-fw', 'caption' => \_MA_WGSIMPLEACC_OUTTEMPLATE_DEFAULT];
                $crOuttemplates = new \CriteriaCompo();
                $crOuttemplates->add(new \Criteria('otpl_online', 1));
                $outtemplatesAll = $outtemplatesHandler->getAll($crOuttemplates);
                foreach (\array_keys($outtemplatesAll) as $j) {
                    $otplType = $outtemplatesAll[$j]->getVar('otpl_type');
                    $showOtpl = false;
                    $arrAllid  = \unserialize($outtemplatesAll[$j]->getVar('otpl_allid'), ['allowed_classes' => false]);
                    if (0 == (int)$arrAllid[0] || \in_array($transactionsAll[$i]->getVar('tra_allid'), $arrAllid)) {
                        $arrAccid  = \unserialize($outtemplatesAll[$j]->getVar('otpl_accid'), ['allowed_classes' => false]);
                        if (0 == (int)$arrAccid[0] || \in_array($transactionsAll[$i]->getVar('tra_accid'), $arrAccid)) {
                            $showOtpl = true;
                        }
                    }
                    if ($showOtpl) {
                        switch ($otplType) {
                            case Constants::OUTTEMPLATE_TYPE_READY:
                                $outputOp = 'exec_output&amp;target=pdf';
                                break;
                            case Constants::OUTTEMPLATE_TYPE_FORM:
                                $outputOp = 'exec_output&amp;target=editoutput';
                                break;
                            case 0:
                            default:
                                $outputOp = 'exec_output&amp;target=browser';
                                break;
                        }
                        $outputTpls[] = [
                            'href' => 'outtemplates.php?op=' . $outputOp . '&amp;otpl_id=' . $outtemplatesAll[$j]->getVar('otpl_id') . '&amp;tra_id=' . $transactions[$i]['tra_id'],
                            'title' => $outtemplatesAll[$j]->getVar('otpl_name'),
                            'type' => $otplType,
                            'caption' => $outtemplatesAll[$j]->getVar('otpl_name')
                        ];
                    }
                }
                if (\count($outputTpls) > 0){
                    $transactions[$i]['outputTpls'] = $outputTpls;
                }
                unset($crOuttemplates, $outtemplates);
                if ('list' === $op) {
                    // get sums of different amounts
                    if (Constants::CLASS_INCOME === (int)$transactions[$i]['tra_class']) {
                        $amount = $transactions[$i]['tra_amountin'];
                        $sumAmountIn['total'] = (float)$sumAmountIn['total'] + $amount;
                        if (Constants::TRASTATUS_SUBMITTED === (int)$transactions[$i]['tra_status']) {
                            $sumAmountIn['submitted'] = (float)$sumAmountIn['submitted'] + $amount;
                        }
                        if (Constants::TRASTATUS_APPROVED === (int)$transactions[$i]['tra_status']) {
                            $sumAmountIn['approved'] = (float)$sumAmountIn['approved'] + $amount;
                        }
                    }
                    if (Constants::CLASS_EXPENSES === (int)$transactions[$i]['tra_class']) {
                        $amount = $transactions[$i]['tra_amountout'];
                        $sumAmountOut['total'] = $sumAmountOut['total'] + $amount;
                        if (Constants::TRASTATUS_SUBMITTED === (int)$transactions[$i]['tra_status']) {
                            $sumAmountOut['submitted'] = $sumAmountOut['submitted'] + $amount;
                        }
                        if (Constants::TRASTATUS_APPROVED === (int)$transactions[$i]['tra_status']) {
                            $sumAmountOut['approved'] = $sumAmountOut['approved'] + $amount;
                        }
                    }
                }
                $keywords[$i] = $transactionsAll[$i]->getVar('tra_desc');
            }
            if ('list' === $op) {
                $sumAmountIn = [
                    'total' => Utility::FloatToString(\round($sumAmountIn['total'], 2)),
                    'submitted' => Utility::FloatToString(\round($sumAmountIn['submitted'], 2)),
                    'approved' => Utility::FloatToString(\round($sumAmountIn['approved'], 2))
                ];
                $sumAmountOut = [
                    'total' => Utility::FloatToString(\round($sumAmountOut['total'], 2)),
                    'submitted' => Utility::FloatToString(\round($sumAmountOut['submitted'], 2)),
                    'approved' => Utility::FloatToString(\round($sumAmountOut['approved'], 2))
                ];
                $GLOBALS['xoopsTpl']->assign('sumAmountIn', $sumAmountIn);
                $GLOBALS['xoopsTpl']->assign('sumAmountOut', $sumAmountOut);
            }
            $GLOBALS['xoopsTpl']->assign('transactions', $transactions);
            unset($transactions);
            // Display Navigation
            if ($transactionsCount > $limit) {
                require_once \XOOPS_ROOT_PATH . '/class/pagenav.php';
                $pagenav = new \XoopsPageNav($transactionsCount, $limit, $start, 'start', 'op=list&amp;limit=' . $limit . $traFilter);
                $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav());
            }
            $GLOBALS['xoopsTpl']->assign('showAssets', 0 === $asId);
            $GLOBALS['xoopsTpl']->assign('sort_order', \strtolower($sortBy . '_' . $order));
            $GLOBALS['xoopsTpl']->assign('useCurrencies', $helper->getConfig('use_currencies'));
            $GLOBALS['xoopsTpl']->assign('useTaxes', $helper->getConfig('use_taxes'));
            $GLOBALS['xoopsTpl']->assign('useFiles', $helper->getConfig('use_files'));
            $GLOBALS['xoopsTpl']->assign('useClients', $helper->getConfig('use_clients'));
            $GLOBALS['xoopsTpl']->assign('useProcessing', $helper->getConfig('use_processing'));
            $GLOBALS['xoopsTpl']->assign('modPathIcon32', \WGSIMPLEACC_URL . '/' . $GLOBALS['xoopsModule']->getInfo('modicons32') . '/');

        } else {
            if ($transactionsCountTotal > 0) {
                $GLOBALS['xoopsTpl']->assign('noData', \_MA_WGSIMPLEACC_FILTER_NO_TRANSACTIONS);
            } else {
                $GLOBALS['xoopsTpl']->assign('noData', \_MA_WGSIMPLEACC_THEREARENT_TRANSACTIONS);
            }
        }
        $GLOBALS['xoopsTpl']->assign('traOpSorter',$traOpSorter);

        // Breadcrumbs
        $xoBreadcrumbs[] = ['title' => \_MA_WGSIMPLEACC_TRANSACTIONS];

        break;
    case 'save':
        // Security Check
        if (!$GLOBALS['xoopsSecurity']->check()) {
            \redirect_header('transactions.php', 3, \implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        // Check permissions
        if (!$permissionsHandler->getPermTransactionsSubmit()) {
            \redirect_header('transactions.php?op=list', 3, \_NOPERM);
        }

        $traDate = \DateTime::createFromFormat(\_SHORTDATESTRING, Request::getString('tra_date'))->getTimestamp();
        $traYear = Request::getInt('tra_year');
        $traNb   = Request::getInt('tra_nb');
        if ($traId > 0) {
            $transactionsObj = $transactionsHandler->get($traId);
            if ($helper->getConfig('use_trahistories')) {
                $traHist = $transactionsHandler->saveHistoryTransactions($traId);
            }
        } else {
            $transactionsObj = $transactionsHandler->create();
            $traHist = 0;
            $traYear = date('Y', $traDate);
            $traNb   = 0;
            $crTransactions = new \CriteriaCompo();
            $crTransactions->add(new \Criteria('tra_year', $traYear));
            $crTransactions->setSort('tra_nb');
            $crTransactions->setOrder('DESC');
            $crTransactions->setStart();
            $crTransactions->setLimit(1);
            $transactionsAll = $transactionsHandler->getAll($crTransactions);
            if ($transactionsHandler->getCount($crTransactions) > 0) {
                foreach (\array_keys($transactionsAll) as $i) {
                    $traNb = (int)$transactionsAll[$i]->getVar('tra_nb');
                }
                $traNb++;
            } else  {
                $traNb = 1;
            }
        }
        $transactionsObj->setVar('tra_year', $traYear);
        $transactionsObj->setVar('tra_nb', $traNb);
        $transactionsObj->setVar('tra_desc', Request::getText('tra_desc'));
        $transactionsObj->setVar('tra_reference', Request::getString('tra_reference'));
        $transactionsObj->setVar('tra_remarks', Request::getText('tra_remarks'));
        $traAccid = Request::getInt('tra_accid');
        // catch cases when editing older transactions where account isn't valid anymore
        if (0 === $traAccid && Request::hasVar('tra_accid_old')) {
            $traAccid = Request::getInt('tra_accid_old');
        }
        $transactionsObj->setVar('tra_accid', $traAccid);
        $traAllid = Request::getInt('tra_allid');
        // catch cases when editing older transactions where account isn't valid anymore
        if (0 === $traAllid && Request::hasVar('tra_allid_old')) {
            $traAllid = Request::getInt('tra_allid_old');
        }
        $transactionsObj->setVar('tra_allid', $traAllid);
        $transactionsObj->setVar('tra_date', $traDate);
        $transactionsObj->setVar('tra_curid', Request::getInt('tra_curid'));
        $traClass = Request::getInt('tra_class');
        $traAmount = Utility::StringToFloat(Request::getString('tra_amount'));
        if (Constants::CLASS_INCOME === $traClass) {
            $transactionsObj->setVar('tra_amountin', $traAmount);
            $transactionsObj->setVar('tra_amountout', 0);
        } elseif (Constants::CLASS_EXPENSES === $traClass) {
            $transactionsObj->setVar('tra_amountout', $traAmount);
            $transactionsObj->setVar('tra_amountin', 0);
        } else {
            $transactionsObj->setVar('tra_amountin', 0);
            $transactionsObj->setVar('tra_amountout', 0);
        }
        $transactionsObj->setVar('tra_taxid', Request::getInt('tra_taxid'));
        $transactionsObj->setVar('tra_asid', Request::getInt('tra_asid'));
        $transactionsObj->setVar('tra_balid', Request::getInt('tra_balid'));
        $transactionsObj->setVar('tra_cliid', Request::getInt('tra_cliid'));
        $transactionsObj->setVar('tra_status', Request::getInt('tra_status'));
        $transactionsObj->setVar('tra_comments', Request::getInt('tra_comments'));
        $transactionsObj->setVar('tra_class', $traClass);
        $transactionsObj->setVar('tra_hist', $traHist);
        $transactionsObj->setVar('tra_processing', Request::getInt('tra_processing'));
        $transactionsObj->setVar('tra_datecreated', Request::getInt('tra_datecreated'));
        $transactionsObj->setVar('tra_submitter', Request::getInt('tra_submitter'));
        // Insert Data
        if ($transactionsHandler->insert($transactionsObj)) {
            $newTraId = $traId > 0 ? $traId : $transactionsObj->getNewInsertedIdTransactions();
            $grouppermHandler = \xoops_getHandler('groupperm');
            $mid = $GLOBALS['xoopsModule']->getVar('mid');
            // Handle notification
            $traDesc = \trim(\preg_replace('#<[^>]+>#', ' ', $transactionsObj->getVar('tra_desc')));
            $traStatus = $transactionsObj->getVar('tra_status');
            $tags = [];
            $tags['ITEM_NAME'] = $traDesc;
            $tags['ITEM_URL']  = \XOOPS_URL . '/modules/wgsimpleacc/transactions.php?op=show&tra_id=' . $newTraId;
            $notificationHandler = \xoops_getHandler('notification');
            if (Constants::TRASTATUS_SUBMITTED == $traStatus) {
                if (0 === $traId) {
                    // Event new notification
                    $notificationHandler->triggerEvent('global', 0, 'global_new', $tags);
                }
                // Event approve notifications
                $notificationHandler->triggerEvent('global', 0, 'global_approve', $tags);
                $notificationHandler->triggerEvent('transactions', $newTraId, 'transaction_approve', $tags);
            } else {
                if ($traId > 0) {
                    // Event modify notification
                    $notificationHandler->triggerEvent('global', 0, 'global_modify', $tags);
                    $notificationHandler->triggerEvent('transactions', $newTraId, 'transaction_modify', $tags);
                } else {
                    // Event new notification
                    $notificationHandler->triggerEvent('global', 0, 'global_new', $tags);
                }
            }
            // redirect after insert
            \redirect_header('transactions.php?op=list' . $traOp . '#traId_' . $newTraId, 2, \_MA_WGSIMPLEACC_FORM_OK);
        }
        // Get Form Error
        $GLOBALS['xoopsTpl']->assign('error', $transactionsObj->getHtmlErrors());
        $form = $transactionsObj->getFormTransactions();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'new':
        // Check permissions
        if (!$permissionsHandler->getPermTransactionsSubmit()) {
            \redirect_header('transactions.php?op=list', 3, \_NOPERM);
        }

        $GLOBALS['xoTheme']->addScript(\WGSIMPLEACC_URL . '/assets/js/forms.js');
        if ($helper->getConfig('use_clients')) {
            $GLOBALS['xoTheme']->addScript(\WGSIMPLEACC_URL . '/assets/select-autocomplete/jquery-ui.min.js');
            $GLOBALS['xoTheme']->addStylesheet(\WGSIMPLEACC_URL . '/assets/select-autocomplete/jquery-ui.min.css');
            $GLOBALS['xoTheme']->addStylesheet(\WGSIMPLEACC_URL . '/assets/select-autocomplete/select-autocomplete.css');
            $GLOBALS['xoopsTpl']->assign('js_autocomplete', true);
        }
        // Form Create
        $transactionsObj = $transactionsHandler->create();
        $form = $transactionsObj->getFormTransactions(false, false, $traType, $start, $limit);
        $GLOBALS['xoopsTpl']->assign('form', $form->render());

        // Breadcrumbs
        $xoBreadcrumbs[] = ['title' => \_MA_WGSIMPLEACC_TRANSACTIONS, 'link' => 'transactions.php?op=list'];
        $xoBreadcrumbs[] = ['title' => \_MA_WGSIMPLEACC_TRANSACTION_ADD];

        break;
    case 'history':
        $GLOBALS['xoopsTpl']->assign('showHist', true);
        //get current version
        $transactions = [];
        $crTransactions = new \CriteriaCompo();
        $crTransactions->add(new \Criteria('tra_id', $traId));
        $transactionsCount = $transactionsHandler->getCount($crTransactions);
        $transactionsAll = $transactionsHandler->getAll($crTransactions);
        if ($transactionsCount > 0) {
            // Get All Transactions
            foreach (\array_keys($transactionsAll) as $i) {
                $transactions[] = $transactionsAll[$i]->getValuesTransactions();
            }
        }
        //get history versions
        $crHistory = new \CriteriaCompo();
        $crHistory->add(new \Criteria('tra_id', $traId));
        $crHistory->setSort('hist_id');
        $crHistory->setOrder('DESC');
        $trahistorCount = $trahistoriesHandler->getCount($crHistory);
        $trahistorAll = $trahistoriesHandler->getAll($crHistory);
        if ($trahistorCount > 0) {
            // Get All Transactions
            foreach (\array_keys($trahistorAll) as $i) {
                $transactions[] = $trahistorAll[$i]->getValuesTrahistories();
            }
        }

        $GLOBALS['xoopsTpl']->assign('historyTransactions', $transactions);

        unset($crTransactions, $crHistory, $transactions);

        $GLOBALS['xoopsTpl']->assign('traOp',$traOp);

        // Breadcrumbs
        $xoBreadcrumbs[] = ['title' => \_MA_WGSIMPLEACC_TRANSACTIONS, 'link' => 'transactions.php?op=list'];
        $xoBreadcrumbs[] = ['title' => \_MA_WGSIMPLEACC_TRANSACTION_HIST];
        break;
    case 'edit':
    case 'approve':
        // Check params
        if (0 === $traId) {
            \redirect_header('transactions.php?op=list', 3, \_MA_WGSIMPLEACC_INVALID_PARAM);
        }
        $approve = ('approve' === $op);

        // Check permissions
        if ($approve && !$permissionsHandler->getPermTransactionsApprove()) {
            \redirect_header('transactions.php?op=list', 3, \_NOPERM);
        }

        $GLOBALS['xoTheme']->addScript(\WGSIMPLEACC_URL . '/assets/js/forms.js');
        if ($helper->getConfig('use_clients')) {
            $GLOBALS['xoTheme']->addScript(\WGSIMPLEACC_URL . '/assets/select-autocomplete/jquery-ui.min.js');
            $GLOBALS['xoTheme']->addStylesheet(\WGSIMPLEACC_URL . '/assets/select-autocomplete/jquery-ui.min.css');
            $GLOBALS['xoTheme']->addStylesheet(\WGSIMPLEACC_URL . '/assets/select-autocomplete/select-autocomplete.css');
            $GLOBALS['xoopsTpl']->assign('js_autocomplete', true);
        }

        $transactionsObj = $transactionsHandler->get($traId);
        $traSubmitter = $transactionsObj->getVar('tra_submitter');
        $traStatus = $transactionsObj->getVar('tra_status');
        if (!$permissionsHandler->getPermTransactionsEdit($traSubmitter, $traStatus, $transactionsObj->getVar('tra_balid'))) {
            \redirect_header('transactions.php?op=list', 3, \_NOPERM);
        }
        // Get Form
        $GLOBALS['xoTheme']->addScript(\WGSIMPLEACC_URL . '/assets/js/forms.js');
        $form = $transactionsObj->getFormTransactions(false, false, 0, $start, $limit, $approve);
        $GLOBALS['xoopsTpl']->assign('form', $form->render());

        // Breadcrumbs
        $xoBreadcrumbs[] = ['title' => \_MA_WGSIMPLEACC_TRANSACTIONS, 'link' => 'transactions.php?op=list'];
        $xoBreadcrumbs[] = ['title' => \_MA_WGSIMPLEACC_TRANSACTION_EDIT];
        break;
    case 'delete':
        // Check params
        if (0 === $traId) {
            \redirect_header('transactions.php?op=list', 3, \_MA_WGSIMPLEACC_INVALID_PARAM);
        }
        // Check permissions
        if (!$permissionsHandler->getPermTransactionsSubmit()) {
            \redirect_header('transactions.php?op=list', 3, \_NOPERM);
        }
        $transactionsObj = $transactionsHandler->get($traId);
        $traSubmitter = $transactionsObj->getVar('tra_submitter');
        $traStatus = $transactionsObj->getVar('tra_status');
        if (!$permissionsHandler->getPermTransactionsEdit($traSubmitter, $traStatus, $transactionsObj->getVar('tra_balid'))) {
            \redirect_header('transactions.php?op=list', 3, \_NOPERM);
        }
        if ($helper->getConfig('use_trahistories')) {
            //create history
            $transactionsHandler->saveHistoryTransactions($traId, 'delete');
        }
        $traDesc = $transactionsObj->getVar('tra_desc');
        if (isset($_REQUEST['ok']) && 1 === (int)$_REQUEST['ok']) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                \redirect_header('transactions.php', 3, \implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            $transactionsObj->setVar('tra_status', Constants::TRASTATUS_DELETED);
            if ($transactionsHandler->insert($transactionsObj)) {
                // Transaction delete notification
                $tags = [];
                $tags['ITEM_NAME'] = $traDesc;
                $notificationHandler = \xoops_getHandler('notification');
                $notificationHandler->triggerEvent('global', 0, 'global_delete', $tags);
                $notificationHandler->triggerEvent('transactions', $traId, 'transaction_delete', $tags);
                \redirect_header('transactions.php', 3, \_MA_WGSIMPLEACC_FORM_DELETE_OK);
            } else {
                $GLOBALS['xoopsTpl']->assign('error', $transactionsObj->getHtmlErrors());
            }
        } else {
            $info = $transactionsObj->getVar('tra_year') . '/' . $transactionsObj->getVar('tra_nb');
            if ('' !== (string)$transactionsObj->getVar('tra_desc')) {
                $info .= $transactionsObj->getVar('tra_desc');
            }
            $customConfirm = new Common\Confirm(
                ['ok' => 1, 'tra_id' => $traId, 'op' => 'delete'],
                $_SERVER['REQUEST_URI'],
                \sprintf(\_MA_WGSIMPLEACC_FORM_SURE_DELETE, $info), _MA_WGSIMPLEACC_FORM_DELETE_CONFIRM, _MA_WGSIMPLEACC_FORM_DELETE_LABEL);
            $form = $customConfirm->getFormConfirm();
            $GLOBALS['xoopsTpl']->assign('form', $form->render());

            // Breadcrumbs
            $xoBreadcrumbs[] = ['title' => \_MA_WGSIMPLEACC_TRANSACTIONS, 'link' => 'transactions.php?op=list'];
            $xoBreadcrumbs[] = ['title' => \_MA_WGSIMPLEACC_TRANSACTION_EDIT];
        }
        break;
    case 'listhist':
        $GLOBALS['xoopsTpl']->assign('showList', true);
        $GLOBALS['xoopsTpl']->assign('listHist', true);
        $GLOBALS['xoopsTpl']->assign('listHead', \_MA_WGSIMPLEACC_TRAHISTORY_DELETED);
        $GLOBALS['xoopsTpl']->assign('permDelete', false);
        if (0 === $traId) {
            $formFilter = $transactionsHandler::getFormFilter($dateFrom, $dateTo, $allId, $asId, $accId, $cliId, 'listhist', 0, $traStatus, $traDesc, $filterInvalid, $limit);
            $GLOBALS['xoopsTpl']->assign('formFilter', $formFilter->render());
        }
        $crTransactions = new \CriteriaCompo();
        $crTransactions->add(new \Criteria('tra_status', Constants::TRASTATUS_DELETED));

        if ($traId > 0) {
            $crTransactions->add(new \Criteria('tra_id', $traId));
        } else {
            $crTransactions->add(new \Criteria('tra_datecreated', $dateFrom, '>='));
            $crTransactions->add(new \Criteria('tra_datecreated', $dateTo, '<='));
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
        /*
        if (\count($traStatus) > 0 && '' !== (string)$traStatus[0]) {
            $critStatus = '(' . \implode(',', $traStatus) . ')';
            $crTransactions->add(new \Criteria('tra_status', $critStatus, 'IN'));
        }
        */
        if ('' != $traDesc) {
            $crTransactions->add(new \Criteria('tra_desc', $traDesc, 'LIKE'));
        }

        $transactionsCount = $transactionsHandler->getCount($crTransactions);
        $GLOBALS['xoopsTpl']->assign('transactionsCount', $transactionsCount);
        if (0 === $traId) {
            $crTransactions->setStart($start);
            $crTransactions->setLimit($limit);
        }
        $crTransactions->setSort('tra_id');
        $crTransactions->setOrder('DESC');
        $transactionsAll = $transactionsHandler->getAll($crTransactions);
        if ($transactionsCount > 0) {
            $transactions = [];
            // Get All Transactions
            foreach (\array_keys($transactionsAll) as $i) {
                $transactions[$i] = $transactionsAll[$i]->getValuesTransactions();
                $transactions[$i]['editable'] = $permissionsHandler->getPermTransactionsEdit($transactions[$i]['tra_submitter'], $transactions[$i]['tra_status'], $transactions[$i]['tra_balid']);
                if ('' !== (string)$transactions[$i]['tra_remarks']) {
                    $transactions[$i]['modaltitle'] = \str_replace('%s', $transactions[$i]['year_nb'], \_MA_WGSIMPLEACC_MODAL_TRATITLE);
                }
                $keywords[$i] = $transactionsAll[$i]->getVar('tra_desc');
            }
            $GLOBALS['xoopsTpl']->assign('transactions', $transactions);
            unset($transactions);
            // Display Navigation
            if ($transactionsCount > $limit) {
                require_once \XOOPS_ROOT_PATH . '/class/pagenav.php';
                $pagenav = new \XoopsPageNav($transactionsCount, $limit, $start, 'start', 'op=listhist&amp;limit=' . $limit . $traFilter);
                $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav());
            }
            $GLOBALS['xoopsTpl']->assign('showAssets', 0 === $asId);
            $GLOBALS['xoopsTpl']->assign('useCurrencies', $helper->getConfig('use_currencies'));
            $GLOBALS['xoopsTpl']->assign('useTaxes', $helper->getConfig('use_taxes'));
            $GLOBALS['xoopsTpl']->assign('useFiles', $helper->getConfig('use_files'));
            $GLOBALS['xoopsTpl']->assign('useClients', $helper->getConfig('use_clients'));
        } else {
            $GLOBALS['xoopsTpl']->assign('noData', \_MA_WGSIMPLEACC_THEREARENT_TRAHISTORIES);
        }
        $GLOBALS['xoopsTpl']->assign('traOp',$traOp);

        // Breadcrumbs
        $xoBreadcrumbs[] = ['title' => \_MA_WGSIMPLEACC_TRANSACTIONS, 'link' => 'transactions.php?op=list'];
        $xoBreadcrumbs[] = ['title' => \_MA_WGSIMPLEACC_TRAHISTORY_DELETED];
        break;
}

// Keywords
wgsimpleaccMetaKeywords($helper->getConfig('keywords') . ', ' . \implode(',', $keywords));
unset($keywords);

// Description
wgsimpleaccMetaDescription(\_MA_WGSIMPLEACC_TRANSACTIONS_DESC);
$GLOBALS['xoopsTpl']->assign('xoops_mpageurl', \WGSIMPLEACC_URL.'/transactions.php');
$GLOBALS['xoopsTpl']->assign('wgsimpleacc_upload_url', \WGSIMPLEACC_UPLOAD_URL);

// View comments
require_once \XOOPS_ROOT_PATH . '/include/comment_view.php';

require __DIR__ . '/footer.php';
