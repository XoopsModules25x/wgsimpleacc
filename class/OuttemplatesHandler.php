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
     * @public function to select transactions/template for output
     * @param int $otplId
     * @param int $traYear
     * @param int $traNb
     * @return \XoopsThemeFormForm
     */
    public static function getFormSelectOutput($otplId = 0, $traYear = 0, $traNb = 0)
    {
        $helper = \XoopsModules\Wgsimpleacc\Helper::getInstance();
        $action = $_SERVER['REQUEST_URI'];

        $isAdmin = $GLOBALS['xoopsUser']->isAdmin($GLOBALS['xoopsModule']->mid());

        // Get Theme Form
        \xoops_load('XoopsFormLoader');
        $form = new \XoopsThemeForm(\_MA_WGSIMPLEACC_OUTTEMPLATE_SELECT, 'formSelectOtpl', $action, 'post', true);
        $form->setExtra('enctype="multipart/form-data"');
        $form->setExtra('class="wgsa-form-inline"');
        // Form Table outtemplates
        $outtemplatesHandler = $helper->getHandler('Outtemplates');
        $otplSelect = new \XoopsFormSelect(\_MA_WGSIMPLEACC_OUTTEMPLATE, 'otpl_id', $otplId);
        $otplSelect->addOptionArray($outtemplatesHandler->getList());
        $form->addElement($otplSelect);

        $selYears = [];
        $selNbMax = 0;
        $transactionsHandler = $helper->getHandler('Transactions');
        $transactionsAll = $transactionsHandler->getAll();
        foreach (\array_keys($transactionsAll) as $i) {
            $selYears[] = $transactionsAll[$i]->getVar('tra_year');
            $selNbMax = $selNbMax < $transactionsAll[$i]->getVar('tra_nb') ?: $transactionsAll[$i]->getVar('tra_nb');
        }
        if (0 === $traYear) {
            $traYear = \date('Y');
        }
        $yearSelect = new \XoopsFormSelect(\_MA_WGSIMPLEACC_OUTTEMPLATE_YEAR, 'tra_year', $traYear);
        foreach ($selYears as $selYear) {
            $yearSelect->addOption($selYear, $selYear);
        }
        $form->addElement($yearSelect, true);

        $nbSelect = new \XoopsFormSelect(\_MA_WGSIMPLEACC_OUTTEMPLATE_NB, 'tra_nb', $traNb);
        for ($i = 1; $i <= $selNbMax; $i++) {
            $nbSelect->addOption($i, $i);
        }
        $form->addElement($nbSelect, true);

        if ($isAdmin) {
            $editor = $helper->getConfig('editor_admin');
        } else {
            $editor = $helper->getConfig('editor_user');
        }
        $sender = $helper->getConfig('otpl_sender');
        if ('tinymce' == $editor) {
            $sender = \nl2br($sender);
        }
        $editorConfigs1['name'] = 'sender';
        $editorConfigs1['value'] = $sender;
        $editorConfigs1['rows'] = 2;
        $editorConfigs1['cols'] = 40;
        $editorConfigs1['width'] = '100%';
        $editorConfigs1['height'] = '100px';
        $editorConfigs1['editor'] = $editor;
        $outSender = new \XoopsFormEditor(\_MA_WGSIMPLEACC_OUTTEMPLATE_SENDER, 'sender', $editorConfigs1);
        $form->addElement($outSender);

        $editorConfigs2['name'] = 'recipient';
        $editorConfigs2['value'] = '';
        $editorConfigs2['rows'] = 5;
        $editorConfigs2['cols'] = 40;
        $editorConfigs2['width'] = '100%';
        $editorConfigs2['height'] = '400px';
        $editorConfigs2['editor'] = $editor;
        $outRecipient = new \XoopsFormEditor(\_MA_WGSIMPLEACC_OUTTEMPLATE_RECIPIENT, 'recipient', $editorConfigs2);
        $form->addElement($outRecipient);

        $targetSelect = new \XoopsFormSelect(\_MA_WGSIMPLEACC_OUTTEMPLATE_TARGET, 'target', 'show', 5);
        $targetSelect->addOption('show', \_MA_WGSIMPLEACC_OUTTEMPLATE_TARGET_SHOW);
        $targetSelect->addOption('pdf', \_MA_WGSIMPLEACC_OUTTEMPLATE_TARGET_PDF);
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
        $otplContent = \str_replace(['&lt;', '&gt;'], ['<', '>'], $outtemplateObj->getVar('otpl_content', 'n'));

        $transactionsHandler = $helper->getHandler('Transactions');
        $traId = (int)$outParams['tra_id'];
        if (0 == $traId) {
            $crTransactions = new \CriteriaCompo();
            $crTransactions->add(new \Criteria('tra_year', $outParams['tra_year']));
            $crTransactions->add(new \Criteria('tra_nb', $outParams['tra_nb']));
            $crTransactions->setStart(0);
            $crTransactions->setLimit(1);
            $transactionsAll = $transactionsHandler->getAll($crTransactions);
            foreach (\array_keys($transactionsAll) as $i) {
                $traId = $transactionsAll[$i]->getVar('tra_id');
            }
        }
        $transactionsObj = $transactionsHandler->get($traId);
        if (!\is_object($transactionsObj)) {
            \redirect_header('index.php?op=list', 3, \_MA_WGSIMPLEACC_INVALID_PARAM);
        }
        $transaction = $transactionsObj->getValuesTransactions();
        $letterTpl->assign('sender', $outParams['sender']);
        $letterTpl->assign('recipient', $outParams['recipient']);
        $letterTpl->assign('year', $transaction['year']);
        $letterTpl->assign('nb', $transaction['nb']);
        $letterTpl->assign('year_nb', $transaction['year_nb']);
        $letterTpl->assign('desc', $transaction['tra_desc']);
        $letterTpl->assign('reference', $transaction['tra_reference']);
        $letterTpl->assign('account', $transaction['account']);
        $letterTpl->assign('allocation', $transaction['allocation']);
        $letterTpl->assign('asset', $transaction['asset']);
        $letterTpl->assign('amount', $transaction['amount']);
        $letterTpl->assign('date', $transaction['date']);


        // extra data
        $letterTpl->assign('output_date', date(_SHORTDATESTRING));
        $user = ('' != $GLOBALS['xoopsUser']->getVar('name')) ? $GLOBALS['xoopsUser']->getVar('name') : $GLOBALS['xoopsUser']->getVar('uname');
        $letterTpl->assign('output_user', $user);
        $letterTpl->assign('xoops_url', \XOOPS_URL);

        $template['body'] = $letterTpl->fetchFromData($otplContent);
        $template['tra_id'] = $traId;
        return $template;
    }
}
