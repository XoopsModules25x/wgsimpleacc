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
 * @since          1.0
 * @min_xoops      2.5.10
 * @author         XOOPS Development Team - Email:<webmaster@wedega.com> - Website:<https://xoops.wedega.com>
 */

use XoopsModules\Wgsimpleacc;
use XoopsModules\Wgsimpleacc\Constants;

\defined('\XOOPS_ROOT_PATH') || die('Restricted access');

/**
 * Class Object PermissionsHandler
 */
class PermissionsHandler extends \XoopsPersistableObjectHandler
{
	/**
	 * Constructor
	 *
	 * @param null
	 */
	public function __construct()
	{
	}

	/**
	 * @public function permGlobalApprove
	 * returns right for global approve
	 *
	 * @param null
	 * @return bool
	 */
	public function getPermGlobalApprove()
	{
		global $xoopsUser, $xoopsModule;

		$currentuid = 0;
		if (isset($xoopsUser) && \is_object($xoopsUser)) {
			if ($xoopsUser->isAdmin($xoopsModule->mid())) {
				return true;
			}
			$currentuid = $xoopsUser->uid();
		}
		$grouppermHandler = \xoops_getHandler('groupperm');
		$mid = $xoopsModule->mid();
		$memberHandler = \xoops_getHandler('member');
		if (0 == $currentuid) {
			$my_group_ids = [\XOOPS_GROUP_ANONYMOUS];
		} else {
			$my_group_ids = $memberHandler->getGroupsByUser($currentuid);;
		}
		if ($grouppermHandler->checkRight('wgsimpleacc_ac', Constants::PERM_GLOBAL_APPROVE, $my_group_ids, $mid)) {
			return true;
		}
		return false;
	}

	/**
	 * @public function permGlobalSubmit
	 * returns right for global submit
	 *
	 * @param null
	 * @return bool
	 */
	public function getPermGlobalSubmit()
	{
		global $xoopsUser, $xoopsModule;

        if ($this->getPermGlobalApprove()) {
            return true;
        }
        $currentuid = 0;
		if (isset($xoopsUser) && \is_object($xoopsUser)) {
			if ($xoopsUser->isAdmin($xoopsModule->mid())) {
				return true;
			}
			$currentuid = $xoopsUser->uid();
		}
		$grouppermHandler = \xoops_getHandler('groupperm');
		$mid = $xoopsModule->mid();
		$memberHandler = \xoops_getHandler('member');
		if (0 == $currentuid) {
			$my_group_ids = [\XOOPS_GROUP_ANONYMOUS];
		} else {
			$my_group_ids = $memberHandler->getGroupsByUser($currentuid);;
		}
		if ($grouppermHandler->checkRight('wgsimpleacc_ac', Constants::PERM_GLOBAL_SUBMIT, $my_group_ids, $mid)) {
			return true;
		}
		return false;
	}

	/**
	 * @public function permGlobalView
	 * returns right for global view
	 *
	 * @param null
	 * @return bool
	 */
	public function getPermGlobalView()
	{
		global $xoopsUser, $xoopsModule;

        if ($this->getPermGlobalSubmit()) {
            return true;
        }
        $currentuid = 0;
		if (isset($xoopsUser) && \is_object($xoopsUser)) {
			if ($xoopsUser->isAdmin($xoopsModule->mid())) {
				return true;
			}
			$currentuid = $xoopsUser->uid();
		}
		$grouppermHandler = \xoops_getHandler('groupperm');
		$mid = $xoopsModule->mid();
		$memberHandler = \xoops_getHandler('member');
		if (0 == $currentuid) {
			$my_group_ids = [\XOOPS_GROUP_ANONYMOUS];
		} else {
			$my_group_ids = $memberHandler->getGroupsByUser($currentuid);;
		}
		if ($grouppermHandler->checkRight('wgsimpleacc_ac', Constants::PERM_GLOBAL_VIEW, $my_group_ids, $mid)) {
			return true;
		}
		return false;
	}

