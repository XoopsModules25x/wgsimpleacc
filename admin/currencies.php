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
    Common
};

require __DIR__ . '/header.php';
// It recovered the value of argument op in URL$
$op = Request::getCmd('op', 'list');
// Request cur_id
$curId = Request::getInt('cur_id');
switch ($op) {
    case 'list':
    default:
        // Define Stylesheet
        $GLOBALS['xoTheme']->addStylesheet($style, null);
        $start = Request::getInt('start', 0);
        $limit = Request::getInt('limit', $helper->getConfig('adminpager'));
        $templateMain = 'wgsimpleacc_admin_currencies.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('currencies.php'));
        $adminObject->addItemButton(\_AM_WGSIMPLEACC_ADD_CURRENCY, 'currencies.php?op=new', 'add');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        $currenciesCount = $currenciesHandler->getCountCurrencies();
        $currenciesAll = $currenciesHandler->getAllCurrencies($start, $limit);
        $GLOBALS['xoopsTpl']->assign('currencies_count', $currenciesCount);
        $GLOBALS['xoopsTpl']->assign('wgsimpleacc_url', \WGSIMPLEACC_URL);
        $GLOBALS['xoopsTpl']->assign('wgsimpleacc_upload_url', \WGSIMPLEACC_UPLOAD_URL);
        // Table view currencies
        if ($currenciesCount > 0) {
            foreach (\array_keys($currenciesAll) as $i) {
                $currency = $currenciesAll[$i]->getValuesCurrencies();
                $GLOBALS['xoopsTpl']->append('currencies_list', $currency);
                unset($currency);
            }
            // Display Navigation
            if ($currenciesCount > $limit) {
                require_once \XOOPS_ROOT_PATH . '/class/pagenav.php';
                $pagenav = new \XoopsPageNav($currenciesCount, $limit, $start, 'start', 'op=list&limit=' . $limit);
                $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
            }
        } else {
            $GLOBALS['xoopsTpl']->assign('error', \_MA_WGSIMPLEACC_THEREARENT_CURRENCIES);
        }
        break;
    case 'new':
        $templateMain = 'wgsimpleacc_admin_currencies.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('currencies.php'));
        $adminObject->addItemButton(\_AM_WGSIMPLEACC_LIST_CURRENCIES, 'currencies.php', 'list');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        // Form Create
        $currenciesObj = $currenciesHandler->create();
        $form = $currenciesObj->getFormCurrencies();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'save':
        // Security Check
        if (!$GLOBALS['xoopsSecurity']->check()) {
            \redirect_header('currencies.php', 3, \implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        if ($curId > 0) {
            $currenciesObj = $currenciesHandler->get($curId);
        } else {
            $currenciesObj = $currenciesHandler->create();
        }
        // Set Vars
        $currenciesObj->setVar('cur_code', Request::getString('cur_code', ''));
        $currenciesObj->setVar('cur_name', Request::getString('cur_name', ''));
        $currencyDatecreatedObj = \DateTime::createFromFormat(_SHORTDATESTRING, Request::getString('cur_datecreated'));
        $currenciesObj->setVar('cur_datecreated', $currencyDatecreatedObj->getTimestamp());
        $currenciesObj->setVar('cur_submitter', Request::getInt('cur_submitter', 0));
        $currenciesObj->setVar('cur_online', Request::getInt('cur_online', 0));
        $currenciesObj->setVar('cur_symbol', Request::getString('cur_symbol', ''));
        // Insert Data
        if ($currenciesHandler->insert($currenciesObj)) {
            if (Request::getInt('cur_primary', 0) > 0) {
                $newCurId = $currenciesObj->getNewInsertedIdCurrencies();
                $curId = $curId > 0 ? $curId : $newCurId;
                $currenciesHandler->setPrimaryCurrencies($curId);
            }
            \redirect_header('currencies.php?op=list', 2, \_MA_WGSIMPLEACC_FORM_OK);
        }
        // Get Form
        $GLOBALS['xoopsTpl']->assign('error', $currenciesObj->getHtmlErrors());
        $form = $currenciesObj->getFormCurrencies();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'edit':
        $templateMain = 'wgsimpleacc_admin_currencies.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('currencies.php'));
        $adminObject->addItemButton(\_AM_WGSIMPLEACC_ADD_CURRENCY, 'currencies.php?op=new', 'add');
        $adminObject->addItemButton(\_AM_WGSIMPLEACC_LIST_CURRENCIES, 'currencies.php', 'list');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        // Get Form
        $currenciesObj = $currenciesHandler->get($curId);
        $form = $currenciesObj->getFormCurrencies();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'delete':
        $templateMain = 'wgsimpleacc_admin_currencies.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('currencies.php'));
        $currenciesObj = $currenciesHandler->get($curId);
        $curCode = $currenciesObj->getVar('cur_code');
        if (isset($_REQUEST['ok']) && 1 == $_REQUEST['ok']) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                \redirect_header('currencies.php', 3, \implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            if ($currenciesHandler->delete($currenciesObj)) {
                \redirect_header('currencies.php', 3, \_MA_WGSIMPLEACC_FORM_DELETE_OK);
            } else {
                $GLOBALS['xoopsTpl']->assign('error', $currenciesObj->getHtmlErrors());
            }
        } else {
            $customConfirm = new Common\Confirm(
                ['ok' => 1, 'cur_id' => $curId, 'op' => 'delete'],
                $_SERVER['REQUEST_URI'],
                \sprintf(\_MA_WGSIMPLEACC_FORM_SURE_DELETE, $currenciesObj->getVar('cur_code')));
            $form = $customConfirm->getFormConfirm();
            $GLOBALS['xoopsTpl']->assign('form', $form->render());
        }
        break;
}
require __DIR__ . '/footer.php';
