<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

// Scan aller Cookies im Quellcode von phpMyAdmin 3.2.0.1

$cookies_to_delete = array();

$cookies_to_delete[] = 'phpMyAdmin';
$cookies_to_delete[] = 'pma_charset';
$cookies_to_delete[] = 'pma_collation_connection';
$cookies_to_delete[] = 'pma_db_filename_template';
$cookies_to_delete[] = 'pma_fontsize';
$cookies_to_delete[] = 'pma_lang';
$cookies_to_delete[] = 'pma_mcrypt_iv';
$cookies_to_delete[] = 'pma_navi_width';
$cookies_to_delete[] = 'pma_server_filename_template';
$cookies_to_delete[] = 'pma_switch_to_new';
$cookies_to_delete[] = 'pma_table_filename_template';
$cookies_to_delete[] = 'pma_theme';
$cookies_to_delete[] = 'pmaCookieVer';

// Wir löschen sicherheitshalber ALLES (TODO: Verbessern?)

// Bei Benutzern: Alle Server sind möglich
// (eigentlich sind ja nur die IDs möglich, die dem Benutzer gehören...)

$servers = array();
$res = db_query("SELECT `id` FROM `".$WBConfig->getMySQLPrefix()."phpmyadmin`");
while ($row = db_fetch($res)) {
	$servers[] = $row['id'];
}

// Bei Admins: Es gibt nur den Server #1, sonst nichts

if (!in_array('1', $servers)) $servers[] = '1';

// Nun die einzelnen Cookie-Varianten hinzufügen

foreach($servers as $val) {
	$cookies_to_delete[] = 'pma_theme-'.$val;;
	$cookies_to_delete[] = 'pmaPass-'.$val;;
	$cookies_to_delete[] = 'pmaServer-'.$val;
	$cookies_to_delete[] = 'pmaUser-'.$val;
}

unset($val);
unset($servers);

foreach($cookies_to_delete as $val) {
	wbUnsetCookie($val, 'modules/'.$m2.'/system/');
}

unset($val);
unset($cookies_to_delete);

?>
