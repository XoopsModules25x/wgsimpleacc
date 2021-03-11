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
 * @since          1.0
 * @min_xoops      2.5.9
 * @author         Wedega - Email:<webmaster@wedega.com> - Website:<https://wedega.com>
 * @version        $Id: 1.0 update.php 1 Mon 2018-03-19 10:04:53Z XOOPS Project (www.xoops.org) $
 * @copyright      module for xoops
 * @license        GPL 2.0 or later
 */

/**
 * @param      $module
 * @param null $prev_version
 *
 * @return bool|null
 */
function xoops_module_update_wgsimpleacc($module, $prev_version = null)
{
    $ret = null;
    if ($prev_version < 10) {
        $ret = update_wgsimpleacc_v10($module);
    }
    if ($prev_version < 120) {
        $ret = update_wgsimpleacc_v120($module);
    }

    $ret = wgsimpleacc_check_db($module);

    //check upload directory
	require_once __DIR__ . '/install.php';
    $ret = xoops_module_install_wgsimpleacc($module);

    $errors = $module->getErrors();
    if (!empty($errors)) {
        print_r($errors);
    }

    return $ret;

}

// irmtfan bug fix: solve templates duplicate issue
/**
 * @param $module
 *
 * @return bool
 */
function update_wgsimpleacc_v10($module)
{
    global $xoopsDB;
    $result = $xoopsDB->query(
        'SELECT t1.ttpl_id FROM ' . $xoopsDB->prefix('tplfile') . ' t1, ' . $xoopsDB->prefix('tplfile') . ' t2 WHERE t1.tpl_refid = t2.tpl_refid AND t1.tpl_module = t2.tpl_module AND t1.tpl_tplset=t2.tpl_tplset AND t1.tpl_file = t2.tpl_file AND t1.tpl_type = t2.tpl_type AND t1.ttpl_id > t2.ttpl_id'
    );
    $tplids = [];
    while (false !== (list($tplid) = $xoopsDB->fetchRow($result))) {
        $tplids[] = $tplid;
    }
    if (\count($tplids) > 0) {
        $tplfileHandler  = \xoops_getHandler('tplfile');
        $duplicate_files = $tplfileHandler->getObjects(new \Criteria('ttpl_id', '(' . \implode(',', $tplids) . ')', 'IN'));

        if (\count($duplicate_files) > 0) {
            foreach (\array_keys($duplicate_files) as $i) {
                $tplfileHandler->delete($duplicate_files[$i]);
            }
        }
    }
    $sql = 'SHOW INDEX FROM ' . $xoopsDB->prefix('tplfile') . " WHERE KEY_NAME = 'tpl_refid_module_set_file_type'";
    if (!$result = $xoopsDB->queryF($sql)) {
        xoops_error($xoopsDB->error() . '<br>' . $sql);

        return false;
    }
    $ret = [];
    while (false !== ($myrow = $xoopsDB->fetchArray($result))) {
        $ret[] = $myrow;
    }
    if (!empty($ret)) {
        $module->setErrors("'tpl_refid_module_set_file_type' unique index is exist. Note: check 'tplfile' table to be sure this index is UNIQUE because XOOPS CORE need it.");

        return true;
    }
    $sql = 'ALTER TABLE ' . $xoopsDB->prefix('tplfile') . ' ADD UNIQUE tpl_refid_module_set_file_type ( tpl_refid, tpl_module, tpl_tplset, tpl_file, tpl_type )';
    if (!$result = $xoopsDB->queryF($sql)) {
        xoops_error($xoopsDB->error() . '<br>' . $sql);
        $module->setErrors("'tpl_refid_module_set_file_type' unique index is not added to 'tplfile' table. Warning: do not use XOOPS until you add this unique index.");

        return false;
    }

    return true;
}


/**
 * @param $module
 *
 * @return bool
 */
