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

\defined('\XOOPS_ROOT_PATH') || die('Restricted access');

/**
 * Class Object Balances
 */
class Balances extends \XoopsObject
{
	/**
	 * Constructor
	 *
	 * @param null
	 */
	public function __construct()
	{
		$this->initVar('bal_id', \XOBJ_DTYPE_INT);
		$this->initVar('bal_from', \XOBJ_DTYPE_INT);
		$this->initVar('bal_to', \XOBJ_DTYPE_INT);
        $this->initVar('bal_asid', \XOBJ_DTYPE_INT);
        $this->initVar('bal_curid', \XOBJ_DTYPE_INT);
        $this->initVar('bal_amountstart', \XOBJ_DTYPE_DECIMAL);
        $this->initVar('bal_amountend', \XOBJ_DTYPE_DECIMAL);
		$this->initVar('bal_status', \XOBJ_DTYPE_INT);
		$this->initVar('bal_datecreated', \XOBJ_DTYPE_INT);
		$this->initVar('bal_submitter', \XOBJ_DTYPE_INT);
	}

	/**
	 * @static function &getInstance
	 *
	 * @param null
	 */
	public static function getInstance()
	{
		static $instance = false;
		if (!$instance) {
			$instance = new self();
		}
	}

	/**
	 * The new inserted $Id
	 * @return inserted id
	 */
	public function getNewInsertedIdBalances()
	{
		$newInsertedId = $GLOBALS['xoopsDB']->getInsertId();
		return $newInsertedId;
	}

    /**
     * @public function getForm
     * @param bool $action
     * @param bool $admin
     * @return \XoopsThemeForm
     */
	public function getFormBalances($action = false, $admin = false)
	{
		$helper = \XoopsModules\Wgsimpleacc\Helper::getInstance();
		if (!$action) {
			$action = $_SERVER['REQUEST_URI'];
		}
        $dtime = \DateTime::createFromFormat('Y-m-d', (date('Y') - 1) . '-1-1');
        $dateFrom = $dtime->getTimestamp();
        $dtime = \DateTime::createFromFormat('Y-m-d', (date('Y') - 1) . '-12-31');
        $dateTo = $dtime->getTimestamp();
		// Title
		$title = $this->isNew() ? \sprintf(\_AM_WGSIMPLEACC_BALANCE_ADD) : \sprintf(\_AM_WGSIMPLEACC_BALANCE_EDIT);
		// Get Theme Form
		\xoops_load('XoopsFormLoader');
		$form = new \XoopsThemeForm($title, 'form', $action, 'post', true);
		$form->setExtra('enctype="multipart/form-data"');
		// Form Text Date Select balFrom
		$balFrom = $this->isNew() ? $dateFrom : $this->getVar('bal_from');
		$form->addElement(new \XoopsFormTextDateSelect(\_MA_WGSIMPLEACC_BALANCE_FROM, 'bal_from', '', $balFrom), true);
		// Form Text Date Select balTo
		$balTo = $this->isNew() ? $dateTo : $this->getVar('bal_to');
		$form->addElement(new \XoopsFormTextDateSelect(\_MA_WGSIMPLEACC_BALANCE_TO, 'bal_to', '', $balTo), true);
		// Form Select Status balStatus
        $balStatus = $this->isNew() ? Constants::STATUS_APPROVED : $this->getVar('bal_status');
        if ($admin) {
            // Form Table assets
            $assetsHandler = $helper->getHandler('Assets');
            $balAsid = $this->isNew() ? $assetsHandler->getPrimaryAsset() : $this->getVar('bal_asid');
            $balAsidSelect = new \XoopsFormSelect(\_MA_WGSIMPLEACC_BALANCE_ASID, 'bal_asid', $balAsid);
            $balAsidSelect->addOptionArray($assetsHandler->getList());
            $form->addElement($balAsidSelect);
            // Form Table currencies
            $currenciesHandler = $helper->getHandler('Currencies');
            $balCuridSelect = new \XoopsFormSelect(\_MA_WGSIMPLEACC_BALANCE_CURID, 'bal_curid', $this->getVar('bal_curid'));
            $balCuridSelect->addOptionArray($currenciesHandler->getList());
            $form->addElement($balCuridSelect);
            // Form Text balAmountStart
            $balAmountStart = $this->isNew() ? 0 : $this->getVar('bal_amountstart');
            $balAmountStart = Utility::FloatToString($balAmountStart);
            $form->addElement(new \XoopsFormText(\_MA_WGSIMPLEACC_BALANCE_AMOUNTSTART, 'bal_amountstart', 20, 150, $balAmountStart), true);
            // Form Text balAmountEnd
            $balAmountEnd = $this->isNew() ? 0 : $this->getVar('bal_amountend');
            $balAmountEnd = Utility::FloatToString($balAmountEnd);
            $form->addElement(new \XoopsFormText(\_MA_WGSIMPLEACC_BALANCE_AMOUNTEND, 'bal_amountend', 20, 150, $balAmountEnd), true);
            // Form Select Status
            $balStatusSelect = new \XoopsFormSelect(\_MA_WGSIMPLEACC_BALANCE_STATUS, 'bal_status', $balStatus);
            //$balStatusSelect->addOption(Constants::STATUS_CREATED, \_AM_WGSIMPLEACC_STATUS_CREATED);
            $balStatusSelect->addOption(Constants::STATUS_APPROVED, \_AM_WGSIMPLEACC_STATUS_APPROVED);
            $form->addElement($balStatusSelect);
            // Form Text Date Select balDatecreated
            $balDatecreated = $this->isNew() ?: $this->getVar('bal_datecreated');
            $form->addElement(new \XoopsFormTextDateSelect(\_MA_WGSIMPLEACC_DATECREATED, 'bal_datecreated', '', $balDatecreated), true);
            // Form Select User balSubmitter
            $balSubmitter = $this->isNew() ? $GLOBALS['xoopsUser']->getVar('uid') : $this->getVar('bal_submitter');
            $form->addElement(new \XoopsFormSelectUser(\_MA_WGSIMPLEACC_SUBMITTER, 'bal_submitter', false, $balSubmitter));
        } else {
            $form->addElement(new \XoopsFormHidden('bal_status', $balStatus));
        }

		// To Save
        if ($admin) {
            $form->addElement(new \XoopsFormHidden('op', 'save'));
            $form->addElement(new \XoopsFormButtonTray('', \_MA_WGSIMPLEACC_BALANCE_SUBMIT, 'submit', '', false));
        } else {
            $form->addElement(new \XoopsFormHidden('op', 'precalc'));
            $form->addElement(new \XoopsFormButtonTray('', \_MA_WGSIMPLEACC_BALANCE_PRECALC, 'submit', '', false));
        }

		return $form;
	}

