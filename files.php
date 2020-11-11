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
use XoopsModules\Wgsimpleacc\{
    Constants,
    Common
};

require __DIR__ . '/header.php';
$GLOBALS['xoopsOption']['template_main'] = 'wgsimpleacc_main_startmin.tpl';
require_once \XOOPS_ROOT_PATH . '/header.php';
$GLOBALS['xoopsTpl']->assign('template_sub', 'db:wgsimpleacc_files.tpl');
require __DIR__ . '/navbar.php';

// Permissions
if (!$permissionsHandler->getPermGlobalView()) {
    $GLOBALS['xoopsTpl']->assign('error', _NOPERM);
    require __DIR__ . '/footer.php';
}

$op    = Request::getCmd('op', 'list');
$start = Request::getInt('start', 0);
$limit = Request::getInt('limit', $helper->getConfig('userpager'));
$filId = Request::getInt('fil_id', 0);
$filTraid = Request::getInt('fil_traid', 0);
$uploadByApp = $helper->getConfig('upload_by_app');

// Define Stylesheet
$GLOBALS['xoTheme']->addStylesheet($style, null);

$GLOBALS['xoopsTpl']->assign('xoops_icons32_url', XOOPS_ICONS32_URL);
$GLOBALS['xoopsTpl']->assign('wgsimpleacc_url', WGSIMPLEACC_URL);
$GLOBALS['xoopsTpl']->assign('wgsimpleacc_upload_files_url', WGSIMPLEACC_UPLOAD_FILES_URL);

$keywords = [];

$GLOBALS['xoopsTpl']->assign('upload_by_app', $uploadByApp);
$GLOBALS['xoopsTpl']->assign('start', $start);
$GLOBALS['xoopsTpl']->assign('limit', $limit);
$GLOBALS['xoopsTpl']->assign('fil_traid', $filTraid);


