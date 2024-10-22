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
    Common
};

require __DIR__ . '/header.php';
require_once \XOOPS_ROOT_PATH . '/header.php';
$GLOBALS['xoopsTpl']->assign('template_sub', 'db:wgsimpleacc_files.tpl');

foreach ($styles as $style) {
    $GLOBALS['xoTheme']->addStylesheet($style, null);
}

// Permissions
if (!$permissionsHandler->getPermFilesView()) {
    \redirect_header('index.php', 0);
}

/* params from files.php */
$op            = Request::getCmd('op', 'list');
$deleteFiltemp = Request::getString('delete_filtemp');
$start         = Request::getInt('start');
$limit         = Request::getInt('limit', $helper->getConfig('userpager'));
$filId         = Request::getInt('fil_id');
$filTraid      = Request::getInt('fil_traid');
if ('save_temp' == $op && '' != $deleteFiltemp) {
    $op = 'delete_filtemp';
}
/* params from transactions.php */
$traOp = Request::getString('traOp');
if ('' === $traOp) {
    $traId           = Request::getInt('tra_id');
    $traType         = Request::getInt('tra_type');
    $allId           = Request::getInt('all_id');
    $allSubs         = Request::getInt('allSubs');
    $accId           = Request::getInt('acc_id');
    $asId            = Request::getInt('as_id');
    $cliId           = Request::getInt('cli_id');
    $displayfilter   = Request::getInt('displayfilter');
    $filterYear      = Request::getInt('filterYear');
    $filterMonthFrom = Request::getInt('filterMonthFrom');
    $filterYearFrom  = Request::getInt('filterYearFrom');
    $filterMonthTo   = Request::getInt('filterMonthTo');
    $filterYearTo    = Request::getInt('filterYearTo', date('Y'));
    $filterInvalid   = Request::getInt('filterInvalid');
    $traStatus       = Request::getArray('tra_status');
    $traDesc         = Request::getString('tra_desc');
    $sortBy          = Request::getString('sortby', 'tra_id');
    $order           = Request::getString('order', 'desc');

    $traOp = '&amp;start=' . $start . '&amp;limit=' . $limit . '&amp;all_id=' . $allId . '&amp;acc_id=' . $accId . '&amp;as_id=' . $asId;
    $traOp .= '&amp;filterYear=' . $filterYear . '&amp;filterMonthFrom=' . $filterMonthFrom . '&amp;filterYearFrom=' . $filterYearFrom . '&amp;filterMonthTo=' . $filterMonthTo . '&amp;filterYearTo=' . $filterYearTo;
    $traOp .= '&amp;displayfilter=' . $displayfilter . '&amp;allSubs=' . $allSubs . '&amp;filterInvalid=' . $filterInvalid;
    $traOp .= '&amp;cli_id=' . $cliId . '&amp;tra_type=' . $traType;
    $GLOBALS['xoopsTpl']->assign('traOp', $traOp);
}

$uploadByApp = $helper->getConfig('upload_by_app');

$GLOBALS['xoopsTpl']->assign('wgsimpleacc_upload_files_url', \WGSIMPLEACC_UPLOAD_FILES_URL);
$GLOBALS['xoopsTpl']->assign('upload_by_app', $uploadByApp);
$GLOBALS['xoopsTpl']->assign('start', $start);
$GLOBALS['xoopsTpl']->assign('limit', $limit);
$GLOBALS['xoopsTpl']->assign('fil_traid', $filTraid);

$keywords = [];

