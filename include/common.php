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
if (!\defined('XOOPS_ICONS32_PATH')) {
    \define('XOOPS_ICONS32_PATH', \XOOPS_ROOT_PATH . '/Frameworks/moduleclasses/icons/32');
}
if (!\defined('XOOPS_ICONS32_URL')) {
    \define('XOOPS_ICONS32_URL', \XOOPS_URL . '/Frameworks/moduleclasses/icons/32');
}
\define('WGSIMPLEACC_DIRNAME', 'wgsimpleacc');
\define('WGSIMPLEACC_PATH', \XOOPS_ROOT_PATH . '/modules/' . WGSIMPLEACC_DIRNAME);
\define('WGSIMPLEACC_URL', \XOOPS_URL . '/modules/' . WGSIMPLEACC_DIRNAME);
\define('WGSIMPLEACC_ICONS_PATH', WGSIMPLEACC_PATH . '/assets/icons');
\define('WGSIMPLEACC_ICONS_URL', WGSIMPLEACC_URL . '/assets/icons');
\define('WGSIMPLEACC_IMAGE_PATH', WGSIMPLEACC_PATH . '/assets/images');
\define('WGSIMPLEACC_IMAGE_URL', WGSIMPLEACC_URL . '/assets/images');
\define('WGSIMPLEACC_CSS_URL', WGSIMPLEACC_URL . '/assets/css');
\define('WGSIMPLEACC_UPLOAD_PATH', XOOPS_UPLOAD_PATH . '/' . WGSIMPLEACC_DIRNAME);
\define('WGSIMPLEACC_UPLOAD_URL', XOOPS_UPLOAD_URL . '/' . WGSIMPLEACC_DIRNAME);
\define('WGSIMPLEACC_UPLOAD_FILES_PATH', WGSIMPLEACC_UPLOAD_PATH . '/files');
\define('WGSIMPLEACC_UPLOAD_FILES_URL', WGSIMPLEACC_UPLOAD_URL . '/files');
\define('WGSIMPLEACC_UPLOAD_IMAGES_URL', WGSIMPLEACC_UPLOAD_URL . '/images');
\define('WGSIMPLEACC_ADMIN', WGSIMPLEACC_URL . '/admin/index.php');
$localLogo = WGSIMPLEACC_IMAGE_URL . '/wedega_logo.png';
// Module Information
$copyright = "<a href='https://wedega.com' title='Wedega - Webdesign Gabor' target='_blank'><img src='" . $localLogo . "' alt='Wedega - Webdesign Gabor'></a>";
require_once \XOOPS_ROOT_PATH . '/class/xoopsrequest.php';
require_once WGSIMPLEACC_PATH . '/include/functions.php';
