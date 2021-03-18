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
use XoopsModules\Wgsimpleacc\Constants;

\defined('\XOOPS_ROOT_PATH') || die('Restricted access');

/**
 * Class Object Accounts
 */
class Accounts extends \XoopsObject
{
	/**
	 * Constructor
	 *
	 * @param null
	 */
	public function __construct()
	{
        $this->initVar('acc_id', \XOBJ_DTYPE_INT);
        $this->initVar('acc_pid', \XOBJ_DTYPE_INT);
        $this->initVar('acc_key', \XOBJ_DTYPE_TXTBOX);
        $this->initVar('acc_name', \XOBJ_DTYPE_TXTBOX);
        $this->initVar('acc_desc', \XOBJ_DTYPE_TXTAREA);
        $this->initVar('acc_classification', \XOBJ_DTYPE_INT);
        $this->initVar('acc_color', \XOBJ_DTYPE_TXTBOX);
        $this->initVar('acc_iecalc', \XOBJ_DTYPE_INT);
        $this->initVar('acc_online', \XOBJ_DTYPE_INT);
        $this->initVar('acc_level', \XOBJ_DTYPE_INT);
        $this->initVar('acc_weight', \XOBJ_DTYPE_INT);
        $this->initVar('acc_datecreated', \XOBJ_DTYPE_INT);
        $this->initVar('acc_submitter', \XOBJ_DTYPE_INT);
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
	public function getNewInsertedIdAccounts()
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
	public function getFormAccounts($action = false, $admin = false)
	{
		$helper = \XoopsModules\Wgsimpleacc\Helper::getInstance();
		if (!$action) {
			$action = $_SERVER['REQUEST_URI'];
		}
		// Title
		$title = $this->isNew() ? \sprintf(\_MA_WGSIMPLEACC_ACCOUNT_ADD) : \sprintf(\_MA_WGSIMPLEACC_ACCOUNT_EDIT);
		// Get Theme Form
		\xoops_load('XoopsFormLoader');
		$form = new \XoopsThemeForm($title, 'form', $action, 'post', true);
		$form->setExtra('enctype="multipart/form-data"');
		// Form Table accounts
		$accountsHandler = $helper->getHandler('Accounts');
		$accPidSelect = new \XoopsFormSelect(\_MA_WGSIMPLEACC_ACCOUNT_PID, 'acc_pid', $this->getVar('acc_pid'));
        $accPidSelect->addOption(0, ' ');
        $accountsCount = $accountsHandler->getCountAccounts();
        if ($accountsCount > 0) {
            $accountsAll = $accountsHandler->getAllAccounts();
            foreach (\array_keys($accountsAll) as $i) {
                $accPidSelect->addOption($accountsAll[$i]->getVar('acc_id'), $accountsAll[$i]->getVar('acc_key') . ' ' . $accountsAll[$i]->getVar('acc_name'));
            }
        }
		$form->addElement($accPidSelect);
		// Form Text accKey
		$form->addElement(new \XoopsFormText(\_MA_WGSIMPLEACC_ACCOUNT_KEY, 'acc_key', 50, 255, $this->getVar('acc_key')), true);
		// Form Text accName
		$form->addElement(new \XoopsFormText(\_MA_WGSIMPLEACC_ACCOUNT_NAME, 'acc_name', 50, 255, $this->getVar('acc_name')));
		// Form Editor TextArea accDesc
		$form->addElement(new \XoopsFormTextArea(\_MA_WGSIMPLEACC_ACCOUNT_DESC, 'acc_desc', $this->getVar('acc_desc', 'e'), 4, 47));
		// Form Select accClassification
        $accClassification = $this->isNew() ? Constants::CLASS_BOTH : $this->getVar('acc_classification');
		$accClassificationSelect = new \XoopsFormSelect(\_MA_WGSIMPLEACC_ACCOUNT_CLASSIFICATION, 'acc_classification', $accClassification, 3);
		$accClassificationSelect->addOption(Constants::CLASS_EXPENSES, \_MA_WGSIMPLEACC_CLASS_EXPENSES);
		$accClassificationSelect->addOption(Constants::CLASS_INCOME, \_MA_WGSIMPLEACC_CLASS_INCOME);
        $accClassificationSelect->addOption(Constants::CLASS_BOTH, \_MA_WGSIMPLEACC_CLASS_BOTH);
		$form->addElement($accClassificationSelect);
        // Form Select accColor
        $colors = Utility::getColors();
        $accColor = $this->getVar('acc_color');
        $accColorRadio = new \XoopsFormRadio(\_MA_WGSIMPLEACC_ACCOUNT_COLOR, 'acc_color', $accColor);
        foreach($colors as $color) {
            $desc = '<span style="background-color:' . $color['code'] . ';';
            if ($color['code'] == $accColor) {
                $desc .= 'border:3px double #000"';
            } else {
                $desc .= 'border:1px solid #000"';
            }
            $desc .= '>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;' . $color['descr'];
            $accColorRadio->addOption($color['code'], $desc);
        }
        $form->addElement($accColorRadio);
        // Form Radio Yes/No accIecalc
        $accIecalc = $this->isNew() ? 1 : $this->getVar('acc_iecalc');
        $form->addElement(new \XoopsFormRadioYN(\_MA_WGSIMPLEACC_ACCOUNT_IECALC, 'acc_iecalc', $accIecalc));
		// Form Radio Yes/No accOnline
		$accOnline = $this->isNew() ?: $this->getVar('acc_online');
		$form->addElement(new \XoopsFormRadioYN(\_MA_WGSIMPLEACC_ACCOUNT_ONLINE, 'acc_online', $accOnline));
        // Form Text accLevel
        $accLevel = $this->isNew() ? 1 : $this->getVar('acc_level');
        if ($admin) {
            $form->addElement(new \XoopsFormText(\_MA_WGSIMPLEACC_ACCOUNT_LEVEL, 'acc_level', 50, 255, $accLevel));
        } else {
            $form->addElement(new \XoopsFormHidden('acc_level', $accLevel));
        }
		// Form Text accWeight
        $accWeight = $this->isNew() ? 99 : $this->getVar('acc_weight');
        // Form Text Date Select accDatecreated
        $accDatecreated = $this->isNew() ? \time() : $this->getVar('acc_datecreated');
        // Form Select User accSubmitter
        $accSubmitter = $this->isNew() ? $GLOBALS['xoopsUser']->uid() : $this->getVar('acc_submitter');
        if ($admin) {
            $form->addElement(new \XoopsFormText(\_MA_WGSIMPLEACC_ACCOUNT_WEIGHT, 'acc_weight', 50, 255, $accWeight));
            $form->addElement(new \XoopsFormTextDateSelect(\_MA_WGSIMPLEACC_DATECREATED, 'acc_datecreated', '', $accDatecreated));
            $form->addElement(new \XoopsFormSelectUser(\_MA_WGSIMPLEACC_SUBMITTER, 'acc_submitter', false, $accSubmitter));
        } else {
            $form->addElement(new \XoopsFormHidden('acc_weight', $accWeight));
            $form->addElement(new \XoopsFormHidden('acc_datecreated', $accDatecreated));
            $form->addElement(new \XoopsFormHidden('acc_submitter', $accSubmitter));
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
	public function getValuesAccounts($keys = null, $format = null, $maxDepth = null)
	{
        $helper  = \XoopsModules\Wgsimpleacc\Helper::getInstance();
        $utility = new \XoopsModules\Wgsimpleacc\Utility();
        $ret = $this->getValues($keys, $format, $maxDepth);
        $ret['id']             = $this->getVar('acc_id');
        $accountsHandler = $helper->getHandler('Accounts');
        $accountsObj = $accountsHandler->get($this->getVar('acc_pid'));
        $ret['pid']            = $accountsObj->getVar('acc_key');
        $ret['key']            = $this->getVar('acc_key');
        $ret['name']           = $this->getVar('acc_name');
        $ret['desc']           = \strip_tags($this->getVar('acc_desc', 'e'));
        $editorMaxchar = $helper->getConfig('editor_maxchar');
        $ret['desc_short']     = $utility::truncateHtml($ret['desc'], $editorMaxchar);
        $classification        = $this->getVar('acc_classification');
        $ret['classification'] = $classification;
        switch ($classification) {
            case Constants::CLASS_BOTH:
            default:
                $class_text = \_MA_WGSIMPLEACC_CLASS_BOTH;
                break;
            case Constants::CLASS_EXPENSES:
                $class_text = \_MA_WGSIMPLEACC_CLASS_EXPENSES;
                break;
            case Constants::CLASS_INCOME:
                $class_text = \_MA_WGSIMPLEACC_CLASS_INCOME;
                break;
        }
        $ret['class_text']  = $class_text;
        $ret['color']          = $this->getVar('acc_color');
        $ret['iecalc']         = (int)$this->getVar('acc_iecalc') > 0 ? _YES : _NO;
        $ret['online']         = (int)$this->getVar('acc_online') > 0 ? _YES : _NO;
        $ret['level']          = $this->getVar('acc_level');
        $ret['weight']         = $this->getVar('acc_weight');
        $ret['datecreated']    = \formatTimestamp($this->getVar('acc_datecreated'), 's');
        $ret['submitter']      = \XoopsUser::getUnameFromId($this->getVar('acc_submitter'));
        return $ret;
	}

	/**
	 * Returns an array representation of the object
	 *
	 * @return array
	 */
	public function toArrayAccounts()
	{
		$ret = [];
		$vars = $this->getVars();
		foreach (\array_keys($vars) as $var) {
			$ret[$var] = $this->getVar('"{$var}"');
		}
		return $ret;
	}
}
