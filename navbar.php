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

$GLOBALS['xoTheme']->addStylesheet(WGSIMPLEACC_URL . '/assets/css/startmin.css', null);
$GLOBALS['xoTheme']->addStylesheet(WGSIMPLEACC_URL . '/assets/css/style.css', null);

$GLOBALS['xoTheme']->addScript(WGSIMPLEACC_URL . '/assets/js/metisMenu.min.js');
$GLOBALS['xoTheme']->addScript(WGSIMPLEACC_URL . '/assets/js/startmin.js');

$GLOBALS['xoopsTpl']->assign('permGlobalView', $permissionsHandler->getPermGlobalView());
$GLOBALS['xoopsTpl']->assign('permGlobalApprove', $permissionsHandler->getPermGlobalApprove());
$GLOBALS['xoopsTpl']->assign('permTransactionsSubmit', $permissionsHandler->getPermTransactionsSubmit());
$GLOBALS['xoopsTpl']->assign('permAllocationsSubmit', $permissionsHandler->getPermAllocationsSubmit());
$GLOBALS['xoopsTpl']->assign('permAccountsSubmit', $permissionsHandler->getPermAccountsSubmit());
$GLOBALS['xoopsTpl']->assign('permAssetsSubmit', $permissionsHandler->getPermAssetsSubmit());
$GLOBALS['xoopsTpl']->assign('permBalancesCreate', $permissionsHandler->getPermBalancesCreate());
$GLOBALS['xoopsTpl']->assign('permTratemplatesSubmit', $permissionsHandler->getPermTratemplatesSubmit());
$GLOBALS['xoopsTpl']->assign('permTratemplatesView', $permissionsHandler->getPermTratemplatesView());
$GLOBALS['xoopsTpl']->assign('permOuttemplatesSubmit', $permissionsHandler->getPermOuttemplatesSubmit());
$GLOBALS['xoopsTpl']->assign('permOuttemplatesView', $permissionsHandler->getPermOuttemplatesView());
$crOuttemplates = new \CriteriaCompo();
$crOuttemplates->add(new \Criteria('otpl_online', 1));
$outtemplatesAll = $outtemplatesHandler->getAll($crOuttemplates);
foreach (\array_keys($outtemplatesAll) as $i) {
    $outtemplates[$i] = $outtemplatesAll[$i]->getValuesOuttemplates();
}
$GLOBALS['xoopsTpl']->assign('outtemplates', $outtemplates);
unset($outtemplates);

//$GLOBALS['xoopsTpl']->assign('pathIcons32', WGSIMPLEACC_ICONS_URL . '/32/');
$GLOBALS['xoopsTpl']->assign('wgsimpleacc_icon_url_32', WGSIMPLEACC_ICONS_URL . '/32/');
