<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

// Funktioniert FTP-Zugang?

if ($konfiguration['core_directftp']['ftp-server'] == '') {
	$fehler = 'Personal WebBase ben&ouml;tigt FTP-Zugriff auf das Verzeichnis &quot;design&quot;, damit Designs ordnungsgem&auml;&szlig; (de)installiert werden k&ouml;nnen.<br>Bitte bearbeiten Sie die <a href="'.$_SERVER['PHP_SELF'].'?modul=core_directftp&amp;seite=konfig&amp;vonmodul='.urlencode($modul).'">Konfigurationswerte</a> und tragen Sie dort korrekte Werte ein.<br><br>M&ouml;gliche Ursache: Server/Benutzername/Passwort falsch.';
	$verhindere_loeschen = 1;
	$conn_id = null;
	$login_result = false;
} else {
	$conn_id = @ftp_connect($konfiguration['core_directftp']['ftp-server'], $konfiguration['core_directftp']['ftp-port']);
	$login_result = @ftp_login ($conn_id, $konfiguration['core_directftp']['ftp-username'], $konfiguration['core_directftp']['ftp-passwort']);
}

$fehler = '';

if ((!$conn_id) || (!$login_result))
{
  $fehler = 'Personal WebBase ben&ouml;tigt FTP-Zugriff auf das Verzeichnis &quot;design&quot;, damit Designs ordnungsgem&auml;&szlig; (de)installiert werden k&ouml;nnen.<br>Bitte bearbeiten Sie die <a href="'.$_SERVER['PHP_SELF'].'?modul=core_directftp&amp;seite=konfig&amp;vonmodul='.urlencode($modul).'">Konfigurationswerte</a> und tragen Sie dort korrekte Werte ein.<br><br>M&ouml;gliche Ursache: Server/Benutzername/Passwort falsch.';
  $verhindere_loeschen = 1;
}

if (($fehler == '') && ((substr($konfiguration['core_directftp']['ftp-verzeichnis'], 0, 1) != '/') || (substr($konfiguration['core_directftp']['ftp-verzeichnis'], strlen($konfiguration['core_directftp']['ftp-verzeichnis'])-1, 1) != '/')))
{
  $fehler = 'Die Verzeichnissyntax ist falsch. Bitte bearbeiten Sie die <a href="'.$_SERVER['PHP_SELF'].'?modul=core_directftp&amp;seite=konfig&amp;vonmodul='.urlencode($modul).'">Konfigurationswerte</a> und tragen Sie dort korrekte Werte ein.<br><br>M&ouml;gliche Ursache: Verzeichnis zeigt nicht auf Personal WebBase-Verzeichnis oder Datei &quot;moddir.txt&quot; ist nicht mehr vorhanden.';
  $verhindere_loeschen = 1;
}

if (($fehler == '') && ((@ftp_size($conn_id, $konfiguration['core_directftp']['ftp-verzeichnis'].'design/'.'desdir.txt') == -1) || (@ftp_size($conn_id, $konfiguration['core_directftp']['ftp-verzeichnis'].'modules/'.'moddir.txt') == -1)))
{
  $fehler = 'Personal WebBase ben&ouml;tigt FTP-Zugriff auf die Verzeichnisse &quot;design&quot; und &quot;modules&quot;, damit Designs ordnungsgem&auml;&szlig; (de)installiert werden k&ouml;nnen.<br>Bitte bearbeiten Sie die <a href="'.$_SERVER['PHP_SELF'].'?modul=core_directftp&amp;seite=konfig&amp;vonmodul='.urlencode($modul).'">Konfigurationswerte</a> und tragen Sie dort korrekte Werte ein.<br><br>M&ouml;gliche Ursache: Verzeichnis zeigt nicht auf das Personal WebBase-Verzeichnis oder Datei &quot;desdir.txt&quot; bzw. &quot;moddir.txt&quot; ist nicht mehr vorhanden.';
  $verhindere_loeschen = 1;
}

if ($conn_id) @ftp_quit($conn_id);

  echo $header;

if ($modulueberschrift == '') $modulueberschrift = $modul;
    echo '<h1>'.my_htmlentities($modulueberschrift).'</h1>';
    echo 'Hier k&ouml;nnen Sie die Designs von Personal WebBase verwalten.<br><br>';

    wb_draw_table_begin();
    wb_draw_table_content('', '<b>Verzeichnisname</b>', '', '<b>Designname</b>', '', '<b>Autor</b>', '', '<b>Version</b>', '', '<b>Lizenztyp</b>', '', '<b>Aktionen</b>');

    $handle = @opendir('design/');
    while ($file = @readdir($handle))
    {
      if ((($file <> '.') && ($file <> '..') && @filetype('design/'.wb_dir_escape($file)) == 'dir'))
      {
      $name = '';
      $autor = '';
      $version = '';
      $license = '';

      if (file_exists('design/'.wb_dir_escape($file).'/var.inc.php'))
        include 'design/'.wb_dir_escape($file).'/var.inc.php';

      if ($license == '1')
        $license = 'Offizielles Produkt';
      else if ($license == '0')
        $license = 'Drittanbieter-Produkt';
      else
        $license = 'Unbekannt';

      if (isset($verhindere_loeschen) && ($verhindere_loeschen != ''))
        $aktionen = '<font color="#888888">Entfernen</font>';
      else
        $aktionen = '<a href="javascript:abfrage(\''.$_SERVER['PHP_SELF'].'?seite=kraftsetzung&amp;modul='.urlencode($modul).'&amp;aktion=delete&amp;entfernen='.urlencode($file).'\');" class="menu">Entfernen</a>';

      wb_draw_table_content('', my_htmlentities($file), '', my_htmlentities($name), '', my_htmlentities($autor), '', $version, '', $license, '', $aktionen);
      }
    }
    closedir($handle);

    wb_draw_table_end();

    echo '<a href="'.$_SERVER['PHP_SELF'].'?seite=konfig&amp;modul='.urlencode($modul).'&amp;vonmodul='.urlencode($modul).'&amp;vonseite='.urlencode($seite).'">Aktuelles Design &auml;ndern</a><br><br>';

    echo '<b>Design installieren</b><br><br>';

    if ($fehler != '')
      echo '<font color="#FF0000">'.$fehler.'</font>';
    else
      echo 'Achtung: Personal WebBase &uuml;berl&auml;sst den Designs die komplette Handlungsfreiheit bez&uuml;glich der Datenbank und der PHP-Codeausf&uuml;hrung. Ein Design kann bei dem Installationsprozess b&ouml;sartigen Code ausf&uuml;hren und das System oder den Datenbestand gef&auml;hrden. Installieren Sie daher nur Designs, bei denen Sie sicherstellen k&ouml;nnen, dass sie keinen b&ouml;sartigen Code enthalten. Maximale Dateigr&ouml;&szlig;e: '.ini_get('post_max_size').'B<br><br>

<form enctype="multipart/form-data" action="'.$_SERVER['PHP_SELF'].'" method="POST">
<input type="hidden" name="seite" value="kraftsetzung">
<input type="hidden" name="modul" value="'.$modul.'">
<input type="hidden" name="aktion" value="install">
<input type="hidden" name="MAX_FILE_SIZE" value="'.return_bytes(ini_get('post_max_size')).'">

<input name="dfile" type="file"><br><br>

<input type="submit" class="button" onmouseover="this.className=\'button_act\';" onmouseout="this.className=\'button\';" value="Design installieren">
</form><a href="https://www.personal-webbase.de/designs.html" target="_blank">Weitere Designs im offiziellen Personal WebBase-Portal</a>';

      echo $footer;

?>
