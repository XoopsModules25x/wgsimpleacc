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
 * Class Object Handler Images
 */
class ImagesHandler extends \XoopsPersistableObjectHandler
{
	/**
	 * Constructor
	 *
	 * @param \XoopsDatabase $db
	 */
	public function __construct(\XoopsDatabase $db)
	{
		parent::__construct($db, 'wgsimpleacc_images', Images::class, 'img_id', 'img_traid');
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
	 * Get Count Images in the database
	 * @param int    $start
	 * @param int    $limit
	 * @param string $sort
	 * @param string $order
	 * @return int
	 */
	public function getCountImages($start = 0, $limit = 0, $sort = 'img_id ASC, img_traid', $order = 'ASC')
	{
		$crCountImages = new \CriteriaCompo();
		$crCountImages = $this->getImagesCriteria($crCountImages, $start, $limit, $sort, $order);
		return $this->getCount($crCountImages);
	}

	/**
	 * Get All Images in the database
	 * @param int    $start
	 * @param int    $limit
	 * @param string $sort
	 * @param string $order
	 * @return array
	 */
	public function getAllImages($start = 0, $limit = 0, $sort = 'img_id ASC, img_traid', $order = 'ASC')
	{
		$crAllImages = new \CriteriaCompo();
		$crAllImages = $this->getImagesCriteria($crAllImages, $start, $limit, $sort, $order);
		return $this->getAll($crAllImages);
	}

	/**
	 * Get Criteria Images
	 * @param        $crImages
	 * @param int    $start
	 * @param int    $limit
	 * @param string $sort
	 * @param string $order
	 * @return int
	 */
	private function getImagesCriteria($crImages, $start, $limit, $sort, $order)
	{
		$crImages->setStart($start);
		$crImages->setLimit($limit);
		$crImages->setSort($sort);
		$crImages->setOrder($order);
		return $crImages;
	}
}
