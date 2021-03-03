<?php

declare(strict_types=1);


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
 * Class Object Handler Filhistories
 */
class FilhistoriesHandler extends \XoopsPersistableObjectHandler
{
	/**
	 * Constructor
	 *
	 * @param \XoopsDatabase $db
	 */
	public function __construct(\XoopsDatabase $db)
	{
		parent::__construct($db, 'wgsimpleacc_filhistories', Filhistories::class, 'hist_id', 'fil_name');
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
	 * Get Count Filhistories in the database
	 * @param int    $start
	 * @param int    $limit
	 * @param string $sort
	 * @param string $order
	 * @return int
	 */
	public function getCountFilhistories($start = 0, $limit = 0, $sort = 'hist_id ASC, fil_name', $order = 'ASC')
	{
		$crCountFilhistories = new \CriteriaCompo();
		$crCountFilhistories = $this->getFilhistoriesCriteria($crCountFilhistories, $start, $limit, $sort, $order);
		return $this->getCount($crCountFilhistories);
	}

	/**
	 * Get All Filhistories in the database
	 * @param int    $start
	 * @param int    $limit
	 * @param string $sort
	 * @param string $order
	 * @return array
	 */
	public function getAllFilhistories($start = 0, $limit = 0, $sort = 'hist_id ASC, fil_name', $order = 'ASC')
	{
		$crAllFilhistories = new \CriteriaCompo();
		$crAllFilhistories = $this->getFilhistoriesCriteria($crAllFilhistories, $start, $limit, $sort, $order);
		return $this->getAll($crAllFilhistories);
	}

	/**
	 * Get Criteria Filhistories
	 * @param        $crFilhistories
	 * @param int    $start
	 * @param int    $limit
	 * @param string $sort
	 * @param string $order
	 * @return int
	 */
	private function getFilhistoriesCriteria($crFilhistories, $start, $limit, $sort, $order)
	{
		$crFilhistories->setStart($start);
		$crFilhistories->setLimit($limit);
		$crFilhistories->setSort($sort);
		$crFilhistories->setOrder($order);
		return $crFilhistories;
	}
}
