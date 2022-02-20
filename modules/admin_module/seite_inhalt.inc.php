<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne IronBASE ausgef&uuml;hrt werden.');

// Funktioniert FTP-Zugang?

$conn_id = @ftp_connect($konfiguration['core_directftp']['ftp-server'], $konfiguration['core_directftp']['ftp-port']);
$login_result = @ftp_login ($conn_id, $konfiguration['core_directftp']['ftp-username'], $konfiguration['core_directftp']['ftp-passwort']);

$fehler = '';

if ((!$conn_id) || (!$login_result))
{
  $fehler = 'IronBASE ben&ouml;tigt FTP-Zugriff auf das Verzeichnis &quot;modules&quot;, damit Module ordnungsgem&auml;&szlig; (de)installiert werden k&ouml;nnen.<br>Bitte bearbeiten Sie die <a href="'.$_SERVER['PHP_SELF'].'?modul=core_directftp&amp;seite=konfig&amp;vonmodul='.$modul.'">Konfigurationswerte</a> und tragen Sie dort korrekte Werte ein.<br><br>M&ouml;gliche Ursache: Server/Benutzername/Passwort falsch.';
  $verhindere_loeschen = 1;
}

if (($fehler == '') && ((substr($konfiguration['core_directftp']['ftp-verzeichnis'], 0, 1) != '/') || (substr($konfiguration['core_directftp']['ftp-verzeichnis'], strlen($konfiguration['core_directftp']['ftp-verzeichnis'])-1, 1) != '/')))
{
  $fehler = 'Die Verzeichnissyntax ist falsch. Bitte bearbeiten Sie die <a href="'.$_SERVER['PHP_SELF'].'?modul=core_directftp&amp;seite=konfig&amp;vonmodul='.$modul.'">Konfigurationswerte</a> und tragen Sie dort korrekte Werte ein.<br><br>M&ouml;gliche Ursache: Verzeichnis zeigt nicht auf IronBASE-Verzeichnis oder Datei &quot;moddir.txt&quot; ist nicht mehr vorhanden.';
  $verhindere_loeschen = 1;
}

if (($fehler == '') && (@ftp_size($conn_id, $konfiguration['core_directftp']['ftp-verzeichnis'].'modules/moddir.txt') == -1))
{
  $fehler = 'IronBASE ben&ouml;tigt FTP-Zugriff auf das Verzeichnis &quot;modules&quot;, damit Module ordnungsgem&auml;&szlig; (de)installiert werden k&ouml;nnen.<br>Bitte bearbeiten Sie die <a href="'.$_SERVER['PHP_SELF'].'?modul=core_directftp&amp;seite=konfig&amp;vonmodul='.$modul.'">Konfigurationswerte</a> und tragen Sie dort korrekte Werte ein.<br><br>M&ouml;gliche Ursache: Verzeichnis zeigt nicht auf IronBASE-Verzeichnis oder Datei &quot;moddir.txt&quot; ist nicht mehr vorhanden.';
  $verhindere_loeschen = 1;
}

@ftp_quit($conn_id);

  echo $header;

