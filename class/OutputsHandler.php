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
 * Class Object Handler OutputsHandler
 */
class OutputsHandler extends \XoopsPersistableObjectHandler
{
    /**
     * Constructor
     *
     * @param \XoopsDatabase $db
     */
    public function __construct(\XoopsDatabase $db)
    {
    }

    /**
     * @public function getForm
     * @param bool $action
     * @return \XoopsThemeForm
     */
    public static function getFormBalancesSelect($action = false)
    {
        $helper = \XoopsModules\Wgsimpleacc\Helper::getInstance();
        if (!$action) {
            $action = $_SERVER['REQUEST_URI'];
        }
        // Get Theme Form
        \xoops_load('XoopsFormLoader');
        $form = new \XoopsThemeForm(\_MA_WGSIMPLEACC_BALANCES_OUT_SELECT, 'formBalSelect', $action, 'post', true);
        $form->setExtra('enctype="multipart/form-data"');

        $checkboxList = "<ul class='wgsa-checkboxlist'>\n";
        $sql = 'SELECT `bal_from`, `bal_to`, Sum(`bal_amountstart`) AS Sum_bal_amountstart, Sum(`bal_amountend`) AS Sum_bal_amountend, bal_status, bal_datecreated, bal_submitter ';
        $sql .= 'FROM ' . $GLOBALS['xoopsDB']->prefix('wgsimpleacc_balances') . ' ';
        $sql .= 'GROUP BY ' . $GLOBALS['xoopsDB']->prefix('wgsimpleacc_balances') . '.bal_from, ';
        $sql .= $GLOBALS['xoopsDB']->prefix('wgsimpleacc_balances') . '.bal_to, ';
        $sql .= $GLOBALS['xoopsDB']->prefix('wgsimpleacc_balances') . '.bal_status, ';
        $sql .= $GLOBALS['xoopsDB']->prefix('wgsimpleacc_balances') . '.bal_datecreated, ';
        $sql .= $GLOBALS['xoopsDB']->prefix('wgsimpleacc_balances') . '.bal_submitter ';
        $sql .= 'ORDER BY ' . $GLOBALS['xoopsDB']->prefix('wgsimpleacc_balances') . '.bal_datecreated DESC;';
        $result = $GLOBALS['xoopsDB']->query($sql);
        while (list($balFrom, $balTo, $balAmountStart, $balAmountEnd, $balStatus, $balDatecreated, $balSubmitter) = $GLOBALS['xoopsDB']->fetchRow($result)) {
            $checkboxList .= '<li><input type="checkbox" />';
            $checkboxList .= '<span class="wgsa-input-label">' . date(_SHORTDATESTRING, $balFrom) . ' - ' . date(_SHORTDATESTRING, $balTo) .'</span>';
            $balancesHandler = $helper->getHandler('Balances');
            $crBalancesSub = new \CriteriaCompo();
            $crBalancesSub->add(new \Criteria('bal_from', $balFrom));
            $crBalancesSub->add(new \Criteria('bal_to', $balTo));
            $crBalancesSub->setSort('bal_id');
            $crBalancesSub->setOrder('DESC');
            $balancesSub = $balancesHandler->getAll($crBalancesSub);
            $checkboxList .= '<ul class="wgsa-checkboxlist-nested">';
            foreach (\array_keys($balancesSub) as $bs) {
                $balance = $balancesSub[$bs]->getValuesBalances();
                $checkboxList .= '<li><input id="balIds[' . $balance['bal_id'] . ']" type="checkbox" name="balIds[' . $balance['bal_id'] . ']" value="' . $balance['bal_id'] . '" />';
                $checkboxList .= '<span class="wgsa-input-label">' . $balance['asset'] .'</span>';
                $checkboxList .="</li>\n";
            }
            $checkboxList .= "</li>\n";
            $checkboxList .= "</ul>\n";
            unset($crBalancesSub);
        }
        $checkboxList .= '</ul>';
        $form->addElement(new \XoopsFormLabel(\_MA_WGSIMPLEACC_BALANCES_OUT_SELECT, $checkboxList, 'labelBalids'));

        $balLevelDetails = new \XoopsFormElementTray(\_MA_WGSIMPLEACC_BALANCES_OUT_LEVEL,'<br>');
        $levelAllocations = new \XoopsFormSelect(\_MA_WGSIMPLEACC_BALANCES_OUT_LEVEL_ALLOC, 'level_alloc', $helper->getConfig('balance_level_alloc'));
        $levelAllocations->addOption(Constants::BALANCES_OUT_LEVEL_SKIP, \_MA_WGSIMPLEACC_BALANCES_OUT_LEVEL_SKIP);
        $levelAllocations->addOption(Constants::BALANCES_OUT_LEVEL_ALLOC1, \_MA_WGSIMPLEACC_BALANCES_OUT_LEVEL_ALLOC1);
        $levelAllocations->addOption(Constants::BALANCES_OUT_LEVEL_ALLOC2, \_MA_WGSIMPLEACC_BALANCES_OUT_LEVEL_ALLOC2);
        $balLevelDetails->addElement($levelAllocations);
        $levelAccounts = new \XoopsFormSelect(\_MA_WGSIMPLEACC_BALANCES_OUT_LEVEL_ACC, 'level_account', $helper->getConfig('balance_level_acc'));
        $levelAccounts->addOption(Constants::BALANCES_OUT_LEVEL_SKIP, \_MA_WGSIMPLEACC_BALANCES_OUT_LEVEL_SKIP);
        //$levelAccounts->addOption(Constants::BALANCES_OUT_LEVEL_ACC1, \_MA_WGSIMPLEACC_BALANCES_OUT_LEVEL_ACC1);
        $levelAccounts->addOption(Constants::BALANCES_OUT_LEVEL_ACC2, \_MA_WGSIMPLEACC_BALANCES_OUT_LEVEL_ACC2);
        $balLevelDetails->addElement($levelAccounts);

        $form->addElement($balLevelDetails);

        $form->addElement(new \XoopsFormHidden('op', 'bal_output'));
        $form->addElement(new \XoopsFormButtonTray('', \_MA_WGSIMPLEACC_OUTPUT_BALANCES, 'submit', '', false));

        return $form;
    }

