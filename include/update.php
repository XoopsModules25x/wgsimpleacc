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
 * Wgsimpleacc module for xoops
 *
 * @param mixed      $module
 * @param null|mixed $prev_version
 * @package        Wgsimpleacc
 * @author         Wedega - Email:<webmaster@wedega.com> - Website:<https://wedega.com>
 * @version        $Id: 1.0 update.php 1 Mon 2018-03-19 10:04:53Z XOOPS Project (www.xoops.org) $
 * @copyright      module for xoops
 * @license        GPL 2.0 or later
 */

use XoopsModules\Wgsimpleacc;
use XoopsModules\Wgsimpleacc\Common\ {
    Configurator,
    Migrate,
    MigrateHelper
};

/**
 * @param      $module
 * @param null $prev_version
 *
 * @return bool|null
 */
function xoops_module_update_wgsimpleacc($module, $prev_version = null): ?bool
{
    $moduleDirName = $module->dirname();

    /*
    if ($prev_version < 133) {
        update_wgsimpleacc_v133($module);
    }
    */

    //wgsimpleacc_check_db($module);

    //check upload directory
    require_once __DIR__ . '/install.php';
    xoops_module_install_wgsimpleacc($module);

    // update DB corresponding to sql/mysql.sql
    $configurator = new Configurator();
    $migrate = new Migrate($configurator);

    $fileSql = \XOOPS_ROOT_PATH . '/modules/' . $moduleDirName . '/sql/mysql.sql';
    // ToDo: add function setDefinitionFile to .\class\libraries\vendor\xoops\xmf\src\Database\Migrate.php
    // Todo: once we are using setDefinitionFile this part has to be adapted
    //$fileYaml = \XOOPS_ROOT_PATH . '/modules/' . $moduleDirName . '/sql/update_' . $moduleDirName . '_migrate.yml';
    //try {
    //$migrate->setDefinitionFile('update_' . $moduleDirName);
    //} catch (\Exception $e) {
    // as long as this is not done default file has to be created
    $moduleVersionOld = $module->getInfo('version');
    $moduleVersionNew = \str_replace(['.', '-'], '_', $moduleVersionOld);
    $fileYaml = \XOOPS_ROOT_PATH . '/modules/' . $moduleDirName . "/sql/{$moduleDirName}_{$moduleVersionNew}_migrate.yml";
    //}

    // create a schema file based on sql/mysql.sql
    $migratehelper = new MigrateHelper($fileSql, $fileYaml);
    if (!$migratehelper->createSchemaFromSqlfile()) {
        \xoops_error('Error: creation schema file failed!');
        return false;
    }

    //create copy for XOOPS 2.5.11 Beta 1 and older versions
    $fileYaml2 = \XOOPS_ROOT_PATH . '/modules/' . $moduleDirName . "/sql/{$moduleDirName}_{$moduleVersionOld}_migrate.yml";
    \copy($fileYaml, $fileYaml2);

    // run standard procedure for db migration
    $migrate->synchronizeSchema();

    $errors = $module->getErrors();
    if (!empty($errors)) {
        print_r($errors);
        return false;
    }

    return true;

}

/**
 * @param $module
 *
 * @return bool
 */
/*
function wgsimpleacc_check_db($module)
{
    return true;
}
*/

/**
 * Update data of table wgsimpleacc_transactions because of changes in status
 * @param $module
 *
 * @return bool
 */
/*
function update_wgsimpleacc_v133($module)
{
    $helper = XoopsModules\Wgsimpleacc\Helper::getInstance();
    $transactionsHandler = $helper->getHandler('Transactions');
    $trahistoriesHandler = $helper->getHandler('Trahistories');

    $transactionsAll = $transactionsHandler->getAll();

    foreach (\array_keys($transactionsAll) as $i) {
        if (0 === (int)$transactionsAll[$i]->getVar('tra_dateupdated')) {
            //save last tra_datecreated as tra_dateupdated
            $traId = $transactionsAll[$i]->getVar('tra_id');
            $transactionsObj = $transactionsHandler->get($traId);
            $transactionsObj->setVar('tra_dateupdated', $transactionsAll[$i]->getVar('tra_datecreated'));
            //get first tra_datecreated from history as tra_datecreated
            $crHistory = new \CriteriaCompo();
            $crHistory->add(new \Criteria('tra_id', $traId));
            $crHistory->setSort('hist_id');
            $crHistory->setOrder('ASC');
            $crHistory->setStart();
            $crHistory->setLimit(1);
            $trahistorCount = $trahistoriesHandler->getCount($crHistory);
            if ($trahistorCount > 0) {
                // Get All Transactions
                $trahistorAll = $trahistoriesHandler->getAll($crHistory);
                foreach (\array_keys($trahistorAll) as $j) {
                    $transactionsObj->setVar('tra_datecreated', $trahistorAll[$j]->getVar('tra_datecreated'));
                }
            }
            $transactionsHandler->insert($transactionsObj);
        }
    }

    return true;
}
*/
