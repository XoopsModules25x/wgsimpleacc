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
 * @since          1.0
 * @min_xoops      2.5.10
 * @author         XOOPS Development Team - Email:<webmaster@wedega.com> - Website:<https://xoops.wedega.com>
 */

use Xmf\Request;
use XoopsModules\Wgsimpleacc;
use XoopsModules\Wgsimpleacc\Constants;
use XoopsModules\Wgsimpleacc\Common;

require __DIR__ . '/header.php';
require_once \XOOPS_ROOT_PATH . '/header.php';
$GLOBALS['xoopsTpl']->assign('template_sub', 'db:wgsimpleacc_clients.tpl');
require __DIR__ . '/navbar.php';

// Permissions
if (!$permissionsHandler->getPermClientsView()) {
    \redirect_header('index.php', 0, '');
}

$op      = Request::getCmd('op', 'list');
$start   = Request::getInt('start', 0);
$limit   = Request::getInt('limit', $helper->getConfig('userpager'));
$cliId   = Request::getInt('cli_id', 0);
$cliName = Request::getString('cli_name', '');
$sortBy  = 'cli_' . Request::getString('sortby', 'name');
$orderBy = Request::getString('orderby', 'ASC');

$GLOBALS['xoopsTpl']->assign('start', $start);
$GLOBALS['xoopsTpl']->assign('limit', $limit);
$GLOBALS['xoopsTpl']->assign('xoops_icons32_url', \XOOPS_ICONS32_URL);
$GLOBALS['xoopsTpl']->assign('wgsimpleacc_url', \WGSIMPLEACC_URL);
$GLOBALS['xoopsTpl']->assign('wgsimpleacc_icons_url_32', WGSIMPLEACC_ICONS_URL . '/32/');

$keywords = [];

$permSubmit = $permissionsHandler->getPermClientsSubmit();
$GLOBALS['xoopsTpl']->assign('permSubmit', $permSubmit);
$GLOBALS['xoopsTpl']->assign('showItem', $cliId > 0);

