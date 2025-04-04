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
use XoopsModules\Wgsimpleacc\{
    Constants,
    Common,
    Utility
};

require __DIR__ . '/header.php';
require_once \XOOPS_ROOT_PATH . '/header.php';
$GLOBALS['xoopsTpl']->assign('template_sub', 'db:wgsimpleacc_tratemplates.tpl');

foreach ($styles as $style) {
    $GLOBALS['xoTheme']->addStylesheet($style, null);
}

// Permissions
if (!$permissionsHandler->getPermTratemplatesView()) {
    \redirect_header('index.php', 0);
}

$op    = Request::getCmd('op', 'list');
$start = Request::getInt('start');
$limit = Request::getInt('limit', $helper->getConfig('userpager'));
$tplId = Request::getInt('ttpl_id');

$GLOBALS['xoopsTpl']->assign('showItem', $tplId > 0);

$permSubmit  = $permissionsHandler->getPermTratemplatesSubmit();
$permApprove = $permissionsHandler->getPermTratemplatesApprove();

$keywords = [];

switch ($op) {
    case 'show':
    case 'list':
    default:
        $GLOBALS['xoopsTpl']->assign('showList', true);
        $GLOBALS['xoopsTpl']->assign('useClients', $helper->getConfig('use_clients'));
        $crTratemplates = new \CriteriaCompo();
        if ($tplId > 0) {
            $crTratemplates->add(new \Criteria('ttpl_id', $tplId));
        }
        $tratemplatesCount = $tratemplatesHandler->getCount($crTratemplates);
        $GLOBALS['xoopsTpl']->assign('tratemplatesCount', $tratemplatesCount);
        $crTratemplates->setStart($start);
        $crTratemplates->setLimit($limit);
        $tratemplatesAll = $tratemplatesHandler->getAll($crTratemplates);
        if ($tratemplatesCount > 0) {
            $tratemplates = [];
            // Get All Tratemplates
            foreach (\array_keys($tratemplatesAll) as $i) {
                $tratemplates[$i] = $tratemplatesAll[$i]->getValuesTratemplates();
                $tratemplates[$i]['edit'] = $permissionsHandler->getPermTratemplatesEdit($tratemplates[$i]['ttpl_submitter']);
                $keywords[$i] = $tratemplatesAll[$i]->getVar('ttpl_name');
            }
            $GLOBALS['xoopsTpl']->assign('tratemplates', $tratemplates);
            $GLOBALS['xoopsTpl']->assign('permSubmit', $permSubmit);
            $GLOBALS['xoopsTpl']->assign('permApprove', $permApprove);
            unset($tratemplates);
            // Display Navigation
            if ($tratemplatesCount > $limit) {
                include_once \XOOPS_ROOT_PATH . '/class/pagenav.php';
                $pagenav = new \XoopsPageNav($tratemplatesCount, $limit, $start, 'start', 'op=list&limit=' . $limit);
                $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav());
            }
        }

        // Breadcrumbs
        $xoBreadcrumbs[] = ['title' => \_MA_WGSIMPLEACC_TRATEMPLATES];
        break;
    case 'save':
        // Security Check
        if (!$GLOBALS['xoopsSecurity']->check()) {
            \redirect_header('tratemplates.php', 3, \implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        // Check permissions
        if (!$permSubmit) {
            \redirect_header('tratemplates.php?op=list', 3, \_NOPERM);
        }
        if ($tplId > 0) {
            $tratemplatesObj = $tratemplatesHandler->get($tplId);
        } else {
            $tratemplatesObj = $tratemplatesHandler->create();
        }
        $tratemplatesObj->setVar('ttpl_name', Request::getString('ttpl_name'));
        $tratemplatesObj->setVar('ttpl_desc', Request::getText('ttpl_desc'));
        $tratemplatesObj->setVar('ttpl_accid', Request::getInt('ttpl_accid'));
        $tratemplatesObj->setVar('ttpl_allid', Request::getInt('ttpl_allid'));
        $tratemplatesObj->setVar('ttpl_asid', Request::getInt('ttpl_asid'));
        $tratemplatesObj->setVar('ttpl_cliid', Request::getInt('ttpl_cliid'));
        $tratemplatesObj->setVar('ttpl_class', Request::getInt('ttpl_class'));
        $tplAmountin = Request::getString('ttpl_amountin');
        $tratemplatesObj->setVar('ttpl_amountin', Utility::StringToFloat($tplAmountin));
        $tplAmountout = Request::getString('ttpl_amountout');
        $tratemplatesObj->setVar('ttpl_amountout', Utility::StringToFloat($tplAmountout));
        $tratemplatesObj->setVar('ttpl_online', Request::getInt('ttpl_online'));
        $templateDatecreatedObj = \DateTime::createFromFormat(\_SHORTDATESTRING, Request::getString('ttpl_datecreated'));
        $tratemplatesObj->setVar('ttpl_datecreated', $templateDatecreatedObj->getTimestamp());
        $tratemplatesObj->setVar('ttpl_submitter', Request::getInt('ttpl_submitter'));
        // Insert Data
        if ($tratemplatesHandler->insert($tratemplatesObj)) {
            // redirect after insert
            \redirect_header('tratemplates.php', 2, \_MA_WGSIMPLEACC_FORM_OK);
        }
        // Get Form Error
        $GLOBALS['xoopsTpl']->assign('error', $tratemplatesObj->getHtmlErrors());
        $form = $tratemplatesObj->getFormTratemplates();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'new':
        // Check permissions
        if (!$permSubmit) {
            \redirect_header('tratemplates.php?op=list', 3, \_NOPERM);
        }
        $traId = Request::getInt('tra_id');
        // Form Create
        $tratemplatesObj = $tratemplatesHandler->create();
        if ($traId > 0) {
            $transactionsObj = $transactionsHandler->get($traId);
            $tratemplatesObj->setVar('ttpl_desc', $transactionsObj->getVar('tra_desc', 'n'));
            $tratemplatesObj->setVar('ttpl_accid', $transactionsObj->getVar('tra_accid'));
            $tratemplatesObj->setVar('ttpl_allid', $transactionsObj->getVar('tra_allid'));
            $tratemplatesObj->setVar('ttpl_asid', $transactionsObj->getVar('tra_asid'));
            $tratemplatesObj->setVar('ttpl_cliid', $transactionsObj->getVar('tra_cliid'));
            $tratemplatesObj->setVar('ttpl_class', $transactionsObj->getVar('tra_class'));
            $tratemplatesObj->setVar('ttpl_amountin', $transactionsObj->getVar('tra_amountin'));
            $tratemplatesObj->setVar('ttpl_amountout', $transactionsObj->getVar('tra_amountout'));
        }
        $form = $tratemplatesObj->getFormTratemplates();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());

        // Breadcrumbs
        $xoBreadcrumbs[] = ['title' => \_MA_WGSIMPLEACC_TRATEMPLATES, 'link' => 'tratemplates.php?op=list'];
        $xoBreadcrumbs[] = ['title' => \_MA_WGSIMPLEACC_TRATEMPLATE_ADD];
        break;
    case 'edit':
        // Check params
        if (0 == $tplId) {
            \redirect_header('tratemplates.php?op=list', 3, \_MA_WGSIMPLEACC_INVALID_PARAM);
        }
        // Get Form
        $tratemplatesObj = $tratemplatesHandler->get($tplId);
        // Check permissions
        if (!$permApprove && !$permissionsHandler->getPermTratemplatesEdit($tratemplatesObj->getVar('ttpl_submitter'))) {
            \redirect_header('tratemplates.php?op=list', 3, \_NOPERM);
        }
        $form = $tratemplatesObj->getFormTratemplates();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());

        // Breadcrumbs
        $xoBreadcrumbs[] = ['title' => \_MA_WGSIMPLEACC_TRATEMPLATES, 'link' => 'tratemplates.php?op=list'];
        $xoBreadcrumbs[] = ['title' => \_MA_WGSIMPLEACC_TRATEMPLATE_EDIT];
        break;
    case 'delete':
        // Check params
        if (0 == $tplId) {
            \redirect_header('tratemplates.php?op=list', 3, \_MA_WGSIMPLEACC_INVALID_PARAM);
        }
        $tratemplatesObj = $tratemplatesHandler->get($tplId);
        // Check permissions
        if (!$permApprove && !$permissionsHandler->getPermTratemplatesEdit($tratemplatesObj->getVar('ttpl_submitter'))) {
            \redirect_header('tratemplates.php?op=list', 3, \_NOPERM);
        }
        $tplName = $tratemplatesObj->getVar('ttpl_name');
        if (isset($_REQUEST['ok']) && 1 == $_REQUEST['ok']) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                \redirect_header('tratemplates.php', 3, \implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            if ($tratemplatesHandler->delete($tratemplatesObj)) {
                \redirect_header('tratemplates.php', 3, \_MA_WGSIMPLEACC_FORM_DELETE_OK);
            } else {
                $GLOBALS['xoopsTpl']->assign('error', $tratemplatesObj->getHtmlErrors());
            }
        } else {
            $customConfirm = new Common\Confirm(
                ['ok' => 1, 'ttpl_id' => $tplId, 'op' => 'delete'],
                $_SERVER['REQUEST_URI'],
                \sprintf(\_MA_WGSIMPLEACC_FORM_SURE_DELETE, $tratemplatesObj->getVar('ttpl_name')), _MA_WGSIMPLEACC_FORM_DELETE_CONFIRM, _MA_WGSIMPLEACC_FORM_DELETE_LABEL);
            $form = $customConfirm->getFormConfirm();
            $GLOBALS['xoopsTpl']->assign('form', $form->render());

            // Breadcrumbs
            $xoBreadcrumbs[] = ['title' => \_MA_WGSIMPLEACC_TRATEMPLATES, 'link' => 'tratemplates.php?op=list'];
            $xoBreadcrumbs[] = ['title' => \_MA_WGSIMPLEACC_TRATEMPLATE_EDIT];
        }
        break;
}

// Keywords
wgsimpleaccMetaKeywords($helper->getConfig('keywords') . ', ' . \implode(',', $keywords));
unset($keywords);

$GLOBALS['xoopsTpl']->assign('xoops_mpageurl', \WGSIMPLEACC_URL.'/tratemplates.php');
$GLOBALS['xoopsTpl']->assign('wgsimpleacc_upload_url', \WGSIMPLEACC_UPLOAD_URL);

require __DIR__ . '/footer.php';
