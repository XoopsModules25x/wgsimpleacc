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
 * wgSimpleAcc module for xoops
 *
 * @copyright      2020 XOOPS Project (https://xooops.org)
 * @license        GPL 2.0 or later
 * @package        wgsimpleacc
 * @since          1.0
 * @min_xoops      2.5.10
 * @author         Goffy - XOOPS Development Team - Email:<webmaster@wedega.com> - Website:<https://xoops.wedega.com>
 */

require_once __DIR__ . '/common.php';
require_once __DIR__ . '/main.php';

// ---------------- Admin Index ----------------
\define('_AM_WGSIMPLEACC_STATISTICS', 'Statistics');
// There are
\define('_AM_WGSIMPLEACC_THEREARE_ACCOUNTS', "There are <span class='bold'>%s</span> accounts in the database");
\define('_AM_WGSIMPLEACC_THEREARE_TRANSACTIONS', "There are <span class='bold'>%s</span> transactions in the database");
\define('_AM_WGSIMPLEACC_THEREARE_TRAHISTORIES', "There are <span class='bold'>%s</span> transaction histories in the database");
\define('_AM_WGSIMPLEACC_THEREARE_ALLOCATIONS', "There are <span class='bold'>%s</span> allocations in the database");
\define('_AM_WGSIMPLEACC_THEREARE_ASSETS', "There are <span class='bold'>%s</span> assets in the database");
\define('_AM_WGSIMPLEACC_THEREARE_CURRENCIES', "There are <span class='bold'>%s</span> currencies in the database");
\define('_AM_WGSIMPLEACC_THEREARE_TAXES', "There are <span class='bold'>%s</span> taxes in the database");
\define('_AM_WGSIMPLEACC_THEREARE_FILES', "There are <span class='bold'>%s</span> files in the database");
\define('_AM_WGSIMPLEACC_THEREARE_BALANCES', "There are <span class='bold'>%s</span> balances in the database");
\define('_AM_WGSIMPLEACC_THEREARE_TRATEMPLATES', "There are <span class='bold'>%s</span> transaction templates in the database");
\define('_AM_WGSIMPLEACC_THEREARE_OUTTEMPLATES', "There are <span class='bold'>%s</span> output templates in the database");
// ---------------- Admin Files ----------------
// Buttons
\define('_AM_WGSIMPLEACC_ADD_ACCOUNT', 'Add New Account');
\define('_AM_WGSIMPLEACC_ADD_TRANSACTION', 'Add New Transaction');
\define('_AM_WGSIMPLEACC_ADD_ALLOCATION', 'Add New Allocation');
\define('_AM_WGSIMPLEACC_ADD_ASSET', 'Add New Asset');
\define('_AM_WGSIMPLEACC_ADD_CURRENCY', 'Add New Currency');
\define('_AM_WGSIMPLEACC_ADD_TAX', 'Add New Tax');
\define('_AM_WGSIMPLEACC_ADD_FILE', 'Add New File');
\define('_AM_WGSIMPLEACC_ADD_BALANCE', 'Add New Balance');
\define('_AM_WGSIMPLEACC_ADD_TRATEMPLATE', 'Add New Transaction Template');
\define('_AM_WGSIMPLEACC_ADD_OUTTEMPLATE', 'Add New Output Template');
// Lists
\define('_AM_WGSIMPLEACC_LIST_ACCOUNTS', 'List of Accounts');
\define('_AM_WGSIMPLEACC_LIST_TRANSACTIONS', 'List of Transactions');
\define('_AM_WGSIMPLEACC_LIST_ALLOCATIONS', 'List of Allocations');
\define('_AM_WGSIMPLEACC_LIST_ASSETS', 'List of Assets');
\define('_AM_WGSIMPLEACC_LIST_CURRENCIES', 'List of Currencies');
\define('_AM_WGSIMPLEACC_LIST_TAXES', 'List of Taxes');
\define('_AM_WGSIMPLEACC_LIST_FILES', 'List of Files');
\define('_AM_WGSIMPLEACC_LIST_BALANCES', 'List of Balances');
\define('_AM_WGSIMPLEACC_LIST_TRATEMPLATES', 'List of Transaction Templates');
\define('_AM_WGSIMPLEACC_LIST_OUTTEMPLATES', 'List of Output Templates');
// ---------------- Admin Classes ----------------
// Caption of Transaction
\define('_AM_WGSIMPLEACC_TRANSACTION_HISTID', 'History Id');
\define('_AM_WGSIMPLEACC_TRANSACTION_HISTTYPE', 'History Type');
\define('_AM_WGSIMPLEACC_TRANSACTION_HISTDATE', 'History date');
// Account add/edit
\define('_AM_WGSIMPLEACC_ACCOUNT_ADD', 'Add Account');
\define('_AM_WGSIMPLEACC_ACCOUNT_EDIT', 'Edit Account');
// Allocation add/edit
\define('_AM_WGSIMPLEACC_ALLOCATION_ADD', 'Add Allocation');
\define('_AM_WGSIMPLEACC_ALLOCATION_EDIT', 'Edit Allocation');
// Asset add/edit
\define('_AM_WGSIMPLEACC_ASSET_ADD', 'Add Asset');
\define('_AM_WGSIMPLEACC_ASSET_EDIT', 'Edit Asset');
// Currency add/edit
\define('_AM_WGSIMPLEACC_CURRENCY_ADD', 'Add Currency');
\define('_AM_WGSIMPLEACC_CURRENCY_EDIT', 'Edit Currency');
// Elements of Currency
\define('_AM_WGSIMPLEACC_CURRENCY_ID', 'Id');
\define('_AM_WGSIMPLEACC_CURRENCY_SYMBOL', 'Symbol');
\define('_AM_WGSIMPLEACC_CURRENCY_CODE', 'Code');
\define('_AM_WGSIMPLEACC_CURRENCY_NAME', 'Name');
\define('_AM_WGSIMPLEACC_CURRENCY_PRIMARY', 'Primary');
\define('_AM_WGSIMPLEACC_CURRENCY_ONLINE', 'Online');
// Tax add/edit
\define('_AM_WGSIMPLEACC_TAX_ADD', 'Add Tax');
\define('_AM_WGSIMPLEACC_TAX_EDIT', 'Edit Tax');
// Elements of Tax
\define('_AM_WGSIMPLEACC_TAX_ID', 'Id');
\define('_AM_WGSIMPLEACC_TAX_NAME', 'Name');
\define('_AM_WGSIMPLEACC_TAX_RATE', 'Rate');
\define('_AM_WGSIMPLEACC_TAX_ONLINE', 'Online');
\define('_AM_WGSIMPLEACC_TAX_PRIMARY', 'Primary');
// Balance add/edit
\define('_AM_WGSIMPLEACC_BALANCE_ADD', 'Add Balance');
\define('_AM_WGSIMPLEACC_BALANCE_EDIT', 'Edit Balance');
// Template add/edit
\define('_AM_WGSIMPLEACC_TRATEMPLATE_ADD', 'Add Template');
\define('_AM_WGSIMPLEACC_TRATEMPLATE_EDIT', 'Edit Template');
// Template add/edit
\define('_AM_WGSIMPLEACC_OUTTEMPLATE_ADD', 'Add Template');
\define('_AM_WGSIMPLEACC_OUTTEMPLATE_EDIT', 'Edit Template');
// Status
\define('_AM_WGSIMPLEACC_STATUS_NONE', 'No status');
\define('_AM_WGSIMPLEACC_STATUS_OFFLINE', 'Offline');
\define('_AM_WGSIMPLEACC_STATUS_SUBMITTED', 'Submitted');
\define('_AM_WGSIMPLEACC_STATUS_APPROVED', 'Approved');
\define('_AM_WGSIMPLEACC_STATUS_BROKEN', 'Broken');
\define('_AM_WGSIMPLEACC_STATUS_CREATED', 'Created');
\define('_AM_WGSIMPLEACC_STATUS_LOCKED', 'Locked');
// ---------------- Admin Permissions ----------------
// Permissions
\define('_AM_WGSIMPLEACC_NO_PERMISSIONS_SET', 'No permission set');
\define('_AM_WGSIMPLEACC_PERMISSIONS_GLOBAL', 'Permissions global');
\define('_AM_WGSIMPLEACC_PERMISSIONS_GLOBAL_DESC', 'Set permissions <br>- global (for all) or <br>- for transactions, assets, allocations and account separately');
\define('_AM_WGSIMPLEACC_PERMISSIONS_GLOBAL_VIEW', 'Permissions global to view');
\define('_AM_WGSIMPLEACC_PERMISSIONS_GLOBAL_SUBMIT', 'Permissions global to submit');
\define('_AM_WGSIMPLEACC_PERMISSIONS_GLOBAL_APPROVE', 'Permissions global to approve');
\define('_AM_WGSIMPLEACC_PERMISSIONS_TRANSACTION_SUBMIT', 'Permissions to submit transaction');
\define('_AM_WGSIMPLEACC_PERMISSIONS_TRANSACTION_APPROVE', 'Permissions to approve submitted transaction');
\define('_AM_WGSIMPLEACC_PERMISSIONS_TRANSACTION_VIEW', 'Permissions to view transactions');
\define('_AM_WGSIMPLEACC_PERMISSIONS_ALLOCATION_SUBMIT', 'Permissions to submit allocation');
\define('_AM_WGSIMPLEACC_PERMISSIONS_ALLOCATION_VIEW', 'Permissions to view allocations');
\define('_AM_WGSIMPLEACC_PERMISSIONS_ASSET_SUBMIT', 'Permissions to submit asset');
\define('_AM_WGSIMPLEACC_PERMISSIONS_ASSET_VIEW', 'Permissions to view assets');
\define('_AM_WGSIMPLEACC_PERMISSIONS_ACCOUNT_SUBMIT', 'Permissions to submit account');
\define('_AM_WGSIMPLEACC_PERMISSIONS_ACCOUNT_VIEW', 'Permissions to view accounts');
\define('_AM_WGSIMPLEACC_PERMISSIONS_BALANCE_SUBMIT', 'Permissions to create balance');
\define('_AM_WGSIMPLEACC_PERMISSIONS_BALANCE_VIEW', 'Permissions to view balances');
\define('_AM_WGSIMPLEACC_PERMISSIONS_TRATEMPLATE_SUBMIT', 'Permissions to submit templates');
\define('_AM_WGSIMPLEACC_PERMISSIONS_TRATEMPLATE_VIEW', 'Permissions to view templates');
\define('_AM_WGSIMPLEACC_PERMISSIONS_OUTTEMPLATE_SUBMIT', 'Permissions to submit output templates');
\define('_AM_WGSIMPLEACC_PERMISSIONS_OUTTEMPLATE_VIEW', 'Permissions to view output templates');
// ---------------- Admin Others ----------------
\define('_AM_WGSIMPLEACC_ABOUT_MAKE_DONATION', 'Submit');
\define('_AM_WGSIMPLEACC_SUPPORT_FORUM', 'Support Forum');
\define('_AM_WGSIMPLEACC_DONATION_AMOUNT', 'Donation Amount');
\define('_AM_WGSIMPLEACC_MAINTAINEDBY', ' is maintained by ');
\define('_AM_WGSIMPLEACC_ERROR_NO_WGPHPOFFICE', "This module needs module 'wgPhpOffice' for output data as MS Excel file. Please install first!");
// ---------------- End ----------------
