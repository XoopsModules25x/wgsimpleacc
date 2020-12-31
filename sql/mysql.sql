# SQL Dump for wgsimpleacc module
# PhpMyAdmin Version: 4.0.4
# http://www.phpmyadmin.net
#
# Host: localhost
# Generated on: Sun Oct 04, 2020 to 11:52:33
# Server version: 5.5.5-10.4.10-MariaDB
# PHP Version: 7.4.0

#
# Structure table for `wgsimpleacc_transactions` 16
#

CREATE TABLE `wgsimpleacc_transactions` (
  `tra_id` INT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
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
  PRIMARY KEY (`tra_id`)
) ENGINE=InnoDB;

#
# Structure table for `wgsimpleacc_trahistories` 16
#

CREATE TABLE `wgsimpleacc_trahistories` (
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
) ENGINE=InnoDB;

#
# Structure table for `wgsimpleacc_assets` 11
#

CREATE TABLE `wgsimpleacc_assets` (
  `as_id` INT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `as_name` VARCHAR(255) NOT NULL DEFAULT '',
  `as_reference` VARCHAR(255) NOT NULL DEFAULT '',
  `as_descr` TEXT NOT NULL ,
  `as_color` VARCHAR(7) NOT NULL DEFAULT '',
  `as_iecalc` INT(1) NOT NULL DEFAULT '0',
  `as_online` INT(1) NOT NULL DEFAULT '0',
  `as_primary` INT(1) NOT NULL DEFAULT '0',
  `as_datecreated` INT(11) NOT NULL DEFAULT '0',
  `as_submitter` INT(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`as_id`)
) ENGINE=InnoDB;

#
# Structure table for `wgsimpleacc_balances` 6
#

CREATE TABLE `wgsimpleacc_balances` (
  `bal_id` INT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `bal_from` INT(10) NOT NULL DEFAULT '0',
  `bal_to` INT(10) NOT NULL DEFAULT '0',
  `bal_asid` INT(10) NOT NULL DEFAULT '0',
  `bal_curid` INT(10) NOT NULL DEFAULT '0',
  `bal_amountstart` DOUBLE(16, 2) NOT NULL DEFAULT '0.00',
  `bal_amountend` DOUBLE(16, 2) NOT NULL DEFAULT '0.00',
  `bal_status` INT(1) NOT NULL DEFAULT '0',
  `bal_datecreated` INT(10) NOT NULL DEFAULT '0',
  `bal_submitter` INT(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`bal_id`)
) ENGINE=InnoDB;

#
# Structure table for `wgsimpleacc_files` 8
#

CREATE TABLE `wgsimpleacc_files` (
  `fil_id` INT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `fil_traid` INT(10) NOT NULL DEFAULT '0',
  `fil_name` VARCHAR(255) NOT NULL DEFAULT '',
  `fil_type` VARCHAR(50) NOT NULL DEFAULT '',
  `fil_desc` TEXT NOT NULL ,
  `fil_ip` VARCHAR(16) NOT NULL DEFAULT '',
  `fil_datecreated` INT(10) NOT NULL DEFAULT '0',
  `fil_submitter` INT(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`fil_id`)
) ENGINE=InnoDB;

#
# Structure table for `wgsimpleacc_accounts` 11
#

CREATE TABLE `wgsimpleacc_accounts` (
  `acc_id` INT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `acc_pid` INT(10) NOT NULL DEFAULT '0',
  `acc_key` VARCHAR(25) NOT NULL DEFAULT '',
  `acc_name` VARCHAR(255) NOT NULL DEFAULT '',
  `acc_desc` TEXT NOT NULL ,
  `acc_classification` INT(10) NOT NULL DEFAULT '0',
  `acc_iecalc` INT(1) NOT NULL DEFAULT '0',
  `acc_color` VARCHAR(7) NOT NULL DEFAULT '',
  `acc_weight` INT(10) NOT NULL DEFAULT '0',
  `acc_level` INT(10) NOT NULL DEFAULT '0',
  `acc_online` INT(1) NOT NULL DEFAULT '0',
  `acc_datecreated` INT(10) NOT NULL DEFAULT '0',
  `acc_submitter` INT(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`acc_id`)
) ENGINE=InnoDB;

