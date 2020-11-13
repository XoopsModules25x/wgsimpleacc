<?php

namespace XoopsModules\Wgsimpleacc;

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

use XoopsModules\Wgsimpleacc;

\defined('\XOOPS_ROOT_PATH') || die('Restricted access');

/**
 * Class Object Files
 */
class Files extends \XoopsObject
{
	/**
	 * Constructor
	 *
	 * @param null
	 */
	public function __construct()
	{
		$this->initVar('fil_id', \XOBJ_DTYPE_INT);
		$this->initVar('fil_traid', \XOBJ_DTYPE_INT);
		$this->initVar('fil_name', \XOBJ_DTYPE_TXTBOX);
		$this->initVar('fil_type', \XOBJ_DTYPE_TXTBOX);
		$this->initVar('fil_desc', \XOBJ_DTYPE_TXTAREA);
		$this->initVar('fil_ip', \XOBJ_DTYPE_TXTBOX);
		$this->initVar('fil_datecreated', \XOBJ_DTYPE_INT);
		$this->initVar('fil_submitter', \XOBJ_DTYPE_INT);
	}

	/**
	 * @static function &getInstance
	 *
	 * @param null
	 */
	public static function getInstance()
	{
		static $instance = false;
		if (!$instance) {
			$instance = new self();
		}
	}

	/**
	 * The new inserted $Id
	 * @return inserted id
	 */
	public function getNewInsertedIdFiles()
	{
		$newInsertedId = $GLOBALS['xoopsDB']->getInsertId();
		return $newInsertedId;
	}

    /**
     * @public function getForm
     * @param int $traId
     * @param bool $action
     * @return \XoopsThemeForm
     */
	public function getFormFilesAdmin($traId, $action = false)
	{
		if (!$GLOBALS['xoopsUser']->isAdmin($GLOBALS['xoopsModule']->mid())) {
            \redirect_header('accounts.php?op=list', 3, _NOPERM);
        }
	    $helper = \XoopsModules\Wgsimpleacc\Helper::getInstance();
		if (!$action) {
			$action = $_SERVER['REQUEST_URI'];
		}
		// Title
		$title = $this->isNew() ? \sprintf(\_MA_WGSIMPLEACC_FILE_ADD) : \sprintf(\_MA_WGSIMPLEACC_FILE_EDIT);
		// Get Theme Form
		\xoops_load('XoopsFormLoader');
		$form = new \XoopsThemeForm($title, 'form', $action, 'post', true);
		$form->setExtra('enctype="multipart/form-data"');
		// Form Table transactions
		$transactionsHandler = $helper->getHandler('Transactions');
		$filTraid = $this->isNew() ? $traId : $this->getVar('fil_traid');
        $filTraidSelect = new \XoopsFormSelect(\_MA_WGSIMPLEACC_FILE_TRAID, 'fil_traid', $filTraid);
        $filTraidSelect->addOptionArray($transactionsHandler->getList());
        $form->addElement($filTraidSelect);

		// Form File: Upload filName
		$filName = $this->isNew() ? '' : $this->getVar('fil_name');

        $fileUploadTray = new \XoopsFormElementTray(\_MA_WGSIMPLEACC_FILE_NAME, '<br>');
        $fileDirectory = '/uploads/wgsimpleacc/files';
        if (!$this->isNew()) {
            $fileUploadTray->addElement(new \XoopsFormLabel(\sprintf(\_MA_WGSIMPLEACC_FILE_NAME_UPLOADS, ".{$fileDirectory}/"), $filName));
        }
        $maxsize = $helper->getConfig('maxsize_file');
        $fileUploadTray->addElement(new \XoopsFormFile('', 'fil_name', $maxsize));
        $fileUploadTray->addElement(new \XoopsFormLabel(\_MA_WGSIMPLEACC_FORM_UPLOAD_SIZE, ($maxsize / 1048576) . ' '  . \_MA_WGSIMPLEACC_FORM_UPLOAD_SIZE_MB));
        $form->addElement($fileUploadTray, true);
		// Form Select filType
        $form->addElement(new \XoopsFormText(\_MA_WGSIMPLEACC_FILE_TYPE, 'fil_type', 20, 150, $this->getVar('fil_type')));
		// Form Editor TextArea filDesc
		$form->addElement(new \XoopsFormTextArea(\_MA_WGSIMPLEACC_FILE_DESC, 'fil_desc', $this->getVar('fil_desc', 'e'), 4, 47));
		// Form Text IP filIp
		$filIp = $_SERVER['REMOTE_ADDR'];
		$form->addElement(new \XoopsFormText(\_MA_WGSIMPLEACC_FILE_IP, 'fil_ip', 20, 150, $filIp));
		// Form Text Date Select filDatecreated
		$filDatecreated = $this->isNew() ?: $this->getVar('fil_datecreated');
		$form->addElement(new \XoopsFormTextDateSelect(\_MA_WGSIMPLEACC_DATECREATED, 'fil_datecreated', '', $filDatecreated));
		// Form Select User filSubmitter
		$form->addElement(new \XoopsFormSelectUser(\_MA_WGSIMPLEACC_SUBMITTER, 'fil_submitter', false, $this->getVar('fil_submitter')));
		// To Save
		$form->addElement(new \XoopsFormHidden('op', 'save'));
		$form->addElement(new \XoopsFormButtonTray('', _SUBMIT, 'submit', '', false));
		return $form;
	}

