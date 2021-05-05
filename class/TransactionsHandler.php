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


/**
 * Class Object Handler Transactions
 */
class TransactionsHandler extends \XoopsPersistableObjectHandler
{
    /**
     * Constructor
     *
     * @param \XoopsDatabase $db
     */
    public function __construct(\XoopsDatabase $db)
    {
        parent::__construct($db, 'wgsimpleacc_transactions', Transactions::class, 'tra_id', 'tra_desc');
    }

    /**
     * @param bool $isNew
     *
     * @return object
     */
    public function create($isNew = true)
    {
        return parent::create($isNew);
    }

    /**
     * retrieve a field
     *
     * @param int $i field id
     * @param null fields
     * @return mixed reference to the {@link Get} object
     */
    public function get($i = null, $fields = null)
    {
        return parent::get($i, $fields);
    }

    /**
     * get inserted id
     *
     * @param null
     * @return int reference to the {@link Get} object
     */
    public function getInsertId()
    {
        return $this->db->getInsertId();
    }

    /**
     * Get Count Transactions in the database
     * @param int    $start
     * @param int    $limit
     * @param string $sort
     * @param string $order
     * @return int
     */
    public function getCountTransactions($start = 0, $limit = 0, $sort = 'tra_id ASC, tra_desc', $order = 'ASC')
    {
        $crCountTransactions = new \CriteriaCompo();
        $crCountTransactions = $this->getTransactionsCriteria($crCountTransactions, $start, $limit, $sort, $order);
        return $this->getCount($crCountTransactions);
    }

    /**
     * Get All Transactions in the database
     * @param int    $start
     * @param int    $limit
     * @param string $sort
     * @param string $order
     * @return array
     */
    public function getAllTransactions($start = 0, $limit = 0, $sort = 'tra_id ASC, tra_desc', $order = 'ASC')
    {
        $crAllTransactions = new \CriteriaCompo();
        $crAllTransactions = $this->getTransactionsCriteria($crAllTransactions, $start, $limit, $sort, $order);
        return $this->getAll($crAllTransactions);
    }

    /**
     * Get Criteria Transactions
     * @param        $crTransactions
     * @param int    $start
     * @param int    $limit
     * @param string $sort
     * @param string $order
     * @return int
     */
    private function getTransactionsCriteria($crTransactions, $start, $limit, $sort, $order)
    {
        $crTransactions->setStart($start);
        $crTransactions->setLimit($limit);
        $crTransactions->setSort($sort);
        $crTransactions->setOrder($order);
        return $crTransactions;
    }

