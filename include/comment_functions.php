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

/**
 * CommentsUpdate
 *
 * @param mixed  $itemId
 * @param mixed  $itemNumb
 * @return bool
 */
function wgsimpleaccCommentsUpdate(mixed $itemId, mixed $itemNumb): bool
{
    // Get instance of module
    /*
    $helper = Helper::getInstance();

    $imagesHandler = $helper->getHandler('Images');
    $imgId = (int)$itemId;
    $imagesObj = $imagesHandler->get($imgId);
    $imagesObj->setVar('img_comments', (int)$itemNumb);
    if ($imagesHandler->insert($imagesObj)) {
        return true;
    }
    */
    return false;
}

/**
 * CommentsApprove
 *
 * @param mixed $comment
 * @return bool
 */
function wgsimpleaccCommentsApprove(mixed &$comment): bool
{
    // Notification event
    // Get instance of module
    /*
    $helper = Helper::getInstance();

    $imagesHandler = $helper->getHandler('Images');
    $imgId = $comment->getVar('com_itemid');
    $imagesObj = $imagesHandler->get($imgId);
    $imgTraid = $imagesObj->getVar('img_traid');

    $tags = [];
    $tags['ITEM_NAME'] = $imgTraid;
    $tags['ITEM_URL']  = \XOOPS_URL . '/modules/wgsimpleacc/images.php?op=show&img_id=' . $imgId;
    $notificationHandler = \xoops_getHandler('notification');
    // Event modify notification
    $notificationHandler->triggerEvent('global', 0, 'global_comment', $tags);
    $notificationHandler->triggerEvent('images', $imgId, 'image_comment', $tags);
    */
    return true;

}
