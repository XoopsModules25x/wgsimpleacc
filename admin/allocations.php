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

use Xmf\Request;
use XoopsModules\Wgsimpleacc;
use XoopsModules\Wgsimpleacc\Constants;
use XoopsModules\Wgsimpleacc\Common;

require __DIR__ . '/header.php';
// It recovered the value of argument op in URL$
$op    = Request::getCmd('op', 'list');
$start = Request::getInt('start');
$limit = Request::getInt('limit', $helper->getConfig('adminpager'));
// Request all_id
$allId = Request::getInt('all_id');
switch ($op) {
    case 'list':
    default:
        // Define Stylesheet
        $GLOBALS['xoTheme']->addStylesheet($style, null);
        $templateMain = 'wgsimpleacc_admin_allocations.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('allocations.php'));
        $adminObject->addItemButton(\_AM_WGSIMPLEACC_ADD_ALLOCATION, 'allocations.php?op=new');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        $allocationsCount = $allocationsHandler->getCountAllocations();
        $allocationsAll = $allocationsHandler->getAllAllocations($start, $limit);
        $GLOBALS['xoopsTpl']->assign('allocations_count', $allocationsCount);
        $GLOBALS['xoopsTpl']->assign('wgsimpleacc_url', \WGSIMPLEACC_URL);
        $GLOBALS['xoopsTpl']->assign('wgsimpleacc_upload_url', \WGSIMPLEACC_UPLOAD_URL);
        // Table view allocations
        if ($allocationsCount > 0) {
            $accountsHandler = $helper->getHandler('Accounts');
            foreach (\array_keys($allocationsAll) as $i) {
                $allocation = $allocationsAll[$i]->getValuesAllocations();
                // get accounts defined for this allocation
                $arrAccounts = \unserialize($allocationsAll[$i]->getVar('all_accounts'), ['allowed_classes' => false]);
                $allAccounts = [];
                foreach ($arrAccounts as $account) {
                    $accountsObj = $accountsHandler->get($account);
                    if (\is_object($accountsObj)) {
                        $allAccounts[$account] = $accountsObj->getVar('acc_name');
                    }
                    unset($accountsObj);
                }
                $allocation['accounts'] = $allAccounts;
                $GLOBALS['xoopsTpl']->append('allocations_list', $allocation);
                unset($allocation);
            }
            // Display Navigation
            if ($allocationsCount > $limit) {
                require_once \XOOPS_ROOT_PATH . '/class/pagenav.php';
                $pagenav = new \XoopsPageNav($allocationsCount, $limit, $start, 'start', 'op=list&limit=' . $limit);
                $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav());
            }
        } else {
            $GLOBALS['xoopsTpl']->assign('error', \_MA_WGSIMPLEACC_THEREARENT_ALLOCATIONS);
        }
        break;
    case 'new':
        $templateMain = 'wgsimpleacc_admin_allocations.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('allocations.php'));
        $adminObject->addItemButton(\_AM_WGSIMPLEACC_LIST_ALLOCATIONS, 'allocations.php', 'list');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        // Form Create
        $allocationsObj = $allocationsHandler->create();
        $form = $allocationsObj->getFormAllocations($start, $limit, 'list', false, true);
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'save':
        // Security Check
        if (!$GLOBALS['xoopsSecurity']->check()) {
            \redirect_header('allocations.php', 3, \implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        if ($allId > 0) {
            $allocationsObj = $allocationsHandler->get($allId);
        } else {
            $allocationsObj = $allocationsHandler->create();
        }
        // Set Vars
        $allPid = Request::getInt('all_pid');
        $allocationsObj->setVar('all_pid', $allPid);
        $allocationsObj->setVar('all_name', Request::getString('all_name'));
        $allocationsObj->setVar('all_desc', Request::getString('all_desc'));
        $allocationsObj->setVar('all_online', Request::getInt('all_online'));
        $allocationsObj->setVar('all_accounts', \serialize(Request::getArray('all_accounts')));
        $level = 1;
        if ($allPid > 0) {
            $allParentObj = $allocationsHandler->get($allPid);
            $level = $allParentObj->getVar('all_level') + 1;
        }
        unset($allParentObj);
        $allocationsObj->setVar('all_level', $level);
        $allocationsObj->setVar('all_weight', Request::getInt('all_weight'));
        $allocationDatecreatedObj = \DateTime::createFromFormat(_SHORTDATESTRING, Request::getString('all_datecreated'));
        $allocationsObj->setVar('all_datecreated', $allocationDatecreatedObj->getTimestamp());
        $allocationsObj->setVar('all_submitter', Request::getInt('all_submitter'));
        // Insert Data
        if ($allocationsHandler->insert($allocationsObj)) {
            \redirect_header('allocations.php?op=list', 2, \_MA_WGSIMPLEACC_FORM_OK);
        }
        // Get Form
        $GLOBALS['xoopsTpl']->assign('error', $allocationsObj->getHtmlErrors());
        $form = $allocationsObj->getFormAllocations($start, $limit);
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'edit':
        $templateMain = 'wgsimpleacc_admin_allocations.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('allocations.php'));
        $adminObject->addItemButton(\_AM_WGSIMPLEACC_ADD_ALLOCATION, 'allocations.php?op=new');
        $adminObject->addItemButton(\_AM_WGSIMPLEACC_LIST_ALLOCATIONS, 'allocations.php', 'list');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        // Get Form
        $allocationsObj = $allocationsHandler->get($allId);
        $form = $allocationsObj->getFormAllocations($start, $limit, 'list',false, true);
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'delete':
        $templateMain = 'wgsimpleacc_admin_allocations.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('allocations.php'));
        $allocationsObj = $allocationsHandler->get($allId);
        $allName = $allocationsObj->getVar('all_name');
        if (isset($_REQUEST['ok']) && 1 == $_REQUEST['ok']) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                \redirect_header('allocations.php', 3, \implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            if ($allocationsHandler->delete($allocationsObj)) {
                \redirect_header('allocations.php', 3, \_MA_WGSIMPLEACC_FORM_DELETE_OK);
            } else {
                $GLOBALS['xoopsTpl']->assign('error', $allocationsObj->getHtmlErrors());
            }
        } else {
            $customConfirm = new Common\Confirm(
                ['ok' => 1, 'all_id' => $allId, 'op' => 'delete'],
                $_SERVER['REQUEST_URI'],
                \sprintf(\_MA_WGSIMPLEACC_FORM_SURE_DELETE, $allocationsObj->getVar('all_name')), _MA_WGSIMPLEACC_FORM_DELETE_CONFIRM, _MA_WGSIMPLEACC_FORM_DELETE_LABEL);
            $form = $customConfirm->getFormConfirm();
            $GLOBALS['xoopsTpl']->assign('form', $form->render());
        }
        break;
}
require __DIR__ . '/footer.php';
