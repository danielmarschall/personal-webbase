<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

// Link Updates

$res = db_query("SELECT COUNT(*) AS `ct` FROM `".$WBConfig->getMySQLPrefix()."links` WHERE `update_enabled` = '1' AND `new_tag` = '1' AND `user_cnid` = '".$benutzer['id']."'");
$row = db_fetch($res);
$ereignisse['links_updates'] = $row['ct'];

if ($ereignisse['links_updates'] != 1)
	$plural_links1 = 'n';
else
	$plural_links1 = '';

if ($ereignisse['links_updates'])
	$links_weiter1 = '<div align="right"><a href="'.$_SERVER['PHP_SELF'].'?seite=main&amp;modul='.$m2.'&amp;onlyupdates=1" class="menu">Anzeigen &gt;&gt;</a></div>';
else
	$links_weiter1 = '';

wb_draw_table_content('30', '<b>'.$ereignisse['links_updates'].'</b>', '', 'beobachtete Webseite'.$plural_links1.' mit neuen &Auml;nderungen.', '', $links_weiter1);

// Link Fehler

$res = db_query("SELECT COUNT(*) AS `ct` FROM `".$WBConfig->getMySQLPrefix()."links` WHERE `update_enabled` = '1' AND `broken_tag` = '1' AND `user_cnid` = '".$benutzer['id']."'");
$row = db_fetch($res);
$ereignisse['links_fehler'] = $row['ct'];

if ($ereignisse['links_fehler'] != 1)
	$plural_links2 = 'n';
else
	$plural_links2 = '';

if ($ereignisse['links_fehler'])
	$links_weiter2 = '<div align="right"><a href="'.$_SERVER['PHP_SELF'].'?seite=main&amp;modul='.$m2.'&amp;onlyupdates=1" class="menu">Anzeigen &gt;&gt;</a></div>';
else
	$links_weiter2 = '';

wb_draw_table_content('30', '<b>'.$ereignisse['links_fehler'].'</b>', '', 'beobachtete Webseite'.$plural_links1.' mit fehlerhafter &Uuml;berpr&uuml;fung.', '', $links_weiter2);

?>