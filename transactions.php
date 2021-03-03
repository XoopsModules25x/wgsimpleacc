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
    Common,
    Utility
};

require __DIR__ . '/header.php';
$GLOBALS['xoopsOption']['template_main'] = 'wgsimpleacc_main_startmin.tpl';
require_once \XOOPS_ROOT_PATH . '/header.php';
$GLOBALS['xoopsTpl']->assign('template_sub', 'db:wgsimpleacc_transactions.tpl');
require_once __DIR__ . '/navbar.php';

// Permissions
if (!$permissionsHandler->getPermGlobalView()) {
    $GLOBALS['xoopsTpl']->assign('error', _NOPERM);
    require __DIR__ . '/footer.php';
}

$op              = Request::getCmd('op', 'list');
$start           = Request::getInt('start', 0);
$limit           = Request::getInt('limit', $helper->getConfig('userpager'));
$traId           = Request::getInt('tra_id', 0);
$traType         = Request::getInt('tra_type', 0);
$allId           = Request::getInt('all_id', 0);
$accId           = Request::getInt('acc_id', 0);
$asId            = Request::getInt('as_id', 0);
$filterYear      = Request::getInt('filterYear', 0);
$filterMonthFrom = Request::getInt('filterMonthFrom', 0);
$filterYearFrom  = Request::getInt('filterYearFrom', 0);
$filterMonthTo   = Request::getInt('filterMonthTo', 0);
$filterYearTo    = Request::getInt('filterYearTo', date('Y'));

$period_type = $helper->getConfig('balance_period');

// Define Stylesheet
$GLOBALS['xoTheme']->addStylesheet($style, null);

$GLOBALS['xoopsTpl']->assign('wgsimpleacc_icon_url_16', WGSIMPLEACC_ICONS_URL . '/16/');
$GLOBALS['xoopsTpl']->assign('xoops_icons32_url', XOOPS_ICONS32_URL);
$GLOBALS['xoopsTpl']->assign('wgsimpleacc_url', WGSIMPLEACC_URL);
$GLOBALS['xoopsTpl']->assign('wgsimpleacc_upload_files_url', WGSIMPLEACC_UPLOAD_FILES_URL);

$keywords = [];

$permSubmit = $permissionsHandler->getPermTransactionsSubmit();
$GLOBALS['xoopsTpl']->assign('permSubmit', $permSubmit);
$permApprove = $permissionsHandler->getPermTransactionsApprove();
$GLOBALS['xoopsTpl']->assign('permApprove', $permApprove);
$GLOBALS['xoopsTpl']->assign('showItem', $traId > 0);
$displayfilter    = Request::getInt('displayfilter', 0);
if (0 == $displayfilter || $traId > 0) {
    $GLOBALS['xoopsTpl']->assign('displayfilter', 'none');
    $GLOBALS['xoopsTpl']->assign('btnfilter', \_MA_WGSIMPLEACC_FILTER_SHOW);
} else {
    $GLOBALS['xoopsTpl']->assign('btnfilter', \_MA_WGSIMPLEACC_FILTER_HIDE);
}

$traOp = '&amp;start=' . $start . '&amp;limit=' . $limit . '&amp;all_id=' . $allId . '&amp;acc_id=' . $accId . '&amp;as_id=' . $asId;
$traOp .= '&amp;filterYear=' . $filterYear . '&amp;filterMonthFrom=' . $filterMonthFrom . '&amp;filterYearFrom=' . $filterYearFrom . '&amp;filterMonthTo=' . $filterMonthTo . '&amp;filterYearTo=' . $filterYearTo;
$traOp .= '&amp;displayfilter=' . $displayfilter;

