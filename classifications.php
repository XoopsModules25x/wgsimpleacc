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
$GLOBALS['xoopsOption']['template_main'] = 'wgsimpleacc_classifications.tpl';
include_once \XOOPS_ROOT_PATH . '/header.php';

$op    = Request::getCmd('op', 'list');
$start = Request::getInt('start', 0);
$limit = Request::getInt('limit', $helper->getConfig('userpager'));
$claId = Request::getInt('cla_id', 0);

// Define Stylesheet
$GLOBALS['xoTheme']->addStylesheet($style, null);

$GLOBALS['xoopsTpl']->assign('xoops_icons32_url', XOOPS_ICONS32_URL);
$GLOBALS['xoopsTpl']->assign('wgsimpleacc_url', WGSIMPLEACC_URL);

$keywords = [];

$GLOBALS['xoopsTpl']->assign('showItem', $claId > 0);

switch ($op) {
	case 'show':
	case 'list':
	default:
		$crClassifications = new \CriteriaCompo();
		if ($claId > 0) {
			$crClassifications->add(new \Criteria('cla_id', $claId));
		}
		$classificationsCount = $classificationsHandler->getCount($crClassifications);
		$GLOBALS['xoopsTpl']->assign('classificationsCount', $classificationsCount);
		$crClassifications->setStart($start);
		$crClassifications->setLimit($limit);
		$classificationsAll = $classificationsHandler->getAll($crClassifications);
		if ($classificationsCount > 0) {
			$classifications = [];
			// Get All Classifications
			foreach (\array_keys($classificationsAll) as $i) {
				$classifications[$i] = $classificationsAll[$i]->getValuesClassifications();
				$keywords[$i] = $classificationsAll[$i]->getVar('cla_name');
			}
			$GLOBALS['xoopsTpl']->assign('classifications', $classifications);
			unset($classifications);
			// Display Navigation
			if ($classificationsCount > $limit) {
				include_once \XOOPS_ROOT_PATH . '/class/pagenav.php';
				$pagenav = new \XoopsPageNav($classificationsCount, $limit, $start, 'start', 'op=list&limit=' . $limit);
				$GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
			}
			$GLOBALS['xoopsTpl']->assign('type', $helper->getConfig('table_type'));
			$GLOBALS['xoopsTpl']->assign('divideby', $helper->getConfig('divideby'));
			$GLOBALS['xoopsTpl']->assign('numb_col', $helper->getConfig('numb_col'));
		}
		break;
}

// Breadcrumbs
$xoBreadcrumbs[] = ['title' => \_MA_WGSIMPLEACC_CLASSIFICATIONS];

// Keywords
wgsimpleaccMetaKeywords($helper->getConfig('keywords') . ', ' . \implode(',', $keywords));
unset($keywords);

// Description
wgsimpleaccMetaDescription(\_MA_WGSIMPLEACC_CLASSIFICATIONS_DESC);
$GLOBALS['xoopsTpl']->assign('xoops_mpageurl', WGSIMPLEACC_URL.'/classifications.php');
$GLOBALS['xoopsTpl']->assign('wgsimpleacc_upload_url', WGSIMPLEACC_UPLOAD_URL);

require __DIR__ . '/footer.php';
