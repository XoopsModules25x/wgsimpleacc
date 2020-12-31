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
        $balancesHandler = $helper->getHandler('Balances');
        $crBalances = new \CriteriaCompo();
        $crBalances->setSort('bal_id');
        $crBalances->setOrder('DESC');
        $crBalances->setStart(0);
        $crBalances->setLimit(50);
        $balancesAll = $balancesHandler->getAll($crBalances);
        $balSelect = new \XoopsFormSelect(\_MA_WGSIMPLEACC_BALANCES_OUT_SELECT, 'bal_ids', '', 10, true);
        foreach (\array_keys($balancesAll) as $i) {
            $balances[$i] = $balancesAll[$i]->getValuesBalances();
            $balSelect->addOption($balances[$i]['bal_id'], $balances[$i]['from'] . ' - ' . $balances[$i]['to'] . ' ' .$balances[$i]['asset']);
        }
        $form->addElement($balSelect);

        $balLevelDetails = new \XoopsFormElementTray(\_MA_WGSIMPLEACC_BALANCES_OUT_LEVEL,'<br>');
        $levelAllocations = new \XoopsFormSelect(\_MA_WGSIMPLEACC_BALANCES_OUT_LEVEL_ALLOC, 'level_alloc', Constants::BALANCES_OUT_LEVEL_SKIP);
        $levelAllocations->addOption(Constants::BALANCES_OUT_LEVEL_SKIP, \_MA_WGSIMPLEACC_BALANCES_OUT_LEVEL_SKIP);
        $levelAllocations->addOption(Constants::BALANCES_OUT_LEVEL_ALLOC1, \_MA_WGSIMPLEACC_BALANCES_OUT_LEVEL_ALLOC1);
        $levelAllocations->addOption(Constants::BALANCES_OUT_LEVEL_ALLOC2, \_MA_WGSIMPLEACC_BALANCES_OUT_LEVEL_ALLOC2);
        $balLevelDetails->addElement($levelAllocations);
        $levelAccounts = new \XoopsFormSelect(\_MA_WGSIMPLEACC_BALANCES_OUT_LEVEL_ACC, 'level_account', Constants::BALANCES_OUT_LEVEL_SKIP);
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
    public static function getListBalances($bal_ids)
    {
        $helper = \XoopsModules\Wgsimpleacc\Helper::getInstance();
        $balancesHandler = $helper->getHandler('Balances');
        $assetsHandler = $helper->getHandler('Assets');

        $crBalIds = implode(',', $bal_ids);
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

        $ret = [];
        $crBalIds = implode(',', $bal_ids);
        $sql = 'SELECT `tra_accid`, Sum(`tra_amountin`) AS Sum_tra_amountin, Sum(`tra_amountout`) AS Sum_tra_amountout ';
        $sql .= 'FROM ' . $xoopsDB->prefix('wgsimpleacc_transactions') . ' ';
        $sql .= 'WHERE ' . $xoopsDB->prefix('wgsimpleacc_transactions') . '.tra_balid IN(' . $crBalIds. ')';
        $sql .= 'GROUP BY ' . $xoopsDB->prefix('wgsimpleacc_transactions') . '.tra_accid ';
        $sql .= 'ORDER BY ' . $xoopsDB->prefix('wgsimpleacc_transactions') . '.tra_accid;';
        $result = $xoopsDB->query($sql);
        while (list($balAccid, $sumIn, $sumOut) = $xoopsDB->fetchRow($result)) {
            $accountsObj = $accountsHandler->get($balAccid);
            $accName = $accountsObj->getVar('acc_key') . ' - ' . $accountsObj->getVar('acc_name');
            $accColor = $accountsObj->getVar('acc_color');
            $amountTotal = ($sumIn - $sumOut);
            $ret[] = [
                'name' => $accName,
                'total_val' => $amountTotal,
                'total' => Utility::FloatToString($amountTotal),
                'amountin_val' => $sumIn,
                'amountin' => Utility::FloatToString($sumIn),
                'amountout_val' => $sumOut,
                'amountout' => Utility::FloatToString($sumOut),
                'date' => \time(),
                'color' => $accColor
            ];
        }

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

        $ret = [];
        $crBalIds = implode(',', $bal_ids);
        $sql = 'SELECT `tra_allid`, Sum(`tra_amountin`) AS Sum_tra_amountin, Sum(`tra_amountout`) AS Sum_tra_amountout ';
        $sql .= 'FROM ' . $xoopsDB->prefix('wgsimpleacc_transactions') . ' ';
        $sql .= 'WHERE ' . $xoopsDB->prefix('wgsimpleacc_transactions') . '.tra_balid IN(' . $crBalIds. ')';
        $sql .= 'GROUP BY ' . $xoopsDB->prefix('wgsimpleacc_transactions') . '.tra_allid ';
        $sql .= 'ORDER BY ' . $xoopsDB->prefix('wgsimpleacc_transactions') . '.tra_allid;';
        $result = $xoopsDB->query($sql);
        while (list($balAllid, $sumIn, $sumOut) = $xoopsDB->fetchRow($result)) {
            $allocationsObj = $allocationsHandler->get($balAllid);
            $allName = $allocationsObj->getVar('all_name');
            $amountTotal = ($sumIn - $sumOut);
            $ret[] = [
                'name' => $allName,
                'total_val' => $amountTotal,
                'total' => Utility::FloatToString($amountTotal),
                'amountin_val' => $sumIn,
                'amountin' => Utility::FloatToString($sumIn),
                'amountout_val' => $sumOut,
                'amountout' => Utility::FloatToString($sumOut),
                'date' => \time()
            ];
        }

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

        $crBalIds = implode(',', $bal_ids);
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
                $allocations_list[] = ['all_id' => $allId, 'all_name' => $allName];
                $sumAmountin = 0;
                $sumAmountout = 0;
                $subAllIds = $allocationsHandler->getSubsOfAllocations($allId);
                foreach ($subAllIds as $subAllId) {
                    $crTransactions = new \CriteriaCompo();
                    $crTransactions->add(new \Criteria('tra_allid', $subAllId));
                    $crTransactions->add(new \Criteria('tra_balid', '(' . $crBalIds . ')', 'IN'));
                    $transactionsAll = $transactionsHandler->getAll($crTransactions);
                    foreach (\array_keys($transactionsAll) as $t) {
                        $sumAmountin += $transactionsAll[$t]->getVar('tra_amountin');
                        $sumAmountout += $transactionsAll[$t]->getVar('tra_amountout');
                    }

                    unset($crTransactions);
                }
                $ret[] = [
                    'name' => $allName,
                    'total_val' => ($sumAmountin - $sumAmountout),
                    'total' => Utility::FloatToString(($sumAmountin - $sumAmountout)),
                    'amountin_val' => $sumAmountin,
                    'amountin' => Utility::FloatToString($sumAmountin),
                    'amountout_val' => $sumAmountout,
                    'amountout' => Utility::FloatToString($sumAmountout),
                    'date' => \time()
                ];
            }
        }
        unset($crAllocations);

        return $ret;
    }


}
