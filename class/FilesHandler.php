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
 * Class Object Handler Files
 */
class FilesHandler extends \XoopsPersistableObjectHandler
{
	/**
	 * Constructor
	 *
	 * @param \XoopsDatabase $db
	 */
	public function __construct(\XoopsDatabase $db)
	{
		parent::__construct($db, 'wgsimpleacc_files', Files::class, 'fil_id', 'fil_name');
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
	 * Get Count Files in the database
	 * @param int    $start
	 * @param int    $limit
	 * @param string $sort
	 * @param string $order
	 * @return int
	 */
	public function getCountFiles($start = 0, $limit = 0, $sort = 'fil_id ASC, fil_name', $order = 'ASC')
	{
		$crCountFiles = new \CriteriaCompo();
		$crCountFiles = $this->getFilesCriteria($crCountFiles, $start, $limit, $sort, $order);
		return $this->getCount($crCountFiles);
	}

	/**
	 * Get All Files in the database
	 * @param int    $start
	 * @param int    $limit
	 * @param string $sort
	 * @param string $order
	 * @return array
	 */
	public function getAllFiles($start = 0, $limit = 0, $sort = 'fil_id ASC, fil_name', $order = 'ASC')
	{
		$crAllFiles = new \CriteriaCompo();
		$crAllFiles = $this->getFilesCriteria($crAllFiles, $start, $limit, $sort, $order);
		return $this->getAll($crAllFiles);
	}

	/**
	 * Get Criteria Files
	 * @param        $crFiles
	 * @param int    $start
	 * @param int    $limit
	 * @param string $sort
	 * @param string $order
	 * @return int
	 */
	private function getFilesCriteria($crFiles, $start, $limit, $sort, $order)
	{
		$crFiles->setStart($start);
		$crFiles->setLimit($limit);
		$crFiles->setSort($sort);
		$crFiles->setOrder($order);
		return $crFiles;
	}
}