<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

$meldung = '';

$fehler = false;

		$conn_id = @ftp_connect($configuration[$m2]['ftp-server'], $configuration[$m2]['ftp-port']);
		$login_result = @ftp_login ($conn_id, $configuration[$m2]['ftp-username'], $configuration[$m2]['ftp-password']);

		if ((!$conn_id) || (!$login_result))
		{
			$meldung .= '<span class="red">Die FTP-Zugangsdaten sind falsch! Bitte korrigieren Sie diese.</span>';
			$fehler = true;
		}

		if ((!$fehler) && (substr($configuration[$m2]['ftp-verzeichnis'], strlen($configuration[$m2]['ftp-verzeichnis'])-1, 1) != '/'))
		{
			$meldung .= '<span class="red">Das FTP-Verzeichnis muss einen abschlie&szlig;enden Slash (/) erhalten!</span>';
			$fehler = true;
		}

		if ((!$fehler) && (substr($configuration[$m2]['ftp-verzeichnis'], 0, 1) != '/'))
		{
			$meldung .= '<span class="red">Das FTP-Verzeichnis muss mit einem Slash (/) beginnen!</span>';
			$fehler = true;
		}

		if ((!$fehler) && (@ftp_size($conn_id, $configuration[$m2]['ftp-verzeichnis'].'modules/moddir.txt') == -1))
		{
			$meldung .= '<span class="red">Kann modules/moddir.txt nicht finden. Zeigt das FTP-Verzeichnis wirklich auf Personal WebBase?</span>';
			$fehler = true;
		}

		if ((!$fehler) && (@ftp_size($conn_id, $configuration[$m2]['ftp-verzeichnis'].'designs/desdir.txt') == -1))
		{
			$meldung .= '<span class="red">Kann designs/desdir.txt nicht finden. Zeigt das FTP-Verzeichnis wirklich auf Personal WebBase?</span>';
			$fehler = true;
		}

		if ($fehler)
		{
			$meldung .= '<br><a href="'.oop_link_to_modul($m2, 'config', 'admin_configuration').'">Konfigurationswerte bearbeiten</a>.';
		}
		else
		{
			$meldung .= '<span class="green">Es gibt derzeit kein Problem mit den FTP-Zugangsdaten.</span>';
		}

		@ftp_quit($conn_id);

?>