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

use XoopsModules\Wgsimpleacc\Helper;

$dirname       = \basename(\dirname(__DIR__));
$moduleHandler = \xoops_getHandler('module');
$xoopsModule   = XoopsModule::getByDirname($dirname);
$moduleInfo    = $moduleHandler->get($xoopsModule->getVar('mid'));
$sysPathIcon32 = $moduleInfo->getInfo('sysicons32');

$helper = Helper::getInstance();

$adminmenu[] = [
    'title' => \_MI_WGSIMPLEACC_ADMENU1,
    'link' => 'admin/index.php',
    'icon' => 'assets/icons/32/dashboard.png',
];
$adminmenu[] = [
    'title' => \_MI_WGSIMPLEACC_ADMENU2,
    'link' => 'admin/transactions.php',
    'icon' => 'assets/icons/32/transactions.png',
];
if ($helper->getConfig('use_trahistories')) {
    $adminmenu[] = [
        'title' => \_MI_WGSIMPLEACC_ADMENU14,
        'link' => 'admin/trahistories.php',
        'icon' => 'assets/icons/32/trahistories.png',
    ];
}
$adminmenu[] = [
    'title' => \_MI_WGSIMPLEACC_ADMENU3,
    'link' => 'admin/files.php',
    'icon' => 'assets/icons/32/files.png',
];
if ($helper->getConfig('use_filhistories')) {
    $adminmenu[] = [
        'title' => \_MI_WGSIMPLEACC_ADMENU16,
        'link' => 'admin/filhistories.php',
        'icon' => 'assets/icons/32/filhistories.png',
    ];
}
$adminmenu[] = [
    'title' => \_MI_WGSIMPLEACC_ADMENU4,
    'link' => 'admin/assets.php',
    'icon' => 'assets/icons/32/assets.png',
];
$adminmenu[] = [
    'title' => \_MI_WGSIMPLEACC_ADMENU5,
    'link' => 'admin/accounts.php',
    'icon' => 'assets/icons/32/accounts.png',
];
$adminmenu[] = [
    'title' => \_MI_WGSIMPLEACC_ADMENU6,
    'link' => 'admin/allocations.php',
    'icon' => 'assets/icons/32/allocations.png',
];
$adminmenu[] = [
    'title' => \_MI_WGSIMPLEACC_ADMENU9,
    'link' => 'admin/balances.php',
    'icon' => 'assets/icons/32/balances.png',
];
if ($helper->getConfig('use_currencies')) {
    $adminmenu[] = [
        'title' => \_MI_WGSIMPLEACC_ADMENU7,
        'link' => 'admin/currencies.php',
        'icon' => 'assets/icons/32/currencies.png',
    ];
}
if ($helper->getConfig('use_taxes')) {
    $adminmenu[] = [
        'title' => \_MI_WGSIMPLEACC_ADMENU8,
        'link' => 'admin/taxes.php',
        'icon' => 'assets/icons/32/taxes.png',
    ];
}
$adminmenu[] = [
    'title' => \_MI_WGSIMPLEACC_ADMENU10,
    'link' => 'admin/tratemplates.php',
    'icon' => 'assets/icons/32/tratemplates.png',
];
$adminmenu[] = [
    'title' => \_MI_WGSIMPLEACC_ADMENU11,
    'link' => 'admin/outtemplates.php',
    'icon' => 'assets/icons/32/outtemplates.png',
];
if ($helper->getConfig('use_clients')) {
    $adminmenu[] = [
        'title' => \_MI_WGSIMPLEACC_ADMENU15,
        'link' => 'admin/clients.php',
        'icon' => 'assets/icons/32/clients.png',
    ];
}
$adminmenu[] = [
    'title' => \_MI_WGSIMPLEACC_ADMENU12,
    'link' => 'admin/permissions.php',
    'icon' => 'assets/icons/32/permissions.png',
];
$adminmenu[] = [
    'title' => \_MI_WGSIMPLEACC_ADMENU13,
    'link' => 'admin/feedback.php',
    'icon' => 'assets/icons/32/feedback.png',
];
$adminmenu[] = [
    'title' => \_MI_WGSIMPLEACC_ABOUT,
    'link' => 'admin/about.php',
    'icon' => 'assets/icons/32/about.png',
];
