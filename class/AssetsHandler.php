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
use XoopsModules\Wgsimpleacc\Utility;

/**
 * Class Object Handler Assets
 */
class AssetsHandler extends \XoopsPersistableObjectHandler
{
    /**
     * Constructor
     *
     * @param \XoopsDatabase $db
     */
    public function __construct(\XoopsDatabase $db)
    {
        parent::__construct($db, 'wgsimpleacc_assets', Assets::class, 'as_id', 'as_name');
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
     * Get Count Assets in the database
     * @param int    $start
     * @param int    $limit
     * @param string $sort
     * @param string $order
     * @return int
     */
    public function getCountAssets($start = 0, $limit = 0, $sort = 'as_id ASC, as_name', $order = 'ASC')
    {
        $crCountAssets = new \CriteriaCompo();
        $crCountAssets = $this->getAssetsCriteria($crCountAssets, $start, $limit, $sort, $order);
        return $this->getCount($crCountAssets);
    }

    /**
     * Get All Assets in the database
     * @param int    $start
     * @param int    $limit
     * @param string $sort
     * @param string $order
     * @return array
     */
    public function getAllAssets($start = 0, $limit = 0, $sort = 'as_id ASC, as_name', $order = 'ASC')
    {
        $crAllAssets = new \CriteriaCompo();
        $crAllAssets = $this->getAssetsCriteria($crAllAssets, $start, $limit, $sort, $order);
        return $this->getAll($crAllAssets);
    }

    /**
     * Get Criteria Assets
     * @param $crAssets
     * @param $start
     * @param $limit
     * @param $sort
     * @param $order
     * @return int
     */
    private function getAssetsCriteria($crAssets, $start, $limit, $sort, $order)
    {
        $crAssets->setStart($start);
        $crAssets->setLimit($limit);
        $crAssets->setSort($sort);
        $crAssets->setOrder($order);
        return $crAssets;
    }

    /**
     * Get current value of all assets
     * @return array
     */
    public function getCurrentAssetsValues()
    {
        global $xoopsDB;

        $helper = \XoopsModules\Wgsimpleacc\Helper::getInstance();
        $assetsHandler = $helper->getHandler('Assets');
        $ret = [];
        $sql = 'SELECT `tra_asid`, Sum(`tra_amountin`) AS Sum_tra_amountin, Sum(`tra_amountout`) AS Sum_tra_amountout ';
        $sql .= 'FROM ' . $xoopsDB->prefix('wgsimpleacc_transactions') . ' ';
        $sql .= 'WHERE `tra_status` > ' . Constants::STATUS_SUBMITTED . ' ';
        $sql .= 'GROUP BY ' . $xoopsDB->prefix('wgsimpleacc_transactions') . '.tra_asid ';
        $sql .= 'ORDER BY ' . $xoopsDB->prefix('wgsimpleacc_transactions') . '.tra_asid;';
        $result = $xoopsDB->query($sql);
        while (list($balAsid, $sumIn, $sumOut) = $xoopsDB->fetchRow($result)) {
            $assetsObj = $assetsHandler->get($balAsid);
            $asName = $assetsObj->getVar('as_name');
            $asColor = $assetsObj->getVar('as_color');
            $asIecalc = $assetsObj->getVar('as_iecalc');
            $amountTotal = ($sumIn - $sumOut);
            $ret[] = ['name' => $asName, 'amount_val' => $amountTotal, 'amount' => Utility::FloatToString($amountTotal), 'date' => \time(), 'color' => $asColor, 'iecalc' => $asIecalc];
        }

        return $ret;

    }

    /**
     * Get value of all assets from last balance
     * @return array
     */
    public function getAssetsValuesLastBalance()
    {
        $helper = \XoopsModules\Wgsimpleacc\Helper::getInstance();
        $assetsHandler = $helper->getHandler('Assets');
        $balancesHandler = $helper->getHandler('Balances');

        $ret = [];
        $assetsAll = $assetsHandler->getAll();
        foreach (\array_keys($assetsAll) as $i) {
            $asId = $assetsAll[$i]->getVar('as_id');
            $asName = $assetsAll[$i]->getVar('as_name');
            $asColor = $assetsAll[$i]->getVar('as_color');
            $balAmount = 0;
            $balDate   = 0;
            $crBalances = new \CriteriaCompo();
            $crBalances->add(new \Criteria('bal_asid', $asId));
            $crBalances->setSort('bal_datecreated');
            $crBalances->setOrder('DESC');
            $crBalances->setStart();
            $crBalances->setLimit(1);
            $balancesAll = $balancesHandler->getAll($crBalances);
            foreach (\array_keys($balancesAll) as $b) {
                $balAmount = $balancesAll[$b]->getVar('bal_amountend');
                $balDate = $balancesAll[$b]->getVar('bal_datecreate');
            }
            unset($crBalances);

            $ret[] = ['id' => $asId, 'name' => $asName, 'amount_val' => $balAmount, 'amount' => Utility::FloatToString($balAmount), 'date' => $balDate, 'color' => $asColor];
        }

        return $ret;

    }

    /**
     * Get value of all assets for a period
     * @param      $dateFrom
     * @param      $dateTo
     * @param bool $includeSum
     * @param bool $onlyApproved
     * @return array
     */
    public function getAssetsValues($dateFrom, $dateTo, $includeSum = false, $onlyApproved = false)
    {
        $helper = \XoopsModules\Wgsimpleacc\Helper::getInstance();
        $transactionsHandler = $helper->getHandler('Transactions');
        $assetsHandler = $helper->getHandler('Assets');
        $balancesHandler = $helper->getHandler('Balances');
        $currenciesHandler = $helper->getHandler('Currencies');

        $ret = [];
        $sumAmountStartTotal = (float)0;
        $sumAmountEndTotal   = (float)0;
        $balCurid = $currenciesHandler->getPrimaryCurrency() > 0 ? $currenciesHandler->getPrimaryCurrency() : 0;

        $assetsAll = $assetsHandler->getAll();
        foreach (\array_keys($assetsAll) as $i) {
            $asId = $assetsAll[$i]->getVar('as_id');
            $asName = $assetsAll[$i]->getVar('as_name');
            $asColor = $assetsAll[$i]->getVar('as_color');
            $asIecalc = $assetsAll[$i]->getVar('as_iecalc');
            $crBalances = new \CriteriaCompo();
            $crBalances->add(new \Criteria('bal_asid', $asId));
            $crBalances->add(new \Criteria('bal_to', $dateFrom, '<'));
            $crBalances->setSort('bal_datecreated');
            $crBalances->setOrder('DESC');
            $crBalances->setStart();
            $crBalances->setLimit(1);
            $balAmountStart = (float)0;
            $sumAmountin    = (float)0;
            $sumAmountout   = (float)0;
            $balDate        = (float)0;
            $balancesAll = $balancesHandler->getAll($crBalances);
            foreach (\array_keys($balancesAll) as $b) {
                $balAmountStart = $balancesAll[$b]->getVar('bal_amountend');
                $balDate = \formatTimestamp($balancesAll[$b]->getVar('bal_to'), 's');
            }
            $crTransactions = new \CriteriaCompo();
            $crTransactions->add(new \Criteria('tra_asid', $asId));
            $crTransactions->add(new \Criteria('tra_date', $dateFrom, '>='));
            $crTransactions->add(new \Criteria('tra_date', $dateTo, '<='));
            if ($onlyApproved) {
                $crTransactions->add(new \Criteria('tra_status', Constants::STATUS_APPROVED, '>='));
            }
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
            $sumAmountStartTotal += $balAmountStart;
            $sumAmountEndTotal += $balAmountEnd;
            $ret[] = [
                'id' => $asId,
                'name' => $asName,
                'date' => $balDate,
                'amount_start_val' => $balAmountStart,
                'amount_start' => Utility::FloatToString($balAmountStart),
                'amount_end_val' => $balAmountEnd,
                'amount_end' => Utility::FloatToString($balAmountEnd),
                'amount_diff' => $balAmountEnd - $balAmountStart,
                'curid' => $balCurid,
                'color' => $asColor,
                'iecalc' => $asIecalc,
            ];
        }
        if ($includeSum) {
            $ret[] = [
                'id' => 0,
                'name' => \_MA_WGSIMPLEACC_SUMS,
                'date' => 0,
                'amount_start_val' => $sumAmountStartTotal,
                'amount_start' => Utility::FloatToString($sumAmountStartTotal),
                'amount_end_val' => $sumAmountEndTotal,
                'amount_end' => Utility::FloatToString($sumAmountEndTotal),
                'curid' => 0,
            ];
        }
        return $ret;
    }

    /**
     * Get value of all assets for a balance
     * @param $balId
     * @param $asId
     * @return array
     */
    /*
    public function getAssetsValuesByBalance($balId, $asId)
    {
        $helper = \XoopsModules\Wgsimpleacc\Helper::getInstance();
        $transactionsHandler = $helper->getHandler('Transactions');
        $assetsHandler = $helper->getHandler('Assets');
        $balancesHandler = $helper->getHandler('Balances');
        $currenciesHandler = $helper->getHandler('Currencies');

        $ret = [];
        $balCurid = $currenciesHandler->getPrimaryCurrency() > 0 ? $currenciesHandler->getPrimaryCurrency() : 0;

        $assetsObj = $assetsHandler->get($asId);
        $asName = $assetsObj->getVar('as_name');
        $balAmountStart = 0;
        $sumAmountin    = 0;
        $sumAmountout   = 0;
        $balDate        = 0;
        $crTransactions = new \CriteriaCompo();
        $crTransactions->add(new \Criteria('tra_asid', $asId));
        $crTransactions->add(new \Criteria('tra_balid', $balId));
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
        $balAmountEnd = $balAmountStart - $sumAmountout + $sumAmountin;
        $ret = [
            'id' => $asId,
            'name' => $asName,
            'date' => $balDate,
            'from' => $balDate,
            'amount_start_val' => $balAmountStart,
            'amount_start' => Utility::FloatToString($balAmountStart),
            'amount_end_val' => $balAmountEnd,
            'amount_end' => Utility::FloatToString($balAmountEnd),
            'curid' => $balCurid,
        ];

        return $ret;
    }
    */

    /**
     * Set given asset as primary
     * @param int $asId
     * @return bool
     */
    public function setPrimaryAssets($asId)
    {
        $helper  = \XoopsModules\Wgsimpleacc\Helper::getInstance();
        $assetsObj = null;
        $assetsHandler = $helper->getHandler('Assets');
        if (isset($asId)) {
            $assetsObj = $assetsHandler->get($asId);
        } else {
            \redirect_header('assets.php', 3, 'missing Id');
        }

        // reset all
        $strSQL = 'UPDATE ' . $GLOBALS['xoopsDB']->prefix('wgsimpleacc_assets') . ' SET ' . $GLOBALS['xoopsDB']->prefix('wgsimpleacc_assets') . '.as_primary = 0';
        $GLOBALS['xoopsDB']->queryF($strSQL);
        // Set Vars
        $assetsObj->setVar('as_primary', 1);
        // Insert Data
        if ($assetsHandler->insert($assetsObj)) {
            return true;
        }
        return false;

    }

    /**
     * Get primary asset
     * @return int
     */
    public function getPrimaryAsset()
    {
        $asId = '';
        $crAssets = new \CriteriaCompo();
        $crAssets->add(new \Criteria('as_primary', 1));
        $assetsCount = $this->getCount($crAssets);
        $assetsAll = $this->getAll($crAssets);
        if ($assetsCount > 0) {
            foreach (\array_keys($assetsAll) as $i) {
                $asId = $assetsAll[$i]->getVar('as_id');
            }
        }

        return $asId;
    }
}
