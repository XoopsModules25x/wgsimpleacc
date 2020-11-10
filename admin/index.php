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
 * @author         XOOPS Development Team - Email:<webmaster@wedega.com> - Website:<https://xoops.wedega.com>
 */


use XoopsModules\Wgsimpleacc\Common;

require_once \dirname(__DIR__) . '/preloads/autoloader.php';
require __DIR__ . '/header.php';

// Template Index
$templateMain = 'wgsimpleacc_admin_index.tpl';

// Count elements
$countTransactions = $transactionsHandler->getCount();
$countAssets = $assetsHandler->getCount();
$countFiles = $filesHandler->getCount();
$countAccounts = $accountsHandler->getCount();
$countAllocations = $allocationsHandler->getCount();
$countCurrencies = $currenciesHandler->getCount();
$countTaxes = $taxesHandler->getCount();
$countBalances = $balancesHandler->getCount();
$countTratemplates = $tratemplatesHandler->getCount();
$countOuttemplates = $outtemplatesHandler->getCount();

// InfoBox Statistics
$adminObject->addInfoBox(\_AM_WGSIMPLEACC_STATISTICS);
// Info elements
$adminObject->addInfoBoxLine(\sprintf( '<label>' . \_AM_WGSIMPLEACC_THEREARE_TRANSACTIONS . '</label>', $countTransactions));
$adminObject->addInfoBoxLine(\sprintf( '<label>' . \_AM_WGSIMPLEACC_THEREARE_ASSETS . '</label>', $countAssets));
$adminObject->addInfoBoxLine(\sprintf( '<label>' . \_AM_WGSIMPLEACC_THEREARE_FILES . '</label>', $countFiles));
$adminObject->addInfoBoxLine(\sprintf( '<label>' . \_AM_WGSIMPLEACC_THEREARE_ACCOUNTS . '</label>', $countAccounts));
$adminObject->addInfoBoxLine(\sprintf( '<label>' . \_AM_WGSIMPLEACC_THEREARE_ALLOCATIONS . '</label>', $countAllocations));
$adminObject->addInfoBoxLine(\sprintf( '<label>' . \_AM_WGSIMPLEACC_THEREARE_CURRENCIES . '</label>', $countCurrencies));
$adminObject->addInfoBoxLine(\sprintf( '<label>' . \_AM_WGSIMPLEACC_THEREARE_TAXES . '</label>', $countTaxes));
$adminObject->addInfoBoxLine(\sprintf( '<label>' . \_AM_WGSIMPLEACC_THEREARE_BALANCES . '</label>', $countBalances));
$adminObject->addInfoBoxLine(\sprintf( '<label>' . \_AM_WGSIMPLEACC_THEREARE_TRATEMPLATES . '</label>', $countTratemplates));
$adminObject->addInfoBoxLine(\sprintf( '<label>' . \_AM_WGSIMPLEACC_THEREARE_OUTTEMPLATES . '</label>', $countOuttemplates));
// Upload Folders
$configurator = new Common\Configurator();
if ($configurator->uploadFolders && \is_array($configurator->uploadFolders)) {
	foreach (\array_keys($configurator->uploadFolders) as $i) {
		$folder[] = $configurator->uploadFolders[$i];
	}
}
// Uploads Folders Created
foreach (\array_keys($folder) as $i) {
	$adminObject->addConfigBoxLine($folder[$i], 'folder');
	$adminObject->addConfigBoxLine([$folder[$i], '777'], 'chmod');
}

/*
if (!\is_dir(\XOOPS_ROOT_PATH . '/modules/wgphpoffice')) {
    $adminObject->addConfigBoxLine('<span style="color:#ff0000;"><img src="' . $pathIcon16 . '/0.png" alt="!">' . \_AM_WGSIMPLEACC_ERROR_NO_WGPHPOFFICE . '</span>', 'default');
}
$adminObject->addConfigBoxLine('wgphpoffice', 'module');
*/

// Render Index
$GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('index.php'));
// Test Data
if ($helper->getConfig('displaySampleButton')) {
	\xoops_loadLanguage('admin/modulesadmin', 'system');
	require_once \dirname(__DIR__) . '/testdata/index.php';
	$adminObject->addItemButton(\constant('CO_' . $moduleDirNameUpper . '_ADD_SAMPLEDATA'), '__DIR__ . /../../testdata/index.php?op=load', 'add');
	$adminObject->addItemButton(\constant('CO_' . $moduleDirNameUpper . '_SAVE_SAMPLEDATA'), '__DIR__ . /../../testdata/index.php?op=save', 'add');
//	$adminObject->addItemButton(\constant('CO_' . $moduleDirNameUpper . '_EXPORT_SCHEMA'), '__DIR__ . /../../testdata/index.php?op=exportschema', 'add');
	$adminObject->displayButton('left');
}
$GLOBALS['xoopsTpl']->assign('index', $adminObject->displayIndex());
// End Test Data
require __DIR__ . '/footer.php';
