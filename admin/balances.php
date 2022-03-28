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

require __DIR__ . '/header.php';
// It recovered the value of argument op in URL$
$op = Request::getCmd('op', 'list');
// Request bal_id
$balId = Request::getInt('bal_id');
switch ($op) {
    case 'list':
    default:
        // Define Stylesheet
        $GLOBALS['xoTheme']->addStylesheet($style, null);
        $start = Request::getInt('start');
        $limit = Request::getInt('limit', $helper->getConfig('adminpager'));
        $templateMain = 'wgsimpleacc_admin_balances.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('balances.php'));
        $adminObject->addItemButton(\_AM_WGSIMPLEACC_ADD_BALANCE, 'balances.php?op=new');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        $balancesCount = $balancesHandler->getCountBalances();
        $balancesAll = $balancesHandler->getAllBalances($start, $limit);
        $GLOBALS['xoopsTpl']->assign('balances_count', $balancesCount);
        $GLOBALS['xoopsTpl']->assign('wgsimpleacc_url', \WGSIMPLEACC_URL);
        $GLOBALS['xoopsTpl']->assign('wgsimpleacc_upload_url', \WGSIMPLEACC_UPLOAD_URL);
        // Table view balances
        if ($balancesCount > 0) {
            foreach (\array_keys($balancesAll) as $i) {
                $balance = $balancesAll[$i]->getValuesBalances();
                $GLOBALS['xoopsTpl']->append('balances_list', $balance);
                unset($balance);
            }
            // Display Navigation
            if ($balancesCount > $limit) {
                require_once \XOOPS_ROOT_PATH . '/class/pagenav.php';
                $pagenav = new \XoopsPageNav($balancesCount, $limit, $start, 'start', 'op=list&limit=' . $limit);
                $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav());
            }
        } else {
            $GLOBALS['xoopsTpl']->assign('error', \_MA_WGSIMPLEACC_THEREARENT_BALANCES);
        }
        break;
    case 'new':
        $templateMain = 'wgsimpleacc_admin_balances.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('balances.php'));
        $adminObject->addItemButton(\_AM_WGSIMPLEACC_LIST_BALANCES, 'balances.php', 'list');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        // Form Create
        $balancesObj = $balancesHandler->create();
        $form = $balancesObj->getFormBalances(false, true);
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'save':
        // Security Check
        if (!$GLOBALS['xoopsSecurity']->check()) {
            \redirect_header('balances.php', 3, \implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        if ($balId > 0) {
            $balancesObj = $balancesHandler->get($balId);
        } else {
            $balancesObj = $balancesHandler->create();
        }
        // Set Vars
        $balanceFromObj = \DateTime::createFromFormat(Utility::CustomDateFormat(), Request::getString('bal_from') . ' 00:00');
        $balancesObj->setVar('bal_from', $balanceFromObj->getTimestamp());
        $balanceToObj = \DateTime::createFromFormat(Utility::CustomDateFormat(), Request::getString('bal_to') . ' 23:59');
        $balancesObj->setVar('bal_to', $balanceToObj->getTimestamp());
        $balancesObj->setVar('bal_asid', Request::getInt('bal_asid'));
        $balancesObj->setVar('bal_curid', Request::getInt('bal_curid'));
        $balAmountStart = Request::getString('bal_amountstart');
        $balancesObj->setVar('bal_amountstart', Utility::StringToFloat($balAmountStart));
        $balAmount = Request::getString('bal_amountend');
        $balancesObj->setVar('bal_amountend', Utility::StringToFloat($balAmount));
        $balancesObj->setVar('bal_status', Request::getInt('bal_status'));
        $balanceDatecreatedObj = \DateTime::createFromFormat(_SHORTDATESTRING, Request::getString('bal_datecreated'));
        $balancesObj->setVar('bal_datecreated', $balanceDatecreatedObj->getTimestamp());
        $balancesObj->setVar('bal_submitter', Request::getInt('bal_submitter'));
        // Insert Data
        if ($balancesHandler->insert($balancesObj)) {
            \redirect_header('balances.php?op=list', 2, \_MA_WGSIMPLEACC_FORM_OK);
        }
        // Get Form
        $GLOBALS['xoopsTpl']->assign('error', $balancesObj->getHtmlErrors());
        $form = $balancesObj->getFormBalances(false, true);
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'edit':
        $templateMain = 'wgsimpleacc_admin_balances.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('balances.php'));
        $adminObject->addItemButton(\_AM_WGSIMPLEACC_ADD_BALANCE, 'balances.php?op=new');
        $adminObject->addItemButton(\_AM_WGSIMPLEACC_LIST_BALANCES, 'balances.php', 'list');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        // Get Form
        $balancesObj = $balancesHandler->get($balId);
        $form = $balancesObj->getFormBalances(false, true);
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'delete':
        $templateMain = 'wgsimpleacc_admin_balances.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('balances.php'));
        $balancesObj = $balancesHandler->get($balId);
        $balFrom = $balancesObj->getVar('bal_from');
        if (isset($_REQUEST['ok']) && 1 == $_REQUEST['ok']) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                \redirect_header('balances.php', 3, \implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            if ($balancesHandler->delete($balancesObj)) {
                \redirect_header('balances.php', 3, \_MA_WGSIMPLEACC_FORM_DELETE_OK);
            } else {
                $GLOBALS['xoopsTpl']->assign('error', $balancesObj->getHtmlErrors());
            }
        } else {
            $customConfirm = new Common\Confirm(
                ['ok' => 1, 'bal_id' => $balId, 'op' => 'delete'],
                $_SERVER['REQUEST_URI'],
                \sprintf(\_MA_WGSIMPLEACC_FORM_SURE_DELETE, $balancesObj->getVar('bal_id')));
            $form = $customConfirm->getFormConfirm();
            $GLOBALS['xoopsTpl']->assign('form', $form->render());
        }
        break;
}
require __DIR__ . '/footer.php';