    /**
     * @public function to get list of balances for output
     * @param array $bal_ids
     * @return array
     */
    public function getListBalances($bal_ids)
    {
        $helper = \XoopsModules\Wgsimpleacc\Helper::getInstance();
        $balancesHandler = $helper->getHandler('Balances');
        $assetsHandler = $helper->getHandler('Assets');

        $crBalIds = \implode(',', $bal_ids);
        $crBalances = new \CriteriaCompo();
        $crBalances->add(new \Criteria('bal_id', "($crBalIds)", 'IN'));
        $balancesCount = $balancesHandler->getCount($crBalances);
        $GLOBALS['xoopsTpl']->assign('balancesCount', $balancesCount);
        $balances = [];
        if ($balancesCount > 0) {
            $balancesAll = $balancesHandler->getAll($crBalances);
            foreach (\array_keys($balancesAll) as $i) {
                $balances[$i] = $balancesAll[$i]->getValuesBalances();
                $balances[$i]['color'] = $assetsHandler->get($balances[$i]['bal_asid'])->getVar('as_color');
            }
        }

        return $balances;
    }

    /**
     * Get current value of all assets
     * @param array $bal_ids
     * @return array
     */
    public function getListAccountsValues($bal_ids)
    {
        global $xoopsDB;

        $helper = \XoopsModules\Wgsimpleacc\Helper::getInstance();
        $accountsHandler = $helper->getHandler('Accounts');
        $transactionsHandler = $helper->getHandler('Transactions');

        $crBalIds = \implode(',', $bal_ids);

        $balSource = 'tra_balid';
        $crTransactions = new \CriteriaCompo();
        $crTransactions->add(new \Criteria('tra_balidt', '('. $crBalIds . ')', 'IN'));
        $transactionsCount = $transactionsHandler->getCount($crTransactions);
        if ($transactionsCount > 0) {
            $balSource = 'tra_balidt';
        }
        $ret = [];
        $sql = 'SELECT `tra_accid`, Sum(`tra_amountin`) AS Sum_tra_amountin, Sum(`tra_amountout`) AS Sum_tra_amountout ';
        $sql .= 'FROM ' . $xoopsDB->prefix('wgsimpleacc_transactions') . ' ';
        $sql .= 'WHERE ' . $xoopsDB->prefix('wgsimpleacc_transactions') . '.' . $balSource . ' IN(' . $crBalIds. ')';
        $sql .= 'GROUP BY ' . $xoopsDB->prefix('wgsimpleacc_transactions') . '.tra_accid ';
        $sql .= 'ORDER BY ' . $xoopsDB->prefix('wgsimpleacc_transactions') . '.tra_accid;';
        $result = $xoopsDB->query($sql);
        while (list($balAccid, $sumIn, $sumOut) = $xoopsDB->fetchRow($result)) {
            $accountsObj = $accountsHandler->get($balAccid);
            $accName = $accountsObj->getVar('acc_key') . ' - ' . $accountsObj->getVar('acc_name');
            $accColor = $accountsObj->getVar('acc_color');
            $amountTotal = ($sumIn - $sumOut);
            $ret[] = [
                'weight'        => $accountsObj->getVar('acc_weight'),
                'level'         =>  $accountsObj->getVar('acc_level'),
                'level_symbol'  => \str_repeat( '- ' , $accountsObj->getVar('acc_level')),
                'name'          => $accName,
                'total_val'     => $amountTotal,
                'total'         => Utility::FloatToString($amountTotal),
                'amountin_val'  => $sumIn,
                'amountin'      => Utility::FloatToString($sumIn),
                'amountout_val' => $sumOut,
                'amountout'     => Utility::FloatToString($sumOut),
                'date'          => \time(),
                'color'         => $accColor
            ];
        }
        sort($ret);

        return $ret;

    }