    /**
     * @public function to get form for filter Transactions
     * @param int $allId
     * @param $filterYear
     * @param $filterMonthFrom
     * @param $filterYearFrom
     * @param $filterMonthTo
     * @param $filterYearTo
     * @param $yearMin
     * @param $yearMax
     * @param $asId
     * @param $accId
     * @param $cliId
     * @param string $op
     * @return FormInline
     */
    public static function getFormFilterTransactions($allId, $filterYear, $filterMonthFrom, $filterYearFrom, $filterMonthTo, $filterYearTo, $yearMin, $yearMax, $asId, $accId, $cliId, $op='list')
    {
        $helper = \XoopsModules\Wgsimpleacc\Helper::getInstance();
        $period_type = $helper->getConfig('balance_period');
        $action = $_SERVER['REQUEST_URI'];

        // Title
        //$title = \_MA_WGSIMPLEACC_FILTERBY_YEAR;
        // Get Theme Form
        \xoops_load('XoopsFormLoader');
        $form = new \XoopsModules\Wgsimpleacc\FormInline('', 'formFilter', $action, 'post', true);
        $form->setExtra('enctype="multipart/form-data"');
        $form->setExtra('class="wgsa-form-inline"');
        // Form Table allocations
        $allocationsHandler = $helper->getHandler('Allocations');
        $traAllocationSelect = new \XoopsFormSelect(\_MA_WGSIMPLEACC_FILTERBY_ALLOC, 'all_id', $allId);
        $allocations = $allocationsHandler->getSelectTreeOfAllocations();
        $traAllocationSelect->addOption(0, \_MA_WGSIMPLEACC_SHOW_ALL);
        foreach ($allocations as $allocation) {
            $traAllocationSelect->addOption($allocation['id'], $allocation['text']);
        }
        $form->addElement($traAllocationSelect, true);
        //linebreak
        $form->addElement(new \XoopsFormHidden('linebreak', ''));
        //create filter depending on preferences
        if (Constants::FILTER_PYEARLY == $period_type) {
            $filterYearSelect = new \XoopsFormSelect(\_MA_WGSIMPLEACC_FILTERBY_YEAR . ': ', 'filterYear', $filterYear);
            $filterYearSelect->addOption(Constants::FILTER_TYPEALL, \_MA_WGSIMPLEACC_SHOW_ALL);
            for ($i = $yearMin; $i <= $yearMax; $i++) {
                $filterYearSelect->addOption($i, $i);
            }
            $filterYearSelect->addOption(\date('Y'), \date('Y')); //if no Transactions available for current year
            $form->addElement($filterYearSelect, true);
        } else {
            //select from/to
            $selectFromToTray = new \XoopsFormElementTray(\_MA_WGSIMPLEACC_FILTERBY_PERIOD . ': ', '&nbsp;');
            //select from
            if (0 == $filterMonthFrom) {
                $filterMonthFrom = $helper->getConfig('balance_period_from');
            }
            $filterMonthFromSelect = new \XoopsFormSelect(\_MA_WGSIMPLEACC_FILTER_PERIODFROM, 'filterMonthFrom', $filterMonthFrom);
            $filterMonthFromSelect->addOption(1, \_MI_WGSIMPLEACC_JANUARY);
            $filterMonthFromSelect->addOption(2, \_MI_WGSIMPLEACC_FEBRUARY);
            $filterMonthFromSelect->addOption(3, \_MI_WGSIMPLEACC_MARCH);
            $filterMonthFromSelect->addOption(4, \_MI_WGSIMPLEACC_APRIL);
            $filterMonthFromSelect->addOption(5, \_MI_WGSIMPLEACC_MAY);
            $filterMonthFromSelect->addOption(6, \_MI_WGSIMPLEACC_JUNE);
            $filterMonthFromSelect->addOption(7, \_MI_WGSIMPLEACC_JULY);
            $filterMonthFromSelect->addOption(8, \_MI_WGSIMPLEACC_AUGUST);
            $filterMonthFromSelect->addOption(9, \_MI_WGSIMPLEACC_SEPTEMBER);
            $filterMonthFromSelect->addOption(10, \_MI_WGSIMPLEACC_OCTOBER);
            $filterMonthFromSelect->addOption(11, \_MI_WGSIMPLEACC_NOVEMBER);
            $filterMonthFromSelect->addOption(12, \_MI_WGSIMPLEACC_DECEMBER);
            $selectFromToTray->addElement($filterMonthFromSelect);
            $filterYearFromSelect = new \XoopsFormSelect('', 'filterYearFrom', $filterYearFrom);
            for ($i = $yearMin; $i <= $yearMax; $i++) {
                $filterYearFromSelect->addOption($i, $i);
            }
            $filterYearFromSelect->addOption(\date('Y'), \date('Y')); //if no Transactions available for current year
            $selectFromToTray->addElement($filterYearFromSelect);
            //select to
            if (0 == $filterMonthTo) {
                $filterMonthTo = $helper->getConfig('balance_period_to');
            }
            $filterMonthToSelect = new \XoopsFormSelect(\_MA_WGSIMPLEACC_FILTER_PERIODTO, 'filterMonthTo', $filterMonthTo);
            $filterMonthToSelect->addOption(1, \_MI_WGSIMPLEACC_JANUARY);
            $filterMonthToSelect->addOption(2, \_MI_WGSIMPLEACC_FEBRUARY);
            $filterMonthToSelect->addOption(3, \_MI_WGSIMPLEACC_MARCH);
            $filterMonthToSelect->addOption(4, \_MI_WGSIMPLEACC_APRIL);
            $filterMonthToSelect->addOption(5, \_MI_WGSIMPLEACC_MAY);
            $filterMonthToSelect->addOption(6, \_MI_WGSIMPLEACC_JUNE);
            $filterMonthToSelect->addOption(7, \_MI_WGSIMPLEACC_JULY);
            $filterMonthToSelect->addOption(8, \_MI_WGSIMPLEACC_AUGUST);
            $filterMonthToSelect->addOption(9, \_MI_WGSIMPLEACC_SEPTEMBER);
            $filterMonthToSelect->addOption(10, \_MI_WGSIMPLEACC_OCTOBER);
            $filterMonthToSelect->addOption(11, \_MI_WGSIMPLEACC_NOVEMBER);
            $filterMonthToSelect->addOption(12, \_MI_WGSIMPLEACC_DECEMBER);
            $selectFromToTray->addElement($filterMonthToSelect);
            $filterYearToSelect = new \XoopsFormSelect('', 'filterYearTo', $filterYearTo);
            for ($i = $yearMin; $i <= $yearMax; $i++) {
                $filterYearToSelect->addOption($i, $i);
            }
            $filterYearToSelect->addOption(\date('Y'), \date('Y')); //if no Transactions available for current year
            $selectFromToTray->addElement($filterYearToSelect);
            $form->addElement($selectFromToTray);
        }
        //linebreak
        $form->addElement(new \XoopsFormHidden('linebreak', ''));
        // Form Table assets
        $assetsHandler = $helper->getHandler('Assets');
        $traAsidSelect = new \XoopsFormSelect(\_MA_WGSIMPLEACC_FILTERBY_ASSET, 'as_id', $asId);
        $traAsidSelect->addOption(Constants::FILTER_TYPEALL, \_MA_WGSIMPLEACC_SHOW_ALL);
        $traAsidSelect->addOptionArray($assetsHandler->getList());
        $form->addElement($traAsidSelect);
        //linebreak
        $form->addElement(new \XoopsFormHidden('linebreak', ''));
        // Form Table accounts
        $accountsHandler = $helper->getHandler('Accounts');
        $traAccidSelect = new \XoopsFormSelect(\_MA_WGSIMPLEACC_FILTERBY_ACCOUNT, 'acc_id', $accId);
        $traAccidSelect->addOption(Constants::FILTER_TYPEALL, \_MA_WGSIMPLEACC_SHOW_ALL);
        $accountsCount = $accountsHandler->getCountAccounts();
        if ($accountsCount > 0) {
            $accountsAll = $accountsHandler->getAllAccounts();
            foreach (\array_keys($accountsAll) as $i) {
                $traAccidSelect->addOption($accountsAll[$i]->getVar('acc_id'), $accountsAll[$i]->getVar('acc_key') . ' ' . $accountsAll[$i]->getVar('acc_name'));
            }
        }
        $form->addElement($traAccidSelect);
        if ($helper->getConfig('use_clients')){
            //linebreak
            $form->addElement(new \XoopsFormHidden('linebreak', ''));
            // Form Table clients
            $clientsHandler = $helper->getHandler('Clients');
            $traCliidSelect = new \XoopsFormSelect(\_MA_WGSIMPLEACC_FILTERBY_CLIENT, 'cli_id', $cliId);
            $traCliidSelect->addOption(Constants::FILTER_TYPEALL, \_MA_WGSIMPLEACC_SHOW_ALL);
            $traCliidSelect->addOptionArray($clientsHandler->getList());
            $form->addElement($traCliidSelect);
        }
        if ('tra_output' === $op) {
            //linebreak
            $form->addElement(new \XoopsFormHidden('linebreak', ''));
            $outputSelect = new \XoopsFormSelect(\_MA_WGSIMPLEACC_FILTER_OUTPUTTYPE, 'output_type', 'xlsx', 5);
            $outputSelect->addOption('csv', 'csv');
            $outputSelect->addOption('xlsx', 'xlsx');
            $form->addElement($outputSelect);
        }

        //linebreak
        $form->addElement(new \XoopsFormHidden('linebreak', ''));
        //button
        if ('tra_output' === $op) {
            $btnApply = new \XoopsFormButton('', 'submit', \_MA_WGSIMPLEACC_FILTER_OUTPUT, 'submit');
        } else {
            $btnApply = new \XoopsFormButton('', 'submit', \_MA_WGSIMPLEACC_FILTER_APPLY, 'submit');
        }
        $form->addElement($btnApply);
        $form->addElement(new \XoopsFormHidden('displayfilter', 1));
        $form->addElement(new \XoopsFormHidden('start', 0));
        $form->addElement(new \XoopsFormHidden('op', $op));
        return $form;
    }

