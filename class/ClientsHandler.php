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

/**
 * Class Object Handler Clients
 */
class ClientsHandler extends \XoopsPersistableObjectHandler
{
    /**
     * Constructor
     *
     * @param \XoopsDatabase $db
     */
    public function __construct(\XoopsDatabase $db)
    {
        parent::__construct($db, 'wgsimpleacc_clients', Clients::class, 'cli_id', 'cli_name');
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
     * @return mixed reference to the {@link Get} object
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
     * Get Count Clients in the database
     * @param int    $start
     * @param int    $limit
     * @param string $sort
     * @param string $order
     * @return int
     */
    public function getCountClients($start = 0, $limit = 0, $sort = 'cli_name', $order = 'ASC')
    {
        $crCountClients = new \CriteriaCompo();
        $crCountClients = $this->getClientsCriteria($crCountClients, $start, $limit, $sort, $order);
        return $this->getCount($crCountClients);
    }

    /**
     * Get All Clients in the database
     * @param int    $start
     * @param int    $limit
     * @param string $sort
     * @param string $order
     * @return array
     */
    public function getAllClients($start = 0, $limit = 0, $sort = 'cli_name', $order = 'ASC')
    {
        $crAllClients = new \CriteriaCompo();
        $crAllClients = $this->getClientsCriteria($crAllClients, $start, $limit, $sort, $order);
        return $this->getAll($crAllClients);
    }

    /**
     * Get Criteria Clients
     * @param $crClients
     * @param $start
     * @param $limit
     * @param $sort
     * @param $order
     * @return int
     */
    private function getClientsCriteria($crClients, $start, $limit, $sort, $order)
    {
        $crClients->setStart($start);
        $crClients->setLimit($limit);
        $crClients->setSort($sort);
        $crClients->setOrder($order);
        return $crClients;
    }

    /**
     * Get All Clients in the database
     * @param  $cliId
     * @return string
     */
    public function getClientFullAddress($cliId)
    {
        $clientsObj = $this->get($cliId);
        $line1 = '';
        $line2 = '';
        if (\is_object($clientsObj)) {
            if ('' !== $clientsObj->getVar('cli_address')) {
                $line1 = $clientsObj->getVar('cli_address');
            }
            if ('' !== $clientsObj->getVar('cli_postal')) {
                $line2 .= $clientsObj->getVar('cli_postal');
            }
            if ('' !== $clientsObj->getVar('cli_city')) {
                if ('' !== $line2) {
                    $line2 .= '-';
                }
                $line2 .= $clientsObj->getVar('cli_city');
            }
            if ('' !== $line2) {
                $line2 = '<p>' . $line2 . '</p>';
            }
        }
        return $line1 . $line2;
    }

    /**
     * @public function to get form for filter clients
     * @param string $cliName
     * @return \XoopsSimpleForm
     */
    public static function getFormFilterClients($cliName = '')
    {
        $action = $_SERVER['REQUEST_URI'];

        // Get Theme Form
        \xoops_load('XoopsFormLoader');
        $form = new \XoopsModules\Wgsimpleacc\FormInline('', 'formFilter', $action, 'post', true);
        $form->setExtra('enctype="multipart/form-data"');
        $nameTray = new \XoopsFormElementTray('', '');
        $formText = new \XoopsFormText('', 'cli_name', 30, 100, $cliName);
        $formText->setExtra('placeholder="' . \_MA_WGSIMPLEACC_FORM_PLACEHOLDER_NAME . '"');
        $nameTray->addElement($formText);
        $nameTray->addElement(new \XoopsFormLabel('', '<button class="btn btn-primary" type="submit"><i class="fa fa-search fa-fw"></i></button>'));
        $form->addElement($nameTray);
        $form->addElement(new \XoopsFormHidden('op', 'list'));
        return $form;
    }
}
