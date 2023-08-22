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
require_once __DIR__ . '/main.php';

// ---------------- Admin Index ----------------
\define('_AM_WGSIMPLEACC_STATISTICS', 'Statistiken');
// There are
\define('_AM_WGSIMPLEACC_THEREARE_ACCOUNTS', "Es gibt <span class='bold'>%s</span> Konten in der Datenbank");
\define('_AM_WGSIMPLEACC_THEREARE_TRANSACTIONS', "Es gibt <span class='bold'>%s</span> Transaktionen in der Datenbank");
\define('_AM_WGSIMPLEACC_THEREARE_TRAHISTORIES', "Es gibt <span class='bold'>%s</span> historische Transaktionen in der Datenbank");
\define('_AM_WGSIMPLEACC_THEREARE_ALLOCATIONS', "Es gibt <span class='bold'>%s</span> Zuordnungen in der Datenbank");
\define('_AM_WGSIMPLEACC_THEREARE_ASSETS', "Es gibt <span class='bold'>%s</span> Vermögenswerte in der Datenbank");
\define('_AM_WGSIMPLEACC_THEREARE_CURRENCIES', "Es gibt <span class='bold'>%s</span> Währungen in der Datenbank");
\define('_AM_WGSIMPLEACC_THEREARE_TAXES', "Es gibt <span class='bold'>%s</span> Steuerarten in der Datenbank");
\define('_AM_WGSIMPLEACC_THEREARE_FILES', "Es gibt <span class='bold'>%s</span> Dateien in der Datenbank");
\define('_AM_WGSIMPLEACC_THEREARE_FILHISTORIES', "Es gibt <span class='bold'>%s</span> historische Dateien in der Datenbank");
\define('_AM_WGSIMPLEACC_THEREARE_BALANCES', "Es gibt <span class='bold'>%s</span> Abschlüsse in der Datenbank");
\define('_AM_WGSIMPLEACC_THEREARE_TRATEMPLATES', "Es gibt <span class='bold'>%s</span> Transaktionsvorlagen in der Datenbank");
\define('_AM_WGSIMPLEACC_THEREARE_OUTTEMPLATES', "Es gibt <span class='bold'>%s</span> Ausgabevorlagen in der Datenbank");
\define('_AM_WGSIMPLEACC_THEREARE_CLIENTS', "Es gibt <span class='bold'>%s</span> Klienten in der Datenbank");
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
\define('_AM_WGSIMPLEACC_ADD_CLIENT', 'Neuen Klienten hinzufügen');
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
\define('_AM_WGSIMPLEACC_LIST_CLIENTS', 'Liste der Klienten');
// ---------------- Admin Classes ----------------
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
// Caption of Transaction histories
\define('_AM_WGSIMPLEACC_TRANSACTION_HISTID', 'Historie Id');
\define('_AM_WGSIMPLEACC_TRANSACTION_HISTTYPE', 'Historie Typ');
\define('_AM_WGSIMPLEACC_TRANSACTION_HISTDATE', 'Historie Datum');
\define('_AM_WGSIMPLEACC_TRANSACTION_HISTSUBMITTER', 'Historie Einsender');
// Caption of Transaction histories
\define('_AM_WGSIMPLEACC_FILES_HISTID', 'Historie Id');
\define('_AM_WGSIMPLEACC_FILES_HISTTYPE', 'Historie Typ');
\define('_AM_WGSIMPLEACC_FILES_HISTDATE', 'Historie Datum');
\define('_AM_WGSIMPLEACC_FILES_HISTSUBMITTER', 'Historie Einsender');
// ---------------- Admin Permissions ----------------
// Permissions
\define('_AM_WGSIMPLEACC_NO_PERMISSIONS_SET', 'Keine Berechtigung gesetzt');
\define('_AM_WGSIMPLEACC_PERMISSIONS_GLOBAL', 'Globale Berechtigungen');
\define('_AM_WGSIMPLEACC_PERMISSIONS_GLOBAL_DESC', 'Setzt die Berechtigungen <br>- global (für alle) oder <br>- für Transaktionen, Vermögenswerte, Zuordnungen und Konten separat');
\define('_AM_WGSIMPLEACC_PERMISSIONS_GLOBAL_VIEW', 'Globale Berechtigungen zum Ansehen');
\define('_AM_WGSIMPLEACC_PERMISSIONS_GLOBAL_SUBMIT', 'Globale Berechtigungen zum Einsenden (nur für Webmaster empfohlen)');
\define('_AM_WGSIMPLEACC_PERMISSIONS_GLOBAL_APPROVE', 'Globale Berechtigungen zum Bestätigen (nur für Webmaster empfohlen)');
\define('_AM_WGSIMPLEACC_PERMISSIONS_TRANSACTION_SUBMIT', 'Berechtigungen zum Einsenden von Transaktionen');
\define('_AM_WGSIMPLEACC_PERMISSIONS_TRANSACTION_APPROVE', 'Berechtigungen zum Bestätigen von Transaktionen');
\define('_AM_WGSIMPLEACC_PERMISSIONS_TRANSACTION_VIEW', 'Berechtigungen zum Ansehen der Transaktionen');
\define('_AM_WGSIMPLEACC_PERMISSIONS_ALLOCATION_SUBMIT', 'Berechtigungen zum Einsenden einer Zuordnung');
\define('_AM_WGSIMPLEACC_PERMISSIONS_ALLOCATION_VIEW', 'Berechtigungen zum Ansehen der Zuordnungen');
\define('_AM_WGSIMPLEACC_PERMISSIONS_ASSET_SUBMIT', 'Berechtigungen zum Einsenden von eines Vermögenswertes');
\define('_AM_WGSIMPLEACC_PERMISSIONS_ASSET_VIEW', 'Berechtigungen zum Ansehen der Vermögenswerten');
\define('_AM_WGSIMPLEACC_PERMISSIONS_ACCOUNT_SUBMIT', 'Berechtigungen zum Einsenden von eines Kontos');
\define('_AM_WGSIMPLEACC_PERMISSIONS_ACCOUNT_VIEW', 'Berechtigungen zum Ansehen der Konten');
\define('_AM_WGSIMPLEACC_PERMISSIONS_BALANCE_SUBMIT', 'Berechtigungen zum Erstellen von eines Abschlüsses');
\define('_AM_WGSIMPLEACC_PERMISSIONS_BALANCE_VIEW', 'Berechtigungen zum Ansehen der Abschlüssen');
\define('_AM_WGSIMPLEACC_PERMISSIONS_TRATEMPLATE_SUBMIT', 'Berechtigungen zum Erstellen von Transaktionensvorlagen');
\define('_AM_WGSIMPLEACC_PERMISSIONS_TRATEMPLATE_VIEW', 'Berechtigungen zum Ansehen der Transaktionensvorlagen');
\define('_AM_WGSIMPLEACC_PERMISSIONS_OUTTEMPLATE_SUBMIT', 'Berechtigungen zum Erstellen von Ausgabevorlagen');
\define('_AM_WGSIMPLEACC_PERMISSIONS_OUTTEMPLATE_VIEW', 'Berechtigungen zum Ansehen der Ausgabevorlagen');
\define('_AM_WGSIMPLEACC_PERMISSIONS_CLIENT_ADMIN', 'Berechtigungen zum Verwalten von Klienten');
\define('_AM_WGSIMPLEACC_PERMISSIONS_CLIENT_SUBMIT', 'Berechtigungen zum Einsenden von Klienten');
\define('_AM_WGSIMPLEACC_PERMISSIONS_CLIENT_VIEW', 'Berechtigungen zum Ansehen der Klienten');
\define('_AM_WGSIMPLEACC_PERMISSIONS_FILEDIR_ADMIN', 'Berechtigungen zum Verwalten der Dateien im Dateiverzeichnis');
\define('_AM_WGSIMPLEACC_PERMISSIONS_FILEDIR_SUBMIT', 'Berechtigungen zum Hochladen von Dateien in das Dateiverzeichnis');
\define('_AM_WGSIMPLEACC_PERMISSIONS_FILEDIR_VIEW', 'Berechtigungen zum Ansehen der Dateien im Dateiverzeichnis');
// ---------------- Admin Others ----------------
\define('_AM_WGSIMPLEACC_ABOUT_MAKE_DONATION', 'Senden');
\define('_AM_WGSIMPLEACC_SUPPORT_FORUM', 'Support Forum');
\define('_AM_WGSIMPLEACC_DONATION_AMOUNT', 'Spendenbetrag Amount');
\define('_AM_WGSIMPLEACC_MAINTAINEDBY', ' wird unterstützt von ');
// ---------------- End ----------------