#
# Structure table for `wgsimpleacc_allocations` 9
#

CREATE TABLE `wgsimpleacc_allocations` (
  `all_id` INT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `all_pid` INT(10) NOT NULL DEFAULT '0',
  `all_name` VARCHAR(255) NOT NULL DEFAULT '',
  `all_desc` TEXT NOT NULL ,
  `all_online` INT(1) NOT NULL DEFAULT '0',
  `all_weight` INT(10) NOT NULL DEFAULT '0',
  `all_level` INT(10) NOT NULL DEFAULT '0',
  `all_datecreated` INT(10) NOT NULL DEFAULT '0',
  `all_submitter` INT(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`all_id`)
) ENGINE=InnoDB;

#
# Structure table for `wgsimpleacc_currencies` 7
#

CREATE TABLE `wgsimpleacc_currencies` (
  `cur_id` INT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cur_symbol` VARCHAR(5) NOT NULL DEFAULT '',
  `cur_code` VARCHAR(3) NOT NULL DEFAULT '',
  `cur_name` VARCHAR(255) NOT NULL DEFAULT '',
  `cur_primary` INT(1) NOT NULL DEFAULT '0',
  `cur_online` INT(1) NOT NULL DEFAULT '0',
  `cur_datecreated` INT(10) NOT NULL DEFAULT '0',
  `cur_submitter` INT(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`cur_id`)
) ENGINE=InnoDB;

#
# Structure table for `wgsimpleacc_taxes` 7
#

CREATE TABLE `wgsimpleacc_taxes` (
  `tax_id` INT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tax_name` VARCHAR(255) NOT NULL DEFAULT '',
  `tax_rate` INT(10) NOT NULL DEFAULT '0',
  `tax_online` INT(1) NOT NULL DEFAULT '0',
  `tax_primary` INT(1) NOT NULL DEFAULT '0',
  `tax_datecreated` INT(10) NOT NULL DEFAULT '0',
  `tax_submitter` INT(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`tax_id`)
) ENGINE=InnoDB;

#
# Structure table for `wgsimpleacc_tratemplates` 9
#

CREATE TABLE `wgsimpleacc_tratemplates` (
  `ttpl_id` INT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ttpl_name` VARCHAR(255) NOT NULL DEFAULT '',
  `ttpl_desc` VARCHAR(255) NOT NULL DEFAULT '',
  `ttpl_accid` INT(10) NOT NULL DEFAULT '0',
  `ttpl_allid` INT(10) NOT NULL DEFAULT '0',
  `ttpl_asid` INT(10) NOT NULL DEFAULT '0',
  `ttpl_amountin` DOUBLE(16, 2) NOT NULL DEFAULT '0.00',
  `ttpl_amountout` DOUBLE(16, 2) NOT NULL DEFAULT '0.00',
  `ttpl_online` INT(1) NOT NULL DEFAULT '0',
  `ttpl_datecreated` INT(10) NOT NULL DEFAULT '0',
  `ttpl_submitter` INT(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ttpl_id`)
) ENGINE=InnoDB;

#
# Structure table for `wgsimpleacc_outtemplates` 6
# 

CREATE TABLE `wgsimpleacc_outtemplates` (
  `otpl_id` INT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `otpl_name` VARCHAR(255) NOT NULL DEFAULT '',
  `otpl_content` TEXT NOT NULL ,
  `otpl_online` INT(1) NOT NULL DEFAULT '0',
  `otpl_datecreated` INT(10) NOT NULL DEFAULT '0',
  `otpl_submitter` INT(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`otpl_id`)
) ENGINE=InnoDB;
