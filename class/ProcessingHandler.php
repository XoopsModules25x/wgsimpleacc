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
 * Class Object Handler Processing
 */
class ProcessingHandler extends \XoopsPersistableObjectHandler
{
    /**
     * Constructor
     *
     * @param \XoopsDatabase $db
     */
    public function __construct(\XoopsDatabase $db)
    {
        parent::__construct($db, 'wgsimpleacc_processing', Processing::class, 'pro_id', 'pro_text');
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
     * @return int reference to the {@link Get} object
     */
    public function getInsertId()
    {
        return $this->db->getInsertId();
    }

    /**
     * Get Count Processing in the database
     * @param int    $start
     * @param int    $limit
     * @param string $sort
     * @param string $order
     * @return int
     */
    public function getCountProcessing($start = 0, $limit = 0, $sort = 'pro_weight', $order = 'ASC')
    {
        $crCountProcessing = new \CriteriaCompo();
        $crCountProcessing = $this->getProcessingCriteria($crCountProcessing, $start, $limit, $sort, $order);
        return $this->getCount($crCountProcessing);
    }

    /**
     * Get All Processing in the database
     * @param int    $start
     * @param int    $limit
     * @param string $sort
     * @param string $order
     * @return array
     */
    public function getAllProcessing($start = 0, $limit = 0, $sort = 'pro_weight', $order = 'ASC')
    {
        $crAllProcessing = new \CriteriaCompo();
        $crAllProcessing = $this->getProcessingCriteria($crAllProcessing, $start, $limit, $sort, $order);
        return $this->getAll($crAllProcessing);
    }

    /**
     * Get Criteria Processing
     * @param \CriteriaCompo $crProcessing
     * @param int $start
     * @param int $limit
     * @param string $sort
     * @param string $order
     * @return \CriteriaCompo
     */
    private function getProcessingCriteria($crProcessing, $start, $limit, $sort, $order)
    {
        $crProcessing->setStart($start);
        $crProcessing->setLimit($limit);
        $crProcessing->setSort($sort);
        $crProcessing->setOrder($order);
        return $crProcessing;
    }
}