    /**
     * @public function getPermTransactionsApprove
     * returns right for approve transactions
     *
     * @param null
     * @return bool
     */
    public function getPermTransactionsApprove()
    {
        global $xoopsUser, $xoopsModule;

        if ($this->getPermGlobalApprove()) {
            return true;
        }
        $currentuid = 0;
        if (isset($xoopsUser) && \is_object($xoopsUser)) {
            if ($xoopsUser->isAdmin($xoopsModule->mid())) {
                return true;
            }
            $currentuid = $xoopsUser->uid();
        }
        $grouppermHandler = \xoops_getHandler('groupperm');
        $mid = $xoopsModule->mid();
        $memberHandler = \xoops_getHandler('member');
        if (0 == $currentuid) {
            $my_group_ids = [\XOOPS_GROUP_ANONYMOUS];
        } else {
            $my_group_ids = $memberHandler->getGroupsByUser($currentuid);;
        }
        if ($grouppermHandler->checkRight('wgsimpleacc_ac', Constants::PERM_TRANSACTIONS_APPROVE, $my_group_ids, $mid)) {
            return true;
        }
        return false;
    }

    /**
     * @public function getPermTransactionsSubmit
     * returns right for submit transactions
     *
     * @param null
     * @return bool
     */
    public function getPermTransactionsSubmit()
    {
        global $xoopsUser, $xoopsModule;

        if ($this->getPermGlobalSubmit()) {
            return true;
        }
        if ($this->getPermTransactionsApprove()) {
            return true;
        }
        $currentuid = 0;
        if (isset($xoopsUser) && \is_object($xoopsUser)) {
            if ($xoopsUser->isAdmin($xoopsModule->mid())) {
                return true;
            }
            $currentuid = $xoopsUser->uid();
        }
        $grouppermHandler = \xoops_getHandler('groupperm');
        $mid = $xoopsModule->mid();
        $memberHandler = \xoops_getHandler('member');
        if (0 == $currentuid) {
            $my_group_ids = [\XOOPS_GROUP_ANONYMOUS];
        } else {
            $my_group_ids = $memberHandler->getGroupsByUser($currentuid);;
        }
        if ($grouppermHandler->checkRight('wgsimpleacc_ac', Constants::PERM_TRANSACTIONS_SUBMIT, $my_group_ids, $mid)) {
            return true;
        }
        return false;
    }

    /**
     * @public function getPermTransactionsEdit
     * returns right for edit/delete transactions
     *  - User must have perm to submit and must be owner
     *  - transaction is not closed
     *
     * @param $traSubmitter
     * @param $traStatus
     * @return bool
     */
    public function getPermTransactionsEdit($traSubmitter, $traStatus)
    {
        global $xoopsUser, $xoopsModule;

        if ($this->getPermGlobalSubmit()) {
            return true;
        }
        if (Constants::STATUS_LOCKED == $traStatus) {
            return false;
        }
        $currentuid = 0;
        if (isset($xoopsUser) && \is_object($xoopsUser)) {
            if ($xoopsUser->isAdmin($xoopsModule->mid())) {
                return true;
            }
            $currentuid = $xoopsUser->uid();
        }
        if ($this->getPermTransactionsApprove()) {
            return true;
        }
        if ($this->getPermTransactionsSubmit() && $currentuid == $traSubmitter && Constants::STATUS_SUBMITTED == $traStatus) {
            return true;
        }
        return false;
    }

	/**
     * @public function getPermAllocationsSubmit
     * returns right for submit allocations
     *
     * @param null
     * @return bool
     */
    public function getPermAllocationsSubmit()
    {
        global $xoopsUser, $xoopsModule;

        if ($this->getPermGlobalSubmit()) {
            return true;
        }
        $currentuid = 0;
        if (isset($xoopsUser) && \is_object($xoopsUser)) {
            if ($xoopsUser->isAdmin($xoopsModule->mid())) {
                return true;
            }
            $currentuid = $xoopsUser->uid();
        }
        $grouppermHandler = \xoops_getHandler('groupperm');
        $mid = $xoopsModule->mid();
        $memberHandler = \xoops_getHandler('member');
        if (0 == $currentuid) {
            $my_group_ids = [\XOOPS_GROUP_ANONYMOUS];
        } else {
            $my_group_ids = $memberHandler->getGroupsByUser($currentuid);;
        }
        if ($grouppermHandler->checkRight('wgsimpleacc_ac', Constants::PERM_ALLOCATIONS_SUBMIT, $my_group_ids, $mid)) {
            return true;
        }
        return false;
    }

