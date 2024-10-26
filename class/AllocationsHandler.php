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
use XoopsModules\Wgsimpleacc\Constants;

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
     * @return int reference to the {@link Get} object
     */
    public function getInsertId(): int
    {
        return $this->db->getInsertId();
    }

    /**
     * Get Count Allocations in the database
     * @param int $start
     * @param int $limit
     * @param string $sort
     * @param string $order
     * @return int
     */
    public function getCountAllocations(int $start = 0, int $limit = 0, string $sort = 'all_id ASC, all_name', string $order = 'ASC'): int
    {
        $crCountAllocations = new \CriteriaCompo();
        $crCountAllocations = $this->getAllocationsCriteria($crCountAllocations, $start, $limit, $sort, $order);
        return $this->getCount($crCountAllocations);
    }

    /**
     * Get All Allocations in the database
     * @param int $start
     * @param int $limit
     * @param string $sort
     * @param string $order
     * @return array
     */
    public function getAllAllocations(int $start = 0, int $limit = 0, string $sort = 'all_weight ASC, all_id', string $order = 'ASC'): array
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
    private function getAllocationsCriteria($crAllocations, $start, $limit, $sort, $order): int
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
    public function getSelectTreeOfAllocations(): bool|array
    {
        $list = [];

        $crItems           = new \CriteriaCompo();
        $crItems->add(new \Criteria('all_online', Constants::ONOFF_ONLINE));
        $crItems->setSort('all_weight ASC, all_id');
        $crItems->setOrder('ASC');
        $allocationsCount = $this->getCount($crItems);
        $allocationsAll   = $this->getAll($crItems);
        // Table view allocations
        if ($allocationsCount > 0) {
            foreach (\array_keys($allocationsAll) as $i) {
                $level = $allocationsAll[$i]->getVar('all_level');
                /*
                switch ($level) {
                    case 1:
                        $dots = \str_repeat('&#9679; ', $level);
                        break;
                    case 2:
                        $dots = '&nbsp;&nbsp;' . \str_repeat('&#9675; ', $level);
                        break;
                    case 3:
                        $dots = \str_repeat('&nbsp; ', $level) . \str_repeat('&#9726; ', $level);
                        break;
                    case 4:
                    default:
                        $dots = \str_repeat('&nbsp; ', $level) . \str_repeat('&#9725; ', $level);
                        break;
                }*/
                switch ($level) {
                    case 1:
                        $dots = \str_repeat('- ', $level);
                        break;
                    case 2:
                    default:
                        $dots = \str_repeat('&nbsp; ', $level) . \str_repeat('-&nbsp;', $level);
                        break;
                }
                $list[] = ['id' => $allocationsAll[$i]->getVar('all_id'), 'text' => $dots . ' ' . $allocationsAll[$i]->getVar('all_name')];
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
    public function getListOfAllocationsEdit($itemPid): bool|string
    {
        if ($itemPid > 0) {
            $childsAll = '<ol>';
        } else {
            $childsAll = '';
        }

        $helper       = \XoopsModules\Wgsimpleacc\Helper::getInstance();
        $transactionsHandler = $helper->getHandler('Transactions');
        $itemId       = 'all_id';
        $itemName     = 'all_name';
        $itemDesc     = 'all_desc';
        $itemOnline   = 'all_online';

        $crItems           = new \CriteriaCompo();
        $crItems->add(new \Criteria('all_pid', $itemPid));
        $crItems->add(new \Criteria('all_online', Constants::ONOFF_HIDDEN, '<'));
        $crItems->setSort('all_weight ASC, all_datecreated');
        $crItems->setOrder('DESC');
        $itemsCount = $this->getCount($crItems);
        $itemsAll   = $this->getAll($crItems);
        // Table view items
        if ($itemsCount > 0) {
            foreach (\array_keys($itemsAll) as $i) {
                $child     = $this->getListOfAllocationsEdit($itemsAll[$i]->getVar($itemId));
                $childsAll .= '<li style="display: list-item;" class="mjs-nestedSortable-branch mjs-nestedSortable-collapsed" id="menuItem_' . $itemsAll[$i]->getVar($itemId) . '">';
                $childsAll .= '<div class="menuDiv">';
                if ($child) {
                    $childsAll .= '<span id="disclose_icon_' . $itemsAll[$i]->getVar($itemId) . '" title="' . \_MA_WGSIMPLEACC_LIST_CHILDS . '" class="disclose ui-icon ui-icon-plusthick"><span>-</span></span>';
                }
                $childsAll .= '<span>';
                $childsAll .= '<span id="' . $itemsAll[$i]->getVar($itemId) . '" data-id="' . $itemsAll[$i]->getVar($itemId) . '" class="disclose_text itemTitle">' . $itemsAll[$i]->getVar($itemName);
                $itemDescText = (string)$itemsAll[$i]->getVar($itemDesc);
                if ('' !== $itemDescText) {
                    $childsAll .= '<span class="badge wgsa-info-badge" title="' . $itemDescText . '">i</span>';
                }
                $childsAll .= '</span>';
                $childsAll .= '<span class="pull-right">';
                $onlineText = (1 == (int)$itemsAll[$i]->getVar($itemOnline)) ? \_MA_WGSIMPLEACC_ONLINE : \_MA_WGSIMPLEACC_OFFLINE;
                $childsAll .= '<img class="wgsa-img-online" src="' . \WGSIMPLEACC_ICONS_URL . '/32/' . $itemsAll[$i]->getVar($itemOnline) . '.png" title="' . $onlineText . '" alt="' . $onlineText . '">';
                $crTransactions = new \CriteriaCompo();
                $crTransactions->add(new \Criteria('tra_allid', $i));
                $crTransactions->add(new \Criteria('tra_status', Constants::TRASTATUS_DELETED, '>'));
                $transactionsCount = $transactionsHandler->getCount($crTransactions);
                $childsAll .= '<a class="btn btn btn-default wgsa-btn-list';
                if (0 === $transactionsCount) {
                    $childsAll .= ' disabled';
                }
                $childsAll .= '" href="transactions.php?op=list&displayfilter=1&amp;' . $itemId . '=' . $itemsAll[$i]->getVar($itemId) . '" title="' . \_MA_WGSIMPLEACC_TRANSACTIONS . '">(' . $transactionsCount . ') ' . \_MA_WGSIMPLEACC_TRANSACTIONS . '</a>';
                $childsAll .= '<a class="btn btn btn-primary wgsa-btn-list" href="allocations.php?op=edit&amp;' . $itemId . '=' . $itemsAll[$i]->getVar($itemId) . '" title="' . \_EDIT . '">' . \_EDIT . '</a>';
                $childsAll .= '<a class="btn btn btn-danger wgsa-btn-list';
                if ($transactionsCount > 0) {
                    $childsAll .= ' disabled';
                }
                $childsAll .= '" href="allocations.php?op=delete&amp;' . $itemId . '=' . $itemsAll[$i]->getVar($itemId) . '" title="' . \_DELETE . '">' . \_DELETE . '</a>';
                $childsAll .= '</span>';
                $childsAll .= '</span>';
                $childsAll .= '</div>';
                unset($crTransactions);

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
    public function getListOfAllocations($itemPid): bool|string
    {
        if ($itemPid > 0) {
            $childsAll = '<ol>';
        } else {
            $childsAll = '';
        }

        $itemId       = 'all_id';
        $itemName     = 'all_name';

        $crItems           = new \CriteriaCompo();
        $crItems->add(new \Criteria('all_pid', $itemPid));
        $crItems->add(new \Criteria('all_online', Constants::ONOFF_HIDDEN, '<'));
        $crItems->setSort('all_weight ASC, all_datecreated');
        $crItems->setOrder('DESC');
        $itemsCount = $this->getCount($crItems);
        $itemsAll   = $this->getAll($crItems);
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
     * Get array of allocations with all childs
     * @param $allPid
     * @return bool|array
     */
    public function getArrayTreeOfAllocations($allPid): bool|array
    {

        $arrayAllTree = [];

        $helper       = \XoopsModules\Wgsimpleacc\Helper::getInstance();
        $transactionsHandler = $helper->getHandler('Transactions');

        $crItems           = new \CriteriaCompo();
        $crItems->add(new \Criteria('all_pid', $allPid));
        $crItems->add(new \Criteria('all_online', Constants::ONOFF_HIDDEN, '<'));
        $crItems->setSort('all_weight ASC, all_datecreated');
        $crItems->setOrder('DESC');
        $itemsCount = $this->getCount($crItems);
        $itemsAll   = $this->getAll($crItems);
        // Table view items
        if ($itemsCount > 0) {
            foreach (\array_keys($itemsAll) as $i) {
                $crTransactions = new \CriteriaCompo();
                $crTransactions->add(new \Criteria('tra_allid', $i));
                $crTransactions->add(new \Criteria('tra_status', Constants::TRASTATUS_DELETED, '>'));
                $transactionsCount = $transactionsHandler->getCount($crTransactions);
                $arrayAllTree[$i]['id'] = $i;
                $arrayAllTree[$i]['name'] = $itemsAll[$i]->getVar('all_name');
                $arrayAllTree[$i]['tracount'] = $transactionsCount;
                $arrayAllTree[$i]['online'] = 0;
                $arrayAllTree[$i]['online_text'] = \_MA_WGSIMPLEACC_OFFLINE;
                if (Constants::ONOFF_ONLINE == $itemsAll[$i]->getVar('all_online')) {
                    $arrayAllTree[$i]['online'] = 1;
                    $arrayAllTree[$i]['online_text'] = \_MA_WGSIMPLEACC_ONLINE;
                }
                $child     = $this->getArrayTreeOfAllocations($i);
                if ($child) {
                    $arrayAllTree[$i]['child'] = $child;
                    $arrayAllTree[$i]['childs'] = \count($child);
                } else {
                    $arrayAllTree[$i]['child'] = [];
                    $arrayAllTree[$i]['childs'] = 0;
                }
            }
        } else {
            return false;
        }

        return $arrayAllTree;
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
    public function getSubsOfAllocations($allId): bool|array
    {
        $list = [];

        $crItems           = new \CriteriaCompo();
        $crItems->add(new \Criteria('all_online', Constants::ONOFF_ONLINE));
        $crItems->setSort('all_weight ASC, all_id');
        $crItems->setOrder('ASC');
        $allocationsCount = $this->getCount($crItems);
        $allocationsAll   = $this->getAll($crItems);
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
    public function AllocationIsOnline($allId): array
    {
        $allocationObj = $this->get($allId);

        return ['online' => (bool)$allocationObj->getVar('all_online'), 'name' => $allocationObj->getVar('all_name')];
    }
}
