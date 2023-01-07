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
 * Class Object Taxes
 */
class Taxes extends \XoopsObject
{
    /**
     * Constructor
     *
     * @param null
     */
    public function __construct()
    {
        $this->initVar('tax_id', \XOBJ_DTYPE_INT);
        $this->initVar('tax_name', \XOBJ_DTYPE_TXTBOX);
        $this->initVar('tax_rate', \XOBJ_DTYPE_INT);
        $this->initVar('tax_online', \XOBJ_DTYPE_INT);
        $this->initVar('tax_primary', \XOBJ_DTYPE_INT);
        $this->initVar('tax_datecreated', \XOBJ_DTYPE_INT);
        $this->initVar('tax_submitter', \XOBJ_DTYPE_INT);
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
    public function getNewInsertedIdTaxes()
    {
        return $GLOBALS['xoopsDB']->getInsertId();
    }

    /**
     * @public function getForm
     * @param bool $action
     * @return \XoopsThemeForm
     */
    public function getFormTaxes($action = false)
    {
        //$helper = \XoopsModules\Wgsimpleacc\Helper::getInstance();
        if (!$action) {
            $action = $_SERVER['REQUEST_URI'];
        }
        // Title
        $title = $this->isNew() ? \_AM_WGSIMPLEACC_TAX_ADD : \_AM_WGSIMPLEACC_TAX_EDIT;
        // Get Theme Form
        \xoops_load('XoopsFormLoader');
        $form = new \XoopsThemeForm($title, 'form', $action, 'post', true);
        $form->setExtra('enctype="multipart/form-data"');
        // Form Text taxName
        $form->addElement(new \XoopsFormText(\_AM_WGSIMPLEACC_TAX_NAME, 'tax_name', 50, 255, $this->getVar('tax_name')), true);
        // Form Text taxRate
        $taxRate = $this->isNew() ? '0' : $this->getVar('tax_rate');
        $form->addElement(new \XoopsFormText(\_AM_WGSIMPLEACC_TAX_RATE, 'tax_rate', 20, 150, $taxRate), true);
        // Form Radio Yes/No taxOnline
        $taxOnline = $this->isNew() ?: $this->getVar('tax_online');
        $form->addElement(new \XoopsFormRadioYN(\_AM_WGSIMPLEACC_TAX_ONLINE, 'tax_online', $taxOnline));
        // Form Radio Yes/No taxPrimary
        $taxPrimary = $this->isNew() ?: $this->getVar('tax_primary');
        $form->addElement(new \XoopsFormRadioYN(\_AM_WGSIMPLEACC_TAX_PRIMARY, 'tax_primary', $taxPrimary));
        // Form Text Date Select taxDatecreated
        $taxDatecreated = $this->isNew() ?: $this->getVar('tax_datecreated');
        $form->addElement(new \XoopsFormTextDateSelect(\_MA_WGSIMPLEACC_DATECREATED, 'tax_datecreated', '', $taxDatecreated));
        // Form Select User taxSubmitter
        $form->addElement(new \XoopsFormSelectUser(\_MA_WGSIMPLEACC_SUBMITTER, 'tax_submitter', false, $this->getVar('tax_submitter')));
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
    public function getValuesTaxes($keys = null, $format = null, $maxDepth = null)
    {
        $ret = $this->getValues($keys, $format, $maxDepth);
        $ret['id']          = $this->getVar('tax_id');
        $ret['name']        = $this->getVar('tax_name');
        $ret['rate']        = $this->getVar('tax_rate');
        $ret['online']      = (int)$this->getVar('tax_online') > 0 ? \_YES : \_NO;
        $ret['primary']     = (int)$this->getVar('tax_primary') > 0 ? \_YES : \_NO;
        $ret['datecreated'] = \formatTimestamp($this->getVar('tax_datecreated'), 's');
        $ret['submitter']   = \XoopsUser::getUnameFromId($this->getVar('tax_submitter'));

        return $ret;
    }

    /**
     * Returns an array representation of the object
     *
     * @return array
     */
    public function toArrayTaxes()
    {
        $ret = [];
        $vars = $this->getVars();
        foreach (\array_keys($vars) as $var) {
            $ret[$var] = $this->getVar('"{$var}"');
        }
        return $ret;
    }
}