	/**
	 * Get Values
	 * @param null $keys
	 * @param null $format
	 * @param null $maxDepth
	 * @return array
	 */
	public function getValuesBalances($keys = null, $format = null, $maxDepth = null)
	{
        $helper  = \XoopsModules\Wgsimpleacc\Helper::getInstance();
	    $ret = $this->getValues($keys, $format, $maxDepth);
		$ret['id']         = $this->getVar('bal_id');
        $assetsHandler = $helper->getHandler('Assets');
        $assetsObj = $assetsHandler->get($this->getVar('bal_asid'));
        $ret['asset']      = $assetsObj->getVar('as_name');
		$ret['from']       = \formatTimestamp($this->getVar('bal_from'), 's');
		$ret['to']         = \formatTimestamp($this->getVar('bal_to'), 's');
        $currenciesHandler = $helper->getHandler('Currencies');
        $currenciesObj = $currenciesHandler->get($this->getVar('bal_curid'));
        if (\is_object($currenciesObj)) {
            $ret['curid'] = $currenciesObj->getVar('cur_code');
        }
        $ret['amountstart'] = Utility::FloatToString($this->getVar('bal_amountstart'));
        $ret['amountend']   = Utility::FloatToString($this->getVar('bal_amountend'));
        $ret['difference']   = Utility::FloatToString($this->getVar('bal_amountend') - $this->getVar('bal_amountstart'));
		$status             = $this->getVar('bal_status');
		$ret['status']      = $status;
		switch ($status) {
			case Constants::STATUS_NONE:
			default:
				$status_text = \_AM_WGSIMPLEACC_STATUS_NONE;
				break;
			case Constants::STATUS_OFFLINE:
				$status_text = \_AM_WGSIMPLEACC_STATUS_OFFLINE;
				break;
			case Constants::STATUS_SUBMITTED:
				$status_text = \_AM_WGSIMPLEACC_STATUS_SUBMITTED;
				break;
		}
		$ret['status_text'] = $status_text;
		$ret['datecreated'] = \formatTimestamp($this->getVar('bal_datecreated'), 's');
		$ret['submitter']   = \XoopsUser::getUnameFromId($this->getVar('bal_submitter'));
		return $ret;
	}

	/**
	 * Returns an array representation of the object
	 *
	 * @return array
	 */
	public function toArrayBalances()
	{
		$ret = [];
		$vars = $this->getVars();
		foreach (\array_keys($vars) as $var) {
			$ret[$var] = $this->getVar('"{$var}"');
		}
		return $ret;
	}
}
