<?php

declare(strict_types=1);

/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

/**
 * wgFileManager module for xoops
 *
 * @copyright    2021 XOOPS Project (https://xoops.org)
 * @license      GPL 2.0 or later
 * @package      wgfilemanager
 * @author       Goffy - Wedega - Email:webmaster@wedega.com - Website:https://xoops.wedega.com
 */

//use XoopsModules\Wgsimpleacc;
use XoopsModules\Wgsimpleacc\Helper;
//use XoopsModules\Wgsimpleacc\Constants;
use Xmf\Request;

require_once \XOOPS_ROOT_PATH . '/modules/wgsimpleacc/include/common.php';

/**
 * Function show block
 * @param  $options
 * @return array
 */
function b_wgsimpleacc_startminnav_show($options)
{

    $helper      = XoopsModules\Wgsimpleacc\Helper::getInstance();

    $permissionsHandler = $helper->getHandler('Permissions');

    // Define Stylesheet
    $GLOBALS['xoTheme']->addStylesheet(\WGSIMPLEACC_URL . '/assets/css/startmin.css', null);

    // Add scripts
    $GLOBALS['xoTheme']->addScript(\WGSIMPLEACC_URL . '/assets/js/metisMenu.min.js');
    $GLOBALS['xoTheme']->addScript(\WGSIMPLEACC_URL . '/assets/js/startmin.js');

    $wgmenu = new \XoopsModules\Wgsimpleacc\Modulemenu;
    //$block=$wgmenu->getMenuitemsStartmin();
    return $wgmenu->getMenuitemsStartmin();

}