    /**
     * @public function to save old transaction as history before updating or deleting
     * @param int    $traId
     * @param string $type
     * @return bool
     */
    public function saveHistoryTransactions($traId, $type = 'update')
    {
        global $xoopsUser;
        $uid = \is_object($xoopsUser) ? $xoopsUser->uid() : 0;

        $helper = \XoopsModules\Wgsimpleacc\Helper::getInstance();
        $transactionsHandler = $helper->getHandler('Transactions');
        $transactionsObj = $transactionsHandler->get($traId);
        $traVars = $transactionsObj->getVars();

        $insert = 'INSERT INTO ' . $GLOBALS['xoopsDB']->prefix('wgsimpleacc_trahistories') . ' (hist_datecreated, hist_type, hist_submitter';
        $select = 'SELECT ' . \time() . " AS histdatecreated, '$type' AS histtype, '$uid' AS histsubmitter";
        $from = ' FROM '. $GLOBALS['xoopsDB']->prefix('wgsimpleacc_transactions');
        $where = " WHERE (tra_id=$traId)";

        foreach (\array_keys($traVars) as $var) {
            $insert .= ', ' . $var;
            $select .= ', ' . $var;
        }
        $insert .= ') ';
        $GLOBALS['xoopsDB']->queryF($insert . $select . $from . $where) or die ('MySQL-Error: ' . mysqli_error());

        return true;
    }
}