    /**
     * @public function getForm
     * @param bool $action
     * @return \XoopsThemeForm
     */
    public function getFormFilesEdit($action = false)
    {

        $helper = \XoopsModules\Wgsimpleacc\Helper::getInstance();
        if (!$action) {
            $action = $_SERVER['REQUEST_URI'];
        }
        // Get Theme Form
        \xoops_load('XoopsFormLoader');
        $form = new \XoopsThemeForm(\_MA_WGSIMPLEACC_FILE_EDIT, 'form', $action, 'post', true);
        $form->setExtra('enctype="multipart/form-data"');
        // Form Table transactions
        $transactionsHandler = $helper->getHandler('Transactions');
        $transactionsObj = $transactionsHandler->get($this->getVar('fil_traid'));
        $transaction = $transactionsObj->getVar('tra_year') . '/' . $transactionsObj->getVar('tra_nb') . ' ' . $transactionsObj->getVar('tra_desc');
        $form->addElement(new \XoopsFormLabel(\_MA_WGSIMPLEACC_TRANSACTION, $transaction));
        // Form filName
        $form->addElement(new \XoopsFormLabel(\_MA_WGSIMPLEACC_FILE_NAME, $this->getVar('fil_name')));
        // Form Select filType
        $form->addElement(new \XoopsFormLabel(\_MA_WGSIMPLEACC_FILE_TYPE, $this->getVar('fil_type')));
        // Form Editor TextArea filDesc
        $form->addElement(new \XoopsFormTextArea(\_MA_WGSIMPLEACC_FILE_DESC, 'fil_desc', $this->getVar('fil_desc', 'e'), 4, 47));
        // To Save
        $form->addElement(new \XoopsFormHidden('op', 'save_edit'));
        $form->addElement(new \XoopsFormButtonTray('', _SUBMIT, 'submit', '', false));
        return $form;
    }

    /**
     * @public function getForm
     * @param int $traId
     * @param bool $action
     * @return \XoopsThemeForm
     */
    public function getFormFiles($traId, $action = false)
    {
        $helper = \XoopsModules\Wgsimpleacc\Helper::getInstance();
        if (!$action) {
            $action = $_SERVER['REQUEST_URI'];
        }
        // Title
        $title = $this->isNew() ? '' : \sprintf(\_MA_WGSIMPLEACC_FILE_EDIT);
        // Get Theme Form
        \xoops_load('XoopsFormLoader');
        $form = new \XoopsThemeForm($title, 'form', $action, 'post', true);
        $form->setExtra('enctype="multipart/form-data"');
        // Form Table transactions
        $filTraid = $this->isNew() ? $traId : $this->getVar('fil_traid');
        // Form File: Upload filName
        $filName = $this->isNew() ? '' : $this->getVar('fil_name');
        $fileUploadTray = new \XoopsFormElementTray(\_MA_WGSIMPLEACC_FILE_NAME, '<br>');
        $fileDirectory = '/uploads/wgsimpleacc/files';
        if (!$this->isNew()) {
            $fileUploadTray->addElement(new \XoopsFormLabel(\sprintf(\_MA_WGSIMPLEACC_FILE_NAME_UPLOADS, ".{$fileDirectory}/"), $filName));
        }
        $maxsize = $helper->getConfig('maxsize_file');
        $fileUploadTray->addElement(new \XoopsFormFile('', 'fil_name', $maxsize), true);
        $fileUploadTray->addElement(new \XoopsFormLabel(\_MA_WGSIMPLEACC_FORM_UPLOAD_SIZE, ($maxsize / 1048576) . ' '  . \_MA_WGSIMPLEACC_FORM_UPLOAD_SIZE_MB));
        $mimetypes = $helper->getConfig('mimetypes_file');
        $extensions = '';
        foreach ($mimetypes as $mimetype) {
            if ('' !== $extensions) {
                $extensions .= ', ';
            }
            $extensions .= Utility::MimetypeToExtension($mimetype);
        }
        $fileUploadTray->addElement(new \XoopsFormLabel(\_MA_WGSIMPLEACC_FORM_UPLOAD_ALLOWEDMIME, $extensions));
        $form->addElement($fileUploadTray, true);
        if (!$this->isNew()) {
            // Form Select filType
            $form->addElement(new \XoopsFormText(\_MA_WGSIMPLEACC_FILE_TYPE, 'fil_type', 20, 150, $this->getVar('fil_type')));
        }
        // Form Editor TextArea filDesc
        $form->addElement(new \XoopsFormTextArea(\_MA_WGSIMPLEACC_FILE_DESC, 'fil_desc', $this->getVar('fil_desc', 'e'), 4, 47));
        // To Save
        $form->addElement(new \XoopsFormHidden('op', 'upload_file'));
        $form->addElement(new \XoopsFormHidden('fil_traid', $filTraid));
        $form->addElement(new \XoopsFormButtonTray('', _SUBMIT, 'submit', '', false));
        return $form;
    }

