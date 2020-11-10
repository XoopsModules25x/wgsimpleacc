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
use XoopsModules\Wgsimpleacc\Constants;

require __DIR__ . '/header.php';

// Template Index
$templateMain = 'wgsimpleacc_admin_permissions.tpl';
$GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('permissions.php'));

$op = Request::getCmd('op', 'global');

// Get Form
require_once \XOOPS_ROOT_PATH . '/class/xoopsform/grouppermform.php';
\xoops_load('XoopsFormLoader');

$formTitle = \_AM_WGSIMPLEACC_PERMISSIONS_GLOBAL;
$permName = 'wgsimpleacc_ac';
$permDesc = \_AM_WGSIMPLEACC_PERMISSIONS_GLOBAL_DESC;
$globalPerms = [
    Constants::PERM_GLOBAL_APPROVE => \_AM_WGSIMPLEACC_PERMISSIONS_GLOBAL_APPROVE,
    Constants::PERM_GLOBAL_SUBMIT => \_AM_WGSIMPLEACC_PERMISSIONS_GLOBAL_SUBMIT,
    Constants::PERM_GLOBAL_VIEW => \_AM_WGSIMPLEACC_PERMISSIONS_GLOBAL_VIEW,
    Constants::PERM_TRANSACTIONS_APPROVE => \_AM_WGSIMPLEACC_PERMISSIONS_TRANSACTION_APPROVE,
    Constants::PERM_TRANSACTIONS_SUBMIT => \_AM_WGSIMPLEACC_PERMISSIONS_TRANSACTION_SUBMIT,
    Constants::PERM_ALLOCATIONS_SUBMIT => \_AM_WGSIMPLEACC_PERMISSIONS_ALLOCATION_SUBMIT,
    Constants::PERM_ASSETS_SUBMIT => \_AM_WGSIMPLEACC_PERMISSIONS_ASSET_SUBMIT,
    Constants::PERM_ACCOUNTS_SUBMIT => \_AM_WGSIMPLEACC_PERMISSIONS_ACCOUNT_SUBMIT,
    Constants::PERM_BALANCES_CREATE => \_AM_WGSIMPLEACC_PERMISSIONS_BALANCE_CREATE,
    Constants::PERM_TRATEMPLATES_SUBMIT => \_AM_WGSIMPLEACC_PERMISSIONS_TRATEMPLATE_SUBMIT,
    Constants::PERM_TRATEMPLATES_VIEW => \_AM_WGSIMPLEACC_PERMISSIONS_TRATEMPLATE_VIEW,
    Constants::PERM_OUTTEMPLATES_SUBMIT => \_AM_WGSIMPLEACC_PERMISSIONS_OUTTEMPLATE_SUBMIT,
    Constants::PERM_OUTTEMPLATES_VIEW => \_AM_WGSIMPLEACC_PERMISSIONS_OUTTEMPLATE_VIEW,
    ];

$moduleId = $xoopsModule->getVar('mid');
$permform = new \XoopsGroupPermForm($formTitle, $moduleId, $permName, $permDesc, 'admin/permissions.php');
$permFound = false;
if ('global' === $op) {
	foreach ($globalPerms as $gPermId => $gPermName) {
		$permform->addItem($gPermId, $gPermName);
	}
	$GLOBALS['xoopsTpl']->assign('form', $permform->render());
	$permFound = true;
}
if ($op === 'approve_transactions' || $op === 'submit_transactions' || $op === 'view_transactions') {
	$transactionsCount = $transactionsHandler->getCountTransactions();
	if ($transactionsCount > 0) {
		$transactionsAll = $transactionsHandler->getAllTransactions(0, 'tra_desc');
		foreach (\array_keys($transactionsAll) as $i) {
			$permform->addItem($transactionsAll[$i]->getVar('tra_id'), $transactionsAll[$i]->getVar('tra_desc'));
		}
		$GLOBALS['xoopsTpl']->assign('form', $permform->render());
	}
	$permFound = true;
}
unset($permform);
if (true !== $permFound) {
	\redirect_header('permissions.php', 3, \_AM_WGSIMPLEACC_NO_PERMISSIONS_SET);
	exit();
}
require __DIR__ . '/footer.php';