switch ($op) {
	case 'show':
	case 'list':
	default:
        $GLOBALS['xoopsTpl']->assign('showList', true);
        $GLOBALS['xoopsTpl']->assign('listHead', \_MA_WGSIMPLEACC_TRANSACTIONS_LIST);
        $GLOBALS['xoopsTpl']->assign('permDelete', true);
        if (0 == $traId) {
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
            $formFilter = $transactionsHandler::getFormFilterTransactions($allId, $filterYear, $filterMonthFrom, $filterYearFrom, $filterMonthTo, $filterYearTo, $yearMin, $yearMax, $asId, $accId);
            $GLOBALS['xoopsTpl']->assign('formFilter', $formFilter->render());
        }
	    $crTransactions = new \CriteriaCompo();
		if ($traId > 0) {
			$crTransactions->add(new \Criteria('tra_id', $traId));
		} else {
            $crTransactions->add(new \Criteria('tra_status', Constants::STATUS_OFFLINE, '>'));
            $tradateFrom = 0;
            $tradateTo = \time() + (10 * 365 * 24 * 60 * 60);;
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
                $tradateTo= $dtime->getTimestamp();
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
        if (0 == $traId) {
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
                $transactions[$i]['editable'] = $permissionsHandler->getPermTransactionsEdit($transactions[$i]['tra_submitter'], $transactions[$i]['tra_status']);
                $transactions[$i]['waiting'] = (Constants::STATUS_SUBMITTED == $transactions[$i]['tra_status']);
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
				$pagenav = new \XoopsPageNav($transactionsCount, $limit, $start, 'start', 'op=list&limit=' . $limit . '&amp;all_id=' . $allId);
				$GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
			}
            $GLOBALS['xoopsTpl']->assign('showAssets', 0 == $asId);
			$GLOBALS['xoopsTpl']->assign('useCurrencies', $helper->getConfig('use_currencies'));
			$GLOBALS['xoopsTpl']->assign('useTaxes', $helper->getConfig('use_taxes'));
            $GLOBALS['xoopsTpl']->assign('useFiles', $helper->getConfig('use_files'));
            $GLOBALS['xoopsTpl']->assign('useClients', $helper->getConfig('use_clients'));
		} else {
            $GLOBALS['xoopsTpl']->assign('noData', \_MA_WGSIMPLEACC_THEREARENT_TRANSACTIONS);
        }
        $GLOBALS['xoopsTpl']->assign('traOp',$traOp);

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
			\redirect_header('transactions.php?op=list', 3, _NOPERM);
		}

        $traDate = \DateTime::createFromFormat(_SHORTDATESTRING, Request::getString('tra_date'))->getTimestamp();
        $traYear = Request::getInt('tra_year', 0);
        $createYearNb = false;
		if ($traId > 0) {
			$transactionsObj = $transactionsHandler->get($traId);
            if ($helper->getConfig('use_trahistories')) {
                $traHist = $transactionsHandler->saveHistoryTransactions($traId);
            }
			if (date('Y', $traDate) != $traYear) {
                $createYearNb = true;
            }
		} else {
			$transactionsObj = $transactionsHandler->create();
            $traHist = 0;
            $createYearNb = true;
		}
		if ($createYearNb) {
		    $traYear = date('Y', $traDate);
            $traNb = 0;
            $crTransactions = new \CriteriaCompo();
            $crTransactions->add(new \Criteria('tra_year', $traYear));
            $crTransactions->setSort('tra_nb');
            $crTransactions->setOrder('DESC');
            $crTransactions->setStart(0);
            $crTransactions->setLimit(1);
            $transactionsAll = $transactionsHandler->getAll($crTransactions);
            foreach (\array_keys($transactionsAll) as $i) {
                $traNb = (int)$transactionsAll[$i]->getVar('tra_nb');
            }
            $traNb++;
        } else {
            $traYear = Request::getInt('tra_year', 0);
            $traNb = Request::getInt('tra_nb', 0);
        }
        $transactionsObj->setVar('tra_year', $traYear);
        $transactionsObj->setVar('tra_nb', $traNb);
		$transactionsObj->setVar('tra_desc', Request::getText('tra_desc', ''));
		$transactionsObj->setVar('tra_reference', Request::getString('tra_reference', ''));
        $transactionsObj->setVar('tra_remarks', Request::getText('tra_remarks', ''));
		$transactionsObj->setVar('tra_accid', Request::getInt('tra_accid', 0));
		$transactionsObj->setVar('tra_allid', Request::getInt('tra_allid', 0));
		$transactionDateObj = \DateTime::createFromFormat(_SHORTDATESTRING, Request::getString('tra_date'));
		$transactionsObj->setVar('tra_date', $traDate);
		$transactionsObj->setVar('tra_curid', Request::getInt('tra_curid', 0));
        $traClass = Request::getInt('tra_class', 0);
        $traAmount = Utility::StringToFloat(Request::getString('tra_amount'));
        if (Constants::CLASS_INCOME == $traClass) {
            $transactionsObj->setVar('tra_amountin', $traAmount);
            $transactionsObj->setVar('tra_amountout', 0);
        } elseif (Constants::CLASS_EXPENSES == $traClass) {
            $transactionsObj->setVar('tra_amountout', $traAmount);
            $transactionsObj->setVar('tra_amountin', 0);
        } else {
            $transactionsObj->setVar('tra_amountin', 0);
            $transactionsObj->setVar('tra_amountout', 0);
        }
        $transactionsObj->setVar('tra_taxid', Request::getInt('tra_taxid', 0));
        $transactionsObj->setVar('tra_asid', Request::getInt('tra_asid', 0));
        $transactionsObj->setVar('tra_balid', Request::getInt('tra_balid', 0));
        $transactionsObj->setVar('tra_cliid', Request::getInt('tra_cliid', 0));
		$transactionsObj->setVar('tra_status', Request::getInt('tra_status', 0));
		$transactionsObj->setVar('tra_comments', Request::getInt('tra_comments', 0));
        $transactionsObj->setVar('tra_class', $traClass);
        $transactionsObj->setVar('tra_hist', $traHist);
		$transactionsObj->setVar('tra_datecreated', Request::getInt('tra_datecreated', 0));
		$transactionsObj->setVar('tra_submitter', Request::getInt('tra_submitter', 0));
		// Insert Data
		if ($transactionsHandler->insert($transactionsObj)) {
			$newTraId = $traId > 0 ? $traId : $transactionsObj->getNewInsertedIdTransactions();
			$grouppermHandler = \xoops_getHandler('groupperm');
			$mid = $GLOBALS['xoopsModule']->getVar('mid');
			// Handle notification
			$traDesc = $transactionsObj->getVar('tra_desc');
			$traStatus = $transactionsObj->getVar('tra_status');
			$tags = [];
			$tags['ITEM_NAME'] = $traDesc;
			$tags['ITEM_URL']  = \XOOPS_URL . '/modules/wgsimpleacc/transactions.php?op=show&tra_id=' . $newTraId;
			$notificationHandler = \xoops_getHandler('notification');
			if (Constants::STATUS_SUBMITTED == $traStatus) {
				// Event approve notification
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
			\redirect_header('transactions.php?op=list' . $traOp . '#traId_' . $traId, 2, \_MA_WGSIMPLEACC_FORM_OK);
		}
		// Get Form Error
		$GLOBALS['xoopsTpl']->assign('error', $transactionsObj->getHtmlErrors());
		$form = $transactionsObj->getFormTransactions();
		$GLOBALS['xoopsTpl']->assign('form', $form->render());
		break;
	case 'new':
        $GLOBALS['xoTheme']->addScript(WGSIMPLEACC_URL . '/assets/js/forms.js');
		// Check permissions
		if (!$permissionsHandler->getPermTransactionsSubmit()) {
			\redirect_header('transactions.php?op=list', 3, _NOPERM);
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
        if (0 == $traId) {
            \redirect_header('transactions.php?op=list', 3, \_MA_WGSIMPLEACC_INVALID_PARAM);
        }
        $approve = (bool)('approve' == $op);

		// Check permissions
        if ($approve && !$permissionsHandler->getPermTransactionsApprove()) {
            \redirect_header('transactions.php?op=list', 3, _NOPERM);
        }
        $transactionsObj = $transactionsHandler->get($traId);
        $traSubmitter = $transactionsObj->getVar('tra_submitter');
        $traStatus = $transactionsObj->getVar('tra_status');
        if (!$permissionsHandler->getPermTransactionsEdit($traSubmitter, $traStatus)) {
            \redirect_header('transactions.php?op=list', 3, _NOPERM);
        }
		// Get Form
        $GLOBALS['xoTheme']->addScript(WGSIMPLEACC_URL . '/assets/js/forms.js');
		$form = $transactionsObj->getFormTransactions(false, false, 0, $start, $limit, $approve);
		$GLOBALS['xoopsTpl']->assign('form', $form->render());

        // Breadcrumbs
        $xoBreadcrumbs[] = ['title' => \_MA_WGSIMPLEACC_TRANSACTIONS, 'link' => 'transactions.php?op=list'];
        $xoBreadcrumbs[] = ['title' => \_MA_WGSIMPLEACC_TRANSACTION_EDIT];
		break;
	case 'delete':
        // Check params
        if (0 == $traId) {
            \redirect_header('transactions.php?op=list', 3, \_MA_WGSIMPLEACC_INVALID_PARAM);
        }
	    // Check permissions
		if (!$permissionsHandler->getPermTransactionsSubmit()) {
			\redirect_header('transactions.php?op=list', 3, _NOPERM);
		}
        $transactionsObj = $transactionsHandler->get($traId);
        $traSubmitter = $transactionsObj->getVar('tra_submitter');
        $traStatus = $transactionsObj->getVar('tra_status');
        if (!$permissionsHandler->getPermTransactionsEdit($traSubmitter, $traStatus)) {
            \redirect_header('transactions.php?op=list', 3, _NOPERM);
        }
        if ($helper->getConfig('use_trahistories')) {
            //create history
            $transactionsHandler->saveHistoryTransactions($traId, 'delete');
        }
		$traDesc = $transactionsObj->getVar('tra_desc');
		if (isset($_REQUEST['ok']) && 1 == $_REQUEST['ok']) {
			if (!$GLOBALS['xoopsSecurity']->check()) {
				\redirect_header('transactions.php', 3, \implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
			}
            $transactionsObj->setVar('tra_status', Constants::STATUS_OFFLINE);
			if ($transactionsHandler->insert($transactionsObj)) {
				// Event delete notification
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
			$xoopsconfirm = new Common\XoopsConfirm(
				['ok' => 1, 'tra_id' => $traId, 'op' => 'delete'],
				$_SERVER['REQUEST_URI'],
				\sprintf(\_MA_WGSIMPLEACC_FORM_SURE_DELETE, $transactionsObj->getVar('tra_desc')));
			$form = $xoopsconfirm->getFormXoopsConfirm();
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
        if (0 == $traId) {
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
            $formFilter = $transactionsHandler::getFormFilterTransactions($allId, $filterYear, $filterMonthFrom, $filterYearFrom, $filterMonthTo, $filterYearTo, $yearMin, $yearMax, $asId, $accId);
            $GLOBALS['xoopsTpl']->assign('formFilter', $formFilter->render());
        }
        $crTransactions = new \CriteriaCompo();
        $crTransactions->add(new \Criteria('tra_status', Constants::STATUS_OFFLINE));
        if ($traId > 0) {
            $crTransactions->add(new \Criteria('tra_id', $traId));
        } else {
            $tradateFrom = 0;
            $tradateTo = \time() + (10 * 365 * 24 * 60 * 60);;
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
                $tradateTo= $dtime->getTimestamp();
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
        if (0 == $traId) {
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
                $transactions[$i]['editable'] = $permissionsHandler->getPermTransactionsEdit($transactions[$i]['tra_submitter'], $transactions[$i]['tra_status']);
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
                $pagenav = new \XoopsPageNav($transactionsCount, $limit, $start, 'start', 'op=list&limit=' . $limit . '&amp;all_id=' . $allId);
                $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
            }
            $GLOBALS['xoopsTpl']->assign('showAssets', 0 == $asId);
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
$GLOBALS['xoopsTpl']->assign('xoops_mpageurl', WGSIMPLEACC_URL.'/transactions.php');
$GLOBALS['xoopsTpl']->assign('wgsimpleacc_upload_url', WGSIMPLEACC_UPLOAD_URL);

// View comments
require_once \XOOPS_ROOT_PATH . '/include/comment_view.php';

require __DIR__ . '/footer.php';
