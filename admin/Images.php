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
// Request img_id
$imgId = Request::getInt('img_id');
switch ($op) {
	case 'list':
	default:
		// Define Stylesheet
		$GLOBALS['xoTheme']->addStylesheet($style, null);
		$start = Request::getInt('start', 0);
		$limit = Request::getInt('limit', $helper->getConfig('adminpager'));
		$templateMain = 'wgsimpleacc_admin_images.tpl';
		$GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('images.php'));
		$adminObject->addItemButton(\_AM_WGSIMPLEACC_ADD_IMAGE, 'images.php?op=new', 'add');
		$GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
		$imagesCount = $imagesHandler->getCountImages();
		$imagesAll = $imagesHandler->getAllImages($start, $limit);
		$GLOBALS['xoopsTpl']->assign('images_count', $imagesCount);
		$GLOBALS['xoopsTpl']->assign('wgsimpleacc_url', WGSIMPLEACC_URL);
		$GLOBALS['xoopsTpl']->assign('wgsimpleacc_upload_url', WGSIMPLEACC_UPLOAD_URL);
		// Table view images
		if ($imagesCount > 0) {
			foreach (\array_keys($imagesAll) as $i) {
				$image = $imagesAll[$i]->getValuesImages();
				$GLOBALS['xoopsTpl']->append('images_list', $image);
				unset($image);
			}
			// Display Navigation
			if ($imagesCount > $limit) {
				include_once \XOOPS_ROOT_PATH . '/class/pagenav.php';
				$pagenav = new \XoopsPageNav($imagesCount, $limit, $start, 'start', 'op=list&limit=' . $limit);
				$GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
			}
		} else {
			$GLOBALS['xoopsTpl']->assign('error', \_AM_WGSIMPLEACC_THEREARENT_IMAGES);
		}
		break;
	case 'new':
		$templateMain = 'wgsimpleacc_admin_images.tpl';
		$GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('images.php'));
		$adminObject->addItemButton(\_AM_WGSIMPLEACC_IMAGES_LIST, 'images.php', 'list');
		$GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
		// Form Create
		$imagesObj = $imagesHandler->create();
		$form = $imagesObj->getFormImages();
		$GLOBALS['xoopsTpl']->assign('form', $form->render());
		break;
	case 'save':
		// Security Check
		if (!$GLOBALS['xoopsSecurity']->check()) {
			\redirect_header('images.php', 3, \implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
		}
		if ($imgId > 0) {
			$imagesObj = $imagesHandler->get($imgId);
		} else {
			$imagesObj = $imagesHandler->create();
		}
		// Set Vars
		$imagesObj->setVar('img_traid', Request::getInt('img_traid', 0));
		// Set Var img_name
		include_once \XOOPS_ROOT_PATH . '/class/uploader.php';
		$filename       = $_FILES['img_name']['name'];
		$imgMimetype    = $_FILES['img_name']['type'];
		$imgNameDef     = Request::getString('img_traid');
		$uploaderErrors = '';
		$uploader = new \XoopsMediaUploader(WGSIMPLEACC_UPLOAD_IMAGE_PATH . '/images/', 
													$helper->getConfig('mimetypes_image'), 
													$helper->getConfig('maxsize_image'), null, null);
		if ($uploader->fetchMedia($_POST['xoops_upload_file'][0])) {
			$extension = \preg_replace('/^.+\.([^.]+)$/sU', '', $filename);
			$imgName = \str_replace(' ', '', $imgNameDef) . '.' . $extension;
			$uploader->setPrefix($imgName);
			$uploader->fetchMedia($_POST['xoops_upload_file'][0]);
			if (!$uploader->upload()) {
				$uploaderErrors = $uploader->getErrors();
			} else {
				$savedFilename = $uploader->getSavedFileName();
				$maxwidth  = (int)$helper->getConfig('maxwidth_image');
				$maxheight = (int)$helper->getConfig('maxheight_image');
				if ($maxwidth > 0 && $maxheight > 0) {
					// Resize image
					$imgHandler                = new Wgsimpleacc\Common\Resizer();
					$imgHandler->sourceFile    = WGSIMPLEACC_UPLOAD_IMAGE_PATH . '/images/' . $savedFilename;
					$imgHandler->endFile       = WGSIMPLEACC_UPLOAD_IMAGE_PATH . '/images/' . $savedFilename;
					$imgHandler->imageMimetype = $imgMimetype;
					$imgHandler->maxWidth      = $maxwidth;
					$imgHandler->maxHeight     = $maxheight;
					$result                    = $imgHandler->resizeImage();
				}
				$imagesObj->setVar('img_name', $savedFilename);
			}
		} else {
			if ($filename > '') {
				$uploaderErrors = $uploader->getErrors();
			}
			$imagesObj->setVar('img_name', Request::getString('img_name'));
		}
		$imagesObj->setVar('img_type', Request::getInt('img_type', 0));
		$imagesObj->setVar('img_desc', Request::getString('img_desc', ''));
		$imagesObj->setVar('img_ip', Request::getString('img_ip', ''));
		$imageDatecreatedObj = \DateTime::createFromFormat(_SHORTDATESTRING, Request::getString('img_datecreated'));
		$imagesObj->setVar('img_datecreated', $imageDatecreatedObj->getTimestamp());
		$imagesObj->setVar('img_submitter', Request::getInt('img_submitter', 0));
		// Insert Data
		if ($imagesHandler->insert($imagesObj)) {
			if ('' !== $uploaderErrors) {
				\redirect_header('images.php?op=edit&img_id=' . $imgId, 5, $uploaderErrors);
			} else {
				\redirect_header('images.php?op=list', 2, \_AM_WGSIMPLEACC_FORM_OK);
			}
		}
		// Get Form
		$GLOBALS['xoopsTpl']->assign('error', $imagesObj->getHtmlErrors());
		$form = $imagesObj->getFormImages();
		$GLOBALS['xoopsTpl']->assign('form', $form->render());
		break;
	case 'edit':
		$templateMain = 'wgsimpleacc_admin_images.tpl';
		$GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('images.php'));
		$adminObject->addItemButton(\_AM_WGSIMPLEACC_ADD_IMAGE, 'images.php?op=new', 'add');
		$adminObject->addItemButton(\_AM_WGSIMPLEACC_IMAGES_LIST, 'images.php', 'list');
		$GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
		// Get Form
		$imagesObj = $imagesHandler->get($imgId);
		$form = $imagesObj->getFormImages();
		$GLOBALS['xoopsTpl']->assign('form', $form->render());
		break;
	case 'delete':
		$templateMain = 'wgsimpleacc_admin_images.tpl';
		$GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('images.php'));
		$imagesObj = $imagesHandler->get($imgId);
		$imgTraid = $imagesObj->getVar('img_traid');
		if (isset($_REQUEST['ok']) && 1 == $_REQUEST['ok']) {
			if (!$GLOBALS['xoopsSecurity']->check()) {
				\redirect_header('images.php', 3, \implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
			}
			if ($imagesHandler->delete($imagesObj)) {
				\redirect_header('images.php', 3, \_AM_WGSIMPLEACC_FORM_DELETE_OK);
			} else {
				$GLOBALS['xoopsTpl']->assign('error', $imagesObj->getHtmlErrors());
			}
		} else {
			$xoopsconfirm = new Common\XoopsConfirm(
				['ok' => 1, 'img_id' => $imgId, 'op' => 'delete'],
				$_SERVER['REQUEST_URI'],
				\sprintf(\_AM_WGSIMPLEACC_FORM_SURE_DELETE, $imagesObj->getVar('img_traid')));
			$form = $xoopsconfirm->getFormXoopsConfirm();
			$GLOBALS['xoopsTpl']->assign('form', $form->render());
		}
		break;
}
require __DIR__ . '/footer.php';
