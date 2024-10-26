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
 * Class Object StatisticsHandler
 */
class StatisticsHandler
{
    /**
     * Constructor
     *

     */
    public function __construct()
    {
    }

    public function buildList ($treeElements, $identifier) {

        $checkboxList = "<ul class='wgsa-checkboxlist'>\n";
        foreach ($treeElements as $element) {
            $checkboxList .= '<li><input id="' . $identifier . '[' . $element['id'] . ']" type="checkbox" name="' . $identifier . '[' . $element['id'] . ']" value="' . $element['id'] . '" />';
            $checkboxList .= '<span class="wgsa-input-label">' . $element['name'] .'</span>';
            if (\count($element['child']) > 0) {
                $checkboxList .= $this->buildList($element['child'], $identifier);
            }
            $checkboxList .="</li>\n";
        }


        return $checkboxList .= '</ul>';
    }

    /**
     * @public function getForm
     * @param array $paramsArr
     * @return \XoopsThemeForm
     */
    public static function getFormStatisticsSelect(array $paramsArr)
    {
        $helper = \XoopsModules\Wgsimpleacc\Helper::getInstance();
        $action = $_SERVER['REQUEST_URI'];
        $statisticsHandler = $helper->getHandler('Statistics');

        // Get Theme Form
        \xoops_load('XoopsFormLoader');
        $form = new \XoopsThemeForm(\_MA_WGSIMPLEACC_STATISTICS, 'formStatSelect', $action, 'post', true);
        $form->setExtra('enctype="multipart/form-data"');

        $allocationsHandler = $helper->getHandler('Allocations');
        $arrayAllTree = $allocationsHandler->getArrayTreeOfAllocations(0);
        $checkboxListAll = $statisticsHandler->buildList($arrayAllTree, 'allIds');
        $form->addElement(new \XoopsFormLabel(\_MA_WGSIMPLEACC_STATISTICS_ALL_SELECT, $checkboxListAll, 'labelAllids'));

        $accountsHandler = $helper->getHandler('Accounts');
        $arrayAccTree = $accountsHandler->getArrayTreeOfAccounts(0);
        $checkboxListAcc = $statisticsHandler->buildList($arrayAccTree, 'accIds');
        $form->addElement(new \XoopsFormLabel(\_MA_WGSIMPLEACC_STATISTICS_ACC_SELECT, $checkboxListAcc, 'labelAccids'));

        $selectType = new \XoopsFormSelect(\_MA_WGSIMPLEACC_STATISTICS_TYPE, 'type', 1, 2);
        $selectType->addOption(1, \_MA_WGSIMPLEACC_STATISTICS_TYPE_TIMELINE);
        $selectType->addOption(2, \_MA_WGSIMPLEACC_STATISTICS_TYPE_DISTR);
        $form->addElement($selectType);

        $form->addElement(new \XoopsFormHidden('op', 'all_acc_output'));
        $form->addElement(new \XoopsFormButtonTray('', \_MA_WGSIMPLEACC_STATISTICS_SHOW, 'submit', '', false));

        return $form;
    }
}
