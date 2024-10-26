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

/**
 * comment callback functions
 *
 * @param  $category
 * @param  $item_id
 * @return array|null item
 */
function wgsimpleacc_notify_iteminfo($category, $item_id): ?array
{
    global $xoopsDB;

    if (!\defined('WGSIMPLEACC_URL')) {
        \define('WGSIMPLEACC_URL', \XOOPS_URL . '/modules/wgsimpleacc');
    }

    switch ($category) {
        case 'global':
            $item['name'] = '';
            $item['url']  = '';
            return $item;
        case 'transactions':
            $sql          = 'SELECT tra_desc FROM ' . $xoopsDB->prefix('wgsimpleacc_transactions') . ' WHERE tra_id = '. $item_id;
            $result       = $xoopsDB->query($sql);
            $result_array = $xoopsDB->fetchArray($result);
            $item['name'] = \strip_tags($result_array['tra_desc']);
            $item['url']  = WGSIMPLEACC_URL . '/transactions.php?tra_id=' . $item_id;
            return $item;
    }
    return null;
}
