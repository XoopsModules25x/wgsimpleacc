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
 * Class Object Classifications
 */
class Classifications extends \XoopsObject
{
	/**
	 * Constructor
	 *
	 * @param null
	 */
	public function __construct()
	{
		$this->initVar('cla_id', \XOBJ_DTYPE_INT);
		$this->initVar('cla_pid', \XOBJ_DTYPE_INT);
		$this->initVar('cla_name', \XOBJ_DTYPE_TXTBOX);
		$this->initVar('cla_datecreated', \XOBJ_DTYPE_INT);
		$this->initVar('cla_submitter', \XOBJ_DTYPE_INT);
		$this->initVar('cla_status', \XOBJ_DTYPE_INT);
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
	public function getNewInsertedIdClassifications()
	{
		$newInsertedId = $GLOBALS['xoopsDB']->getInsertId();
		return $newInsertedId;
	}

	/**
	 * @public function getForm
	 * @param bool $action
	 * @return \XoopsThemeForm
	 */
	public function getFormClassifications($action = false)
	{
		$helper = \XoopsModules\Wgsimpleacc\Helper::getInstance();
		if (!$action) {
			$action = $_SERVER['REQUEST_URI'];
		}
		$isAdmin = $GLOBALS['xoopsUser']->isAdmin($GLOBALS['xoopsModule']->mid());
		// Title
		$title = $this->isNew() ? \sprintf(\_AM_WGSIMPLEACC_CLASSIFICATION_ADD) : \sprintf(\_AM_WGSIMPLEACC_CLASSIFICATION_EDIT);
		// Get Theme Form
		\xoops_load('XoopsFormLoader');
		$form = new \XoopsThemeForm($title, 'form', $action, 'post', true);
		$form->setExtra('enctype="multipart/form-data"');
		// Form Table classifications
		$classificationsHandler = $helper->getHandler('Classifications');
		$claPidSelect = new \XoopsFormSelect(\_AM_WGSIMPLEACC_CLASSIFICATION_PID, 'cla_pid', $this->getVar('cla_pid'));
		$claPidSelect->addOptionArray($classificationsHandler->getList());
		$form->addElement($claPidSelect);
		// Form Text claName
		$form->addElement(new \XoopsFormText(\_AM_WGSIMPLEACC_CLASSIFICATION_NAME, 'cla_name', 50, 255, $this->getVar('cla_name')), true);
		// Form Select Status claStatus
		$claStatusSelect = new \XoopsFormSelect(\_AM_WGSIMPLEACC_CLASSIFICATION_STATUS, 'cla_status', $this->getVar('cla_status'));
		$claStatusSelect->addOption(Constants::STATUS_NONE, \_AM_WGSIMPLEACC_STATUS_NONE);
		$claStatusSelect->addOption(Constants::STATUS_OFFLINE, \_AM_WGSIMPLEACC_STATUS_OFFLINE);
		$claStatusSelect->addOption(Constants::STATUS_SUBMITTED, \_AM_WGSIMPLEACC_STATUS_SUBMITTED);
		$claStatusSelect->addOption(Constants::STATUS_BROKEN, \_AM_WGSIMPLEACC_STATUS_BROKEN);
		$form->addElement($claStatusSelect);
		// Form Text Date Select claDatecreated
		$claDatecreated = $this->isNew() ?: $this->getVar('cla_datecreated');
		$form->addElement(new \XoopsFormTextDateSelect(\_AM_WGSIMPLEACC_CLASSIFICATION_DATECREATED, 'cla_datecreated', '', $claDatecreated));
		// Form Select User claSubmitter
		$form->addElement(new \XoopsFormSelectUser(\_AM_WGSIMPLEACC_CLASSIFICATION_SUBMITTER, 'cla_submitter', false, $this->getVar('cla_submitter')));
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
	public function getValuesClassifications($keys = null, $format = null, $maxDepth = null)
	{
		$helper  = \XoopsModules\Wgsimpleacc\Helper::getInstance();
		$ret = $this->getValues($keys, $format, $maxDepth);
		$ret['id']          = $this->getVar('cla_id');
		$classificationsHandler = $helper->getHandler('Classifications');
		$classificationsObj = $classificationsHandler->get($this->getVar('cla_pid'));
		$ret['pid']         = $classificationsObj->getVar('as_name');
		$ret['name']        = $this->getVar('cla_name');
		$ret['datecreated'] = \formatTimestamp($this->getVar('cla_datecreated'), 's');
		$ret['submitter']   = \XoopsUser::getUnameFromId($this->getVar('cla_submitter'));
		$status             = $this->getVar('cla_status');
		$ret['status']      = $status;
		switch ($status) {
			case Constants::STATUS_NONE:
			default:
				$status_text = \_AM_WGSIMPLEACC_STATUS_NONE;
				break;
			case Constants::STATUS_OFFLINE:
				$status_text = \_AM_WGSIMPLEACC_STATUS_OFFLINE;
				break;
			case Constants::STATUS_SUBMITTED:
				$status_text = \_AM_WGSIMPLEACC_STATUS_SUBMITTED;
				break;
		}
		$ret['status_text'] = $status_text;
		return $ret;
	}

	/**
	 * Returns an array representation of the object
	 *
	 * @return array
	 */
	public function toArrayClassifications()
	{
		$ret = [];
		$vars = $this->getVars();
		foreach (\array_keys($vars) as $var) {
			$ret[$var] = $this->getVar('"{$var}"');
		}
		return $ret;
	}
}
