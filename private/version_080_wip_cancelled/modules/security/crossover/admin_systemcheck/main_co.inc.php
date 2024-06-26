<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

$meldung = '';

// -------------------------------------

if (!ini_get('safe_mode'))
	$meldung .= '- PHP sollte mit Safe_Mode ausgef&uuml;hrt werden.<br>';

// -------------------------------------

$ok = true;
if ($configuration['common_directftp']['ftp-verzeichnis'] != '/')
{
	if ($configuration['common_directftp']['ftp-verzeichnis'] == '/html/')
	{
		// Handelt es sich um Confixx? Dann ist /html/ auch OK
		if ($dir = @opendir('../'))
		{
			while ($file = @readdir($dir))
			{
				if (($file != 'atd') && ($file != 'log') && ($file != '.forward') && ($file != 'restore') && ($file != 'backup')
				&& ($file != '.configs') && ($file != 'html') && ($file != 'files') && ($file != 'phptmp') && ($file != '.')
				&& ($file != '..')) $ok = false;
			}
			@closedir($dir);
		}
	}
	else
		$ok = false;
}
if (!$ok) $meldung .= '- Personal WebBase besitzt m&ouml;glicherweise keinen eigenen FTP-Account!<br>';

// -------------------------------------

$ok = true;
$path = '../';

if ($dir = @opendir($path))
{
	// Bei Confixx liegen im Übergeordneten Verzeichnis die folgenden Dateien... die sind OK; andere nicht!
	while ($file = @readdir($dir))
	{
		if (($file != 'atd') && ($file != 'log') && ($file != '.forward') && ($file != 'restore') && ($file != 'backup')
		&& ($file != '.configs') && ($file != 'html') && ($file != 'files') && ($file != 'phptmp') && ($file != '.')
		&& ($file != '..')) $ok = false;
	}
	@closedir($dir);
}

// Aber weiter darf man nicht zurück gehen!
while (true)
{
	if (@readdir(@opendir($path))) $ok = false;
	$realpath = @realpath($path);
	if (($realpath == '/') || ((strlen($realpath) == 3) && (substr($realpath, 1, 2) == ':\\')) || (!$ok))
		break;
	else
		$path .= '../';
}

if (!$ok) $meldung .= '- Personal WebBase kann bei der HTTP-Server-Ebene auf das &uuml;bergeordnete Verzeichnis zugreifen!<br>';

// -------------------------------------

if ($WBConfig->getMySQLUsername() == 'root')
	$meldung .= '- ACHTUNG! Personal WebBase verwendet den MySQL-Benutzer &quot;root&quot;!<br>';

$my_warnung = false;
$db_list = db_list_dbs();
while ($row = db_fetch($db_list))
{
	if (($row['Database'] != 'information_schema') && ($row['Database'] != $WBConfig->getMySQLDatabase()))
		$my_warnung = true;
}

if ($my_warnung)
	$meldung .= '- Personal WebBase kann m&ouml;glicherweise auf andere MySQL-Datenbanken zugreifen!<br>';

$rx = db_list_tables($WBConfig->getMySQLDatabase());
$rx2 = db_query("SELECT * FROM `".$WBConfig->getMySQLPrefix()."modules`");

if (db_num($rx) > db_num($rx2))
	$meldung .= '- Es existieren fremde MySQL-Tabellen in der Personal WebBase-Datenbank, auf die Personal WebBase m&ouml;glicherweise Zugriff hat!<br>';

// -------------------------------------

if (!$WBConfig->getForceSSLFlag())
{
	$meldung .= '- SSL-Verbindungen werden nicht erzwungen (includes/config.inc.php: $force_ssl).<br>&nbsp;&nbsp;Wenn Sie &uuml;ber SSL verf&uuml;gen, sollten Sie die Einstellung auf true bzw. 1 setzen.<br>';
}

// -------------------------------------

if ($meldung != '')
	$meldung = '<span class="red">Potentielle Sicherheitsl&uuml;cke(n) entdeckt! Lesen Sie das <a href="handbuch.pdf" target="_blank">Handbuch</a> zur Behebung der Sicherheitsl&uuml;cken.<br>'.substr($meldung, 0, strlen($meldung)-strlen('<br>')).'</span>';
else
	$meldung = 'Es wurden keine Sicherheitsl&uuml;cken gefunden.';

?>
