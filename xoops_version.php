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

//
require_once __DIR__ . '/preloads/autoloader.php';

$moduleDirName      = \basename(__DIR__);
$moduleDirNameUpper = \mb_strtoupper($moduleDirName);
// ------------------- Informations ------------------- //
$modversion = [
	'name'                => \_MI_WGSIMPLEACC_NAME,
	'version'             => 1.20,
	'description'         => \_MI_WGSIMPLEACC_DESC,
	'author'              => 'Goffy - XOOPS Development Team',
	'author_mail'         => 'webmaster@wedega.com',
	'author_website_url'  => 'https://xoops.wedega.com',
	'author_website_name' => 'XOOPS on Wedega',
	'credits'             => 'Goffy - XOOPS Development Team',
	'license'             => 'GPL 2.0 or later',
	'license_url'         => 'http://www.gnu.org/licenses/gpl-3.0.en.html',
	'help'                => 'page=help',
	'release_info'        => 'release_info',
	'release_file'        => \XOOPS_URL . '/modules/wgsimpleacc/docs/release_info file',
	'release_date'        => '2021/01/26',
	'manual'              => 'link to manual file',
	'manual_file'         => \XOOPS_URL . '/modules/wgsimpleacc/docs/install.txt',
	'min_php'             => '7.3',
	'min_xoops'           => '2.5.10',
	'min_admin'           => '1.2',
	'min_db'              => ['mysql' => '5.5', 'mysqli' => '5.5'],
	'image'               => 'assets/images/logoModule.png',
	'dirname'             => \basename(__DIR__),
	'dirmoduleadmin'      => 'Frameworks/moduleclasses/moduleadmin',
	'sysicons16'          => '../../Frameworks/moduleclasses/icons/16',
	'sysicons32'          => '../../Frameworks/moduleclasses/icons/32',
	'modicons16'          => 'assets/icons/16',
	'modicons32'          => 'assets/icons/32',
	'demo_site_url'       => 'https://xoops.org',
	'demo_site_name'      => 'XOOPS Demo Site',
	'support_url'         => 'https://xoops.org/modules/newbb',
	'support_name'        => 'Support Forum',
	'module_website_url'  => 'www.xoops.org',
	'module_website_name' => 'XOOPS Project',
	'release'             => '01/26/2021',
	'module_status'       => 'RC 1',
	'system_menu'         => 1,
	'hasAdmin'            => 1,
	'hasMain'             => 1,
	'adminindex'          => 'admin/index.php',
	'adminmenu'           => 'admin/menu.php',
	'onInstall'           => 'include/install.php',
	'onUninstall'         => 'include/uninstall.php',
	'onUpdate'            => 'include/update.php',
];
// ------------------- Templates ------------------- //
$modversion['templates'] = [
	// Admin templates
	['file' => 'wgsimpleacc_admin_about.tpl', 'description' => '', 'type' => 'admin'],
    ['file' => 'wgsimpleacc_admin_accounts.tpl', 'description' => '', 'type' => 'admin'],
    ['file' => 'wgsimpleacc_admin_allocations.tpl', 'description' => '', 'type' => 'admin'],
    ['file' => 'wgsimpleacc_admin_assets.tpl', 'description' => '', 'type' => 'admin'],
    ['file' => 'wgsimpleacc_admin_balances.tpl', 'description' => '', 'type' => 'admin'],
    ['file' => 'wgsimpleacc_admin_currencies.tpl', 'description' => '', 'type' => 'admin'],
    ['file' => 'wgsimpleacc_admin_files.tpl', 'description' => '', 'type' => 'admin'],
    ['file' => 'wgsimpleacc_admin_footer.tpl', 'description' => '', 'type' => 'admin'],
	['file' => 'wgsimpleacc_admin_header.tpl', 'description' => '', 'type' => 'admin'],
	['file' => 'wgsimpleacc_admin_index.tpl', 'description' => '', 'type' => 'admin'],
    ['file' => 'wgsimpleacc_admin_outtemplates.tpl', 'description' => '', 'type' => 'admin'],
    ['file' => 'wgsimpleacc_admin_permissions.tpl', 'description' => '', 'type' => 'admin'],
	['file' => 'wgsimpleacc_admin_taxes.tpl', 'description' => '', 'type' => 'admin'],
    ['file' => 'wgsimpleacc_admin_transactions.tpl', 'description' => '', 'type' => 'admin'],
    ['file' => 'wgsimpleacc_admin_trahistories.tpl', 'description' => '', 'type' => 'admin'],
    ['file' => 'wgsimpleacc_admin_tratemplates.tpl', 'description' => '', 'type' => 'admin'],
	// User templates
    ['file' => 'wgsimpleacc_main_startmin.tpl', 'description' => ''],
    ['file' => 'wgsimpleacc_accounts.tpl', 'description' => ''],
    ['file' => 'wgsimpleacc_allocations.tpl', 'description' => ''],
    ['file' => 'wgsimpleacc_assets.tpl', 'description' => ''],
	['file' => 'wgsimpleacc_assets_item.tpl', 'description' => ''],
    ['file' => 'wgsimpleacc_balances.tpl', 'description' => ''],
    ['file' => 'wgsimpleacc_breadcrumbs.tpl', 'description' => ''],  
    ['file' => 'wgsimpleacc_chart_assets_pie.tpl', 'description' => ''],
    ['file' => 'wgsimpleacc_chart_assets_line.tpl', 'description' => ''],
    ['file' => 'wgsimpleacc_chart_accounts_line.tpl', 'description' => ''],
    ['file' => 'wgsimpleacc_chart_balances_line.tpl', 'description' => ''],
    ['file' => 'wgsimpleacc_chart_transactions_hbar.tpl', 'description' => ''],
	['file' => 'wgsimpleacc_files.tpl', 'description' => ''],
	['file' => 'wgsimpleacc_files_item.tpl', 'description' => ''],
    ['file' => 'wgsimpleacc_footer.tpl', 'description' => ''],
    ['file' => 'wgsimpleacc_header.tpl', 'description' => ''],
    ['file' => 'wgsimpleacc_index.tpl', 'description' => ''],
    ['file' => 'wgsimpleacc_navbar.tpl', 'description' => ''],
    ['file' => 'wgsimpleacc_outputs.tpl', 'description' => ''],
    ['file' => 'wgsimpleacc_outtemplates.tpl', 'description' => ''],
    ['file' => 'wgsimpleacc_outtemplates_list.tpl', 'description' => ''],
    ['file' => 'wgsimpleacc_statistics.tpl', 'description' => ''],
    ['file' => 'wgsimpleacc_tratemplates.tpl', 'description' => ''],
	['file' => 'wgsimpleacc_tratemplates_list.tpl', 'description' => ''],
	['file' => 'wgsimpleacc_transactions.tpl', 'description' => ''],
	['file' => 'wgsimpleacc_transactions_list.tpl', 'description' => ''],
    ['file' => 'wgsimpleacc_transactions_hist.tpl', 'description' => ''],
	['file' => 'wgsimpleacc_transactions_item.tpl', 'description' => ''],
    ['file' => 'wgsimpleacc_transactions_pdf.tpl', 'description' => ''],
    ['file' => 'wgsimpleacc_transactions_print.tpl', 'description' => ''],
];
// ------------------- Mysql ------------------- //
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';
// Tables
$modversion['tables'] = [
	'wgsimpleacc_accounts',
	'wgsimpleacc_transactions',
    'wgsimpleacc_trahistories',
	'wgsimpleacc_allocations',
	'wgsimpleacc_assets',
	'wgsimpleacc_currencies',
	'wgsimpleacc_taxes',
	'wgsimpleacc_files',
    'wgsimpleacc_balances',
    'wgsimpleacc_outtemplates',
    'wgsimpleacc_tratemplates',
];
// ------------------- Search ------------------- //
$modversion['hasSearch'] = 1;
$modversion['search'] = [
	'file' => 'include/search.inc.php',
	'func' => 'wgsimpleacc_search',
];
// ------------------- Comments ------------------- //
$modversion['hasComments'] = 1;
$modversion['comments']['pageName'] = 'transactions.php';
$modversion['comments']['itemName'] = 'tra_id';
// Comment callback functions
$modversion['comments']['callbackFile'] = 'include/comment_functions.php';
$modversion['comments']['callback'] = [
	'approve' => 'wgsimpleaccCommentsApprove',
	'update'  => 'wgsimpleaccCommentsUpdate',
];
// ------------------- Config ------------------- //
// Editor Admin
\xoops_load('xoopseditorhandler');
$editorHandler = XoopsEditorHandler::getInstance();
$modversion['config'][] = [
	'name'        => 'editor_admin',
	'title'       => '_MI_WGSIMPLEACC_EDITOR_ADMIN',
	'description' => '_MI_WGSIMPLEACC_EDITOR_ADMIN_DESC',
	'formtype'    => 'select',
	'valuetype'   => 'text',
	'default'     => 'dhtml',
	'options'     => \array_flip($editorHandler->getList()),
];
// Editor User
\xoops_load('xoopseditorhandler');
$editorHandler = XoopsEditorHandler::getInstance();
$modversion['config'][] = [
	'name'        => 'editor_user',
	'title'       => '_MI_WGSIMPLEACC_EDITOR_USER',
	'description' => '_MI_WGSIMPLEACC_EDITOR_USER_DESC',
	'formtype'    => 'select',
	'valuetype'   => 'text',
	'default'     => 'dhtml',
	'options'     => \array_flip($editorHandler->getList()),
];
// Editor : max characters admin area
$modversion['config'][] = [
	'name'        => 'editor_maxchar',
	'title'       => '_MI_WGSIMPLEACC_EDITOR_MAXCHAR',
	'description' => '_MI_WGSIMPLEACC_EDITOR_MAXCHAR_DESC',
	'formtype'    => 'textbox',
	'valuetype'   => 'int',
	'default'     => 50,
];
// Keywords
$modversion['config'][] = [
	'name'        => 'keywords',
	'title'       => '_MI_WGSIMPLEACC_KEYWORDS',
	'description' => '_MI_WGSIMPLEACC_KEYWORDS_DESC',
	'formtype'    => 'textbox',
	'valuetype'   => 'text',
	'default'     => 'wgsimpleacc, accounts, transactions, allocations, assets, currencies, taxes, files, images',
];
// create increment steps for file size
require_once __DIR__ . '/include/xoops_version.inc.php';
$iniPostMaxSize       = wgsimpleaccReturnBytes(\ini_get('post_max_size'));
$iniUploadMaxFileSize = wgsimpleaccReturnBytes(\ini_get('upload_max_filesize'));
$maxSize              = min($iniPostMaxSize, $iniUploadMaxFileSize);
if ($maxSize > 10000 * 1048576) {
	$increment = 500;
}
if ($maxSize <= 10000 * 1048576) {
	$increment = 200;
}
if ($maxSize <= 5000 * 1048576) {
	$increment = 100;
}
if ($maxSize <= 2500 * 1048576) {
	$increment = 50;
}
if ($maxSize <= 1000 * 1048576) {
	$increment = 10;
}
if ($maxSize <= 500 * 1048576) {
	$increment = 5;
}
if ($maxSize <= 100 * 1048576) {
	$increment = 2;
}
if ($maxSize <= 50 * 1048576) {
	$increment = 1;
}
if ($maxSize <= 25 * 1048576) {
	$increment = 0.5;
}
$optionMaxsize = [];
$i = $increment;
while ($i * 1048576 <= $maxSize) {
	$optionMaxsize[$i . ' ' . \_MI_WGSIMPLEACC_SIZE_MB] = $i * 1048576;
	$i += $increment;
}
// Uploads : maxsize of file
$modversion['config'][] = [
	'name'        => 'maxsize_file',
	'title'       => '_MI_WGSIMPLEACC_MAXSIZE_FILE',
	'description' => '_MI_WGSIMPLEACC_MAXSIZE_FILE_DESC',
	'formtype'    => 'select',
	'valuetype'   => 'int',
	'default'     => 3145728,
	'options'     => $optionMaxsize,
];
// Uploads : mimetypes of file
$modversion['config'][] = [
	'name'        => 'mimetypes_file',
	'title'       => '_MI_WGSIMPLEACC_MIMETYPES_FILE',
	'description' => '_MI_WGSIMPLEACC_MIMETYPES_FILE_DESC',
	'formtype'    => 'select_multi',
	'valuetype'   => 'array',
	'default'     => ['image/gif', 'image/jpeg', 'image/jpg', 'image/jpe', 'image/png', 'application/pdf', 'application/zip', 'text/comma-separated-values', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'],
	'options'     => ['gif' => 'image/gif','jpeg' => 'image/jpeg','pjpeg' => 'image/pjpeg','jpg' => 'image/jpg','jpe' => 'image/jpe', 'png' => 'image/png', 'pdf' => 'application/pdf','zip' => 'application/zip','csv' => 'text/comma-separated-values', 'txt' => 'text/plain', 'xml' => 'application/xml', 'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'],
];
$modversion['config'][] = [
    'name'        => 'maxwidth_image',
    'title'       => '_MI_WGSIMPLEACC_MAXWIDTH_IMAGE',
    'description' => '_MI_WGSIMPLEACC_MAXWIDTH_IMAGE_DESC',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => 800,
];
$modversion['config'][] = [
    'name'        => 'maxheight_image',
    'title'       => '_MI_WGSIMPLEACC_MAXHEIGHT_IMAGE',
    'description' => '_MI_WGSIMPLEACC_MAXHEIGHT_IMAGE_DESC',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => 800,
];
// Uploads : use upload app
$modversion['config'][] = [
    'name'        => 'upload_by_app',
    'title'       => '_MI_WGSIMPLEACC_UPLOAD_BY_APP',
    'description' => '_MI_WGSIMPLEACC_UPLOAD_BY_APP_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 0,
];
// Admin pager
$modversion['config'][] = [
	'name'        => 'adminpager',
	'title'       => '_MI_WGSIMPLEACC_ADMIN_PAGER',
	'description' => '_MI_WGSIMPLEACC_ADMIN_PAGER_DESC',
	'formtype'    => 'textbox',
	'valuetype'   => 'int',
	'default'     => 10,
];
// User pager
$modversion['config'][] = [
	'name'        => 'userpager',
	'title'       => '_MI_WGSIMPLEACC_USER_PAGER',
	'description' => '_MI_WGSIMPLEACC_USER_PAGER_DESC',
	'formtype'    => 'textbox',
	'valuetype'   => 'int',
	'default'     => 10,
];
// Balance : types
$modversion['config'][] = [
    'name'        => 'balance_period',
    'title'       => '_MI_WGSIMPLEACC_BALANCE_PERIOD',
    'description' => '_MI_WGSIMPLEACC_BALANCE_PERIOD_DESC',
    'formtype'    => 'select',
    'valuetype'   => 'int',
    'default'     => 1,
    'options'     => ['_MI_WGSIMPLEACC_BALANCE_FILTER_PYEARLY' => 1, '_MI_WGSIMPLEACC_BALANCE_FILTER_PMONTHLY' => 2],
];
// Balance : from
$modversion['config'][] = [
    'name'        => 'balance_period_from',
    'title'       => '_MI_WGSIMPLEACC_BALANCE_PERIOD_FROM',
    'description' => '_MI_WGSIMPLEACC_BALANCE_PERIOD_FROM_DESC',
    'formtype'    => 'select',
    'valuetype'   => 'int',
    'default'     => 1,
    'options'     => ['_MI_WGSIMPLEACC_JANUARY' => 1, '_MI_WGSIMPLEACC_FEBRUARY' => 2, '_MI_WGSIMPLEACC_MARCH' => 3, '_MI_WGSIMPLEACC_APRIL' => 4, '_MI_WGSIMPLEACC_MAY' => 5, '_MI_WGSIMPLEACC_JUNE' => 6, '_MI_WGSIMPLEACC_JULY' => 7, '_MI_WGSIMPLEACC_AUGUST' => 8, '_MI_WGSIMPLEACC_SEPTEMBER' => 9, '_MI_WGSIMPLEACC_OCTOBER' => 10, '_MI_WGSIMPLEACC_NOVEMBER' => 11, '_MI_WGSIMPLEACC_DECEMBER' => 12],
];
// Balance : to
$modversion['config'][] = [
    'name'        => 'balance_period_to',
    'title'       => '_MI_WGSIMPLEACC_BALANCE_PERIOD_TO',
    'description' => '_MI_WGSIMPLEACC_BALANCE_PERIOD_FROM_DESC',
    'formtype'    => 'select',
    'valuetype'   => 'int',
    'default'     => 12,
    'options'     => ['_MI_WGSIMPLEACC_JANUARY' => 1, '_MI_WGSIMPLEACC_FEBRUARY' => 2, '_MI_WGSIMPLEACC_MARCH' => 3, '_MI_WGSIMPLEACC_APRIL' => 4, '_MI_WGSIMPLEACC_MAY' => 5, '_MI_WGSIMPLEACC_JUNE' => 6, '_MI_WGSIMPLEACC_JULY' => 7, '_MI_WGSIMPLEACC_AUGUST' => 8, '_MI_WGSIMPLEACC_SEPTEMBER' => 9, '_MI_WGSIMPLEACC_OCTOBER' => 10, '_MI_WGSIMPLEACC_NOVEMBER' => 11, '_MI_WGSIMPLEACC_DECEMBER' => 12],
];
// Comma separator
$modversion['config'][] = [
    'name'        => 'sep_comma',
    'title'       => '_MI_WGSIMPLEACC_SEP_COMMA',
    'description' => '_MI_WGSIMPLEACC_SEP_COMMA_DESC',
    'formtype'    => 'textbox',
    'valuetype'   => 'text',
    'default'     => '.',
];
// Thousands separator
$modversion['config'][] = [
    'name'        => 'sep_thousand',
    'title'       => '_MI_WGSIMPLEACC_SEP_THSD',
    'description' => '_MI_WGSIMPLEACC_SEP_THSD_DESC',
    'formtype'    => 'textbox',
    'valuetype'   => 'text',
    'default'     => ',',
];
// use currencies
$modversion['config'][] = [
    'name'        => 'use_currencies',
    'title'       => '_MI_WGSIMPLEACC_USE_CURRENCIES',
    'description' => '_MI_WGSIMPLEACC_USE_CURRENCIES_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 0,
];
// use taxes
$modversion['config'][] = [
    'name'        => 'use_taxes',
    'title'       => '_MI_WGSIMPLEACC_USE_TAXES',
    'description' => '_MI_WGSIMPLEACC_USE_TAXES_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 0,
];
// use files
$modversion['config'][] = [
    'name'        => 'use_files',
    'title'       => '_MI_WGSIMPLEACC_USE_FILES',
    'description' => '_MI_WGSIMPLEACC_USE_FILES_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 0,
];
// Default sender for output templates
$modversion['config'][] = [
    'name'        => 'otpl_sender',
    'title'       => '_MI_WGSIMPLEACC_OTPL_SENDER',
    'description' => '_MI_WGSIMPLEACC_OTPL_SENDER_DESC',
    'formtype'    => 'textarea',
    'valuetype'   => 'text',
    'default'     => 'Wedega - Webdesign Gabor<br>Goffy<br>somewhere in Austria',
];
// Advertise
$modversion['config'][] = [
	'name'        => 'advertise',
	'title'       => '_MI_WGSIMPLEACC_ADVERTISE',
	'description' => '_MI_WGSIMPLEACC_ADVERTISE_DESC',
	'formtype'    => 'textarea',
	'valuetype'   => 'text',
	'default'     => '',
];
// Show module description
$modversion['config'][] = [
    'name'        => 'index_header',
    'title'       => '_MI_WGSIMPLEACC_INDEXHEADER',
    'description' => '_MI_WGSIMPLEACC_INDEXHEADER_DESC',
    'formtype'    => 'textbox',
    'valuetype'   => 'text',
    'default'     => \_MI_WGSIMPLEACC_DESC,
];
// Show breadcrumb
$modversion['config'][] = [
    'name'        => 'show_breadcrumbs',
    'title'       => '_MI_WGSIMPLEACC_SHOWBCRUMBS',
    'description' => '_MI_WGSIMPLEACC_SHOWBCRUMBS_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1,
];
// Show copyright
$modversion['config'][] = [
    'name'        => 'show_copyright',
    'title'       => '_MI_WGSIMPLEACC_SHOWCOPYRIGHT',
    'description' => '_MI_WGSIMPLEACC_SHOWCOPYRIGHT_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1,
];
// Make Sample button visible?
$modversion['config'][] = [
	'name'        => 'displaySampleButton',
	'title'       => 'CO_' . $moduleDirNameUpper . '_' . 'SHOW_SAMPLE_BUTTON',
	'description' => 'CO_' . $moduleDirNameUpper . '_' . 'SHOW_SAMPLE_BUTTON_DESC',
	'formtype'    => 'yesno',
	'valuetype'   => 'int',
	'default'     => 1,
];
// Maintained by
$modversion['config'][] = [
	'name'        => 'maintainedby',
	'title'       => '_MI_WGSIMPLEACC_MAINTAINEDBY',
	'description' => '_MI_WGSIMPLEACC_MAINTAINEDBY_DESC',
	'formtype'    => 'textbox',
	'valuetype'   => 'text',
	'default'     => 'https://xoops.org/modules/newbb',
];
// ------------------- Notifications ------------------- //
$modversion['hasNotification'] = 1;
$modversion['notification'] = [
	'lookup_file' => 'include/notification.inc.php',
	'lookup_func' => 'wgsimpleacc_notify_iteminfo',
];
// Categories of notification
// Global Notify
$modversion['notification']['category'][] = [
	'name'           => 'global',
	'title'          => \_MI_WGSIMPLEACC_NOTIFY_GLOBAL,
	'description'    => '',
	'subscribe_from' => ['index.php', 'transactions.php'],
];
// Transaction Notify
$modversion['notification']['category'][] = [
	'name'           => 'transactions',
	'title'          => \_MI_WGSIMPLEACC_NOTIFY_TRANSACTION,
	'description'    => '',
	'subscribe_from' => 'transactions.php',
	'item_name'      => 'tra_id',
	'allow_bookmark' => 1,
];
// Global events notification
// GLOBAL_NEW Notify
$modversion['notification']['event'][] = [
	'name'          => 'global_new',
	'category'      => 'global',
	'admin_only'    => 0,
	'title'         => \_MI_WGSIMPLEACC_NOTIFY_GLOBAL_NEW,
	'caption'       => \_MI_WGSIMPLEACC_NOTIFY_GLOBAL_NEW_CAPTION,
	'description'   => '',
	'mail_template' => 'global_new_notify',
	'mail_subject'  => \_MI_WGSIMPLEACC_NOTIFY_GLOBAL_NEW_SUBJECT,
];
// GLOBAL_MODIFY Notify
$modversion['notification']['event'][] = [
	'name'          => 'global_modify',
	'category'      => 'global',
	'admin_only'    => 0,
	'title'         => \_MI_WGSIMPLEACC_NOTIFY_GLOBAL_MODIFY,
	'caption'       => \_MI_WGSIMPLEACC_NOTIFY_GLOBAL_MODIFY_CAPTION,
	'description'   => '',
	'mail_template' => 'global_modify_notify',
	'mail_subject'  => \_MI_WGSIMPLEACC_NOTIFY_GLOBAL_MODIFY_SUBJECT,
];
// GLOBAL_DELETE Notify
$modversion['notification']['event'][] = [
	'name'          => 'global_delete',
	'category'      => 'global',
	'admin_only'    => 0,
	'title'         => \_MI_WGSIMPLEACC_NOTIFY_GLOBAL_DELETE,
	'caption'       => \_MI_WGSIMPLEACC_NOTIFY_GLOBAL_DELETE_CAPTION,
	'description'   => '',
	'mail_template' => 'global_delete_notify',
	'mail_subject'  => \_MI_WGSIMPLEACC_NOTIFY_GLOBAL_DELETE_SUBJECT,
];
// GLOBAL_APPROVE Notify
$modversion['notification']['event'][] = [
	'name'          => 'global_approve',
	'category'      => 'global',
	'admin_only'    => 1,
	'title'         => \_MI_WGSIMPLEACC_NOTIFY_GLOBAL_APPROVE,
	'caption'       => \_MI_WGSIMPLEACC_NOTIFY_GLOBAL_APPROVE_CAPTION,
	'description'   => '',
	'mail_template' => 'global_approve_notify',
	'mail_subject'  => \_MI_WGSIMPLEACC_NOTIFY_GLOBAL_APPROVE_SUBJECT,
];
// GLOBAL_COMMENT Notify
$modversion['notification']['event'][] = [
	'name'          => 'global_comment',
	'category'      => 'global',
	'admin_only'    => 0,
	'title'         => \_MI_WGSIMPLEACC_NOTIFY_GLOBAL_COMMENT,
	'caption'       => \_MI_WGSIMPLEACC_NOTIFY_GLOBAL_COMMENT_CAPTION,
	'description'   => '',
	'mail_template' => 'global_comment_notify',
	'mail_subject'  => \_MI_WGSIMPLEACC_NOTIFY_GLOBAL_COMMENT_SUBJECT,
];
// Event notifications for items
// TRANSACTION_MODIFY Notify
$modversion['notification']['event'][] = [
	'name'          => 'transaction_modify',
	'category'      => 'transactions',
	'admin_only'    => 0,
	'title'         => \_MI_WGSIMPLEACC_NOTIFY_TRANSACTION_MODIFY,
	'caption'       => \_MI_WGSIMPLEACC_NOTIFY_TRANSACTION_MODIFY_CAPTION,
	'description'   => '',
	'mail_template' => 'transaction_modify_notify',
	'mail_subject'  => \_MI_WGSIMPLEACC_NOTIFY_TRANSACTION_MODIFY_SUBJECT,
];
// TRANSACTION_DELETE Notify
$modversion['notification']['event'][] = [
	'name'          => 'transaction_delete',
	'category'      => 'transactions',
	'admin_only'    => 0,
	'title'         => \_MI_WGSIMPLEACC_NOTIFY_TRANSACTION_DELETE,
	'caption'       => \_MI_WGSIMPLEACC_NOTIFY_TRANSACTION_DELETE_CAPTION,
	'description'   => '',
	'mail_template' => 'transaction_delete_notify',
	'mail_subject'  => \_MI_WGSIMPLEACC_NOTIFY_TRANSACTION_DELETE_SUBJECT,
];

