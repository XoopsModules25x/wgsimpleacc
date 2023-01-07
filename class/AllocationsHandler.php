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
 * Class Object Handler Allocations
 */
class AllocationsHandler extends \XoopsPersistableObjectHandler
{
    /**
     * Constructor
     *
     * @param \XoopsDatabase $db
     */
    public function __construct(\XoopsDatabase $db)
    {
        parent::__construct($db, 'wgsimpleacc_allocations', Allocations::class, 'all_id', 'all_name');
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
     * Get Count Allocations in the database
     * @param int    $start
     * @param int    $limit
     * @param string $sort
     * @param string $order
     * @return int
     */
    public function getCountAllocations($start = 0, $limit = 0, $sort = 'all_id ASC, all_name', $order = 'ASC')
    {
        $crCountAllocations = new \CriteriaCompo();
        $crCountAllocations = $this->getAllocationsCriteria($crCountAllocations, $start, $limit, $sort, $order);
        return $this->getCount($crCountAllocations);
    }

    /**
     * Get All Allocations in the database
     * @param int    $start
     * @param int    $limit
     * @param string $sort
     * @param string $order
     * @return array
     */
    public function getAllAllocations($start = 0, $limit = 0, $sort = 'all_weight ASC, all_id', $order = 'ASC')
    {
        $crAllAllocations = new \CriteriaCompo();
        $crAllAllocations = $this->getAllocationsCriteria($crAllAllocations, $start, $limit, $sort, $order);
        return $this->getAll($crAllAllocations);
    }

    /**
     * Get Criteria Allocations
     * @param $crAllocations
     * @param $start
     * @param $limit
     * @param $sort
     * @param $order
     * @return int
     */
    private function getAllocationsCriteria($crAllocations, $start, $limit, $sort, $order)
    {
        $crAllocations->setStart($start);
        $crAllocations->setLimit($limit);
        $crAllocations->setSort($sort);
        $crAllocations->setOrder($order);
        return $crAllocations;
    }

    /**
     * Get all allocations for selectbox
     * @return array|false
     */
    public function getSelectTreeOfAllocations()
    {
        $list = [];
        $helper             = \XoopsModules\Wgsimpleacc\Helper::getInstance();
        $allocationsHandler = $helper->getHandler('Allocations');

        $crItems           = new \CriteriaCompo();
        $crItems->add(new \Criteria('all_online', 1));
        $crItems->setSort('all_weight ASC, all_id');
        $crItems->setOrder('ASC');
        $allocationsCount = $allocationsHandler->getCount($crItems);
        $allocationsAll   = $allocationsHandler->getAll($crItems);
        // Table view allocations
        if ($allocationsCount > 0) {
            foreach (\array_keys($allocationsAll) as $i) {
                $list[] = ['id' => $allocationsAll[$i]->getVar('all_id'), 'text' => \str_repeat('- ', $allocationsAll[$i]->getVar('all_level')) . ' ' . $allocationsAll[$i]->getVar('all_name')];
            }
        } else {
            return false;
        }

        return $list;
    }

    /**
     * Get all childs of an item
     * @param $itemPid
     * @return bool|string
     */
    public function getListOfAllocationsEdit($itemPid)
    {
        if ($itemPid > 0) {
            $childsAll = '<ol>';
        } else {
            $childsAll = '';
        }

        $helper       = \XoopsModules\Wgsimpleacc\Helper::getInstance();
        $itemsHandler = $helper->getHandler('Allocations');
        $itemId       = 'all_id';
        $itemName     = 'all_name';
        $itemOnline   = 'all_online';

        $crItems           = new \CriteriaCompo();
        $crItems->add(new \Criteria('all_pid', $itemPid));
        $crItems->setSort('all_weight ASC, all_datecreated');
        $crItems->setOrder('DESC');
        $itemsCount = $itemsHandler->getCount($crItems);
        $itemsAll   = $itemsHandler->getAll($crItems);
        // Table view items
        if ($itemsCount > 0) {
            foreach (\array_keys($itemsAll) as $i) {
                $child     = $this->getListOfAllocationsEdit($itemsAll[$i]->getVar($itemId));
                $childsAll .= '<li style="display: list-item;" class="mjs-nestedSortable-branch mjs-nestedSortable-collapsed" id="menuItem_' . $itemsAll[$i]->getVar($itemId) . '">';

                $childsAll .= '<div class="menuDiv">';
                if ($child) {
                    $childsAll .= '<span title="' . \_MA_WGSIMPLEACC_LIST_CHILDS . '" class="disclose ui-icon ui-icon-plusthick"><span>-</span></span>';
                }
                $childsAll .= '<span>';
                $childsAll .= '<span data-id="' . $itemsAll[$i]->getVar($itemId) . '" class="itemTitle">' . $itemsAll[$i]->getVar($itemName) . '</span>';
                $childsAll .= '<span class="pull-right">';
                $onlineText = (1 == (int)$itemsAll[$i]->getVar($itemOnline)) ? \_MA_WGSIMPLEACC_ONLINE : \_MA_WGSIMPLEACC_OFFLINE;
                $childsAll .= '<img class="wgsa-img-online" src="' . \WGSIMPLEACC_ICONS_URL . '/32/' . $itemsAll[$i]->getVar($itemOnline) . '.png" title="' . $onlineText . '" alt="' . $onlineText . '">';
                $childsAll .= '<a class="btn btn btn-default wgsa-btn-list" href="transactions.php?op=list&displayfilter=1&amp;' . $itemId . '=' . $itemsAll[$i]->getVar($itemId) . '" title="' . \_MA_WGSIMPLEACC_TRANSACTIONS . '">' . \_MA_WGSIMPLEACC_TRANSACTIONS . '</a>';
                $childsAll .= '<a class="btn btn btn-primary wgsa-btn-list" href="allocations.php?op=edit&amp;' . $itemId . '=' . $itemsAll[$i]->getVar($itemId) . '" title="' . \_EDIT . '">' . \_EDIT . '</a>';
                $childsAll .= '<a class="btn btn btn-danger wgsa-btn-list" href="allocations.php?op=delete&amp;' . $itemId . '=' . $itemsAll[$i]->getVar($itemId) . '" title="' . \_DELETE . '">' . \_DELETE . '</a>';
                $childsAll .= '</span>';
                $childsAll .= '</span>';
                $childsAll .= '</div>';

                if ($child) {
                    $childsAll .= $child;
                }
                $childsAll .= '</li>';
            }
        } else {
            return false;
        }
        if ($itemPid > 0) {
            $childsAll .= '</ol>';
        }

        return $childsAll;
    }

    /**
     * Get all childs of an item
     * @param $itemPid
     * @return bool|string
     */
    public function getListOfAllocations($itemPid)
    {
        if ($itemPid > 0) {
            $childsAll = '<ol>';
        } else {
            $childsAll = '';
        }

        $helper       = \XoopsModules\Wgsimpleacc\Helper::getInstance();
        $itemsHandler = $helper->getHandler('Allocations');
        $itemId       = 'all_id';
        $itemName     = 'all_name';

        $crItems           = new \CriteriaCompo();
        $crItems->add(new \Criteria('all_pid', $itemPid));
        $crItems->setSort('all_weight ASC, all_datecreated');
        $crItems->setOrder('DESC');
        $itemsCount = $itemsHandler->getCount($crItems);
        $itemsAll   = $itemsHandler->getAll($crItems);
        // Table view items
        if ($itemsCount > 0) {
            foreach (\array_keys($itemsAll) as $i) {
                $child     = $this->getListOfAllocations($itemsAll[$i]->getVar($itemId));
                $childsAll .= '<li style="display: list-item;" class="mjs-nestedSortable-branch " id="menuItem_' . $itemsAll[$i]->getVar($itemId) . '">';

                $childsAll .= '<div class="menuDiv">';
                $childsAll .= '<span>';
                $childsAll .= '<span data-id="' . $itemsAll[$i]->getVar($itemId) . '" class="itemTitle">' . $itemsAll[$i]->getVar($itemName) . '</span>';
                $childsAll .= '</span>';
                $childsAll .= '</div>';

                if ($child) {
                    $childsAll .= $child;
                }
                $childsAll .= '</li>';
            }
        } else {
            return false;
        }
        if ($itemPid > 0) {
            $childsAll .= '</ol>';
        }

        return $childsAll;
    }

    /**
     * Get all allocations of level
     * @param $level
     * @return string

    public function getAllocationSum($allId, $sumIn, $sumOut)
    {
        $list = [];
        $helper             = \XoopsModules\Wgsimpleacc\Helper::getInstance();
        $allocationsHandler = $helper->getHandler('Allocations');
        $permissionsHandler = $helper->getHandler('Permissions');

        $crItems           = new \CriteriaCompo();
        $crItems->add(new \Criteria('all_online', 1));
        $crItems->add(new \Criteria('all_pid', $allId));
        $crItems->setSort('all_weight ASC, all_id');
        $crItems->setOrder('ASC');
        $allocationsCount = $allocationsHandler->getCount($crItems);
        $allocationsAll   = $allocationsHandler->getAll($crItems);
        // Table view allocations
        if ($allocationsCount > 0) {
            foreach (\array_keys($allocationsAll) as $i) {
                $sumIn += 1;
                $child     = $this->getAllocationSum($allocationsAll[$i]->getVar('all_id'), $sumIn, $sumOut);
                if ($child) {
                    //$childsAll .= $child;
                }
                if ($permissionsHandler->getPermAllocationsSubmit()) {
                    $list[] = ['id' => $allocationsAll[$i]->getVar('all_id'), 'text' => \str_repeat('- ', $allocationsAll[$i]->getVar('all_level')) . ' ' . $allocationsAll[$i]->getVar('all_name')];
                }
            }
        } else {
            return false;
        }

        return $list;
    }*/


    /**
    * Get all sub allocations for given allocation
    * @param $allId
    * @return array|false
    */
    public function getSubsOfAllocations($allId)
    {
        $list = [];
        $helper             = \XoopsModules\Wgsimpleacc\Helper::getInstance();
        $allocationsHandler = $helper->getHandler('Allocations');

        $crItems           = new \CriteriaCompo();
        $crItems->add(new \Criteria('all_online', 1));
        $crItems->setSort('all_weight ASC, all_id');
        $crItems->setOrder('ASC');
        $allocationsCount = $allocationsHandler->getCount($crItems);
        $allocationsAll   = $allocationsHandler->getAll($crItems);
        // Table view allocations
        if ($allocationsCount > 0) {
            foreach (\array_keys($allocationsAll) as $i) {
                if ($allocationsAll[$i]->getVar('all_id') == $allId || \in_array($allocationsAll[$i]->getVar('all_pid'), $list)) {
                    $list[] = $allocationsAll[$i]->getVar('all_id');
                }
            }
        } else {
            return false;
        }

        return $list;
    }

    /**
     * Check whether given allocation is online or not
     * @param $allId
     * @return array
     */
    public function AllocationIsOnline($allId)
    {
        $allocationObj = $this->get($allId);

        return ['online' => (bool)$allocationObj->getVar('all_online'), 'name' => $allocationObj->getVar('all_name')];
    }
}
