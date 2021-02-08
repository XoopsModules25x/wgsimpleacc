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
\define('_MA_WGSIMPLEACC_INDEX', 'Übersicht');
\define('_MA_WGSIMPLEACC_TITLE', 'wgSimpleAcc');
\define('_MA_WGSIMPLEACC_DESC', 'wgSimpleAcc ist ein Tool für die Einnahmen-Ausgaben-Rechnung von Vereinen');
\define('_MA_WGSIMPLEACC_INDEX_DESC', 'Willkommmen auf der Startseite des neuen Modules wgSimpleAcc!');
\define('_MA_WGSIMPLEACC_NO_PDF_LIBRARY', 'Libraries TCPDF ist nicht vorhanden, bitte Hochladen in root/Frameworks');
\define('_MA_WGSIMPLEACC_NO', 'Nein');
\define('_MA_WGSIMPLEACC_DETAILS', 'Details anzeigen');
\define('_MA_WGSIMPLEACC_REFRESH', 'Aktualisieren');
\define('_MA_WGSIMPLEACC_FILTERTYPE', 'Filter');
\define('_MA_WGSIMPLEACC_SHOW_ALL', 'Alle anzeigen');
\define('_MA_WGSIMPLEACC_SHOW_CUSTOM', 'Benutzerdefinierte Auswahl anzeigen');
\define('_MA_WGSIMPLEACC_FILTERBY_YEAR', 'Jahr auswählen');
\define('_MA_WGSIMPLEACC_FILTERBY_ASSET', 'Vermögenswert auswählen');
\define('_MA_WGSIMPLEACC_FILTERBY_ALLOC', 'Zuordnung auswählen');
\define('_MA_WGSIMPLEACC_FILTERBY_ACCOUNT', 'Konto auswählen');
\define('_MA_WGSIMPLEACC_FILTERBY_PERIOD', 'Zeitraum auswählen');
\define('_MA_WGSIMPLEACC_FILTER_PERIODFROM', 'Von');
\define('_MA_WGSIMPLEACC_FILTER_PERIODTO', 'Bis');
\define('_MA_WGSIMPLEACC_FILTER_APPLY', 'Filter anwenden');
\define('_MA_WGSIMPLEACC_FILTER_SHOW', 'Filter anzeigen');
\define('_MA_WGSIMPLEACC_FILTER_HIDE', 'Filter ausblenden');
\define('_MA_WGSIMPLEACC_FILTER_OUTPUT', 'Gewählte Daten ausgeben');
\define('_MA_WGSIMPLEACC_FILTER_OUTPUTTYPE', 'Art der Ausgabe');
\define('_MA_WGSIMPLEACC_DATECREATED', 'Erstelldatum');
\define('_MA_WGSIMPLEACC_SUBMITTER', 'Einsender');
\define('_MA_WGSIMPLEACC_LIST_CHILDS', 'Klicke zum Anzeigen/Verstecken der Unterkategorien');
\define('_MA_WGSIMPLEACC_APPROVE', 'Freigeben');
\define('_MA_WGSIMPLEACC_DASHBOARD', 'Dashboard');
\define('_MA_WGSIMPLEACC_DOWNLOAD', 'Download');
\define('_MA_WGSIMPLEACC_REACTIVATE', 'Reaktivieren (Transaktion wieder zu gültigen Transaktionen hinzufügen');
\define('_MA_WGSIMPLEACC_SUMS', 'Summen');
// ---------------- Contents ----------------
// There aren't
\define('_MA_WGSIMPLEACC_THEREARENT_ACCOUNTS', 'Es gibt derzeit keine Konten in der Datenbank');
\define('_MA_WGSIMPLEACC_THEREARENT_TRANSACTIONS', 'Es gibt derzeit keine Transaktionen in der Datenbank');
\define('_MA_WGSIMPLEACC_THEREARENT_TRAHISTORIES', 'Es gibt derzeit keine historischen Transaktionen in der Datenbank');
\define('_MA_WGSIMPLEACC_THEREARENT_ALLOCATIONS', 'Es gibt derzeit keine Zuordnungen in der Datenbank');
\define('_MA_WGSIMPLEACC_THEREARENT_ASSETS', 'Es gibt derzeit keine Vermögenswerte in der Datenbank');
\define('_MA_WGSIMPLEACC_THEREARENT_CURRENCIES', 'Es gibt derzeit keine Währungen in der Datenbank');
\define('_MA_WGSIMPLEACC_THEREARENT_TAXES', 'Es gibt derzeit keine Steuerarten in der Datenbank');
\define('_MA_WGSIMPLEACC_THEREARENT_FILES', 'Es gibt derzeit keine Dateien in der Datenbank');
\define('_MA_WGSIMPLEACC_THEREARENT_BALANCES', 'Es gibt derzeit keine Abschlüsse in der Datenbank');
\define('_MA_WGSIMPLEACC_THEREARENT_TRATEMPLATES', 'Es gibt derzeit keine Transaktionsvorlagen in der Datenbank');
\define('_MA_WGSIMPLEACC_THEREARENT_OUTTEMPLATES', 'Es gibt derzeit keine Ausgabevorlagen in der Datenbank');
\define('_MA_WGSIMPLEACC_THEREARENT_CLIENTS', 'Es gibt derzeit keine Klienten in der Datenbank');
// Account
\define('_MA_WGSIMPLEACC_ACCOUNT', 'Konto');
\define('_MA_WGSIMPLEACC_ACCOUNTS', 'Buchungskonten');
\define('_MA_WGSIMPLEACC_ACCOUNTS_TITLE', 'Kontentitel');
\define('_MA_WGSIMPLEACC_ACCOUNTS_DESC', 'Beschreibung Konten');
\define('_MA_WGSIMPLEACC_ACCOUNTS_LIST', 'Liste der Buchungskonten');
\define('_MA_WGSIMPLEACC_ACCOUNTS_TIMELINE', 'Entwicklung nach Konten');
\define('_MA_WGSIMPLEACC_ACCOUNT_SUBMIT', 'Konto einsenden');
// Caption of Konto
\define('_MA_WGSIMPLEACC_ACCOUNT_ID', 'Id');
\define('_MA_WGSIMPLEACC_ACCOUNT_PID', 'Übergeordnetes Konto');
\define('_MA_WGSIMPLEACC_ACCOUNT_KEY', 'Schlüssel');
\define('_MA_WGSIMPLEACC_ACCOUNT_NAME', 'Name');
\define('_MA_WGSIMPLEACC_ACCOUNT_DESC', 'Beschreibung');
\define('_MA_WGSIMPLEACC_ACCOUNT_CLASSIFICATION', 'Klassifizierung');
\define('_MA_WGSIMPLEACC_ACCOUNT_COLOR', 'Farbe');
\define('_MA_WGSIMPLEACC_ACCOUNT_ONLINE', 'Online');
\define('_MA_WGSIMPLEACC_ACCOUNT_SORT', 'Sortierung');
\define('_MA_WGSIMPLEACC_ACCOUNT_LEVEL', 'Ebene');
\define('_MA_WGSIMPLEACC_ACCOUNT_WEIGHT', 'Reihung');
\define('_MA_WGSIMPLEACC_ACCOUNT_IECALC', 'Verwendung in Einnahmen-Ausgaben-Berechnung');
\define('_MA_WGSIMPLEACC_ACCOUNT_ERR_DELETE', 'Löschen des Kontos nicht zulässig!<br>Das Konto wurde bereits für Transaktionen verwendet!<br>Bitte zuerst diese Transaktionen ändern');
// Transaction add/edit
\define('_MA_WGSIMPLEACC_TRANSACTION_ADD', 'Transaktion hinzufügen');
\define('_MA_WGSIMPLEACC_TRANSACTION_ADD_INCOME', 'Transaktion Einnahmen hinzufügen');
\define('_MA_WGSIMPLEACC_TRANSACTION_ADD_EXPENSES', 'Transaktion Ausgaben hinzufügen');
\define('_MA_WGSIMPLEACC_TRANSACTION_EDIT', 'Transaktion bearbeiten');
\define('_MA_WGSIMPLEACC_TRANSACTION_EDIT_INCOME', 'Transaktion Einnahmen bearbeiten');
\define('_MA_WGSIMPLEACC_TRANSACTION_EDIT_EXPENSES', 'Transaktion Ausgaben bearbeiten');
\define('_MA_WGSIMPLEACC_TRANSACTION_STATUS_WAITING', 'Wartet auf Freigabe');
\define('_MA_WGSIMPLEACC_TRANSACTION_DETAILS', 'Details zu Transaktion');
// Transaction
\define('_MA_WGSIMPLEACC_TRANSACTION', 'Transaktion');
\define('_MA_WGSIMPLEACC_TRANSACTIONS', 'Transaktionen');
\define('_MA_WGSIMPLEACC_TRANSACTIONS_TITLE', 'Transaktionstitel');
\define('_MA_WGSIMPLEACC_TRANSACTIONS_DESC', 'Beschreibung Transaktion');
\define('_MA_WGSIMPLEACC_TRANSACTIONS_LIST', 'Liste der Transaktionen');
\define('_MA_WGSIMPLEACC_TRANSACTIONS_OVERVIEW', 'Übersicht Transaktionen');
\define('_MA_WGSIMPLEACC_TRANSACTIONS_INCOMES', 'Einnahmen');
\define('_MA_WGSIMPLEACC_TRANSACTIONS_EXPENSES', 'Ausgaben');
\define('_MA_WGSIMPLEACC_TRANSACTION_SUBMIT_INCOME', 'Einnahme erstellen');
\define('_MA_WGSIMPLEACC_TRANSACTION_SUBMIT_EXPENSE', 'Ausgabe erstellen');
// Caption of Transaction
\define('_MA_WGSIMPLEACC_TRANSACTION_ID', 'Id');
\define('_MA_WGSIMPLEACC_TRANSACTION_YEAR', 'Jahr');
\define('_MA_WGSIMPLEACC_TRANSACTION_NB', 'Nummer');
\define('_MA_WGSIMPLEACC_TRANSACTION_YEARNB', 'Jahr/Nummer');
\define('_MA_WGSIMPLEACC_TRANSACTION_DESC', 'Beschreibung');
\define('_MA_WGSIMPLEACC_TRANSACTION_REFERENCE', 'Referenz');
\define('_MA_WGSIMPLEACC_TRANSACTION_REMARKS', 'Anmerkungen');
\define('_MA_WGSIMPLEACC_TRANSACTION_ACCID', 'Konto');
\define('_MA_WGSIMPLEACC_TRANSACTION_ALLID', 'Zuordnung');
\define('_MA_WGSIMPLEACC_TRANSACTION_DATE', 'Datum');
\define('_MA_WGSIMPLEACC_TRANSACTION_CURID', 'Währung');
\define('_MA_WGSIMPLEACC_TRANSACTION_AMOUNT', 'Betrag');
\define('_MA_WGSIMPLEACC_TRANSACTION_AMOUNTIN', 'Betrag Einnahme');
\define('_MA_WGSIMPLEACC_TRANSACTION_AMOUNTOUT', 'Betrag Ausgabe');
\define('_MA_WGSIMPLEACC_TRANSACTION_TAXID', 'Steuerart');
\define('_MA_WGSIMPLEACC_TRANSACTION_ASID', 'Vermögenswert');
\define('_MA_WGSIMPLEACC_TRANSACTION_CLIID', 'Klient');
\define('_MA_WGSIMPLEACC_TRANSACTION_STATUS', 'Status');
\define('_MA_WGSIMPLEACC_TRANSACTION_COMMENTS', 'Kommentare');
\define('_MA_WGSIMPLEACC_TRANSACTION_CLASS', 'Klasse');
\define('_MA_WGSIMPLEACC_TRANSACTION_FILES', 'Dateien');
\define('_MA_WGSIMPLEACC_TRANSACTION_BALID', 'Abschluss');
\define('_MA_WGSIMPLEACC_TRANSACTION_HIST', 'Historie');
\define('_MA_WGSIMPLEACC_TRANSACTION_TEMPLATE', 'Vorlage');
// Allocation
\define('_MA_WGSIMPLEACC_ALLOCATION', 'Zuordnung');
\define('_MA_WGSIMPLEACC_ALLOCATIONS', 'Zuordnungen');
\define('_MA_WGSIMPLEACC_ALLOCATIONS_TITLE', 'Titel Zuordnungen');
\define('_MA_WGSIMPLEACC_ALLOCATIONS_DESC', 'Beschreibung Zuordnungen');
\define('_MA_WGSIMPLEACC_ALLOCATIONS_LIST', 'Liste der Zuordnungen');
\define('_MA_WGSIMPLEACC_ALLOCATION_SUBMIT', 'Zuordnung einsenden');
\define('_MA_WGSIMPLEACC_ALLOCATION_SELECT', 'Zuordnung wählen');
// Caption of Allocation
\define('_MA_WGSIMPLEACC_ALLOCATION_ID', 'Id');
\define('_MA_WGSIMPLEACC_ALLOCATION_PID', 'Übergeordnete Zuordnung');
\define('_MA_WGSIMPLEACC_ALLOCATION_NAME', 'Name');
\define('_MA_WGSIMPLEACC_ALLOCATION_DESC', 'Beschreibung');
\define('_MA_WGSIMPLEACC_ALLOCATION_ONLINE', 'Online');
\define('_MA_WGSIMPLEACC_ALLOCATION_SORT', 'Sortierung');
\define('_MA_WGSIMPLEACC_ALLOCATION_LEVEL', 'Ebene');
\define('_MA_WGSIMPLEACC_ALLOCATION_WEIGHT', 'Reihung');
\define('_MA_WGSIMPLEACC_ALLOCATION_ERR_DELETE1', 'Löschen der Zuordnung nicht zulässig!<br>Die Zuordnung wurde bereits für Transaktionen verwendet!<br>Bitte zuerst diese Transaktionen ändern');
\define('_MA_WGSIMPLEACC_ALLOCATION_ERR_DELETE2', 'Löschen der Zuordnung nicht zulässig!<br>Die Zuordnung besitzt Unterkategorien!<br>Bitte zuerst Unterkategorien löschen');
\define('_MA_WGSIMPLEACC_ALLOCATION_CURRID', 'Diese Zuordnung: %s');
// Asset
\define('_MA_WGSIMPLEACC_ASSET', 'Vermögenswert');
\define('_MA_WGSIMPLEACC_ASSETS', 'Vermögenswerte');
\define('_MA_WGSIMPLEACC_ASSETS_TITLE', 'Vermögenswerte Titel');
\define('_MA_WGSIMPLEACC_ASSETS_DESC', 'Vermögenswerte Beschreibung');
\define('_MA_WGSIMPLEACC_ASSETS_LIST', 'Liste der Vermögenswerte');
\define('_MA_WGSIMPLEACC_ASSETS_OVERVIEW', 'Übersicht über Vermögenswerte');
\define('_MA_WGSIMPLEACC_ASSETS_CURRENT', 'Aktuelle Werte der Vermögenswerte');
\define('_MA_WGSIMPLEACC_ASSETSTOTAL_CURRENT', 'Aktuelle Werte der Vermögenswerte gesamt');
\define('_MA_WGSIMPLEACC_ASSETS_TIMELINE', 'Entwicklung der Vermögenswerte');
\define('_MA_WGSIMPLEACC_ASSET_SUBMIT', 'Vermögenswert einsenden');
// Caption of Asset
\define('_MA_WGSIMPLEACC_ASSET_ID', 'Id');
\define('_MA_WGSIMPLEACC_ASSET_NAME', 'Name');
\define('_MA_WGSIMPLEACC_ASSET_REFERENCE', 'Referenz');
\define('_MA_WGSIMPLEACC_ASSET_DESCR', 'Beschreibung');
\define('_MA_WGSIMPLEACC_ASSET_COLOR', 'Farbe');
\define('_MA_WGSIMPLEACC_ASSET_ONLINE', 'Online');
\define('_MA_WGSIMPLEACC_ASSET_PRIMARY', 'Primär');
\define('_MA_WGSIMPLEACC_ASSET_ERR_DELETE', 'Löschen des Vermögenswertes nicht zulässig!<br>Der Vermögenswert wurde als primär definiert!<br>Bitte zuerst einen anderen Vermögenswert als primär definieren');
//Charts
\define('_MA_WGSIMPLEACC_CHART_AMOUNT', 'Betrag');
\define('_MA_WGSIMPLEACC_CHART_PERIOD', 'Zeitraum');
\define('_MA_WGSIMPLEACC_CHART_BALANCE', 'Saldo');
//Color
\define('_MA_WGSIMPLEACC_COLOR_LIGHTRED', 'Hellrot');
\define('_MA_WGSIMPLEACC_COLOR_RED', 'Rot');
\define('_MA_WGSIMPLEACC_COLOR_DARKRED', 'Dunkelrot');
\define('_MA_WGSIMPLEACC_COLOR_LIGHTORANGE', 'Hellorange');
\define('_MA_WGSIMPLEACC_COLOR_ORANGE', 'Orange');
\define('_MA_WGSIMPLEACC_COLOR_DARKORANGE', 'Dunkelorange');
\define('_MA_WGSIMPLEACC_COLOR_LIGHTYELLOW', 'Hellgelb');
\define('_MA_WGSIMPLEACC_COLOR_YELLOW', 'Gelb');
\define('_MA_WGSIMPLEACC_COLOR_DARKYELLOW', 'Dunkelgelb');
\define('_MA_WGSIMPLEACC_COLOR_LIGHTGREEN', 'Hellgrün');
\define('_MA_WGSIMPLEACC_COLOR_GREEN', 'Grün');
\define('_MA_WGSIMPLEACC_COLOR_DARKGREEN', 'Dunkelgrün');
\define('_MA_WGSIMPLEACC_COLOR_LIGHTBLUE', 'Hellblau');
\define('_MA_WGSIMPLEACC_COLOR_BLUE', 'Blau');
\define('_MA_WGSIMPLEACC_COLOR_DARKBLUE', 'Dunkelblau');
\define('_MA_WGSIMPLEACC_COLOR_LIGHTPURPLE', 'Hellviolett');
\define('_MA_WGSIMPLEACC_COLOR_PURPLE', 'Violett');
\define('_MA_WGSIMPLEACC_COLOR_DARKPURPLE', 'Dunkelviolett');
\define('_MA_WGSIMPLEACC_COLOR_GREY', 'Grau');
\define('_MA_WGSIMPLEACC_COLOR_LIGHTBROWN', 'Hellbraun');
\define('_MA_WGSIMPLEACC_COLOR_BROWN', 'Braun');
\define('_MA_WGSIMPLEACC_COLOR_DARKBROWN', 'Dunkelbraun');
// File add/edit
\define('_MA_WGSIMPLEACC_FILE_ADD', 'Datei hinzufügen');
\define('_MA_WGSIMPLEACC_FILE_EDIT', 'Datei bearbeiten');
// File
\define('_MA_WGSIMPLEACC_FILE', 'Datei');
\define('_MA_WGSIMPLEACC_FILES', 'Dateien');
\define('_MA_WGSIMPLEACC_FILES_TITLE', 'Dateien Titel');
\define('_MA_WGSIMPLEACC_FILES_DESC', 'Dateien Beschreibung');
\define('_MA_WGSIMPLEACC_FILES_LIST', 'Liste der Dateien');
\define('_MA_WGSIMPLEACC_FILES_LISTHEADER', 'Dateien zu Transaktion: %t');
\define('_MA_WGSIMPLEACC_FILES_CURRENT', 'Aktuelle Dateien');
\define('_MA_WGSIMPLEACC_FILES_UPLOAD', 'Dateien hochladen');
\define('_MA_WGSIMPLEACC_FILES_UPLOAD_ERROR', 'Fehler beim Hochladen von Datei: ungültiger Dateiname');
\define('_MA_WGSIMPLEACC_FILES_TEMP', 'Hochgeladene Dateien');
\define('_MA_WGSIMPLEACC_FILES_TEMP_DESC', 'Hochgeladene Dateien im Verzeichnis: %f');
\define('_MA_WGSIMPLEACC_FILES_TEMP_DESC_NO', 'Es gibt keine hochgeladenen Dateien im Verzeichnis: %f');
\define('_MA_WGSIMPLEACC_FILE_DETAILS', 'Details zu Datei');
// Caption of File
\define('_MA_WGSIMPLEACC_FILE_ID', 'Id');
\define('_MA_WGSIMPLEACC_FILE_TRAID', 'Transaktion');
\define('_MA_WGSIMPLEACC_FILE_NAME', 'Name');
\define('_MA_WGSIMPLEACC_FILE_NAME_UPLOADS', 'Name in %s :');
\define('_MA_WGSIMPLEACC_FILE_TYPE', 'Typ');
\define('_MA_WGSIMPLEACC_FILE_DESC', 'Beschreibung');
\define('_MA_WGSIMPLEACC_FILE_IP', 'Ip');
\define('_MA_WGSIMPLEACC_FILE_PREVIEW', 'Vorschau');
// Balance
\define('_MA_WGSIMPLEACC_BALANCE', 'Abschluss');
\define('_MA_WGSIMPLEACC_BALANCES', 'Abschlüsse');
\define('_MA_WGSIMPLEACC_BALANCES_TITLE', 'Abschlüsse Titel');
\define('_MA_WGSIMPLEACC_BALANCES_LIST', 'Liste der Abschlüsse');
\define('_MA_WGSIMPLEACC_BALANCE_SUBMIT', 'Abschluss erstellen');
\define('_MA_WGSIMPLEACC_BALANCE_SUBMIT_FINAL', 'Abschluss endgültig erstellen');
\define('_MA_WGSIMPLEACC_BALANCE_PRECALC', 'Vorausberechnung');
\define('_MA_WGSIMPLEACC_BALANCES_TIMELINE', 'Entwicklung der Vermögenswerte je Abschluss');
\define('_MA_WGSIMPLEACC_BALANCE_DETAILS', 'Details zum Abschluss');
// Caption of Balance
\define('_MA_WGSIMPLEACC_BALANCE_ID', 'Id');
\define('_MA_WGSIMPLEACC_BALANCE_FROM', 'Von');
\define('_MA_WGSIMPLEACC_BALANCE_TO', 'Bis');
\define('_MA_WGSIMPLEACC_BALANCE_ASID', 'Vermögenswert');
\define('_MA_WGSIMPLEACC_BALANCE_CURID', 'Währung');
\define('_MA_WGSIMPLEACC_BALANCE_AMOUNTSTART', 'Startbetrag');
\define('_MA_WGSIMPLEACC_BALANCE_AMOUNTEND', 'Endbetrag');
\define('_MA_WGSIMPLEACC_BALANCE_DIFFERENCE', 'Differenz');
\define('_MA_WGSIMPLEACC_BALANCE_STATUS', 'Status');
\define('_MA_WGSIMPLEACC_BALANCE_CALC_PERIOD', 'Berechnete Werte für den Zeitraum von %f bis %t');
\define('_MA_WGSIMPLEACC_BALANCE_DATE', 'Letztes Datum des Vermögenswertes');
\define('_MA_WGSIMPLEACC_BALANCE_VALUESTART', 'Vermögenswert (zu Beginn)');
\define('_MA_WGSIMPLEACC_BALANCE_VALUEEND', 'Berechneter Vermögenswertes am Ende');
\define('_MA_WGSIMPLEACC_BALANCE_DATEUSED', "Das 'Datum von' or 'Datum bis' ist innerhalb des Zeitraumes eines anderen Abschlusses");
\define('_MA_WGSIMPLEACC_BALANCE_ERRORS', 'Abschlüsse wurden erstellt, jedoch sind Fehler aufgetreten');
// Output balances
\define('_MA_WGSIMPLEACC_BALANCES_OUT_TOTAL', 'Total');
\define('_MA_WGSIMPLEACC_BALANCES_OUT_SUMS', 'Summen');
\define('_MA_WGSIMPLEACC_BALANCES_OUT_SELECT', 'Abschlüsse auswählen');
\define('_MA_WGSIMPLEACC_BALANCES_OUT_LEVEL', 'Detailgrad auswählen');
\define('_MA_WGSIMPLEACC_BALANCES_OUT_LEVEL_SKIP', 'Nicht ausgeben');
\define('_MA_WGSIMPLEACC_BALANCES_OUT_LEVEL_ALLOC', 'Detailgrad Zuordnungen');
\define('_MA_WGSIMPLEACC_BALANCES_OUT_LEVEL_ALLOC1', 'Zuordnungen erstes Level zusammenfassen');
\define('_MA_WGSIMPLEACC_BALANCES_OUT_LEVEL_ALLOC2', 'Alle Zuordnungen detailliert ausgeben');
\define('_MA_WGSIMPLEACC_BALANCES_OUT_LEVEL_ACC', 'Detailgrad Konten');
\define('_MA_WGSIMPLEACC_BALANCES_OUT_LEVEL_ACC1', 'Konten erstes Level zusammenfassen');
\define('_MA_WGSIMPLEACC_BALANCES_OUT_LEVEL_ACC2', 'Alle Konten detailliert ausgeben');
// Templates general
\define('_MA_WGSIMPLEACC_TEMPLATES', 'Vorlagen');
\define('_MA_WGSIMPLEACC_TEMPLATE_NONE', 'Keine');
// Tratemplates
\define('_MA_WGSIMPLEACC_TRATEMPLATES', 'Transaktionsvorlagen');
\define('_MA_WGSIMPLEACC_TRATEMPLATES_LIST', 'Liste der Transaktionsvorlagen');
\define('_MA_WGSIMPLEACC_TRATEMPLATE_SUBMIT', 'Transaktionsvorlage einsenden');
// Elements of Template
\define('_MA_WGSIMPLEACC_TRATEMPLATE_ID', 'Id');
\define('_MA_WGSIMPLEACC_TRATEMPLATE_NAME', 'Name');
\define('_MA_WGSIMPLEACC_TRATEMPLATE_DESC', 'Beschreibung');
\define('_MA_WGSIMPLEACC_TRATEMPLATE_ACCID', 'Konto');
\define('_MA_WGSIMPLEACC_TRATEMPLATE_ALLID', 'Zuordnung');
\define('_MA_WGSIMPLEACC_TRATEMPLATE_ASID', 'Vermögenswert');
\define('_MA_WGSIMPLEACC_TRATEMPLATE_CLASS', 'Klasse');
\define('_MA_WGSIMPLEACC_TRATEMPLATE_AMOUNTIN', 'Betrag Eingang');
\define('_MA_WGSIMPLEACC_TRATEMPLATE_AMOUNTOUT', 'Betrag Ausgang');
\define('_MA_WGSIMPLEACC_TRATEMPLATE_ONLINE', 'Online');
// Outtemplate
\define('_MA_WGSIMPLEACC_OUTTEMPLATE', 'Ausgabevorlage');
\define('_MA_WGSIMPLEACC_OUTTEMPLATES', 'Ausgabevorlagen');
\define('_MA_WGSIMPLEACC_OUTTEMPLATES_TITLE', 'Titel Ausgabevorlage');
\define('_MA_WGSIMPLEACC_OUTTEMPLATES_LIST', 'Liste der Ausgabevorlage');
\define('_MA_WGSIMPLEACC_OUTTEMPLATE_SUBMIT', 'Ausgabevorlage einsenden');
// Caption of Outtemplate
\define('_MA_WGSIMPLEACC_OUTTEMPLATE_ID', 'Id');
\define('_MA_WGSIMPLEACC_OUTTEMPLATE_NAME', 'Name');
\define('_MA_WGSIMPLEACC_OUTTEMPLATE_CONTENT', 'Inhalt');
\define('_MA_WGSIMPLEACC_OUTTEMPLATE_CONTENT_DESC','
    Html format:
    <br>
    Dieses Modul verwendet die Xoops <a href="http://www.smarty.net/">Smarty template engine</a> zum Rendern von Ausgaben.
    <br><br>
    Verfügbare Smarty-Variable sind:
    <ul>
    <li><{$sender}>: Absender</li>
    <li><{$recipient}>: Empfänger</li>
    <li><{$year}>: GZ-Jahr der Transaktion</li>
    <li><{$nb}>: GZ-Nummer der Transaktion</li>
    <li><{$year_nb}>: GZ-Jahr/GZ-Nummer der Transaktion (Format: JJJJ/00000)</li>
    <li><{$desc}>: Beschreibung</li>
    <li><{$reference}>: Referenz</li>
    <li><{$account}>: Konto</li>
    <li><{$allocation}>: Zuordnung</li>
    <li><{$asset}>: Vermögenswert</li>
    <li><{$amount}>: Betrag</li>
    <li><{$date}>: Transaktionsdatum</li>
    <li><{$amount}>: Betrag</li>
    </ul>
    <ul>
    <li><{$xoops_url}>: Url Ihrer Webseite (z.B. http://localhost/)</li>
    <li><{$output_date}>: Ausgabedatum</li>
    <li><{$output_user}>: Aktueller Benutzername</li>
    </ul>');
\define('_MA_WGSIMPLEACC_OUTTEMPLATE_ONLINE', 'Online');
// Output Form
\define('_MA_WGSIMPLEACC_OUTTEMPLATE_SELECT', 'Transaktion und Ausgabevorlage auswählen');
\define('_MA_WGSIMPLEACC_OUTTEMPLATE_YEAR', 'Jahr');
\define('_MA_WGSIMPLEACC_OUTTEMPLATE_NB', 'Nummer');
\define('_MA_WGSIMPLEACC_OUTTEMPLATE_SENDER', 'Absender');
\define('_MA_WGSIMPLEACC_OUTTEMPLATE_RECIPIENT', 'Empfänger');
\define('_MA_WGSIMPLEACC_OUTTEMPLATE_TARGET', 'Art der Ausgabe');
\define('_MA_WGSIMPLEACC_OUTTEMPLATE_TARGET_SHOW', 'Nur anzeigen');
\define('_MA_WGSIMPLEACC_OUTTEMPLATE_TARGET_PDF', 'Als PDF ausgeben');
\define('_MA_WGSIMPLEACC_OUTTEMPLATE_PDF_SUCCESS', 'Daten erfolgreich als PDF ausgegeben');
// Client
\define('_MA_WGSIMPLEACC_CLIENTS', 'Klienten');
\define('_MA_WGSIMPLEACC_CLIENTS_LIST', 'Liste der Klienten');
\define('_MA_WGSIMPLEACC_CLIENT_SUBMIT', 'Klient einsenden');
// Client add/edit
\define('_MA_WGSIMPLEACC_CLIENT_ADD', 'Klient hinzufügen');
\define('_MA_WGSIMPLEACC_CLIENT_EDIT', 'Klient bearbeiten');
// Elements of Client
\define('_MA_WGSIMPLEACC_CLIENT_ID', 'Id');
\define('_MA_WGSIMPLEACC_CLIENT_NAME', 'Name');
\define('_MA_WGSIMPLEACC_CLIENT_FULLADDRESS', 'Adresse');
\define('_MA_WGSIMPLEACC_CLIENT_POSTAL', 'PLZ');
\define('_MA_WGSIMPLEACC_CLIENT_CITY', 'Ort');
\define('_MA_WGSIMPLEACC_CLIENT_ADDRESS', 'Adresse');
\define('_MA_WGSIMPLEACC_CLIENT_CTRY', 'Land');
\define('_MA_WGSIMPLEACC_CLIENT_PHONE', 'Telefon');
\define('_MA_WGSIMPLEACC_CLIENT_VAT', 'UID');
\define('_MA_WGSIMPLEACC_CLIENT_CREDITOR', 'Kreditor (Verkäufer)');
\define('_MA_WGSIMPLEACC_CLIENT_DEBTOR', 'Debitor (Käufer)');
// Statistics
\define('_MA_WGSIMPLEACC_STATISTICS', 'Statistiken');
// Outputs
\define('_MA_WGSIMPLEACC_OUTPUTS', 'Ausgabe');
\define('_MA_WGSIMPLEACC_OUTPUT_TRA_TITLE', 'Ausgabe Transaktionen');
\define('_MA_WGSIMPLEACC_OUTPUT_BALANCES', 'Ausgabe Abschlüsse');
// History
\define('_MA_WGSIMPLEACC_HISTORY_ID', 'History Id');
\define('_MA_WGSIMPLEACC_HISTORY_TYPE', 'Typ');
\define('_MA_WGSIMPLEACC_HISTORY_DATECREATED', 'Datum Historie');
\define('_MA_WGSIMPLEACC_TRAHISTORY_LIST', 'Historie zu Transaktion');
\define('_MA_WGSIMPLEACC_TRAHISTORY_DELETED', 'Liste der gelöschten Transaktionen');
// Submit
\define('_MA_WGSIMPLEACC_SUBMIT', 'Einsenden');
// Modal
\define('_MA_WGSIMPLEACC_MODAL_TRATITLE', 'Details zu Transaktion %s');
// Form
\define('_MA_WGSIMPLEACC_FORM_OK', 'Erfolgreich gespeichert');
\define('_MA_WGSIMPLEACC_FORM_DELETE_OK', 'Erfolgreich gelöscht');
\define('_MA_WGSIMPLEACC_FORM_SURE_DELETE', "Wollen Sie diesen Eintrag wirklich löschen: <b><span style='color : Red;'>%s </span></b>");
\define('_MA_WGSIMPLEACC_FORM_SURE_RENEW', "Wollen Sie diesen Eintrag wirklich aktualisieren: <b><span style='color : Red;'>%s </span></b>");
\define('_MA_WGSIMPLEACC_INVALID_PARAM', 'Ungültiger Parameter');
\define('_MA_WGSIMPLEACC_FORM_ACTION', 'Aktion');
\define('_MA_WGSIMPLEACC_FORM_UPLOAD', 'Datei hochladen');
\define('_MA_WGSIMPLEACC_FORM_UPLOAD_SIZE', 'Maximale Dateigröße: ');
\define('_MA_WGSIMPLEACC_FORM_UPLOAD_SIZE_MB', 'MB');
\define('_MA_WGSIMPLEACC_FORM_IMAGE_PATH', 'Dateien in %s :');
\define('_MA_WGSIMPLEACC_FORM_UPLOAD_ALLOWEDMIME', 'Erlaubte Dateitypen:');
//Constants
\define('_MA_WGSIMPLEACC_CLASS_EXPENSES', 'Ausgaben');
\define('_MA_WGSIMPLEACC_CLASS_INCOME', 'Einnahmen');
\define('_MA_WGSIMPLEACC_CLASS_BOTH', 'Beides');
//PDF files
\define('_MA_WGSIMPLEACC_PDF_BUTTON', 'Als PDF ausgeben');
\define('_MA_WGSIMPLEACC_PDF_TRANAME', 'Beleg_%y_%n');
\define('_MA_WGSIMPLEACC_PDF_TRAHEADER', 'Beleg %y / %n');
\define('_MA_WGSIMPLEACC_PDF_BALNAME', 'Ausgabe_Abschluesse');
\define('_MA_WGSIMPLEACC_PDF_BALHEADER', 'Ausgabe Abschlüsse');
// ---------------- Print ----------------
\define('_MA_WGSIMPLEACC_PRINT', 'Print');
// ---------------- Menu ----------------
\define('_MA_WGSIMPLEACC_MENUADMIN', 'Administration');
\define('_MA_WGSIMPLEACC_MENUUSER', 'Benutzer');
\define('_MA_WGSIMPLEACC_MENUNOTIF', 'Benachrichtigungen');
\define('_MA_WGSIMPLEACC_MENUINBOX', 'Posteingang');
// Admin link
\define('_MA_WGSIMPLEACC_ADMIN', 'Admin');
// ---------------- End ----------------
// Konto add/edit
\define('_MA_WGSIMPLEACC_ACCOUNT_ADD', 'Konto hinzufügen');
\define('_MA_WGSIMPLEACC_ACCOUNT_EDIT', 'Konto bearbeiten');
// Allocation add/edit
\define('_MA_WGSIMPLEACC_ALLOCATION_ADD', 'Zuordnung hinzufügen');
\define('_MA_WGSIMPLEACC_ALLOCATION_EDIT', 'Zuordnung bearbeiten');
// Asset add/edit
\define('_MA_WGSIMPLEACC_ASSET_ADD', 'Vermögenswert hinzufügen');
\define('_MA_WGSIMPLEACC_ASSET_EDIT', 'Vermögenswert bearbeiten');
// Balance add/edit
\define('_MA_WGSIMPLEACC_BALANCE_ADD', 'Abschluss hinzufügen');
\define('_MA_WGSIMPLEACC_BALANCE_EDIT', 'Abschluss bearbeiten');
// Template add/edit
\define('_MA_WGSIMPLEACC_TRATEMPLATE_ADD', 'Vorlage hinzufügen');
\define('_MA_WGSIMPLEACC_TRATEMPLATE_EDIT', 'Vorlage bearbeiten');
// Template add/edit
\define('_MA_WGSIMPLEACC_OUTTEMPLATE_ADD', 'Vorlage hinzufügen');
\define('_MA_WGSIMPLEACC_OUTTEMPLATE_EDIT', 'Vorlage bearbeiten');
// Status
\define('_MA_WGSIMPLEACC_STATUS_NONE', 'Kein Status');
\define('_MA_WGSIMPLEACC_STATUS_OFFLINE', 'Gelöscht');
\define('_MA_WGSIMPLEACC_STATUS_SUBMITTED', 'Eingesendet');
\define('_MA_WGSIMPLEACC_STATUS_APPROVED', 'Bestätigt');
\define('_MA_WGSIMPLEACC_STATUS_BROKEN', 'Fehlerhaft');
\define('_MA_WGSIMPLEACC_STATUS_CREATED', 'Erstellt');
\define('_MA_WGSIMPLEACC_STATUS_LOCKED', 'Gesperrt');

