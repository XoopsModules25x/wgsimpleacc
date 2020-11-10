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
$imgId = Request::getInt('img_id');
// Define Stylesheet
$GLOBALS['xoTheme']->addStylesheet($style, null);
if (empty($imgId)) {
	\redirect_header(WGSIMPLEACC_URL . '/index.php', 2, \_MA_WGSIMPLEACC_NOIMGID);
}
// Get Instance of Handler
$imagesHandler = $helper->getHandler('Images');
$grouppermHandler = \xoops_getHandler('groupperm');
// Verify that the article is published
$images = $imagesHandler->get($imgId);
// Verify permissions
if (!$grouppermHandler->checkRight('wgsimpleacc_view', $imgId->getVar('img_id'), $groups, $GLOBALS['xoopsModule']->getVar('mid'))) {
	\redirect_header(WGSIMPLEACC_URL . '/index.php', 3, _NOPERM);
	exit();
}
$image = $images->getValuesImages();
foreach ($image as $k => $v) {
	$GLOBALS['xoopsTpl']->append('"{$k}"', $v);
}
$GLOBALS['xoopsTpl']->assign('xoops_sitename', $GLOBALS['xoopsConfig']['sitename']);
$GLOBALS['xoopsTpl']->assign('xoops_pagetitle', \strip_tags($image->getVar('img_traid') - \_MA_WGSIMPLEACC_PRINT - $GLOBALS['xoopsModule']->name()));
$GLOBALS['xoopsTpl']->display('db:images_print.tpl');