switch ($op) {
    case 'show':
    case 'list':
    default:
        // Breadcrumbs
        $xoBreadcrumbs[] = ['title' => \_MA_WGSIMPLEACC_CLIENTS];

        $showFiltered= false;
        $crClients = new \CriteriaCompo();
        if ($cliId > 0) {
            $crClients->add(new \Criteria('cli_id', $cliId));
            $showFiltered = true;
        }
        if ('' !== $cliName) {
            $crClients->add(new \Criteria('cli_name', '%' . $cliName . '%', 'LIKE'));
        }
        $GLOBALS['xoopsTpl']->assign('showFiltered', $showFiltered);
        $GLOBALS['xoopsTpl']->assign('showList', 'show' !== $op);
        $clientsCount = $clientsHandler->getCount($crClients);
        $GLOBALS['xoopsTpl']->assign('clientsCount', $clientsCount);
        $crClients->setStart($start);
        $crClients->setLimit($limit);
        $crClients->setSort($sortBy);
        $crClients->setOrder($orderBy);
        $clientsAll = $clientsHandler->getAll($crClients);
        if ($clientsCount > 0) {
            $clients = [];
            $clientName = '';
            // Get All Clients
            foreach (\array_keys($clientsAll) as $i) {
                $clients[$i] = $clientsAll[$i]->getValuesClients();
                $clients[$i]['editable'] = $permissionsHandler->getPermClientsEdit($clients[$i]['cli_submitter']);
                $crTransactions = new \CriteriaCompo();
                $crTransactions->add(new \Criteria('tra_cliid', $clients[$i]['cli_id']));
                $transactionsCount = $transactionsHandler->getCount($crTransactions);
                $clients[$i]['deletable'] = (0 == $transactionsCount);
                unset($crTransactions);
                $clientName = $clientsAll[$i]->getVar('cli_name');
                $keywords[$i] = $clientName;
            }
            $GLOBALS['xoopsTpl']->assign('clients', $clients);
            unset($clients);
            // Display Navigation
            if ($clientsCount > $limit) {
                include_once \XOOPS_ROOT_PATH . '/class/pagenav.php';
                $pagenav = new \XoopsPageNav($clientsCount, $limit, $start, 'start', 'op=list&amp;limit=' . $limit . '&amp;cli_name=' . $cliName);
                $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
            }
            $GLOBALS['xoopsTpl']->assign('table_type', $helper->getConfig('table_type'));
            $GLOBALS['xoopsTpl']->assign('panel_type', $helper->getConfig('panel_type'));
            $GLOBALS['xoopsTpl']->assign('divideby', $helper->getConfig('divideby'));
            $GLOBALS['xoopsTpl']->assign('numb_col', $helper->getConfig('numb_col'));
            if ('show' == $op && '' != $clientName) {
                $GLOBALS['xoopsTpl']->assign('xoops_pagetitle', \strip_tags($clientName . ' - ' . $GLOBALS['xoopsModule']->getVar('name')));
            }
        }
        unset($crClients);
        $formFilter = $clientsHandler->getFormFilterClients($cliName);
        $GLOBALS['xoopsTpl']->assign('formFilter', $formFilter->renderSearch());
        break;
    case 'save':
        // Security Check
        if (!$GLOBALS['xoopsSecurity']->check()) {
            \redirect_header('clients.php', 3, \implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        // Check permissions
        if (!$permissionsHandler->getPermClientsSubmit()) {
            \redirect_header('clients.php?op=list', 3, \_NOPERM);
        }
        if ($cliId > 0) {
            $clientsObj = $clientsHandler->get($cliId);
        } else {
            $clientsObj = $clientsHandler->create();
        }
        $clientsObj->setVar('cli_name', Request::getText('cli_name', ''));
        $clientsObj->setVar('cli_postal', Request::getString('cli_postal', ''));
        $clientsObj->setVar('cli_city', Request::getString('cli_city', ''));
        $clientsObj->setVar('cli_address', Request::getText('cli_address', ''));
        $clientsObj->setVar('cli_ctry', Request::getString('cli_ctry', ''));
        $clientsObj->setVar('cli_phone', Request::getString('cli_phone', ''));
        $clientsObj->setVar('cli_vat', Request::getString('cli_vat', ''));
        $clientsObj->setVar('cli_creditor', Request::getInt('cli_creditor', 0));
        $clientsObj->setVar('cli_debtor', Request::getInt('cli_debtor', 0));
        $clientsObj->setVar('cli_online', Request::getInt('cli_online', 0));
        $clientDatecreatedObj = \DateTime::createFromFormat(\_SHORTDATESTRING, Request::getString('cli_datecreated'));
        $clientsObj->setVar('cli_datecreated', $clientDatecreatedObj->getTimestamp());
        $clientsObj->setVar('cli_submitter', Request::getInt('cli_submitter', 0));
        // Insert Data
        if ($clientsHandler->insert($clientsObj)) {
            // redirect after insert
            \redirect_header('clients.php', 2, \_MA_WGSIMPLEACC_FORM_OK);
        }
        // Get Form Error
        $GLOBALS['xoopsTpl']->assign('error', $clientsObj->getHtmlErrors());
        $form = $clientsObj->getFormClients();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'new':
        // Check permissions
        if (!$permissionsHandler->getPermClientsSubmit()) {
            \redirect_header('clients.php?op=list', 3, \_NOPERM);
        }
        // Form Create
        $clientsObj = $clientsHandler->create();
        $form = $clientsObj->getFormClients();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());

        // Breadcrumbs
        $xoBreadcrumbs[] = ['title' => \_MA_WGSIMPLEACC_CLIENTS, 'link' => 'clients.php?op=list'];
        $xoBreadcrumbs[] = ['title' => \_MA_WGSIMPLEACC_CLIENT_ADD];
        break;
    case 'edit':
        // Check params
        if (0 == $cliId) {
            \redirect_header('clients.php?op=list', 3, \_MA_WGSIMPLEACC_INVALID_PARAM);
        }
        // Get Form
        $clientsObj = $clientsHandler->get($cliId);
        // Check permissions
        if (!$permissionsHandler->getPermClientsEdit($clientsObj->getVar('cli_submitter'))) {
            \redirect_header('clients.php?op=list', 3, \_NOPERM);
        }

        $form = $clientsObj->getFormClients();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());

        // Breadcrumbs
        $xoBreadcrumbs[] = ['title' => \_MA_WGSIMPLEACC_CLIENTS, 'link' => 'clients.php?op=list'];
        $xoBreadcrumbs[] = ['title' => \_MA_WGSIMPLEACC_CLIENT_EDIT];
        break;
    case 'delete':
        // Check params
        if (0 == $cliId) {
            \redirect_header('clients.php?op=list', 3, \_MA_WGSIMPLEACC_INVALID_PARAM);
        }
        // Get Form
        $clientsObj = $clientsHandler->get($cliId);
        // Check permissions
        if (!$permissionsHandler->getPermClientsEdit($clientsObj->getVar('cli_submitter'))) {
            \redirect_header('clients.php?op=list', 3, \_NOPERM);
        }
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

        // Breadcrumbs
        $xoBreadcrumbs[] = ['title' => \_MA_WGSIMPLEACC_CLIENTS, 'link' => 'clients.php?op=list'];
        $xoBreadcrumbs[] = ['title' => \_MA_WGSIMPLEACC_CLIENT_EDIT];
        break;
    case 'change_yn':
        if ($cliId > 0) {
            $clientsObj = $clientsHandler->get($cliId);
            $clientsObj->setVar(Request::getString('field'), Request::getInt('value', 0));
            // Insert Data
            if ($clientsHandler->insert($clientsObj, true)) {
                \redirect_header('clients.php?op=list&amp;start=' . $start . '&amp;limit=' . $limit, 2, \_MA_WGSIMPLEACC_FORM_OK);
            }
        }
        break;
}

// Keywords
wgsimpleaccMetaKeywords($helper->getConfig('keywords') . ', ' . \implode(',', $keywords));
unset($keywords);

// Description
$GLOBALS['xoopsTpl']->assign('xoops_mpageurl', \WGSIMPLEACC_URL . '/clients.php');

require __DIR__ . '/footer.php';
