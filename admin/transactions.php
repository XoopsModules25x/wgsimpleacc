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
// It recovered the value of argument op in URL$
$op = Request::getCmd('op', 'list');
// Request tra_id
$traId = Request::getInt('tra_id');
$start = Request::getInt('start');
$limit = Request::getInt('limit', $helper->getConfig('adminpager'));

switch ($op) {
    case 'list':
    default:
        // Define Stylesheet
        $GLOBALS['xoTheme']->addStylesheet($style, null);
        $templateMain = 'wgsimpleacc_admin_transactions.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('transactions.php'));
        $adminObject->addItemButton(\_AM_WGSIMPLEACC_ADD_TRANSACTION, 'transactions.php?op=new');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        $transactionsCount = $transactionsHandler->getCountTransactions();
        $transactionsAll = $transactionsHandler->getAllTransactions($start, $limit, 'tra_id', 'DESC');
        $GLOBALS['xoopsTpl']->assign('transactions_count', $transactionsCount);
        $GLOBALS['xoopsTpl']->assign('wgsimpleacc_url', \WGSIMPLEACC_URL);
        $GLOBALS['xoopsTpl']->assign('wgsimpleacc_upload_url', \WGSIMPLEACC_UPLOAD_URL);
        $GLOBALS['xoopsTpl']->assign('start', $start);
        $GLOBALS['xoopsTpl']->assign('limit', $limit);
        // Table view transactions
        if ($transactionsCount > 0) {
            foreach (\array_keys($transactionsAll) as $i) {
                $transaction = $transactionsAll[$i]->getValuesTransactions();
                $GLOBALS['xoopsTpl']->append('transactions_list', $transaction);
                unset($transaction);
            }
            // Display Navigation
            if ($transactionsCount > $limit) {
                require_once \XOOPS_ROOT_PATH . '/class/pagenav.php';
                $pagenav = new \XoopsPageNav($transactionsCount, $limit, $start, 'start', 'op=list&limit=' . $limit);
                $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav());
            }
        } else {
            $GLOBALS['xoopsTpl']->assign('error', \_MA_WGSIMPLEACC_THEREARENT_TRANSACTIONS);
        }
        break;
    case 'new':
        $templateMain = 'wgsimpleacc_admin_transactions.tpl';
        $GLOBALS['xoTheme']->addScript(\WGSIMPLEACC_URL . '/assets/js/forms.js');
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('transactions.php'));
        $adminObject->addItemButton(\_AM_WGSIMPLEACC_LIST_TRANSACTIONS, 'transactions.php', 'list');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        // Form Create
        $transactionsObj = $transactionsHandler->create();
        $form = $transactionsObj->getFormTransactions(false, true, Constants::CLASS_BOTH, $start, $limit);
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'save':
        // Security Check
        if (!$GLOBALS['xoopsSecurity']->check()) {
            \redirect_header('transactions.php', 3, \implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        if ($traId > 0) {
            $transactionsObj = $transactionsHandler->get($traId);
        } else {
            $transactionsObj = $transactionsHandler->create();
        }
        // Set Vars
        $transactionsObj->setVar('tra_year', Request::getInt('tra_year'));
        $transactionsObj->setVar('tra_nb', Request::getInt('tra_nb'));
        $transactionsObj->setVar('tra_desc', Request::getText('tra_desc'));
        $transactionsObj->setVar('tra_reference', Request::getString('tra_reference'));
        $transactionsObj->setVar('tra_remarks', Request::getText('tra_remarks'));
        $transactionsObj->setVar('tra_accid', Request::getInt('tra_accid'));
        $transactionsObj->setVar('tra_allid', Request::getInt('tra_allid'));
        $transactionDateObj = \DateTime::createFromFormat(_SHORTDATESTRING, Request::getString('tra_date'));
        $transactionsObj->setVar('tra_date', $transactionDateObj->getTimestamp());
        $transactionsObj->setVar('tra_curid', Request::getInt('tra_curid'));
        $traClass = Request::getInt('tra_class');
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
        $transactionsObj->setVar('tra_taxid', Request::getInt('tra_taxid'));
        $transactionsObj->setVar('tra_asid', Request::getInt('tra_asid'));
        $transactionsObj->setVar('tra_balid', Request::getInt('tra_balid'));
        $transactionsObj->setVar('tra_balidt', Request::getInt('tra_balidt'));
        $transactionsObj->setVar('tra_cliid', Request::getInt('tra_cliid'));
        $transactionsObj->setVar('tra_status', Request::getInt('tra_status'));
        $transactionsObj->setVar('tra_comments', Request::getInt('tra_comments'));
        $transactionsObj->setVar('tra_class', $traClass);
        $transactionsObj->setVar('tra_hist', Request::getInt('tra_hist'));
        $transactionsObj->setVar('tra_processing', Request::getInt('tra_processing'));
        $transactionDatecreatedObj = \DateTime::createFromFormat(_SHORTDATESTRING, Request::getString('tra_datecreated'));
        $transactionsObj->setVar('tra_datecreated', $transactionDatecreatedObj->getTimestamp());
        $transactionsObj->setVar('tra_submitter', Request::getInt('tra_submitter'));
        // Insert Data
        if ($transactionsHandler->insert($transactionsObj)) {
            \redirect_header('transactions.php?op=list&amp;start=' . $start . '&amp;limit=' . $limit, 2, \_MA_WGSIMPLEACC_FORM_OK);
        }
        // Get Form
        $GLOBALS['xoopsTpl']->assign('error', $transactionsObj->getHtmlErrors());
        $form = $transactionsObj->getFormTransactions();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'edit':
        $templateMain = 'wgsimpleacc_admin_transactions.tpl';
        $GLOBALS['xoTheme']->addScript(\WGSIMPLEACC_URL . '/assets/js/forms.js');
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('transactions.php'));
        $adminObject->addItemButton(\_AM_WGSIMPLEACC_ADD_TRANSACTION, 'transactions.php?op=new');
        $adminObject->addItemButton(\_AM_WGSIMPLEACC_LIST_TRANSACTIONS, 'transactions.php', 'list');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        // Get Form
        $transactionsObj = $transactionsHandler->get($traId);
        $form = $transactionsObj->getFormTransactions(false, true, 0, $start, $limit);
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'delete':
        $templateMain = 'wgsimpleacc_admin_transactions.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('transactions.php'));
        $transactionsObj = $transactionsHandler->get($traId);
        $transactionsHandler->saveHistoryTransactions($traId, 'delete Admin');
        $traDesc = $transactionsObj->getVar('tra_desc');
        if (isset($_REQUEST['ok']) && 1 == $_REQUEST['ok']) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                \redirect_header('transactions.php', 3, \implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            if ($transactionsHandler->delete($transactionsObj)) {
                \redirect_header('transactions.php', 3, \_MA_WGSIMPLEACC_FORM_DELETE_OK);
            } else {
                $GLOBALS['xoopsTpl']->assign('error', $transactionsObj->getHtmlErrors());
            }
        } else {
            $customConfirm = new Common\Confirm(
                ['ok' => 1, 'tra_id' => $traId, 'op' => 'delete'],
                $_SERVER['REQUEST_URI'],
                \sprintf(\_MA_WGSIMPLEACC_FORM_SURE_DELETE, $transactionsObj->getVar('tra_desc')), _MA_WGSIMPLEACC_FORM_DELETE_CONFIRM, _MA_WGSIMPLEACC_FORM_DELETE_LABEL);
            $form = $customConfirm->getFormConfirm();
            $GLOBALS['xoopsTpl']->assign('form', $form->render());
        }
        break;
}
require __DIR__ . '/footer.php';
