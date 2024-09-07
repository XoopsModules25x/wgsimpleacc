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
    Common,
    Utility
};

require __DIR__ . '/header.php';
require_once \XOOPS_ROOT_PATH . '/header.php';
$GLOBALS['xoopsTpl']->assign('template_sub', 'db:wgsimpleacc_balances.tpl');

$GLOBALS['xoTheme']->addStylesheet($style, null);

// Permissions
if (!$permissionsHandler->getPermBalancesView()) {
    \redirect_header('index.php', 0);
}

$op      = Request::getCmd('op', 'list');
$start   = Request::getInt('start');
$limit   = Request::getInt('limit', $helper->getConfig('userpager'));
$balId   = Request::getInt('bal_id');
$balType = Request::getInt('bal_type');

$keywords = [];

$GLOBALS['xoopsTpl']->assign('showItem', $balId > 0);
$GLOBALS['xoopsTpl']->assign('table_type', $helper->getConfig('table_type'));
$GLOBALS['xoopsTpl']->assign('balTypeFinal', Constants::BALANCE_TYPE_FINAL);
$GLOBALS['xoopsTpl']->assign('balTypeTemporary', Constants::BALANCE_TYPE_TEMPORARY);
$permBalancesSubmit = $permissionsHandler->getPermBalancesSubmit();
$GLOBALS['xoopsTpl']->assign('permBalancesSubmit', $permBalancesSubmit);

