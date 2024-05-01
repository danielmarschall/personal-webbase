<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

function ftp_rmdir_rec($handle, $path)
{
	if (!@ftp_delete($handle, $path))
	{
		$list = @ftp_nlist($handle, $path);
		if(!empty($list))
			foreach($list as $value) {
				 ftp_rmdir_rec($handle, $value);
			}
		}
	}

	if (@ftp_rmdir($handle, $path)) {
		return true;
	} else
		return false;
	}
}

if (($aktion == 'delete') || ($aktion == 'install'))
{
	// Funktioniert FTP-Zugang?

	$conn_id = @ftp_connect($configuration['common_directftp']['ftp-server'], $configuration['common_directftp']['ftp-port']);
	$login_result = @ftp_login ($conn_id, $configuration['common_directftp']['ftp-username'], $configuration['common_directftp']['ftp-password']);

	$fehler = 0;

	if ((!$conn_id) || (!$login_result))
		$fehler = 1;

	if ((@ftp_size($conn_id, $configuration['common_directftp']['ftp-verzeichnis'].'designs/'.'desdir.txt') == -1) || (@ftp_size($conn_id, $configuration['common_directftp']['ftp-verzeichnis'].'modules/'.'moddir.txt') == -1) || (substr($configuration['common_directftp']['ftp-verzeichnis'], 0, 1) != '/') || (substr($configuration['common_directftp']['ftp-verzeichnis'], strlen($configuration['common_directftp']['ftp-verzeichnis'])-1, 1) != '/'))
		$fehler = 1;

	if ($fehler)
		die($header.'<b>Fehler</b><br><br>Fehlkonfiguration im FTP-Direktzugriff-Kernmodul! FTP-Zugangsdaten oder -Verzeichnis fehlerhaft bzw. zu geringe Zugriffsrechte! Bitte <a href="'.$_SERVER['PHP_SELF'].'?modul=common_directftp&amp;seite=config&amp;vonmodul='.$modul.'">Konfigurationswerte</a> einsehen.<br><br><a href="'.$_SERVER['PHP_SELF'].'?seite=main&amp;modul='.$modul.'">Zur&uuml;ck</a>'.$footer);
}

// Los gehts!

if ($aktion == 'delete')
{
	// Achtung! Ein Hacker könnte ../ als Design angeben und somit das komplette Designverzeichnis oder mehr rekursiv löschen!
	if (strpos($modul, '..'))
		die($header.'<b>Fehler</b><br><br>Der L&ouml;schvorgang wurde aufgrund einer Schutzverletzung abgebrochen!<br><br><a href="'.$_SERVER['PHP_SELF'].'?seite=main&amp;modul='.$modul.'">Zur&uuml;ck</a>'.$footer);

	// Nun Design über FTP löschen!
	@ftp_rmdir_rec($conn_id, $configuration['common_directftp']['ftp-verzeichnis'].'designs/'.$entfernen);
	@ftp_quit($conn_id);

	// Info: MySQL-Daten löschen sich über Autostart automatisch
	wb_redirect_now($_SERVER['PHP_SELF'].'?seite=main&modul='.$modul);
}

