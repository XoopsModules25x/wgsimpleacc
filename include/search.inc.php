<?php
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
use XoopsModules\Wgsimpleacc\Helper;

/**
 * search callback functions
 *
 * @param $queryarray
 * @param $andor
 * @param $limit
 * @param $offset
 * @param $userid
 * @return array $itemIds
 */
function wgsimpleacc_search($queryarray, $andor, $limit, $offset, $userid)
{
    $ret = [];
    $helper = Helper::getInstance();

    // search in table transactions
    // search keywords
    $elementCount = 0;
    $transactionsHandler = $helper->getHandler('Transactions');
    if (\is_array($queryarray)) {
        $elementCount = \count($queryarray);
    }
    if ($elementCount > 0) {
        $crKeywords = new \CriteriaCompo();
        for ($i = 0; $i  <  $elementCount; $i++) {
            $crKeyword = new \CriteriaCompo();
            $crKeyword->add(new \Criteria('tra_desc', '%' . $queryarray[$i] . '%', 'LIKE'), 'OR');
            $crKeyword->add(new \Criteria('tra_reference', '%' . $queryarray[$i] . '%', 'LIKE'), 'OR');
            $crKeywords->add($crKeyword, $andor);
            unset($crKeyword);
        }
    }
    // search user(s)
    if ($userid && \is_array($userid)) {
        $userid = array_map('intval', $userid);
        $crUser = new \CriteriaCompo();
        $crUser->add(new \Criteria('tra_submitter', '(' . \implode(',', $userid) . ')', 'IN'), 'OR');
    } elseif (is_numeric($userid) && $userid > 0) {
        $crUser = new \CriteriaCompo();
        $crUser->add(new \Criteria('tra_submitter', $userid), 'OR');
    }
    $crSearch = new \CriteriaCompo();
    if (isset($crKeywords)) {
        $crSearch->add($crKeywords);
    }
    if (isset($crUser)) {
        $crSearch->add($crUser);
    }
    $crSearch->setStart($offset);
    $crSearch->setLimit($limit);
    $crSearch->setSort('tra_datecreated');
    $crSearch->setOrder('DESC');
    $transactionsAll = $transactionsHandler->getAll($crSearch);
    foreach (\array_keys($transactionsAll) as $i) {
        $ret[] = [
            'image'  => 'assets/icons/16/transactions.png',
            'link'   => 'transactions.php?op=show&amp;tra_id=' . $transactionsAll[$i]->getVar('tra_id'),
            'title'  => \strip_tags($transactionsAll[$i]->getVar('tra_desc')),
            'time'   => $transactionsAll[$i]->getVar('tra_datecreated')
        ];
    }
    unset($crKeywords);
    unset($crKeyword);
    unset($crUser);
    unset($crSearch);

    // search in table allocations
    // search keywords
    $elementCount = 0;
    $allocationsHandler = $helper->getHandler('Allocations');
    if (\is_array($queryarray)) {
        $elementCount = \count($queryarray);
    }
    if ($elementCount > 0) {
        $crKeywords = new \CriteriaCompo();
        for ($i = 0; $i  <  $elementCount; $i++) {
            $crKeyword = new \CriteriaCompo();
            $crKeyword->add(new \Criteria('all_name', '%' . $queryarray[$i] . '%', 'LIKE'), 'OR');
            $crKeyword->add(new \Criteria('all_desc', '%' . $queryarray[$i] . '%', 'LIKE'), 'OR');
            $crKeywords->add($crKeyword, $andor);
            unset($crKeyword);
        }
    }
    // search user(s)
    if ($userid && \is_array($userid)) {
        $userid = array_map('intval', $userid);
        $crUser = new \CriteriaCompo();
        $crUser->add(new \Criteria('all_submitter', '(' . \implode(',', $userid) . ')', 'IN'), 'OR');
    } elseif (is_numeric($userid) && $userid > 0) {
        $crUser = new \CriteriaCompo();
        $crUser->add(new \Criteria('all_submitter', $userid), 'OR');
    }
    $crSearch = new \CriteriaCompo();
    if (isset($crKeywords)) {
        $crSearch->add($crKeywords);
    }
    if (isset($crUser)) {
        $crSearch->add($crUser);
    }
    $crSearch->setStart($offset);
    $crSearch->setLimit($limit);
    $crSearch->setSort('all_datecreated');
    $crSearch->setOrder('DESC');
    $allocationsAll = $allocationsHandler->getAll($crSearch);
    foreach (\array_keys($allocationsAll) as $i) {
        $ret[] = [
            'image'  => 'assets/icons/16/allocations.png',
            'link'   => 'allocations.php?op=show&amp;all_id=' . $allocationsAll[$i]->getVar('all_id'),
            'title'  => \strip_tags($allocationsAll[$i]->getVar('all_name')),
            'time'   => $allocationsAll[$i]->getVar('all_datecreated')
        ];
    }
    unset($crKeywords);
    unset($crKeyword);
    unset($crUser);
    unset($crSearch);

    // search in table files
    // search keywords
    $elementCount = 0;
    $filesHandler = $helper->getHandler('Files');
    if (\is_array($queryarray)) {
        $elementCount = \count($queryarray);
    }
    if ($elementCount > 0) {
        $crKeywords = new \CriteriaCompo();
        for ($i = 0; $i  <  $elementCount; $i++) {
            $crKeyword = new \CriteriaCompo();
            $crKeyword->add(new \Criteria('fil_name', '%' . $queryarray[$i] . '%', 'LIKE'), 'OR');
            $crKeyword->add(new \Criteria('fil_desc', '%' . $queryarray[$i] . '%', 'LIKE'), 'OR');
            $crKeywords->add($crKeyword, $andor);
            unset($crKeyword);
        }
    }
    // search user(s)
    if ($userid && \is_array($userid)) {
        $userid = array_map('intval', $userid);
        $crUser = new \CriteriaCompo();
        $crUser->add(new \Criteria('fil_submitter', '(' . \implode(',', $userid) . ')', 'IN'), 'OR');
    } elseif (is_numeric($userid) && $userid > 0) {
        $crUser = new \CriteriaCompo();
        $crUser->add(new \Criteria('fil_submitter', $userid), 'OR');
    }
    $crSearch = new \CriteriaCompo();
    if (isset($crKeywords)) {
        $crSearch->add($crKeywords);
    }
    if (isset($crUser)) {
        $crSearch->add($crUser);
    }
    $crSearch->setStart($offset);
    $crSearch->setLimit($limit);
    $crSearch->setSort('fil_datecreated');
    $crSearch->setOrder('DESC');
    $filesAll = $filesHandler->getAll($crSearch);
    foreach (\array_keys($filesAll) as $i) {
        $ret[] = [
            'image'  => 'assets/icons/16/files.png',
            'link'   => 'files.php?op=show&amp;fil_id=' . $filesAll[$i]->getVar('fil_id'),
            'title'  => \strip_tags($filesAll[$i]->getVar('fil_name')),
            'time'   => $filesAll[$i]->getVar('fil_datecreated')
        ];
    }
    unset($crKeywords);
    unset($crKeyword);
    unset($crUser);
    unset($crSearch);

    // search in table clients
    // search keywords
    $elementCount = 0;
    $clientsHandler = $helper->getHandler('Clients');
    if (\is_array($queryarray)) {
        $elementCount = \count($queryarray);
    }
    if ($elementCount > 0) {
        $crKeywords = new \CriteriaCompo();
        for ($i = 0; $i  <  $elementCount; $i++) {
            $crKeyword = new \CriteriaCompo();
            $crKeyword->add(new \Criteria('cli_name', '%' . $queryarray[$i] . '%', 'LIKE'), 'OR');
            $crKeywords->add($crKeyword, $andor);
            unset($crKeyword);
        }
    }
    // search user(s)
    if ($userid && \is_array($userid)) {
        $userid = array_map('intval', $userid);
        $crUser = new \CriteriaCompo();
        $crUser->add(new \Criteria('cli_submitter', '(' . \implode(',', $userid) . ')', 'IN'), 'OR');
    } elseif (is_numeric($userid) && $userid > 0) {
        $crUser = new \CriteriaCompo();
        $crUser->add(new \Criteria('cli_submitter', $userid), 'OR');
    }
    $crSearch = new \CriteriaCompo();
    if (isset($crKeywords)) {
        $crSearch->add($crKeywords);
    }
    if (isset($crUser)) {
        $crSearch->add($crUser);
    }
    $crSearch->setStart($offset);
    $crSearch->setLimit($limit);
    $crSearch->setSort('cli_datecreated');
    $crSearch->setOrder('DESC');
    $clientsAll = $clientsHandler->getAll($crSearch);
    foreach (\array_keys($clientsAll) as $i) {
        $ret[] = [
            'image'  => 'assets/icons/16/clients.png',
            'link'   => 'clients.php?op=show&amp;cli_id=' . $clientsAll[$i]->getVar('cli_id'),
            'title'  => \strip_tags($clientsAll[$i]->getVar('cli_name')),
            'time'   => $clientsAll[$i]->getVar('cli_datecreated')
        ];
    }
    unset($crKeywords);
    unset($crKeyword);
    unset($crUser);
    unset($crSearch);

    return $ret;

}
