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
 * Class Object Handler Taxes
 */
class TaxesHandler extends \XoopsPersistableObjectHandler
{
    /**
     * Constructor
     *
     * @param \XoopsDatabase $db
     */
    public function __construct(\XoopsDatabase $db)
    {
        parent::__construct($db, 'wgsimpleacc_taxes', Taxes::class, 'tax_id', 'tax_name');
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
     * Get Count Taxes in the database
     * @param int    $start
     * @param int    $limit
     * @param string $sort
     * @param string $order
     * @return int
     */
    public function getCountTaxes($start = 0, $limit = 0, $sort = 'tax_id ASC, tax_name', $order = 'ASC')
    {
        $crCountTaxes = new \CriteriaCompo();
        $crCountTaxes = $this->getTaxesCriteria($crCountTaxes, $start, $limit, $sort, $order);
        return $this->getCount($crCountTaxes);
    }

    /**
     * Get All Taxes in the database
     * @param int    $start
     * @param int    $limit
     * @param string $sort
     * @param string $order
     * @return array
     */
    public function getAllTaxes($start = 0, $limit = 0, $sort = 'tax_id ASC, tax_name', $order = 'ASC')
    {
        $crAllTaxes = new \CriteriaCompo();
        $crAllTaxes = $this->getTaxesCriteria($crAllTaxes, $start, $limit, $sort, $order);
        return $this->getAll($crAllTaxes);
    }

    /**
     * Get Criteria Taxes
     * @param        $crTaxes
     * @param int    $start
     * @param int    $limit
     * @param string $sort
     * @param string $order
     * @return int
     */
    private function getTaxesCriteria($crTaxes, $start, $limit, $sort, $order)
    {
        $crTaxes->setStart($start);
        $crTaxes->setLimit($limit);
        $crTaxes->setSort($sort);
        $crTaxes->setOrder($order);
        return $crTaxes;
    }

    /**
     * Set given tax as primary
     * @param int $taxId
     * @return bool
     */
    public function setPrimaryTaxes($taxId)
    {
        $helper  = \XoopsModules\Wgsimpleacc\Helper::getInstance();
        $taxesObj = null;
        $taxesHandler = $helper->getHandler('Taxes');
        if (isset($taxId)) {
            $taxesObj = $taxesHandler->get($taxId);
        } else {
            \redirect_header('taxes.php', 3, 'missing Id');
        }

        // reset all
        $strSQL = 'UPDATE ' . $GLOBALS['xoopsDB']->prefix('wgsimpleacc_taxes') . ' SET ' . $GLOBALS['xoopsDB']->prefix('wgsimpleacc_taxes') . '.tax_primary = 0';
        $GLOBALS['xoopsDB']->queryF($strSQL);
        // Set Vars
        $taxesObj->setVar('tax_primary', 1);
        // Insert Data
        if ($taxesHandler->insert($taxesObj)) {
            return true;
        }
        return false;

    }

    /**
     * Get primary tax
     * @return int
     */
    public function getPrimaryTax()
    {
        $taxId = 0;
        $crTaxes = new \CriteriaCompo();
        $crTaxes->add(new \Criteria('tax_primary', 1));
        $taxesCount = $this->getCount($crTaxes);
        $taxesAll = $this->getAll($crTaxes);
        if ($taxesCount > 0) {
            foreach (\array_keys($taxesAll) as $i) {
                $taxId = $taxesAll[$i]->getVar('tax_id');
            }
        }

        return $taxId;

    }
}
