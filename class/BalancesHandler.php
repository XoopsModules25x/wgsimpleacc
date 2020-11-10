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
 * @author         XOOPS Development Team - Email:<webmaster@wedega.com> - Website:<https://xoops.wedega.com>
 */

use XoopsModules\Wgsimpleacc;


/**
 * Class Object Handler Balances
 */
class BalancesHandler extends \XoopsPersistableObjectHandler
{
	/**
	 * Constructor
	 *
	 * @param \XoopsDatabase $db
	 */
	public function __construct(\XoopsDatabase $db)
	{
		parent::__construct($db, 'wgsimpleacc_balances', Balances::class, 'bal_id', 'bal_id');
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
	 * Get Count Balances in the database
	 * @param int    $start
	 * @param int    $limit
	 * @param string $sort
	 * @param string $order
	 * @return int
	 */
	public function getCountBalances($start = 0, $limit = 0, $sort = 'bal_id', $order = 'ASC')
	{
		$crCountBalances = new \CriteriaCompo();
		$crCountBalances = $this->getBalancesCriteria($crCountBalances, $start, $limit, $sort, $order);
		return $this->getCount($crCountBalances);
	}

	/**
	 * Get All Balances in the database
	 * @param int    $start
	 * @param int    $limit
	 * @param string $sort
	 * @param string $order
	 * @return array
	 */
	public function getAllBalances($start = 0, $limit = 0, $sort = 'bal_to DESC, bal_asid', $order = 'ASC')
	{
		$crAllBalances = new \CriteriaCompo();
		$crAllBalances = $this->getBalancesCriteria($crAllBalances, $start, $limit, $sort, $order);
		return $this->getAll($crAllBalances);
	}

	/**
	 * Get Criteria Balances
	 * @param        $crBalances
	 * @param int    $start
	 * @param int    $limit
	 * @param string $sort
	 * @param string $order
	 * @return int
	 */
	private function getBalancesCriteria($crBalances, $start, $limit, $sort, $order)
	{
		$crBalances->setStart($start);
		$crBalances->setLimit($limit);
		$crBalances->setSort($sort);
		$crBalances->setOrder($order);
		return $crBalances;
	}

    /**
     * Get current value of all assets
     * @return array
     */
    public function getCurrentAssetsValues()
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
            $crBalances->setStart(0);
            $crBalances->setLimit(1);
            $balancesAll = $balancesHandler->getAll($crBalances);
            foreach (\array_keys($balancesAll) as $b) {
                $balAmount = $balancesAll[$b]->getVar('bal_amount');
                $balDate = $balancesAll[$b]->getVar('bal_datecreate');
            }
            unset($crBalances);

            $ret[] = ['name' => $asName, 'amount_val' => $balAmount, 'amount' => Utility::FloatToString($balAmount), 'date' => $balDate, 'color' => $asColor];
        }

        return $ret;

    }
}