    /**
     * @public function getPermAllocationsEdit
     * returns right for edit/delete allocations
     *  - User must have perm to submit and must be owner
     *
     * @param null
     * @return bool
     */
    public function getPermAllocationsEdit($allSubmitter)
    {
        global $xoopsUser, $xoopsModule;

        if ($this->getPermGlobalSubmit()) {
            return true;
        }
        $currentuid = 0;
        if (isset($xoopsUser) && \is_object($xoopsUser)) {
            if ($xoopsUser->isAdmin($xoopsModule->mid())) {
                return true;
            }
            $currentuid = $xoopsUser->uid();
        }
        if ($this->getPermAllocationsSubmit() && $currentuid == $allSubmitter) {
            return true;
        }
        return false;
    }

    /**
     * @public function getPermAccountsSubmit
     * returns right for submit accounts
     *
     * @param null
     * @return bool
     */
    public function getPermAccountsSubmit()
    {
        global $xoopsUser, $xoopsModule;

        if ($this->getPermGlobalSubmit()) {
            return true;
        }
        $currentuid = 0;
        if (isset($xoopsUser) && \is_object($xoopsUser)) {
            if ($xoopsUser->isAdmin($xoopsModule->mid())) {
                return true;
            }
            $currentuid = $xoopsUser->uid();
        }
        $grouppermHandler = \xoops_getHandler('groupperm');
        $mid = $xoopsModule->mid();
        $memberHandler = \xoops_getHandler('member');
        if (0 == $currentuid) {
            $my_group_ids = [\XOOPS_GROUP_ANONYMOUS];
        } else {
            $my_group_ids = $memberHandler->getGroupsByUser($currentuid);;
        }
        if ($grouppermHandler->checkRight('wgsimpleacc_ac', Constants::PERM_ACCOUNTS_SUBMIT, $my_group_ids, $mid)) {
            return true;
        }
        return false;
    }

    /**
     * @public function getPermAccountsEdit
     * returns right for edit/delete accounts
     * - User must have perm to submit and must be owner
     *
     * @param null
     * @return bool
     */
    public function getPermAccountsEdit($accSubmitter)
    {
        global $xoopsUser, $xoopsModule;

        if ($this->getPermGlobalSubmit()) {
            return true;
        }
        $currentuid = 0;
        if (isset($xoopsUser) && \is_object($xoopsUser)) {
            if ($xoopsUser->isAdmin($xoopsModule->mid())) {
                return true;
            }
            $currentuid = $xoopsUser->uid();
        }
        if ($this->getPermAccountsSubmit() && $currentuid == $accSubmitter) {
            return true;
        }
        return false;
    }

    /**
     * @public function getPermAssetsSubmit
     * returns right for submit assets
     *
     * @param null
     * @return bool
     */
    public function getPermAssetsSubmit()
    {
        global $xoopsUser, $xoopsModule;

        if ($this->getPermGlobalSubmit()) {
            return true;
        }
        $currentuid = 0;
        if (isset($xoopsUser) && \is_object($xoopsUser)) {
            if ($xoopsUser->isAdmin($xoopsModule->mid())) {
                return true;
            }
            $currentuid = $xoopsUser->uid();
        }
        $grouppermHandler = \xoops_getHandler('groupperm');
        $mid = $xoopsModule->mid();
        $memberHandler = \xoops_getHandler('member');
        if (0 == $currentuid) {
            $my_group_ids = [\XOOPS_GROUP_ANONYMOUS];
        } else {
            $my_group_ids = $memberHandler->getGroupsByUser($currentuid);;
        }
        if ($grouppermHandler->checkRight('wgsimpleacc_ac', Constants::PERM_ASSETS_SUBMIT, $my_group_ids, $mid)) {
            return true;
        }
        return false;
    }