    /**
     * Get current value of all allocations
     * @param array $bal_ids
     * @return array
     */
    public function getListAllocationsValues($bal_ids)
    {
        global $xoopsDB;

        $helper = \XoopsModules\Wgsimpleacc\Helper::getInstance();
        $allocationsHandler = $helper->getHandler('Allocations');
        $transactionsHandler = $helper->getHandler('Transactions');

        $crBalIds = \implode(',', $bal_ids);
        $balSource = 'tra_balid';
        $crTransactions = new \CriteriaCompo();
        $crTransactions->add(new \Criteria('tra_balidt', '('. $crBalIds . ')', 'IN'));
        $transactionsCount = $transactionsHandler->getCount($crTransactions);
        if ($transactionsCount > 0) {
            $balSource = 'tra_balidt';
        }
        $ret = [];
        $sql = 'SELECT `tra_allid`, Sum(`tra_amountin`) AS Sum_tra_amountin, Sum(`tra_amountout`) AS Sum_tra_amountout ';
        $sql .= 'FROM ' . $xoopsDB->prefix('wgsimpleacc_transactions') . ' ';
        $sql .= 'WHERE ' . $xoopsDB->prefix('wgsimpleacc_transactions') . '.' . $balSource . ' IN(' . $crBalIds. ')';
        $sql .= 'GROUP BY ' . $xoopsDB->prefix('wgsimpleacc_transactions') . '.tra_allid ';
        $sql .= 'ORDER BY ' . $xoopsDB->prefix('wgsimpleacc_transactions') . '.tra_allid;';
        $result = $xoopsDB->query($sql);
        while (list($balAllid, $sumIn, $sumOut) = $xoopsDB->fetchRow($result)) {
            $allocationsObj = $allocationsHandler->get($balAllid);
            $amountTotal = ($sumIn - $sumOut);
            $ret[] = [
                'weight'        => $allocationsObj->getVar('all_weight'),
                'level'         => $allocationsObj->getVar('all_level'),
                'level_symbol'  => \str_repeat( '- ' , $allocationsObj->getVar('all_level')),
                'name'          => $allocationsObj->getVar('all_name'),
                'total_val'     => $amountTotal,
                'total'         => Utility::FloatToString($amountTotal),
                'amountin_val'  => $sumIn,
                'amountin'      => Utility::FloatToString($sumIn),
                'amountout_val' => $sumOut,
                'amountout'     => Utility::FloatToString($sumOut),
                'date'          => \time()
            ];
        }
        sort($ret);

        return $ret;

    }

