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

$GLOBALS['xoopsTpl']->assign('indexHeader', $helper->getConfig('index_header'));
$GLOBALS['xoopsTpl']->assign('xoops_icons32_url', \XOOPS_ICONS32_URL);
$GLOBALS['xoopsTpl']->assign('wgsimpleacc_icons_url_16', \WGSIMPLEACC_ICONS_URL . '/16/');
$GLOBALS['xoopsTpl']->assign('wgsimpleacc_icons_url_32', \WGSIMPLEACC_ICONS_URL . '/32/');
$GLOBALS['xoopsTpl']->assign('wgsimpleacc_url', \WGSIMPLEACC_URL);
$GLOBALS['xoopsTpl']->assign('wgsimpleacc_image_url', \WGSIMPLEACC_IMAGE_URL);

$GLOBALS['xoopsTpl']->assign('indexHeader', $helper->getConfig('index_header'));

$currentUser = '';
$uid = isset($GLOBALS['xoopsUser']) && \is_object($GLOBALS['xoopsUser']) ? $GLOBALS['xoopsUser']->getVar('uid') : 0;
if ($uid > 0) {
    $currentUser = $GLOBALS['xoopsUser']::getUnameFromId($uid);
}
$GLOBALS['xoopsTpl']->assign('currentUser', $currentUser);

if ($helper->getConfig('show_breadcrumbs')) {
    if (\count($xoBreadcrumbs) > 1) {
        $GLOBALS['xoopsTpl']->assign('xoBreadcrumbs', $xoBreadcrumbs);
    }
    $GLOBALS['xoopsTpl']->assign('show_breadcrumbs', true);
}
$GLOBALS['xoopsTpl']->assign('adv', $helper->getConfig('advertise'));
//
$GLOBALS['xoopsTpl']->assign('admin', \WGSIMPLEACC_ADMIN);
if ($helper->getConfig('show_copyright')) {
    $GLOBALS['xoopsTpl']->assign('copyright', $copyright);
}
// 
require_once \XOOPS_ROOT_PATH . '/footer.php';