    /**
     * @public function getPermAssetsEdit
     * returns right for edit/delete assets
     * - User must have perm to submit and must be owner
     *
     * @param null
     * @return bool
     */
    public function getPermAssetsEdit($asSubmitter)
    {
        global $xoopsUser, $xoopsModule;

        if ($this->getPermGlobalSubmit()) {
            return true;
        }
        $currentuid = 0;
        if (isset($xoopsUser) && \is_object($xoopsUser)) {
            if ($xoopsUser->isAdmin($xoopsModule->mid())) {
                return true;
            }
            $currentuid = $xoopsUser->uid();
        }
        if ($this->getPermAssetsSubmit() && $currentuid == $asSubmitter) {
            return true;
        }
        return false;
    }

    /**
     * @public function getPermFilesEdit
     * returns right for edit/delete files
     * - User must have perm to submit and must be owner
     *
     * @param null
     * @return bool
     */
    public function getPermFilesEdit($asSubmitter)
    {
        global $xoopsUser, $xoopsModule;

        if ($this->getPermGlobalSubmit()) {
            return true;
        }
        $currentuid = 0;
        if (isset($xoopsUser) && \is_object($xoopsUser)) {
            if ($xoopsUser->isAdmin($xoopsModule->mid())) {
                return true;
            }
            $currentuid = $xoopsUser->uid();
        }
        if ($this->getPermTransactionsSubmit() && $currentuid == $asSubmitter) {
            return true;
        }
        return false;
    }

    /**
     * @public function getPermBalancesCreate
     * returns right for create balances
     *
     * @param null
     * @return bool
     */
    public function getPermBalancesCreate()
    {
        global $xoopsUser, $xoopsModule;

        if ($this->getPermGlobalSubmit()) {
            return true;
        }
        $currentuid = 0;
        if (isset($xoopsUser) && \is_object($xoopsUser)) {
            if ($xoopsUser->isAdmin($xoopsModule->mid())) {
                return true;
            }
            $currentuid = $xoopsUser->uid();
        }
        $grouppermHandler = \xoops_getHandler('groupperm');
        $mid = $xoopsModule->mid();
        $memberHandler = \xoops_getHandler('member');
        if (0 == $currentuid) {
            $my_group_ids = [\XOOPS_GROUP_ANONYMOUS];
        } else {
            $my_group_ids = $memberHandler->getGroupsByUser($currentuid);;
        }
        if ($grouppermHandler->checkRight('wgsimpleacc_ac', Constants::PERM_BALANCES_CREATE, $my_group_ids, $mid)) {
            return true;
        }
        return false;
    }

    /**
     * @public function getPermTratemplatesSubmit
     * returns right for submit tratemplate
     *
     * @param null
     * @return bool
     */
    public function getPermTratemplatesSubmit()
    {
        global $xoopsUser, $xoopsModule;

        if ($this->getPermGlobalSubmit()) {
            return true;
        }
        $currentuid = 0;
        if (isset($xoopsUser) && \is_object($xoopsUser)) {
            if ($xoopsUser->isAdmin($xoopsModule->mid())) {
                return true;
            }
            $currentuid = $xoopsUser->uid();
        }
        $grouppermHandler = \xoops_getHandler('groupperm');
        $mid = $xoopsModule->mid();
        $memberHandler = \xoops_getHandler('member');
        if (0 == $currentuid) {
            $my_group_ids = [\XOOPS_GROUP_ANONYMOUS];
        } else {
            $my_group_ids = $memberHandler->getGroupsByUser($currentuid);;
        }
        if ($grouppermHandler->checkRight('wgsimpleacc_ac', Constants::PERM_TRATEMPLATES_SUBMIT, $my_group_ids, $mid)) {
            return true;
        }
        return false;
    }

    /**
     * @public function getPermTratemplatesEdit
     * returns right for edit/delete tratemplate
     * - User must have perm to submit and must be owner
     *
     * @param null
     * @return bool
     */
    public function getPermTratemplatesEdit($tplSubmitter)
    {
        global $xoopsUser, $xoopsModule;

        if ($this->getPermGlobalSubmit()) {
            return true;
        }
        $currentuid = 0;
        if (isset($xoopsUser) && \is_object($xoopsUser)) {
            if ($xoopsUser->isAdmin($xoopsModule->mid())) {
                return true;
            }
            $currentuid = $xoopsUser->uid();
        }
        if ($this->getPermTratemplatesSubmit() && $currentuid == $tplSubmitter) {
            return true;
        }
        return false;
    }

