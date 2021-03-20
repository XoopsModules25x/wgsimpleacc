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
    Common,
    Utility
};

require __DIR__ . '/header.php';
require_once \XOOPS_ROOT_PATH . '/header.php';
$GLOBALS['xoopsTpl']->assign('template_sub', 'db:wgsimpleacc_tratemplates.tpl');
require __DIR__ . '/navbar.php';

// Permissions
if (!$permissionsHandler->getPermTratemplatesView()) {
    \redirect_header('index.php', 0, '');
}

$op    = Request::getCmd('op', 'list');
$start = Request::getInt('start', 0);
$limit = Request::getInt('limit', $helper->getConfig('userpager'));
$tplId = Request::getInt('ttpl_id', 0);

$GLOBALS['xoopsTpl']->assign('xoops_icons32_url', XOOPS_ICONS32_URL);
$GLOBALS['xoopsTpl']->assign('wgsimpleacc_url', WGSIMPLEACC_URL);
$GLOBALS['xoopsTpl']->assign('wgsimpleacc_icons_url_32', WGSIMPLEACC_ICONS_URL . '/32/');
$GLOBALS['xoopsTpl']->assign('showItem', $tplId > 0);

$permSubmit = $permissionsHandler->getPermTratemplatesSubmit();

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
            unset($tratemplates);
            // Display Navigation
            if ($tratemplatesCount > $limit) {
                include_once \XOOPS_ROOT_PATH . '/class/pagenav.php';
                $pagenav = new \XoopsPageNav($tratemplatesCount, $limit, $start, 'start', 'op=list&limit=' . $limit);
                $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
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
            \redirect_header('tratemplates.php?op=list', 3, _NOPERM);
        }
        if ($tplId > 0) {
            $tratemplatesObj = $tratemplatesHandler->get($tplId);
        } else {
            $tratemplatesObj = $tratemplatesHandler->create();
        }
        $tratemplatesObj->setVar('ttpl_name', Request::getString('ttpl_name', ''));
        $tratemplatesObj->setVar('ttpl_desc', Request::getString('ttpl_desc', ''));
        $tratemplatesObj->setVar('ttpl_accid', Request::getInt('ttpl_accid', 0));
        $tratemplatesObj->setVar('ttpl_allid', Request::getInt('ttpl_allid', 0));
        $tratemplatesObj->setVar('ttpl_asid', Request::getInt('ttpl_asid', 0));
        $tratemplatesObj->setVar('ttpl_cliid', Request::getInt('ttpl_cliid', 0));
        $tratemplatesObj->setVar('ttpl_class', Request::getInt('ttpl_class', 0));
        $tplAmountin = Request::getString('ttpl_amountin');
        $tratemplatesObj->setVar('ttpl_amountin', Utility::StringToFloat($tplAmountin));
        $tplAmountout = Request::getString('ttpl_amountout');
        $tratemplatesObj->setVar('ttpl_amountout', Utility::StringToFloat($tplAmountout));
        $tratemplatesObj->setVar('ttpl_online', Request::getInt('ttpl_online', 0));
        $templateDatecreatedObj = \DateTime::createFromFormat(_SHORTDATESTRING, Request::getString('ttpl_datecreated'));
        $tratemplatesObj->setVar('ttpl_datecreated', $templateDatecreatedObj->getTimestamp());
        $tratemplatesObj->setVar('ttpl_submitter', Request::getInt('ttpl_submitter', 0));
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
            \redirect_header('tratemplates.php?op=list', 3, _NOPERM);
        }
        // Form Create
        $tratemplatesObj = $tratemplatesHandler->create();
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
        if (!$permissionsHandler->getPermTratemplatesEdit($tratemplatesObj->getVar('ttpl_submitter'))) {
            \redirect_header('tratemplates.php?op=list', 3, _NOPERM);
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
        if (!$permissionsHandler->getPermTratemplatesEdit($tratemplatesObj->getVar('ttpl_submitter'))) {
            \redirect_header('tratemplates.php?op=list', 3, _NOPERM);
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
            $xoopsconfirm = new Common\XoopsConfirm(
                ['ok' => 1, 'ttpl_id' => $tplId, 'op' => 'delete'],
                $_SERVER['REQUEST_URI'],
                \sprintf(\_MA_WGSIMPLEACC_FORM_SURE_DELETE, $tratemplatesObj->getVar('ttpl_name')));
            $form = $xoopsconfirm->getFormXoopsConfirm();
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

$GLOBALS['xoopsTpl']->assign('xoops_mpageurl', WGSIMPLEACC_URL.'/tratemplates.php');
$GLOBALS['xoopsTpl']->assign('wgsimpleacc_upload_url', WGSIMPLEACC_UPLOAD_URL);

require __DIR__ . '/footer.php';
