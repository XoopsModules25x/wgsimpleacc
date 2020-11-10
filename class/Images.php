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
 * @author         XOOPS Development Team - Email:<webmaster@wedega.com> - Website:<https://xoops.wedega.com>
 */

use XoopsModules\Wgsimpleacc;

\defined('\XOOPS_ROOT_PATH') || die('Restricted access');

/**
 * Class Object Images
 */
class Images extends \XoopsObject
{
	/**
	 * Constructor
	 *
	 * @param null
	 */
	public function __construct()
	{
		$this->initVar('img_id', \XOBJ_DTYPE_INT);
		$this->initVar('img_traid', \XOBJ_DTYPE_INT);
		$this->initVar('img_name', \XOBJ_DTYPE_TXTBOX);
		$this->initVar('img_type', \XOBJ_DTYPE_INT);
		$this->initVar('img_desc', \XOBJ_DTYPE_TXTAREA);
		$this->initVar('img_ip', \XOBJ_DTYPE_TXTBOX);
		$this->initVar('img_datecreated', \XOBJ_DTYPE_INT);
		$this->initVar('img_submitter', \XOBJ_DTYPE_INT);
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
	public function getNewInsertedIdImages()
	{
		$newInsertedId = $GLOBALS['xoopsDB']->getInsertId();
		return $newInsertedId;
	}

	/**
	 * @public function getForm
	 * @param bool $action
	 * @return \XoopsThemeForm
	 */
	public function getFormImages($action = false)
	{
		$helper = \XoopsModules\Wgsimpleacc\Helper::getInstance();
		if (!$action) {
			$action = $_SERVER['REQUEST_URI'];
		}
		$isAdmin = $GLOBALS['xoopsUser']->isAdmin($GLOBALS['xoopsModule']->mid());
		// Title
		$title = $this->isNew() ? \sprintf(\_AM_WGSIMPLEACC_IMAGE_ADD) : \sprintf(\_AM_WGSIMPLEACC_IMAGE_EDIT);
		// Get Theme Form
		\xoops_load('XoopsFormLoader');
		$form = new \XoopsThemeForm($title, 'form', $action, 'post', true);
		$form->setExtra('enctype="multipart/form-data"');
		// Form Table transactions
		$transactionsHandler = $helper->getHandler('Transactions');
		$imgTraidSelect = new \XoopsFormSelect(\_AM_WGSIMPLEACC_IMAGE_TRAID, 'img_traid', $this->getVar('img_traid'));
		$imgTraidSelect->addOptionArray($transactionsHandler->getList());
		$form->addElement($imgTraidSelect);
		// Form Image imgName
		// Form Image imgName: Select Uploaded Image 
		$getImgName = $this->getVar('img_name');
		$imgName = $getImgName ?: 'blank.gif';
		$imageDirectory = '/uploads/wgsimpleacc/images/images';
		$imageTray = new \XoopsFormElementTray(\_AM_WGSIMPLEACC_IMAGE_NAME, '<br>');
		$imageSelect = new \XoopsFormSelect(\sprintf(\_AM_WGSIMPLEACC_IMAGE_NAME_UPLOADS, ".{$imageDirectory}/"), 'img_name', $imgName, 5);
		$imageArray = \XoopsLists::getImgListAsArray( \XOOPS_ROOT_PATH . $imageDirectory );
		foreach ($imageArray as $image1) {
			$imageSelect->addOption((string)($image1), $image1);
		}
		$imageSelect->setExtra("onchange='showImgSelected(\"imglabel_img_name\", \"img_name\", \"" . $imageDirectory . '", "", "' . \XOOPS_URL . "\")'");
		$imageTray->addElement($imageSelect, false);
		$imageTray->addElement(new \XoopsFormLabel('', "<br><img src='" . \XOOPS_URL . '/' . $imageDirectory . '/' . $imgName . "' id='imglabel_img_name' alt='' style='max-width:100px' />"));
		// Form Image imgName: Upload new image
		if ($permissionUpload) {
			$maxsize = $helper->getConfig('maxsize_image');
			$imageTray->addElement(new \XoopsFormFile('<br>' . \_AM_WGSIMPLEACC_FORM_UPLOAD_NEW, 'img_name', $maxsize));
			$imageTray->addElement(new \XoopsFormLabel(\_AM_WGSIMPLEACC_FORM_UPLOAD_SIZE, ($maxsize / 1048576) . ' '  . \_AM_WGSIMPLEACC_FORM_UPLOAD_SIZE_MB));
			$imageTray->addElement(new \XoopsFormLabel(\_AM_WGSIMPLEACC_FORM_UPLOAD_IMG_WIDTH, $helper->getConfig('maxwidth_image') . ' px'));
			$imageTray->addElement(new \XoopsFormLabel(\_AM_WGSIMPLEACC_FORM_UPLOAD_IMG_HEIGHT, $helper->getConfig('maxheight_image') . ' px'));
		} else {
			$imageTray->addElement(new \XoopsFormHidden('img_name', $imgName));
		}
		$form->addElement($imageTray, true);
		// Images Handler
		$imagesHandler = $helper->getHandler('Images');
		// Form Select imgType
		$imgTypeSelect = new \XoopsFormSelect(\_AM_WGSIMPLEACC_IMAGE_TYPE, 'img_type', $this->getVar('img_type'), 5);
		$imgTypeSelect->addOption('0', _NONE);
		$imgTypeSelect->addOption('1', \_AM_WGSIMPLEACC_LIST_1);
		$imgTypeSelect->addOption('2', \_AM_WGSIMPLEACC_LIST_2);
		$imgTypeSelect->addOption('3', \_AM_WGSIMPLEACC_LIST_3);
		$form->addElement($imgTypeSelect);
		// Form Editor TextArea imgDesc
		$form->addElement(new \XoopsFormTextArea(\_AM_WGSIMPLEACC_IMAGE_DESC, 'img_desc', $this->getVar('img_desc', 'e'), 4, 47));
		// Form Text IP imgIp
		$imgIp = $_SERVER['REMOTE_ADDR'];
		$form->addElement(new \XoopsFormText(\_AM_WGSIMPLEACC_IMAGE_IP, 'img_ip', 20, 150, $imgIp));
		// Form Text Date Select imgDatecreated
		$imgDatecreated = $this->isNew() ?: $this->getVar('img_datecreated');
		$form->addElement(new \XoopsFormTextDateSelect(\_AM_WGSIMPLEACC_IMAGE_DATECREATED, 'img_datecreated', '', $imgDatecreated));
		// Form Select User imgSubmitter
		$form->addElement(new \XoopsFormSelectUser(\_AM_WGSIMPLEACC_IMAGE_SUBMITTER, 'img_submitter', false, $this->getVar('img_submitter')));
		// To Save
		$form->addElement(new \XoopsFormHidden('op', 'save'));
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
	public function getValuesImages($keys = null, $format = null, $maxDepth = null)
	{
		$helper  = \XoopsModules\Wgsimpleacc\Helper::getInstance();
		$utility = new \XoopsModules\Wgsimpleacc\Utility();
		$ret = $this->getValues($keys, $format, $maxDepth);
		$ret['id']          = $this->getVar('img_id');
		$transactionsHandler = $helper->getHandler('Transactions');
		$transactionsObj = $transactionsHandler->get($this->getVar('img_traid'));
		$ret['traid']       = $transactionsObj->getVar('tra_desc');
		$ret['name']        = $this->getVar('img_name');
		$ret['type']        = $this->getVar('img_type');
		$ret['desc']        = \strip_tags($this->getVar('img_desc', 'e'));
		$editorMaxchar = $helper->getConfig('editor_maxchar');
		$ret['desc_short']  = $utility::truncateHtml($ret['desc'], $editorMaxchar);
		$ret['ip']          = $this->getVar('img_ip');
		$ret['datecreated'] = \formatTimestamp($this->getVar('img_datecreated'), 's');
		$ret['submitter']   = \XoopsUser::getUnameFromId($this->getVar('img_submitter'));
		return $ret;
	}

	/**
	 * Returns an array representation of the object
	 *
	 * @return array
	 */
	public function toArrayImages()
	{
		$ret = [];
		$vars = $this->getVars();
		foreach (\array_keys($vars) as $var) {
			$ret[$var] = $this->getVar('"{$var}"');
		}
		return $ret;
	}
}
