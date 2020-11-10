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
require_once \XOOPS_ROOT_PATH . '/header.php';
$traId = Request::getInt('tra_id');
// Define Stylesheet
$GLOBALS['xoTheme']->addStylesheet($style, null);
if (empty($traId)) {
	\redirect_header(WGSIMPLEACC_URL . '/index.php', 2, \_MA_WGSIMPLEACC_INVALID_PARAM);
}
// Get Instance of Handler
$transactionsHandler = $helper->getHandler('Transactions');
$grouppermHandler = \xoops_getHandler('groupperm');
// Verify that the article is published
$transactions = $transactionsHandler->get($traId);
// Verify permissions

$transaction = $transactions->getValuesTransactions();
$GLOBALS['xoopsTpl']->append('transactions_list', $transaction);

$GLOBALS['xoopsTpl']->assign('useCurrencies', $helper->getConfig('use_currencies'));
$GLOBALS['xoopsTpl']->assign('useTaxes', $helper->getConfig('use_taxes'));

$GLOBALS['xoopsTpl']->assign('xoops_sitename', $GLOBALS['xoopsConfig']['sitename']);
$GLOBALS['xoopsTpl']->assign('xoops_pagetitle', \strip_tags($transactions->getVar('tra_desc') . ' - ' . \_MA_WGSIMPLEACC_PRINT . ' - ' . $GLOBALS['xoopsModule']->getVar('name')));
$GLOBALS['xoopsTpl']->display('db:wgsimpleacc_transactions_print.tpl');
