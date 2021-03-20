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
    Common
};

require __DIR__ . '/header.php';
// It recovered the value of argument op in URL$
$op       = Request::getCmd('op', 'list');
$filId    = Request::getInt('fil_id');
$filTraid = Request::getInt('fil_traid');

switch ($op) {
    case 'list':
    default:
        // Define Stylesheet
        $GLOBALS['xoTheme']->addStylesheet($style, null);
        $start = Request::getInt('start', 0);
        $limit = Request::getInt('limit', $helper->getConfig('adminpager'));
        $templateMain = 'wgsimpleacc_admin_files.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('files.php'));
        $adminObject->addItemButton(\_AM_WGSIMPLEACC_ADD_FILE, 'files.php?op=new', 'add');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        $filesCount = $filesHandler->getCountFiles();
        $filesAll = $filesHandler->getAllFiles($start, $limit);
        $GLOBALS['xoopsTpl']->assign('files_count', $filesCount);
        $GLOBALS['xoopsTpl']->assign('wgsimpleacc_url', WGSIMPLEACC_URL);
        $GLOBALS['xoopsTpl']->assign('wgsimpleacc_upload_url', WGSIMPLEACC_UPLOAD_URL);
        // Table view files
        if ($filesCount > 0) {
            foreach (\array_keys($filesAll) as $i) {
                $file = $filesAll[$i]->getValuesFiles();
                $GLOBALS['xoopsTpl']->append('files_list', $file);
                unset($file);
            }
            // Display Navigation
            if ($filesCount > $limit) {
                require_once \XOOPS_ROOT_PATH . '/class/pagenav.php';
                $pagenav = new \XoopsPageNav($filesCount, $limit, $start, 'start', 'op=list&limit=' . $limit);
                $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
            }
        } else {
            $GLOBALS['xoopsTpl']->assign('error', \_MA_WGSIMPLEACC_THEREARENT_FILES);
        }
        break;
    case 'new':
        $templateMain = 'wgsimpleacc_admin_files.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('files.php'));
        $adminObject->addItemButton(\_AM_WGSIMPLEACC_LIST_FILES, 'files.php', 'list');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        // Form Create
        $filesObj = $filesHandler->create();
        $form = $filesObj->getFormFilesAdmin($filTraid, false);
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'save':
        // Security Check
        if ($filId > 0) {
            $filesObj = $filesHandler->get($filId);
        } else {
            $filesObj = $filesHandler->create();
        }
        // Set Vars
        $filesObj->setVar('fil_traid', Request::getInt('fil_traid', 0));
        // Set Var fil_name
        require_once \XOOPS_ROOT_PATH . '/class/uploader.php';
        $fileName       = $_FILES['fil_name']['name'];
        $imgNameDef     = Request::getString('fil_name');
        $uploader = new \XoopsMediaUploader(WGSIMPLEACC_UPLOAD_FILES_PATH . '/',
                                                    $helper->getConfig('mimetypes_file'), 
                                                    $helper->getConfig('maxsize_file'), null, null);
        if ($uploader->fetchMedia($_POST['xoops_upload_file'][0])) {
            $extension = \preg_replace('/^.+\.([^.]+)$/sU', '', $fileName);
            $imgName = \str_replace(' ', '', $imgNameDef) . '.' . $extension;
            $uploader->setPrefix($imgName);
            $uploader->fetchMedia($_POST['xoops_upload_file'][0]);
            if (!$uploader->upload()) {
                $errors = $uploader->getErrors();
            } else {
                //TODO: add image resize, if image
                $filSaveName = $uploader->getSavedFileName();
                $filesObj->setVar('fil_name', $filSaveName);
            }
        } else {
            if ($fileName > '') {
                $uploaderErrors = $uploader->getErrors();
            }
            $filSaveName = Request::getString('fil_name');
            $filesObj->setVar('fil_name', $filSaveName);
        }
        echo WGSIMPLEACC_UPLOAD_FILES_PATH . '/' . $filSaveName;
        $fileMimetype   = \mime_content_type(WGSIMPLEACC_UPLOAD_FILES_PATH . '/' . $filSaveName);
        $filesObj->setVar('fil_type', $fileMimetype);
        $filesObj->setVar('fil_desc', Request::getString('fil_desc', ''));
        $filesObj->setVar('fil_ip', Request::getString('fil_ip', ''));
        $fileDatecreatedObj = \DateTime::createFromFormat(_SHORTDATESTRING, Request::getString('fil_datecreated'));
        $filesObj->setVar('fil_datecreated', $fileDatecreatedObj->getTimestamp());
        $filesObj->setVar('fil_submitter', Request::getInt('fil_submitter', 0));
        // Insert Data
        if ($filesHandler->insert($filesObj)) {
            if ('' !== $uploaderErrors) {
                \redirect_header('files.php?op=edit&fil_id=' . $filId, 5, $uploaderErrors);
            } else {
                \redirect_header('files.php?op=list', 2, \_MA_WGSIMPLEACC_FORM_OK);
            }
        }
        // Get Form
        $GLOBALS['xoopsTpl']->assign('error', $filesObj->getHtmlErrors());
        $form = $filesObj->getFormFilesAdmin($filTraid, false);
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'edit':
        $templateMain = 'wgsimpleacc_admin_files.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('files.php'));
        $adminObject->addItemButton(\_AM_WGSIMPLEACC_ADD_FILE, 'files.php?op=new', 'add');
        $adminObject->addItemButton(\_AM_WGSIMPLEACC_LIST_FILES, 'files.php', 'list');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        // Get Form
        $filesObj = $filesHandler->get($filId);
        $form = $filesObj->getFormFilesAdmin($filTraid, false);
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'delete':
        $templateMain = 'wgsimpleacc_admin_files.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('files.php'));
        $filesObj = $filesHandler->get($filId);
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
require __DIR__ . '/footer.php';
