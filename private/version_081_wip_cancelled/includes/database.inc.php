<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

function db_connect()
{
	global $WBConfig;
	global $wb_selc;
	global $wb_conn;

	if ($WBConfig->getMySQLPort() != '')
		$zus = ':'.$WBConfig->getMySQLPort();
	else
		$zus = '';

	if ($WBConfig->getMySQLUseMySQLI()) {
		$wb_conn = @mysqli_connect($WBConfig->getMySQLServer().$zus, $WBConfig->getMySQLUsername(), $WBConfig->getMySQLPassword());
		$wb_selc = @mysqli_select_db($WBConfig->getMySQLDatabase(), $wb_conn);
	} else {
		$wb_conn = @mysql_connect($WBConfig->getMySQLServer().$zus, $WBConfig->getMySQLUsername(), $WBConfig->getMySQLPassword());
		$wb_selc = @mysql_select_db($WBConfig->getMySQLDatabase(), $wb_conn);
	}

	if ((!$wb_selc) || (!$wb_conn))
		die('<h1>Fehler</h1>Es konnte keine Verbindung zu dem Datenbankserver hergestellt werden.<br><br>Bitte pr&uuml;fen Sie den Serverstatus und die G&uuml;ltigkeit der Konfigurationsdatei &quot;includes/config.inc.php&quot;.<br><br>MySQL meldet folgendes:<br><br><code>'.mysql_errno().': '.mysql_error().'</code>');
}

function db_query($inp, $halte_an_bei_fehler = true)
{
	global $configuration;
	global $WBConfig;

	dbg_log_db_query($inp);

	if (function_exists('getmicrotime')) {
		global $mysql_count;
		$mysql_count++;
		$ss = getmicrotime();
	}

	if ($WBConfig->getMySQLUseMySQLI())
		$x = @mysqli_query($inp);
	else
		$x = @mysql_query($inp);

	if (function_exists('getmicrotime')) {
		$ee = getmicrotime();
		global $mysql_time;
		$mysql_time += $ee-$ss;
	}

	if ($halte_an_bei_fehler)
	{
		if ($WBConfig->getMySQLUseMySQLI())
			$e = @mysqli_error();
		else
			$e = @mysql_error();

		if ($e != '')
		{
			$mess = '<b>MySQL-Fehler!</b><br><br>Folgender MySQL-Fehler ist aufgetreten:<br><br><code>'.$e.'</code><br><br>Folgende Query wurde ausgef&uuml;hrt:<br><br><code>'.wb_htmlentities($inp).'</code><br><br>Die Scriptausf&uuml;hrung wurde aus Sicherheitsgr&uuml;nden abgebrochen.';

			global $modul;
			global $m2;

			$m = '';

			if ((isset($modul)) && ($modul != ''))
				$m = $modul;
			else
				$m = '';

			if ((isset($m2)) && ($m2 != ''))
			{
				if ($m2 == '')
					$z = $m2.'?';
				else
					$z = ' ('.$m2.'?)';
			}
			else
			{
				$z = '';
			}

			if (function_exists('fehler_melden')) fehler_melden($m.$z, $mess);

			die($mess);
		}
	}

	return $x;
}

function db_fetch($inp)
{
	global $WBConfig;

	if (function_exists('getmicrotime')) $ss = getmicrotime();

	if ($WBConfig->getMySQLUseMySQLI())
		return @mysqli_fetch_array($inp);
	else
		return @mysql_fetch_array($inp);

	if (function_exists('getmicrotime')) {
		$ee = getmicrotime();
		global $mysql_time;
		$mysql_time += $ee-$ss;
	}
}

function db_escape($inp)
{
	global $WBConfig;

	if ($WBConfig->getMySQLUseMySQLI())
		return @mysqli_real_escape_string($inp);
	else
		return @mysql_real_escape_string($inp);
}

function db_simple_escape($inp)
{
	global $WBConfig;

	if ($WBConfig->getMySQLUseMySQLI())
		return @mysqli_escape_string($inp);
	else
		return @mysql_escape_string($inp);
}

function db_num($inp)
{
	global $WBConfig;

	if ($WBConfig->getMySQLUseMySQLI())
		return @mysqli_num_rows($inp);
	else
		return @mysql_num_rows($inp);
}

function db_affected_rows()
{
	global $WBConfig;

	if ($WBConfig->getMySQLUseMySQLI())
		return @mysqli_affected_rows();
	else
		return @mysql_affected_rows();
}

function db_list_dbs()
{
	global $WBConfig;

	if ($WBConfig->getMySQLUseMySQLI())
		return @mysqli_list_dbs();
	else
		return @mysql_list_dbs();
}

function db_list_tables($db)
{
	global $WBConfig;

	if ($WBConfig->getMySQLUseMySQLI())
		return @mysqli_list_tables($db);
	else
		return @mysql_list_tables($db);
}

function db_error()
{
	global $WBConfig;

	if ($WBConfig->getMySQLUseMySQLI())
		return @mysqli_error();
	else
		return @mysql_error();
}

function db_disconnect()
{
	global $WBConfig;
	@session_write_close();

	if ($WBConfig->getMySQLUseMySQLI())
		@mysqli_close();
	else
		@mysql_close();
}

function db_time()
{
	// Warum? Wenn die Zeit von PHP und MySQL verschieden ist (z.B. da auf unterschiedliche Server verteilt), gäbe es Probleme!

	$res = db_query("SELECT NOW()");
	$row = db_fetch($res);

	return $row[0];
}

register_shutdown_function('db_disconnect');
db_connect();

?>
