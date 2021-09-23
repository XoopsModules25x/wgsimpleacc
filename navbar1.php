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
    Utility,
    Common
};

/* startmin */
$GLOBALS['xoTheme']->addStylesheet(\WGSIMPLEACC_URL . '/assets/css/startmin.css', null);
$GLOBALS['xoTheme']->addScript(\WGSIMPLEACC_URL . '/assets/js/metisMenu.min.js');
$GLOBALS['xoTheme']->addScript(\WGSIMPLEACC_URL . '/assets/js/startmin.js');

/* wgSimpleAcc */
$GLOBALS['xoTheme']->addStylesheet(\WGSIMPLEACC_URL . '/assets/css/style.css', null);

// get configs
$GLOBALS['xoopsTpl']->assign('useClients', $helper->getConfig('use_clients'));

// get permissions
$GLOBALS['xoopsTpl']->assign('permGlobalView', $permissionsHandler->getPermGlobalView());
$GLOBALS['xoopsTpl']->assign('permGlobalApprove', $permissionsHandler->getPermGlobalApprove());
$GLOBALS['xoopsTpl']->assign('permTransactionsSubmit', $permissionsHandler->getPermTransactionsSubmit());
$GLOBALS['xoopsTpl']->assign('permTransactionsView', $permissionsHandler->getPermTransactionsView());
$GLOBALS['xoopsTpl']->assign('permAllocationsSubmit', $permissionsHandler->getPermAllocationsSubmit());
$GLOBALS['xoopsTpl']->assign('permAllocationsView', $permissionsHandler->getPermAllocationsView());
$GLOBALS['xoopsTpl']->assign('permAccountsSubmit', $permissionsHandler->getPermAccountsSubmit());
$GLOBALS['xoopsTpl']->assign('permAccountsView', $permissionsHandler->getPermAccountsView());
$GLOBALS['xoopsTpl']->assign('permAssetsSubmit', $permissionsHandler->getPermAssetsSubmit());
$GLOBALS['xoopsTpl']->assign('permAssetsView', $permissionsHandler->getPermAssetsView());
$GLOBALS['xoopsTpl']->assign('permBalancesSubmit', $permissionsHandler->getPermBalancesSubmit());
$GLOBALS['xoopsTpl']->assign('permBalancesView', $permissionsHandler->getPermBalancesView());
$GLOBALS['xoopsTpl']->assign('permTratemplatesSubmit', $permissionsHandler->getPermTratemplatesSubmit());
$GLOBALS['xoopsTpl']->assign('permTratemplatesView', $permissionsHandler->getPermTratemplatesView());
$GLOBALS['xoopsTpl']->assign('permOuttemplatesSubmit', $permissionsHandler->getPermOuttemplatesSubmit());
$GLOBALS['xoopsTpl']->assign('permOuttemplatesView', $permissionsHandler->getPermOuttemplatesView());
$GLOBALS['xoopsTpl']->assign('permClientsSubmit', $permissionsHandler->getPermClientsSubmit());
$GLOBALS['xoopsTpl']->assign('permClientsView', $permissionsHandler->getPermClientsView());

//$GLOBALS['xoopsTpl']->assign('pathIcons32', WGSIMPLEACC_ICONS_URL . '/32/');
$GLOBALS['xoopsTpl']->assign('wgsimpleacc_icon_url_32', WGSIMPLEACC_ICONS_URL . '/32/');

$currentUser = '';
$uid = isset($GLOBALS['xoopsUser']) && \is_object($GLOBALS['xoopsUser']) ? $GLOBALS['xoopsUser']->getVar('uid') : 0;
if ($uid > 0) {
    $currentUser = $GLOBALS['xoopsUser']::getUnameFromId($uid);
}
$GLOBALS['xoopsTpl']->assign('currentUser', $currentUser);
