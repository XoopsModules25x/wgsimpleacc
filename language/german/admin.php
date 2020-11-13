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
\define('_AM_WGSIMPLEACC_STATISTICS', 'Statistiken');
// There are
\define('_AM_WGSIMPLEACC_THEREARE_ACCOUNTS', "Es gibt <span class='bold'>%s</span> Konten in der Datenbank");
\define('_AM_WGSIMPLEACC_THEREARE_TRANSACTIONS', "Es gibt <span class='bold'>%s</span> Transaktionen in der Datenbank");
\define('_AM_WGSIMPLEACC_THEREARE_ALLOCATIONS', "Es gibt <span class='bold'>%s</span> Zuordnungen in der Datenbank");
\define('_AM_WGSIMPLEACC_THEREARE_ASSETS', "Es gibt <span class='bold'>%s</span> Vermögenswerte in der Datenbank");
\define('_AM_WGSIMPLEACC_THEREARE_CURRENCIES', "Es gibt <span class='bold'>%s</span> Währungen in der Datenbank");
\define('_AM_WGSIMPLEACC_THEREARE_TAXES', "Es gibt <span class='bold'>%s</span> Steuerarten in der Datenbank");
\define('_AM_WGSIMPLEACC_THEREARE_FILES', "Es gibt <span class='bold'>%s</span> Dateien in der Datenbank");
\define('_AM_WGSIMPLEACC_THEREARE_BALANCES', "Es gibt <span class='bold'>%s</span> Abschlüsse in der Datenbank");
\define('_AM_WGSIMPLEACC_THEREARE_TRATEMPLATES', "Es gibt <span class='bold'>%s</span> Transaktionsvorlagen in der Datenbank");
\define('_AM_WGSIMPLEACC_THEREARE_OUTTEMPLATES', "Es gibt <span class='bold'>%s</span> Ausgabevorlagen in der Datenbank");
// ---------------- Admin Files ----------------
// Buttons
\define('_AM_WGSIMPLEACC_ADD_ACCOUNT', 'Neues Konto hinzufügen');
\define('_AM_WGSIMPLEACC_ADD_TRANSACTION', 'Neue Transaktion hinzufügen');
\define('_AM_WGSIMPLEACC_ADD_ALLOCATION', 'Neue Zuordnung hinzufügen');
\define('_AM_WGSIMPLEACC_ADD_ASSET', 'Neuen Vermögenswert hinzufügen');
\define('_AM_WGSIMPLEACC_ADD_CURRENCY', 'Neue Währung hinzufügen');
\define('_AM_WGSIMPLEACC_ADD_TAX', 'Neue Steuerart hinzufügen');
\define('_AM_WGSIMPLEACC_ADD_FILE', 'Neue Datei hinzufügen');
\define('_AM_WGSIMPLEACC_ADD_BALANCE', 'Neuen Abschluss hinzufügen');
\define('_AM_WGSIMPLEACC_ADD_TRATEMPLATE', 'Neue Transaktionsvorlage hinzufügen');
\define('_AM_WGSIMPLEACC_ADD_OUTTEMPLATE', 'Neue Ausgabevorlage hinzufügen');
// Lists
\define('_AM_WGSIMPLEACC_LIST_ACCOUNTS', 'Liste der Konten');
\define('_AM_WGSIMPLEACC_LIST_TRANSACTIONS', 'Liste der Transaktionen');
\define('_AM_WGSIMPLEACC_LIST_ALLOCATIONS', 'Liste der Zuordnungen');
\define('_AM_WGSIMPLEACC_LIST_ASSETS', 'Liste der Vermögenswerte');
\define('_AM_WGSIMPLEACC_LIST_CURRENCIES', 'Liste der Währungen');
\define('_AM_WGSIMPLEACC_LIST_TAXES', 'Liste der Steuerarten');
\define('_AM_WGSIMPLEACC_LIST_FILES', 'Liste der Dateien');
\define('_AM_WGSIMPLEACC_LIST_BALANCES', 'Liste der Abschlüsse');
\define('_AM_WGSIMPLEACC_LIST_TRATEMPLATES', 'Liste der Transaktionsvorlagen');
\define('_AM_WGSIMPLEACC_LIST_OUTTEMPLATES', 'Liste der Ausgabevorlagen');
// ---------------- Admin Classes ----------------
// Konto add/edit
\define('_AM_WGSIMPLEACC_ACCOUNT_ADD', 'Konto hinzufügen');
\define('_AM_WGSIMPLEACC_ACCOUNT_EDIT', 'Konto bearbeiten');
// Allocation add/edit
\define('_AM_WGSIMPLEACC_ALLOCATION_ADD', 'Zuordnung hinzufügen');
\define('_AM_WGSIMPLEACC_ALLOCATION_EDIT', 'Zuordnung bearbeiten');
// Asset add/edit
\define('_AM_WGSIMPLEACC_ASSET_ADD', 'Vermögenswert hinzufügen');
\define('_AM_WGSIMPLEACC_ASSET_EDIT', 'Vermögenswert bearbeiten');
// Currency add/edit
\define('_AM_WGSIMPLEACC_CURRENCY_ADD', 'Währung hinzufügen');
\define('_AM_WGSIMPLEACC_CURRENCY_EDIT', 'Währung bearbeiten');
// Elements of Currency
\define('_AM_WGSIMPLEACC_CURRENCY_ID', 'Id');
\define('_AM_WGSIMPLEACC_CURRENCY_SYMBOL', 'Symbol');
\define('_AM_WGSIMPLEACC_CURRENCY_CODE', 'Code');
\define('_AM_WGSIMPLEACC_CURRENCY_NAME', 'Name');
\define('_AM_WGSIMPLEACC_CURRENCY_PRIMARY', 'Primär');
\define('_AM_WGSIMPLEACC_CURRENCY_ONLINE', 'Online');
// Tax add/edit
\define('_AM_WGSIMPLEACC_TAX_ADD', 'Steuerart hinzufügen');
\define('_AM_WGSIMPLEACC_TAX_EDIT', 'Steuerart bearbeiten');
// Elements of Tax
\define('_AM_WGSIMPLEACC_TAX_ID', 'Id');
\define('_AM_WGSIMPLEACC_TAX_NAME', 'Name');
\define('_AM_WGSIMPLEACC_TAX_RATE', 'Rate');
\define('_AM_WGSIMPLEACC_TAX_ONLINE', 'Online');
\define('_AM_WGSIMPLEACC_TAX_PRIMARY', 'Primär');
// Balance add/edit
\define('_AM_WGSIMPLEACC_BALANCE_ADD', 'Abschluss hinzufügen');
\define('_AM_WGSIMPLEACC_BALANCE_EDIT', 'Abschluss bearbeiten');
// Template add/edit
\define('_AM_WGSIMPLEACC_TRATEMPLATE_ADD', 'Vorlage hinzufügen');
\define('_AM_WGSIMPLEACC_TRATEMPLATE_EDIT', 'Vorlage bearbeiten');
// Template add/edit
\define('_AM_WGSIMPLEACC_OUTTEMPLATE_ADD', 'Vorlage hinzufügen');
\define('_AM_WGSIMPLEACC_OUTTEMPLATE_EDIT', 'Vorlage bearbeiten');
// Status
\define('_AM_WGSIMPLEACC_STATUS_NONE', 'Kein Status');
\define('_AM_WGSIMPLEACC_STATUS_OFFLINE', 'Offline');
\define('_AM_WGSIMPLEACC_STATUS_SUBMITTED', 'Eingesendet');
\define('_AM_WGSIMPLEACC_STATUS_APPROVED', 'Bestätigt');
\define('_AM_WGSIMPLEACC_STATUS_BROKEN', 'Fehlerhaft');
\define('_AM_WGSIMPLEACC_STATUS_CREATED', 'Erstellt');
\define('_AM_WGSIMPLEACC_STATUS_LOCKED', 'Gesperrt');
// ---------------- Admin Permissions ----------------
// Permissions
\define('_AM_WGSIMPLEACC_NO_PERMISSIONS_SET', 'Keine Berechtigung gesetzt');
\define('_AM_WGSIMPLEACC_PERMISSIONS_GLOBAL', 'Globale Berechtigungen');
\define('_AM_WGSIMPLEACC_PERMISSIONS_GLOBAL_DESC', 'Setzt die Berechtigungen <br>- global (für alle) oder <br>- für Transaktionen, Vermögenswerte, Zuordnungen und Konten separat');
\define('_AM_WGSIMPLEACC_PERMISSIONS_GLOBAL_VIEW', 'Globale Berechtigungen zum Ansehen');
\define('_AM_WGSIMPLEACC_PERMISSIONS_GLOBAL_SUBMIT', 'Globale Berechtigungen zum Einsenden');
\define('_AM_WGSIMPLEACC_PERMISSIONS_GLOBAL_APPROVE', 'Globale Berechtigungen zum Bestätigen');
\define('_AM_WGSIMPLEACC_PERMISSIONS_TRANSACTION_SUBMIT', 'Berechtigungen zum Einsenden von Transaktionen');
\define('_AM_WGSIMPLEACC_PERMISSIONS_TRANSACTION_APPROVE', 'Berechtigungen zum Bestätigen von Transaktionen');
\define('_AM_WGSIMPLEACC_PERMISSIONS_TRANSACTION_VIEW', 'Berechtigungen zum Ansehen der Transaktionen');
\define('_AM_WGSIMPLEACC_PERMISSIONS_ALLOCATION_SUBMIT', 'Berechtigungen zum Einsenden einer Zuordnung');
\define('_AM_WGSIMPLEACC_PERMISSIONS_ALLOCATION_VIEW', 'Berechtigungen zum Ansehen der Zuordnungen');
\define('_AM_WGSIMPLEACC_PERMISSIONS_ASSET_SUBMIT', 'Berechtigungen zum Einsenden von eines Vermögenswertes');
\define('_AM_WGSIMPLEACC_PERMISSIONS_ASSET_VIEW', 'Berechtigungen zum Ansehen der Vermögenswerten');
\define('_AM_WGSIMPLEACC_PERMISSIONS_ACCOUNT_SUBMIT', 'Berechtigungen zum Einsenden von eines Kontos');
\define('_AM_WGSIMPLEACC_PERMISSIONS_ACCOUNT_VIEW', 'Berechtigungen zum Ansehen der Konten');
\define('_AM_WGSIMPLEACC_PERMISSIONS_BALANCE_CREATE', 'Berechtigungen zum Erstellen von eines Abschlüsses');
\define('_AM_WGSIMPLEACC_PERMISSIONS_BALANCE_VIEW', 'Berechtigungen zum Ansehen der Abschlüssen');
\define('_AM_WGSIMPLEACC_PERMISSIONS_TRATEMPLATE_SUBMIT', 'Berechtigungen zum Erstellen von Transaktionensvorlagen');
\define('_AM_WGSIMPLEACC_PERMISSIONS_TRATEMPLATE_VIEW', 'Berechtigungen zum Ansehen der Transaktionensvorlagen');
\define('_AM_WGSIMPLEACC_PERMISSIONS_OUTTEMPLATE_SUBMIT', 'Berechtigungen zum Erstellen von Ausgabevorlagen');
\define('_AM_WGSIMPLEACC_PERMISSIONS_OUTTEMPLATE_VIEW', 'Berechtigungen zum Ansehen der Ausgabevorlagen');
// ---------------- Admin Others ----------------
\define('_AM_WGSIMPLEACC_ABOUT_MAKE_DONATION', 'Senden');
\define('_AM_WGSIMPLEACC_SUPPORT_FORUM', 'Support Forum');
\define('_AM_WGSIMPLEACC_DONATION_AMOUNT', 'Spendenbetrag Amount');
\define('_AM_WGSIMPLEACC_MAINTAINEDBY', ' wird unterstützt von ');
\define('_AM_WGSIMPLEACC_ERROR_NO_WGPHPOFFICE', "Dieses Modul benötigt das Modul 'wgPhpOffice' für die Ausgabe als MS-Excel-Datei. Bitte installieren!");
// ---------------- End ----------------
