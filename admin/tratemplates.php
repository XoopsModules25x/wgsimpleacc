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
// Request ttpl_id
$tplId = Request::getInt('ttpl_id');
switch ($op) {
    case 'list':
    default:
        // Define Stylesheet
        $GLOBALS['xoTheme']->addStylesheet($style, null);
        $start = Request::getInt('start', 0);
        $limit = Request::getInt('limit', $helper->getConfig('adminpager'));
        $templateMain = 'wgsimpleacc_admin_tratemplates.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('tratemplates.php'));
        $adminObject->addItemButton(\_AM_WGSIMPLEACC_ADD_TRATEMPLATE, 'tratemplates.php?op=new', 'add');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        $tratemplatesCount = $tratemplatesHandler->getCountTratemplates();
        $tratemplatesAll = $tratemplatesHandler->getAllTratemplates($start, $limit);
        $GLOBALS['xoopsTpl']->assign('tratemplates_count', $tratemplatesCount);
        $GLOBALS['xoopsTpl']->assign('wgsimpleacc_url', WGSIMPLEACC_URL);
        $GLOBALS['xoopsTpl']->assign('wgsimpleacc_upload_url', WGSIMPLEACC_UPLOAD_URL);
        // Table view tratemplates
        if ($tratemplatesCount > 0) {
            foreach (\array_keys($tratemplatesAll) as $i) {
                $template = $tratemplatesAll[$i]->getValuesTratemplates();
                $GLOBALS['xoopsTpl']->append('tratemplates_list', $template);
                unset($template);
            }
            // Display Navigation
            if ($tratemplatesCount > $limit) {
                include_once \XOOPS_ROOT_PATH . '/class/pagenav.php';
                $pagenav = new \XoopsPageNav($tratemplatesCount, $limit, $start, 'start', 'op=list&limit=' . $limit);
                $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
            }
        } else {
            $GLOBALS['xoopsTpl']->assign('error', \_MA_WGSIMPLEACC_THEREARENT_TRATEMPLATES);
        }
        break;
    case 'new':
        $templateMain = 'wgsimpleacc_admin_tratemplates.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('tratemplates.php'));
        $adminObject->addItemButton(\_AM_WGSIMPLEACC_LIST_TRATEMPLATES, 'tratemplates.php', 'list');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        // Form Create
        $tratemplatesObj = $tratemplatesHandler->create();
        $form = $tratemplatesObj->getFormTratemplates();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'save':
        // Security Check
        if (!$GLOBALS['xoopsSecurity']->check()) {
            \redirect_header('tratemplates.php', 3, \implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        if ($tplId > 0) {
            $tratemplatesObj = $tratemplatesHandler->get($tplId);
        } else {
            $tratemplatesObj = $tratemplatesHandler->create();
        }
        // Set Vars
        $tratemplatesObj->setVar('ttpl_name', Request::getString('ttpl_name', ''));
        $tratemplatesObj->setVar('ttpl_desc', Request::getString('ttpl_desc', ''));
        $tratemplatesObj->setVar('ttpl_accid', Request::getInt('ttpl_accid', 0));
        $tratemplatesObj->setVar('ttpl_allid', Request::getInt('ttpl_allid', 0));
        $tratemplatesObj->setVar('ttpl_asid', Request::getInt('ttpl_asid', 0));
        $tratemplatesObj->setVar('ttpl_cliid', Request::getInt('ttpl_cliid', 0));
        $tratemplatesObj->setVar('ttpl_class', Request::getInt('ttpl_class', 0));
        $ttplAmountin = Request::getString('ttpl_amountin');
        $tratemplatesObj->setVar('ttpl_amountin', Utility::StringToFloat($ttplAmountin));
        $ttplAmountout = Request::getString('ttpl_amountout');
        $tratemplatesObj->setVar('ttpl_amountout', Utility::StringToFloat($ttplAmountout));
        $tratemplatesObj->setVar('ttpl_online', Request::getInt('ttpl_online', 0));
        $ttemplateDatecreatedObj = \DateTime::createFromFormat(_SHORTDATESTRING, Request::getString('ttpl_datecreated'));
        $tratemplatesObj->setVar('ttpl_datecreated', $ttemplateDatecreatedObj->getTimestamp());
        $tratemplatesObj->setVar('ttpl_submitter', Request::getInt('ttpl_submitter', 0));
        // Insert Data
        if ($tratemplatesHandler->insert($tratemplatesObj)) {
            \redirect_header('tratemplates.php?op=list', 2, \_MA_WGSIMPLEACC_FORM_OK);
        }
        // Get Form
        $GLOBALS['xoopsTpl']->assign('error', $tratemplatesObj->getHtmlErrors());
        $form = $tratemplatesObj->getFormTratemplates();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'edit':
        $templateMain = 'wgsimpleacc_admin_tratemplates.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('tratemplates.php'));
        $GLOBALS['xoTheme']->addScript(WGSIMPLEACC_URL . '/assets/js/functions.js');
        $adminObject->addItemButton(\_AM_WGSIMPLEACC_ADD_TRATEMPLATE, 'tratemplates.php?op=new', 'add');
        $adminObject->addItemButton(\_AM_WGSIMPLEACC_LIST_TRATEMPLATES, 'tratemplates.php', 'list');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        // Get Form
        $tratemplatesObj = $tratemplatesHandler->get($tplId);
        $form = $tratemplatesObj->getFormTratemplates();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'delete':
        $templateMain = 'wgsimpleacc_admin_tratemplates.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('tratemplates.php'));
        $tratemplatesObj = $tratemplatesHandler->get($tplId);
        $tplName = $tratemplatesObj->getVar('ttpl_name');
        if (isset($_REQUEST['ok']) && 1 == $_REQUEST['ok']) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                \redirect_header('tratemplates.php', 3, \implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            if ($tratemplatesHandler->delete($tratemplatesObj)) {
                \redirect_header('tratemplates.php', 3, \_AM_WGSIMPLEACC_FORM_DELETE_OK);
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
        }
        break;
}
require __DIR__ . '/footer.php';
