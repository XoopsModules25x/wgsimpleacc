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
    public function create($isNew = true): object
    {
        return parent::create($isNew);
    }

    /**
     * retrieve a field
     *
     * @param int $id field id
     * @param null $fields
     * @return \XoopsObject|null reference to the {@link Get} object
     */
    public function get($id = null, $fields = null): ?\XoopsObject
    {
        return parent::get($id, $fields);
    }

    /**
     * get inserted id
     *
     * @return int|string
     */
    public function getInsertId(): int|string
    {
        return $this->db->getInsertId();
    }

    /**
     * Get Count Templates in the database
     * @param int $start
     * @param int $limit
     * @param string $sort
     * @param string $order
     * @return int
     */
    public function getCountTratemplates(int $start = 0, int $limit = 0, string $sort = 'ttpl_id ASC, ttpl_name', string $order = 'ASC'): int
    {
        $crCountTratemplates = new \CriteriaCompo();
        $crCountTratemplates = $this->getTratemplatesCriteria($crCountTratemplates, $start, $limit, $sort, $order);
        return $this->getCount($crCountTratemplates);
    }

    /**
     * Get All Templates in the database
     * @param int $start
     * @param int $limit
     * @param string $sort
     * @param string $order
     * @return array
     */
    public function getAllTratemplates(int $start = 0, int $limit = 0, string $sort = 'ttpl_id ASC, ttpl_name', string $order = 'ASC'): array
    {
        $crAllTratemplates = new \CriteriaCompo();
        $crAllTratemplates = $this->getTratemplatesCriteria($crAllTratemplates, $start, $limit, $sort, $order);
        return $this->getAll($crAllTratemplates);
    }

    /**
     * Get Criteria Templates
     * @param        $crTratemplates
     * @param int $start
     * @param int $limit
     * @param string $sort
     * @param string $order
     */
    private function getTratemplatesCriteria($crTratemplates, int $start, int $limit, string $sort, string $order)
    {
        $crTratemplates->setStart($start);
        $crTratemplates->setLimit($limit);
        $crTratemplates->setSort($sort);
        $crTratemplates->setOrder($order);
        return $crTratemplates;
    }
}