if ($aktion == 'install')
{
		// Temp-Verzeichnisnamen finden
		$uid = 'temp_'.zufall(10);

		// Datei in unser Verzeichnis kopieren, sodass wir darauf zugreifen können (für Safe-Mode)
		if (!@ftp_put($conn_id, $configuration['common_directftp']['ftp-verzeichnis'].'modules/'.$modul.'/temp/'.$uid.'.zip', $_FILES['dfile']['tmp_name'], FTP_BINARY))
		{
			@ftp_quit($conn_id);
			die($header.'<b>Fehler</b><br><br>Konnte ZIP-Datei nicht in tempor&auml;res Verzeichnis des Modules hineinkopieren (FTP)!.<br><br><a href="'.$_SERVER['PHP_SELF'].'?seite=main&amp;modul='.$modul.'">Zur&uuml;ck</a>'.$footer);
		}
		@ftp_site($conn_id, 'CHMOD 0644 '.$configuration['common_directftp']['ftp-verzeichnis'].'modules/'.$modul.'/temp/'.$uid.'.zip');

		// Temporäres Verzeichnis für Extraktion erstellen
		@ftp_rmdir_rec($conn_id, $configuration['common_directftp']['ftp-verzeichnis'].'modules/'.$modul.'/temp/'.$uid.'/');
		@ftp_mkdir($conn_id, $configuration['common_directftp']['ftp-verzeichnis'].'modules/'.$modul.'/temp/'.$uid.'/');
		@ftp_site($conn_id, 'CHMOD 0755 '.$configuration['common_directftp']['ftp-verzeichnis'].'modules/'.$modul.'/temp/'.$uid.'/');

		// Entpacken zum Personal WebBase-Temp-Verzeichnis
		if (file_exists('modules/'.$modul.'/includes/dunzip2.inc.php'))
			include('modules/'.$modul.'/includes/dunzip2.inc.php');
		$zip = new dUnzip2('modules/'.$modul.'/temp/'.$uid.'.zip');
		$zip->unzipAll('modules/'.$modul.'/temp/'.$uid.'/', '', true);
		$zip->close();

		// Temporäre Daten löschen
		@ftp_delete($conn_id, $configuration['common_directftp']['ftp-verzeichnis'].'modules/'.$modul.'/temp/'.$uid.'.zip');

		// Wenn Verzeichnis leer ist, lässt es sich löschen. -> Fehler
		$verzinh = @ftp_nlist($conn_id, $configuration['common_directftp']['ftp-verzeichnis'].'modules/'.$modul.'/temp/'.$uid.'/');
		if (count($verzinh) == 0)
		{
			@ftp_rmdir_rec($conn_id, $configuration['common_directftp']['ftp-verzeichnis'].'modules/'.$modul.'/temp/'.$uid.'/');
			@ftp_quit($conn_id);
			die($header.'<b>Fehler</b><br><br>Dekompression entweder komplett misslungen oder ZIP-Datei war leer.<br><br><a href="'.$_SERVER['PHP_SELF'].'?seite=main&amp;modul='.$modul.'">Zur&uuml;ck</a>'.$footer);
		}

		// Verzeichnis verschieben
		if (!@ftp_rename($conn_id, $configuration['common_directftp']['ftp-verzeichnis'].'modules/'.$modul.'/temp/'.$uid.'/', $configuration['common_directftp']['ftp-verzeichnis'].'designs/'.$uid.'/'))
		{
			@ftp_rmdir_rec($conn_id, $configuration['common_directftp']['ftp-verzeichnis'].'modules/'.$modul.'/temp/'.$uid.'/');
			@ftp_quit($conn_id);
			die($header.'<b>Fehler</b><br><br>Das Verschieben des Verzeichnisses ist misslungen!<br><br><a href="'.$_SERVER['PHP_SELF'].'?seite=main&amp;modul='.$modul.'">Zur&uuml;ck</a>'.$footer);
		}

		// Richtigen Dateinamen finden
		$fn = 'designs/'.$uid.'/folder_name.txt';
		$fp = @fopen($fn, 'r');
		$inhalt = @fread($fp, @filesize($fn));
		@fclose($fp);

		// Datei folder_name.txt im Zielmodul löschen
		@ftp_delete ($conn_id, $configuration['common_directftp']['ftp-verzeichnis'].'designs/'.$uid.'/folder_name.txt');

		if ($inhalt != '')
		{
			// Schutzverletzung im folder_namen?
			if (strpos($inhalt, '..'))
			{
				@ftp_quit($conn_id);
				die($header.'<b>Fehler</b><br><br>Das Design konnte zwar installiert werden, jedoch gab es bei der Umbenennung des Ordners eine Schutzverletzung!'.$footer);
			}

			// Gibt es schon ein Design mit dem Titel? Dann Alternativenamen finden
			if (@ftp_chdir($conn_id, $configuration['common_directftp']['ftp-verzeichnis'].'designs/'.$inhalt.'/'))
			{
				@ftp_cdup($conn_id);
				$zusatz = 2;
				$problem = true;
				while (@ftp_chdir($conn_id, $configuration['common_directftp']['ftp-verzeichnis'].'designs/'.$inhalt.$zusatz.'/'))
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
			$erfolg = @ftp_rename ($conn_id, $configuration['common_directftp']['ftp-verzeichnis'].'designs/'.$uid, $configuration['common_directftp']['ftp-verzeichnis'].'designs/'.$inhalt.$zusatz);

			// FTP-Verbindung trennen
			@ftp_quit($conn_id);

			// Wurde der Ordner nicht umbenannt? (z.B. Wenn der Ordnertitel nicht für Dateisystem zulässig war)
			if (!$erfolg)
				die($header.'<b>Information</b><br><br>Das Design konnte zwar installiert werden, jedoch gab es bei der Umbenennung des Ordners einen Fehler!<br><br><a href="'.$_SERVER['PHP_SELF'].'?seite=main&amp;modul='.$modul.'">Zur&uuml;ck</a>'.$footer);

			// Wurde nur der Ordner nicht korrekt umbenannt? (z.B. wenn es ein Design mit dem selben Namen noch gibt)
			if ($problem)
				die($header.'<b>Information</b><br><br>Es existiert bereits ein Design mit dem Namen &quot;'.$inhalt.'&quot;. Das Design wurde trotzdem unter dem alternativen Namen &quot;'.$inhalt.$zusatz.'&quot; installiert.<br><br><a href="'.$_SERVER['PHP_SELF'].'?seite=main&amp;modul='.$modul.'">Zur&uuml;ck</a>'.$footer);
		}
		else
		{
			// Kein Dateiname angegeben?
			@ftp_quit($conn_id);
			die($header.'<b>Information</b><br><br>Das Design wurde unter dem Namen &quot;'.$uid.'&quot; angelegt, da in der Designdatei keine Namensangabe vorhanden war.<br><br><a href="'.$_SERVER['PHP_SELF'].'?seite=main&amp;modul='.$modul.'">Zur&uuml;ck</a>'.$footer);
		}

		// Alles OK? Dann zurück!
		wb_redirect_now($_SERVER['PHP_SELF'].'?seite=main&modul='.$modul);
}

if ($aktion == 'change_configuration')
{
	wb_change_config('design', $newdesign, $modul);
	echo '<script language="JavaScript" type="text/javascript">
		<!--

		parent.location.href = \'index.php?prv_modul='.$vonmodul.'&prv_seite='.$vonseite.'\';

		// -->
</script>';

	// Funktioniert nicht für eine Designänderung: wb_redirect_now($_SERVER['PHP_SELF'].'?seite=main&modul=admin_configuration');
}

?>