    /**
     * @public function getPermTratemplatesSubmit
     * returns right for submit tratemplate
     *
     * @param null
     * @return bool
     */
    public function getPermTratemplatesView()
    {
        global $xoopsUser, $xoopsModule;

        $currentuid = 0;
        if (isset($xoopsUser) && \is_object($xoopsUser)) {
            if ($xoopsUser->isAdmin($xoopsModule->mid())) {
                return true;
            }
            $currentuid = $xoopsUser->uid();
        }
        $grouppermHandler = \xoops_getHandler('groupperm');
        $mid = $xoopsModule->mid();
        $memberHandler = \xoops_getHandler('member');
        if (0 == $currentuid) {
            $my_group_ids = [\XOOPS_GROUP_ANONYMOUS];
        } else {
            $my_group_ids = $memberHandler->getGroupsByUser($currentuid);;
        }
        if ($grouppermHandler->checkRight('wgsimpleacc_ac', Constants::PERM_TRATEMPLATES_VIEW, $my_group_ids, $mid)) {
            return true;
        }
        return false;
    }
    /**
     * @public function getPermOuttemplatesSubmit
     * returns right for submit outtemplate
     *
     * @param null
     * @return bool
     */
    public function getPermOuttemplatesSubmit()
    {
        global $xoopsUser, $xoopsModule;

        if ($this->getPermGlobalSubmit()) {
            return true;
        }
        $currentuid = 0;
        if (isset($xoopsUser) && \is_object($xoopsUser)) {
            if ($xoopsUser->isAdmin($xoopsModule->mid())) {
                return true;
            }
            $currentuid = $xoopsUser->uid();
        }
        $grouppermHandler = \xoops_getHandler('groupperm');
        $mid = $xoopsModule->mid();
        $memberHandler = \xoops_getHandler('member');
        if (0 == $currentuid) {
            $my_group_ids = [\XOOPS_GROUP_ANONYMOUS];
        } else {
            $my_group_ids = $memberHandler->getGroupsByUser($currentuid);;
        }
        if ($grouppermHandler->checkRight('wgsimpleacc_ac', Constants::PERM_OUTTEMPLATES_SUBMIT, $my_group_ids, $mid)) {
            return true;
        }
        return false;
    }

    /**
     * @public function getPermOutemplatesEdit
     * returns right for edit/delete outtemplates
     * - User must have perm to submit and must be owner
     *
     * @param null
     * @return bool
     */
    public function getPermOuttemplatesEdit($tplSubmitter)
    {
        global $xoopsUser, $xoopsModule;

        if ($this->getPermGlobalSubmit()) {
            return true;
        }
        $currentuid = 0;
        if (isset($xoopsUser) && \is_object($xoopsUser)) {
            if ($xoopsUser->isAdmin($xoopsModule->mid())) {
                return true;
            }
            $currentuid = $xoopsUser->uid();
        }
        if ($this->getPermOuttemplatesSubmit() && $currentuid == $tplSubmitter) {
            return true;
        }
        return false;
    }

    /**
     * @public function getPermOuttemplatesView
     * returns right for view outtemplate
     *
     * @param null
     * @return bool
     */
    public function getPermOuttemplatesView()
    {
        global $xoopsUser, $xoopsModule;

        $currentuid = 0;
        if (isset($xoopsUser) && \is_object($xoopsUser)) {
            if ($xoopsUser->isAdmin($xoopsModule->mid())) {
                return true;
            }
            $currentuid = $xoopsUser->uid();
        }
        $grouppermHandler = \xoops_getHandler('groupperm');
        $mid = $xoopsModule->mid();
        $memberHandler = \xoops_getHandler('member');
        if (0 == $currentuid) {
            $my_group_ids = [\XOOPS_GROUP_ANONYMOUS];
        } else {
            $my_group_ids = $memberHandler->getGroupsByUser($currentuid);;
        }
        if ($grouppermHandler->checkRight('wgsimpleacc_ac', Constants::PERM_OUTTEMPLATES_VIEW, $my_group_ids, $mid)) {
            return true;
        }
        return false;
    }
}
