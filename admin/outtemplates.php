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
use XoopsModules\Wgsimpleacc\Constants;
use XoopsModules\Wgsimpleacc\Common;

require __DIR__ . '/header.php';
// It recovered the value of argument op in URL$
$op = Request::getCmd('op', 'list');
// Request otpl_id
$otplId = Request::getInt('otpl_id');
switch ($op) {
    case 'list':
    default:
        // Define Stylesheet
        $GLOBALS['xoTheme']->addStylesheet($style, null);
        $start = Request::getInt('start', 0);
        $limit = Request::getInt('limit', $helper->getConfig('adminpager'));
        $templateMain = 'wgsimpleacc_admin_outtemplates.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('outtemplates.php'));
        $adminObject->addItemButton(\_AM_WGSIMPLEACC_ADD_OUTTEMPLATE, 'outtemplates.php?op=new', 'add');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        $outtemplatesCount = $outtemplatesHandler->getCountOuttemplates();
        $outtemplatesAll = $outtemplatesHandler->getAllOuttemplates($start, $limit);
        $GLOBALS['xoopsTpl']->assign('outtemplates_count', $outtemplatesCount);
        $GLOBALS['xoopsTpl']->assign('wgsimpleacc_url', \WGSIMPLEACC_URL);
        $GLOBALS['xoopsTpl']->assign('wgsimpleacc_upload_url', \WGSIMPLEACC_UPLOAD_URL);
        // Table view outtemplates
        if ($outtemplatesCount > 0) {
            foreach (\array_keys($outtemplatesAll) as $i) {
                $outtemplate = $outtemplatesAll[$i]->getValuesOuttemplates();
                $GLOBALS['xoopsTpl']->append('outtemplates_list', $outtemplate);
                unset($outtemplate);
            }
            // Display Navigation
            if ($outtemplatesCount > $limit) {
                include_once \XOOPS_ROOT_PATH . '/class/pagenav.php';
                $pagenav = new \XoopsPageNav($outtemplatesCount, $limit, $start, 'start', 'op=list&limit=' . $limit);
                $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
            }
        } else {
            $GLOBALS['xoopsTpl']->assign('error', \_MA_WGSIMPLEACC_THEREARENT_OUTTEMPLATES);
        }
        break;
    case 'new':
    case 'clone':
        $templateMain = 'wgsimpleacc_admin_outtemplates.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('outtemplates.php'));
        $adminObject->addItemButton(\_AM_WGSIMPLEACC_LIST_OUTTEMPLATES, 'outtemplates.php', 'list');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        // Form Create
        $outtemplatesObj = $outtemplatesHandler->create();
        if ('clone' === $op) {
            $otplId = Request::getInt('otpl_id_clone');
            $outtemplatesObjOld = $outtemplatesHandler->get($otplId);
            foreach ($outtemplatesObjOld->vars as $k => $v) {
                if ('otpl_id' !== $k) {
                    $outtemplatesObj->setVar($k, $v['value']);
                }
            }
            unset($outtemplatesObjOld);
        }
        $form = $outtemplatesObj->getFormOuttemplates();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'save':
        // Security Check
        if (!$GLOBALS['xoopsSecurity']->check()) {
            \redirect_header('outtemplates.php', 3, \implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        if ($otplId > 0) {
            $outtemplatesObj = $outtemplatesHandler->get($otplId);
        } else {
            $outtemplatesObj = $outtemplatesHandler->create();
        }
        // Set Vars
        $outtemplatesObj->setVar('otpl_name', Request::getString('otpl_name', ''));
        $outtemplatesObj->setVar('otpl_type', Request::getInt('otpl_type', 0));
        $outtemplatesObj->setVar('otpl_header', Request::getText('otpl_header', ''));
        $outtemplatesObj->setVar('otpl_body', Request::getText('otpl_body', ''));
        $outtemplatesObj->setVar('otpl_footer', Request::getText('otpl_footer', ''));
        $arrAllid = Request::getArray('otpl_allid');
        if (0 == (int)$arrAllid[0]) {
            $otpl_allid = serialize([0]);
        } else {
            $otpl_allid = serialize($arrAllid);
        }
        $outtemplatesObj->setVar('otpl_allid', $otpl_allid);
        $arrAccid = Request::getArray('otpl_accid');
        if (0 == (int)$arrAccid[0]) {
            $otpl_accid = serialize([0]);
        } else {
            $otpl_accid = serialize($arrAccid);
        }
        $outtemplatesObj->setVar('otpl_accid', $otpl_accid);
        $outtemplatesObj->setVar('otpl_online', Request::getInt('otpl_online', 0));
        $outtemplateDatecreatedObj = \DateTime::createFromFormat(_SHORTDATESTRING, Request::getString('otpl_datecreated'));
        $outtemplatesObj->setVar('otpl_datecreated', $outtemplateDatecreatedObj->getTimestamp());
        $outtemplatesObj->setVar('otpl_submitter', Request::getInt('otpl_submitter', 0));
        // Insert Data
        if ($outtemplatesHandler->insert($outtemplatesObj)) {
            \redirect_header('outtemplates.php?op=list', 2, \_MA_WGSIMPLEACC_FORM_OK);
        }
        // Get Form
        $GLOBALS['xoopsTpl']->assign('error', $outtemplatesObj->getHtmlErrors());
        $form = $outtemplatesObj->getFormOuttemplates();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'edit':
        $templateMain = 'wgsimpleacc_admin_outtemplates.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('outtemplates.php'));
        $adminObject->addItemButton(\_AM_WGSIMPLEACC_ADD_OUTTEMPLATE, 'outtemplates.php?op=new', 'add');
        $adminObject->addItemButton(\_AM_WGSIMPLEACC_LIST_OUTTEMPLATES, 'outtemplates.php', 'list');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        // Get Form
        $outtemplatesObj = $outtemplatesHandler->get($otplId);
        $form = $outtemplatesObj->getFormOuttemplates();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'delete':
        $templateMain = 'wgsimpleacc_admin_outtemplates.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('outtemplates.php'));
        $outtemplatesObj = $outtemplatesHandler->get($otplId);
        $otplName = $outtemplatesObj->getVar('otpl_name');
        if (isset($_REQUEST['ok']) && 1 == $_REQUEST['ok']) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                \redirect_header('outtemplates.php', 3, \implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            if ($outtemplatesHandler->delete($outtemplatesObj)) {
                \redirect_header('outtemplates.php', 3, \_AM_WGSIMPLEACC_FORM_DELETE_OK);
            } else {
                $GLOBALS['xoopsTpl']->assign('error', $outtemplatesObj->getHtmlErrors());
            }
        } else {
            $xoopsconfirm = new Common\XoopsConfirm(
                ['ok' => 1, 'otpl_id' => $otplId, 'op' => 'delete'],
                $_SERVER['REQUEST_URI'],
                \sprintf(\_MA_WGSIMPLEACC_FORM_SURE_DELETE, $outtemplatesObj->getVar('otpl_name')));
            $form = $xoopsconfirm->getFormXoopsConfirm();
            $GLOBALS['xoopsTpl']->assign('form', $form->render());
        }
        break;
}
require __DIR__ . '/footer.php';
