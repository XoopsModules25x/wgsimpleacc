<?php

declare(strict_types=1);


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
 * @author         XOOPS Development Team - Email:<webmaster@wedega.com> - Website:<https://xoops.wedega.com>
 */

use XoopsModules\Wgsimpleacc;

\defined('\XOOPS_ROOT_PATH') || die('Restricted access');

/**
 * Class Object Clients
 */
class Processing extends \XoopsObject
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->initVar('pro_id', \XOBJ_DTYPE_INT);
        $this->initVar('pro_text', \XOBJ_DTYPE_TXTBOX);
        $this->initVar('pro_income', \XOBJ_DTYPE_INT);
        $this->initVar('pro_expenses', \XOBJ_DTYPE_INT);
        $this->initVar('pro_weight', \XOBJ_DTYPE_INT);
        $this->initVar('pro_online', \XOBJ_DTYPE_INT);
        $this->initVar('pro_default', \XOBJ_DTYPE_INT);
        $this->initVar('pro_datecreated', \XOBJ_DTYPE_INT);
        $this->initVar('pro_submitter', \XOBJ_DTYPE_INT);
    }

    /**
     * @static function &getInstance
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
     * @return int
     */
    public function getNewInsertedIdProcessing()
    {
        return $GLOBALS['xoopsDB']->getInsertId();
    }

    /**
     * @public function getForm
     * @param bool $action
     * @return \XoopsThemeForm
     */
    public function getFormProcessing($action = false)
    {
        $helper = \XoopsModules\Wgsimpleacc\Helper::getInstance();
        if (!$action) {
            $action = $_SERVER['REQUEST_URI'];
        }
        $isAdmin = $GLOBALS['xoopsUser']->isAdmin($GLOBALS['xoopsModule']->mid());
        if ($isAdmin) {
            $editor = $helper->getConfig('editor_admin');
        } else {
            $editor = $helper->getConfig('editor_user');
        }

        // Title
        $title = $this->isNew() ? \_MA_WGSIMPLEACC_PROCESSING_ADD : \_MA_WGSIMPLEACC_PROCESSING_EDIT;
        // Get Theme Form
        \xoops_load('XoopsFormLoader');
        $form = new \XoopsThemeForm($title, 'form', $action, 'post', true);
        $form->setExtra('enctype="multipart/form-data"');
        // Form Text proText
        $form->addElement(new \XoopsFormText(\_MA_WGSIMPLEACC_PROCESSING_TEXT, 'pro_text', 50, 255, $this->getVar('pro_text')));
        // Form Radio Yes/No proIncome
        $proIncome = $this->isNew() ? 0 : $this->getVar('pro_income');
        $form->addElement(new \XoopsFormRadioYN(\_MA_WGSIMPLEACC_PROCESSING_INCOME, 'pro_income', $proIncome));
        // Form Radio Yes/No proExpenses
        $proExpenses = $this->isNew() ? 0 : $this->getVar('pro_expenses');
        $form->addElement(new \XoopsFormRadioYN(\_MA_WGSIMPLEACC_PROCESSING_EXPENSES, 'pro_expenses', $proExpenses));
        // Form Text proWeight
        $form->addElement(new \XoopsFormText(\_MA_WGSIMPLEACC_PROCESSING_WEIGHT, 'pro_weight', 10, 255, $this->getVar('pro_weight')));
        // Form Radio Yes/No proOnline
        $proOnline = $this->isNew() ? 0 : $this->getVar('pro_online');
        $form->addElement(new \XoopsFormRadioYN(\_MA_WGSIMPLEACC_PROCESSING_ONLINE, 'pro_online', $proOnline));
        // Form Radio Yes/No proDefault
        $proDefault = $this->isNew() ? 0 : $this->getVar('pro_default');
        $form->addElement(new \XoopsFormRadioYN(\_MA_WGSIMPLEACC_PROCESSING_DEFAULT, 'pro_default', $proDefault));
        // Form Text Date Select proDatecreated
        // Form Select User proSubmitter
        $proDatecreated = $this->isNew() ? \time() : $this->getVar('pro_datecreated');
        $proSubmitter = $this->isNew() ? $GLOBALS['xoopsUser']->uid() : $this->getVar('pro_submitter');
        if ($isAdmin) {
            $form->addElement(new \XoopsFormTextDateSelect(\_MA_WGSIMPLEACC_DATECREATED, 'pro_datecreated', '', $proDatecreated));
            $form->addElement(new \XoopsFormSelectUser(\_MA_WGSIMPLEACC_SUBMITTER, 'pro_submitter', false, $proSubmitter));
        } else {
            $form->addElement(new \XoopsFormLabel(\_MA_WGSIMPLEACC_DATECREATED, \formatTimestamp($proDatecreated, 's')));
            $form->addElement(new \XoopsFormHidden('pro_datecreated_int', \time()));
            $form->addElement(new \XoopsFormLabel(\_MA_WGSIMPLEACC_SUBMITTER, \XoopsUser::getUnameFromId($proSubmitter)));
            $form->addElement(new \XoopsFormHidden('pro_submitter', $GLOBALS['xoopsUser']->uid()));
        }
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
    public function getValuesProcessing($keys = null, $format = null, $maxDepth = null)
    {
        $helper  = \XoopsModules\Wgsimpleacc\Helper::getInstance();
        $utility = new \XoopsModules\Wgsimpleacc\Utility();
        $ret = $this->getValues($keys, $format, $maxDepth);
        $ret['id']            = $this->getVar('pro_id');
        $ret['text']          = $this->getVar('pro_text');
        $editorMaxchar = $helper->getConfig('editor_maxchar');
        $ret['text_short']    = $utility::truncateHtml($ret['text'], $editorMaxchar);
        $ret['weight']      = (int)$this->getVar('pro_weight');
        $ret['income']      = (int)$this->getVar('pro_income') > 0 ? \_YES : \_NO;
        $ret['expenses']        = (int)$this->getVar('pro_expenses') > 0 ? \_YES : \_NO;
        $ret['online']        = (int)$this->getVar('pro_online') > 0 ? \_YES : \_NO;
        $ret['default']        = (int)$this->getVar('pro_default') > 0 ? \_YES : \_NO;
        $ret['datecreated']   = \formatTimestamp($this->getVar('pro_datecreated'), 's');
        $ret['submitter']     = \XoopsUser::getUnameFromId($this->getVar('pro_submitter'));

        return $ret;
    }

    /**
     * Returns an array representation of the object
     *
     * @return array
     */
    public function toArrayProcessing()
    {
        $ret = [];
        $vars = $this->getVars();
        foreach (\array_keys($vars) as $var) {
            $ret[$var] = $this->getVar('"{$var}"');
        }
        return $ret;
    }
}
