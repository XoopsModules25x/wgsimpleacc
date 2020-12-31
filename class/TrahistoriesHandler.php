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
 * Class Object Handler Trahistories
 */
class TrahistoriesHandler extends \XoopsPersistableObjectHandler
{
	/**
	 * Constructor
	 *
	 * @param \XoopsDatabase $db
	 */
	public function __construct(\XoopsDatabase $db)
	{
		parent::__construct($db, 'wgsimpleacc_trahistories', Trahistories::class, 'hist_id', 'hist_datecreated');
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
	 * Get Count Trahistories in the database
	 * @param int    $start
	 * @param int    $limit
	 * @param string $sort
	 * @param string $order
	 * @return int
	 */
	public function getCountTrahistories($start = 0, $limit = 0, $sort = 'hist_id', $order = 'DESC')
	{
		$crCountTrahistories = new \CriteriaCompo();
		$crCountTrahistories = $this->getTrahistoriesCriteria($crCountTrahistories, $start, $limit, $sort, $order);
		return $this->getCount($crCountTrahistories);
	}

	/**
	 * Get All Trahistories in the database
	 * @param int    $start
	 * @param int    $limit
	 * @param string $sort
	 * @param string $order
	 * @return array
	 */
	public function getAllTrahistories($start = 0, $limit = 0, $sort = 'hist_id', $order = 'DESC')
	{
		$crAllTrahistories = new \CriteriaCompo();
		$crAllTrahistories = $this->getTrahistoriesCriteria($crAllTrahistories, $start, $limit, $sort, $order);
		return $this->getAll($crAllTrahistories);
	}

	/**
	 * Get Criteria Trahistories
	 * @param        $crTrahistories
	 * @param int    $start
	 * @param int    $limit
	 * @param string $sort
	 * @param string $order
	 * @return int
	 */
	private function getTrahistoriesCriteria($crTrahistories, $start, $limit, $sort, $order)
	{
		$crTrahistories->setStart($start);
		$crTrahistories->setLimit($limit);
		$crTrahistories->setSort($sort);
		$crTrahistories->setOrder($order);
		return $crTrahistories;
	}
}