if ($modulueberschrift == '') $modulueberschrift = $modul;
echo '<h1>'.htmlentities($modulueberschrift).'</h1>';
    echo 'Hier k&ouml;nnen Sie die Module von IronBASE verwalten. Ist ein Modul nicht
    korrekt geschrieben worden, so k&ouml;nnen trotz Deinstallation des Moduls noch Datenbest&auml;nde in der
    Datenbank zur&uuml;ckbleiben. Wenn das Modul als &quot;IronBASE-Core&quot; eingestuft wurde, dann
    ist der Autor des Moduls der Meinung, dass es wichtig f&uuml;r die Ausf&uuml;hrung von IronBASE oder anderen
    Modulen verantwortlich ist. Entfernen Sie ein solches Modul, so kann IronBASE besch&auml;digt und Kundendaten
    verloren gehen! In dem Feld &quot;Daten&quot; k&ouml;nnen Sie sehen, wie viele IronBASE-Konfigurationswerte (C) und wie viele
    MySQL-Tabellen (T) das jeweilige Modul benutzt.<br><br>';

    gfx_begintable();
    gfx_tablecontent('', '<b>Verzeichnisname</b>', '', '<b>Modulname</b>', '', '<b>Autor</b>', '', '<b>Lizenztyp</b>', '', '<b>Sichtbar</b>', '', '<b>Version</b>', '', '<b>Daten</b>', '', '<b>Aktionen</b>');
    foreach ($module as $m1 => $m2)
    {
      $res = db_query("SELECT COUNT(*) AS `cid` FROM `".$mysql_zugangsdaten['praefix']."konfig` WHERE `modul` = '".db_escape($m2)."'");
      $row = db_fetch($res);
      $cdaten = $row['cid'];

      $res = db_query("SELECT COUNT(*) AS `cid` FROM `".$mysql_zugangsdaten['praefix']."module` WHERE `modul` = '".db_escape($m2)."'");
      $row = db_fetch($res);
      $mdaten = $row['cid'];

      $modulueberschrift = '';
      $modulsekpos = '';
      $modulpos = '';
      $modulrechte = '';
 	  $autor = '';
      $version = '';
      $menuevisible = '';
      $license = '';
      $deaktiviere_zugangspruefung = 0;

      if (file_exists('modules/'.$m2.'/var.inc.php'))
        include 'modules/'.$m2.'/var.inc.php';
      if ($modulueberschrift == '') $modulueberschrift = 'Unbekannt';
      if ($autor == '') $autor = 'Unbekannt';
      if ($version == '') $version = 'Unbekannt';
      if ($menuevisible == '0')
        $menuevisible = 'Nein';
      else if ($menuevisible == '1')
        $menuevisible = 'Ja';
      else
        $menuevisible = 'Unbekannt';
      if ($license == '0')
        $license = 'Public Freeware';
      else if ($license == '1')
        $license = 'Public Shareware';
      else if ($license == '2')
        $license = 'Private Secured';
      else if ($license == '3')
        $license = 'IronBASE-Core';
      else if ($license == '4')
        $license = 'IronBASE-Enclosure';
      else
        $license = 'Unbekannt';
      $ca = ($cdaten == 0) ? '' : '<a href="'.$_SERVER['PHP_SELF'].'?modul=admin_konfig&amp;seite=konfig&amp;only='.$m2.'&amp;vonmodul='.$modul.'&amp;vonseite='.$seite.'" class="menu">';
      $cb = ($cdaten == 0) ? '' : '</a>';
      $ta = ($mdaten == 0) ? '' : '<a href="'.$_SERVER['PHP_SELF'].'?modul=admin_datenbank&amp;seite=inhalt&amp;only='.$m2.'&amp;vonmodul='.$modul.'&amp;vonseite='.$seite.'" class="menu">';
      $tb = ($mdaten == 0) ? '' : '</a>';

      if ((isset($verhindere_loeschen)) && ($verhindere_loeschen != ''))
        $aktionen = '<font color="#888888">Entfernen</font>';
      else
        $aktionen = '<a href="javascript:abfrage(\''.$_SERVER['PHP_SELF'].'?seite=kraftsetzung&amp;modul='.$modul.'&amp;aktion=delete&amp;entfernen='.$m2.'\');" class="menu">Entfernen</a>';

      gfx_tablecontent('', htmlentities($m2), '', htmlentities($modulueberschrift), '', htmlentities($autor), '', $license, '', $menuevisible, '',  htmlentities($version), '', $ca.$cdaten.'C'.$cb.' / '.$ta.$mdaten.'T'.$tb, '', $aktionen);
    }

    unset($m1);
	unset($m2);

    gfx_endtable();
    echo '<b>Modul installieren</b><br><br>';

    if ($fehler != '')
      echo '<font color="#FF0000">'.$fehler.'</font>';
    else
      echo 'Achtung: IronBASE &uuml;berl&auml;sst den Modulen die komplette Handlungsfreiheit bez&uuml;glich der Datenbank und der PHP-Codeausf&uuml;hrung. Ein Modul kann bei dem Installationsprozess b&ouml;sartigen Code ausf&uuml;hren und das System oder den Datenbestand gef&auml;hrden. Installieren Sie daher nur Module, bei denen Sie sicherstellen k&ouml;nnen, dass sie keinen b&ouml;sartigen Code enthalten. Wenn Sie ein Modul updaten m&ouml;chten, deinstallieren Sie die alte Version des Modules zuerst. Maximale Dateigr&ouml;&szlig;e: '.ini_get('post_max_size').'B<br><br>

<form enctype="multipart/form-data" action="'.$_SERVER['PHP_SELF'].'" method="POST">
<input type="hidden" name="seite" value="kraftsetzung">
<input type="hidden" name="modul" value="'.$modul.'">
<input type="hidden" name="aktion" value="install">
<input type="hidden" name="MAX_FILE_SIZE" value="'.return_bytes(ini_get('post_max_size')).'">

<input name="dfile" type="file"><br><br>

<input type="submit" class="button" onmouseover="this.className=\'button_act\';" onmouseout="this.className=\'button\';" value="Modul installieren">
</form><a href="http://www.viathinksoft.de/info/ironbase/module.php" target="_blank">Weitere Module im offiziellen IronBASE-Portal</a>';

      echo $footer;

?>