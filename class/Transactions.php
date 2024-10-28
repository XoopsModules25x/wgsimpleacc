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
use XoopsModules\Wgsimpleacc\{
    Helper,
    Constants,
    Utility
};
use XoopsModules\Wgsimpleacc\Form\FormSelectCascading;

\defined('\XOOPS_ROOT_PATH') || die('Restricted access');

/**
 * Class Object Transactions
 */
class Transactions extends \XoopsObject
{
    /**
     * Constructor
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
        $this->initVar('tra_cliid', \XOBJ_DTYPE_INT);
        $this->initVar('tra_status', \XOBJ_DTYPE_INT);
        $this->initVar('tra_comments', \XOBJ_DTYPE_INT);
        $this->initVar('tra_class', \XOBJ_DTYPE_INT);
        $this->initVar('tra_balid', \XOBJ_DTYPE_INT);
        $this->initVar('tra_balidt', \XOBJ_DTYPE_INT);
        $this->initVar('tra_hist', \XOBJ_DTYPE_TXTBOX);
        $this->initVar('tra_datecreated', \XOBJ_DTYPE_INT);
        $this->initVar('tra_submitter', \XOBJ_DTYPE_INT);
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
     * @return integer
     */
    public function getNewInsertedIdTransactions()
    {
        return $GLOBALS['xoopsDB']->getInsertId();
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
        $helper = Helper::getInstance();
        if (!$action) {
            $action = $_SERVER['REQUEST_URI'];
        }
        $isAdmin = $GLOBALS['xoopsUser']->isAdmin($GLOBALS['xoopsModule']->mid());
        $cascadingAccounts = (bool)$helper->getConfig('use_cascadingacc');
        $traClass = $this->isNew() ? $type : (int)$this->getVar('tra_class');

        // Title
        $title = $this->isNew() ? \_MA_WGSIMPLEACC_TRANSACTION_ADD : \_MA_WGSIMPLEACC_TRANSACTION_EDIT;
        if (Constants::CLASS_INCOME === $traClass || Constants::CLASS_BOTH === $traClass) {
            $title = $this->isNew() ? \_MA_WGSIMPLEACC_TRANSACTION_ADD_INCOME : \_MA_WGSIMPLEACC_TRANSACTION_EDIT_INCOME;
        }
        if (Constants::CLASS_EXPENSES === $traClass || Constants::CLASS_BOTH === $traClass) {
            $title = $this->isNew() ? \_MA_WGSIMPLEACC_TRANSACTION_ADD_EXPENSES : \_MA_WGSIMPLEACC_TRANSACTION_EDIT_EXPENSES;
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
            $form->addElement(new \XoopsFormHidden('ttpl_cliid[0]', '0'));
            $form->addElement(new \XoopsFormHidden('ttpl_amountin[0]', '0'));
            $form->addElement(new \XoopsFormHidden('ttpl_amountout[0]', '0'));
            $crTratemplates = new \CriteriaCompo();
            $crTratemplates->add(new \Criteria('ttpl_online', 1));
            if ($traClass > Constants::CLASS_BOTH) {
                $crTraClass = new \CriteriaCompo();
                $crTraClass->add(new \Criteria('ttpl_class', $traClass));
                $crTraClass->add(new \Criteria('ttpl_class', Constants::CLASS_BOTH), 'OR');
                $crTratemplates->add($crTraClass);
            }
            $tratemplatesAll = $helper->getHandler('Tratemplates')->getAll($crTratemplates);
            foreach ($tratemplatesAll as $tratemplate) {
                $tplId = $tratemplate->getVar('ttpl_id');
                $form->addElement(new \XoopsFormHidden('ttpl_desc[' . $tplId . ']', $tratemplate->getVar('ttpl_desc')));
                if ($cascadingAccounts) {
                    $form->addElement(new \XoopsFormHidden('ttpl_accid[' . $tplId . ']', $tratemplate->getVar('ttpl_accid') . '_' . $tratemplate->getVar('ttpl_allid')));
                } else {
                    $form->addElement(new \XoopsFormHidden('ttpl_accid[' . $tplId . ']', $tratemplate->getVar('ttpl_accid')));
                }
                $form->addElement(new \XoopsFormHidden('ttpl_allid[' . $tplId . ']', $tratemplate->getVar('ttpl_allid')));
                $form->addElement(new \XoopsFormHidden('ttpl_asid[' . $tplId . ']', $tratemplate->getVar('ttpl_asid')));
                $form->addElement(new \XoopsFormHidden('ttpl_cliid[' . $tplId . ']', $tratemplate->getVar('ttpl_cliid')));
                $cliName = '';
                if ($helper->getConfig('use_clients')) {
                    $clientsHandler = $helper->getHandler('Clients');
                    $clientsObj = $clientsHandler->get($tratemplate->getVar('ttpl_cliid'));
                    $cliName = Utility::cleanTextDropdown($clientsObj->getVar('cli_name'));
                }
                $form->addElement(new \XoopsFormHidden('ttpl_client[' . $tplId . ']', $cliName));
                if (Constants::CLASS_INCOME === $traClass) {
                    $form->addElement(new \XoopsFormHidden('ttpl_amount[' . $tplId . ']', Utility::FloatToString($tratemplate->getVar('ttpl_amountin'))));
                } else {
                    $form->addElement(new \XoopsFormHidden('ttpl_amount[' . $tplId . ']', Utility::FloatToString($tratemplate->getVar('ttpl_amountout'))));
                }
            }
            $tratemplatesSelect = new \XoopsFormRadio(\_MA_WGSIMPLEACC_TRANSACTION_TEMPLATE, 'tra_template', 0);
            $tratemplatesSelect->addOption(0, \_MA_WGSIMPLEACC_TEMPLATE_NONE);
            $tratemplatesSelect->addOptionArray($tratemplatesHandler->getList($crTratemplates));
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
        // Form Table clients
        if ($helper->getConfig('use_clients')) {
            $traClient = $this->isNew() ? 0 : $this->getVar('tra_cliid');
            $clientsHandler = $helper->getHandler('Clients');
            $crClients = new \CriteriaCompo();
            $crClients->add(new \Criteria('cli_online', 1));
            if (Constants::CLASS_INCOME === $type || Constants::CLASS_INCOME === $traClass || Constants::CLASS_BOTH === $type) {
                $crClients->add(new \Criteria('cli_debtor', 1));
            } else {
                $crClients->add(new \Criteria('cli_creditor', 1));
            }
            $crClients->setSort('cli_name');
            $crClients->setOrder('ASC');
            $traCliidSelect = new \XoopsFormSelect(\_MA_WGSIMPLEACC_TRANSACTION_CLIID, 'tra_cliid', $traClient);
            $traCliidSelect->addOption('');
            $clientsAll = $clientsHandler->getAll($crClients);
            foreach ($clientsAll as $client) {
                $traCliidSelect->addOption($client->getVar('cli_id'), Utility::cleanTextDropdown($client->getVar('cli_name')));
            }
            $form->addElement($traCliidSelect);
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
        $form->addElement($traDesc, true);
        // Form Editor DhtmlTextArea traRemarks
        $editorConfigs = [];
        $editorConfigs['name'] = 'tra_remarks';
        $editorConfigs['value'] = $this->getVar('tra_remarks', 'e');
        $editorConfigs['rows'] = 5;
        $editorConfigs['cols'] = 40;
        $editorConfigs['width'] = '100%';
        $editorConfigs['height'] = '400px';
        $editorConfigs['editor'] = $editor;
        $traRemarks = new \XoopsFormEditor(\_MA_WGSIMPLEACC_TRANSACTION_REMARKS, 'tra_remarks', $editorConfigs);
        $form->addElement($traRemarks);
        // Form Table allocations
        $allocationsHandler = $helper->getHandler('Allocations');
        $traAllid = $this->isNew() ? 0 : (int)$this->getVar('tra_allid');
        $allRequired = true;
        $allInfoInvalid = null;
        $accInfoInvalid = null;
        if ($traAllid > 0) {
            $allIsOnline = $allocationsHandler->AllocationIsOnline($traAllid);
            if (!$allIsOnline['online']) {
                // create info that allocation isn't valid anymore
                // required is false in order to allow saving without changing it
                $allInfoInvalid = new \XoopsFormLabel('', \sprintf(\_MA_WGSIMPLEACC_TRANSACTION_SELECT_INVALID, \_MA_WGSIMPLEACC_ALLOCATION, $allIsOnline['name']));
                $allRequired = false;
            }
        }
        if ($cascadingAccounts) {
            // add cascading form select for accounts
            $traAllocationSelect1 = new Form\FormSelectCascading(\_MA_WGSIMPLEACC_TRANSACTION_ALLID, 'tra_allid', $traAllid, 10);
            $traAllocationSelect1->setType(1);
            $allocations = $allocationsHandler->getSelectTreeOfAllocations();
            $arrAllocations = [];
            foreach ($allocations as $allocation) {
                $arrAllocations[] = ['id' => $allocation['id'], 'text' => $allocation['text'], 'rel' => '0', 'init' => '0'];
            }
            $traAllocationSelect1->setCustomOptions($arrAllocations);
            $form->addElement($traAllocationSelect1, $allRequired);
        } else {
            // add default xoops form select
            $traAllocationSelect = new \XoopsFormSelect('', 'tra_allid', $traAllid, 15);
            $allocations = $allocationsHandler->getSelectTreeOfAllocations();
            foreach ($allocations as $allocation) {
                $traAllocationSelect->addOption($allocation['id'], $allocation['text']);
            }
            $form->addElement($traAllocationSelect, $allRequired);
        }
        if (\is_object($allInfoInvalid)) {
            // show info that allocation isn't valid anymore
            $form->addElement($allInfoInvalid);
            $form->addElement(new \XoopsFormHidden('tra_allid_old', $traAllid));
        }
        // Form Table accounts
        $accountsHandler = $helper->getHandler('Accounts');
        $traAccid = $this->isNew() ? 0 : (int)$this->getVar('tra_accid');
        $accRequired = true;
        if ($traAccid > 0) {
            $accIsOnline = $accountsHandler->AccountIsOnline($traAccid);
            if (!$accIsOnline['online']) {
                // create info that account isn't valid anymore
                // required is false in order to allow saving without changing it
                $accInfoInvalid = new \XoopsFormLabel('', \sprintf(\_MA_WGSIMPLEACC_TRANSACTION_SELECT_INVALID, \_MA_WGSIMPLEACC_ACCOUNT, $accIsOnline['name']));
                $accRequired = false;
            }
        }
        if ($cascadingAccounts) {
            // add cascading form select for accounts
            $traAccidSelect = new Form\FormSelectCascading(\_MA_WGSIMPLEACC_TRANSACTION_ACCID, 'tra_accid', $traAccid . '_' . $traAllid, 10);
            $traAccidSelect->setType(2);
            $arrAccounts = [];
            $accountsAll = $accountsHandler->getSelectTreeOfAccounts($traClass);
            // get all accounts associated with allocations
            foreach ($allocations as $allocation) {
                $allObj = $allocationsHandler->get($allocation['id']);
                $allAccounts = \unserialize($allObj->getVar('all_accounts'), ['allowed_classes' => false]);
                foreach ($allAccounts as $account) {
                    foreach ($accountsAll as $accSingle) {
                        if ((int)$accSingle['id'] === (int)$account) {
                            $arrAccounts[] = ['id' => $accSingle['id'] . '_' . $allocation['id'], 'text' => $accSingle['text'], 'rel' => $allocation['id'], 'init' => $traAllid];
                        }
                    }
                }
            }
            $traAccidSelect->setCustomOptions($arrAccounts);
            $form->addElement($traAccidSelect, $accRequired);
        } else {
            // add default xoops form select
            $traAccidSelect = new \XoopsFormSelect(\_MA_WGSIMPLEACC_TRANSACTION_ACCID, 'tra_accid', $traAccid, 15);
            $accounts = $accountsHandler->getSelectTreeOfAccounts($traClass);
            foreach ($accounts as $account) {
                $traAccidSelect->addOption($account['id'], $account['text']);
            }
            $form->addElement($traAccidSelect, $accRequired);
        }
        if (\is_object($accInfoInvalid)) {
            $form->addElement($accInfoInvalid);
            $form->addElement(new \XoopsFormHidden('tra_accid_old', $traAccid));
        }
        // Form Text Date Select traDate
        $traDate = $this->isNew() ?: $this->getVar('tra_date');
        $form->addElement(new \XoopsFormTextDateSelect(\_MA_WGSIMPLEACC_TRANSACTION_DATE, 'tra_date', '', $traDate), true);
        if ($helper->getConfig('useCurrencies')) {
            // Form Table currencies
            $currenciesHandler = $helper->getHandler('Currencies');
            $crCurrencies = new \CriteriaCompo();
            $crCurrencies->add(new \Criteria('cur_online', 1));
            $traCuridSelect = new \XoopsFormSelect(\_MA_WGSIMPLEACC_TRANSACTION_CURID, 'tra_curid', $this->getVar('tra_curid'));
            $traCuridSelect->addOptionArray($currenciesHandler->getList($crCurrencies));
            $form->addElement($traCuridSelect);
        }
        // Form Text traAmountin
        $default0 = '0' . $helper->getConfig('sep_comma') . '00';
        $traAmountin = $this->isNew() ? $default0 : Utility::FloatToString($this->getVar('tra_amountin'));
        // Form Text traAmountout
        $traAmountout = $this->isNew() ? $default0 : Utility::FloatToString($this->getVar('tra_amountout'));
        // Form Select traClass
        $traClassSelect = new \XoopsFormRadio(\_MA_WGSIMPLEACC_TRANSACTION_CLASS, 'tra_class', $traClass);
        $traClassSelect->addOption(Constants::CLASS_EXPENSES, \_MA_WGSIMPLEACC_CLASS_EXPENSES);
        $traClassSelect->addOption(Constants::CLASS_INCOME, \_MA_WGSIMPLEACC_CLASS_INCOME);
        $form->addElement($traClassSelect);
        // Form Text traAmount
        $traAmount = 0;
        if (Constants::CLASS_INCOME === $type || Constants::CLASS_INCOME === $traClass || Constants::CLASS_BOTH === $type) {
            $traAmount = $traAmountin;
        }
        if (Constants::CLASS_EXPENSES === $type || Constants::CLASS_EXPENSES == $traClass || Constants::CLASS_BOTH === $type) {
            $traAmount = $traAmountout;
        }
        $traAmountTray = new \XoopsFormElementTray(\_MA_WGSIMPLEACC_TRANSACTION_AMOUNT, '&nbsp;');
        $traAmountTray->addElement(new \XoopsFormText('', 'tra_amount', 20, 150, $traAmount));
        $button = new \XoopsFormButton('', 'calcAmount', \_MA_WGSIMPLEACC_CALC);
        $button->setExtra('onclick="$(\'#calcModal\').modal();"');
        $traAmountTray->addElement($button);
        $form->addElement($traAmountTray);
        // Form Table taxes
        if ($helper->getConfig('use_taxes')) {
            $taxesHandler = $helper->getHandler('Taxes');
            $crTaxes = new \CriteriaCompo();
            $crTaxes->add(new \Criteria('tax_online', 1));
            $traTaxid = $this->isNew() ? $taxesHandler->getPrimaryTax() : $this->getVar('tra_taxid');
            $traTaxidSelect = new \XoopsFormSelect(\_MA_WGSIMPLEACC_TRANSACTION_TAXID, 'tra_taxid', $traTaxid);
            $traTaxidSelect->addOptionArray($taxesHandler->getList($crTaxes));
            $form->addElement($traTaxidSelect);
        }
        // Form Table assets
        $assetsHandler = $helper->getHandler('Assets');
        $crAssets = new \CriteriaCompo();
        $crAssets->add(new \Criteria('as_online', 1));
        $crAssets->add(new \Criteria('as_iecalc', 1));
        $traAsid = $this->isNew() ? $assetsHandler->getPrimaryAsset() : $this->getVar('tra_asid');
        $traAsidSelect = new \XoopsFormSelect(\_MA_WGSIMPLEACC_TRANSACTION_ASID, 'tra_asid', $traAsid);
        $traAsidSelect->addOptionArray($assetsHandler->getList($crAssets));
        $form->addElement($traAsidSelect);
        // Form Text traComments
        $traComments = $this->isNew() ? 0 : $this->getVar('tra_comments');
        // Form Text traBalid
        $traBalid = $this->isNew() ? 0 : $this->getVar('tra_balid');
        // Form Text traBalidt
        $traBalidt = $this->isNew() ? 0 : $this->getVar('tra_balidt');
        // Form Text traHist
        $traHist = $this->isNew() ? 0 : $this->getVar('tra_hist');
        // Form Text Date Select traDatecreated
        $traDatecreated = $this->isNew() ? \time() : $this->getVar('tra_datecreated');
        // Form Select User traSubmitter
        $traSubmitter = $this->isNew() ? (int)$GLOBALS['xoopsUser']->uid() : (int)$this->getVar('tra_submitter');
        $permissionsHandler = $helper->getHandler('Permissions');
        $traStatus = (int)$this->getVar('tra_status');
        if ($admin) {
            // Form Select Status traStatus
            $traStatusSelect = new \XoopsFormSelect(\_MA_WGSIMPLEACC_TRANSACTION_STATUS, 'tra_status', $traStatus);
            $traStatusSelect->addOption(Constants::TRASTATUS_NONE, \_MA_WGSIMPLEACC_TRASTATUS_NONE);
            $traStatusSelect->addOption(Constants::TRASTATUS_DELETED, \_MA_WGSIMPLEACC_TRASTATUS_DELETED);
            $traStatusSelect->addOption(Constants::TRASTATUS_CREATED, \_MA_WGSIMPLEACC_TRASTATUS_CREATED);
            $traStatusSelect->addOption(Constants::TRASTATUS_SUBMITTED, \_MA_WGSIMPLEACC_TRASTATUS_SUBMITTED);
            $traStatusSelect->addOption(Constants::TRASTATUS_APPROVED, \_MA_WGSIMPLEACC_TRASTATUS_APPROVED);
            $traStatusSelect->addOption(Constants::TRASTATUS_LOCKED, \_MA_WGSIMPLEACC_TRASTATUS_LOCKED);
            $form->addElement($traStatusSelect);
            // Form Select traBalid
            $traBalidSelect = new \XoopsFormSelect(\_MA_WGSIMPLEACC_TRANSACTION_BALID, 'tra_balid', $traBalid);
            $balancesHandler = $helper->getHandler('Balances');
            $traBalidSelect->addOption(0);
            $traBalidSelect->addOptionArray($balancesHandler->getList());
            $form->addElement($traBalidSelect);
            // Form Select traBalidt
            $traBalidtSelect = new \XoopsFormSelect(\_MA_WGSIMPLEACC_TRANSACTION_BALIDT, 'tra_balidt', $traBalidt);
            $balancesHandler = $helper->getHandler('Balances');
            $traBalidtSelect->addOption(0);
            $traBalidtSelect->addOptionArray($balancesHandler->getList());
            $form->addElement($traBalidtSelect);
            $form->addElement(new \XoopsFormText(\_MA_WGSIMPLEACC_TRANSACTION_COMMENTS, 'tra_comments', 50, 255, $traComments));
            $form->addElement(new \XoopsFormText(\_MA_WGSIMPLEACC_TRANSACTION_HIST, 'tra_hist', 20, 150, $traHist));
            $form->addElement(new \XoopsFormTextDateSelect(\_MA_WGSIMPLEACC_DATECREATED, 'tra_datecreated', '', $traDatecreated));
            $form->addElement(new \XoopsFormSelectUser(\_MA_WGSIMPLEACC_SUBMITTER, 'tra_submitter', false, $traSubmitter));
        } else {
            // Form Select Status traStatus
            if ($permissionsHandler->getPermTransactionsApprove()) {
                if ($this->isNew() || $approve) {
                    $traStatus = Constants::TRASTATUS_APPROVED;
                } else {
                    $traStatus = $this->getVar('tra_status');
                }
                $traStatusSelect = new \XoopsFormSelect(\_MA_WGSIMPLEACC_TRANSACTION_STATUS, 'tra_status', $traStatus);
                $traStatusSelect->addOption(Constants::TRASTATUS_DELETED, \_MA_WGSIMPLEACC_TRASTATUS_DELETED);
                $traStatusSelect->addOption(Constants::TRASTATUS_CREATED, \_MA_WGSIMPLEACC_TRASTATUS_CREATED);
                $traStatusSelect->addOption(Constants::TRASTATUS_SUBMITTED, \_MA_WGSIMPLEACC_TRASTATUS_SUBMITTED);
                $traStatusSelect->addOption(Constants::TRASTATUS_APPROVED, \_MA_WGSIMPLEACC_TRASTATUS_APPROVED);
                $form->addElement($traStatusSelect);
            } else {
                $traStatusNew = Constants::TRASTATUS_SUBMITTED;
                if ($this->isNew()) {
                    $form->addElement(new \XoopsFormLabel(\_MA_WGSIMPLEACC_TRANSACTION_STATUS, Utility::getTraStatusText($traStatusNew)));
                } else {
                    $form->addElement(new \XoopsFormLabel(\_MA_WGSIMPLEACC_TRANSACTION_STATUS, Utility::getTraStatusText($traStatus)));
                }
                $form->addElement(new \XoopsFormHidden('tra_status', $traStatusNew));
            }
            $form->addElement(new \XoopsFormHidden('tra_balid', $traBalid));
            $form->addElement(new \XoopsFormHidden('tra_comments', $traComments));
            $form->addElement(new \XoopsFormHidden('tra_hist', $traHist));
            $form->addElement(new \XoopsFormHidden('tra_datecreated', \time()));
            $form->addElement(new \XoopsFormHidden('tra_submitter', $GLOBALS['xoopsUser']->uid()));
        }
        $form->addElement(new \XoopsFormHidden('start', $start));
        $form->addElement(new \XoopsFormHidden('limit', $limit));
        $form->addElement(new \XoopsFormHidden('op', 'save'));
        if ($approve) {
            $form->addElement(new \XoopsFormButtonTray('', \_MA_WGSIMPLEACC_APPROVE, 'submit', '', false));
        //} elseif (Constants::TRASTATUS_DELETED == $traStatus) {
                //$form->addElement(new \XoopsFormButtonTray('', \_MA_WGSIMPLEACC_REACTIVATE, 'submit', '', false));
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
        $ret['accid']         = $this->getVar('tra_accid');
        if (\is_object($accountsObj)) {
            $ret['acc_key']       = $accountsObj->getVar('acc_key');
            $ret['account']       = $accountsObj->getVar('acc_key') . ' ' . $accountsObj->getVar('acc_name');
        }
        $allocationsHandler   = $helper->getHandler('Allocations');
        $allocationsObj       = $allocationsHandler->get($this->getVar('tra_allid'));
        if (\is_object($allocationsObj)) {
            $ret['allocation']    = $allocationsObj->getVar('all_name');
        }
        $ret['date']          = \formatTimestamp($this->getVar('tra_date'), _SHORTDATESTRING);
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
        $taxesHandler       = $helper->getHandler('Taxes');
        $taxesObj           = $taxesHandler->get($this->getVar('tra_taxid'));
        $ret['taxid']       = $taxesObj->getVar('tax_name');
        $ret['taxrate']     = $taxesObj->getVar('tax_rate');
        $assetsHandler      = $helper->getHandler('Assets');
        $assetsObj          = $assetsHandler->get($this->getVar('tra_asid'));
        $ret['asset']       = $assetsObj->getVar('as_name');
        $ret['cliid']       = $this->getVar('tra_cliid');
        $cliName            = '';
        $clientsHandler = $helper->getHandler('Clients');
        $clientsObj = $clientsHandler->get($this->getVar('tra_cliid'));
        if (\is_object($clientsObj)) {
            $cliName = $clientsObj->getVar('cli_name');
        }
        $ret['client']      = $cliName;
        $status             = $this->getVar('tra_status');
        $ret['status']      = $status;
        $ret['status_text'] = Utility::getTraStatusText($status);
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
        $ret['class_text']      = $class_text;
        $ret['balid']           = $this->getVar('tra_balid');
        $ret['balidt']          = $this->getVar('tra_balidt');
        $ret['hist']            = $this->getVar('tra_hist');
        $ret['datecreated']     = \formatTimestamp($this->getVar('tra_datecreated'), _SHORTDATESTRING);
        $ret['datetimecreated'] = \formatTimestamp($this->getVar('tra_datecreated'), _DATESTRING);
        $ret['submitter']       = \XoopsUser::getUnameFromId($this->getVar('tra_submitter'));
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
