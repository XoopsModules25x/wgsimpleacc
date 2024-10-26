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

\defined('\XOOPS_ROOT_PATH') || die('Restricted access');

/**
 * Class Object Trahistories
 */
class Trahistories extends \XoopsObject
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->initVar('hist_id', \XOBJ_DTYPE_INT);
        $this->initVar('hist_type', \XOBJ_DTYPE_TXTBOX);
        $this->initVar('hist_datecreated', \XOBJ_DTYPE_INT);
        $this->initVar('hist_submitter', \XOBJ_DTYPE_INT);
        $this->initVar('tra_id', \XOBJ_DTYPE_INT);
        $this->initVar('tra_year', \XOBJ_DTYPE_INT);
        $this->initVar('tra_nb', \XOBJ_DTYPE_INT);
        $this->initVar('tra_desc', \XOBJ_DTYPE_OTHER);
        $this->initVar('tra_reference', \XOBJ_DTYPE_TXTBOX);
        $this->initVar('tra_remarks', \XOBJ_DTYPE_OTHER);
        $this->initVar('tra_accid', \XOBJ_DTYPE_INT);
        $this->initVar('tra_allid', \XOBJ_DTYPE_INT);
        $this->initVar('tra_date', \XOBJ_DTYPE_INT);
        $this->initVar('tra_curid', \XOBJ_DTYPE_INT);
        $this->initVar('tra_amountin', \XOBJ_DTYPE_DECIMAL);
        $this->initVar('tra_amountout', \XOBJ_DTYPE_DECIMAL);
        $this->initVar('tra_taxid', \XOBJ_DTYPE_INT);
        $this->initVar('tra_asid', \XOBJ_DTYPE_INT);
        $this->initVar('tra_status', \XOBJ_DTYPE_INT);
        $this->initVar('tra_comments', \XOBJ_DTYPE_INT);
        $this->initVar('tra_class', \XOBJ_DTYPE_INT);
        $this->initVar('tra_balid', \XOBJ_DTYPE_INT);
        $this->initVar('tra_balidt', \XOBJ_DTYPE_INT);
        $this->initVar('tra_hist', \XOBJ_DTYPE_TXTBOX);
        $this->initVar('tra_datecreated', \XOBJ_DTYPE_INT);
        $this->initVar('tra_submitter', \XOBJ_DTYPE_INT);
    }

    /**
     * @static function &getInstance
     */
    public static function getInstance()
    {
        static $instance = false;
        if (!$instance) {
            $instance = new self();
        }
    }

    /**
     * Get Values
     * @param null $keys
     * @param null $format
     * @param null $maxDepth
     * @return array
     */
    public function getValuesTrahistories($keys = null, $format = null, $maxDepth = null): array
    {
        $helper  = \XoopsModules\Wgsimpleacc\Helper::getInstance();
        $utility = new \XoopsModules\Wgsimpleacc\Utility();
        $editorMaxchar = $helper->getConfig('editor_maxchar');

        $ret = $this->getValues($keys, $format, $maxDepth);
        $ret['histid']        = $this->getVar('hist_id');
        $ret['histdate']      = \formatTimestamp($this->getVar('hist_datecreated'), _DATESTRING);
        $ret['histtype']      = $this->getVar('hist_type');
        $ret['histsubmitter'] = \XoopsUser::getUnameFromId($this->getVar('hist_submitter'));
        $ret['id']            = $this->getVar('tra_id');
        $ret['year']          = $this->getVar('tra_year');
        $ret['nb']            = $this->getVar('tra_nb');
        $ret['year_nb']       = $this->getVar('tra_year') . '/' . \substr('00000' . $this->getVar('tra_nb'), -5);
        $ret['desc']          = $this->getVar('tra_desc', 'e');
        $ret['desc_short']    = $utility::truncateHtml($ret['desc'], $editorMaxchar);
        $ret['reference']     = $this->getVar('tra_reference');
        $ret['remarks']       = $this->getVar('tra_remarks', 'e');
        $ret['remarks_short'] = $utility::truncateHtml($ret['remarks'], $editorMaxchar);
        $ret['accid']         = $this->getVar('tra_accid');
        $accountsHandler      = $helper->getHandler('Accounts');
        $accountsObj          = $accountsHandler->get($this->getVar('tra_accid'));
        if (\is_object($accountsObj)) {
            $ret['acckey']  = $accountsObj->getVar('acc_key');
            $ret['account'] = $accountsObj->getVar('acc_key') . ' ' . $accountsObj->getVar('acc_name');
        } else {
            $ret['acckey']  = '?';
            $ret['account'] = \_MA_WGSIMPLEACC_MISSING_ID . ':' . $this->getVar('tra_accid');
        }
        $allocationsHandler   = $helper->getHandler('Allocations');
        $allocationsObj       = $allocationsHandler->get($this->getVar('tra_allid'));
        $allName              = \_MA_WGSIMPLEACC_MISSING_ID . ':' . $this->getVar('tra_allid');
        if (\is_object($allocationsObj)) {
            $allName = $allocationsObj->getVar('all_name');
        }
        $ret['allocation']    = $allName;
        $ret['date']          = \formatTimestamp($this->getVar('tra_date'), _SHORTDATESTRING);
        $currenciesHandler    = $helper->getHandler('Currencies');
        $currenciesObj        = $currenciesHandler->get($this->getVar('tra_curid'));
        if (\is_object($currenciesObj)) {
            $ret['curid'] = $currenciesObj->getVar('cur_code');
        }
        $ret['amountin']      =  Utility::FloatToString($this->getVar('tra_amountin'));
        $ret['amountout']     =  Utility::FloatToString($this->getVar('tra_amountout'));
        if ($this->getVar('tra_amountin') > 0) {
            $ret['amount'] = $ret['amountin'];
        } else {
            $ret['amount'] = $ret['amountout'];
        }
        $taxesHandler       = $helper->getHandler('Taxes');
        $taxesObj           = $taxesHandler->get($this->getVar('tra_taxid'));
        $ret['taxid']       = $taxesObj->getVar('tax_name');
        $ret['taxrate']     = $taxesObj->getVar('tax_rate');
        $assetsHandler      = $helper->getHandler('Assets');
        $assetsObj          = $assetsHandler->get($this->getVar('tra_asid'));
        $ret['asset']       = $assetsObj->getVar('as_name');
        $status             = $this->getVar('tra_status');
        $ret['status']      = $status;
        $ret['status_text'] = Utility::getTraStatusText($status);
        $ret['comments']    = $this->getVar('tra_comments');
        $traClass           = $this->getVar('tra_class');
        $ret['class']       = $traClass;
        switch ($traClass) {
            case Constants::CLASS_BOTH:
            default:
                $class_text = \_MA_WGSIMPLEACC_CLASS_BOTH;
                break;
            case Constants::CLASS_EXPENSES:
                $class_text = \_MA_WGSIMPLEACC_CLASS_EXPENSES;
                break;
            case Constants::CLASS_INCOME:
                $class_text = \_MA_WGSIMPLEACC_CLASS_INCOME;
                break;
        }
        $ret['class_text']      = $class_text;
        $ret['balid']           = $this->getVar('tra_balid');
        $ret['balidt']          = $this->getVar('tra_balidt');
        $ret['hist']            = $this->getVar('tra_hist');
        $ret['datecreated']     = \formatTimestamp($this->getVar('tra_datecreated'), _SHORTDATESTRING);
        $ret['datetimecreated'] = \formatTimestamp($this->getVar('tra_datecreated'), _DATESTRING);
        $ret['submitter']       = \XoopsUser::getUnameFromId($this->getVar('tra_submitter'));
        $filesHandler = $helper->getHandler('Files');
        $crFiles = new \CriteriaCompo();
        $crFiles->add(new \Criteria('fil_traid', $this->getVar('tra_id')));
        $filesCount = $filesHandler->getCount($crFiles);
        $ret['nbfiles'] = $filesCount;
        if ($filesCount > 0) {
            $filesAll = $filesHandler->getAll($crFiles);
            $files = [];
            // Get All Files
            foreach (\array_keys($filesAll) as $i) {
                $file = $filesAll[$i]->getValuesFiles();
                $files[$i] = ['id' => $file['fil_id'], 'name' => $file['fil_name'], 'image' => $file['image']];
                unset($file);
            }
            $ret['files'] = $files;
        }
        return $ret;
    }
}
