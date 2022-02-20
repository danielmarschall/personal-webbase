<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

function ftp_rmdir_rec($handle, $path)
{
   if (!@ftp_delete($handle, $path))
   {
       $list = @ftp_nlist($handle, $path);
       if(!empty($list))
           foreach($list as $value)
               ftp_rmdir_rec($handle, $value);
   }

   if(@ftp_rmdir($handle, $path))
       return true;
   else
       return false;
}

  // Funktioniert FTP-Zugang?

if ($konfiguration['core_directftp']['ftp-server'] == '') {
	$conn_id = null;
	$login_result = false;
} else {
  $conn_id = @ftp_connect($konfiguration['core_directftp']['ftp-server'], $konfiguration['core_directftp']['ftp-port']);
  $login_result = @ftp_login ($conn_id, $konfiguration['core_directftp']['ftp-username'], $konfiguration['core_directftp']['ftp-passwort']);
}

  $fehler = 0;

  if ((!$conn_id) || (!$login_result))
    $fehler = 1;

  if ((@ftp_size($conn_id, $konfiguration['core_directftp']['ftp-verzeichnis'].'modules/moddir.txt') == -1) || (substr($konfiguration['core_directftp']['ftp-verzeichnis'], 0, 1) != '/') || (substr($konfiguration['core_directftp']['ftp-verzeichnis'], strlen($konfiguration['core_directftp']['ftp-verzeichnis'])-1, 1) != '/'))
    $fehler = 1;

  if ($fehler)
    die($header.'<b>Fehler</b><br><br>Fehlkonfiguration im FTP-Direktzugriff-Kernmodul! FTP-Zugangsdaten oder -Verzeichnis fehlerhaft bzw. zu geringe Zugriffsrechte! Bitte <a href="'.$_SERVER['PHP_SELF'].'?modul=core_directftp&amp;seite=konfig&amp;vonmodul='.$modul.'">Konfigurationswerte</a> einsehen.<br><br><a href="'.$_SERVER['PHP_SELF'].'?seite=inhalt&amp;modul='.$modul.'">Zur&uuml;ck</a>'.$footer);

  // Los gehts!

  if ($aktion == 'delete')
  {
    // Achtung! Ein Hacker könnte ../ als Modul angeben und somit das komplette Modulverzeichnis oder mehr rekursiv löschen!
    if (strpos($modul, '..'))
      die($header.'<b>Fehler</b><br><br>Der L&ouml;schvorgang wurde aufgrund einer Schutzverletzung abgebrochen!<br><br><a href="'.$_SERVER['PHP_SELF'].'?seite=inhalt&amp;modul='.$modul.'">Zur&uuml;ck</a>'.$footer);

    // Nun Modul über FTP löschen!
    @ftp_rmdir_rec($conn_id, $konfiguration['core_directftp']['ftp-verzeichnis'].'modules/'.$entfernen);
    if ($conn_id) @ftp_quit($conn_id);

    // Info: MySQL-Daten löschen sich über Autostart automatisch
    if (!headers_sent()) header('location: '.$_SERVER['PHP_SELF'].'?seite=inhalt&modul='.$modul);
  }

  if ($aktion == 'install')
  {
	  // Temp-Verzeichnisnamen finden
      $uid = 'temp_'.zufall(10);

      // Datei in unser Verzeichnis kopieren, sodass wir darauf zugreifen können (für Safe-Mode)
      if (!@ftp_put($conn_id, $konfiguration['core_directftp']['ftp-verzeichnis'].'modules/'.$modul.'/temp/'.$uid.'.zip', $_FILES['dfile']['tmp_name'], FTP_BINARY))
      {
        if ($conn_id) @ftp_quit($conn_id);
        die($header.'<b>Fehler</b><br><br>Konnte ZIP-Datei nicht in tempor&auml;res Verzeichnis des Modules hineinkopieren (FTP)!.<br><br><a href="'.$_SERVER['PHP_SELF'].'?seite=inhalt&amp;modul='.$modul.'">Zur&uuml;ck</a>'.$footer);
      }
      @ftp_site($conn_id, 'CHMOD 0644 '.$konfiguration['core_directftp']['ftp-verzeichnis'].'modules/'.$modul.'/temp/'.$uid.'.zip');

      // Temporäres Verzeichnis für Extraktion erstellen
      @ftp_rmdir_rec($conn_id, $konfiguration['core_directftp']['ftp-verzeichnis'].'modules/'.$modul.'/temp/'.$uid.'/');
      @ftp_mkdir($conn_id, $konfiguration['core_directftp']['ftp-verzeichnis'].'modules/'.$modul.'/temp/'.$uid.'/');
      @ftp_site($conn_id, 'CHMOD 0755 '.$konfiguration['core_directftp']['ftp-verzeichnis'].'modules/'.$modul.'/temp/'.$uid.'/');

      // Entpacken zum Personal WebBase-Temp-Verzeichnis
      if (file_exists('modules/'.$modul.'/dUnzip2.inc.php'))
        include('modules/'.$modul.'/dUnzip2.inc.php');
	  $zip = new dUnzip2('modules/'.$modul.'/temp/'.$uid.'.zip');
      $zip->unzipAll('modules/'.$modul.'/temp/'.$uid.'/', '', true);
      $zip->close();

	  // Temporäre Daten löschen
	  @ftp_delete($conn_id, $konfiguration['core_directftp']['ftp-verzeichnis'].'modules/'.$modul.'/temp/'.$uid.'.zip');

      // Wenn Verzeichnis leer ist, lässt es sich löschen. -> Fehler
      $verzinh = @ftp_nlist($conn_id, $konfiguration['core_directftp']['ftp-verzeichnis'].'modules/'.$modul.'/temp/'.$uid.'/');
      if (count($verzinh) == 0)
      {
        @ftp_rmdir_rec($conn_id, $konfiguration['core_directftp']['ftp-verzeichnis'].'modules/'.$modul.'/temp/'.$uid.'/');
        if ($conn_id) @ftp_quit($conn_id);
        die($header.'<b>Fehler</b><br><br>Dekompression entweder komplett misslungen oder ZIP-Datei war leer.<br><br><a href="'.$_SERVER['PHP_SELF'].'?seite=inhalt&amp;modul='.$modul.'">Zur&uuml;ck</a>'.$footer);
      }

	  // Verzeichnis verschieben
	  if (!@ftp_rename($conn_id, $konfiguration['core_directftp']['ftp-verzeichnis'].'modules/'.$modul.'/temp/'.$uid.'/', $konfiguration['core_directftp']['ftp-verzeichnis'].'modules/'.$uid.'/'))
	  {
        @ftp_rmdir_rec($conn_id, $konfiguration['core_directftp']['ftp-verzeichnis'].'modules/'.$modul.'/temp/'.$uid.'/');
        if ($conn_id) @ftp_quit($conn_id);
        die($header.'<b>Fehler</b><br><br>Das Verschieben des Verzeichnisses ist misslungen!<br><br><a href="'.$_SERVER['PHP_SELF'].'?seite=inhalt&amp;modul='.$modul.'">Zur&uuml;ck</a>'.$footer);
	  }

	  // Richtigen Dateinamen finden
	  $fn = 'modules/'.$uid.'/ordnername.txt';
	  $fp = @fopen($fn, 'r');
	  $inhalt = @fread($fp, @filesize($fn));
      @fclose($fp);

      // Datei ordnername.txt im Zielmodul löschen
      @ftp_delete ($conn_id, $konfiguration['core_directftp']['ftp-verzeichnis'].'modules/'.$uid.'/ordnername.txt');

      if ($inhalt != '')
      {
        // Schutzverletzung im Ordnernamen?
        if (strpos($inhalt, '..'))
        {
          if ($conn_id) @ftp_quit($conn_id);
          die($header.'<b>Fehler</b><br><br>Das Modul konnte zwar installiert werden, jedoch gab es bei der Umbenennung des Ordners eine Schutzverletzung!<br><br><a href="'.$_SERVER['PHP_SELF'].'?seite=inhalt&amp;modul='.$modul.'">Zur&uuml;ck</a>'.$footer);
        }

        // Gibt es schon ein Modul mit dem Titel? Dann Alternativenamen finden
        if (@ftp_chdir($conn_id, $konfiguration['core_directftp']['ftp-verzeichnis'].'modules/'.$inhalt.'/'))
        {
          @ftp_cdup($conn_id);
          $zusatz = 2;
          $problem = true;
          while (@ftp_chdir($conn_id, $konfiguration['core_directftp']['ftp-verzeichnis'].'modules/'.$inhalt.$zusatz.'/'))
          {
            @ftp_cdup($conn_id);
            $zusatz++;
          }
        }
        else
        {
          $problem = false;
          $zusatz = '';
        }

        // Ordner umbenennen
        $erfolg = @ftp_rename ($conn_id, $konfiguration['core_directftp']['ftp-verzeichnis'].'modules/'.$uid, $konfiguration['core_directftp']['ftp-verzeichnis'].'modules/'.$inhalt.$zusatz);

        // FTP-Verbindung trennen
        if ($conn_id) @ftp_quit($conn_id);

        // Wurde der Ordner nicht umbenannt? (z.B. Wenn der Ordnertitel nicht für Dateisystem zulässig war)
        if (!$erfolg)
          die($header.'<b>Information</b><br><br>Das Modul konnte zwar installiert werden, jedoch gab es bei der Umbenennung des Ordners einen Fehler!<br><br><a href="'.$_SERVER['PHP_SELF'].'?seite=inhalt&amp;modul='.$modul.'">Zur&uuml;ck</a>'.$footer);

        // Wurde nur der Ordner nicht korrekt umbenannt? (z.B. wenn es ein Modul mit dem selben Namen noch gibt)
        if ($problem)
          die($header.'<b>Information</b><br><br>Es existiert bereits ein Modul mit dem Namen &quot;'.$inhalt.'&quot;. Das Modul wurde trotzdem unter dem alternativen Namen &quot;'.$inhalt.$zusatz.'&quot; installiert.<br><br><a href="'.$_SERVER['PHP_SELF'].'?seite=inhalt&amp;modul='.$modul.'">Zur&uuml;ck</a>'.$footer);
      }
      else
      {
        // Kein Dateiname angegeben?
        if ($conn_id) @ftp_quit($conn_id);
        die($header.'<b>Information</b><br><br>Das Modul wurde unter dem Namen &quot;'.$uid.'&quot; angelegt, da in der Moduldatei keine Namensangabe vorhanden war.<br><br><a href="'.$_SERVER['PHP_SELF'].'?seite=inhalt&amp;modul='.$modul.'">Zur&uuml;ck</a>'.$footer);
      }

      // Alles OK? Dann zurück!
      if (!headers_sent()) header('location: '.$_SERVER['PHP_SELF'].'?seite=inhalt&modul='.$modul);
  }

?>
