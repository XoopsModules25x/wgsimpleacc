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

if ($helper->getConfig('show_breadcrumbs')) {
    if (\count($xoBreadcrumbs) > 1) {
        $GLOBALS['xoopsTpl']->assign('xoBreadcrumbs', $xoBreadcrumbs);
    }
    $GLOBALS['xoopsTpl']->assign('show_breadcrumbs', true);
}
$GLOBALS['xoopsTpl']->assign('adv', $helper->getConfig('advertise'));
//
$GLOBALS['xoopsTpl']->assign('admin', WGSIMPLEACC_ADMIN);
if ($helper->getConfig('show_copyright')) {
    $GLOBALS['xoopsTpl']->assign('copyright', $copyright);
}
// 
require_once \XOOPS_ROOT_PATH . '/footer.php';
