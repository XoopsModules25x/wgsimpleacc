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
 * Class Object Transactions
 */
class Transactions extends \XoopsObject
{
	/**
	 * Constructor
	 *
	 * @param null
	 */
	public function __construct()
	{
		$this->initVar('tra_id', \XOBJ_DTYPE_INT);
        $this->initVar('tra_year', \XOBJ_DTYPE_INT);
        $this->initVar('tra_nb', \XOBJ_DTYPE_INT);
		$this->initVar('tra_desc', \XOBJ_DTYPE_OTHER);
		$this->initVar('tra_reference', \XOBJ_DTYPE_TXTBOX);
        $this->initVar('tra_remarks', \XOBJ_DTYPE_OTHER);
		$this->initVar('tra_accid', \XOBJ_DTYPE_INT);
		$this->initVar('tra_allid', \XOBJ_DTYPE_INT);
		$this->initVar('tra_date', \XOBJ_DTYPE_INT);
		$this->initVar('tra_curid', \XOBJ_DTYPE_INT);
		$this->initVar('tra_amountin', \XOBJ_DTYPE_DECIMAL);
		$this->initVar('tra_amountout', \XOBJ_DTYPE_DECIMAL);
		$this->initVar('tra_taxid', \XOBJ_DTYPE_INT);
        $this->initVar('tra_asid', \XOBJ_DTYPE_INT);
		$this->initVar('tra_status', \XOBJ_DTYPE_INT);
		$this->initVar('tra_comments', \XOBJ_DTYPE_INT);
        $this->initVar('tra_class', \XOBJ_DTYPE_INT);
        $this->initVar('tra_balid', \XOBJ_DTYPE_INT);
		$this->initVar('tra_datecreated', \XOBJ_DTYPE_INT);
		$this->initVar('tra_submitter', \XOBJ_DTYPE_INT);
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
	public function getNewInsertedIdTransactions()
	{
		$newInsertedId = $GLOBALS['xoopsDB']->getInsertId();
		return $newInsertedId;
	}

    /**
     * @public function getForm
     * @param bool $action
     * @param bool $admin
     * @param int  $type
     * @param int  $start
     * @param int  $limit
     * @param bool $approve
     * @return \XoopsThemeForm
     */
	public function getFormTransactions($action = false, $admin = false, $type = 0, $start = 0, $limit = 0, $approve = false)
	{
		$helper = \XoopsModules\Wgsimpleacc\Helper::getInstance();
		if (!$action) {
			$action = $_SERVER['REQUEST_URI'];
		}
        $isAdmin = $GLOBALS['xoopsUser']->isAdmin($GLOBALS['xoopsModule']->mid());
        $traClass = $this->isNew() ? $type : $this->getVar('tra_class');
        // Title
        $title = $this->isNew() ? \sprintf(\_MA_WGSIMPLEACC_TRANSACTION_ADD) : \sprintf(\_MA_WGSIMPLEACC_TRANSACTION_EDIT);
        if (Constants::CLASS_INCOME == $traClass || Constants::CLASS_BOTH == $traClass) {
            $title = $this->isNew() ? \sprintf(\_MA_WGSIMPLEACC_TRANSACTION_ADD_INCOME) : \sprintf(\_MA_WGSIMPLEACC_TRANSACTION_EDIT_INCOME);
        }
        if (Constants::CLASS_EXPENSES == $traClass || Constants::CLASS_BOTH == $traClass) {
            $title = $this->isNew() ? \sprintf(\_MA_WGSIMPLEACC_TRANSACTION_ADD_EXPENSES) : \sprintf(\_MA_WGSIMPLEACC_TRANSACTION_EDIT_EXPENSES);
        }
		// Get Theme Form
		\xoops_load('XoopsFormLoader');
		$form = new \XoopsThemeForm($title, 'formTransaction', $action, 'post', true);
		$form->setExtra('enctype="multipart/form-data"');
        $permissionsHandler = $helper->getHandler('Permissions');
		if ($permissionsHandler->getPermTratemplatesView()) {
            // Form Table Tratemplates
            $tratemplatesHandler = $helper->getHandler('Tratemplates');
            $form->addElement(new \XoopsFormHidden('ttpl_desc[0]', ''));
            $form->addElement(new \XoopsFormHidden('ttpl_accid[0]', '0'));
            $form->addElement(new \XoopsFormHidden('ttpl_allid[0]', '0'));
            $form->addElement(new \XoopsFormHidden('ttpl_asid[0]', '0'));
            $form->addElement(new \XoopsFormHidden('ttpl_amountin[0]', '0'));
            $form->addElement(new \XoopsFormHidden('ttpl_amountout[0]', '0'));
            $crTratemplates = new \CriteriaCompo();
            $crTratemplates->add(new \Criteria('ttpl_online', 1));
            $tratemplatesAll = $helper->getHandler('Tratemplates')->getAll($crTratemplates);
            foreach ($tratemplatesAll as $tratemplate) {
                $tplId = $tratemplate->getVar('ttpl_id');
                $form->addElement(new \XoopsFormHidden('ttpl_desc[' . $tplId . ']', $tratemplate->getVar('ttpl_desc')));
                $form->addElement(new \XoopsFormHidden('ttpl_accid[' . $tplId . ']', $tratemplate->getVar('ttpl_accid')));
                $form->addElement(new \XoopsFormHidden('ttpl_allid[' . $tplId . ']', $tratemplate->getVar('ttpl_allid')));
                $form->addElement(new \XoopsFormHidden('ttpl_asid[' . $tplId . ']', $tratemplate->getVar('ttpl_asid')));
                $form->addElement(new \XoopsFormHidden('ttpl_amountin[' . $tplId . ']', $tratemplate->getVar('ttpl_amountin')));
                $form->addElement(new \XoopsFormHidden('ttpl_amountout[' . $tplId . ']', $tratemplate->getVar('ttpl_amountout')));
            }
            $tratemplatesSelect = new \XoopsFormRadio(\_MA_WGSIMPLEACC_TRANSACTION_TEMPLATE, 'tra_template', 0);
            $tratemplatesSelect->addOption(0, \_MA_WGSIMPLEACC_TEMPLATE_NONE);
            $tratemplatesSelect->addOptionArray($tratemplatesHandler->getList());
            $tratemplatesSelect->setExtra(" onchange='presetTraField()' ");
            $form->addElement($tratemplatesSelect, true);
        }
		if (!$this->isNew()) {
		    if ($admin) {
                // Form Text traYear
                $form->addElement(new \XoopsFormText(\_MA_WGSIMPLEACC_TRANSACTION_YEAR, 'tra_year', 50, 255, $this->getVar('tra_year')));
                // Form Text traNb
                $form->addElement(new \XoopsFormText(\_MA_WGSIMPLEACC_TRANSACTION_NB, 'tra_nb', 50, 255, $this->getVar('tra_nb')));
            } else {
                // Form Label traYear / traNb
                $form->addElement(new \XoopsFormLabel(\_MA_WGSIMPLEACC_TRANSACTION_YEARNB, $this->getVar('tra_year') . '/' . $this->getVar('tra_nb')));
                $form->addElement(new \XoopsFormHidden('tra_year', $this->getVar('tra_year')));
                $form->addElement(new \XoopsFormHidden('tra_nb', $this->getVar('tra_nb')));
            }
        }
        // Form Text traReference
        $form->addElement(new \XoopsFormText(\_MA_WGSIMPLEACC_TRANSACTION_REFERENCE, 'tra_reference', 50, 255, $this->getVar('tra_reference')));
        // Form Editor DhtmlTextArea traDesc
        $editorConfigs = [];
        if ($isAdmin) {
            $editor = $helper->getConfig('editor_admin');
        } else {
            $editor = $helper->getConfig('editor_user');
        }
        $editorConfigs['name'] = 'tra_desc';
        $editorConfigs['value'] = $this->getVar('tra_desc', 'e');
        $editorConfigs['rows'] = 5;
        $editorConfigs['cols'] = 40;
        $editorConfigs['width'] = '100%';
        $editorConfigs['height'] = '400px';
        $editorConfigs['editor'] = $editor;
        $traDesc = new \XoopsFormEditor(\_MA_WGSIMPLEACC_TRANSACTION_DESC, 'tra_desc', $editorConfigs);
        $form->addElement($traDesc);
        // Form Editor DhtmlTextArea traRemarks
        $editorConfigs = [];
        if ($isAdmin) {
            $editor = $helper->getConfig('editor_admin');
        } else {
            $editor = $helper->getConfig('editor_user');
        }
        $editorConfigs['name'] = 'tra_remarks';
        $editorConfigs['value'] = $this->getVar('tra_remarks', 'e');
        $editorConfigs['rows'] = 5;
        $editorConfigs['cols'] = 40;
        $editorConfigs['width'] = '100%';
        $editorConfigs['height'] = '400px';
        $editorConfigs['editor'] = $editor;
        $traRemarks = new \XoopsFormEditor(\_MA_WGSIMPLEACC_TRANSACTION_REMARKS, 'tra_remarks', $editorConfigs);
        $form->addElement($traRemarks);
		// Form Table accounts
		$accountsHandler = $helper->getHandler('Accounts');
		$traAccidSelect = new \XoopsFormSelect(\_MA_WGSIMPLEACC_TRANSACTION_ACCID, 'tra_accid', $this->getVar('tra_accid'), 5);
		$accounts = $accountsHandler->getSelectTreeOfAccounts(Constants::CLASS_INCOME);
		foreach ($accounts as $account) {
            $traAccidSelect->addOption($account['id'], $account['text']);
        }
		$form->addElement($traAccidSelect, true);
		// Form Table allocations
		$allocationsHandler = $helper->getHandler('Allocations');
		$traAllocationSelect = new \XoopsFormSelect(\_MA_WGSIMPLEACC_TRANSACTION_ALLID, 'tra_allid', $this->getVar('tra_allid'), 5);
        $allocations = $allocationsHandler->getSelectTreeOfAllocations();
        foreach ($allocations as $allocation) {
            $traAllocationSelect->addOption($allocation['id'], $allocation['text']);
        }
		$form->addElement($traAllocationSelect, true);
		// Form Text Date Select traDate
		$traDate = $this->isNew() ?: $this->getVar('tra_date');
		$form->addElement(new \XoopsFormTextDateSelect(\_MA_WGSIMPLEACC_TRANSACTION_DATE, 'tra_date', '', $traDate), true);
        if ($helper->getConfig('useCurrencies')) {
            // Form Table currencies
            $currenciesHandler = $helper->getHandler('Currencies');
            $traCuridSelect = new \XoopsFormSelect(\_MA_WGSIMPLEACC_TRANSACTION_CURID, 'tra_curid', $this->getVar('tra_curid'));
            $traCuridSelect->addOptionArray($currenciesHandler->getList());
            $form->addElement($traCuridSelect);
        }
        // Form Text traAmountin
        $default0 = '0' . $helper->getConfig('sep_comma') . '00';
        $traAmountin = $this->isNew() ? $default0 : Utility::FloatToString($this->getVar('tra_amountin'));
        // Form Text traAmountout
        $traAmountout = $this->isNew() ? $default0 : Utility::FloatToString($this->getVar('tra_amountout'));
		if (Constants::CLASS_INCOME == $type || Constants::CLASS_INCOME == $traClass || Constants::CLASS_BOTH == $type) {
            $form->addElement(new \XoopsFormText(\_MA_WGSIMPLEACC_TRANSACTION_AMOUNTIN, 'tra_amountin', 20, 150, $traAmountin));
            $form->addElement(new \XoopsFormHidden('tra_amountout', 0));
        }
        if (Constants::CLASS_EXPENSES == $type || Constants::CLASS_EXPENSES == $traClass || Constants::CLASS_BOTH == $type) {
            $form->addElement(new \XoopsFormText(\_MA_WGSIMPLEACC_TRANSACTION_AMOUNTOUT, 'tra_amountout', 20, 150, $traAmountout));
            $form->addElement(new \XoopsFormHidden('tra_amountin', 0));
        }
        if ($helper->getConfig('use_taxes')) {
            // Form Table taxes
            $taxesHandler = $helper->getHandler('Taxes');
            $traTaxid = $this->isNew() ? $taxesHandler->getPrimaryTax() : $this->getVar('tra_taxid');
            $traTaxidSelect = new \XoopsFormSelect(\_MA_WGSIMPLEACC_TRANSACTION_TAXID, 'tra_taxid', $traTaxid);
            $traTaxidSelect->addOptionArray($taxesHandler->getList());
            $form->addElement($traTaxidSelect);
        }
        // Form Table assets
        $assetsHandler = $helper->getHandler('Assets');
        $traAsid = $this->isNew() ? $assetsHandler->getPrimaryAsset() : $this->getVar('tra_asid');
		$traAsidSelect = new \XoopsFormSelect(\_MA_WGSIMPLEACC_TRANSACTION_ASID, 'tra_asid', $traAsid);
		$traAsidSelect->addOptionArray($assetsHandler->getList());
		$form->addElement($traAsidSelect);
        // Form Text traClass
        $traClass = $this->isNew() ? 0 : $this->getVar('tra_class');
		// Form Text traComments
        $traComments = $this->isNew() ? 0 : $this->getVar('tra_comments');
        // Form Text traBalid
        $traBalid = $this->isNew() ? 0 : $this->getVar('tra_balid');
		// Form Text Date Select traDatecreated
		$traDatecreated = $this->isNew() ? \time() : $this->getVar('tra_datecreated');
        // Form Select User traSubmitter
        $traSubmitter = $this->isNew() ? $GLOBALS['xoopsUser']->uid() : $this->getVar('tra_submitter');
        $permissionsHandler = $helper->getHandler('Permissions');
        if ($admin) {
            // Form Select Status traStatus
            $traStatusSelect = new \XoopsFormSelect(\_MA_WGSIMPLEACC_TRANSACTION_STATUS, 'tra_status', $this->getVar('tra_status'));
            $traStatusSelect->addOption(Constants::STATUS_NONE, \_AM_WGSIMPLEACC_STATUS_NONE);
            $traStatusSelect->addOption(Constants::STATUS_OFFLINE, \_AM_WGSIMPLEACC_STATUS_OFFLINE);
            $traStatusSelect->addOption(Constants::STATUS_SUBMITTED, \_AM_WGSIMPLEACC_STATUS_SUBMITTED);
            $traStatusSelect->addOption(Constants::STATUS_APPROVED, \_AM_WGSIMPLEACC_STATUS_APPROVED);
            $traStatusSelect->addOption(Constants::STATUS_LOCKED, \_AM_WGSIMPLEACC_STATUS_LOCKED);
            $form->addElement($traStatusSelect);
            // Form Select traClass
            $traClassSelect = new \XoopsFormSelect(\_MA_WGSIMPLEACC_TRANSACTION_CLASS, 'tra_class', $traClass);
            $traClassSelect->addOption(Constants::CLASS_BOTH, \_MA_WGSIMPLEACC_CLASS_BOTH);
            $traClassSelect->addOption(Constants::CLASS_EXPENSES, \_MA_WGSIMPLEACC_CLASS_EXPENSES);
            $traClassSelect->addOption(Constants::CLASS_INCOME, \_MA_WGSIMPLEACC_CLASS_INCOME);
            $form->addElement($traClassSelect);
            // Form Select traClass
            $traBalidSelect = new \XoopsFormSelect(\_MA_WGSIMPLEACC_TRANSACTION_BALID, 'tra_balid', $traBalid);
            $balancesHandler = $helper->getHandler('Balances');
            $traBalidSelect->addOption(0, '');
            $traBalidSelect->addOptionArray($balancesHandler->getList());
            $form->addElement($traBalidSelect);
            $form->addElement(new \XoopsFormText(\_MA_WGSIMPLEACC_TRANSACTION_COMMENTS, 'tra_comments', 50, 255, $traComments));
            $form->addElement(new \XoopsFormTextDateSelect(\_MA_WGSIMPLEACC_DATECREATED, 'tra_datecreated', '', $traDatecreated));
            $form->addElement(new \XoopsFormSelectUser(\_MA_WGSIMPLEACC_SUBMITTER, 'tra_submitter', false, $traSubmitter));
        } else {
            $traStatus = Constants::STATUS_SUBMITTED;
            if ($permissionsHandler->getPermTransactionsApprove()) {
                $traStatus = Constants::STATUS_APPROVED;
            }
            $form->addElement(new \XoopsFormHidden('tra_status', $traStatus));
            $form->addElement(new \XoopsFormHidden('tra_datecreated', $traDatecreated));
            $form->addElement(new \XoopsFormHidden('tra_submitter', $traSubmitter));
        }
        $form->addElement(new \XoopsFormHidden('start', $start));
        $form->addElement(new \XoopsFormHidden('limit', $limit));
		$form->addElement(new \XoopsFormHidden('op', 'save'));
		if ($approve) {
            $form->addElement(new \XoopsFormButtonTray('', \_MA_WGSIMPLEACC_APPROVE, 'submit', '', false));
        } else {
            $form->addElement(new \XoopsFormButtonTray('', \_SUBMIT, 'submit', '', false));
        }

		return $form;
	}

	/**
	 * Get Values
	 * @param null $keys
	 * @param null $format
	 * @param null $maxDepth
	 * @return array
	 */
	public function getValuesTransactions($keys = null, $format = null, $maxDepth = null)
	{
		$helper  = \XoopsModules\Wgsimpleacc\Helper::getInstance();
		$utility = new \XoopsModules\Wgsimpleacc\Utility();
        $editorMaxchar = $helper->getConfig('editor_maxchar');

		$ret = $this->getValues($keys, $format, $maxDepth);
		$ret['id']            = $this->getVar('tra_id');
        $ret['year']          = $this->getVar('tra_year');
        $ret['nb']            = $this->getVar('tra_nb');
        $ret['year_nb']       = $this->getVar('tra_year') . '/' . \substr('00000' . $this->getVar('tra_nb'), -5);
		$ret['desc']          = $this->getVar('tra_desc', 'e');
		$ret['desc_short']    = $utility::truncateHtml($ret['desc'], $editorMaxchar);
		$ret['reference']     = $this->getVar('tra_reference');
        $ret['remarks']       = $this->getVar('tra_remarks', 'e');
        $ret['remarks_short'] = $utility::truncateHtml($ret['remarks'], $editorMaxchar);
		$accountsHandler      = $helper->getHandler('Accounts');
		$accountsObj          = $accountsHandler->get($this->getVar('tra_accid'));
		$ret['accid']         = $accountsObj->getVar('acc_key');
        $ret['account']       = $accountsObj->getVar('acc_key') . ' ' . $accountsObj->getVar('acc_name');
		$allocationsHandler   = $helper->getHandler('Allocations');
		$allocationsObj       = $allocationsHandler->get($this->getVar('tra_allid'));
		$ret['allocation']    = $allocationsObj->getVar('all_name');
		$ret['date']          = \formatTimestamp($this->getVar('tra_date'), 's');
		$currenciesHandler    = $helper->getHandler('Currencies');
		$currenciesObj        = $currenciesHandler->get($this->getVar('tra_curid'));
        if (\is_object($currenciesObj)) {
            $ret['curid'] = $currenciesObj->getVar('cur_code');
        }
		$ret['amountin']      =  Utility::FloatToString($this->getVar('tra_amountin'));
		$ret['amountout']     =  Utility::FloatToString($this->getVar('tra_amountout'));
		if ($this->getVar('tra_amountin') > 0) {
            $ret['amount'] = $ret['amountin'];
        } else {
            $ret['amount'] = $ret['amountout'];
        }
        $taxesHandler         = $helper->getHandler('Taxes');
		$taxesObj             = $taxesHandler->get($this->getVar('tra_taxid'));
		$ret['taxid']         = $taxesObj->getVar('tax_name');
        $ret['taxrate']       = $taxesObj->getVar('tax_rate');
        $assetsHandler        = $helper->getHandler('Assets');
        $assetsObj            = $assetsHandler->get($this->getVar('tra_asid'));
        $ret['asset']         = $assetsObj->getVar('as_name');
		$status               = $this->getVar('tra_status');
		$ret['status']        = $status;
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
			case Constants::STATUS_APPROVED:
				$status_text = \_AM_WGSIMPLEACC_STATUS_APPROVED;
				break;
            case Constants::STATUS_LOCKED:
                $status_text = \_AM_WGSIMPLEACC_STATUS_LOCKED;
                break;
		}
		$ret['status_text'] = $status_text;
		$ret['comments']    = $this->getVar('tra_comments');
        $traClass           = $this->getVar('tra_class');
        $ret['class']       = $traClass;
        switch ($traClass) {
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
        $ret['balid']       = $this->getVar('tra_balid');
		$ret['datecreated'] = \formatTimestamp($this->getVar('tra_datecreated'), 's');
		$ret['submitter']   = \XoopsUser::getUnameFromId($this->getVar('tra_submitter'));
        $filesHandler = $helper->getHandler('Files');
        $crFiles = new \CriteriaCompo();
        $crFiles->add(new \Criteria('fil_traid', $this->getVar('tra_id')));
        $filesCount = $filesHandler->getCount($crFiles);
        $ret['nbfiles'] = $filesCount;
        if ($filesCount > 0) {
            $filesAll = $filesHandler->getAll($crFiles);
            $files = [];
            // Get All Files
            foreach (\array_keys($filesAll) as $i) {
                $file = $filesAll[$i]->getValuesFiles();
                $files[$i] = ['id' => $file['fil_id'], 'name' => $file['fil_name'], 'image' => $file['image']];
                unset($file);
            }
            $ret['files'] = $files;
        }
		return $ret;
	}

	/**
	 * Returns an array representation of the object
	 *
	 * @return array
	 */
	public function toArrayTransactions()
	{
		$ret = [];
		$vars = $this->getVars();
		foreach (\array_keys($vars) as $var) {
			$ret[$var] = $this->getVar('"{$var}"');
		}
		return $ret;
	}
}