    /**
     * Get current value of level 1 allocations including sub allocs
     * @param array $bal_ids
     * @param       $level
     * @return array
     */
    public function getLevelAllocations($bal_ids, $level = 1)
    {
        $helper = \XoopsModules\Wgsimpleacc\Helper::getInstance();
        $allocationsHandler = $helper->getHandler('Allocations');
        $transactionsHandler = $helper->getHandler('Transactions');

        $crBalIds = \implode(',', $bal_ids);
        $balSource = 'tra_balid';
        $crTransactions = new \CriteriaCompo();
        $crTransactions->add(new \Criteria('tra_balidt', '('. $crBalIds . ')', 'IN'));
        $transactionsCount = $transactionsHandler->getCount($crTransactions);
        if ($transactionsCount > 0) {
            $balSource = 'tra_balidt';
        }
        $ret = [];

        //get all allocations
        $crAllocations = new \CriteriaCompo();
        $crAllocations->add(new \Criteria('all_online', 1));
        $crAllocations->add(new \Criteria('all_level', $level));
        $crAllocations->setSort('all_weight ASC, all_id');
        $crAllocations->setOrder('ASC');
        $allocationsCount = $allocationsHandler->getCount($crAllocations);
        $allocationsAll = $allocationsHandler->getAll($crAllocations);
        if ($allocationsCount > 0) {
            foreach (\array_keys($allocationsAll) as $i) {
                $allId = $allocationsAll[$i]->getVar('all_id');
                $allName = $allocationsAll[$i]->getVar('all_name');
                $allWeight = $allocationsAll[$i]->getVar('all_weight');
                $allLevel = $allocationsAll[$i]->getVar('all_level');
                $allocations_list[] = ['all_id' => $allId, 'all_name' => $allName];
                $sumAmountin = 0;
                $sumAmountout = 0;
                $subAllIds = $allocationsHandler->getSubsOfAllocations($allId);
                foreach ($subAllIds as $subAllId) {
                    $crTransactions = new \CriteriaCompo();
                    $crTransactions->add(new \Criteria('tra_allid', $subAllId));
                    $crTransactions->add(new \Criteria($balSource, '(' . $crBalIds . ')', 'IN'));
                    $transactionsAll = $transactionsHandler->getAll($crTransactions);
                    foreach (\array_keys($transactionsAll) as $t) {
                        $sumAmountin += $transactionsAll[$t]->getVar('tra_amountin');
                        $sumAmountout += $transactionsAll[$t]->getVar('tra_amountout');
                    }

                    unset($crTransactions);
                }
                $ret[] = [
                    'weight'        => $allWeight,
                    'level'         =>  $allLevel,
                    'level_symbol'  => \str_repeat( '- ' , $allLevel),
                    'name'          => $allName,
                    'total_val'     => ($sumAmountin - $sumAmountout),
                    'total'         => Utility::FloatToString(($sumAmountin - $sumAmountout)),
                    'amountin_val'  => $sumAmountin,
                    'amountin'      => Utility::FloatToString($sumAmountin),
                    'amountout_val' => $sumAmountout,
                    'amountout'     => Utility::FloatToString($sumAmountout),
                    'date'          => \time()
                ];
            }
        }
        unset($crAllocations);
        sort($ret);

        return $ret;
    }
}
