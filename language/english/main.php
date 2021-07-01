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

require_once __DIR__ . '/admin.php';

// ---------------- Main ----------------
\define('_MA_WGSIMPLEACC_INDEX', 'Overview');
\define('_MA_WGSIMPLEACC_TITLE', 'wgSimpleAcc');
\define('_MA_WGSIMPLEACC_DESC', 'The wgSimpleAcc is a XOOPS module to record an income / expense account for clubs or small businesses');
\define('_MA_WGSIMPLEACC_INDEX_DESC', 'Welcome to the homepage of your new module wgSimpleAcc!');
\define('_MA_WGSIMPLEACC_NO_PDF_LIBRARY', 'Libraries TCPDF not there yet, upload them in root/Frameworks');
\define('_MA_WGSIMPLEACC_NO', 'No');
\define('_MA_WGSIMPLEACC_DETAILS', 'Show details');
\define('_MA_WGSIMPLEACC_REFRESH', 'Refresh');
\define('_MA_WGSIMPLEACC_FILTERTYPE', 'Filter');
\define('_MA_WGSIMPLEACC_SHOW_ALL', 'Show all');
\define('_MA_WGSIMPLEACC_SHOW_CUSTOM', 'Show custom selection');
\define('_MA_WGSIMPLEACC_FILTERBY_YEAR', 'Select year');
\define('_MA_WGSIMPLEACC_FILTERBY_ASSET', 'Select asset');
\define('_MA_WGSIMPLEACC_FILTERBY_ALLOC', 'Select allocation');
\define('_MA_WGSIMPLEACC_FILTERBY_ACCOUNT', 'Select account');
\define('_MA_WGSIMPLEACC_FILTERBY_PERIOD', 'Select period');
\define('_MA_WGSIMPLEACC_FILTERBY_CLIENT', 'Select client');
\define('_MA_WGSIMPLEACC_FILTER_PERIODFROM', 'From');
\define('_MA_WGSIMPLEACC_FILTER_PERIODTO', 'To');
\define('_MA_WGSIMPLEACC_FILTER_APPLY', 'Apply Filter');
\define('_MA_WGSIMPLEACC_FILTER_SHOW', 'Show Filter');
\define('_MA_WGSIMPLEACC_FILTER_HIDE', 'Hide Filter');
\define('_MA_WGSIMPLEACC_FILTER_OUTPUT', 'Output selected data');
\define('_MA_WGSIMPLEACC_FILTER_OUTPUTTYPE', 'Type of output');
\define('_MA_WGSIMPLEACC_DATECREATED', 'Date created');
\define('_MA_WGSIMPLEACC_SUBMITTER', 'Submitter');
\define('_MA_WGSIMPLEACC_LIST_CHILDS', 'Click to show/hide sub categories');
\define('_MA_WGSIMPLEACC_APPROVE', 'Approve');
\define('_MA_WGSIMPLEACC_DASHBOARD', 'Dashboard');
\define('_MA_WGSIMPLEACC_DOWNLOAD', 'Download');
\define('_MA_WGSIMPLEACC_REACTIVATE', 'Reactivate (add transaction to list of valid transactions again');
\define('_MA_WGSIMPLEACC_SUMS', 'Sums');
\define('_MA_WGSIMPLEACC_FORM_PLACEHOLDER_NAME', 'Enter name');
// ---------------- Contents ----------------
// There aren't
\define('_MA_WGSIMPLEACC_THEREARENT_ACCOUNTS', "There aren't accounts at the moment");
\define('_MA_WGSIMPLEACC_THEREARENT_TRANSACTIONS', "There aren't transactions at the moment");
\define('_MA_WGSIMPLEACC_THEREARENT_TRAHISTORIES', "There aren't transaction histories at the moment");
\define('_MA_WGSIMPLEACC_THEREARENT_ALLOCATIONS', "There aren't allocations at the moment");
\define('_MA_WGSIMPLEACC_THEREARENT_ASSETS', "There aren't assets at the moment");
\define('_MA_WGSIMPLEACC_THEREARENT_CURRENCIES', "There aren't currencies at the moment");
\define('_MA_WGSIMPLEACC_THEREARENT_TAXES', "There aren't taxes at the moment");
\define('_MA_WGSIMPLEACC_THEREARENT_FILES', "There aren't files at the moment");
\define('_MA_WGSIMPLEACC_THEREARENT_FILHISTORIES', "There aren't files histories at the moment");
\define('_MA_WGSIMPLEACC_THEREARENT_BALANCES', "There aren't balances at the moment");
\define('_MA_WGSIMPLEACC_THEREARENT_TRATEMPLATES', "There aren't transaction templates at the moment");
\define('_MA_WGSIMPLEACC_THEREARENT_OUTTEMPLATES', "There aren't output templates at the moment");
\define('_MA_WGSIMPLEACC_THEREARENT_CLIENTS', "There aren't clients at the moment");
// Account
\define('_MA_WGSIMPLEACC_ACCOUNT_ADD', 'Add Account');
\define('_MA_WGSIMPLEACC_ACCOUNT_EDIT', 'Edit Account');
\define('_MA_WGSIMPLEACC_ACCOUNT', 'Account');
\define('_MA_WGSIMPLEACC_ACCOUNTS', 'Accounts');
\define('_MA_WGSIMPLEACC_ACCOUNTS_TITLE', 'Accounts title');
\define('_MA_WGSIMPLEACC_ACCOUNTS_DESC', 'Accounts description');
\define('_MA_WGSIMPLEACC_ACCOUNTS_LIST', 'List of Accounts');
\define('_MA_WGSIMPLEACC_ACCOUNTS_TIMELINE', 'Development of accounts');
\define('_MA_WGSIMPLEACC_ACCOUNT_SUBMIT', 'Submit account');
// Caption of Account
\define('_MA_WGSIMPLEACC_ACCOUNT_ID', 'Id');
\define('_MA_WGSIMPLEACC_ACCOUNT_PID', 'Parent account');
\define('_MA_WGSIMPLEACC_ACCOUNT_KEY', 'Key');
\define('_MA_WGSIMPLEACC_ACCOUNT_NAME', 'Name');
\define('_MA_WGSIMPLEACC_ACCOUNT_DESC', 'Description');
\define('_MA_WGSIMPLEACC_ACCOUNT_CLASSIFICATION', 'Classification');
\define('_MA_WGSIMPLEACC_ACCOUNT_COLOR', 'Color');
\define('_MA_WGSIMPLEACC_ACCOUNT_ONLINE', 'Online');
\define('_MA_WGSIMPLEACC_ACCOUNT_SORT', 'Sort');
\define('_MA_WGSIMPLEACC_ACCOUNT_LEVEL', 'Level');
\define('_MA_WGSIMPLEACC_ACCOUNT_WEIGHT', 'Weight');
\define('_MA_WGSIMPLEACC_ACCOUNT_IECALC', 'Use in income/expenses calculation');
\define('_MA_WGSIMPLEACC_ACCOUNT_ERR_DELETE', 'Deleting account not possible!<br>Account already used for transactions!<br>Please change these transactions first');
// Transaction add/edit
\define('_MA_WGSIMPLEACC_TRANSACTION_ADD', 'Add transaction');
\define('_MA_WGSIMPLEACC_TRANSACTION_ADD_INCOME', 'Add transaction for income');
\define('_MA_WGSIMPLEACC_TRANSACTION_ADD_EXPENSES', 'Add transaction for expenses');
\define('_MA_WGSIMPLEACC_TRANSACTION_EDIT', 'Edit Transaction');
\define('_MA_WGSIMPLEACC_TRANSACTION_EDIT_INCOME', 'Edit transaction for income');
\define('_MA_WGSIMPLEACC_TRANSACTION_EDIT_EXPENSES', 'Edit transaction for expenses');
\define('_MA_WGSIMPLEACC_TRANSACTION_STATUS_WAITING', 'Waiting for approval');
\define('_MA_WGSIMPLEACC_TRANSACTION_DETAILS', 'Details for transaction');
// Transaction
\define('_MA_WGSIMPLEACC_TRANSACTION', 'Transaction');
\define('_MA_WGSIMPLEACC_TRANSACTIONS', 'Transactions');
\define('_MA_WGSIMPLEACC_TRANSACTIONS_TITLE', 'Transactions title');
\define('_MA_WGSIMPLEACC_TRANSACTIONS_DESC', 'Transactions description');
\define('_MA_WGSIMPLEACC_TRANSACTIONS_LIST', 'List of Transactions');
\define('_MA_WGSIMPLEACC_TRANSACTIONS_OVERVIEW', 'Overview of Transactions');
\define('_MA_WGSIMPLEACC_TRANSACTIONS_INCOMES', 'Incomes');
\define('_MA_WGSIMPLEACC_TRANSACTIONS_EXPENSES', 'Expenses');
\define('_MA_WGSIMPLEACC_TRANSACTION_SUBMIT_INCOME', 'Submit income');
\define('_MA_WGSIMPLEACC_TRANSACTION_SUBMIT_EXPENSE', 'Submit expense');
\define('_MA_WGSIMPLEACC_TRANSACTION_TRATEMPLATE', 'Use as template');
// Caption of Transaction
\define('_MA_WGSIMPLEACC_TRANSACTION_ID', 'Id');
\define('_MA_WGSIMPLEACC_TRANSACTION_YEAR', 'Year');
\define('_MA_WGSIMPLEACC_TRANSACTION_NB', 'Number');
\define('_MA_WGSIMPLEACC_TRANSACTION_YEARNB', 'Year/Number');
\define('_MA_WGSIMPLEACC_TRANSACTION_DESC', 'Description');
\define('_MA_WGSIMPLEACC_TRANSACTION_REFERENCE', 'Reference');
\define('_MA_WGSIMPLEACC_TRANSACTION_REMARKS', 'Remarks');
\define('_MA_WGSIMPLEACC_TRANSACTION_ACCID', 'Account');
\define('_MA_WGSIMPLEACC_TRANSACTION_ALLID', 'Allocation');
\define('_MA_WGSIMPLEACC_TRANSACTION_DATE', 'Value Date');
\define('_MA_WGSIMPLEACC_TRANSACTION_CURID', 'Currency');
\define('_MA_WGSIMPLEACC_TRANSACTION_AMOUNT', 'Amount');
\define('_MA_WGSIMPLEACC_TRANSACTION_AMOUNTIN', 'Amount income');
\define('_MA_WGSIMPLEACC_TRANSACTION_AMOUNTOUT', 'Amount expense');
\define('_MA_WGSIMPLEACC_TRANSACTION_TAXID', 'Tax rate');
\define('_MA_WGSIMPLEACC_TRANSACTION_ASID', 'Asset');
\define('_MA_WGSIMPLEACC_TRANSACTION_CLIID', 'Client');
\define('_MA_WGSIMPLEACC_TRANSACTION_STATUS', 'Status');
\define('_MA_WGSIMPLEACC_TRANSACTION_COMMENTS', 'Comments');
\define('_MA_WGSIMPLEACC_TRANSACTION_CLASS', 'Class');
\define('_MA_WGSIMPLEACC_TRANSACTION_FILES', 'Files');
\define('_MA_WGSIMPLEACC_TRANSACTION_BALID', 'Balance');
\define('_MA_WGSIMPLEACC_TRANSACTION_HIST', 'History');
\define('_MA_WGSIMPLEACC_TRANSACTION_TEMPLATE', 'Template');
// Allocation
\define('_MA_WGSIMPLEACC_ALLOCATION_ADD', 'Add Allocation');
\define('_MA_WGSIMPLEACC_ALLOCATION_EDIT', 'Edit Allocation');
\define('_MA_WGSIMPLEACC_ALLOCATION', 'Allocation');
\define('_MA_WGSIMPLEACC_ALLOCATIONS', 'Allocations');
\define('_MA_WGSIMPLEACC_ALLOCATIONS_TITLE', 'Allocations title');
\define('_MA_WGSIMPLEACC_ALLOCATIONS_DESC', 'Allocations description');
\define('_MA_WGSIMPLEACC_ALLOCATIONS_LIST', 'List of Allocations');
\define('_MA_WGSIMPLEACC_ALLOCATION_SUBMIT', 'Submit allocation');
\define('_MA_WGSIMPLEACC_ALLOCATION_SELECT', 'Select allocation');
// Caption of Allocation
\define('_MA_WGSIMPLEACC_ALLOCATION_ID', 'Id');
\define('_MA_WGSIMPLEACC_ALLOCATION_PID', 'Parent allocation');
\define('_MA_WGSIMPLEACC_ALLOCATION_NAME', 'Name');
\define('_MA_WGSIMPLEACC_ALLOCATION_DESC', 'Description');
\define('_MA_WGSIMPLEACC_ALLOCATION_ONLINE', 'Online');
\define('_MA_WGSIMPLEACC_ALLOCATION_SORT', 'Sort');
\define('_MA_WGSIMPLEACC_ALLOCATION_LEVEL', 'Level');
\define('_MA_WGSIMPLEACC_ALLOCATION_WEIGHT', 'Weight');
\define('_MA_WGSIMPLEACC_ALLOCATION_ERR_DELETE1', 'Deleting allocation not possible!<br>Allocation already used for transactions!<br>Please change these transactions first');
\define('_MA_WGSIMPLEACC_ALLOCATION_ERR_DELETE2', 'Deleting allocation not possible!<br>Allocation has sub allocations!<br>Please delete sub allocations first');
\define('_MA_WGSIMPLEACC_ALLOCATION_CURRID', 'Current allocation: %s');
// Asset
\define('_MA_WGSIMPLEACC_ASSET_ADD', 'Add Asset');
\define('_MA_WGSIMPLEACC_ASSET_EDIT', 'Edit Asset');
\define('_MA_WGSIMPLEACC_ASSET', 'Asset');
\define('_MA_WGSIMPLEACC_ASSETS', 'Assets');
\define('_MA_WGSIMPLEACC_ASSETS_TITLE', 'Assets title');
\define('_MA_WGSIMPLEACC_ASSETS_DESC', 'Assets description');
\define('_MA_WGSIMPLEACC_ASSETS_LIST', 'List of Assets');
\define('_MA_WGSIMPLEACC_ASSETS_OVERVIEW', 'Overview of Assets');
\define('_MA_WGSIMPLEACC_ASSETS_CURRENT', 'Current values of assets');
\define('_MA_WGSIMPLEACC_ASSETSTOTAL_CURRENT', 'Current values of assets in total');
\define('_MA_WGSIMPLEACC_ASSETS_TIMELINE', 'Development of assets');
\define('_MA_WGSIMPLEACC_ASSET_SUBMIT', 'Submit Asset');
// Caption of Asset
\define('_MA_WGSIMPLEACC_ASSET_ID', 'Id');
\define('_MA_WGSIMPLEACC_ASSET_NAME', 'Name');
\define('_MA_WGSIMPLEACC_ASSET_REFERENCE', 'Reference');
\define('_MA_WGSIMPLEACC_ASSET_DESCR', 'Description');
\define('_MA_WGSIMPLEACC_ASSET_COLOR', 'Color');
\define('_MA_WGSIMPLEACC_ASSET_IECALC', 'Use for income/expenses');
\define('_MA_WGSIMPLEACC_ASSET_IECALC_DESC', 'Use this assets for assigning to income or expenses');
\define('_MA_WGSIMPLEACC_ASSET_ONLINE', 'Online');
\define('_MA_WGSIMPLEACC_ASSET_PRIMARY', 'Primary');
\define('_MA_WGSIMPLEACC_ASSET_ERR_DELETE', 'Deleting asset not possible!<br>Assert is defined as primary!<br>Please define another asset as primary first');
//Charts
\define('_MA_WGSIMPLEACC_CHART_AMOUNT', 'Amount');
\define('_MA_WGSIMPLEACC_CHART_PERIOD', 'Period');
\define('_MA_WGSIMPLEACC_CHART_BALANCE', 'Balance');
\define('_MA_WGSIMPLEACC_CHART_TRAINEXSUMS', 'Sums of Transactions');
//Color
\define('_MA_WGSIMPLEACC_COLOR_LIGHTRED', 'Light Red');
\define('_MA_WGSIMPLEACC_COLOR_RED', 'Red');
\define('_MA_WGSIMPLEACC_COLOR_DARKRED', 'Dark red');
\define('_MA_WGSIMPLEACC_COLOR_LIGHTORANGE', 'Light Orange');
\define('_MA_WGSIMPLEACC_COLOR_ORANGE', 'Orange');
\define('_MA_WGSIMPLEACC_COLOR_DARKORANGE', 'Dark orange');
\define('_MA_WGSIMPLEACC_COLOR_LIGHTYELLOW', 'Light Yellow');
\define('_MA_WGSIMPLEACC_COLOR_YELLOW', 'Yellow');
\define('_MA_WGSIMPLEACC_COLOR_DARKYELLOW', 'Dark yellow');
\define('_MA_WGSIMPLEACC_COLOR_LIGHTGREEN', 'Light Green');
\define('_MA_WGSIMPLEACC_COLOR_GREEN', 'Green');
\define('_MA_WGSIMPLEACC_COLOR_DARKGREEN', 'Dark green');
\define('_MA_WGSIMPLEACC_COLOR_LIGHTBLUE', 'Light Blue');
\define('_MA_WGSIMPLEACC_COLOR_BLUE', 'Blue');
\define('_MA_WGSIMPLEACC_COLOR_DARKBLUE', 'Dark blue');
\define('_MA_WGSIMPLEACC_COLOR_LIGHTPURPLE', 'Light Purple');
\define('_MA_WGSIMPLEACC_COLOR_PURPLE', 'Purple');
\define('_MA_WGSIMPLEACC_COLOR_DARKPURPLE', 'Dark Purple');
\define('_MA_WGSIMPLEACC_COLOR_GREY', 'Grey');
\define('_MA_WGSIMPLEACC_COLOR_LIGHTBROWN', 'Light Brown');
\define('_MA_WGSIMPLEACC_COLOR_BROWN', 'Brown');
\define('_MA_WGSIMPLEACC_COLOR_DARKBROWN', 'Dark brown');
// File
\define('_MA_WGSIMPLEACC_FILE_ADD', 'Add File');
\define('_MA_WGSIMPLEACC_FILE_EDIT', 'Edit File');
\define('_MA_WGSIMPLEACC_FILE', 'File');
\define('_MA_WGSIMPLEACC_FILES', 'Files');
\define('_MA_WGSIMPLEACC_FILES_TITLE', 'Files title');
\define('_MA_WGSIMPLEACC_FILES_DESC', 'Files description');
\define('_MA_WGSIMPLEACC_FILES_LIST', 'List of Files');
\define('_MA_WGSIMPLEACC_FILES_LISTHEADER', 'Files of transaction: %t');
\define('_MA_WGSIMPLEACC_FILES_CURRENT', 'Current Files');
\define('_MA_WGSIMPLEACC_FILES_UPLOAD', 'Upload files');
\define('_MA_WGSIMPLEACC_FILES_UPLOAD_ERROR', 'Error upload files: invalid file name');
\define('_MA_WGSIMPLEACC_FILES_TEMP', 'Uploaded files');
\define('_MA_WGSIMPLEACC_FILES_TEMP_DESC', 'Uploaded files in folder: %f');
\define('_MA_WGSIMPLEACC_FILES_TEMP_DESC_NO', 'There are no uploaded files in folder: %f');
\define('_MA_WGSIMPLEACC_FILE_DETAILS', 'Details for file');
\define('_MA_WGSIMPLEACC_FILES_TEMP_DELETE', 'Delete shown file');
// Caption of File
\define('_MA_WGSIMPLEACC_FILE_ID', 'Id');
\define('_MA_WGSIMPLEACC_FILE_TRAID', 'Transaction');
\define('_MA_WGSIMPLEACC_FILE_NAME', 'Name');
\define('_MA_WGSIMPLEACC_FILE_NAME_UPLOADS', 'Name in %s :');
\define('_MA_WGSIMPLEACC_FILE_TYPE', 'Type');
\define('_MA_WGSIMPLEACC_FILE_DESC', 'Description');
\define('_MA_WGSIMPLEACC_FILE_IP', 'IP-Address');
\define('_MA_WGSIMPLEACC_FILE_PREVIEW', 'Preview');
// Balance
\define('_MA_WGSIMPLEACC_BALANCE_ADD', 'Add Balance');
\define('_MA_WGSIMPLEACC_BALANCE_EDIT', 'Edit Balance');
\define('_MA_WGSIMPLEACC_BALANCE', 'Balance');
\define('_MA_WGSIMPLEACC_BALANCES', 'Balances');
\define('_MA_WGSIMPLEACC_BALANCES_TITLE', 'Balances title');
\define('_MA_WGSIMPLEACC_BALANCES_LIST', 'List of Balances');
\define('_MA_WGSIMPLEACC_BALANCE_SUBMIT', 'Create balance');
\define('_MA_WGSIMPLEACC_BALANCE_SUBMIT_FINAL', 'Create balance finally');
\define('_MA_WGSIMPLEACC_BALANCE_PRECALC', 'Pre-Calculate');
\define('_MA_WGSIMPLEACC_BALANCES_TIMELINE', 'Development of assets per balance');
\define('_MA_WGSIMPLEACC_BALANCE_DETAILS', 'Details of balance');
// Caption of Balance
\define('_MA_WGSIMPLEACC_BALANCE_ID', 'Id');
\define('_MA_WGSIMPLEACC_BALANCE_FROM', 'From');
\define('_MA_WGSIMPLEACC_BALANCE_TO', 'To');
\define('_MA_WGSIMPLEACC_BALANCE_ASID', 'Asset');
\define('_MA_WGSIMPLEACC_BALANCE_CURID', 'Currency');
\define('_MA_WGSIMPLEACC_BALANCE_AMOUNTSTART', 'Amount Start');
\define('_MA_WGSIMPLEACC_BALANCE_AMOUNTEND', 'Amount End');
\define('_MA_WGSIMPLEACC_BALANCE_DIFFERENCE', 'Difference');
\define('_MA_WGSIMPLEACC_BALANCE_STATUS', 'Status');
\define('_MA_WGSIMPLEACC_BALANCE_CALC_PERIOD', 'Calculated values for period from %f to %t');
\define('_MA_WGSIMPLEACC_BALANCE_DATE', 'Last date of asset');
\define('_MA_WGSIMPLEACC_BALANCE_VALUESTART', 'Value asset (at start)');
\define('_MA_WGSIMPLEACC_BALANCE_VALUEEND', 'Calculated value at end');
\define('_MA_WGSIMPLEACC_BALANCE_DATEUSED', "The 'date from' or 'date to' is within the period of another balance");
\define('_MA_WGSIMPLEACC_BALANCE_ERRORS', 'Balances were created, but errors occured');
// Output balances
\define('_MA_WGSIMPLEACC_BALANCES_OUT_TOTAL', 'Total');
\define('_MA_WGSIMPLEACC_BALANCES_OUT_SUMS', 'Total');
\define('_MA_WGSIMPLEACC_BALANCES_OUT_SELECT', 'Select balances');
\define('_MA_WGSIMPLEACC_BALANCES_OUT_LEVEL', 'Select level of details');
\define('_MA_WGSIMPLEACC_BALANCES_OUT_LEVEL_SKIP', 'No output');
\define('_MA_WGSIMPLEACC_BALANCES_OUT_LEVEL_ALLOC', 'Level of allocations');
\define('_MA_WGSIMPLEACC_BALANCES_OUT_LEVEL_ALLOC1', 'Aggregate allocations on first level');
\define('_MA_WGSIMPLEACC_BALANCES_OUT_LEVEL_ALLOC2', 'Output detailed allocations');
\define('_MA_WGSIMPLEACC_BALANCES_OUT_LEVEL_ACC', 'Level of account');
\define('_MA_WGSIMPLEACC_BALANCES_OUT_LEVEL_ACC1', 'Aggregate all account');
\define('_MA_WGSIMPLEACC_BALANCES_OUT_LEVEL_ACC2', 'Aggregate accounts on first level');
// Templates general
\define('_MA_WGSIMPLEACC_TEMPLATES', 'Templates');
\define('_MA_WGSIMPLEACC_TEMPLATE_NONE', 'None');
// Tratemplates
\define('_MA_WGSIMPLEACC_TRATEMPLATE_ADD', 'Add Template');
\define('_MA_WGSIMPLEACC_TRATEMPLATE_EDIT', 'Edit Template');
\define('_MA_WGSIMPLEACC_TRATEMPLATES', 'Transaction templates');
\define('_MA_WGSIMPLEACC_TRATEMPLATES_LIST', 'List of Transaction Templates');
\define('_MA_WGSIMPLEACC_TRATEMPLATE_SUBMIT', 'Submit Transaction Template');
// Elements of Tratemplates
\define('_MA_WGSIMPLEACC_TRATEMPLATE_ID', 'Id');
\define('_MA_WGSIMPLEACC_TRATEMPLATE_NAME', 'Name');
\define('_MA_WGSIMPLEACC_TRATEMPLATE_DESC', 'Description');
\define('_MA_WGSIMPLEACC_TRATEMPLATE_ACCID', 'Accounts');
\define('_MA_WGSIMPLEACC_TRATEMPLATE_ALLID', 'Allocations');
\define('_MA_WGSIMPLEACC_TRATEMPLATE_ASID', 'Assets');
\define('_MA_WGSIMPLEACC_TRATEMPLATE_CLASS', 'Class');
\define('_MA_WGSIMPLEACC_TRATEMPLATE_AMOUNTIN', 'Amount in');
\define('_MA_WGSIMPLEACC_TRATEMPLATE_AMOUNTOUT', 'Amount out');
\define('_MA_WGSIMPLEACC_TRATEMPLATE_ONLINE', 'Online');
// Outtemplate
\define('_MA_WGSIMPLEACC_OUTTEMPLATE_ADD', 'Add Template');
\define('_MA_WGSIMPLEACC_OUTTEMPLATE_EDIT', 'Edit Template');
\define('_MA_WGSIMPLEACC_OUTTEMPLATE', 'Output template');
\define('_MA_WGSIMPLEACC_OUTTEMPLATES', 'Output templates');
\define('_MA_WGSIMPLEACC_OUTTEMPLATES_TITLE', 'Output templates title');
\define('_MA_WGSIMPLEACC_OUTTEMPLATES_LIST', 'List of Output templates');
\define('_MA_WGSIMPLEACC_OUTTEMPLATE_SUBMIT', 'Submit Output Template');
// Elements of Outtemplate
\define('_MA_WGSIMPLEACC_OUTTEMPLATE_ID', 'Id');
\define('_MA_WGSIMPLEACC_OUTTEMPLATE_NAME', 'Name');
\define('_MA_WGSIMPLEACC_OUTTEMPLATE_TYPE', 'Type');
\define('_MA_WGSIMPLEACC_OUTTEMPLATE_TYPE_READY', 'Ready to use');
\define('_MA_WGSIMPLEACC_OUTTEMPLATE_TYPE_BROWSER', 'Show in Browser');
\define('_MA_WGSIMPLEACC_OUTTEMPLATE_TYPE_FORM', 'Edit with form');
\define('_MA_WGSIMPLEACC_OUTTEMPLATE_TYPE_DESC', '- Ready to use: the template will be filled in and downloaded as pdf immediately<br>
- Show in Browser form: the data will be loaded and the output will be shown in your browser<br>
- Edit with form: the data will be loaded into a form and you can check result before output');
\define('_MA_WGSIMPLEACC_OUTTEMPLATE_HEADER', 'Page header');
\define('_MA_WGSIMPLEACC_OUTTEMPLATE_BODY', 'Content');
\define('_MA_WGSIMPLEACC_OUTTEMPLATE_FOOTER', 'Page footer');
\define('_MA_WGSIMPLEACC_OUTTEMPLATE_SMARTY', 'Smarty variables');
\define('_MA_WGSIMPLEACC_OUTTEMPLATE_SMARTY_DESC', '
    This module uses the Xoops <a href="http://www.smarty.net/">Smarty template engine</a> to render the output.
    <br><br>
    Available smarty-vars for transactions are:
    <ul>
    <li><{$sender}>: Default sender for output</li>
    <li><{$recipient}>: Recipient/Client</li>
    <li><{year}>: transaction registration year</li>
    <li><{nb}>: transaction registration year</li>
    <li><{$year_nb}>: Registration year/number of transaction (Format: YYYY/00000)</li>
    <li><{$desc}>: Description</li>
    <li><{$reference}>: Reference</li>
    <li><{$account}>: Account</li>
    <li><{$allocation}>: Allocation</li>
    <li><{$asset}>: Asset</li>
    <li><{$date}>: Transaction date</li>
    <li><{$amount}>: Amount</li>
    <li><{$status_text}>: Status</li>
    <li><{$datecreated}>: Date created</li>
    <li><{$submitter}>: Submitter</li>
    </ul>
    General smarty-vars are:
    <ul>
    <li><{$xoops_sitename}>: The website name</li>
    <li><{xoops_slogan}>: Slogan of website</li>
    <li><{$xoops_pagetitle}>: The page title</li>
    <li><{$xoops_url}>: The site main url (e.g. http://localhost/)</li>
    <li><{$output_date}>: Date output</li>
    <li><{$output_user}>: Current user name</li>
    </ul>');
\define('_MA_WGSIMPLEACC_OUTTEMPLATE_ALLID', 'Allocations');
\define('_MA_WGSIMPLEACC_OUTTEMPLATE_ACCID', 'Accounts');
\define('_MA_WGSIMPLEACC_OUTTEMPLATE_ALL', 'All');
\define('_MA_WGSIMPLEACC_OUTTEMPLATE_ONLINE', 'Online');
// Output Form
\define('_MA_WGSIMPLEACC_OUTTEMPLATE_FORM', 'Output Transaction');
\define('_MA_WGSIMPLEACC_OUTTEMPLATE_YEAR', 'Year');
\define('_MA_WGSIMPLEACC_OUTTEMPLATE_NB', 'Number');
\define('_MA_WGSIMPLEACC_OUTTEMPLATE_SENDER', 'Sender');
\define('_MA_WGSIMPLEACC_OUTTEMPLATE_RECIPIENT', 'Recipient');
\define('_MA_WGSIMPLEACC_OUTTEMPLATE_TARGET', 'Type of output');
\define('_MA_WGSIMPLEACC_OUTTEMPLATE_TARGET_BROWSER', 'Show only');
\define('_MA_WGSIMPLEACC_OUTTEMPLATE_TARGET_PDF', 'Output as PDF');
\define('_MA_WGSIMPLEACC_OUTTEMPLATE_PDF_SUCCESS', 'Output data as PDF successfully');
// Client
\define('_MA_WGSIMPLEACC_CLIENTS', 'Clients');
\define('_MA_WGSIMPLEACC_CLIENTS_LIST', 'List of Clients');
\define('_MA_WGSIMPLEACC_CLIENTS_FILTERED', 'Clients (filtered)');
\define('_MA_WGSIMPLEACC_CLIENTS_FILTEREDNON', 'No clients found for this criteria');
\define('_MA_WGSIMPLEACC_CLIENT_SUBMIT', 'Send Client');
\define('_MA_WGSIMPLEACC_CLIENTS_SHOWALL', 'Show all Clients');
\define('_MA_WGSIMPLEACC_CLIENTS_NOTFOUND', " didn't match any client");
// Client add/edit
\define('_MA_WGSIMPLEACC_CLIENT_ADD', 'Add Client');
\define('_MA_WGSIMPLEACC_CLIENT_EDIT', 'Edit Client');
\define('_MA_WGSIMPLEACC_CLIENT_DETAILS', 'Details for client');
// Elements of Client
\define('_MA_WGSIMPLEACC_CLIENT_ID', 'Id');
\define('_MA_WGSIMPLEACC_CLIENT_NAME', 'Name');
\define('_MA_WGSIMPLEACC_CLIENT_FULLADDRESS', 'Address');
\define('_MA_WGSIMPLEACC_CLIENT_POSTAL', 'Postal');
\define('_MA_WGSIMPLEACC_CLIENT_CITY', 'City');
\define('_MA_WGSIMPLEACC_CLIENT_ADDRESS', 'Address');
\define('_MA_WGSIMPLEACC_CLIENT_CTRY', 'Country');
\define('_MA_WGSIMPLEACC_CLIENT_PHONE', 'Phone');
\define('_MA_WGSIMPLEACC_CLIENT_VAT', 'Vat number');
\define('_MA_WGSIMPLEACC_CLIENT_CREDITOR', 'Creditor (vendor)');
\define('_MA_WGSIMPLEACC_CLIENT_DEBTOR', 'Debtor');
\define('_MA_WGSIMPLEACC_CLIENT_ONLINE', 'Online');
// Statistics
\define('_MA_WGSIMPLEACC_STATISTICS', 'Statistics');
// Outputs
\define('_MA_WGSIMPLEACC_OUTPUTS', 'Outputs');
\define('_MA_WGSIMPLEACC_OUTPUT_TRA_TITLE', 'Output Transaktions');
\define('_MA_WGSIMPLEACC_OUTPUT_BALANCES', 'Output Balances');
// History
\define('_MA_WGSIMPLEACC_HISTORY_ID', 'History Id');
\define('_MA_WGSIMPLEACC_HISTORY_TYPE', 'Type');
\define('_MA_WGSIMPLEACC_HISTORY_DATECREATED', 'Date History');
\define('_MA_WGSIMPLEACC_TRAHISTORY_LIST', 'History for transaction');
\define('_MA_WGSIMPLEACC_TRAHISTORY_DELETED', 'List of deleted transactions');
// Submit
\define('_MA_WGSIMPLEACC_SUBMIT', 'Submit');
// Modal
\define('_MA_WGSIMPLEACC_MODAL_TRATITLE', 'Details for transaction %s');
// Form
\define('_MA_WGSIMPLEACC_FORM_OK', 'Successfully saved');
\define('_MA_WGSIMPLEACC_FORM_DELETE_OK', 'Successfully deleted');
\define('_MA_WGSIMPLEACC_FORM_SURE_DELETE', "Are you sure to delete: <b><span style='color : Red;'>%s </span></b>");
\define('_MA_WGSIMPLEACC_FORM_SURE_RENEW', "Are you sure to update: <b><span style='color : Red;'>%s </span></b>");
\define('_MA_WGSIMPLEACC_INVALID_PARAM', 'Invalid parameter');
\define('_MA_WGSIMPLEACC_FORM_ACTION', 'Action');
\define('_MA_WGSIMPLEACC_FORM_UPLOAD', 'Upload file');
\define('_MA_WGSIMPLEACC_FORM_UPLOAD_SIZE', 'Max file size: ');
\define('_MA_WGSIMPLEACC_FORM_UPLOAD_SIZE_MB', 'MB');
\define('_MA_WGSIMPLEACC_FORM_IMAGE_PATH', 'Files in %s :');
\define('_MA_WGSIMPLEACC_FORM_UPLOAD_ALLOWEDMIME', 'Allowed mimetypes:');
//Constants class
\define('_MA_WGSIMPLEACC_CLASS_EXPENSES', 'Expenses');
\define('_MA_WGSIMPLEACC_CLASS_INCOME', 'Incomes');
\define('_MA_WGSIMPLEACC_CLASS_BOTH', 'Both');
// Constants Status
\define('_MA_WGSIMPLEACC_STATUS_NONE', 'No status');
\define('_MA_WGSIMPLEACC_STATUS_OFFLINE', 'Deleted');
\define('_MA_WGSIMPLEACC_STATUS_SUBMITTED', 'Submitted');
\define('_MA_WGSIMPLEACC_STATUS_APPROVED', 'Approved');
\define('_MA_WGSIMPLEACC_STATUS_BROKEN', 'Broken');
\define('_MA_WGSIMPLEACC_STATUS_CREATED', 'Created');
\define('_MA_WGSIMPLEACC_STATUS_LOCKED', 'Locked');
//PDF files
\define('_MA_WGSIMPLEACC_PDF_BUTTON', 'Output as PDF');
\define('_MA_WGSIMPLEACC_PDF_TRANAME', 'Transaction_%y_%n');
\define('_MA_WGSIMPLEACC_PDF_TRAHEADER', 'Transaction %y / %n');
\define('_MA_WGSIMPLEACC_PDF_BALNAME', 'Output_Balances');
\define('_MA_WGSIMPLEACC_PDF_BALHEADER', 'Output Balances');
// ---------------- Print ----------------
\define('_MA_WGSIMPLEACC_PRINT', 'Print');
// ---------------- Menu ----------------
\define('_MA_WGSIMPLEACC_MENUADMIN', 'Administration');
\define('_MA_WGSIMPLEACC_MENUUSER', 'User');
\define('_MA_WGSIMPLEACC_MENUNOTIF', 'Notification');
\define('_MA_WGSIMPLEACC_MENUINBOX', 'Inbox');
// ---------------- Online ----------------
\define('_MA_WGSIMPLEACC_ONLINE', 'Online');
\define('_MA_WGSIMPLEACC_OFFLINE', 'Offline');
// ---------------- Activate ----------------
\define('_MA_WGSIMPLEACC_ACTIVE', 'Activated (click to deactivate)');
\define('_MA_WGSIMPLEACC_NONACTIVE', 'Deactivated (click to activate)');
// Admin link
\define('_MA_WGSIMPLEACC_ADMIN', 'Admin');
// ---------------- End ----------------
