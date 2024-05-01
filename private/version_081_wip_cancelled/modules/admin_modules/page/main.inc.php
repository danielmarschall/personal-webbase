<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

// Funktioniert FTP-Zugang?

$conn_id = @ftp_connect($configuration['common_directftp']['ftp-server'], $configuration['common_directftp']['ftp-port']);
$login_result = @ftp_login ($conn_id, $configuration['common_directftp']['ftp-username'], $configuration['common_directftp']['ftp-password']);

$fehler = '';

if ((!$conn_id) || (!$login_result))
{
	$fehler = 'Personal WebBase ben&ouml;tigt FTP-Zugriff auf das Verzeichnis &quot;modules&quot;, damit Module ordnungsgem&auml;&szlig; (de)installiert werden k&ouml;nnen.<br>Bitte bearbeiten Sie die <a href="'.$_SERVER['PHP_SELF'].'?modul=common_directftp&amp;seite=config&amp;vonmodul='.$modul.'">Konfigurationswerte</a> und tragen Sie dort korrekte Werte ein.<br><br>M&ouml;gliche Ursache: Server/Benutzername/Passwort falsch.';
	$verhindere_loeschen = 1;
}

if (($fehler == '') && ((substr($configuration['common_directftp']['ftp-verzeichnis'], 0, 1) != '/') || (substr($configuration['common_directftp']['ftp-verzeichnis'], strlen($configuration['common_directftp']['ftp-verzeichnis'])-1, 1) != '/')))
{
	$fehler = 'Die Verzeichnissyntax ist falsch. Bitte bearbeiten Sie die <a href="'.$_SERVER['PHP_SELF'].'?modul=common_directftp&amp;seite=config&amp;vonmodul='.$modul.'">Konfigurationswerte</a> und tragen Sie dort korrekte Werte ein.<br><br>M&ouml;gliche Ursache: Verzeichnis zeigt nicht auf Personal WebBase-Verzeichnis oder Datei &quot;moddir.txt&quot; ist nicht mehr vorhanden.';
	$verhindere_loeschen = 1;
}

if (($fehler == '') && (@ftp_size($conn_id, $configuration['common_directftp']['ftp-verzeichnis'].'modules/moddir.txt') == -1))
{
	$fehler = 'Personal WebBase ben&ouml;tigt FTP-Zugriff auf das Verzeichnis &quot;modules&quot;, damit Module ordnungsgem&auml;&szlig; (de)installiert werden k&ouml;nnen.<br>Bitte bearbeiten Sie die <a href="'.$_SERVER['PHP_SELF'].'?modul=common_directftp&amp;seite=config&amp;vonmodul='.$modul.'">Konfigurationswerte</a> und tragen Sie dort korrekte Werte ein.<br><br>M&ouml;gliche Ursache: Verzeichnis zeigt nicht auf Personal WebBase-Verzeichnis oder Datei &quot;moddir.txt&quot; ist nicht mehr vorhanden.';
	$verhindere_loeschen = 1;
}

@ftp_quit($conn_id);

echo $header;

echo '<h1>'.wb_htmlentities($module_information->caption).'</h1>';

echo 'Hier k&ouml;nnen Sie die Module von Personal WebBase verwalten. Ist ein Modul nicht
korrekt geschrieben worden, so k&ouml;nnen trotz Deinstallation des Moduls noch Datenbest&auml;nde in der
Datenbank zur&uuml;ckbleiben. Wenn das Modul als &quot;Personal WebBase-Core&quot; eingestuft wurde, dann
ist der Autor des Moduls der Meinung, dass es wichtig f&uuml;r die Ausf&uuml;hrung von Personal WebBase oder anderen
Modulen verantwortlich ist. Entfernen Sie ein solches Modul, so kann Personal WebBase besch&auml;digt und Kundendaten
verloren gehen! In dem Feld &quot;Daten&quot; k&ouml;nnen Sie sehen, wie viele Personal WebBase-Konfigurationswerte (C) und wie viele
MySQL-Tabellen (T) das jeweilige Modul benutzt.<br><br>';

