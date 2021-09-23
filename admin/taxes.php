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
// Request tax_id
$taxId = Request::getInt('tax_id');
switch ($op) {
    case 'list':
    default:
        // Define Stylesheet
        $GLOBALS['xoTheme']->addStylesheet($style, null);
        $start = Request::getInt('start', 0);
        $limit = Request::getInt('limit', $helper->getConfig('adminpager'));
        $templateMain = 'wgsimpleacc_admin_taxes.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('taxes.php'));
        $adminObject->addItemButton(\_AM_WGSIMPLEACC_ADD_TAX, 'taxes.php?op=new', 'add');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        $taxesCount = $taxesHandler->getCountTaxes();
        $taxesAll = $taxesHandler->getAllTaxes($start, $limit);
        $GLOBALS['xoopsTpl']->assign('taxes_count', $taxesCount);
        $GLOBALS['xoopsTpl']->assign('wgsimpleacc_url', \WGSIMPLEACC_URL);
        $GLOBALS['xoopsTpl']->assign('wgsimpleacc_upload_url', \WGSIMPLEACC_UPLOAD_URL);
        // Table view taxes
        if ($taxesCount > 0) {
            foreach (\array_keys($taxesAll) as $i) {
                $tax = $taxesAll[$i]->getValuesTaxes();
                $GLOBALS['xoopsTpl']->append('taxes_list', $tax);
                unset($tax);
            }
            // Display Navigation
            if ($taxesCount > $limit) {
                require_once \XOOPS_ROOT_PATH . '/class/pagenav.php';
                $pagenav = new \XoopsPageNav($taxesCount, $limit, $start, 'start', 'op=list&limit=' . $limit);
                $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
            }
        } else {
            $GLOBALS['xoopsTpl']->assign('error', \_MA_WGSIMPLEACC_THEREARENT_TAXES);
        }
        break;
    case 'new':
        $templateMain = 'wgsimpleacc_admin_taxes.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('taxes.php'));
        $adminObject->addItemButton(\_AM_WGSIMPLEACC_LIST_TAXES, 'taxes.php', 'list');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        // Form Create
        $taxesObj = $taxesHandler->create();
        $form = $taxesObj->getFormTaxes();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'save':
        // Security Check
        if (!$GLOBALS['xoopsSecurity']->check()) {
            \redirect_header('taxes.php', 3, \implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        if ($taxId > 0) {
            $taxesObj = $taxesHandler->get($taxId);
        } else {
            $taxesObj = $taxesHandler->create();
        }
        // Set Vars
        $taxesObj->setVar('tax_name', Request::getString('tax_name', ''));
        $taxesObj->setVar('tax_rate', Request::getInt('tax_rate', 0));
        $taxesObj->setVar('tax_online', Request::getInt('tax_online', 0));
        $taxDatecreatedObj = \DateTime::createFromFormat(_SHORTDATESTRING, Request::getString('tax_datecreated'));
        $taxesObj->setVar('tax_datecreated', $taxDatecreatedObj->getTimestamp());
        $taxesObj->setVar('tax_submitter', Request::getInt('tax_submitter', 0));
        // Insert Data
        if ($taxesHandler->insert($taxesObj)) {
            if (Request::getInt('tax_primary', 0) > 0) {
                $newTaxId = $taxesObj->getNewInsertedIdTaxes();
                $taxId = $taxId > 0 ? $taxId : $newTaxId;
                $taxesHandler->setPrimaryTaxes($taxId);
            }
            \redirect_header('taxes.php?op=list', 2, \_MA_WGSIMPLEACC_FORM_OK);
        }
        // Get Form
        $GLOBALS['xoopsTpl']->assign('error', $taxesObj->getHtmlErrors());
        $form = $taxesObj->getFormTaxes();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'edit':
        $templateMain = 'wgsimpleacc_admin_taxes.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('taxes.php'));
        $adminObject->addItemButton(\_AM_WGSIMPLEACC_ADD_TAX, 'taxes.php?op=new', 'add');
        $adminObject->addItemButton(\_AM_WGSIMPLEACC_LIST_TAXES, 'taxes.php', 'list');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        // Get Form
        $taxesObj = $taxesHandler->get($taxId);
        $form = $taxesObj->getFormTaxes();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'delete':
        $templateMain = 'wgsimpleacc_admin_taxes.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('taxes.php'));
        $taxesObj = $taxesHandler->get($taxId);
        $taxName = $taxesObj->getVar('tax_name');
        if (isset($_REQUEST['ok']) && 1 == $_REQUEST['ok']) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                \redirect_header('taxes.php', 3, \implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            if ($taxesHandler->delete($taxesObj)) {
                \redirect_header('taxes.php', 3, \_MA_WGSIMPLEACC_FORM_DELETE_OK);
            } else {
                $GLOBALS['xoopsTpl']->assign('error', $taxesObj->getHtmlErrors());
            }
        } else {
            $xoopsconfirm = new Common\XoopsConfirm(
                ['ok' => 1, 'tax_id' => $taxId, 'op' => 'delete'],
                $_SERVER['REQUEST_URI'],
                \sprintf(\_MA_WGSIMPLEACC_FORM_SURE_DELETE, $taxesObj->getVar('tax_name')));
            $form = $xoopsconfirm->getFormXoopsConfirm();
            $GLOBALS['xoopsTpl']->assign('form', $form->render());
        }
        break;
}
require __DIR__ . '/footer.php';
