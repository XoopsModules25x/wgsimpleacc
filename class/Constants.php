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

/**
 * Interface  Constants
 */
interface Constants
{
    // Constants for tables
    /*
    public const TABLE_ACCOUNTS = 0;
    public const TABLE_TRANSACTIONS = 1;
    public const TABLE_ALLOCATIONS = 2;
    public const TABLE_ASSETS = 3;
    public const TABLE_CURRENCIES = 4;
    public const TABLE_TAXES = 5;
    public const TABLE_FILES = 6;
    public const TABLE_TRAHISTORIES = 7;
    public const TABLE_FILHISTORIES = 8;
    public const TABLE_BALANCES = 9;
    public const TABLE_OUTTEMPLATES = 10;
    public const TABLE_TRATEMPLATES = 11;
    public const TABLE_CLIENTS = 12;
    */

    // Constants for status
    public const STATUS_NONE      = 0;
    public const STATUS_CREATED   = 1;
    public const STATUS_BROKEN    = 2;
    public const STATUS_OFFLINE   = 3;
    public const STATUS_SUBMITTED = 4;
    public const STATUS_APPROVED  = 7;
    public const STATUS_TEMPORARY = 8;
    public const STATUS_LOCKED    = 9;

    // Constants for permissions
    public const PERM_GLOBAL_NONE          = 0;
    public const PERM_GLOBAL_VIEW          = 1;
    public const PERM_GLOBAL_SUBMIT        = 2;
    public const PERM_GLOBAL_APPROVE       = 3;
    public const PERM_TRANSACTIONS_APPROVE = 4;
    public const PERM_TRANSACTIONS_SUBMIT  = 5;
    public const PERM_TRANSACTIONS_VIEW    = 6;
    public const PERM_ALLOCATIONS_SUBMIT   = 7;
    public const PERM_ALLOCATIONS_VIEW     = 8;
    public const PERM_ASSETS_SUBMIT        = 9;
    public const PERM_ASSETS_VIEW          = 10;
    public const PERM_ACCOUNTS_SUBMIT      = 11;
    public const PERM_ACCOUNTS_VIEW        = 12;
    public const PERM_BALANCES_SUBMIT      = 13;
    public const PERM_BALANCES_VIEW        = 14;
    public const PERM_TRATEMPLATES_SUBMIT  = 15;
    public const PERM_TRATEMPLATES_VIEW    = 16;
    public const PERM_OUTTEMPLATES_SUBMIT  = 17;
    public const PERM_OUTTEMPLATES_VIEW    = 18;
    public const PERM_CLIENTS_SUBMIT       = 19;
    public const PERM_CLIENTS_VIEW         = 20;

    // Constants for account class
    public const CLASS_BOTH   = 1;
    public const CLASS_EXPENSES  = 2;
    public const CLASS_INCOME = 3;

    // Constants for filter
    public const FILTER_PYEARLY    = 1;
    public const FILTER_PMONTHLY   = 2;

    public const FILTER_TYPEALL    = 0;
    public const FILTER_TYPECUSTOM = 1;

    //Type of balance
    public const BALANCE_TYPE_TEMPORARY = 1;
    public const BALANCE_TYPE_FINAL = 2;
    //Output balances
    public const BALANCES_OUT_LEVEL_SKIP = 0;
    public const BALANCES_OUT_LEVEL_ALLOC1 = 1;
    public const BALANCES_OUT_LEVEL_ALLOC2 = 2;
    //public const BALANCES_OUT_LEVEL_ALLOC3 = 3;
    public const BALANCES_OUT_LEVEL_ACC1 = 1;
    public const BALANCES_OUT_LEVEL_ACC2 = 2;
    //public const BALANCES_OUT_LEVEL_ACC3 = 3;

    // Constants for output templates
    public const OUTTEMPLATE_TYPE_READY   = 1;
    public const OUTTEMPLATE_TYPE_BROWSER = 2;
    public const OUTTEMPLATE_TYPE_FORM    = 3;

    // Constants for output templates allocations
    public const OUTTEMPLATE_ALL = 0;

}
