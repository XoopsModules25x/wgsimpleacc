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
 * @since          1.0
 * @min_xoops      2.5.10
 * @author         XOOPS Development Team - Email:<webmaster@wedega.com> - Website:<https://xoops.wedega.com>
 */

use XoopsModules\Wgsimpleacc;

\defined('\XOOPS_ROOT_PATH') || die('Restricted access');

/**
 * Class Object Clients
 */
class Clients extends \XoopsObject
{
    /**
     * Constructor
     *
     * @param null
     */
    public function __construct()
    {
        $this->initVar('cli_id', \XOBJ_DTYPE_INT);
        $this->initVar('cli_name', \XOBJ_DTYPE_OTHER);
        $this->initVar('cli_postal', \XOBJ_DTYPE_TXTBOX);
        $this->initVar('cli_city', \XOBJ_DTYPE_TXTBOX);
        $this->initVar('cli_address', \XOBJ_DTYPE_OTHER);
        $this->initVar('cli_ctry', \XOBJ_DTYPE_TXTBOX);
        $this->initVar('cli_phone', \XOBJ_DTYPE_TXTBOX);
        $this->initVar('cli_vat', \XOBJ_DTYPE_TXTBOX);
        $this->initVar('cli_creditor', \XOBJ_DTYPE_INT);
        $this->initVar('cli_debtor', \XOBJ_DTYPE_INT);
        $this->initVar('cli_online', \XOBJ_DTYPE_INT);
        $this->initVar('cli_datecreated', \XOBJ_DTYPE_INT);
        $this->initVar('cli_submitter', \XOBJ_DTYPE_INT);
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
    public function getNewInsertedIdClients()
    {
        $newInsertedId = $GLOBALS['xoopsDB']->getInsertId();
        return $newInsertedId;
    }

    /**
     * @public function getForm
     * @param bool $action
     * @return \XoopsThemeForm
     */
    public function getFormClients($action = false)
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
        $title = $this->isNew() ? \sprintf(\_MA_WGSIMPLEACC_CLIENT_ADD) : \sprintf(\_MA_WGSIMPLEACC_CLIENT_EDIT);
        // Get Theme Form
        \xoops_load('XoopsFormLoader');
        $form = new \XoopsThemeForm($title, 'form', $action, 'post', true);
        $form->setExtra('enctype="multipart/form-data"');
        // Form Editor DhtmlTextArea cliName
        $editorConfigs1 = [];
        $editorConfigs1['name'] = 'cli_name';
        $editorConfigs1['value'] = $this->getVar('cli_name', 'e');
        $editorConfigs1['rows'] = 5;
        $editorConfigs1['cols'] = 40;
        $editorConfigs1['width'] = '100%';
        $editorConfigs1['height'] = '400px';
        $editorConfigs1['editor'] = $editor;
        $cliName = new \XoopsFormEditor(\_MA_WGSIMPLEACC_CLIENT_NAME, 'cli_name', $editorConfigs1);
        $form->addElement($cliName);
        // Form Text cliPostal
        $form->addElement(new \XoopsFormText(\_MA_WGSIMPLEACC_CLIENT_POSTAL, 'cli_postal', 50, 255, $this->getVar('cli_postal')));
        // Form Text cliCity
        $form->addElement(new \XoopsFormText(\_MA_WGSIMPLEACC_CLIENT_CITY, 'cli_city', 50, 255, $this->getVar('cli_city')));
        // Form Editor DhtmlTextArea cliAddress
        $editorConfigs2 = [];
        $editorConfigs2['name'] = 'cli_address';
        $editorConfigs2['value'] = $this->getVar('cli_address', 'e');
        $editorConfigs2['rows'] = 5;
        $editorConfigs2['cols'] = 40;
        $editorConfigs2['width'] = '100%';
        $editorConfigs2['height'] = '400px';
        $editorConfigs2['editor'] = $editor;
        $cliAddress = new \XoopsFormEditor(\_MA_WGSIMPLEACC_CLIENT_ADDRESS, 'cli_address', $editorConfigs2);
        $form->addElement($cliAddress);
        // Form Select Country cliCtry
        $cliCtrySelect = new \XoopsFormSelect(\_MA_WGSIMPLEACC_CLIENT_CTRY, 'cli_ctry', $this->getVar('cli_ctry'));
        $cliCtrySelect->addOption('', _NONE);
        $countryArray = \XoopsLists::getCountryList();
        $cliCtrySelect->addOptionArray($countryArray);
        $form->addElement($cliCtrySelect);
        // Form Text cliPhone
        $form->addElement(new \XoopsFormText(\_MA_WGSIMPLEACC_CLIENT_PHONE, 'cli_phone', 50, 255, $this->getVar('cli_phone')));
        // Form Text cliVat
        $form->addElement(new \XoopsFormText(\_MA_WGSIMPLEACC_CLIENT_VAT, 'cli_vat', 50, 255, $this->getVar('cli_vat')));
        // Form Radio Yes/No cliCreditor
        $cliCreditor = $this->isNew() ?: $this->getVar('cli_creditor');
        $form->addElement(new \XoopsFormRadioYN(\_MA_WGSIMPLEACC_CLIENT_CREDITOR, 'cli_creditor', $cliCreditor));
        // Form Radio Yes/No cliDebtor
        $cliDebtor = $this->isNew() ?: $this->getVar('cli_debtor');
        $form->addElement(new \XoopsFormRadioYN(\_MA_WGSIMPLEACC_CLIENT_DEBTOR, 'cli_debtor', $cliDebtor));
        // Form Radio Yes/No cliOnline
        $cliOnline = $this->isNew() ?: $this->getVar('cli_online');
        $form->addElement(new \XoopsFormRadioYN(\_MA_WGSIMPLEACC_CLIENT_ONLINE, 'cli_online', $cliOnline));
        // Form Text Date Select cliDatecreated
        // Form Select User cliSubmitter
        $cliDatecreated = $this->isNew() ? \time() : $this->getVar('cli_datecreated');
        $cliSubmitter = $this->isNew() ? $GLOBALS['xoopsUser']->uid() : $this->getVar('cli_submitter');
        if ($isAdmin) {
            $form->addElement(new \XoopsFormTextDateSelect(\_MA_WGSIMPLEACC_DATECREATED, 'cli_datecreated', '', $cliDatecreated));
            $form->addElement(new \XoopsFormSelectUser(\_MA_WGSIMPLEACC_SUBMITTER, 'cli_submitter', false, $cliSubmitter));
        } else {
            $form->addElement(new \XoopsFormLabel(\_MA_WGSIMPLEACC_DATECREATED, \formatTimestamp($cliDatecreated, 's')));
            $form->addElement(new \XoopsFormHidden('cli_datecreated', \time()));
            $form->addElement(new \XoopsFormLabel(\_MA_WGSIMPLEACC_SUBMITTER, \XoopsUser::getUnameFromId($cliSubmitter)));
            $form->addElement(new \XoopsFormHidden('as_submitter', $GLOBALS['xoopsUser']->uid()));
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
    public function getValuesClients($keys = null, $format = null, $maxDepth = null)
    {
        $helper  = \XoopsModules\Wgsimpleacc\Helper::getInstance();
        $utility = new \XoopsModules\Wgsimpleacc\Utility();
        $ret = $this->getValues($keys, $format, $maxDepth);
        $ret['id']            = $this->getVar('cli_id');
        $ret['name']          = $this->getVar('cli_name', 'e');
        $editorMaxchar = $helper->getConfig('editor_maxchar');
        $ret['name_short']    = $utility::truncateHtml($ret['name'], $editorMaxchar);
        $fullAddress          = '';
        $ret['ctry']          = $this->getVar('cli_ctry');
        if ('' !== $this->getVar('cli_ctry')) {
            $fullAddress .= $this->getVar('cli_ctry');
        }
        $ret['postal']        = $this->getVar('cli_postal');
        if ('' !== $this->getVar('cli_postal')) {
            if ('' !== $fullAddress) {
                $fullAddress .= ' ';
            }
            $fullAddress .= $this->getVar('cli_postal');
        }
        $ret['city']          = $this->getVar('cli_city');
        if ('' !== $this->getVar('cli_city')) {
            if ('' !== $fullAddress) {
                $fullAddress .= ' ';
            }
            $fullAddress .= $this->getVar('cli_city');
        }
        $ret['address'] = $this->getVar('cli_address', 'e');
        if ('' !== $fullAddress) {
            $fullAddress = '<p>' . $fullAddress . '</p>';
        }
        if ('' !== $this->getVar('cli_address')) {
            $fullAddress .= $ret['address'];
        }
        $ret['fulladdress']   = $fullAddress;
        $ret['address_short'] = $utility::truncateHtml($ret['address'], $editorMaxchar);
        $ret['phone']         = $this->getVar('cli_phone');
        $ret['vat']           = $this->getVar('cli_vat');
        $ret['creditor']      = (int)$this->getVar('cli_creditor') > 0 ? _YES : _NO;
        $ret['debtor']        = (int)$this->getVar('cli_debtor') > 0 ? _YES : _NO;
        $ret['online']        = (int)$this->getVar('cli_online') > 0 ? _YES : _NO;
        $ret['datecreated']   = \formatTimestamp($this->getVar('cli_datecreated'), 's');
        $ret['submitter']     = \XoopsUser::getUnameFromId($this->getVar('cli_submitter'));

        return $ret;
    }

    /**
     * Returns an array representation of the object
     *
     * @return array
     */
    public function toArrayClients()
    {
        $ret = [];
        $vars = $this->getVars();
        foreach (\array_keys($vars) as $var) {
            $ret[$var] = $this->getVar('"{$var}"');
        }
        return $ret;
    }
}
