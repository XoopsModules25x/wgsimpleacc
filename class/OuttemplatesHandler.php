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


/**
 * Class Object Handler Outtemplates
 */
class OuttemplatesHandler extends \XoopsPersistableObjectHandler
{
    /**
     * Constructor
     *
     * @param \XoopsDatabase $db
     */
    public function __construct(\XoopsDatabase $db)
    {
        parent::__construct($db, 'wgsimpleacc_outtemplates', Outtemplates::class, 'otpl_id', 'otpl_name');
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
     * @param int $i field id
     * @param null fields
     * @return mixed reference to the {@link Get} object
     */
    public function get($i = null, $fields = null)
    {
        return parent::get($i, $fields);
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
     * Get Count Outtemplates in the database
     * @param int    $start
     * @param int    $limit
     * @param string $sort
     * @param string $order
     * @return int
     */
    public function getCountOuttemplates($start = 0, $limit = 0, $sort = 'otpl_id ASC, otpl_name', $order = 'ASC')
    {
        $crCountOuttemplates = new \CriteriaCompo();
        $crCountOuttemplates = $this->getOuttemplatesCriteria($crCountOuttemplates, $start, $limit, $sort, $order);
        return $this->getCount($crCountOuttemplates);
    }

    /**
     * Get All Outtemplates in the database
     * @param int    $start
     * @param int    $limit
     * @param string $sort
     * @param string $order
     * @return array
     */
    public function getAllOuttemplates($start = 0, $limit = 0, $sort = 'otpl_id ASC, otpl_name', $order = 'ASC')
    {
        $crAllOuttemplates = new \CriteriaCompo();
        $crAllOuttemplates = $this->getOuttemplatesCriteria($crAllOuttemplates, $start, $limit, $sort, $order);
        return $this->getAll($crAllOuttemplates);
    }

    /**
     * Get Criteria Outtemplates
     * @param        $crOuttemplates
     * @param int    $start
     * @param int    $limit
     * @param string $sort
     * @param string $order
     * @return int
     */
    private function getOuttemplatesCriteria($crOuttemplates, $start, $limit, $sort, $order)
    {
        $crOuttemplates->setStart($start);
        $crOuttemplates->setLimit($limit);
        $crOuttemplates->setSort($sort);
        $crOuttemplates->setOrder($order);
        return $crOuttemplates;
    }
    /**
     * @public function to edit output
     * @param array $template
     * @return \XoopsThemeForm
     */
    public static function getFormEditTraOutput($template = [])
    {
        $helper = \XoopsModules\Wgsimpleacc\Helper::getInstance();
        $action = $_SERVER['REQUEST_URI'];

        $isAdmin = $GLOBALS['xoopsUser']->isAdmin($GLOBALS['xoopsModule']->mid());

        // Get Theme Form
        \xoops_load('XoopsFormLoader');
        $form = new \XoopsThemeForm(\_MA_WGSIMPLEACC_OUTTEMPLATE_FORM, 'formSelectOtpl', $action, 'post', true);
        $form->setExtra('enctype="multipart/form-data"');
        $form->setExtra('class="wgsa-form-inline"');

        if ($isAdmin) {
            $editor = $helper->getConfig('editor_admin');
        } else {
            $editor = $helper->getConfig('editor_user');
        }
        $editorConfigs1 = [];
        $editorConfigs1['name'] = 'otpl_header';
        $editorConfigs1['value'] = $template['header'];
        $editorConfigs1['rows'] = 2;
        $editorConfigs1['cols'] = 40;
        $editorConfigs1['width'] = '100%';
        $editorConfigs1['height'] = '400px';
        $editorConfigs1['editor'] = $editor;
        $outHeader = new \XoopsFormEditor(\_MA_WGSIMPLEACC_OUTTEMPLATE_HEADER, 'otpl_header', $editorConfigs1);
        $form->addElement($outHeader);

        $editorConfigs2 = [];
        $editorConfigs2['name'] = 'otpl_body';
        $editorConfigs2['value'] = $template['body'];
        $editorConfigs2['rows'] = 5;
        $editorConfigs2['cols'] = 40;
        $editorConfigs2['width'] = '100%';
        $editorConfigs2['height'] = '400px';
        $editorConfigs2['editor'] = $editor;
        $outBody = new \XoopsFormEditor(\_MA_WGSIMPLEACC_OUTTEMPLATE_BODY, 'otpl_body', $editorConfigs2);
        $form->addElement($outBody);

        $editorConfigs3 = [];
        $editorConfigs3['name'] = 'otpl_footer';
        $editorConfigs3['value'] = $template['footer'];
        $editorConfigs3['rows'] = 5;
        $editorConfigs3['cols'] = 40;
        $editorConfigs3['width'] = '100%';
        $editorConfigs3['height'] = '400px';
        $editorConfigs3['editor'] = $editor;
        $outFooter = new \XoopsFormEditor(\_MA_WGSIMPLEACC_OUTTEMPLATE_FOOTER, 'otpl_footer', $editorConfigs3);
        $form->addElement($outFooter);

        $targetSelect = new \XoopsFormSelect(\_MA_WGSIMPLEACC_OUTTEMPLATE_TARGET, 'target', 'form_browser', 5);
        $targetSelect->addOption('form_browser', \_MA_WGSIMPLEACC_OUTTEMPLATE_TARGET_BROWSER);
        $targetSelect->addOption('form_pdf', \_MA_WGSIMPLEACC_OUTTEMPLATE_TARGET_PDF);
        $form->addElement($targetSelect);

        // To Save
        $form->addElement(new \XoopsFormHidden('op', 'exec_output'));
        $form->addElement(new \XoopsFormButtonTray('', \_SUBMIT, 'submit', '', false));
        return $form;
    }

    /**
     * @public function to get output
     * @param array $outParams
     * @return array
     */
    public static function getFetchedOutput($outParams)
    {
        global $XoopsTpl;

        $helper = \XoopsModules\Wgsimpleacc\Helper::getInstance();

        $letterTpl = new \XoopsTpl();

        $outtemplateObj = $helper->getHandler('Outtemplates')->get($outParams['otpl_id']);
        if (!\is_object($outtemplateObj)) {
            \redirect_header('index.php?op=list', 3, \_MA_WGSIMPLEACC_INVALID_PARAM);
        }
        $otplBody = \str_replace(['&lt;', '&gt;'], ['<', '>'], $outtemplateObj->getVar('otpl_body', 'n'));

        // assign data of transaction
        foreach ($outParams as $key => $value) {
            $letterTpl->assign($key, $outParams[$key]);
        }
        // assign extra data
        $letterTpl->assign('sender', $helper->getConfig('otpl_sender'));
        $letterTpl->assign('output_date', date(_SHORTDATESTRING));
        $user = ('' != $GLOBALS['xoopsUser']->getVar('name')) ? $GLOBALS['xoopsUser']->getVar('name') : $GLOBALS['xoopsUser']->getVar('uname');
        $letterTpl->assign('output_user', $user);
        $letterTpl->assign('xoops_url', \XOOPS_URL);
        $letterTpl->assign('xoops_sitename', htmlspecialchars($GLOBALS['xoopsConfig']['sitename'], ENT_QUOTES));
        $letterTpl->assign('xoops_slogan', htmlspecialchars($GLOBALS['xoopsConfig']['slogan'], ENT_QUOTES));
        $letterTpl->assign('xoops_pagetitle', isset($GLOBALS['xoopsModule']) && is_object($GLOBALS['xoopsModule'])
            ? $GLOBALS['xoopsModule']->getVar('name')
            : htmlspecialchars($GLOBALS['xoopsConfig']['slogan'], ENT_QUOTES));

        // fetch templates
        $template['body'] = $letterTpl->fetchFromData($otplBody);

        $otplHeader = \str_replace(['&lt;', '&gt;'], ['<', '>'], $outtemplateObj->getVar('otpl_header', 'n'));
        $template['header'] = $letterTpl->fetchFromData($otplHeader);

        $otplFooter= \str_replace(['&lt;', '&gt;'], ['<', '>'], $outtemplateObj->getVar('otpl_footer', 'n'));
        $template['footer'] = $letterTpl->fetchFromData($otplFooter);

        return $template;
    }

    /**
     * @public function to get output
     * @param $traId
     * @return array
     */
    public static function getOutParams($traId) {
        $helper = \XoopsModules\Wgsimpleacc\Helper::getInstance();
        $transactionsHandler = $helper->getHandler('Transactions');
        $clientsHandler = $helper->getHandler('Clients');

        //get data from transactions
        $transactionsObj = $transactionsHandler->get($traId);
        $outParams = $transactionsObj->getValuesTransactions();
        //additional output params must be after call of transaction values
        //$outParams['otpl_id'] = $otplId;
        $client         = $outParams['client'];
        $clientsAddress = $clientsHandler->getClientFullAddress($transactionsObj->getVar('tra_cliid'));
        if ('' !== $clientsAddress) {
            $client .= $clientsAddress;
        }
        $outParams['recipient']  = $client;

        return $outParams;
    }
}
