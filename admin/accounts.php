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
    Utility,
    Common
};

require __DIR__ . '/header.php';
// It recovered the value of argument op in URL$
$op = Request::getCmd('op', 'list');
// Request acc_id
$accId = Request::getInt('acc_id');
switch ($op) {
	case 'list':
	default:
		// Define Stylesheet
		$GLOBALS['xoTheme']->addStylesheet($style, null);
		$start = Request::getInt('start', 0);
		$limit = Request::getInt('limit', $helper->getConfig('adminpager'));
		$templateMain = 'wgsimpleacc_admin_accounts.tpl';
		$GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('accounts.php'));
		$adminObject->addItemButton(\_AM_WGSIMPLEACC_ADD_ACCOUNT, 'accounts.php?op=new', 'add');
		$GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
		$accountsCount = $accountsHandler->getCountAccounts();
		$accountsAll = $accountsHandler->getAllAccounts($start, $limit);
		$GLOBALS['xoopsTpl']->assign('accounts_count', $accountsCount);
		$GLOBALS['xoopsTpl']->assign('wgsimpleacc_url', WGSIMPLEACC_URL);
		$GLOBALS['xoopsTpl']->assign('wgsimpleacc_upload_url', WGSIMPLEACC_UPLOAD_URL);
		// Table view accounts
		if ($accountsCount > 0) {
			foreach (\array_keys($accountsAll) as $i) {
				$account = $accountsAll[$i]->getValuesAccounts();
				$GLOBALS['xoopsTpl']->append('accounts_list', $account);
				unset($account);
			}
			// Display Navigation
			if ($accountsCount > $limit) {
				require_once \XOOPS_ROOT_PATH . '/class/pagenav.php';
				$pagenav = new \XoopsPageNav($accountsCount, $limit, $start, 'start', 'op=list&limit=' . $limit);
				$GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
			}
		} else {
			$GLOBALS['xoopsTpl']->assign('error', \_MA_WGSIMPLEACC_THEREARENT_ACCOUNTS);
		}
        $GLOBALS['xoopsTpl']->assign('colors', Utility::getColors());

		break;
	case 'new':
		$templateMain = 'wgsimpleacc_admin_accounts.tpl';
		$GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('accounts.php'));
		$adminObject->addItemButton(\_AM_WGSIMPLEACC_LIST_ACCOUNTS, 'accounts.php', 'list');
		$GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
		// Form Create
		$accountsObj = $accountsHandler->create();
		$form = $accountsObj->getFormAccounts(false, true);
		$GLOBALS['xoopsTpl']->assign('form', $form->render());
		break;
	case 'save':
		// Security Check
		if (!$GLOBALS['xoopsSecurity']->check()) {
			\redirect_header('accounts.php', 3, \implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
		}
		if ($accId > 0) {
			$accountsObj = $accountsHandler->get($accId);
		} else {
			$accountsObj = $accountsHandler->create();
		}
		// Set Vars
        $accPid = Request::getInt('acc_pid', 0);
        $accountsObj->setVar('acc_pid', $accPid);
        $accountsObj->setVar('acc_key', Request::getString('acc_key', ''));
        $accountsObj->setVar('acc_name', Request::getString('acc_name', ''));
        $accountsObj->setVar('acc_desc', Request::getString('acc_desc', ''));
        $accountsObj->setVar('acc_classification', Request::getInt('acc_classification', 0));
        $accountsObj->setVar('acc_color', Request::getString('acc_color', ''));
        $accountsObj->setVar('acc_iecalc', Request::getInt('acc_iecalc', 0));
        $accountsObj->setVar('acc_online', Request::getInt('acc_online', 0));
        $level = 1;
        if ($accPid > 0) {
            $accParentObj = $accountsHandler->get($accPid);
            $level = $accParentObj->getVar('acc_level') + 1;
        }
        unset($accParentObj);
        $accountsObj->setVar('acc_level', Request::getInt('acc_level', 0));
        $accountsObj->setVar('acc_weight', Request::getInt('acc_weight', 0));
        $accountDatecreatedObj = \DateTime::createFromFormat(_SHORTDATESTRING, Request::getString('acc_datecreated'));
        $accountsObj->setVar('acc_datecreated', $accountDatecreatedObj->getTimestamp());
        $accountsObj->setVar('acc_submitter', Request::getInt('acc_submitter', 0));
		// Insert Data
		if ($accountsHandler->insert($accountsObj)) {
			\redirect_header('accounts.php?op=list', 2, \_MA_WGSIMPLEACC_FORM_OK);
		}
		// Get Form
		$GLOBALS['xoopsTpl']->assign('error', $accountsObj->getHtmlErrors());
		$form = $accountsObj->getFormAccounts();
		$GLOBALS['xoopsTpl']->assign('form', $form->render());
		break;
    case 'savecolor':
        if ($accId > 0) {
            $accountsObj = $accountsHandler->get($accId);
        } else {
            \redirect_header('accounts.php', 3, \_MA_WGSIMPLEACC_INVALID_PARAM);
        }
        // Set Vars
        $accountsObj->setVar('acc_color', '#' . Request::getString('acc_color', ''));
        // Insert Data
        if ($accountsHandler->insert($accountsObj)) {
            \redirect_header('accounts.php?op=list', 2, \_MA_WGSIMPLEACC_FORM_OK);
        }
        break;
	case 'edit':
		$templateMain = 'wgsimpleacc_admin_accounts.tpl';
		$GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('accounts.php'));
		$adminObject->addItemButton(\_AM_WGSIMPLEACC_ADD_ACCOUNT, 'accounts.php?op=new', 'add');
		$adminObject->addItemButton(\_AM_WGSIMPLEACC_LIST_ACCOUNTS, 'accounts.php', 'list');
		$GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
		// Get Form
		$accountsObj = $accountsHandler->get($accId);
		$form = $accountsObj->getFormAccounts(false, true);
		$GLOBALS['xoopsTpl']->assign('form', $form->render());
		break;
	case 'delete':
		$templateMain = 'wgsimpleacc_admin_accounts.tpl';
		$GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('accounts.php'));
		$accountsObj = $accountsHandler->get($accId);
		$accKey = $accountsObj->getVar('acc_key');
		if (isset($_REQUEST['ok']) && 1 == $_REQUEST['ok']) {
			if (!$GLOBALS['xoopsSecurity']->check()) {
				\redirect_header('accounts.php', 3, \implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
			}
			if ($accountsHandler->delete($accountsObj)) {
				\redirect_header('accounts.php', 3, \_MA_WGSIMPLEACC_FORM_DELETE_OK);
			} else {
				$GLOBALS['xoopsTpl']->assign('error', $accountsObj->getHtmlErrors());
			}
		} else {
			$xoopsconfirm = new Common\XoopsConfirm(
				['ok' => 1, 'acc_id' => $accId, 'op' => 'delete'],
				$_SERVER['REQUEST_URI'],
				\sprintf(\_MA_WGSIMPLEACC_FORM_SURE_DELETE, $accountsObj->getVar('acc_key')));
			$form = $xoopsconfirm->getFormXoopsConfirm();
			$GLOBALS['xoopsTpl']->assign('form', $form->render());
		}
		break;
}
require __DIR__ . '/footer.php';
