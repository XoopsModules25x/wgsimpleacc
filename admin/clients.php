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
 * wgSimpleAcc module for xoops
 *
 * @copyright      2020 XOOPS Project (https://xooops.org)
 * @license        GPL 2.0 or later
 * @package        wgsimpleacc
 * @author         XOOPS Development Team - Email:<webmaster@wedega.com> - Website:<https://xoops.wedega.com>
 */

use Xmf\Request;
use XoopsModules\Wgsimpleacc;
use XoopsModules\Wgsimpleacc\Constants;
use XoopsModules\Wgsimpleacc\Common;

require __DIR__ . '/header.php';
// It recovered the value of argument op in URL$
$op = Request::getCmd('op', 'list');
// Request cli_id
$cliId = Request::getInt('cli_id');
switch ($op) {
    case 'list':
    default:
        // Define Stylesheet
        $GLOBALS['xoTheme']->addStylesheet($style, null);
        $start = Request::getInt('start');
        $limit = Request::getInt('limit', $helper->getConfig('adminpager'));
        $templateMain = 'wgsimpleacc_admin_clients.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('clients.php'));
        $adminObject->addItemButton(\_AM_WGSIMPLEACC_ADD_CLIENT, 'clients.php?op=new');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        $clientsCount = $clientsHandler->getCountClients();
        $clientsAll = $clientsHandler->getAllClients($start, $limit);
        $GLOBALS['xoopsTpl']->assign('clients_count', $clientsCount);
        $GLOBALS['xoopsTpl']->assign('wgsimpleacc_url', \WGSIMPLEACC_URL);
        $GLOBALS['xoopsTpl']->assign('wgsimpleacc_upload_url', \WGSIMPLEACC_UPLOAD_URL);
        // Table view clients
        if ($clientsCount > 0) {
            foreach (\array_keys($clientsAll) as $i) {
                $client = $clientsAll[$i]->getValuesClients();
                $GLOBALS['xoopsTpl']->append('clients_list', $client);
                unset($client);
            }
            // Display Navigation
            if ($clientsCount > $limit) {
                include_once \XOOPS_ROOT_PATH . '/class/pagenav.php';
                $pagenav = new \XoopsPageNav($clientsCount, $limit, $start, 'start', 'op=list&limit=' . $limit);
                $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav());
            }
        } else {
            $GLOBALS['xoopsTpl']->assign('error', \_MA_WGSIMPLEACC_THEREARENT_CLIENTS);
        }
        break;
    case 'new':
        $templateMain = 'wgsimpleacc_admin_clients.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('clients.php'));
        $adminObject->addItemButton(\_AM_WGSIMPLEACC_LIST_CLIENTS, 'clients.php', 'list');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        // Form Create
        $clientsObj = $clientsHandler->create();
        $form = $clientsObj->getFormClients();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'save':
        // Security Check
        if (!$GLOBALS['xoopsSecurity']->check()) {
            \redirect_header('clients.php', 3, \implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        if ($cliId > 0) {
            $clientsObj = $clientsHandler->get($cliId);
        } else {
            $clientsObj = $clientsHandler->create();
        }
        // Set Vars
        $clientsObj->setVar('cli_name', Request::getText('cli_name'));
        $clientsObj->setVar('cli_postal', Request::getString('cli_postal'));
        $clientsObj->setVar('cli_city', Request::getString('cli_city'));
        $clientsObj->setVar('cli_address', Request::getText('cli_address'));
        $clientsObj->setVar('cli_ctry', Request::getString('cli_ctry'));
        $clientsObj->setVar('cli_phone', Request::getString('cli_phone'));
        $clientsObj->setVar('cli_vat', Request::getString('cli_vat'));
        $clientsObj->setVar('cli_creditor', Request::getInt('cli_creditor'));
        $clientsObj->setVar('cli_debtor', Request::getInt('cli_debtor'));
        $clientsObj->setVar('cli_online', Request::getInt('cli_online'));
        $clientDatecreatedObj = \DateTime::createFromFormat(_SHORTDATESTRING, Request::getString('cli_datecreated'));
        $clientsObj->setVar('cli_datecreated', $clientDatecreatedObj->getTimestamp());
        $clientsObj->setVar('cli_submitter', Request::getInt('cli_submitter'));
        // Insert Data
        if ($clientsHandler->insert($clientsObj)) {
            \redirect_header('clients.php?op=list', 2, \_MA_WGSIMPLEACC_FORM_OK);
        }
        // Get Form
        $GLOBALS['xoopsTpl']->assign('error', $clientsObj->getHtmlErrors());
        $form = $clientsObj->getFormClients();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'edit':
        $templateMain = 'wgsimpleacc_admin_clients.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('clients.php'));
        $adminObject->addItemButton(\_AM_WGSIMPLEACC_ADD_CLIENT, 'clients.php?op=new');
        $adminObject->addItemButton(\_AM_WGSIMPLEACC_LIST_CLIENTS, 'clients.php', 'list');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        // Get Form
        $clientsObj = $clientsHandler->get($cliId);
        $form = $clientsObj->getFormClients();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'delete':
        $templateMain = 'wgsimpleacc_admin_clients.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('clients.php'));
        $clientsObj = $clientsHandler->get($cliId);
        $cliName = $clientsObj->getVar('cli_name');
        if (isset($_REQUEST['ok']) && 1 == $_REQUEST['ok']) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                \redirect_header('clients.php', 3, \implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            if ($clientsHandler->delete($clientsObj)) {
                \redirect_header('clients.php', 3, \_MA_WGSIMPLEACC_FORM_DELETE_OK);
            } else {
                $GLOBALS['xoopsTpl']->assign('error', $clientsObj->getHtmlErrors());
            }
        } else {
            $customConfirm = new Common\Confirm(
                ['ok' => 1, 'cli_id' => $cliId, 'op' => 'delete'],
                $_SERVER['REQUEST_URI'],
                \sprintf(\_MA_WGSIMPLEACC_FORM_SURE_DELETE, $clientsObj->getVar('cli_name')), _MA_WGSIMPLEACC_FORM_DELETE_CONFIRM, _MA_WGSIMPLEACC_FORM_DELETE_LABEL);
            $form = $customConfirm->getFormConfirm();
            $GLOBALS['xoopsTpl']->assign('form', $form->render());
        }
        break;
}
require __DIR__ . '/footer.php';
