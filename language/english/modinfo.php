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
 * @author         Goffy - XOOPS Development Team - Email:<webmaster@wedega.com> - Website:<https://xoops.wedega.com>
 */

require_once __DIR__ . '/common.php';

// ---------------- Admin Main ----------------
\define('_MI_WGSIMPLEACC_NAME', 'wgSimpleAcc');
\define('_MI_WGSIMPLEACC_DESC', 'wgSimpleAcc - a simple tool for income/expenses calculation of small communities');
// ---------------- Admin Menu ----------------
\define('_MI_WGSIMPLEACC_ADMENU1', 'Dashboard');
\define('_MI_WGSIMPLEACC_ADMENU2', 'Transactions');
\define('_MI_WGSIMPLEACC_ADMENU3', 'Files');
\define('_MI_WGSIMPLEACC_ADMENU4', 'Assets');
\define('_MI_WGSIMPLEACC_ADMENU5', 'Accounts');
\define('_MI_WGSIMPLEACC_ADMENU6', 'Allocations');
\define('_MI_WGSIMPLEACC_ADMENU7', 'Currencies');
\define('_MI_WGSIMPLEACC_ADMENU8', 'Taxes');
\define('_MI_WGSIMPLEACC_ADMENU9', 'Balances');
\define('_MI_WGSIMPLEACC_ADMENU10', 'Templates Transaction');
\define('_MI_WGSIMPLEACC_ADMENU11', 'Templates Outputs');
\define('_MI_WGSIMPLEACC_ADMENU12', 'Permissions');
\define('_MI_WGSIMPLEACC_ADMENU13', 'Feedback');
\define('_MI_WGSIMPLEACC_ADMENU14', 'Transactions History');
\define('_MI_WGSIMPLEACC_ADMENU15', 'Clients');
\define('_MI_WGSIMPLEACC_ADMENU16', 'Files History');
\define('_MI_WGSIMPLEACC_ABOUT', 'About');
// ---------------- Admin Nav ----------------
\define('_MI_WGSIMPLEACC_ADMIN_PAGER', 'Admin pager');
\define('_MI_WGSIMPLEACC_ADMIN_PAGER_DESC', 'Admin per page list');
// User
\define('_MI_WGSIMPLEACC_USER_PAGER', 'User pager');
\define('_MI_WGSIMPLEACC_USER_PAGER_DESC', 'User per page list');
// Config
\define('_MI_WGSIMPLEACC_GROUP_GENERAL', 'General options');
\define('_MI_WGSIMPLEACC_GROUP_UPLOAD', 'Uploads');
\define('_MI_WGSIMPLEACC_GROUP_DISPLAY', 'Display');
\define('_MI_WGSIMPLEACC_GROUP_FORMATS', 'Formats');
\define('_MI_WGSIMPLEACC_GROUP_INDEX', 'Index page');
\define('_MI_WGSIMPLEACC_GROUP_BALANCE', 'Balance options');
\define('_MI_WGSIMPLEACC_GROUP_OPTCOMP', 'Optional components');
\define('_MI_WGSIMPLEACC_GROUP_MISC', 'Misc');
\define('_MI_WGSIMPLEACC_EDITOR_ADMIN', 'Editor admin');
\define('_MI_WGSIMPLEACC_EDITOR_ADMIN_DESC', 'Select the editor which should be used in admin area for text area fields');
\define('_MI_WGSIMPLEACC_EDITOR_USER', 'Editor user');
\define('_MI_WGSIMPLEACC_EDITOR_USER_DESC', 'Select the editor which should be used in user area for text area fields');
\define('_MI_WGSIMPLEACC_EDITOR_MAXCHAR', 'Text max characters');
\define('_MI_WGSIMPLEACC_EDITOR_MAXCHAR_DESC', 'Max characters for showing text of a textarea or editor field in admin area');
\define('_MI_WGSIMPLEACC_KEYWORDS', 'Keywords');
\define('_MI_WGSIMPLEACC_KEYWORDS_DESC', 'Insert here the keywords (separate by comma)');
\define('_MI_WGSIMPLEACC_SIZE_MB', 'MB');
\define('_MI_WGSIMPLEACC_MAXWIDTH_IMAGE', 'Max width image');
\define('_MI_WGSIMPLEACC_MAXWIDTH_IMAGE_DESC', 'Set the max width to which uploaded images should be scaled (in pixel)<br>0 means, that images keeps the original size. <br>If an image is smaller than maximum value then the image will be not enlarge, it will be save in original width.');
\define('_MI_WGSIMPLEACC_MAXHEIGHT_IMAGE', 'Max height image');
\define('_MI_WGSIMPLEACC_MAXHEIGHT_IMAGE_DESC', 'Set the max height to which uploaded images should be scaled (in pixel)<br>0 means, that images keeps the original size. <br>If an image is smaller than maximum value then the image will be not enlarge, it will be save in original height');
\define('_MI_WGSIMPLEACC_MAXSIZE_FILE', 'Max size file');
\define('_MI_WGSIMPLEACC_MAXSIZE_FILE_DESC', 'Define the max size for uploading files');
\define('_MI_WGSIMPLEACC_MIMETYPES_FILE', 'Mime types file');
\define('_MI_WGSIMPLEACC_MIMETYPES_FILE_DESC', 'Define the allowed mime types for uploading files');
\define('_MI_WGSIMPLEACC_UPLOAD_BY_APP', 'Use file upload app');
\define('_MI_WGSIMPLEACC_UPLOAD_BY_APP_DESC', "If you are using a file upload app (e.g. Project Camera) to upload images or files then select 'Yes'");
\define('_MI_WGSIMPLEACC_ADVERTISE', 'Advertisement Code');
\define('_MI_WGSIMPLEACC_ADVERTISE_DESC', 'Insert here the advertisement code');
\define('_MI_WGSIMPLEACC_MAINTAINEDBY', 'Maintained By');
\define('_MI_WGSIMPLEACC_MAINTAINEDBY_DESC', 'Allow url of support site or community');
\define('_MI_WGSIMPLEACC_SEP_COMMA', 'Comma separator');
\define('_MI_WGSIMPLEACC_SEP_COMMA_DESC', 'Please define comma separator');
\define('_MI_WGSIMPLEACC_SEP_THSD', 'Thousands separator');
\define('_MI_WGSIMPLEACC_SEP_THSD_DESC', 'Please define thousands separator');
\define('_MI_WGSIMPLEACC_USE_CURRENCIES', 'Use currencies');
\define('_MI_WGSIMPLEACC_USE_CURRENCIES_DESC', 'Please define whether you want use currencies');
\define('_MI_WGSIMPLEACC_USE_TAXES', 'Use taxes');
\define('_MI_WGSIMPLEACC_USE_TAXES_DESC', 'Please define whether you want use taxes');
\define('_MI_WGSIMPLEACC_USE_FILES', 'Use file system');
\define('_MI_WGSIMPLEACC_USE_FILES_DESC', 'Please define whether you want use the possibility to add files to your transactions');
\define('_MI_WGSIMPLEACC_USE_FILES_ADD', 'Use additional file system');
\define('_MI_WGSIMPLEACC_USE_FILES_ADD_DESC', 'Please define whether you want use the simple filemanager to add files with no link to specific transaction');
\define('_MI_WGSIMPLEACC_USE_CLIENTS', 'Use clients system');
\define('_MI_WGSIMPLEACC_USE_CLIENTS_DESC', 'Please define whether you want use the possibility to handle client data');
\define('_MI_WGSIMPLEACC_USE_TRAHISTORY', 'Use transaction histories');
\define('_MI_WGSIMPLEACC_USE_TRAHISTORY_DESC', 'If you are using histories then original data will be stored in history table before deleting or updating');
\define('_MI_WGSIMPLEACC_USE_FILHISTORY', 'Use files histories');
\define('_MI_WGSIMPLEACC_USE_FILHISTORY_DESC', 'If you are using histories then original data will be stored in history table before deleting or updating. Then files itself will be not deleted');
\define('_MI_WGSIMPLEACC_USE_CASCADINGACC', 'Use cascadierende accounts');
\define('_MI_WGSIMPLEACC_USE_CASCADINGACC_DESC', 'If you are using this option, then you have to associate accounts to the allocations. When you are create a transaction, then only accounts will be shown which are associated to the selected allocation.<br>If you are not using this option, then allways all available accounts will be shown if you are creating a transaction.');
/*
\define('_MI_WGSIMPLEACC_BALANCE_PERIOD', 'Balancing period');
\define('_MI_WGSIMPLEACC_BALANCE_PERIOD_DESC', 'Define period how balancing should be done');
\define('_MI_WGSIMPLEACC_BALANCE_FILTER_PYEARLY', 'Yearly');
\define('_MI_WGSIMPLEACC_BALANCE_FILTER_PMONTHLY', 'Monthly');
\define('_MI_WGSIMPLEACC_BALANCE_PERIOD_FROM', 'From');
\define('_MI_WGSIMPLEACC_BALANCE_PERIOD_FROM_DESC', "Select, if balancing period is 'Monthly', otherwise ignore it");
\define('_MI_WGSIMPLEACC_BALANCE_PERIOD_TO', 'To');
\define('_MI_WGSIMPLEACC_JANUARY', 'January');
\define('_MI_WGSIMPLEACC_FEBRUARY', 'February');
\define('_MI_WGSIMPLEACC_MARCH', 'March');
\define('_MI_WGSIMPLEACC_APRIL', 'April');
\define('_MI_WGSIMPLEACC_MAY', 'May');
\define('_MI_WGSIMPLEACC_JUNE', 'June');
\define('_MI_WGSIMPLEACC_JULY', 'July');
\define('_MI_WGSIMPLEACC_AUGUST', 'August');
\define('_MI_WGSIMPLEACC_SEPTEMBER', 'September');
\define('_MI_WGSIMPLEACC_OCTOBER', 'October');
\define('_MI_WGSIMPLEACC_NOVEMBER', 'November');
\define('_MI_WGSIMPLEACC_DECEMBER', 'December');

*/
\define('_MI_WGSIMPLEACC_BALANCES_OUT_LEVEL_SKIP', 'No output');
\define('_MI_WGSIMPLEACC_BALANCES_OUT_LEVEL_DESC', 'Please decide, which level of details should be used by default for the output of balances');
\define('_MI_WGSIMPLEACC_BALANCES_OUT_LEVEL_ALLOC', 'Default level of allocations');
\define('_MI_WGSIMPLEACC_BALANCES_OUT_LEVEL_ALLOC1', 'Aggregate allocations on first level');
\define('_MI_WGSIMPLEACC_BALANCES_OUT_LEVEL_ALLOC2', 'Output detailed allocations');
\define('_MI_WGSIMPLEACC_BALANCES_OUT_LEVEL_ACC', 'Default level of account');
\define('_MI_WGSIMPLEACC_BALANCES_OUT_LEVEL_ACC1', 'Aggregate all account');
\define('_MI_WGSIMPLEACC_BALANCES_OUT_LEVEL_ACC2', 'Aggregate accounts on first level');
\define('_MI_WGSIMPLEACC_INDEXHEADER', 'Index header');
\define('_MI_WGSIMPLEACC_INDEXHEADER_DESC', 'Show this text as header on index page');
\define('_MI_WGSIMPLEACC_INDEX_TRAHBAR', 'Index Transaction Bar');
\define('_MI_WGSIMPLEACC_INDEX_TRAHBAR_DESC', 'Show transaction bar (horizontal) with amounts of current period on index page');
\define('_MI_WGSIMPLEACC_INDEX_ASSETSPIE', 'Index Assets Pie Chart Period');
\define('_MI_WGSIMPLEACC_INDEX_ASSETSPIE_DESC', 'Show assets pie chart with amounts of current period on index page');
\define('_MI_WGSIMPLEACC_INDEX_ASSETSPIETOTAL', 'Index Assets Pie Chart Totals');
\define('_MI_WGSIMPLEACC_INDEX_ASSETSPIETOTAL_DESC', 'Show assets pie chart with total amounts on index page');
\define('_MI_WGSIMPLEACC_INDEX_TRAINEXSUMS', 'Index Transaction Sums Period');
\define('_MI_WGSIMPLEACC_INDEX_TRAINEXSUMS_DESC', 'Show transaction sums income/expenses with amounts of current period on index page');
\define('_MI_WGSIMPLEACC_INDEX_TRAINEXPIE', 'Index Transaction Pie Chart Period');
\define('_MI_WGSIMPLEACC_INDEX_TRAINEXPIE_DESC', 'Show transaction pie chart with amounts of current period on index page');
\define('_MI_WGSIMPLEACC_OTPL_SENDER', 'Default sender for output');
\define('_MI_WGSIMPLEACC_OTPL_SENDER_DESC', 'Default sender which should be used for output templates');
\define('_MI_WGSIMPLEACC_SHOWBCRUMBS', 'Show breadcrumb navigation');
\define('_MI_WGSIMPLEACC_SHOWBCRUMBS_DESC', "Breadcrumb navigation displays the current page's context within the site structure.");
\define('_MI_WGSIMPLEACC_MNAMEBCRUMBS', 'Module name in breadcrumb');
\define('_MI_WGSIMPLEACC_MNAMEBCRUMBS_DESC', 'You can define the module name in breadcrumb here. If module name should be not shown then keep it blank.');
\define('_MI_WGSIMPLEACC_SHOWCOPYRIGHT', 'Show copyright');
\define('_MI_WGSIMPLEACC_SHOWCOPYRIGHT_DESC', 'You can remove the copyright from the wgSimpleAcc, but a backlinks to www.wedega.com is expected, anywhere on your site');
// Global notifications
\define('_MI_WGSIMPLEACC_NOTIFY_GLOBAL', 'Global notification');
\define('_MI_WGSIMPLEACC_NOTIFY_GLOBAL_NEW', 'Any new item');
\define('_MI_WGSIMPLEACC_NOTIFY_GLOBAL_NEW_CAPTION', 'Notify me about any new item');
\define('_MI_WGSIMPLEACC_NOTIFY_GLOBAL_NEW_SUBJECT', 'Notification about new item');
\define('_MI_WGSIMPLEACC_NOTIFY_GLOBAL_MODIFY', 'Any modified item');
\define('_MI_WGSIMPLEACC_NOTIFY_GLOBAL_MODIFY_CAPTION', 'Notify me about any item modification');
\define('_MI_WGSIMPLEACC_NOTIFY_GLOBAL_MODIFY_SUBJECT', 'Notification about modification');
\define('_MI_WGSIMPLEACC_NOTIFY_GLOBAL_DELETE', 'Any deleted item');
\define('_MI_WGSIMPLEACC_NOTIFY_GLOBAL_DELETE_CAPTION', 'Notify me about any deleted item');
\define('_MI_WGSIMPLEACC_NOTIFY_GLOBAL_DELETE_SUBJECT', 'Notification about deleted item');
\define('_MI_WGSIMPLEACC_NOTIFY_GLOBAL_APPROVE', 'Any item to approve');
\define('_MI_WGSIMPLEACC_NOTIFY_GLOBAL_APPROVE_CAPTION', 'Notify me about any item waiting for approvement');
\define('_MI_WGSIMPLEACC_NOTIFY_GLOBAL_APPROVE_SUBJECT', 'Notification about item waiting for approvement');
\define('_MI_WGSIMPLEACC_NOTIFY_GLOBAL_COMMENT', 'Any comments');
\define('_MI_WGSIMPLEACC_NOTIFY_GLOBAL_COMMENT_CAPTION', 'Notify me about any comment');
\define('_MI_WGSIMPLEACC_NOTIFY_GLOBAL_COMMENT_SUBJECT', 'Notification about any comment');
// Transaction notifications
\define('_MI_WGSIMPLEACC_NOTIFY_TRANSACTION', 'Transaction notification');
\define('_MI_WGSIMPLEACC_NOTIFY_TRANSACTION_MODIFY', 'Transaction modification');
\define('_MI_WGSIMPLEACC_NOTIFY_TRANSACTION_MODIFY_CAPTION', 'Notify me about modification of this transaction ');
\define('_MI_WGSIMPLEACC_NOTIFY_TRANSACTION_MODIFY_SUBJECT', 'Notification about transaction modification');
\define('_MI_WGSIMPLEACC_NOTIFY_TRANSACTION_DELETE', 'Transaction deleted');
\define('_MI_WGSIMPLEACC_NOTIFY_TRANSACTION_DELETE_CAPTION', 'Notify me about deleting this transactions');
\define('_MI_WGSIMPLEACC_NOTIFY_TRANSACTION_DELETE_SUBJECT', 'Notification deleted transaction');
\define('_MI_WGSIMPLEACC_NOTIFY_TRANSACTION_COMMENT', 'Transaction comment');
\define('_MI_WGSIMPLEACC_NOTIFY_TRANSACTION_COMMENT_CAPTION', 'Notify me about comments for transaction');
\define('_MI_WGSIMPLEACC_NOTIFY_TRANSACTION_COMMENT_SUBJECT', 'Notification about comments for transaction');
// ---------------- End ----------------
//1.3.2
\define('_MI_WGFILEMANAGER_SHOW_STARTMIN_NAV', 'Show Startmin navigation');
\define('_MI_WGFILEMANAGER_SHOW_STARTMIN_NAV_DESC', "Define whether Startmin navigation should be shown");
\define('_MI_WGFILEMANAGER_SHOW_STARTMIN_NAV_LEFT', 'Show Startmin navigation on left side');
\define('_MI_WGFILEMANAGER_SHOW_STARTMIN_NAV_NONE', 'Do not show it, I use another block instead');
// Blocks
\define('_MI_WGSIMPLEACC_STARTMIN_BLOCK', 'Block Startmin Navigation');
\define('_MI_WGSIMPLEACC_STARTMIN_BLOCK_DESC', 'Block for displaying startmin navigation menu');