wb_draw_table_begin();
wb_draw_table_content('', '<b>Verzeichnisname</b>', '', '<b>Modulname</b>', '', '<b>Autor</b>', '', '<b>Lizenztyp</b>', '', '<b>Sichtbar</b>', '', '<b>Version</b>', '', '<b>Sprache</b>', '', '<b>Daten</b>', '', '<b>Aktionen</b>');
foreach ($modules as $m1 => $m2)
{
	$res = db_query("SELECT COUNT(*) AS `cid` FROM `".$WBConfig->getMySQLPrefix()."configuration` WHERE `module` = '".db_escape($m2)."'");
	$row = db_fetch($res);
	$cdaten = $row['cid'];

	$res = db_query("SELECT COUNT(*) AS `cid` FROM `".$WBConfig->getMySQLPrefix()."modules` WHERE `module` = '".db_escape($m2)."'");
	$row = db_fetch($res);
	$mdaten = $row['cid'];

	$module_information = get_module_information($m2);

	if ($module_information->author == '') $module_information->author = 'Unbekannt';

	if ($module_information->version == '') $module_information->version = 'Unbekannt';

	if ($module_information->menu_visible == '0')
		$module_information->menu_visible = 'Nein';
	else if ($module_information->menu_visible == '1')
		$module_information->menu_visible = 'Ja';
	else
		$module_information->menu_visible = 'Unbekannt';

	if ($module_information->license == '0')
		$module_information->license = 'Public Freeware';
	else if ($module_information->license == '1')
		$module_information->license = 'Public Shareware';
	else if ($module_information->license == '2')
		$module_information->license = 'Private Secured';
	else if ($module_information->license == '3')
		$module_information->license = 'Personal WebBase-Core';
	else if ($module_information->license == '4')
		$module_information->license = 'Personal WebBase-Enclosure';
	else
		$module_information->license = 'Unbekannt';

	$ca = ($cdaten == 0) ? '' : '<a href="'.$_SERVER['PHP_SELF'].'?modul=admin_configuration&amp;seite=config&amp;only='.$m2.'&amp;vonmodul='.$modul.'&amp;vonseite='.$seite.'" class="menu">';
	$cb = ($cdaten == 0) ? '' : '</a>';
	$ta = ($mdaten == 0) ? '' : '<a href="'.$_SERVER['PHP_SELF'].'?modul=admin_database&amp;seite=main&amp;only='.$m2.'&amp;vonmodul='.$modul.'&amp;vonseite='.$seite.'" class="menu">';
	$tb = ($mdaten == 0) ? '' : '</a>';

	if ((isset($verhindere_loeschen)) && ($verhindere_loeschen != ''))
		$aktionen = '<span class="grey">Entfernen</span>';
	else
		$aktionen = '<a href="javascript:abfrage(\''.$_SERVER['PHP_SELF'].'?seite=operate&amp;modul='.$modul.'&amp;aktion=delete&amp;entfernen='.$m2.'\');" class="menu">Entfernen</a>';

	wb_draw_table_content('', wb_htmlentities($m2), '', wb_htmlentities($module_information->caption), '', wb_htmlentities($module_information->author), '', $module_information->license, '', $module_information->menu_visible, '',	wb_htmlentities($module_information->version), '', wb_htmlentities($module_information->language), '', $ca.$cdaten.'C'.$cb.' / '.$ta.$mdaten.'T'.$tb, '', $aktionen);
}

unset($m1);
unset($m2);

wb_draw_table_end();
echo '<b>Modul installieren</b><br><br>';

if ($fehler != '')
	echo '<span class="red">'.$fehler.'</span>';
else
	echo 'Achtung: Personal WebBase &uuml;berl&auml;sst den Modulen die komplette Handlungsfreiheit bez&uuml;glich der Datenbank und der PHP-Codeausf&uuml;hrung. Ein Modul kann bei dem Installationsprozess b&ouml;sartigen Code ausf&uuml;hren und das System oder den Datenbestand gef&auml;hrden. Installieren Sie daher nur Module, bei denen Sie sicherstellen k&ouml;nnen, dass sie keinen b&ouml;sartigen Code enthalten. Wenn Sie ein Modul updaten m&ouml;chten, deinstallieren Sie die alte Version des Modules zuerst. Maximale Dateigr&ouml;&szlig;e: '.ini_get('post_max_size').'B<br><br>

<form enctype="multipart/form-data" action="'.$_SERVER['PHP_SELF'].'" method="POST">
<input type="hidden" name="seite" value="operate">
<input type="hidden" name="modul" value="'.$modul.'">
<input type="hidden" name="aktion" value="install">
<input type="hidden" name="MAX_FILE_SIZE" value="'.return_bytes(ini_get('post_max_size')).'">

<input name="dfile" type="file"><br><br>

<input type="submit" class="button" onmouseover="this.className=\'button_act\';" onmouseout="this.className=\'button\';" value="Modul installieren">
</form><a href="'.deferer('http://www.personal-webbase.de/module.html').'" target="_blank">Weitere Module im offiziellen Personal WebBase-Portal</a>';

echo $footer;

?>