switch ($op) {
	case 'show':
	case 'list':
	default:
	    if ($filTraid > 0) {
            $transactionsObj = $transactionsHandler->get($filTraid);
            $title = $transactionsObj->getVar('tra_year') . '/' . $transactionsObj->getVar('tra_nb') . ' ' . $transactionsObj->getVar('tra_desc');
            $GLOBALS['xoopsTpl']->assign('header_fileslist', \str_replace('%t', $title, \_MA_WGSIMPLEACC_FILES_LISTHEADER));
        }
	    $crFiles = new \CriteriaCompo();
		if ($filId > 0) {
            $GLOBALS['xoopsTpl']->assign('template_sub', 'db:wgsimpleacc_files_item.tpl');
			$crFiles->add(new \Criteria('fil_id', $filId));
		}
        $crFiles->add(new \Criteria('fil_traid', $filTraid));
		$filesCount = $filesHandler->getCount($crFiles);
		$GLOBALS['xoopsTpl']->assign('filesCount', $filesCount);
		$crFiles->setStart($start);
		$crFiles->setLimit($limit);
		$filesAll = $filesHandler->getAll($crFiles);
		if ($filesCount > 0) {
			$files = [];
			// Get All Files
			foreach (\array_keys($filesAll) as $i) {
				$files[$i] = $filesAll[$i]->getValuesFiles();
				$keywords[$i] = $filesAll[$i]->getVar('fil_name');
			}
			$GLOBALS['xoopsTpl']->assign('files', $files);
			unset($files);
		}
        // Check permissions
        if ($permissionsHandler->getPermTransactionsSubmit()) {
            // Form upload files
            $filesObj = $filesHandler->create();
            $formFiles = $filesObj->getFormFiles($filTraid);
            $GLOBALS['xoopsTpl']->assign('formFilesUpload', $formFiles->render());

            if ($uploadByApp) {
                $filesObj = $filesHandler->create();
                $formFilesTemp = $filesObj->getFormTemp($filTraid);
                $GLOBALS['xoopsTpl']->assign('formFilesTemp', $formFilesTemp->render());
            }
        }
		break;
    case 'save_edit':
        // Security Check
        if (!$GLOBALS['xoopsSecurity']->check()) {
            \redirect_header('files.php', 3, \implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        // Check permissions
        if (!$permissionsHandler->getPermTransactionsSubmit()) {
            \redirect_header('files.php?op=list', 3, _NOPERM);
        }
        if ($filId > 0) {
            $filesObj = $filesHandler->get($filId);
        } else {
            \redirect_header('files.php?op=list', 3, \_MA_WGSIMPLEACC_INVALID_PARAM);
        }
        $filesObj->setVar('fil_desc', Request::getString('fil_desc', ''));
        $filesObj->setVar('fil_ip', $_SERVER['REMOTE_ADDR']);
        $filesObj->setVar('fil_datecreated', \time());
        $filesObj->setVar('fil_submitter', $GLOBALS['xoopsUser']->id());
        // Insert Data
        if ($filesHandler->insert($filesObj)) {
            \redirect_header('files.php?op=list&amp;fil_traid=' . $filesObj->getVar('fil_traid'), 2, \_MA_WGSIMPLEACC_FORM_OK);
        }
        // Get Form Error
        $GLOBALS['xoopsTpl']->assign('error', $filesObj->getHtmlErrors());
        $formFiles = $filesObj->getFormFilesEdit($filTraid);
        $GLOBALS['xoopsTpl']->assign('formFilesEdit', $formFiles->render());
        break;
	case 'upload_file':
    case 'save_temp':
		// Security Check
		if (!$GLOBALS['xoopsSecurity']->check()) {
			\redirect_header('files.php', 3, \implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
		}
		// Check permissions
		if (!$permissionsHandler->getPermTransactionsSubmit()) {
            \redirect_header('files.php?op=list', 3, _NOPERM);
		}
		if ($filId > 0) {
			$filesObj = $filesHandler->get($filId);
		} else {
			$filesObj = $filesHandler->create();
		}
		$filesObj->setVar('fil_traid', $filTraid);
        // Set Var fil_name
        $uploaderErrors = '';
		if ('upload_file' == $op) {
            require_once \XOOPS_ROOT_PATH . '/class/uploader.php';
            $filename    = $_FILES['fil_name']['name'];
            $imgMimetype = $_FILES['fil_name']['type'];
            /*
            if (!\file_exists($_FILES['fil_name']['tmp_name'])) {
                // Get Form Error
                $GLOBALS['xoopsTpl']->assign('error', \_MA_WGSIMPLEACC_FILES_UPLOAD_ERROR);
                $formFiles = $filesObj->getFormFiles($filTraid);
                $GLOBALS['xoopsTpl']->assign('formFiles', $formFiles->render());
                if ($uploadByApp) {
                    $filesObj = $filesHandler->create();
                    $formFilesTemp = $filesObj->getFormTemp($filTraid);
                    $GLOBALS['xoopsTpl']->assign('formFilesTemp', $formFilesTemp->render());
                }
                break;
            }*/
            $uploader = new \XoopsMediaUploader(WGSIMPLEACC_UPLOAD_FILES_PATH . '/',
                $helper->getConfig('mimetypes_file'),
                $helper->getConfig('maxsize_file'), null, null);
            if ($uploader->fetchMedia($_POST['xoops_upload_file'][0])) {
                $extension = \preg_replace('/^.+\.([^.]+)$/sU', '', $filename);
                $imgName = \str_replace(' ', '', $filename) . '.' . $extension;
                $uploader->setPrefix($imgName);
                $uploader->fetchMedia($_POST['xoops_upload_file'][0]);
                if (!$uploader->upload()) {
                    $errors = $uploader->getErrors();
                } else {
                    $savedFilename = $uploader->getSavedFileName();
                    $maxwidth  = (int)$helper->getConfig('maxwidth_image');
                    $maxheight = (int)$helper->getConfig('maxheight_image');
                    if ($maxwidth > 0 && $maxheight > 0) {
                        // Resize image
                        $imgHandler                = new Wgsimpleacc\Common\Resizer();
                        $imgHandler->sourceFile    = WGSIMPLEACC_UPLOAD_FILES_PATH . '/' . $savedFilename;
                        $imgHandler->endFile       = WGSIMPLEACC_UPLOAD_FILES_PATH . '/' . $savedFilename;
                        $imgHandler->imageMimetype = $imgMimetype;
                        $imgHandler->maxWidth      = $maxwidth;
                        $imgHandler->maxHeight     = $maxheight;
                        $result                    = $imgHandler->resizeImage();
                    }
                    $filesObj->setVar('fil_name', $savedFilename);
                    $filName = $savedFilename;
                }
            } else {
                if ($filename > '') {
                    $uploaderErrors = $uploader->getErrors();
                }
                $filName =  Request::getString('fil_name');
                $filesObj->setVar('fil_name', $filName);
            }
        } else {
            $filName = Request::getString('fil_temp', '');
            $filSource = \XOOPS_ROOT_PATH . '/uploads/wgsimpleacc/temp/' . $filName;
            $filDest = \XOOPS_ROOT_PATH . '/uploads/wgsimpleacc/files/' . $filName;
            \rename($filSource, $filDest);
            $filesObj->setVar('fil_name', $filName);
        }
        $filePath = \XOOPS_ROOT_PATH . '/uploads/wgsimpleacc/files/' . $filName;
        $fileMimetype   = \mime_content_type($filePath);
        $filesObj->setVar('fil_type', $fileMimetype);
		$filesObj->setVar('fil_desc', Request::getString('fil_desc', ''));
		$filesObj->setVar('fil_ip', $_SERVER['REMOTE_ADDR']);
		$filesObj->setVar('fil_datecreated', \time());
		$filesObj->setVar('fil_submitter', $GLOBALS['xoopsUser']->id());
		// Insert Data
		if ($filesHandler->insert($filesObj)) {
			$newFilId = $filId > 0 ? $filId : $filesObj->getNewInsertedIdFiles();
			// redirect after insert
			if ('' !== $uploaderErrors) {
				\redirect_header('files.php?op=edit&fil_id=' . $newFilId, 5, $uploaderErrors);
			} else {
				\redirect_header('transactions.php?op=list', 2, \_MA_WGSIMPLEACC_FORM_OK);
			}
		}
		// Get Form Error
		$GLOBALS['xoopsTpl']->assign('error', $filesObj->getHtmlErrors());
        $formFiles = $filesObj->getFormFiles($filTraid);
        $GLOBALS['xoopsTpl']->assign('formFiles', $formFiles->render());
        if ($uploadByApp) {
            $filesObj = $filesHandler->create();
            $formFilesTemp = $filesObj->getFormTemp($filTraid);
            $GLOBALS['xoopsTpl']->assign('formFilesTemp', $formFilesTemp->render());
        }
		break;
	/*
	case 'new':
		// Check permissions
		if (!$permissionsHandler->getPermGlobalSubmit()) {
			\redirect_header('files.php?op=list', 3, _NOPERM);
		}
		// Form Create
		$filesObj = $filesHandler->create();
		$form = $filesObj->getFormFiles();
		$GLOBALS['xoopsTpl']->assign('form', $form->render());
		break;
	*/
	case 'edit':
		// Check permissions
		if (!$permissionsHandler->getPermTransactionsSubmit()) {
			\redirect_header('files.php?op=list', 3, _NOPERM);
		}
		// Check params
		if (0 == $filId) {
			\redirect_header('files.php?op=list', 3, \_MA_WGSIMPLEACC_INVALID_PARAM);
		}
		// Get Form
		$filesObj = $filesHandler->get($filId);
		$form = $filesObj->getFormFilesEdit();
		$GLOBALS['xoopsTpl']->assign('formFilesEdit', $form->render());
		break;

	case 'delete':
		// Check params
		if (0 == $filId) {
			\redirect_header('files.php?op=list', 3, \_MA_WGSIMPLEACC_INVALID_PARAM);
		}
		$filesObj = $filesHandler->get($filId);
        // Check permissions
        if (!$permissionsHandler->getPermFilesEdit($filesObj->getVar('fil_submitter'))) {
            \redirect_header('files.php?op=list', 3, _NOPERM);
        }
		$filName = $filesObj->getVar('fil_name');
		if (isset($_REQUEST['ok']) && 1 == $_REQUEST['ok']) {
			if (!$GLOBALS['xoopsSecurity']->check()) {
				\redirect_header('files.php', 3, \implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
			}
			if ($filesHandler->delete($filesObj)) {
				\redirect_header('files.php', 3, \_MA_WGSIMPLEACC_FORM_DELETE_OK);
			} else {
				$GLOBALS['xoopsTpl']->assign('error', $filesObj->getHtmlErrors());
			}
		} else {
			$xoopsconfirm = new Common\XoopsConfirm(
				['ok' => 1, 'fil_id' => $filId, 'op' => 'delete'],
				$_SERVER['REQUEST_URI'],
				\sprintf(\_MA_WGSIMPLEACC_FORM_SURE_DELETE, $filesObj->getVar('fil_name')));
			$form = $xoopsconfirm->getFormXoopsConfirm();
			$GLOBALS['xoopsTpl']->assign('form', $form->render());
		}
		break;
}

// Breadcrumbs
$xoBreadcrumbs[] = ['title' => \_MA_WGSIMPLEACC_FILES];

// Keywords
wgsimpleaccMetaKeywords($helper->getConfig('keywords') . ', ' . \implode(',', $keywords));
unset($keywords);

// Description
wgsimpleaccMetaDescription(\_MA_WGSIMPLEACC_FILES_DESC);
$GLOBALS['xoopsTpl']->assign('xoops_mpageurl', WGSIMPLEACC_URL.'/files.php');
$GLOBALS['xoopsTpl']->assign('wgsimpleacc_upload_url', WGSIMPLEACC_UPLOAD_URL);

require __DIR__ . '/footer.php';
