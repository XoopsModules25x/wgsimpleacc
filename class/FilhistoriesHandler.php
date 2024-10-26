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
    public function create($isNew = true): object
    {
        return parent::create($isNew);
    }

    /**
     * retrieve a field
     *
     * @param int $id field id
     * @param null $fields fields
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
     * Get Count Filhistories in the database
     * @param int $start
     * @param int $limit
     * @param string $sort
     * @param string $order
     * @return int
     */
    public function getCountFilhistories(int $start = 0, int $limit = 0, string $sort = 'hist_id ASC, fil_name', string $order = 'ASC'): int
    {
        $crCountFilhistories = new \CriteriaCompo();
        $crCountFilhistories = $this->getFilhistoriesCriteria($crCountFilhistories, $start, $limit, $sort, $order);
        return $this->getCount($crCountFilhistories);
    }

    /**
     * Get All Filhistories in the database
     * @param int $start
     * @param int $limit
     * @param string $sort
     * @param string $order
     * @return array
     */
    public function getAllFilhistories(int $start = 0, int $limit = 0, string $sort = 'hist_id ASC, fil_name', string $order = 'ASC'): array
    {
        $crAllFilhistories = new \CriteriaCompo();
        $crAllFilhistories = $this->getFilhistoriesCriteria($crAllFilhistories, $start, $limit, $sort, $order);
        return $this->getAll($crAllFilhistories);
    }

    /**
     * Get Criteria Filhistories
     * @param        $crFilhistories
     * @param int $start
     * @param int $limit
     * @param string $sort
     * @param string $order
     */
    private function getFilhistoriesCriteria($crFilhistories, int $start, int $limit, string $sort, string $order)
    {
        $crFilhistories->setStart($start);
        $crFilhistories->setLimit($limit);
        $crFilhistories->setSort($sort);
        $crFilhistories->setOrder($order);
        return $crFilhistories;
    }
}