function wgsimpleacc_check_db($module)
{
    $ret = true;

    $table   = $GLOBALS['xoopsDB']->prefix('wgsimpleacc_transactions');
    $field   = 'tra_remarks';
    $check   = $GLOBALS['xoopsDB']->queryF('SHOW COLUMNS FROM `' . $table . "` LIKE '" . $field . "'");
    $numRows = $GLOBALS['xoopsDB']->getRowsNum($check);
    if (!$numRows) {
        $sql = "ALTER TABLE `$table` ADD `$field` TEXT NOT NULL AFTER `tra_reference`;";
        if (!$result = $GLOBALS['xoopsDB']->queryF($sql)) {
            xoops_error($GLOBALS['xoopsDB']->error() . '<br>' . $sql);
            $module->setErrors("Error when adding '$field' to table '$table'.");
            $ret = false;
        }
    }

    $table   = $GLOBALS['xoopsDB']->prefix('wgsimpleacc_transactions');
    $field   = 'tra_hist';
    $check   = $GLOBALS['xoopsDB']->queryF('SHOW COLUMNS FROM `' . $table . "` LIKE '" . $field . "'");
    $numRows = $GLOBALS['xoopsDB']->getRowsNum($check);
    if (!$numRows) {
        $sql = "ALTER TABLE `$table` ADD `$field` INT(1) NOT NULL DEFAULT '0' AFTER `tra_balid`;";
        if (!$result = $GLOBALS['xoopsDB']->queryF($sql)) {
            xoops_error($GLOBALS['xoopsDB']->error() . '<br>' . $sql);
            $module->setErrors("Error when adding '$field' to table '$table'.");
            $ret = false;
        }
    }

    // create new table
    $table   = $GLOBALS['xoopsDB']->prefix('wgsimpleacc_trahistories');
    $check   = $GLOBALS['xoopsDB']->queryF("SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='$table'");
    $numRows = $GLOBALS['xoopsDB']->getRowsNum($check);
    if (!$numRows) {
        // create new table 'wgsimpleacc_trahistories'
        $sql = "CREATE TABLE `$table` (
                  `hist_id` INT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
                  `hist_type` VARCHAR(25) NOT NULL DEFAULT '',
                  `hist_datecreated` INT(10) NOT NULL DEFAULT '0',
                  `tra_id` INT(8) NOT NULL DEFAULT '0',
                  `tra_year` INT(10) NOT NULL DEFAULT '0',
                  `tra_nb` INT(10) NOT NULL DEFAULT '0',
                  `tra_desc` TEXT NOT NULL ,
                  `tra_reference` VARCHAR(255) NOT NULL DEFAULT '',
                  `tra_remarks` TEXT NOT NULL,
                  `tra_accid` INT(10) NOT NULL DEFAULT '0',
                  `tra_allid` INT(10) NOT NULL DEFAULT '0',
                  `tra_date` INT(11) NOT NULL DEFAULT '0',
                  `tra_curid` INT(10) NOT NULL DEFAULT '0',
                  `tra_amountin` DOUBLE(16, 2) NOT NULL DEFAULT '0.00',
                  `tra_amountout` DOUBLE(16,2) NOT NULL DEFAULT '0.00',
                  `tra_taxid` INT(10) NOT NULL DEFAULT '0',
                  `tra_asid` VARCHAR(45) NOT NULL DEFAULT '',
                  `tra_status` INT(1) NOT NULL DEFAULT '0',
                  `tra_comments` INT(10) NOT NULL DEFAULT '0',
                  `tra_class` INT(10) NOT NULL DEFAULT '0',
                  `tra_balid` INT(10) NOT NULL DEFAULT '0',
                  `tra_hist` INT(1) NOT NULL DEFAULT '0',
                  `tra_datecreated` INT(10) NOT NULL DEFAULT '0',
                  `tra_submitter` INT(10) NOT NULL DEFAULT '0',
                PRIMARY KEY (`hist_id`)
            ) ENGINE=InnoDB;";
        if (!$result = $GLOBALS['xoopsDB']->queryF($sql)) {
            xoops_error($GLOBALS['xoopsDB']->error() . '<br>' . $sql);
            $module->setErrors("Error when creating table '$table'.");
            $ret = false;
        }
    }

    $table   = $GLOBALS['xoopsDB']->prefix('wgsimpleacc_tratemplates');
    $field   = 'ttpl_class';
    $check   = $GLOBALS['xoopsDB']->queryF('SHOW COLUMNS FROM `' . $table . "` LIKE '" . $field . "'");
    $numRows = $GLOBALS['xoopsDB']->getRowsNum($check);
    if (!$numRows) {
        $sql = "ALTER TABLE `$table` ADD `$field` INT(1) NOT NULL DEFAULT '0' AFTER `ttpl_asid`;";
        if (!$result = $GLOBALS['xoopsDB']->queryF($sql)) {
            xoops_error($GLOBALS['xoopsDB']->error() . '<br>' . $sql);
            $module->setErrors("Error when adding '$field' to table '$table'.");
            $ret = false;
        }
    }

    // create new table
    $table   = $GLOBALS['xoopsDB']->prefix('wgsimpleacc_clients');
    $check   = $GLOBALS['xoopsDB']->queryF("SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='$table'");
    $numRows = $GLOBALS['xoopsDB']->getRowsNum($check);
    if (!$numRows) {
        // create new table 'wgsimpleacc_trahistories'
        $sql = "CREATE TABLE `$table` (
                  `cli_id` INT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
                  `cli_name` TEXT NOT NULL ,
                  `cli_postal` VARCHAR(255) NOT NULL DEFAULT '',
                  `cli_city` VARCHAR(255) NOT NULL DEFAULT '',
                  `cli_address` TEXT NOT NULL ,
                  `cli_ctry` VARCHAR(3) NOT NULL DEFAULT '',
                  `cli_phone` VARCHAR(255) NOT NULL DEFAULT '',
                  `cli_vat` VARCHAR(255) NOT NULL DEFAULT '',
                  `cli_creditor` INT(1) NOT NULL DEFAULT '0',
                  `cli_debtor` INT(1) NOT NULL DEFAULT '0',
                  `cli_datecreated` INT(10) NOT NULL DEFAULT '0',
                  `cli_submitter` INT(10) NOT NULL DEFAULT '0',
                  PRIMARY KEY (`cli_id`)
                ) ENGINE=InnoDB;";
        if (!$result = $GLOBALS['xoopsDB']->queryF($sql)) {
            xoops_error($GLOBALS['xoopsDB']->error() . '<br>' . $sql);
            $module->setErrors("Error when creating table '$table'.");
            $ret = false;
        }
    }

    $table   = $GLOBALS['xoopsDB']->prefix('wgsimpleacc_transactions');
    $field   = 'tra_cliid';
    $check   = $GLOBALS['xoopsDB']->queryF('SHOW COLUMNS FROM `' . $table . "` LIKE '" . $field . "'");
    $numRows = $GLOBALS['xoopsDB']->getRowsNum($check);
    if (!$numRows) {
        $sql = "ALTER TABLE `$table` ADD `$field` INT(10) NOT NULL DEFAULT '0' AFTER `tra_asid`;";
        if (!$result = $GLOBALS['xoopsDB']->queryF($sql)) {
            xoops_error($GLOBALS['xoopsDB']->error() . '<br>' . $sql);
            $module->setErrors("Error when adding '$field' to table '$table'.");
            $ret = false;
        }
    }
    $table   = $GLOBALS['xoopsDB']->prefix('wgsimpleacc_trahistories');
    $field   = 'tra_cliid';
    $check   = $GLOBALS['xoopsDB']->queryF('SHOW COLUMNS FROM `' . $table . "` LIKE '" . $field . "'");
    $numRows = $GLOBALS['xoopsDB']->getRowsNum($check);
    if (!$numRows) {
        $sql = "ALTER TABLE `$table` ADD `$field` INT(10) NOT NULL DEFAULT '0' AFTER `tra_asid`;";
        if (!$result = $GLOBALS['xoopsDB']->queryF($sql)) {
            xoops_error($GLOBALS['xoopsDB']->error() . '<br>' . $sql);
            $module->setErrors("Error when adding '$field' to table '$table'.");
            $ret = false;
        }
    }

    $table   = $GLOBALS['xoopsDB']->prefix('wgsimpleacc_files');
    $field   = 'fil_type';
    $check   = $GLOBALS['xoopsDB']->queryF('SHOW COLUMNS FROM `' . $table . "` LIKE '" . $field . "'");
    $numRows = $GLOBALS['xoopsDB']->getRowsNum($check);
    if ($numRows) { //use only for change
        $sql = "ALTER TABLE `$table` CHANGE `$field` `$field` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '';";
        if (!$result = $GLOBALS['xoopsDB']->queryF($sql)) {
            xoops_error($GLOBALS['xoopsDB']->error() . '<br>' . $sql);
            $module->setErrors("Error when adding '$field' to table '$table'.");
            $ret = false;
        }
    }

    $table   = $GLOBALS['xoopsDB']->prefix('wgsimpleacc_tratemplates');
    $field   = 'ttpl_cliid';
    $check   = $GLOBALS['xoopsDB']->queryF('SHOW COLUMNS FROM `' . $table . "` LIKE '" . $field . "'");
    $numRows = $GLOBALS['xoopsDB']->getRowsNum($check);
    if (!$numRows) {
        $sql = "ALTER TABLE `$table` ADD `$field` INT(10) NOT NULL DEFAULT '0' AFTER `ttpl_asid`;";
        if (!$result = $GLOBALS['xoopsDB']->queryF($sql)) {
            xoops_error($GLOBALS['xoopsDB']->error() . '<br>' . $sql);
            $module->setErrors("Error when adding '$field' to table '$table'.");
            $ret = false;
        }
    }

    // create new table
    $table   = $GLOBALS['xoopsDB']->prefix('wgsimpleacc_filhistories');
    $check   = $GLOBALS['xoopsDB']->queryF("SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='$table'");
    $numRows = $GLOBALS['xoopsDB']->getRowsNum($check);
    if (!$numRows) {
        // create new table 'wgsimpleacc_filhistories'
        $sql = "CREATE TABLE `$table` (
                  `hist_id`          INT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
                  `hist_type`        VARCHAR(255)    NOT NULL DEFAULT '',
                  `hist_datecreated` INT(10)         NOT NULL DEFAULT '0',
                  `hist_submitter`   INT(11)         NOT NULL DEFAULT '0',
                  `fil_id`           INT(8)          NOT NULL DEFAULT '0',
                  `fil_traid`        INT(10)         NOT NULL DEFAULT '0',
                  `fil_name`         VARCHAR(255)    NOT NULL DEFAULT '',
                  `fil_type`         VARCHAR(100)    NOT NULL DEFAULT '0',
                  `fil_desc`         TEXT            NOT NULL ,
                  `fil_ip`           VARCHAR(16)     NOT NULL DEFAULT '',
                  `fil_datecreated`  INT(10)         NOT NULL DEFAULT '0',
                  `fil_submitter`    INT(10)         NOT NULL DEFAULT '0',
                  PRIMARY KEY (`hist_id`)
                ) ENGINE=InnoDB;";
        if (!$result = $GLOBALS['xoopsDB']->queryF($sql)) {
            xoops_error($GLOBALS['xoopsDB']->error() . '<br>' . $sql);
            $module->setErrors("Error when creating table '$table'.");
            $ret = false;
        }
    }

    $table   = $GLOBALS['xoopsDB']->prefix('wgsimpleacc_trahistories');
    $field   = 'hist_submitter';
    $check   = $GLOBALS['xoopsDB']->queryF('SHOW COLUMNS FROM `' . $table . "` LIKE '" . $field . "'");
    $numRows = $GLOBALS['xoopsDB']->getRowsNum($check);
    if (!$numRows) {
        $sql = "ALTER TABLE `$table` ADD `$field` INT(11) NOT NULL DEFAULT '0' AFTER `hist_datecreated`;";
        if (!$result = $GLOBALS['xoopsDB']->queryF($sql)) {
            xoops_error($GLOBALS['xoopsDB']->error() . '<br>' . $sql);
            $module->setErrors("Error when adding '$field' to table '$table'.");
            $ret = false;
        }
    }

    $table   = $GLOBALS['xoopsDB']->prefix('wgsimpleacc_outtemplates');
    $field   = 'otpl_type';
    $check   = $GLOBALS['xoopsDB']->queryF('SHOW COLUMNS FROM `' . $table . "` LIKE '" . $field . "'");
    $numRows = $GLOBALS['xoopsDB']->getRowsNum($check);
    if (!$numRows) {
        $sql = "ALTER TABLE `$table` ADD `$field` INT(1) NOT NULL DEFAULT '0' AFTER `otpl_name`;";
        if (!$result = $GLOBALS['xoopsDB']->queryF($sql)) {
            xoops_error($GLOBALS['xoopsDB']->error() . '<br>' . $sql);
            $module->setErrors("Error when adding '$field' to table '$table'.");
            $ret = false;
        }
    }

    $table   = $GLOBALS['xoopsDB']->prefix('wgsimpleacc_outtemplates');
    $field   = 'otpl_allid';
    $check   = $GLOBALS['xoopsDB']->queryF('SHOW COLUMNS FROM `' . $table . "` LIKE '" . $field . "'");
    $numRows = $GLOBALS['xoopsDB']->getRowsNum($check);
    if (!$numRows) {
        $sql = "ALTER TABLE `$table` ADD `$field` VARCHAR(255) NOT NULL DEFAULT '' AFTER `otpl_body`;";
        if (!$result = $GLOBALS['xoopsDB']->queryF($sql)) {
            xoops_error($GLOBALS['xoopsDB']->error() . '<br>' . $sql);
            $module->setErrors("Error when adding '$field' to table '$table'.");
            $ret = false;
        }
    }

    $table   = $GLOBALS['xoopsDB']->prefix('wgsimpleacc_outtemplates');
    $field   = 'otpl_body';
    $check   = $GLOBALS['xoopsDB']->queryF('SHOW COLUMNS FROM `' . $table . "` LIKE '" . $field . "'");
    $numRows = $GLOBALS['xoopsDB']->getRowsNum($check);
    if ($numRows) {
        $sql = "ALTER TABLE `$table` CHANGE `otpl_body` `otpl_body` TEXT NOT NULL;";
        if (!$result = $GLOBALS['xoopsDB']->queryF($sql)) {
            xoops_error($GLOBALS['xoopsDB']->error() . '<br>' . $sql);
            $module->setErrors("Error when adding '$field' to table '$table'.");
            $ret = false;
        }
    }

    $table   = $GLOBALS['xoopsDB']->prefix('wgsimpleacc_outtemplates');
    $field   = 'otpl_header';
    $check   = $GLOBALS['xoopsDB']->queryF('SHOW COLUMNS FROM `' . $table . "` LIKE '" . $field . "'");
    $numRows = $GLOBALS['xoopsDB']->getRowsNum($check);
    if (!$numRows) {
        $sql = "ALTER TABLE `$table` ADD `$field` TEXT NOT NULL AFTER `otpl_type`;";
        if (!$result = $GLOBALS['xoopsDB']->queryF($sql)) {
            xoops_error($GLOBALS['xoopsDB']->error() . '<br>' . $sql);
            $module->setErrors("Error when adding '$field' to table '$table'.");
            $ret = false;
        }
    }

    $table   = $GLOBALS['xoopsDB']->prefix('wgsimpleacc_outtemplates');
    $field   = 'otpl_footer';
    $check   = $GLOBALS['xoopsDB']->queryF('SHOW COLUMNS FROM `' . $table . "` LIKE '" . $field . "'");
    $numRows = $GLOBALS['xoopsDB']->getRowsNum($check);
    if (!$numRows) {
        $sql = "ALTER TABLE `$table` ADD `$field` TEXT NOT NULL AFTER `otpl_body`;";
        if (!$result = $GLOBALS['xoopsDB']->queryF($sql)) {
            xoops_error($GLOBALS['xoopsDB']->error() . '<br>' . $sql);
            $module->setErrors("Error when adding '$field' to table '$table'.");
            $ret = false;
        }
    }

    return $ret;
}

