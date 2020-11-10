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
 * @author         XOOPS Development Team - Email:<webmaster@wedega.com> - Website:<https://xoops.wedega.com>
 */

use Xmf\Request;
use XoopsModules\Wgsimpleacc;
use XoopsModules\Wgsimpleacc\Constants;
use XoopsModules\Wgsimpleacc\Common;

require __DIR__ . '/header.php';
// It recovered the value of argument op in URL$
$op = Request::getCmd('op', 'list');
// Request cla_id
$claId = Request::getInt('cla_id');
switch ($op) {
	case 'list':
	default:
		// Define Stylesheet
		$GLOBALS['xoTheme']->addStylesheet($style, null);
		$start = Request::getInt('start', 0);
		$limit = Request::getInt('limit', $helper->getConfig('adminpager'));
		$templateMain = 'wgsimpleacc_admin_classifications.tpl';
		$GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('classifications.php'));
		$adminObject->addItemButton(\_AM_WGSIMPLEACC_ADD_CLASSIFICATION, 'classifications.php?op=new', 'add');
		$GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
		$classificationsCount = $classificationsHandler->getCountClassifications();
		$classificationsAll = $classificationsHandler->getAllClassifications($start, $limit);
		$GLOBALS['xoopsTpl']->assign('classifications_count', $classificationsCount);
		$GLOBALS['xoopsTpl']->assign('wgsimpleacc_url', WGSIMPLEACC_URL);
		$GLOBALS['xoopsTpl']->assign('wgsimpleacc_upload_url', WGSIMPLEACC_UPLOAD_URL);
		// Table view classifications
		if ($classificationsCount > 0) {
			foreach (\array_keys($classificationsAll) as $i) {
				$classification = $classificationsAll[$i]->getValuesClassifications();
				$GLOBALS['xoopsTpl']->append('classifications_list', $classification);
				unset($classification);
			}
			// Display Navigation
			if ($classificationsCount > $limit) {
				include_once \XOOPS_ROOT_PATH . '/class/pagenav.php';
				$pagenav = new \XoopsPageNav($classificationsCount, $limit, $start, 'start', 'op=list&limit=' . $limit);
				$GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
			}
		} else {
			$GLOBALS['xoopsTpl']->assign('error', \_AM_WGSIMPLEACC_THEREARENT_CLASSIFICATIONS);
		}
		break;
	case 'new':
		$templateMain = 'wgsimpleacc_admin_classifications.tpl';
		$GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('classifications.php'));
		$adminObject->addItemButton(\_AM_WGSIMPLEACC_CLASSIFICATIONS_LIST, 'classifications.php', 'list');
		$GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
		// Form Create
		$classificationsObj = $classificationsHandler->create();
		$form = $classificationsObj->getFormClassifications();
		$GLOBALS['xoopsTpl']->assign('form', $form->render());
		break;
	case 'save':
		// Security Check
		if (!$GLOBALS['xoopsSecurity']->check()) {
			\redirect_header('classifications.php', 3, \implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
		}
		if ($claId > 0) {
			$classificationsObj = $classificationsHandler->get($claId);
		} else {
			$classificationsObj = $classificationsHandler->create();
		}
		// Set Vars
		$classificationsObj->setVar('cla_pid', Request::getInt('cla_pid', 0));
		$classificationsObj->setVar('cla_name', Request::getString('cla_name', ''));
		$classificationDatecreatedObj = \DateTime::createFromFormat(_SHORTDATESTRING, Request::getString('cla_datecreated'));
		$classificationsObj->setVar('cla_datecreated', $classificationDatecreatedObj->getTimestamp());
		$classificationsObj->setVar('cla_submitter', Request::getInt('cla_submitter', 0));
		$classificationsObj->setVar('cla_status', Request::getInt('cla_status', 0));
		// Insert Data
		if ($classificationsHandler->insert($classificationsObj)) {
			\redirect_header('classifications.php?op=list', 2, \_AM_WGSIMPLEACC_FORM_OK);
		}
		// Get Form
		$GLOBALS['xoopsTpl']->assign('error', $classificationsObj->getHtmlErrors());
		$form = $classificationsObj->getFormClassifications();
		$GLOBALS['xoopsTpl']->assign('form', $form->render());
		break;
	case 'edit':
		$templateMain = 'wgsimpleacc_admin_classifications.tpl';
		$GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('classifications.php'));
		$adminObject->addItemButton(\_AM_WGSIMPLEACC_ADD_CLASSIFICATION, 'classifications.php?op=new', 'add');
		$adminObject->addItemButton(\_AM_WGSIMPLEACC_CLASSIFICATIONS_LIST, 'classifications.php', 'list');
		$GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
		// Get Form
		$classificationsObj = $classificationsHandler->get($claId);
		$form = $classificationsObj->getFormClassifications();
		$GLOBALS['xoopsTpl']->assign('form', $form->render());
		break;
	case 'delete':
		$templateMain = 'wgsimpleacc_admin_classifications.tpl';
		$GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('classifications.php'));
		$classificationsObj = $classificationsHandler->get($claId);
		$claName = $classificationsObj->getVar('cla_name');
		if (isset($_REQUEST['ok']) && 1 == $_REQUEST['ok']) {
			if (!$GLOBALS['xoopsSecurity']->check()) {
				\redirect_header('classifications.php', 3, \implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
			}
			if ($classificationsHandler->delete($classificationsObj)) {
				\redirect_header('classifications.php', 3, \_AM_WGSIMPLEACC_FORM_DELETE_OK);
			} else {
				$GLOBALS['xoopsTpl']->assign('error', $classificationsObj->getHtmlErrors());
			}
		} else {
			$xoopsconfirm = new Common\XoopsConfirm(
				['ok' => 1, 'cla_id' => $claId, 'op' => 'delete'],
				$_SERVER['REQUEST_URI'],
				\sprintf(\_AM_WGSIMPLEACC_FORM_SURE_DELETE, $classificationsObj->getVar('cla_name')));
			$form = $xoopsconfirm->getFormXoopsConfirm();
			$GLOBALS['xoopsTpl']->assign('form', $form->render());
		}
		break;
}
require __DIR__ . '/footer.php';
