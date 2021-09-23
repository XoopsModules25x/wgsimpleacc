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
        $this->initVar('otpl_header', \XOBJ_DTYPE_OTHER);
        $this->initVar('otpl_body', \XOBJ_DTYPE_OTHER);
        $this->initVar('otpl_footer', \XOBJ_DTYPE_OTHER);
        $this->initVar('otpl_type', \XOBJ_DTYPE_INT);
        $this->initVar('otpl_allid', \XOBJ_DTYPE_OTHER);
        $this->initVar('otpl_accid', \XOBJ_DTYPE_OTHER);
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
        if ($isAdmin) {
            $editor = $helper->getConfig('editor_admin');
        } else {
            $editor = $helper->getConfig('editor_user');
        }

        // Title
        $title = $this->isNew() ? \sprintf(\_MA_WGSIMPLEACC_OUTTEMPLATE_ADD) : \sprintf(\_MA_WGSIMPLEACC_OUTTEMPLATE_EDIT);
        // Get Theme Form
        \xoops_load('XoopsFormLoader');
        $form = new \XoopsThemeForm($title, 'form', $action, 'post', true);
        $form->setExtra('enctype="multipart/form-data"');
        // Form Text otplName
        $form->addElement(new \XoopsFormText(\_MA_WGSIMPLEACC_OUTTEMPLATE_NAME, 'otpl_name', 50, 255, $this->getVar('otpl_name')), true);
        // Form Select otplType
        $otplTypeSelect = new \XoopsFormSelect(\_MA_WGSIMPLEACC_OUTTEMPLATE_TYPE, 'otpl_type', $this->getVar('otpl_type'));
        $otplTypeSelect->addOption(Constants::OUTTEMPLATE_TYPE_READY, \_MA_WGSIMPLEACC_OUTTEMPLATE_TYPE_READY);
        $otplTypeSelect->addOption(Constants::OUTTEMPLATE_TYPE_BROWSER, \_MA_WGSIMPLEACC_OUTTEMPLATE_TYPE_BROWSER);
        $otplTypeSelect->addOption(Constants::OUTTEMPLATE_TYPE_FORM, \_MA_WGSIMPLEACC_OUTTEMPLATE_TYPE_FORM);
        $otplTypeSelect->setDescription(\_MA_WGSIMPLEACC_OUTTEMPLATE_TYPE_DESC);
        $form->addElement($otplTypeSelect);
        // Form Editor DhtmlTextArea otplHeader
        $editorConfigs1 = [];
        $editorConfigs1['name'] = 'otpl_header';
        $editorConfigs1['value'] = $this->getVar('otpl_header', 'e');
        $editorConfigs1['rows'] = 5;
        $editorConfigs1['cols'] = 40;
        $editorConfigs1['width'] = '100%';
        $editorConfigs1['height'] = '400px';
        $editorConfigs1['editor'] = $editor;
        $otplHeader = new \XoopsFormEditor(\_MA_WGSIMPLEACC_OUTTEMPLATE_HEADER, 'otpl_header', $editorConfigs1);
        $form->addElement($otplHeader);
        // Form Editor DhtmlTextArea otplBody
        $editorConfigs2 = [];
        $editorConfigs2['name'] = 'otpl_body';
        $editorConfigs2['value'] = $this->getVar('otpl_body', 'e');
        $editorConfigs2['rows'] = 5;
        $editorConfigs2['cols'] = 40;
        $editorConfigs2['width'] = '100%';
        $editorConfigs2['height'] = '400px';
        $editorConfigs2['editor'] = $editor;
        $otplBody = new \XoopsFormEditor(\_MA_WGSIMPLEACC_OUTTEMPLATE_BODY, 'otpl_body', $editorConfigs2);
        $form->addElement($otplBody);
        // Form Editor DhtmlTextArea $otplFooter
        $editorConfigs3 = [];
        $editorConfigs3['name'] = 'otpl_footer';
        $editorConfigs3['value'] = $this->getVar('otpl_footer', 'e');
        $editorConfigs3['rows'] = 5;
        $editorConfigs3['cols'] = 40;
        $editorConfigs3['width'] = '100%';
        $editorConfigs3['height'] = '400px';
        $editorConfigs3['editor'] = $editor;
        $otplFooter = new \XoopsFormEditor(\_MA_WGSIMPLEACC_OUTTEMPLATE_FOOTER, 'otpl_footer', $editorConfigs3);
        $form->addElement($otplFooter);
        //smarty description
        $form->addElement(new \XoopsFormLabel(\_MA_WGSIMPLEACC_OUTTEMPLATE_SMARTY, _MA_WGSIMPLEACC_OUTTEMPLATE_SMARTY_DESC));
        // Form Select otplAllid

        $otplAllid = $this->isNew() ? 0 : unserialize($this->getVar('otpl_allid'));
        $allocationsHandler = $helper->getHandler('Allocations');
        $otplAllidSelect = new \XoopsFormSelect(\_MA_WGSIMPLEACC_OUTTEMPLATE_ALLID, 'otpl_allid', $otplAllid, 10, true);
        $otplAllidSelect->addOption(Constants::OUTTEMPLATE_ALL, \_MA_WGSIMPLEACC_OUTTEMPLATE_ALL);
        //$otplAllidSelect->addOptionArray($allocationsHandler->getList());
        $allocations = $allocationsHandler->getSelectTreeOfAllocations();
        foreach ($allocations as $allocation) {
            $otplAllidSelect->addOption($allocation['id'], $allocation['text']);
        }
        $form->addElement($otplAllidSelect);
        // Form Select otplAccid
        $otplAccid = $this->isNew() ? 0 : unserialize($this->getVar('otpl_accid'));
        $accountsHandler = $helper->getHandler('Accounts');
        $otplAccidSelect = new \XoopsFormSelect(\_MA_WGSIMPLEACC_OUTTEMPLATE_ACCID, 'otpl_accid', $otplAccid, 10, true);
        $otplAccidSelect->addOption(Constants::OUTTEMPLATE_ALL, \_MA_WGSIMPLEACC_OUTTEMPLATE_ALL);
        $accounts = $accountsHandler->getSelectTreeOfAccounts(Constants::CLASS_BOTH);
        foreach ($accounts as $account) {
            $otplAccidSelect->addOption($account['id'], $account['text']);
        }
        $form->addElement($otplAccidSelect);
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
        $ret = $this->getValues($keys, $format, $maxDepth);
        $ret['id']   = $this->getVar('otpl_id');
        $ret['name'] = $this->getVar('otpl_name');
        $ret['type'] = $this->getVar('otpl_type');
        switch ($ret['type']) {
            case 'default':
            default:
                $typeText = '';
            break;
            case Constants::OUTTEMPLATE_TYPE_FORM;
                $typeText = _MA_WGSIMPLEACC_OUTTEMPLATE_TYPE_FORM;
            break;
            case Constants::OUTTEMPLATE_TYPE_READY;
                $typeText = _MA_WGSIMPLEACC_OUTTEMPLATE_TYPE_READY;
            break;
            case Constants::OUTTEMPLATE_TYPE_BROWSER;
                $typeText = _MA_WGSIMPLEACC_OUTTEMPLATE_TYPE_BROWSER;
                break;
        }
        $ret['type_text'] = $typeText;
        $ret['header']    = $this->getVar('otpl_header', 'e');
        $ret['body']      = $this->getVar('otpl_body', 'e');
        $ret['footer']    = $this->getVar('otpl_footer', 'e');
        $arrAllid  = unserialize($this->getVar('otpl_allid'));
        $otplAllid = '';
        if (0 == (int)$arrAllid[0]) {
            $otplAllid .= \_MA_WGSIMPLEACC_OUTTEMPLATE_ALL;
        } else {
            $otplAllid .= '<ul>';
            $allocationsHandler = $helper->getHandler('Allocations');
            $allocationsAll     = $allocationsHandler->getAllAllocations();
            foreach (\array_keys($allocationsAll) as $i) {
                if(\in_array($allocationsAll[$i]->getVar('all_id'),$arrAllid)) {
                    $otplAllid .= '<li>' . $allocationsAll[$i]->getVar('all_name') . '</li>';
                }
            }
            $otplAllid .= '</ul>';
        }
        $ret['allid']       = $otplAllid;
        $arrAccid  = unserialize($this->getVar('otpl_accid'));
        $otplAccid = '';
        if (0 == (int)$arrAccid[0]) {
            $otplAccid .= \_MA_WGSIMPLEACC_OUTTEMPLATE_ALL;
        } else {
            $otplAccid .= '<ul>';
            $accountsHandler = $helper->getHandler('Accounts');
            $accountsAll     = $accountsHandler->getAllAccounts();
            foreach (\array_keys($accountsAll) as $i) {
                if(\in_array($accountsAll[$i]->getVar('acc_id'),$arrAccid)) {
                    $otplAccid .= '<li>' . $accountsAll[$i]->getVar('acc_name') . '</li>';
                }
            }
            $otplAccid .= '</ul>';
        }
        $ret['accid']       = $otplAccid;
        $ret['online']      = (int)$this->getVar('otpl_online') > 0 ? \_YES : \_NO;
        $ret['datecreated'] = \formatTimestamp($this->getVar('otpl_datecreated'), 's');
        $ret['submitter']   = \XoopsUser::getUnameFromId($this->getVar('otpl_submitter'));
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
