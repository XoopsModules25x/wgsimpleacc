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
// It recovered the value of argument op in URL$
$op = Request::getCmd('op', 'list');
// Request tra_id
$traId = Request::getInt('tra_id');
$start = Request::getInt('start', 0);
$limit = Request::getInt('limit', $helper->getConfig('adminpager'));

switch ($op) {
	case 'list':
	default:
		// Define Stylesheet
		$GLOBALS['xoTheme']->addStylesheet($style, null);
		$templateMain = 'wgsimpleacc_admin_transactions.tpl';
		$GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('transactions.php'));
		$adminObject->addItemButton(\_AM_WGSIMPLEACC_ADD_TRANSACTION, 'transactions.php?op=new', 'add');
		$GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
		$transactionsCount = $transactionsHandler->getCountTransactions();
		$transactionsAll = $transactionsHandler->getAllTransactions($start, $limit, 'tra_id', 'DESC');
		$GLOBALS['xoopsTpl']->assign('transactions_count', $transactionsCount);
		$GLOBALS['xoopsTpl']->assign('wgsimpleacc_url', WGSIMPLEACC_URL);
		$GLOBALS['xoopsTpl']->assign('wgsimpleacc_upload_url', WGSIMPLEACC_UPLOAD_URL);
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
				$GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
			}
		} else {
			$GLOBALS['xoopsTpl']->assign('error', \_MA_WGSIMPLEACC_THEREARENT_TRANSACTIONS);
		}
		break;
	case 'new':
		$templateMain = 'wgsimpleacc_admin_transactions.tpl';
        $GLOBALS['xoTheme']->addScript(WGSIMPLEACC_URL . '/assets/js/forms.js');
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
        $transactionsObj->setVar('tra_year', Request::getInt('tra_year', 0));
        $transactionsObj->setVar('tra_nb', Request::getInt('tra_nb', 0));
		$transactionsObj->setVar('tra_desc', Request::getString('tra_desc', ''));
		$transactionsObj->setVar('tra_reference', Request::getString('tra_reference', ''));
		$transactionsObj->setVar('tra_accid', Request::getInt('tra_accid', 0));
		$transactionsObj->setVar('tra_allid', Request::getInt('tra_allid', 0));
		$transactionDateObj = \DateTime::createFromFormat(_SHORTDATESTRING, Request::getString('tra_date'));
		$transactionsObj->setVar('tra_date', $transactionDateObj->getTimestamp());
		$transactionsObj->setVar('tra_curid', Request::getInt('tra_curid', 0));
        $traAmountin = Request::getString('tra_amountin');
        $transactionsObj->setVar('tra_amountin', Utility::StringToFloat($traAmountin));
        $traAmountout = Request::getString('tra_amountout');
        $transactionsObj->setVar('tra_amountout', Utility::StringToFloat($traAmountout));
		$transactionsObj->setVar('tra_taxid', Request::getInt('tra_taxid', 0));
		$transactionsObj->setVar('tra_status', Request::getInt('tra_status', 0));
		$transactionsObj->setVar('tra_comments', Request::getInt('tra_comments', 0));
        $transactionsObj->setVar('tra_class', Request::getInt('tra_class', 0));
        $transactionsObj->setVar('tra_asid', Request::getString('tra_asid', ''));
        $transactionsObj->setVar('tra_balid', Request::getString('tra_balid', ''));
		$transactionDatecreatedObj = \DateTime::createFromFormat(_SHORTDATESTRING, Request::getString('tra_datecreated'));
		$transactionsObj->setVar('tra_datecreated', $transactionDatecreatedObj->getTimestamp());
		$transactionsObj->setVar('tra_submitter', Request::getInt('tra_submitter', 0));
		// Insert Data
		if ($transactionsHandler->insert($transactionsObj)) {
			\redirect_header('transactions.php?op=list', 2, \_MA_WGSIMPLEACC_FORM_OK);
		}
		// Get Form
		$GLOBALS['xoopsTpl']->assign('error', $transactionsObj->getHtmlErrors());
		$form = $transactionsObj->getFormTransactions();
		$GLOBALS['xoopsTpl']->assign('form', $form->render());
		break;
	case 'edit':
		$templateMain = 'wgsimpleacc_admin_transactions.tpl';
        $GLOBALS['xoTheme']->addScript(WGSIMPLEACC_URL . '/assets/js/forms.js');
		$GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('transactions.php'));
		$adminObject->addItemButton(\_AM_WGSIMPLEACC_ADD_TRANSACTION, 'transactions.php?op=new', 'add');
		$adminObject->addItemButton(\_AM_WGSIMPLEACC_LIST_TRANSACTIONS, 'transactions.php', 'list');
		$GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
		// Get Form
		$transactionsObj = $transactionsHandler->get($traId);
		$form = $transactionsObj->getFormTransactions(false, true, Constants::CLASS_BOTH, $start, $limit);
		$GLOBALS['xoopsTpl']->assign('form', $form->render());
		break;
	case 'delete':
		$templateMain = 'wgsimpleacc_admin_transactions.tpl';
		$GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('transactions.php'));
		$transactionsObj = $transactionsHandler->get($traId);
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
			$xoopsconfirm = new Common\XoopsConfirm(
				['ok' => 1, 'tra_id' => $traId, 'op' => 'delete'],
				$_SERVER['REQUEST_URI'],
				\sprintf(\_MA_WGSIMPLEACC_FORM_SURE_DELETE, $transactionsObj->getVar('tra_desc')));
			$form = $xoopsconfirm->getFormXoopsConfirm();
			$GLOBALS['xoopsTpl']->assign('form', $form->render());
		}
		break;
}
require __DIR__ . '/footer.php';
