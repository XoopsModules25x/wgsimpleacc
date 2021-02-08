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

use Xmf\Module\Admin;
use XoopsModules\Wgsimpleacc\Helper;

include dirname(__DIR__, 3) . '/include/cp_header.php';
require_once \dirname(__DIR__) . '/include/common.php';

$sysPathIcon16   = '../' . $GLOBALS['xoopsModule']->getInfo('sysicons16');
$sysPathIcon32   = '../' . $GLOBALS['xoopsModule']->getInfo('sysicons32');
$pathModuleAdmin = $GLOBALS['xoopsModule']->getInfo('dirmoduleadmin');
$modPathIcon16   = WGSIMPLEACC_URL . '/' . $GLOBALS['xoopsModule']->getInfo('modicons16') . '/';
$modPathIcon32   = WGSIMPLEACC_URL . '/' . $GLOBALS['xoopsModule']->getInfo('modicons32') . '/';

// Get instance of module
$helper = Helper::getInstance();
$accountsHandler = $helper->getHandler('Accounts');
$transactionsHandler = $helper->getHandler('Transactions');
$allocationsHandler = $helper->getHandler('Allocations');
$assetsHandler = $helper->getHandler('Assets');
$currenciesHandler = $helper->getHandler('Currencies');
$taxesHandler = $helper->getHandler('Taxes');
$filesHandler = $helper->getHandler('Files');
$balancesHandler = $helper->getHandler('Balances');
$tratemplatesHandler = $helper->getHandler('Tratemplates');
$outtemplatesHandler = $helper->getHandler('Outtemplates');
$trahistoriesHandler = $helper->getHandler('Trahistories');
$clientsHandler = $helper->getHandler('Clients');
$myts = MyTextSanitizer::getInstance();
// 
if (!isset($xoopsTpl) || !\is_object($xoopsTpl)) {
	require_once \XOOPS_ROOT_PATH . '/class/template.php';
	$xoopsTpl = new \XoopsTpl();
}

// Load languages
\xoops_loadLanguage('admin');
\xoops_loadLanguage('modinfo');
\xoops_loadLanguage('main');

// Local admin menu class
if (\file_exists($GLOBALS['xoops']->path($pathModuleAdmin.'/moduleadmin.php'))) {
	require_once $GLOBALS['xoops']->path($pathModuleAdmin.'/moduleadmin.php');
} else {
	\redirect_header('../../../admin.php', 5, _AM_MODULEADMIN_MISSING);
}

xoops_cp_header();

// System icons path
$GLOBALS['xoopsTpl']->assign('sysPathIcon16', $sysPathIcon16);
$GLOBALS['xoopsTpl']->assign('sysPathIcon32', $sysPathIcon32);
$GLOBALS['xoopsTpl']->assign('modPathIcon16', $modPathIcon16);
$GLOBALS['xoopsTpl']->assign('modPathIcon32', $modPathIcon32);

$adminObject = Admin::getInstance();
$style = WGSIMPLEACC_URL . '/assets/css/admin/style.css';
