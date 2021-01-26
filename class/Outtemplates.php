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
 * Class Object Outtemplates
 */
class Outtemplates extends \XoopsObject
{
	/**
	 * Constructor
	 *
	 * @param null
	 */
	public function __construct()
	{
		$this->initVar('otpl_id', \XOBJ_DTYPE_INT);
		$this->initVar('otpl_name', \XOBJ_DTYPE_TXTBOX);
		$this->initVar('otpl_content', \XOBJ_DTYPE_OTHER);
		$this->initVar('otpl_online', \XOBJ_DTYPE_INT);
		$this->initVar('otpl_datecreated', \XOBJ_DTYPE_INT);
		$this->initVar('otpl_submitter', \XOBJ_DTYPE_INT);
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
	public function getNewInsertedIdOuttemplates()
	{
		$newInsertedId = $GLOBALS['xoopsDB']->getInsertId();
		return $newInsertedId;
	}

	/**
	 * @public function getForm
	 * @param bool $action
	 * @return \XoopsThemeForm
	 */
	public function getFormOuttemplates($action = false)
	{
		$helper = \XoopsModules\Wgsimpleacc\Helper::getInstance();
		if (!$action) {
			$action = $_SERVER['REQUEST_URI'];
		}
		$isAdmin = $GLOBALS['xoopsUser']->isAdmin($GLOBALS['xoopsModule']->mid());
		// Title
		$title = $this->isNew() ? \sprintf(\_MA_WGSIMPLEACC_OUTTEMPLATE_ADD) : \sprintf(\_MA_WGSIMPLEACC_OUTTEMPLATE_EDIT);
		// Get Theme Form
		\xoops_load('XoopsFormLoader');
		$form = new \XoopsThemeForm($title, 'form', $action, 'post', true);
		$form->setExtra('enctype="multipart/form-data"');
		// Form Text otplName
		$form->addElement(new \XoopsFormText(\_MA_WGSIMPLEACC_OUTTEMPLATE_NAME, 'otpl_name', 50, 255, $this->getVar('otpl_name')), true);
		// Form Editor DhtmlTextArea otplContent
		$editorConfigs = [];
		if ($isAdmin) {
			$editor = $helper->getConfig('editor_admin');
		} else {
			$editor = $helper->getConfig('editor_user');
		}
		$editorConfigs['name'] = 'otpl_content';
		$test1=$this->getVar('otpl_content', 'e');
        $test2=$this->getVar('otpl_content', 'n');
		$editorConfigs['value'] = $this->getVar('otpl_content', 'e');
		$editorConfigs['rows'] = 5;
		$editorConfigs['cols'] = 40;
		$editorConfigs['width'] = '100%';
		$editorConfigs['height'] = '400px';
		$editorConfigs['editor'] = $editor;
        $otplContent = new \XoopsFormEditor(\_MA_WGSIMPLEACC_OUTTEMPLATE_CONTENT, 'otpl_content', $editorConfigs);
        $otplContent->setDescription(\_MA_WGSIMPLEACC_OUTTEMPLATE_CONTENT_DESC);
        $form->addElement($otplContent);
		// Form Radio Yes/No otplOnline
		$otplOnline = $this->isNew() ?: $this->getVar('otpl_online');
		$form->addElement(new \XoopsFormRadioYN(\_MA_WGSIMPLEACC_OUTTEMPLATE_ONLINE, 'otpl_online', $otplOnline));
		// Form Text Date Select otplDatecreated
		$otplDatecreated = $this->isNew() ?: $this->getVar('otpl_datecreated');
		$form->addElement(new \XoopsFormTextDateSelect(\_MA_WGSIMPLEACC_DATECREATED, 'otpl_datecreated', '', $otplDatecreated));
		// Form Select User otplSubmitter
		$form->addElement(new \XoopsFormSelectUser(\_MA_WGSIMPLEACC_SUBMITTER, 'otpl_submitter', false, $this->getVar('otpl_submitter')));
		// To Save
		$form->addElement(new \XoopsFormHidden('op', 'save'));
		$form->addElement(new \XoopsFormButtonTray('', \_SUBMIT, 'submit', '', false));
		return $form;
	}

	/**
	 * Get Values
	 * @param null $keys
	 * @param null $format
	 * @param null $maxDepth
	 * @return array
	 */
	public function getValuesOuttemplates($keys = null, $format = null, $maxDepth = null)
	{
		$helper  = \XoopsModules\Wgsimpleacc\Helper::getInstance();
		$utility = new \XoopsModules\Wgsimpleacc\Utility();
		$ret = $this->getValues($keys, $format, $maxDepth);
		$ret['id']            = $this->getVar('otpl_id');
		$ret['name']          = $this->getVar('otpl_name');
		$ret['content']       = $this->getVar('otpl_content', 'e');
		$editorMaxchar = $helper->getConfig('editor_maxchar');
		$ret['content_short'] = $utility::truncateHtml($ret['content'], $editorMaxchar);
		$ret['online']        = (int)$this->getVar('otpl_online') > 0 ? _YES : _NO;
		$ret['datecreated']   = \formatTimestamp($this->getVar('otpl_datecreated'), 's');
		$ret['submitter']     = \XoopsUser::getUnameFromId($this->getVar('otpl_submitter'));
		return $ret;
	}

	/**
	 * Returns an array representation of the object
	 *
	 * @return array
	 */
	public function toArrayOuttemplates()
	{
		$ret = [];
		$vars = $this->getVars();
		foreach (\array_keys($vars) as $var) {
			$ret[$var] = $this->getVar('"{$var}"');
		}
		return $ret;
	}
}
