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
use XoopsModules\Wgsimpleacc\Utility;

\defined('\XOOPS_ROOT_PATH') || die('Restricted access');

/**
 * Class Object Assets
 */
class Assets extends \XoopsObject
{
	/**
	 * Constructor
	 *
	 * @param null
	 */
	public function __construct()
	{
		$this->initVar('as_id', \XOBJ_DTYPE_INT);
		$this->initVar('as_name', \XOBJ_DTYPE_TXTBOX);
        $this->initVar('as_reference', \XOBJ_DTYPE_TXTBOX);
		$this->initVar('as_descr', \XOBJ_DTYPE_TXTAREA);
        $this->initVar('as_color', \XOBJ_DTYPE_TXTBOX);
        $this->initVar('as_online', \XOBJ_DTYPE_INT);
        $this->initVar('as_primary', \XOBJ_DTYPE_INT);
		$this->initVar('as_datecreated', \XOBJ_DTYPE_INT);
		$this->initVar('as_submitter', \XOBJ_DTYPE_INT);
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
	public function getNewInsertedIdAssets()
	{
		$newInsertedId = $GLOBALS['xoopsDB']->getInsertId();
		return $newInsertedId;
	}

    /**
     * @public function getForm
     * @param bool $action
     * @param bool $admin
     * @return \XoopsThemeForm
     */
	public function getFormAssets($action = false, $admin = false)
    {
        if (!$action) {
            $action = $_SERVER['REQUEST_URI'];
        }
        // Title
        $title = $this->isNew() ? \sprintf(\_AM_WGSIMPLEACC_ASSET_ADD) : \sprintf(\_AM_WGSIMPLEACC_ASSET_EDIT);
        // Get Theme Form
        \xoops_load('XoopsFormLoader');
        $form = new \XoopsThemeForm($title, 'form', $action, 'post', true);
        $form->setExtra('enctype="multipart/form-data"');
        // Form Text asName
        $form->addElement(new \XoopsFormText(\_MA_WGSIMPLEACC_ASSET_NAME, 'as_name', 50, 255, $this->getVar('as_name')), true);
        // Form Text asReference
        $form->addElement(new \XoopsFormText(\_MA_WGSIMPLEACC_ASSET_REFERENCE, 'as_reference', 50, 255, $this->getVar('as_reference')));
        // Form Editor TextArea asDescr
        $form->addElement(new \XoopsFormTextArea(\_MA_WGSIMPLEACC_ASSET_DESCR, 'as_descr', $this->getVar('as_descr', 'e'), 4, 47));
        // Form Select asColor
        $colors = Utility::getColors();
        $asColor = $this->getVar('as_color');
        $asColorRadio = new \XoopsFormRadio(\_MA_WGSIMPLEACC_ASSET_COLOR, 'as_color', $asColor);
        foreach($colors as $color) {
            $desc = '<span style="background-color:' . $color['code'] . ';';
            if ($color['code'] == $asColor) {
                $desc .= 'border:3px double #000"';
            } else {
                $desc .= 'border:1px solid #000"';
            }
            $desc .= '>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;' . $color['descr'];
            $asColorRadio->addOption($color['code'], $desc);
        }
        $form->addElement($asColorRadio);

        // Form Radio Yes/No asOnline
        $asOnline = $this->isNew() ?: $this->getVar('as_online');
        $form->addElement(new \XoopsFormRadioYN(\_MA_WGSIMPLEACC_ASSET_ONLINE, 'as_online', $asOnline));
        // Form Radio Yes/No asPrimary
        $asPrimary = $this->isNew() ?: $this->getVar('as_primary');
        $form->addElement(new \XoopsFormRadioYN(\_MA_WGSIMPLEACC_ASSET_PRIMARY, 'as_primary', $asPrimary));
        // Form Text Date Select asDatecreated
        $asDatecreated = $this->isNew() ? \time() : $this->getVar('as_datecreated');
        $asSubmitter = $this->isNew() ? $GLOBALS['xoopsUser']->uid() : $this->getVar('as_submitter');
        if ($admin) {
            $form->addElement(new \XoopsFormTextDateSelect(\_MA_WGSIMPLEACC_DATECREATED, 'as_datecreated', '', $asDatecreated));
            // Form Select User asSubmitter
            $form->addElement(new \XoopsFormSelectUser(\_MA_WGSIMPLEACC_SUBMITTER, 'as_submitter', false, $asSubmitter));
        } else {
            $form->addElement(new \XoopsFormHidden('as_datecreated', $asDatecreated));
            $form->addElement(new \XoopsFormHidden('as_submitter', $asSubmitter));
        }

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
	public function getValuesAssets($keys = null, $format = null, $maxDepth = null)
	{
        $helper  = \XoopsModules\Wgsimpleacc\Helper::getInstance();
        $utility = new \XoopsModules\Wgsimpleacc\Utility();
        $ret = $this->getValues($keys, $format, $maxDepth);
        $ret['id']          = $this->getVar('as_id');
        $ret['name']        = $this->getVar('as_name');
        $ret['reference']   = $this->getVar('as_reference');
        $ret['descr']       = \strip_tags($this->getVar('as_descr', 'e'));
        $ret['color']        = $this->getVar('as_color');
        $editorMaxchar = $helper->getConfig('editor_maxchar');
        $ret['descr_short'] = $utility::truncateHtml($ret['descr'], $editorMaxchar);
        $ret['online']      = (int)$this->getVar('as_online') > 0 ? _YES : _NO;
        $ret['primary']     = (int)$this->getVar('as_primary') > 0 ? _YES : _NO;
        $ret['datecreated'] = \formatTimestamp($this->getVar('as_datecreated'), 's');
        $ret['submitter']   = \XoopsUser::getUnameFromId($this->getVar('as_submitter'));

		return $ret;
	}

	/**
	 * Returns an array representation of the object
	 *
	 * @return array
	 */
	public function toArrayAssets()
	{
		$ret = [];
		$vars = $this->getVars();
		foreach (\array_keys($vars) as $var) {
			$ret[$var] = $this->getVar('"{$var}"');
		}
		return $ret;
	}
}