/**
 * Update data of table wgsimpleacc_transactions because of changes in status
 * @param $module
 *
 * @return bool
 */
function update_wgsimpleacc_v120($module)
{
    $table = $GLOBALS['xoopsDB']->prefix('wgsimpleacc_transactions');
    $sql = "UPDATE `$table` SET `tra_status` = '9' WHERE `$table`.`tra_status` = 6;";
    $sql .= "UPDATE `$table` SET `tra_status` = '7' WHERE `$table`.`tra_status` = 3;";
    $sql .= "UPDATE `$table` SET `tra_status` = '3' WHERE `$table`.`tra_status` = 1;";
    $sql .= "UPDATE `$table` SET `tra_status` = '1' WHERE `$table`.`tra_status` = 5;";
    $sql .= "UPDATE `$table` SET `tra_status` = '22' WHERE `$table`.`tra_status` = 2;";
    $sql .= "UPDATE `$table` SET `tra_status` = '2' WHERE `$table`.`tra_status` = 4;";
    $sql .= "UPDATE `$table` SET `tra_status` = '4' WHERE `$table`.`tra_status` = 22;";
    if (!$result = $GLOBALS['xoopsDB']->queryF($sql)) {
        xoops_error($GLOBALS['xoopsDB']->error() . '<br>' . $sql);
        $module->setErrors("Error when updating table '$table'.");
        return false;
    }

    return true;
}