switch ($op) {
    case 'showfile':
        $filesObj = $filesHandler->get($filId);
        $filName = $filesObj->getVar('fil_name');
        $filePath = \XOOPS_ROOT_PATH . '/uploads/wgsimpleacc/files/' . $filName;
        $fileMimetype   = $filesObj->getVar('fil_type');

        switch ($fileMimetype) {
            case '':
            default:
                //zip, csv, txt, xlsx, docx
                header("Content-Type: $fileMimetype");
                header('Content-Disposition: attachment; filename="' . $filName . '"');
                $result = @readfile($filePath);
                if ($result === FALSE) {
                    throw new Exception('Cannot access ' . $filePath .' to read.');
                }
                exit;
            case 'application/pdf':
                // Header content type
                header('Content-type: application/pdf');
                header('Content-Disposition: inline; filename="' . $filName . '"');
                header('Content-Transfer-Encoding: binary');
                header('Accept-Ranges: bytes');
                // Read the file
                $result = @readfile($filePath);
                if ($result === FALSE) {
                    throw new Exception("Cannot access '$filePath' to read.");
                }
                exit;
        }
    case 'filedir_new':
        // Check permissions
        if (!$permissionsHandler->getPermFileDirSubmit()) {
            \redirect_header('index.php', 3, \_NOPERM);
        }
        // Get Form
        $filesObj = $filesHandler->create();
        $form = $filesObj->getFormFiles(0);
        $GLOBALS['xoopsTpl']->assign('formFilesDir', $form->render());
        $GLOBALS['xoopsTpl']->assign('header_fileslist', \_MA_WGSIMPLEACC_FILES_UPLOAD);
        break;
    case 'filedir_edit':
        // Check permissions
        if (!$permissionsHandler->getPermFileDirSubmit()) {
            \redirect_header('index.php', 3, \_NOPERM);
        }
        // Check params
        if (0 == $filId && 'filedir_edit' === $op) {
            \redirect_header('index.php', 3, \_MA_WGSIMPLEACC_INVALID_PARAM);
        }
        // Get Form
        $filesObj = $filesHandler->get($filId);
        $form = $filesObj->getFormFilesEdit();
        $GLOBALS['xoopsTpl']->assign('formFilesDir', $form->render());
        break;
    case 'filedir_list':
        $GLOBALS['xoopsTpl']->assign('filedir', true);
        $GLOBALS['xoopsTpl']->assign('header_fileslist', \_MA_WGSIMPLEACC_FILES_LIST_FILEDIR);
        $crFiles = new \CriteriaCompo();
        $crFiles->add(new \Criteria('fil_traid', 0));
        $filesCount = $filesHandler->getCount($crFiles);
        $GLOBALS['xoopsTpl']->assign('filedirCount', $filesCount);
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
        break;
    case 'show':
        if ($filTraid > 0) {
            $transactionsObj = $transactionsHandler->get($filTraid);
            $title = $transactionsObj->getVar('tra_year') . '/' . $transactionsObj->getVar('tra_nb') . ' ' . $transactionsObj->getVar('tra_desc');
            $GLOBALS['xoopsTpl']->assign('header_fileslist', \str_replace('%t', $title, \_MA_WGSIMPLEACC_FILES_LISTHEADER));
        } else {
            $GLOBALS['xoopsTpl']->assign('header_fileslist', 'xxxx');
        }
        $crFiles = new \CriteriaCompo();
        if ($filId > 0) {
            $GLOBALS['xoopsTpl']->assign('template_sub', 'db:wgsimpleacc_files_item.tpl');
            $crFiles->add(new \Criteria('fil_id', $filId));
        } else {
            break;
        }
        $crFiles->add(new \Criteria('fil_traid', $filTraid));
        $filesCount = $filesHandler->getCount($crFiles);
        $GLOBALS['xoopsTpl']->assign('filesCount', $filesCount);
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
        break;
    case 'list':
    case 'show_uploadform':
    default:
        // show be only called if upload form for a transaction should be shown
        if ($filTraid > 0) {
            $transactionsObj = $transactionsHandler->get($filTraid);
            $title = $transactionsObj->getVar('tra_year') . '/' . $transactionsObj->getVar('tra_nb') . ' ' . $transactionsObj->getVar('tra_desc');
            $GLOBALS['xoopsTpl']->assign('header_fileslist', \str_replace('%t', $title, \_MA_WGSIMPLEACC_FILES_LISTHEADER));
        } else {
            break;
        }
        $crFiles = new \CriteriaCompo();
        $crFiles->add(new \Criteria('fil_traid', $filTraid));
        $filesCount = $filesHandler->getCount($crFiles);
        $GLOBALS['xoopsTpl']->assign('filesCount', $filesCount);
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
            $formFiles = $filesObj->getFormFiles($filTraid, $traOp);
            $GLOBALS['xoopsTpl']->assign('formFilesUpload', $formFiles->render());

            if ($uploadByApp) {
                $filesObj = $filesHandler->create();
                $formFilesTemp = $filesObj->getFormTemp($filTraid, $traOp);
                $GLOBALS['xoopsTpl']->assign('formFilesTemp', $formFilesTemp->render());
            }
        }
        break;
    case 'save_edit':
        // Security Check
        if (!$GLOBALS['xoopsSecurity']->check()) {
            \redirect_header('index.php', 3, \implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        // Check permissions
        if (!$permissionsHandler->getPermTransactionsSubmit()) {
            \redirect_header('index.php', 3, \_NOPERM);
        }
        if ($filId > 0) {
            $filesObj = $filesHandler->get($filId);
            if ($helper->getConfig('use_filhistories')) {
                $filesHandler->saveHistoryFiles($filId);
            }
        } else {
            \redirect_header('index.php', 3, \_MA_WGSIMPLEACC_INVALID_PARAM);
        }
        $filesObj->setVar('fil_desc', Request::getString('fil_desc'));
        $filesObj->setVar('fil_ip', $_SERVER['REMOTE_ADDR']);
        $filesObj->setVar('fil_datecreated', \time());
        $filesObj->setVar('fil_submitter', $GLOBALS['xoopsUser']->id());
        // Insert Data
        if ($filesHandler->insert($filesObj)) {
            $filTraid = (int)$filesObj->getVar('fil_traid');
            if ($filTraid > 0) {
                \redirect_header('files.php?op=list&amp;fil_traid=' . $filTraid . $traOp, 2, \_MA_WGSIMPLEACC_FORM_OK);
            } else {
                \redirect_header('files.php?op=filedir_list&amp;fil_traid=0', 2, \_MA_WGSIMPLEACC_FORM_OK);
            }
        }
        // Get Form Error
        $GLOBALS['xoopsTpl']->assign('error', $filesObj->getHtmlErrors());
        $formFiles = $filesObj->getFormFilesEdit($traOp);
        $GLOBALS['xoopsTpl']->assign('formFilesEdit', $formFiles->render());
        break;
    case 'upload_file':
    case 'upload_filedir':
    case 'save_temp':
        // Security Check
        if (!$GLOBALS['xoopsSecurity']->check()) {
            \redirect_header('index.php', 3, \implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        // Check permissions
        if ('upload_filedir' === $op) {
            if (!$permissionsHandler->getPermFileDirSubmit()) {
                \redirect_header('index.php', 3, \_NOPERM);
            }
        } else {
            if (!$permissionsHandler->getPermTransactionsSubmit()) {
                \redirect_header('index.php', 3, \_NOPERM);
            }
        }
        if ($filId > 0) {
            $filesObj = $filesHandler->get($filId);
        } else {
            $filesObj = $filesHandler->create();
        }
        $filesObj->setVar('fil_traid', $filTraid);
        // Set Var fil_name
        $uploaderErrors = '';
        if ('upload_file' === $op || 'upload_filedir' === $op) {
            require_once \XOOPS_ROOT_PATH . '/class/uploader.php';
            $filename    = $_FILES['fil_name']['name'];
            $imgMimetype = $_FILES['fil_name']['type'];
            $uploader = new \XoopsMediaUploader(\WGSIMPLEACC_UPLOAD_FILES_PATH . '/',
                $helper->getConfig('mimetypes_file'),
                $helper->getConfig('maxsize_file'), null, null);
            if ($uploader->fetchMedia($_POST['xoops_upload_file'][0])) {
                $imgName = \substr($filename, 0, strrpos($filename, '.'));
                $imgName = \preg_replace('/[^A-Za-z0-9\-]/', '_', $imgName);
                $uploader->setPrefix($imgName . '_');
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
                        $imgHandler->sourceFile    = \WGSIMPLEACC_UPLOAD_FILES_PATH . '/' . $savedFilename;
                        $imgHandler->endFile       = \WGSIMPLEACC_UPLOAD_FILES_PATH . '/' . $savedFilename;
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
            $filName = Request::getString('fil_temp');
            $filSource = \XOOPS_ROOT_PATH . '/uploads/wgsimpleacc/temp/' . $filName;
            $filDest = \XOOPS_ROOT_PATH . '/uploads/wgsimpleacc/files/' . $filName;
            \rename($filSource, $filDest);
            $filesObj->setVar('fil_name', $filName);
        }
        $filePath = \XOOPS_ROOT_PATH . '/uploads/wgsimpleacc/files/' . $filName;
        if ('' === $filName) {
            \redirect_header('files.php?op=list&fil_traid=' . $filTraid, 5, \_MA_WGSIMPLEACC_FILES_UPLOAD_ERROR);
        }
        $fileMimetype   = \mime_content_type($filePath);
        $filesObj->setVar('fil_type', $fileMimetype);
        $filesObj->setVar('fil_desc', Request::getString('fil_desc'));
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
                if (0 === $filTraid) {
                    \redirect_header('files.php?op=filedir_list', 2, \_MA_WGSIMPLEACC_FORM_OK);
                } else {
                    \redirect_header('files.php?op=list&amp;fil_traid=' . $filTraid . $traOp, 2, \_MA_WGSIMPLEACC_FORM_OK);
                }
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

    case 'edit':
        // Check permissions
        if (!$permissionsHandler->getPermTransactionsSubmit()) {
            \redirect_header('index.php', 3, \_NOPERM);
        }
        // Check params
        if (0 == $filId) {
            \redirect_header('index.php', 3, \_MA_WGSIMPLEACC_INVALID_PARAM);
        }
        // Get Form
        $filesObj = $filesHandler->get($filId);
        $form = $filesObj->getFormFilesEdit($traOp);
        $GLOBALS['xoopsTpl']->assign('formFilesEdit', $form->render());
        break;

    case 'delete':
        // Check params
        if (0 == $filId) {
            \redirect_header('index.php', 3, \_MA_WGSIMPLEACC_INVALID_PARAM);
        }
        $filesObj = $filesHandler->get($filId);
        // Check permissions
        if (!$permissionsHandler->getPermFilesEdit($filesObj->getVar('fil_submitter'))) {
            \redirect_header('index.php', 3, \_NOPERM);
        }
        $filName = $filesObj->getVar('fil_name');
        $filTraid = $filesObj->getVar('fil_traid');
        if (isset($_REQUEST['ok']) && 1 == $_REQUEST['ok']) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                \redirect_header('files.php', 3, \implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            if ($helper->getConfig('use_filhistories')) {
                $filesHandler->saveHistoryFiles($filId);
            } else {
                \unlink(\XOOPS_ROOT_PATH . '/uploads/wgsimpleacc/files/' . $filName);
            }
            if ($filesHandler->delete($filesObj)) {
                if (0 === $filTraid) {
                    \redirect_header('files.php?op=filedir_list', 2, \_MA_WGSIMPLEACC_FORM_DELETE_OK);
                } else {
                    \redirect_header('files.php?op=list&amp;fil_traid=' . $filTraid . $traOp, 3, \_MA_WGSIMPLEACC_FORM_DELETE_OK);
                }
            } else {
                $GLOBALS['xoopsTpl']->assign('error', $filesObj->getHtmlErrors());
            }
        } else {
            $customConfirm = new Common\Confirm(
                ['ok' => 1, 'fil_id' => $filId, 'op' => 'delete', 'traOp' => $traOp],
                $_SERVER['REQUEST_URI'],
                \sprintf(\_MA_WGSIMPLEACC_FORM_SURE_DELETE, $filesObj->getVar('fil_name')), _MA_WGSIMPLEACC_FORM_DELETE_CONFIRM, _MA_WGSIMPLEACC_FORM_DELETE_LABEL);
            $form = $customConfirm->getFormConfirm();
            $GLOBALS['xoopsTpl']->assign('form', $form->render());
        }
        break;
    case 'delete_filtemp':
        // Security Check
        if (!$GLOBALS['xoopsSecurity']->check()) {
            \redirect_header('index.php', 3, \implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        $fileName = Request::getString('fil_temp');
        $filePath = \XOOPS_ROOT_PATH . '/uploads/wgsimpleacc/temp/' . $fileName;
        \unlink($filePath);
        \redirect_header('files.php?op=list&amp;fil_traid=' . $filTraid . $traOp, 3, \_MA_WGSIMPLEACC_FORM_DELETE_OK);
        break;
}

// Breadcrumbs
$xoBreadcrumbs[] = ['title' => \_MA_WGSIMPLEACC_FILES];

// Keywords
wgsimpleaccMetaKeywords($helper->getConfig('keywords') . ', ' . \implode(',', $keywords));
unset($keywords);

// Description
wgsimpleaccMetaDescription(\_MA_WGSIMPLEACC_FILES_DESC);
$GLOBALS['xoopsTpl']->assign('xoops_mpageurl', \WGSIMPLEACC_URL . '/files.php');
$GLOBALS['xoopsTpl']->assign('wgsimpleacc_upload_url', \WGSIMPLEACC_UPLOAD_URL);

require __DIR__ . '/footer.php';