switch ($op) {
    case 'precalc':
        // Check permissions
        if (!$permBalancesSubmit) {
            \redirect_header('balances.php?op=list', 3, \_NOPERM);
        }
        $balFrom = Request::getString('bal_from') . ' 00:00';
        $balanceFromObj = \DateTime::createFromFormat(Utility::CustomDateFormat(), $balFrom);
        $balanceFrom = $balanceFromObj->getTimestamp();
        $balTo = Request::getString('bal_to') . ' 23:59';
        $balanceToObj = \DateTime::createFromFormat(Utility::CustomDateFormat(), $balTo);
        $balanceTo = $balanceToObj->getTimestamp();

        if (Constants::BALANCE_TYPE_FINAL == $balType) {
            // check whether balance already exists
            // date 'balance from' within range
            $crBalances = new \CriteriaCompo();
            $crBalances->add(new \Criteria('bal_from', $balanceFrom, '>='));
            $crBalances->add(new \Criteria('bal_from', $balanceTo, '<='));
            $crBalances->add(new \Criteria('bal_status', Constants::TRASTATUS_APPROVED));
            $countBalances = $balancesHandler->getCount($crBalances);
            if ($countBalances > 0) {
                \redirect_header('balances.php?op=list', 3, \_MA_WGSIMPLEACC_BALANCE_DATEUSED);
            }
            unset($crBalances);
            // date 'balance to' within range
            $crBalances = new \CriteriaCompo();
            $crBalances->add(new \Criteria('bal_to', $balanceFrom, '>='));
            $crBalances->add(new \Criteria('bal_to', $balanceTo, '<='));
            $crBalances->add(new \Criteria('bal_status', Constants::TRASTATUS_APPROVED));
            $countBalances = $balancesHandler->getCount($crBalances);
            if ($countBalances > 0) {
                \redirect_header('balances.php?op=list', 3, \_MA_WGSIMPLEACC_BALANCE_DATEUSED);
            }
            unset($crBalances);
        }
        $GLOBALS['xoopsTpl']->assign('balancesCalc', true);
        $GLOBALS['xoopsTpl']->assign('balType', $balType);

        //get all assets
        $assetsCurrent = $assetsHandler->getAssetsValues($balanceFrom, $balanceTo, true);
        $assetsCount = \count($assetsCurrent);
        if ($assetsCount > 0) {
            $info = \str_replace('%f', $balFrom, \_MA_WGSIMPLEACC_BALANCE_CALC_PERIOD);
            $info = \str_replace('%t', $balTo, $info);
            $GLOBALS['xoopsTpl']->assign('calc_info', $info);

            $GLOBALS['xoopsTpl']->assign('balances_calc', $assetsCurrent);
            $filterMonthFrom = $balanceFromObj->format('m');
            $filterYearFrom = $balanceFromObj->format('Y');
            $filterMonthTo = $balanceToObj->format('m');
            $filterYearTo = $balanceToObj->format('Y');
            $strFilter = "&amp;filterMonthFrom=$filterMonthFrom&amp;filterYearFrom=$filterYearFrom";
            $strFilter .= "&amp;filterMonthTo=$filterMonthTo&amp;filterYearTo=$filterYearTo";
            $GLOBALS['xoopsTpl']->assign('trafilter', $strFilter);
            $strFilter = "&amp;balanceFrom=$balanceFrom&amp;balanceTo=$balanceTo";
            $GLOBALS['xoopsTpl']->assign('balfilter', $strFilter);
        }

        // check for non-approved transactions and show warning, if yes
        $warnings = [];
        $crTransactions = new \CriteriaCompo();
        $crTransactions->add(new \Criteria('tra_date', $balanceFrom, '>='));
        $crTransactions->add(new \Criteria('tra_date', $balanceTo, '<='));
        $crTransactions->add(new \Criteria('tra_status', Constants::TRASTATUS_NONE));
        $countNone = $transactionsHandler->getCount($crTransactions);
        if ($countNone > 0) {
            $warnings[] = \sprintf(\_MA_WGSIMPLEACC_BALANCES_WARNING_NONE, $countNone);
        }
        unset($crTransactions);
        $crTransactions = new \CriteriaCompo();
        $crTransactions->add(new \Criteria('tra_date', $balanceFrom, '>='));
        $crTransactions->add(new \Criteria('tra_date', $balanceTo, '<='));
        $crTransactions->add(new \Criteria('tra_status', Constants::TRASTATUS_CREATED));
        $countOffline = $transactionsHandler->getCount($crTransactions);
        if ($countOffline > 0) {
            $warnings[] = \sprintf(\_MA_WGSIMPLEACC_BALANCES_WARNING_CREATED, $countOffline);
        }
        unset($crTransactions);
        $crTransactions = new \CriteriaCompo();
        $crTransactions->add(new \Criteria('tra_date', $balanceFrom, '>='));
        $crTransactions->add(new \Criteria('tra_date', $balanceTo, '<='));
        $crTransactions->add(new \Criteria('tra_status', Constants::TRASTATUS_SUBMITTED));
        $countSubmitted = $transactionsHandler->getCount($crTransactions);
        if ($countSubmitted > 0) {
            $warnings[] = \sprintf(\_MA_WGSIMPLEACC_BALANCES_WARNING_SUBMITTED, $countSubmitted);
        }
        unset($crTransactions);
        if (\count($warnings) > 0) {
            $GLOBALS['xoopsTpl']->assign('warnings', $warnings);
        }

        // Breadcrumbs
        $xoBreadcrumbs[] = ['title' => \_MA_WGSIMPLEACC_BALANCES, 'link' => 'balances.php?op=list'];
        $xoBreadcrumbs[] = ['title' => \_MA_WGSIMPLEACC_BALANCE_PRECALC];
        break;

    case 'list':
    default:

        $GLOBALS['xoopsTpl']->assign('balancesList', true);
        $balances = [];

        $sql = 'SELECT `bal_from`, `bal_to`, Sum(`bal_amountstart`) AS Sum_bal_amountstart, Sum(`bal_amountend`) AS Sum_bal_amountend, bal_status, bal_datecreated, bal_submitter ';
        $sql .= 'FROM ' . $GLOBALS['xoopsDB']->prefix('wgsimpleacc_balances') . ' ';
        $sql .= 'GROUP BY ' . $GLOBALS['xoopsDB']->prefix('wgsimpleacc_balances') . '.bal_from, ';
        $sql .= $GLOBALS['xoopsDB']->prefix('wgsimpleacc_balances') . '.bal_to, ';
        $sql .= $GLOBALS['xoopsDB']->prefix('wgsimpleacc_balances') . '.bal_status, ';
        $sql .= $GLOBALS['xoopsDB']->prefix('wgsimpleacc_balances') . '.bal_datecreated, ';
        $sql .= $GLOBALS['xoopsDB']->prefix('wgsimpleacc_balances') . '.bal_submitter ';
        $sql .= 'ORDER BY ' . $GLOBALS['xoopsDB']->prefix('wgsimpleacc_balances') . '.bal_from DESC, ' . $GLOBALS['xoopsDB']->prefix('wgsimpleacc_balances') . '.bal_datecreated DESC;';
        $result = $GLOBALS['xoopsDB']->query($sql);
        while (list($balFrom, $balTo, $balAmountStart, $balAmountEnd, $balStatus, $balDatecreated, $balSubmitter) = $GLOBALS['xoopsDB']->fetchRow($result)) {
            $balFromText = \formatTimestamp($balFrom, 's');
            $balToText   = \formatTimestamp($balTo, 's');
            $balType = 0;
            if (Constants::TRASTATUS_APPROVED == $balStatus) {
                $balType = Constants::BALANCE_TYPE_FINAL;
            } else if (Constants::BALSTATUS_TEMPORARY == $balStatus) {
                $balType = Constants::BALANCE_TYPE_TEMPORARY;
            }
            $balances[] = [
                'type' => $balType,
                'bal_from' => $balFrom,
                'from' => $balFromText,
                'bal_to' => $balTo,
                'to' => $balToText,
                'amountstart' => Utility::FloatToString($balAmountStart),
                'amountend' => Utility::FloatToString($balAmountEnd),
                'datecreated' => \formatTimestamp($balDatecreated, 's'),
                'submitter' => \XoopsUser::getUnameFromId($balSubmitter)
            ];
        }
        $balancesCount = \count($balances);
        $GLOBALS['xoopsTpl']->assign('balancesCount', $balancesCount);
        $GLOBALS['xoopsTpl']->assign('balances', $balances);
        // Breadcrumbs
        $xoBreadcrumbs[] = ['title' => \_MA_WGSIMPLEACC_BALANCES];
        break;

    case 'details':
        $GLOBALS['xoopsTpl']->assign('balanceDetails', true);
        $crBalances = new \CriteriaCompo();
        $balanceFrom = Request::getInt('balanceFrom');
        $balanceTo   = Request::getInt('balanceTo');
        $crBalances->add(new \Criteria('bal_from', $balanceFrom));
        $crBalances->add(new \Criteria('bal_to', $balanceTo));
        $balancesCount = $balancesHandler->getCount($crBalances);
        $GLOBALS['xoopsTpl']->assign('balancesCount', $balancesCount);
        $balancesAll = $balancesHandler->getAll($crBalances);
        if ($balancesCount > 0) {
            $balances = [];
            // Get All Balances
            $amountStartTotal = 0;
            $amountEndTotal = 0;
            foreach (\array_keys($balancesAll) as $i) {
                $balances[$i] = $balancesAll[$i]->getValuesBalances();
                $amountStartTotal += $balances[$i]['bal_amountstart'];
                $amountEndTotal += $balances[$i]['bal_amountend'];
            }
            $balances[$i + 1] = [
                'from' => \_MA_WGSIMPLEACC_SUMS,
                'amountstart' => Utility::FloatToString($amountStartTotal),
                'amountend' => Utility::FloatToString($amountEndTotal)
                ];
            $GLOBALS['xoopsTpl']->assign('balances', $balances);
            unset($balances);
            // Display Navigation
            if ($balancesCount > $limit) {
                require_once \XOOPS_ROOT_PATH . '/class/pagenav.php';
                $pagenav = new \XoopsPageNav($balancesCount, $limit, $start, 'start', 'op=list&limit=' . $limit);
                $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav());
            }
        }

        // Breadcrumbs
        $xoBreadcrumbs[] = ['title' => \_MA_WGSIMPLEACC_BALANCE_DETAILS];
        break;

    case 'save':
        // Check permissions
        if (!$permBalancesSubmit) {
            \redirect_header('balances.php?op=list', 3, \_NOPERM);
        }

        $errors = 0;
        $balanceFrom = Request::getInt('balanceFrom');
        $balanceTo   = Request::getInt('balanceTo');
        $submitter   = $GLOBALS['xoopsUser']->getVar('uid');

        if (Constants::BALANCE_TYPE_FINAL == $balType) {
            //check whether balance already exists
            // date 'balance from' within range
            $crBalances = new \CriteriaCompo();
            $crBalances->add(new \Criteria('bal_from', $balanceFrom, '>='));
            $crBalances->add(new \Criteria('bal_from', $balanceTo, '<='));
            $crBalances->add(new \Criteria('bal_status', Constants::TRASTATUS_APPROVED));
            $countBalances = $balancesHandler->getCount($crBalances);
            if ($countBalances > 0) {
                \redirect_header('balances.php?op=list', 3, \_MA_WGSIMPLEACC_BALANCE_DATEUSED);
            }
            unset($crBalances);
            // date 'balance to' within range
            $crBalances = new \CriteriaCompo();
            $crBalances->add(new \Criteria('bal_to', $balanceFrom, '>='));
            $crBalances->add(new \Criteria('bal_to', $balanceTo, '<='));
            $crBalances->add(new \Criteria('bal_status', Constants::TRASTATUS_APPROVED));
            $countBalances = $balancesHandler->getCount($crBalances);
            if ($countBalances > 0) {
                \redirect_header('balances.php?op=list', 3, \_MA_WGSIMPLEACC_BALANCE_DATEUSED);
            }
            unset($crBalances);
        } else {
            //check whether balance already exists
            // date 'balance from' within range
            $crBalances = new \CriteriaCompo();
            $crBalances->add(new \Criteria('bal_from', $balanceFrom, '>='));
            $crBalances->add(new \Criteria('bal_from', $balanceTo, '<='));
            $crBalances->add(new \Criteria('bal_status', Constants::BALSTATUS_TEMPORARY));
            $countBalances = $balancesHandler->getCount($crBalances);
            if ($countBalances > 0) {
                //delete existing one
                $balancesHandler->deleteAll($crBalances);
            }
            unset($crBalances);
            // date 'balance to' within range
            $crBalances = new \CriteriaCompo();
            $crBalances->add(new \Criteria('bal_to', $balanceFrom, '>='));
            $crBalances->add(new \Criteria('bal_to', $balanceTo, '<='));
            $crBalances->add(new \Criteria('bal_status', Constants::BALSTATUS_TEMPORARY));
            $countBalances = $balancesHandler->getCount($crBalances);
            if ($countBalances > 0) {
                //delete existing one
                $balancesHandler->deleteAll($crBalances);
            }
            unset($crBalances);
        }

        //create balance for each asset
        //get all assets
        $assetsCurrent = $assetsHandler->getAssetsValues($balanceFrom, $balanceTo, false, true);
        $assetsCount = \count($assetsCurrent);
        $balDatecreated = \time(); //all balances made at once must have same time
        foreach ($assetsCurrent as $asset) {
            $balancesObj = $balancesHandler->create();
            $balancesObj->setVar('bal_from', $balanceFrom);
            $balancesObj->setVar('bal_to', $balanceTo);
            $balancesObj->setVar('bal_asid', $asset['id']);
            $balancesObj->setVar('bal_curid', $asset['curid']);
            $balancesObj->setVar('bal_amountstart', $asset['amount_start_val']);
            $balancesObj->setVar('bal_amountend', $asset['amount_end_val']);
            if (Constants::BALANCE_TYPE_FINAL == $balType) {
                $balancesObj->setVar('bal_status', Request::getInt('bal_status', Constants::TRASTATUS_APPROVED));
            } else {
                $balancesObj->setVar('bal_status', Request::getInt('bal_status', Constants::BALSTATUS_TEMPORARY));
            }
            $balancesObj->setVar('bal_datecreated', $balDatecreated);
            $balancesObj->setVar('bal_submitter', $submitter);
            // Insert Data
            if ($balancesHandler->insert($balancesObj)) {
                $newBalId = $balId > 0 ? $balId : $balancesObj->getNewInsertedIdBalances();
                //lock all transactions for this period
                $crTransactions = new \CriteriaCompo();
                $crTransactions->add(new \Criteria('tra_date', $balanceFrom, '>='));
                $crTransactions->add(new \Criteria('tra_date', $balanceTo, '<='));
                $crTransactions->add(new \Criteria('tra_asid', $asset['id']));
                $crTransactions->add(new \Criteria('tra_status', Constants::TRASTATUS_SUBMITTED, '>'));
                if (Constants::BALANCE_TYPE_FINAL == $balType) {
                    //$transactionsHandler->updateAll('tra_status', Constants::TRASTATUS_LOCKED, $crTransactions, true);
                    $transactionsHandler->updateAll('tra_balid', $newBalId, $crTransactions, true);
                } else {
                    $transactionsHandler->updateAll('tra_balidt', $newBalId, $crTransactions, true);
                }
                unset($crTransactions);
            } else {
                $errors++;
            }
        }
        // redirect after insert
        if (0 === $errors) {
            \redirect_header('balances.php', 2, \_MA_WGSIMPLEACC_FORM_OK);
        }
        // Get Form Error
        $GLOBALS['xoopsTpl']->assign('error', \_MA_WGSIMPLEACC_BALANCE_ERRORS . $balancesObj->getHtmlErrors());
        $form = $balancesObj->getFormBalances();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;

    case 'new':
        // Check permissions
        if (!$permBalancesSubmit) {
            \redirect_header('balances.php?op=list', 3, \_NOPERM);
        }
        $GLOBALS['xoTheme']->addScript(\WGSIMPLEACC_URL . '/assets/js/forms.js');
        // Form Create
        $balancesObj = $balancesHandler->create();
        $form = $balancesObj->getFormBalances('balances.php');
        $GLOBALS['xoopsTpl']->assign('form', $form->render());

        // Breadcrumbs
        $xoBreadcrumbs[] = ['title' => \_MA_WGSIMPLEACC_BALANCES, 'link' => 'balances.php?op=list'];
        $xoBreadcrumbs[] = ['title' => \_MA_WGSIMPLEACC_BALANCE_SUBMIT];
        break;
    case 'delete':
        // Check permissions
        if (!$permBalancesSubmit) {
            \redirect_header('balances.php?op=list', 3, \_NOPERM);
        }

        $balanceFrom = Request::getInt('balanceFrom');
        $balanceTo   = Request::getInt('balanceTo');

        if (isset($_REQUEST['ok']) && 1 == $_REQUEST['ok']) {
            $crBalances = new \CriteriaCompo();
            $crBalances->add(new \Criteria('bal_from', $balanceFrom));
            $crBalances->add(new \Criteria('bal_to', $balanceTo));
            $crBalances->add(new \Criteria('bal_status', Constants::BALSTATUS_TEMPORARY));
            $countBalances = $balancesHandler->getCount($crBalances);
            if ($countBalances > 0) {
                $errors = 0;
                $balancesAll = $balancesHandler->getAll($crBalances);
                foreach (\array_keys($balancesAll) as $i) {
                    $balances[$i] = $balancesAll[$i]->getValuesBalances();
                    $balancesObj = $balancesHandler->get($i);
                    if (!$balancesHandler->delete($balancesObj)) {
                        $errors++;
                    }
                    unset($balancesObj);
                    //reset bal_id in table transactions
                    $crTransactions = new \CriteriaCompo();
                    $crTransactions->add(new \Criteria('tra_balidt', $i));
                    $transactionsHandler->updateAll('tra_balidt', '0', $crTransactions, true);
                    unset($crTransactions);
                }
                if (0 == $errors) {
                    \redirect_header('balances.php?op=list', 3, \_MA_WGSIMPLEACC_FORM_DELETE_OK);
                } else {
                    \redirect_header('balances.php?op=list', 3, \_MA_WGSIMPLEACC_FORM_DELETE_ERROR);
                }
            }
            unset($crBalances);
        } else {
            $customConfirm = new Common\Confirm(
                ['ok' => 1, 'balanceFrom' => $balanceFrom, 'balanceTo' => $balanceTo, 'op' => 'delete'],
                $_SERVER['REQUEST_URI'],
                \sprintf(\_MA_WGSIMPLEACC_FORM_SURE_DELETE, sprintf(_MA_WGSIMPLEACC_BALANCE_DELETE_FROMTO, date(_SHORTDATESTRING, $balanceFrom), date(_SHORTDATESTRING, $balanceTo))), _MA_WGSIMPLEACC_FORM_DELETE_CONFIRM, _MA_WGSIMPLEACC_FORM_DELETE_LABEL);
            $form = $customConfirm->getFormConfirm();
            $GLOBALS['xoopsTpl']->assign('form', $form->render());
            // Breadcrumbs
            $xoBreadcrumbs[] = ['title' => \_MA_WGSIMPLEACC_BALANCES, 'link' => 'balances.php?op=list'];
            $xoBreadcrumbs[] = ['title' => \_MA_WGSIMPLEACC_BALANCE_DELETE];
        }
        break;
}

// Keywords
wgsimpleaccMetaKeywords($helper->getConfig('keywords') . ', ' . \implode(',', $keywords));
unset($keywords);

// Description
$GLOBALS['xoopsTpl']->assign('xoops_mpageurl', \WGSIMPLEACC_URL . '/balances.php');
$GLOBALS['xoopsTpl']->assign('wgsimpleacc_upload_url', \WGSIMPLEACC_UPLOAD_URL);

require __DIR__ . '/footer.php';
