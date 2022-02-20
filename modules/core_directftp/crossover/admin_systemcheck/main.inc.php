<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

$meldung = '';

$fehler = false;

	if ($konfiguration[$m2]['ftp-server'] == '')
	{
		$meldung .= '<font color="#FF0000">Die FTP-Zugangsdaten sind falsch! Bitte korrigieren Sie diese.</font>';
		$fehler = true;
		$conn_id = null;
		$login_result = false;
	} else {
		if ($konfiguration[$m2]['ftp-server'] == '') {
			$conn_id = null;
			$login_result = false;
		} else {
			$conn_id = @ftp_connect($konfiguration[$m2]['ftp-server'], $konfiguration[$m2]['ftp-port']);
			$login_result = @ftp_login ($conn_id, $konfiguration[$m2]['ftp-username'], $konfiguration[$m2]['ftp-passwort']);
		}

		if ((!$conn_id) || (!$login_result))
		{
		  $meldung .= '<font color="#FF0000">Die FTP-Zugangsdaten sind falsch! Bitte korrigieren Sie diese.</font>';
		  $fehler = true;
		}
	}

	if ((!$fehler) && (substr($konfiguration[$m2]['ftp-verzeichnis'], strlen($konfiguration[$m2]['ftp-verzeichnis'])-1, 1) != '/'))
	{
	  $meldung .= '<font color="#FF0000">Das FTP-Verzeichnis muss einen abschlie&szlig;enden Slash (/) erhalten!</font>';
	  $fehler = true;
	}

	if ((!$fehler) && (substr($konfiguration[$m2]['ftp-verzeichnis'], 0, 1) != '/'))
	{
	  $meldung .= '<font color="#FF0000">Das FTP-Verzeichnis muss mit einem Slash (/) beginnen!</font>';
	  $fehler = true;
	}

	if ((!$fehler) && (@ftp_size($conn_id, $konfiguration[$m2]['ftp-verzeichnis'].'modules/moddir.txt') == -1))
	{
	  $meldung .= '<font color="#FF0000">Kann modules/moddir.txt nicht finden. Zeigt das FTP-Verzeichnis wirklich auf Personal WebBase?</font>';
	  $fehler = true;
	}

	if ((!$fehler) && (@ftp_size($conn_id, $konfiguration[$m2]['ftp-verzeichnis'].'design/desdir.txt') == -1))
	{
	  $meldung .= '<font color="#FF0000">Kann design/desdir.txt nicht finden. Zeigt das FTP-Verzeichnis wirklich auf Personal WebBase?</font>';
	  $fehler = true;
	}

	if ($fehler)
	{
	  $meldung .= '<br><a href="'.oop_link_to_modul($m2, 'konfig', 'admin_konfig').'">Konfigurationswerte bearbeiten</a>.';
	}
	else
	{
	  $meldung .= '<font color="#00BB00">Es gibt derzeit kein Problem mit den FTP-Zugangsdaten.</font>';
	}

	if ($conn_id) @ftp_quit($conn_id);

?>
