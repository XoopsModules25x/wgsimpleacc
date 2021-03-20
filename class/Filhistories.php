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

\defined('\XOOPS_ROOT_PATH') || die('Restricted access');

/**
 * Class Object Filhistories
 */
class Filhistories extends \XoopsObject
{
    /**
     * Constructor
     *
     * @param null
     */
    public function __construct()
    {
        $this->initVar('hist_id', \XOBJ_DTYPE_INT);
        $this->initVar('hist_type', \XOBJ_DTYPE_TXTBOX);
        $this->initVar('hist_datecreated', \XOBJ_DTYPE_INT);
        $this->initVar('hist_submitter', \XOBJ_DTYPE_INT);
        $this->initVar('fil_id', \XOBJ_DTYPE_INT);
        $this->initVar('fil_traid', \XOBJ_DTYPE_INT);
        $this->initVar('fil_name', \XOBJ_DTYPE_TXTBOX);
        $this->initVar('fil_type', \XOBJ_DTYPE_INT);
        $this->initVar('fil_desc', \XOBJ_DTYPE_TXTAREA);
        $this->initVar('fil_ip', \XOBJ_DTYPE_TXTBOX);
        $this->initVar('fil_datecreated', \XOBJ_DTYPE_INT);
        $this->initVar('fil_submitter', \XOBJ_DTYPE_INT);
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
     * Get Values
     * @param null $keys
     * @param null $format
     * @param null $maxDepth
     * @return array
     */
    public function getValuesFilhistories($keys = null, $format = null, $maxDepth = null)
    {
        $helper  = \XoopsModules\Wgsimpleacc\Helper::getInstance();
        $utility = new \XoopsModules\Wgsimpleacc\Utility();
        $ret = $this->getValues($keys, $format, $maxDepth);
        $ret['histid']        = $this->getVar('hist_id');
        $ret['histdate']      = \formatTimestamp($this->getVar('hist_datecreated'), 'm');
        $ret['histtype']      = $this->getVar('hist_type');
        $ret['histsubmitter'] = \XoopsUser::getUnameFromId($this->getVar('hist_submitter'));
        $ret['id']            = $this->getVar('fil_id');
        $transactionsHandler = $helper->getHandler('Transactions');
        $transactionsObj = $transactionsHandler->get($this->getVar('fil_traid'));
        if (\is_object($transactionsObj)) {
            $ret['traid'] = $transactionsObj->getVar('tra_desc');
        } else {
            $ret['traid'] = '';
        }
        $ret['name']          = $this->getVar('fil_name');
        $ret['type']          = $this->getVar('fil_type');
        $ret['desc']          = \strip_tags($this->getVar('fil_desc', 'e'));
        $editorMaxchar = $helper->getConfig('editor_maxchar');
        $ret['desc_short']    = $utility::truncateHtml($ret['desc'], $editorMaxchar);
        $ret['ip']            = $this->getVar('fil_ip');
        $ret['datecreated']   = \formatTimestamp($this->getVar('fil_datecreated'), 's');
        $ret['submitter']     = \XoopsUser::getUnameFromId($this->getVar('fil_submitter'));
        return $ret;
    }
}