    /**
     * @public function getForm
     * @param int  $traId
     * @param bool $action
     * @param bool $admin
     * @return \XoopsThemeForm
     */
    public function getFormTemp($traId, $action = false, $admin = false)
    {
        //$helper = \XoopsModules\Wgsimpleacc\Helper::getInstance();
        if (!$action) {
            $action = $_SERVER['REQUEST_URI'];
        }

        // Get Theme Form
        \xoops_load('XoopsFormLoader');
        $form = new \XoopsThemeForm('', 'form', $action, 'post', true);
        $form->setExtra('enctype="multipart/form-data"');

        // Form Frameworks Images Files filTemp
        // Form Frameworks Images filTemp: Select Uploaded Image

        $filTemp = '';
        $imageDirectory = '/uploads/wgsimpleacc/temp';;
        $imageTray = new \XoopsFormElementTray(\_MA_WGSIMPLEACC_FILES_TEMP, '<br>');
        $imageSelect = new \XoopsFormSelect(\str_replace('%f', ".{$imageDirectory}/", \_MA_WGSIMPLEACC_FILES_TEMP_DESC), 'fil_temp', $filTemp, 5);
        $imageArray = \XoopsLists::getImgListAsArray( \XOOPS_ROOT_PATH . $imageDirectory );
        foreach ($imageArray as $image1) {
            $imageSelect->addOption((string)($image1), $image1);
        }
        $imageSelect->setExtra("onchange='showImgSelected(\"imglabel_fil_temp\", \"fil_temp\", \"" . $imageDirectory . '", "", "' . \XOOPS_URL . "\")'");
        $imageTray->addElement($imageSelect, false);
        $imageTray->addElement(new \XoopsFormLabel('', "<br><img src='" . \XOOPS_URL . '/' . $imageDirectory . '/' . $filTemp . "' id='imglabel_fil_temp' alt='' style='max-width:100px' />"));
        $form->addElement($imageTray);

        // Form Editor TextArea filDesc
        $form->addElement(new \XoopsFormTextArea(\_MA_WGSIMPLEACC_FILE_DESC, 'fil_desc', $this->getVar('fil_desc', 'e'), 4, 47));
        // To Save
        $form->addElement(new \XoopsFormHidden('op', 'save_temp'));
        $form->addElement(new \XoopsFormHidden('fil_traid', $traId));
        $form->addElement(new \XoopsFormButtonTray('', _SUBMIT, 'submit', '', false));
        return $form;
    }

    /**
	 * Get Values
	 * @param null $keys
	 * @param null $format
	 * @param null $maxDepth
	 * @return array
	 */
	public function getValuesFiles($keys = null, $format = null, $maxDepth = null)
	{
		$helper  = \XoopsModules\Wgsimpleacc\Helper::getInstance();
		$utility = new \XoopsModules\Wgsimpleacc\Utility();
		$ret = $this->getValues($keys, $format, $maxDepth);
		$ret['id']          = $this->getVar('fil_id');
		$transactionsHandler = $helper->getHandler('Transactions');
		$transactionsObj = $transactionsHandler->get($this->getVar('fil_traid'));
		$ret['traid']       = $transactionsObj->getVar('tra_desc');
		$ret['name']        = $this->getVar('fil_name');
		$ret['type']        = $this->getVar('fil_type');
		switch ($ret['type']) {
            case 'image/gif':
            case 'image/jpeg':
            case 'image/pjpeg':
            case 'image/jpg':
            case 'image/jpe':
            case 'image/png':
                $ret['image'] = 1;
                break;
            case '':
            default:
                $ret['image'] = 0;
                break;
        }
		$ret['desc']        = \strip_tags($this->getVar('fil_desc', 'e'));
		$editorMaxchar = $helper->getConfig('editor_maxchar');
		$ret['desc_short']  = $utility::truncateHtml($ret['desc'], $editorMaxchar);
		$ret['ip']          = $this->getVar('fil_ip');
		$ret['datecreated'] = \formatTimestamp($this->getVar('fil_datecreated'), 's');
		$ret['submitter']   = \XoopsUser::getUnameFromId($this->getVar('fil_submitter'));
		return $ret;
	}

	/**
	 * Returns an array representation of the object
	 *
	 * @return array
	 */
	public function toArrayFiles()
	{
		$ret = [];
		$vars = $this->getVars();
		foreach (\array_keys($vars) as $var) {
			$ret[$var] = $this->getVar('"{$var}"');
		}
		return $ret;
	}
}
