<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

if ($ib_user_type < 2) die('Keine Zugriffsberechtigung');

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

  if (($aktion == 'delete') || ($aktion == 'install'))
  {
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

    if ((@ftp_size($conn_id, $konfiguration['core_directftp']['ftp-verzeichnis'].'design/'.'desdir.txt') == -1) || (@ftp_size($conn_id, $konfiguration['core_directftp']['ftp-verzeichnis'].'modules/'.'moddir.txt') == -1) || (substr($konfiguration['core_directftp']['ftp-verzeichnis'], 0, 1) != '/') || (substr($konfiguration['core_directftp']['ftp-verzeichnis'], strlen($konfiguration['core_directftp']['ftp-verzeichnis'])-1, 1) != '/'))
      $fehler = 1;

    if ($fehler)
      die($header.'<b>Fehler</b><br><br>Fehlkonfiguration im FTP-Direktzugriff-Kernmodul! FTP-Zugangsdaten oder -Verzeichnis fehlerhaft bzw. zu geringe Zugriffsrechte! Bitte <a href="'.$_SERVER['PHP_SELF'].'?modul=core_directftp&amp;seite=konfig&amp;vonmodul='.urlencode($modul).'">Konfigurationswerte</a> einsehen.<br><br><a href="'.$_SERVER['PHP_SELF'].'?seite=inhalt&amp;modul='.urlencode($modul).'">Zur&uuml;ck</a>'.$footer);
  }

  // Los gehts!

  if ($aktion == 'delete')
  {
    // Nun Design �ber FTP l�schen!
    @ftp_rmdir_rec($conn_id, $konfiguration['core_directftp']['ftp-verzeichnis'].'design/'.wb_dir_escape($entfernen));
    if ($conn_id) @ftp_quit($conn_id);

    // Info: MySQL-Daten l�schen sich �ber Autostart automatisch
    if (!headers_sent()) header('location: '.$_SERVER['PHP_SELF'].'?seite=inhalt&modul='.urlencode($modul));
  }

  if ($aktion == 'install')
  {
	  // Temp-Verzeichnisnamen finden
      $uid = 'temp_'.zufall(10);

      // Datei in unser Verzeichnis kopieren, sodass wir darauf zugreifen k�nnen (f�r Safe-Mode)
      if (!@ftp_put($conn_id, $konfiguration['core_directftp']['ftp-verzeichnis'].'modules/'.wb_dir_escape($modul).'/temp/'.wb_dir_escape($uid).'.zip', $_FILES['dfile']['tmp_name'], FTP_BINARY))
      {
        if ($conn_id) @ftp_quit($conn_id);
        die($header.'<b>Fehler</b><br><br>Konnte ZIP-Datei nicht in tempor&auml;res Verzeichnis des Modules hineinkopieren (FTP)!.<br><br><a href="'.$_SERVER['PHP_SELF'].'?seite=inhalt&amp;modul='.urlencode($modul).'">Zur&uuml;ck</a>'.$footer);
      }
      @ftp_site($conn_id, 'CHMOD 0644 '.$konfiguration['core_directftp']['ftp-verzeichnis'].'modules/'.wb_dir_escape($modul).'/temp/'.wb_dir_escape($uid).'.zip');

      // Tempor�res Verzeichnis f�r Extraktion erstellen
      @ftp_rmdir_rec($conn_id, $konfiguration['core_directftp']['ftp-verzeichnis'].'modules/'.wb_dir_escape($modul).'/temp/'.wb_dir_escape($uid).'/');
      @ftp_mkdir($conn_id, $konfiguration['core_directftp']['ftp-verzeichnis'].'modules/'.wb_dir_escape($modul).'/temp/'.wb_dir_escape($uid).'/');
      @ftp_site($conn_id, 'CHMOD 0755 '.$konfiguration['core_directftp']['ftp-verzeichnis'].'modules/'.wb_dir_escape($modul).'/temp/'.wb_dir_escape($uid).'/');

      // Entpacken zum Personal WebBase-Temp-Verzeichnis
      if (file_exists('modules/'.wb_dir_escape($modul).'/dUnzip2.inc.php'))
        include('modules/'.wb_dir_escape($modul).'/dUnzip2.inc.php');
	  $zip = new dUnzip2('modules/'.wb_dir_escape($modul).'/temp/'.wb_dir_escape($uid).'.zip');
      $zip->unzipAll('modules/'.wb_dir_escape($modul).'/temp/'.wb_dir_escape($uid).'/', '', true);
      $zip->close();

	  // Tempor�re Daten l�schen
	  @ftp_delete($conn_id, $konfiguration['core_directftp']['ftp-verzeichnis'].'modules/'.wb_dir_escape($modul).'/temp/'.wb_dir_escape($uid).'.zip');

      // Wenn Verzeichnis leer ist, l�sst es sich l�schen. -> Fehler
      $verzinh = @ftp_nlist($conn_id, $konfiguration['core_directftp']['ftp-verzeichnis'].'modules/'.wb_dir_escape($modul).'/temp/'.wb_dir_escape($uid).'/');
      if (count($verzinh) == 0)
      {
        @ftp_rmdir_rec($conn_id, $konfiguration['core_directftp']['ftp-verzeichnis'].'modules/'.wb_dir_escape($modul).'/temp/'.wb_dir_escape($uid).'/');
        if ($conn_id) @ftp_quit($conn_id);
        die($header.'<b>Fehler</b><br><br>Dekompression entweder komplett misslungen oder ZIP-Datei war leer.<br><br><a href="'.$_SERVER['PHP_SELF'].'?seite=inhalt&amp;modul='.urlencode($modul).'">Zur&uuml;ck</a>'.$footer);
      }

	  // Verzeichnis verschieben
	  if (!@ftp_rename($conn_id, $konfiguration['core_directftp']['ftp-verzeichnis'].'modules/'.wb_dir_escape($modul).'/temp/'.wb_dir_escape($uid).'/', $konfiguration['core_directftp']['ftp-verzeichnis'].'design/'.wb_dir_escape($uid).'/'))
	  {
        @ftp_rmdir_rec($conn_id, $konfiguration['core_directftp']['ftp-verzeichnis'].'modules/'.wb_dir_escape($modul).'/temp/'.wb_dir_escape($uid).'/');
        if ($conn_id) @ftp_quit($conn_id);
        die($header.'<b>Fehler</b><br><br>Das Verschieben des Verzeichnisses ist misslungen!<br><br><a href="'.$_SERVER['PHP_SELF'].'?seite=inhalt&amp;modul='.urlencode($modul).'">Zur&uuml;ck</a>'.$footer);
	  }

	  // Richtigen Dateinamen finden
	  $fn = 'design/'.wb_dir_escape($uid).'/ordnername.txt';
	  $fp = @fopen($fn, 'r');
	  $inhalt = @fread($fp, @filesize($fn));
      @fclose($fp);

      // Datei ordnername.txt im Zielmodul l�schen
      @ftp_delete ($conn_id, $konfiguration['core_directftp']['ftp-verzeichnis'].'design/'.wb_dir_escape($uid).'/ordnername.txt');

      if ($inhalt != '')
      {
        // Schutzverletzung im Ordnernamen?
        if (strpos($inhalt, '..'))
        {
          if ($conn_id) @ftp_quit($conn_id);
          die($header.'<b>Fehler</b><br><br>Das Design konnte zwar installiert werden, jedoch gab es bei der Umbenennung des Ordners eine Schutzverletzung!'.$footer);
        }

        // Gibt es schon ein Design mit dem Titel? Dann Alternativenamen finden
        if (@ftp_chdir($conn_id, $konfiguration['core_directftp']['ftp-verzeichnis'].'design/'.wb_dir_escape($inhalt).'/'))
        {
          @ftp_cdup($conn_id);
          $zusatz = 2;
          $problem = true;
          while (@ftp_chdir($conn_id, $konfiguration['core_directftp']['ftp-verzeichnis'].'design/'.wb_dir_escape($inhalt).$zusatz.'/'))
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
        $erfolg = @ftp_rename ($conn_id, $konfiguration['core_directftp']['ftp-verzeichnis'].'design/'.wb_dir_escape($uid), $konfiguration['core_directftp']['ftp-verzeichnis'].'design/'.wb_dir_escape($inhalt).$zusatz);

        // FTP-Verbindung trennen
        if ($conn_id) @ftp_quit($conn_id);

        // Wurde der Ordner nicht umbenannt? (z.B. Wenn der Ordnertitel nicht f�r Dateisystem zul�ssig war)
        if (!$erfolg)
          die($header.'<b>Information</b><br><br>Das Design konnte zwar installiert werden, jedoch gab es bei der Umbenennung des Ordners einen Fehler!<br><br><a href="'.$_SERVER['PHP_SELF'].'?seite=inhalt&amp;modul='.urlencode($modul).'">Zur&uuml;ck</a>'.$footer);

        // Wurde nur der Ordner nicht korrekt umbenannt? (z.B. wenn es ein Design mit dem selben Namen noch gibt)
        if ($problem)
          die($header.'<b>Information</b><br><br>Es existiert bereits ein Design mit dem Namen &quot;'.$inhalt.'&quot;. Das Design wurde trotzdem unter dem alternativen Namen &quot;'.$inhalt.$zusatz.'&quot; installiert.<br><br><a href="'.$_SERVER['PHP_SELF'].'?seite=inhalt&amp;modul='.urlencode($modul).'">Zur&uuml;ck</a>'.$footer);
      }
      else
      {
        // Kein Dateiname angegeben?
        if ($conn_id) @ftp_quit($conn_id);
        die($header.'<b>Information</b><br><br>Das Design wurde unter dem Namen &quot;'.$uid.'&quot; angelegt, da in der Designdatei keine Namensangabe vorhanden war.<br><br><a href="'.$_SERVER['PHP_SELF'].'?seite=inhalt&amp;modul='.urlencode($modul).'">Zur&uuml;ck</a>'.$footer);
      }

      // Alles OK? Dann zur�ck!
      if (!headers_sent()) header('location: '.$_SERVER['PHP_SELF'].'?seite=inhalt&modul='.urlencode($modul));
  }

  if ($aktion == 'changekonfig')
  {
    ib_change_config('design', $newdesign, $modul);
    echo '<script language="JavaScript" type="text/javascript">
	  <!--

	  parent.location.href = \'index.php?prv_modul='.urlencode($vonmodul).'&prv_seite='.urlencode($vonseite).'\';

	  // -->
  </script>';

    // Funktioniert nicht f�r eine Design�nderung: if (!headers_sent()) header('location: '.$_SERVER['PHP_SELF'].'?seite=inhalt&modul=admin_konfig');
  }

?>
