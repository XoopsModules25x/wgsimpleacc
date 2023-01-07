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
 * @author         Goffy - XOOPS Development Team - Email:<webmaster@wedega.com> - Website:<https://xoops.wedega.com>
 */

use XoopsModules\Wgsimpleacc;

\defined('\XOOPS_ROOT_PATH') || die('Restricted access');

/**
 * Class Object Currencies
 */
class Currencies extends \XoopsObject
{
    /**
     * Constructor
     *
     * @param null
     */
    public function __construct()
    {
        $this->initVar('cur_id', \XOBJ_DTYPE_INT);
        $this->initVar('cur_code', \XOBJ_DTYPE_TXTBOX);
        $this->initVar('cur_name', \XOBJ_DTYPE_TXTBOX);
        $this->initVar('cur_datecreated', \XOBJ_DTYPE_INT);
        $this->initVar('cur_submitter', \XOBJ_DTYPE_INT);
        $this->initVar('cur_primary', \XOBJ_DTYPE_INT);
        $this->initVar('cur_online', \XOBJ_DTYPE_INT);
        $this->initVar('cur_symbol', \XOBJ_DTYPE_TXTBOX);
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
    public function getNewInsertedIdCurrencies()
    {
        return $GLOBALS['xoopsDB']->getInsertId();
    }

    /**
     * @public function getForm
     * @param bool $action
     * @return \XoopsThemeForm
     */
    public function getFormCurrencies($action = false)
    {
        //$helper = \XoopsModules\Wgsimpleacc\Helper::getInstance();
        if (!$action) {
            $action = $_SERVER['REQUEST_URI'];
        }
        // Title
        $title = $this->isNew() ? \_AM_WGSIMPLEACC_CURRENCY_ADD : \_AM_WGSIMPLEACC_CURRENCY_EDIT;
        // Get Theme Form
        \xoops_load('XoopsFormLoader');
        $form = new \XoopsThemeForm($title, 'form', $action, 'post', true);
        $form->setExtra('enctype="multipart/form-data"');
        // Form Text curSymbol
        $form->addElement(new \XoopsFormText(\_AM_WGSIMPLEACC_CURRENCY_SYMBOL, 'cur_symbol', 50, 255, $this->getVar('cur_symbol')));
        // Form Text curCode
        $form->addElement(new \XoopsFormText(\_AM_WGSIMPLEACC_CURRENCY_CODE, 'cur_code', 50, 255, $this->getVar('cur_code')), true);
        // Form Text curName
        $form->addElement(new \XoopsFormText(\_AM_WGSIMPLEACC_CURRENCY_NAME, 'cur_name', 50, 255, $this->getVar('cur_name')));
        // Form Radio Yes/No asPrimary
        $curPrimary = $this->isNew() ?: $this->getVar('cur_primary');
        $form->addElement(new \XoopsFormRadioYN(\_AM_WGSIMPLEACC_CURRENCY_PRIMARY, 'cur_primary', $curPrimary));
        // Form Radio Yes/No curOnline
        $curOnline = $this->isNew() ?: $this->getVar('cur_online');
        $form->addElement(new \XoopsFormRadioYN(\_AM_WGSIMPLEACC_CURRENCY_ONLINE, 'cur_online', $curOnline));
        // Form Text Date Select curDatecreated
        $curDatecreated = $this->isNew() ?: $this->getVar('cur_datecreated');
        $form->addElement(new \XoopsFormTextDateSelect(\_MA_WGSIMPLEACC_DATECREATED, 'cur_datecreated', '', $curDatecreated));
        // Form Select User curSubmitter
        $form->addElement(new \XoopsFormSelectUser(\_MA_WGSIMPLEACC_SUBMITTER, 'cur_submitter', false, $this->getVar('cur_submitter')));
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
    public function getValuesCurrencies($keys = null, $format = null, $maxDepth = null)
    {
        $ret = $this->getValues($keys, $format, $maxDepth);
        $ret['id']          = $this->getVar('cur_id');
        $ret['code']        = $this->getVar('cur_code');
        $ret['name']        = $this->getVar('cur_name');
        $ret['datecreated'] = \formatTimestamp($this->getVar('cur_datecreated'), 's');
        $ret['submitter']   = \XoopsUser::getUnameFromId($this->getVar('cur_submitter'));
        $ret['primary']     = (int)$this->getVar('cur_primary') > 0 ? \_YES : \_NO;
        $ret['online']      = (int)$this->getVar('cur_online') > 0 ? \_YES : \_NO;
        $ret['symbol']      = $this->getVar('cur_symbol');
        return $ret;
    }

    /**
     * Returns an array representation of the object
     *
     * @return array
     */
    public function toArrayCurrencies()
    {
        $ret = [];
        $vars = $this->getVars();
        foreach (\array_keys($vars) as $var) {
            $ret[$var] = $this->getVar('"{$var}"');
        }
        return $ret;
    }
}
