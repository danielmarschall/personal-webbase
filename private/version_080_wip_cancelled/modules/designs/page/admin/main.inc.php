<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

// Funktioniert FTP-Zugang?

$conn_id = @ftp_connect($configuration['common_directftp']['ftp-server'], $configuration['common_directftp']['ftp-port']);
$login_result = @ftp_login ($conn_id, $configuration['common_directftp']['ftp-username'], $configuration['common_directftp']['ftp-password']);

$fehler = '';

if ((!$conn_id) || (!$login_result))
{
	$fehler = 'Personal WebBase ben&ouml;tigt FTP-Zugriff auf das Verzeichnis &quot;design&quot;, damit Designs ordnungsgem&auml;&szlig; (de)installiert werden k&ouml;nnen.<br>Bitte bearbeiten Sie die <a href="'.$_SERVER['PHP_SELF'].'?modul=common_directftp&amp;seite=config&amp;vonmodul='.$modul.'">Konfigurationswerte</a> und tragen Sie dort korrekte Werte ein.<br><br>M&ouml;gliche Ursache: Server/Benutzername/Passwort falsch.';
	$verhindere_loeschen = 1;
}

if (($fehler == '') && ((substr($configuration['common_directftp']['ftp-verzeichnis'], 0, 1) != '/') || (substr($configuration['common_directftp']['ftp-verzeichnis'], strlen($configuration['common_directftp']['ftp-verzeichnis'])-1, 1) != '/')))
{
	$fehler = 'Die Verzeichnissyntax ist falsch. Bitte bearbeiten Sie die <a href="'.$_SERVER['PHP_SELF'].'?modul=common_directftp&amp;seite=config&amp;vonmodul='.$modul.'">Konfigurationswerte</a> und tragen Sie dort korrekte Werte ein.<br><br>M&ouml;gliche Ursache: Verzeichnis zeigt nicht auf Personal WebBase-Verzeichnis oder Datei &quot;moddir.txt&quot; ist nicht mehr vorhanden.';
	$verhindere_loeschen = 1;
}

if (($fehler == '') && ((@ftp_size($conn_id, $configuration['common_directftp']['ftp-verzeichnis'].'designs/'.'desdir.txt') == -1) || (@ftp_size($conn_id, $configuration['common_directftp']['ftp-verzeichnis'].'modules/'.'moddir.txt') == -1)))
{
	$fehler = 'Personal WebBase ben&ouml;tigt FTP-Zugriff auf die Verzeichnisse &quot;design&quot; und &quot;modules&quot;, damit Designs ordnungsgem&auml;&szlig; (de)installiert werden k&ouml;nnen.<br>Bitte bearbeiten Sie die <a href="'.$_SERVER['PHP_SELF'].'?modul=common_directftp&amp;seite=config&amp;vonmodul='.$modul.'">Konfigurationswerte</a> und tragen Sie dort korrekte Werte ein.<br><br>M&ouml;gliche Ursache: Verzeichnis zeigt nicht auf das Personal WebBase-Verzeichnis oder Datei &quot;desdir.txt&quot; bzw. &quot;moddir.txt&quot; ist nicht mehr vorhanden.';
	$verhindere_loeschen = 1;
}

@ftp_quit($conn_id);

echo $header;


echo '<h1>'.htmlentities($module_information->caption).'</h1>';
echo 'Hier k&ouml;nnen Sie die Designs von Personal WebBase verwalten.<br><br>';

wb_draw_table_begin();
wb_draw_table_content('', '<b>Verzeichnisname</b>', '', '<b>Designname</b>', '', '<b>Autor</b>', '', '<b>Version</b>', '', '<b>Lizenztyp</b>', '', '<b>Aktionen</b>');

$handle = @opendir('designs/');
while ($file = @readdir($handle))
{
	if ((filetype('designs/'.$file) == 'dir') && ($file <> '.') && ($file <> '..'))
	{
		$design_information = WBDesignHandler::get_design_information($file);

		if ($design_information->license == '1')
			$design_information->license = 'Offizielles Produkt';
		else if ($design_information->license == '0')
			$design_information->license = 'Drittanbieter-Produkt';
		else
			$design_information->license = 'Unbekannt';

		if (isset($verhindere_loeschen) && ($verhindere_loeschen != ''))
			$aktionen = '<span class="grey">Entfernen</span>';
		else
			$aktionen = '<a href="javascript:abfrage(\''.$_SERVER['PHP_SELF'].'?seite=operate&amp;modul='.$modul.'&amp;aktion=delete&amp;entfernen='.$file.'\');" class="menu">Entfernen</a>';

		if ($configuration['admin_designs']['design'] == $file)
		{
			$a1 = '<b>';
			$b1 = '</b>';
		}
		else
		{
			$a1 = '';
			$b1 = '';
		}

		wb_draw_table_content('', $a1.htmlentities($file).$b1, '', $a1.htmlentities($design_information->name).$b1, '', $a1.htmlentities($design_information->author).$b1, '', $a1.$design_information->version.$b1, '', $a1.$design_information->license.$b1, '', $a1.$aktionen.$b1);
	}
}
closedir($handle);

wb_draw_table_end();

echo '<a href="'.$_SERVER['PHP_SELF'].'?seite=config&amp;modul='.$modul.'&amp;vonmodul='.$modul.'&amp;vonseite='.$seite.'">Aktuelles Design &auml;ndern</a><br><br>';

echo '<b>Design installieren</b><br><br>';

if ($fehler != '')
	echo '<span class="red">'.$fehler.'</span>';
else
	echo 'Achtung: Personal WebBase &uuml;berl&auml;sst den Designs die komplette Handlungsfreiheit bez&uuml;glich der Datenbank und der PHP-Codeausf&uuml;hrung. Ein Design kann bei dem Installationsprozess b&ouml;sartigen Code ausf&uuml;hren und das System oder den Datenbestand gef&auml;hrden. Installieren Sie daher nur Designs, bei denen Sie sicherstellen k&ouml;nnen, dass sie keinen b&ouml;sartigen Code enthalten. Maximale Dateigr&ouml;&szlig;e: '.ini_get('post_max_size').'B<br><br>

<form enctype="multipart/form-data" action="'.$_SERVER['PHP_SELF'].'" method="POST">
<input type="hidden" name="seite" value="operate">
<input type="hidden" name="modul" value="'.$modul.'">
<input type="hidden" name="aktion" value="install">
<input type="hidden" name="MAX_FILE_SIZE" value="'.return_bytes(ini_get('post_max_size')).'">

<input name="dfile" type="file"><br><br>

<input type="submit" class="button" onmouseover="this.className=\'button_act\';" onmouseout="this.className=\'button\';" value="Design installieren">
</form><a href="'.deferer('http://www.personal-webbase.de/designs.html').'" target="_blank">Weitere Designs im offiziellen Personal WebBase-Portal</a>';

echo $footer;

?>