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
$GLOBALS['xoopsOption']['template_main'] = 'wgsimpleacc_images.tpl';
include_once \XOOPS_ROOT_PATH . '/header.php';

$op    = Request::getCmd('op', 'list');
$start = Request::getInt('start', 0);
$limit = Request::getInt('limit', $helper->getConfig('userpager'));
$imgId = Request::getInt('img_id', 0);

// Define Stylesheet
$GLOBALS['xoTheme']->addStylesheet($style, null);

$GLOBALS['xoopsTpl']->assign('xoops_icons32_url', XOOPS_ICONS32_URL);
$GLOBALS['xoopsTpl']->assign('wgsimpleacc_url', WGSIMPLEACC_URL);

$keywords = [];

$GLOBALS['xoopsTpl']->assign('showItem', $imgId > 0);

switch ($op) {
	case 'show':
	case 'list':
	default:
		$crImages = new \CriteriaCompo();
		if ($imgId > 0) {
			$crImages->add(new \Criteria('img_id', $imgId));
		}
		$imagesCount = $imagesHandler->getCount($crImages);
		$GLOBALS['xoopsTpl']->assign('imagesCount', $imagesCount);
		$crImages->setStart($start);
		$crImages->setLimit($limit);
		$imagesAll = $imagesHandler->getAll($crImages);
		if ($imagesCount > 0) {
			$images = [];
			// Get All Images
			foreach (\array_keys($imagesAll) as $i) {
				$images[$i] = $imagesAll[$i]->getValuesImages();
				$keywords[$i] = $imagesAll[$i]->getVar('img_traid');
			}
			$GLOBALS['xoopsTpl']->assign('images', $images);
			unset($images);
			// Display Navigation
			if ($imagesCount > $limit) {
				include_once \XOOPS_ROOT_PATH . '/class/pagenav.php';
				$pagenav = new \XoopsPageNav($imagesCount, $limit, $start, 'start', 'op=list&limit=' . $limit);
				$GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
			}
			$GLOBALS['xoopsTpl']->assign('type', $helper->getConfig('table_type'));
			$GLOBALS['xoopsTpl']->assign('divideby', $helper->getConfig('divideby'));
			$GLOBALS['xoopsTpl']->assign('numb_col', $helper->getConfig('numb_col'));
		}
		break;
}

// Breadcrumbs
$xoBreadcrumbs[] = ['title' => \_MA_WGSIMPLEACC_IMAGES];

// Keywords
wgsimpleaccMetaKeywords($helper->getConfig('keywords') . ', ' . \implode(',', $keywords));
unset($keywords);

// Description
wgsimpleaccMetaDescription(\_MA_WGSIMPLEACC_IMAGES_DESC);
$GLOBALS['xoopsTpl']->assign('xoops_mpageurl', WGSIMPLEACC_URL.'/images.php');
$GLOBALS['xoopsTpl']->assign('wgsimpleacc_upload_url', WGSIMPLEACC_UPLOAD_URL);

require __DIR__ . '/footer.php';
