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
 * Class Object Handler Templates
 */
class TratemplatesHandler extends \XoopsPersistableObjectHandler
{
    /**
     * Constructor
     *
     * @param \XoopsDatabase $db
     */
    public function __construct(\XoopsDatabase $db)
    {
        parent::__construct($db, 'wgsimpleacc_tratemplates', Tratemplates::class, 'ttpl_id', 'ttpl_name');
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
     * Get Count Templates in the database
     * @param int    $start
     * @param int    $limit
     * @param string $sort
     * @param string $order
     * @return int
     */
    public function getCountTratemplates($start = 0, $limit = 0, $sort = 'ttpl_id ASC, ttpl_name', $order = 'ASC')
    {
        $crCountTratemplates = new \CriteriaCompo();
        $crCountTratemplates = $this->getTratemplatesCriteria($crCountTratemplates, $start, $limit, $sort, $order);
        return $this->getCount($crCountTratemplates);
    }

    /**
     * Get All Templates in the database
     * @param int    $start
     * @param int    $limit
     * @param string $sort
     * @param string $order
     * @return array
     */
    public function getAllTratemplates($start = 0, $limit = 0, $sort = 'ttpl_id ASC, ttpl_name', $order = 'ASC')
    {
        $crAllTratemplates = new \CriteriaCompo();
        $crAllTratemplates = $this->getTratemplatesCriteria($crAllTratemplates, $start, $limit, $sort, $order);
        return $this->getAll($crAllTratemplates);
    }

    /**
     * Get Criteria Templates
     * @param        $crTratemplates
     * @param int    $start
     * @param int    $limit
     * @param string $sort
     * @param string $order
     * @return int
     */
    private function getTratemplatesCriteria($crTratemplates, $start, $limit, $sort, $order)
    {
        $crTratemplates->setStart($start);
        $crTratemplates->setLimit($limit);
        $crTratemplates->setSort($sort);
        $crTratemplates->setOrder($order);
        return $crTratemplates;
    }
}
