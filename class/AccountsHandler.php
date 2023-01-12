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
use XoopsModules\Wgsimpleacc\Constants;

/**
 * Class Object Handler Accounts
 */
class AccountsHandler extends \XoopsPersistableObjectHandler
{
    /**
     * Constructor
     *
     * @param \XoopsDatabase $db
     */
    public function __construct(\XoopsDatabase $db)
    {
        parent::__construct($db, 'wgsimpleacc_accounts', Accounts::class, 'acc_id', 'acc_key');
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
     * @param int $id field id
     * @param null fields
     * @return \XoopsObject|null reference to the {@link Get} object
     */
    public function get($id = null, $fields = null)
    {
        return parent::get($id, $fields);
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
     * Get Count Accounts in the database
     * @param int    $start
     * @param int    $limit
     * @param string $sort
     * @param string $order
     * @return int
     */
    public function getCountAccounts($start = 0, $limit = 0, $sort = 'acc_key ASC, acc_id', $order = 'ASC')
    {
        $crCountAccounts = new \CriteriaCompo();
        $crCountAccounts = $this->getAccountsCriteria($crCountAccounts, $start, $limit, $sort, $order);
        return $this->getCount($crCountAccounts);
    }

    /**
     * Get All Accounts in the database
     * @param int    $start
     * @param int    $limit
     * @param string $sort
     * @param string $order
     * @return array
     */
    public function getAllAccounts($start = 0, $limit = 0, $sort = 'acc_weight ASC, acc_key ASC, acc_id', $order = 'ASC')
    {
        $crAllAccounts = new \CriteriaCompo();
        $crAllAccounts = $this->getAccountsCriteria($crAllAccounts, $start, $limit, $sort, $order);
        return $this->getAll($crAllAccounts);
    }

    /**
     * Get Criteria Accounts
     * @param $crAccounts
     * @param $start
     * @param $limit
     * @param $sort
     * @param $order
     * @return int
     */
    private function getAccountsCriteria($crAccounts, $start, $limit, $sort, $order)
    {
        $crAccounts->setStart($start);
        $crAccounts->setLimit($limit);
        $crAccounts->setSort($sort);
        $crAccounts->setOrder($order);
        return $crAccounts;
    }

    /**
     * Get all accounts for selectbox
     * @param $class
     * @return array|false
     */
    public function getSelectTreeOfAccounts($class)
    {
        $list = [];
        $helper          = \XoopsModules\Wgsimpleacc\Helper::getInstance();
        $accountsHandler = $helper->getHandler('Accounts');

        $crItems = new \CriteriaCompo();
        $crItems->add(new \Criteria('acc_online', 1));
        if ($class > Constants::CLASS_BOTH) {
            $crItemClass = new \CriteriaCompo();
            $crItemClass->add(new \Criteria('acc_classification', $class));
            $crItemClass->add(new \Criteria('acc_classification', Constants::CLASS_BOTH), 'OR');
            $crItems->add($crItemClass);
        }
        $crItems->setSort('acc_weight ASC, acc_key');
        $crItems->setOrder('ASC');
        $accountsCount = $accountsHandler->getCount($crItems);
        $accountsAll   = $accountsHandler->getAll($crItems);
        // Table view accounts
        if ($accountsCount > 0) {
            foreach (\array_keys($accountsAll) as $i) {
                $level = $accountsAll[$i]->getVar('acc_level');
                switch ($level) {
                    case 1:
                        $dots = \str_repeat('- ', $level);
                        break;
                    case 2:
                    default:
                        $dots = \str_repeat('&nbsp; ', $level) . \str_repeat('- ', $level);
                        break;
                }
                $list[] = ['id' => $accountsAll[$i]->getVar('acc_id'), 'text' => $dots . $accountsAll[$i]->getVar('acc_key') . ' ' . $accountsAll[$i]->getVar('acc_name')];
            }
        } else {
            return false;
        }

        return $list;
    }

    /**
     * Get all childs of an item
     * @param $itemPid
     * @return bool|string
     */
    public function getListOfAccountsEdit($itemPid)
    {
        if ($itemPid > 0) {
            $childsAll = '<ol>';
        } else {
            $childsAll = '';
        }

        $helper       = \XoopsModules\Wgsimpleacc\Helper::getInstance();
        $transactionsHandler = $helper->getHandler('Transactions');
        $itemsHandler = $helper->getHandler('Accounts');
        $itemId       = 'acc_id';
        $itemKey      = 'acc_key';
        $itemName     = 'acc_name';
        $itemColor    = 'acc_color';
        $itemOnline   = 'acc_online';
        $itemClass    = 'acc_classification';

        $crItems           = new \CriteriaCompo();
        $crItems->add(new \Criteria('acc_pid', $itemPid));
        $crItems->setSort('acc_weight ASC, acc_datecreated');
        $crItems->setOrder('DESC');
        $itemsCount = $itemsHandler->getCount($crItems);
        $itemsAll   = $itemsHandler->getAll($crItems);
        // Table view items
        if ($itemsCount > 0) {
            foreach (\array_keys($itemsAll) as $i) {
                $child     = $this->getListOfAccountsEdit($itemsAll[$i]->getVar($itemId));
                $childsAll .= '<li style="display: list-item;" class="mjs-nestedSortable-branch mjs-nestedSortable-collapsed" id="menuItem_' . $itemsAll[$i]->getVar($itemId) . '">';
                $childsAll .= '<div class="menuDiv">';
                if ($child) {
                    $childsAll .= '<span id="disclose_icon_' . $itemsAll[$i]->getVar($itemId) . '" title="' . \_MA_WGSIMPLEACC_LIST_CHILDS . '" class="disclose ui-icon ui-icon-plusthick"><span>-</span></span>';
                }
                $childsAll .= '<span>';
                $childsAll .= '<span id="' . $itemsAll[$i]->getVar($itemId) . '" data-id="' . $itemsAll[$i]->getVar($itemId) . '" class="disclose_text itemTitle"><span style="background-color:' . $itemsAll[$i]->getVar($itemColor) . '">&nbsp;&nbsp;&nbsp;</span> ' . $itemsAll[$i]->getVar($itemKey) . ' ' . $itemsAll[$i]->getVar($itemName) . '</span>';

                $childsAll .= '<span class="pull-right">';
                $onlineText = (1 == (int)$itemsAll[$i]->getVar($itemOnline)) ? \_MA_WGSIMPLEACC_ONLINE : \_MA_WGSIMPLEACC_OFFLINE;
                switch ($itemsAll[$i]->getVar($itemClass)) {
                    case 'default':
                    default:
                        $childsAll .= '<img class="wgsa-img" src="' . \WGSIMPLEACC_ICONS_URL . '/32/incomes.png" title="' . \_MA_WGSIMPLEACC_TRANSACTIONS_INCOMES . '" alt="' . \_MA_WGSIMPLEACC_TRANSACTIONS_INCOMES . '">';
                        $childsAll .= '<img class="wgsa-img" src="' . \WGSIMPLEACC_ICONS_URL . '/32/expenses.png" title="' . \_MA_WGSIMPLEACC_TRANSACTIONS_EXPENSES . '" alt="' . \_MA_WGSIMPLEACC_TRANSACTIONS_EXPENSES . '">';
                        break;
                    case Constants::CLASS_EXPENSES:
                        $childsAll .= '<img class="wgsa-img-online" src="' . \WGSIMPLEACC_ICONS_URL . '/32/expenses.png" title="' . \_MA_WGSIMPLEACC_TRANSACTIONS_EXPENSES . '" alt="' . \_MA_WGSIMPLEACC_TRANSACTIONS_EXPENSES . '">';
                        break;
                    case Constants::CLASS_INCOME:
                        $childsAll .= '<img class="wgsa-img-online" src="' . \WGSIMPLEACC_ICONS_URL . '/32/incomes.png" title="' . \_MA_WGSIMPLEACC_TRANSACTIONS_INCOMES . '" alt="' . \_MA_WGSIMPLEACC_TRANSACTIONS_INCOMES . '">';
                        break;
                }
                $crTransactions = new \CriteriaCompo();
                $crTransactions->add(new \Criteria('tra_accid', $i));
                $transactionsCount = $transactionsHandler->getCount($crTransactions);
                $childsAll .= '<img class="wgsa-img-online" src="' . \WGSIMPLEACC_ICONS_URL . '/32/' . $itemsAll[$i]->getVar($itemOnline) . '.png" title="' . $onlineText . '" alt="' . $onlineText . '">';
                $childsAll .= '<a class="btn btn-default wgsa-btn-list';
                if (0 === $transactionsCount) {
                    $childsAll .= ' disabled';
                }
                $childsAll .= '" href="transactions.php?op=list&displayfilter=1&amp;' . $itemId . '=' . $itemsAll[$i]->getVar($itemId) . '" title="' . \_MA_WGSIMPLEACC_TRANSACTIONS . '">(' . $transactionsCount . ') ' . \_MA_WGSIMPLEACC_TRANSACTIONS . '</a>';
                $childsAll .= '<a class="btn btn-primary wgsa-btn-list" href="accounts.php?op=edit&amp;' . $itemId . '=' . $itemsAll[$i]->getVar($itemId) . '" title="' . \_EDIT . '">' . \_EDIT . '</a>';
                $childsAll .= '<a class="btn btn btn-danger wgsa-btn-list';
                if ($transactionsCount > 0) {
                    $childsAll .= ' disabled';
                }
                $childsAll .= '" href="accounts.php?op=delete&amp;' . $itemId . '=' . $itemsAll[$i]->getVar($itemId) . '" title="' . \_DELETE . '">' . \_DELETE . '</a>';
                $childsAll .= '</span>';
                $childsAll .= '</span>';
                $childsAll .= '</div>';
                unset($crTransactions);

                if ($child) {
                    $childsAll .= $child;
                }
                $childsAll .= '</li>';
            }
        } else {
            return false;
        }
        if ($itemPid > 0) {
            $childsAll .= '</ol>';
        }

        return $childsAll;
    }

    /**
     * Get all childs of an item
     * @param $itemPid
     * @return bool|string
     */
    public function getListOfAccounts($itemPid)
    {
        if ($itemPid > 0) {
            $childsAll = '<ol>';
        } else {
            $childsAll = '';
        }

        $helper             = \XoopsModules\Wgsimpleacc\Helper::getInstance();
        $itemsHandler      = $helper->getHandler('Accounts');
        $itemId        = 'acc_id';
        $itemKey       = 'acc_key';
        $itemName      = 'acc_name';
        $itemColor     = 'acc_color';

        $crItems           = new \CriteriaCompo();
        $crItems->add(new \Criteria('acc_pid', $itemPid));
        $crItems->setSort('acc_weight ASC, acc_datecreated');
        $crItems->setOrder('DESC');
        $itemsCount = $itemsHandler->getCount($crItems);
        $itemsAll   = $itemsHandler->getAll($crItems);
        // Table view items
        if ($itemsCount > 0) {
            foreach (\array_keys($itemsAll) as $i) {
                $child     = $this->getListOfAccounts($itemsAll[$i]->getVar($itemId));
                $childsAll .= '<li style="display: list-item;" class="mjs-nestedSortable-branch " id="menuItem_' . $itemsAll[$i]->getVar($itemId) . '">';

                $childsAll .= '<div class="menuDiv">';
                $childsAll .= '<span>';
                $childsAll .= '<span data-id="' . $itemsAll[$i]->getVar($itemId) . '" class="itemTitle"><span style="background-color:' . $itemsAll[$i]->getVar($itemColor) . '">&nbsp;&nbsp;&nbsp;</span> ' . $itemsAll[$i]->getVar($itemKey) . ' ' . $itemsAll[$i]->getVar($itemName) . '</span>';
                $childsAll .= '</span>';
                $childsAll .= '</div>';

                if ($child) {
                    $childsAll .= $child;
                }
                $childsAll .= '</li>';
            }
        } else {
            return false;
        }
        if ($itemPid > 0) {
            $childsAll .= '</ol>';
        }

        return $childsAll;
    }

    /**
     * Get top level of given accounts
     * @param $accId
     * @return array
     */
    public function getTopLevelAccount($accId)
    {
        $helper             = \XoopsModules\Wgsimpleacc\Helper::getInstance();
        $accountsHandler    = $helper->getHandler('Accounts');

        $ret = [];
        $accountsObj = $accountsHandler->get($accId);
        $ret['id']   = $accId;
        $ret['name'] = $accountsObj->getVar('acc_name');
        $ret['color'] = $accountsObj->getVar('acc_color');
        $accPid = $accountsObj->getVar('acc_pid');
        unset($accountsObj);
        if ($accPid > 0) {
            while ($accPid > 0) {
                $accountsObj = $accountsHandler->get($accPid);
                $ret['id']   = $accPid;
                $ret['name'] = $accountsObj->getVar('acc_name');
                $ret['color'] = $accountsObj->getVar('acc_color');
                $accPid = $accountsObj->getVar('acc_pid');
                unset($accountsObj);
            }
        }

        return $ret;
    }

    /**
     * Get value of all accounts for a period
     * @param array $bal_ids
     * @return array
     */
    /*
    public function getAccountsValues($bal_ids)
    {
        $helper = \XoopsModules\Wgsimpleacc\Helper::getInstance();
        $transactionsHandler = $helper->getHandler('Transactions');
        $accountsHandler = $helper->getHandler('Accounts');
        $currenciesHandler = $helper->getHandler('Currencies');

        $ret = [];
        $balAmountStart = 0;
        $sumAmountin = 0;
        $sumAmountout = 0;
        $crBalIds = \implode(',', $bal_ids);
        $balCurid = $currenciesHandler->getPrimaryCurrency() > 0 ? $currenciesHandler->getPrimaryCurrency() : 0;

        $accountsAll = $accountsHandler->getAll();
        foreach (\array_keys($accountsAll) as $i) {
            $accId = $accountsAll[$i]->getVar('acc_id');
            $accName = $accountsAll[$i]->getVar('acc_name');
            $crTransactions = new \CriteriaCompo();
            $crTransactions->add(new \Criteria('tra_accid', $accId));
            $crTransactions->add(new \Criteria('tra_balid', "($crBalIds)", 'IN'));
            $transactionsCount = $transactionsHandler->getCount($crTransactions);
            $transactionsAll   = $transactionsHandler->getAll($crTransactions);
            if ($transactionsCount > 0) {
                foreach (\array_keys($transactionsAll) as $t) {
                    $sumAmountin += $transactionsAll[$t]->getVar('tra_amountin');
                    $sumAmountout += $transactionsAll[$t]->getVar('tra_amountout');
                    $balCurid = $transactionsAll[$t]->getVar('tra_curid'); //TODO: handle multiple currencies
                }
            }
            unset($crTransactions);
            unset($crBalances);
            $balAmountEnd = $balAmountStart - $sumAmountout + $sumAmountin;
            $ret[] = [
                'id' => $accId,
                'name' => $accName,
                'amount_start_val' => $balAmountStart,
                'amount_start' => Utility::FloatToString($balAmountStart),
                'amount_end_val' => $balAmountEnd,
                'amount_end' => Utility::FloatToString($balAmountEnd),
                'diffence' => Utility::FloatToString($balAmountStart + $balAmountEnd),
                'curid' => $balCurid,
            ];
        }

        return $ret;
    }
    */

    /**
     * Get all sub accounts for given account
     * @param $accId
     * @return array|false
     */
    public function getSubsOfAccounts($accId)
    {
        $list = [];
        $helper             = \XoopsModules\Wgsimpleacc\Helper::getInstance();
        $accountsHandler = $helper->getHandler('accounts');

        $crItems           = new \CriteriaCompo();
        $crItems->add(new \Criteria('acc_online', 1));
        $crItems->setSort('acc_weight ASC, acc_id');
        $crItems->setOrder('ASC');
        $accountsCount = $accountsHandler->getCount($crItems);
        $accountsAll   = $accountsHandler->getAll($crItems);
        // Table view accounts
        if ($accountsCount > 0) {
            foreach (\array_keys($accountsAll) as $i) {
                if ($accountsAll[$i]->getVar('acc_id') == $accId || \in_array($accountsAll[$i]->getVar('acc_pid'), $list)) {
                    $list[] = $accountsAll[$i]->getVar('acc_id');
                }
            }
        } else {
            return false;
        }

        return $list;
    }

    /**
     * Check whether given account is online or not
     * @param $accId
     * @return array
     */
    public function AccountIsOnline($accId)
    {
        $accountObj = $this->get($accId);

        return ['online' => (bool)$accountObj->getVar('acc_online'), 'name' => $accountObj->getVar('acc_key') . ' ' . $accountObj->getVar('acc_name')];
    }
    
}
