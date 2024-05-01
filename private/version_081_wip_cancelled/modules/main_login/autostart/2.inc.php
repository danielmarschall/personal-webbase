<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

// TODO: Als crossover für fastlogin auslagern
// TODO: Auch für PMA/net2ftp zugänglich machen

function load_fastlogin_cookie() {
	if (isset($_COOKIE['wb_fastlogin_key'])) {
		$r_user = '';
		$r_pwd  = '';
		$r_succ = wb_decode_fast_login_key($_COOKIE['wb_fastlogin_key'], $r_user, $r_pwd);

		if ($r_succ) {
			login_as_user($r_user, $r_pwd);
		} else {
			// Das Cookie ist ungültig geworden. Wir löschen es.
			wbUnsetCookie('wb_fastlogin_key');
			unset($_COOKIE['wb_fastlogin_key']);
		}
	}
}

// -------------------------------------------------------

@session_cache_limiter('private');
@ini_set('session.cookie_path', RELATIVE_DIR);
//@ini_set('session.cookie_domain', $_SERVER['HTTP_HOST']);
//@session_set_cookie_params(0, RELATIVE_DIR, $_SERVER['HTTP_HOST'], $WBConfig->getForceSSLFlag());

// @ini_set('session.auto_start', 0);
@ini_set('session.cache_expire', 180);
@ini_set('session.use_trans_sid', 0);
@ini_set('session.use_cookies', 1);
@ini_set('session.use_only_cookies', 1);
@ini_set('session.cookie_secure', $WBConfig->getForceSSLFlag());
@ini_set('session.cookie_lifetime', 0);
@ini_set('session.gc_maxlifetime', 1440);
@ini_set('session.bug_compat_42', 0);
@ini_set('session.bug_compat_warn', 1);
if (version_compare(PHP_VERSION, '5.0.0', 'ge') && substr(PHP_OS, 0, 3) != 'WIN')
{
	@ini_set('session.hash_function', 1);
	@ini_set('session.hash_bits_per_character', 6);
}
@ini_set('session.save_handler', 'user');
// @ini_set('session.save_path', 'includes/session/');
// @ini_set('arg_separator.output', '&amp;');
// @ini_set('url_rewriter.tags', 'a=href,area=href,frame=src,input=src,fieldset=');

$wb_session_name = 'webbase';

// TODO: Was hab ich mir dabei gedacht? Möglicherweise als Kompat zu den 3P-Generics
@session_unset();
@session_destroy();

wb_newdatabasetable('sessions', $m2, 'session_id', "varchar(255) NOT NULL",
	'last_updated', "datetime NOT NULL",
	'data_value', "text");

if (function_exists('set_searchable')) set_searchable($m2, 'sessions', 0);

my_add_key($WBConfig->getMySQLPrefix().'sessions', 'session_id', false, 'session_id');

if (!function_exists('sessao_open'))
{
	function sessao_open($aSavaPath, $aSessionName)
	{
		sessao_gc( ini_get('session.gc_maxlifetime') );
		return True;
	}
}

if (!function_exists('sessao_close'))
{
	function sessao_close()
	{
		return True;
	}
}

if (!function_exists('sessao_read'))
{
	function sessao_read( $aKey )
	{
		global $WBConfig;

		$busca = db_query("SELECT `data_value` FROM `".$WBConfig->getMySQLPrefix()."sessions` WHERE `session_id` = '".db_simple_escape($aKey)."'");
		if (db_num($busca) == 0)
		{
			db_query("INSERT INTO `".$WBConfig->getMySQLPrefix()."sessions` (`session_id`, `last_updated`, `data_value`) VALUES ('".db_simple_escape($aKey)."', NOW(), '')");
			return '';
		}
		else
		{
			$r = db_fetch($busca);
			return md5_decrypt($r['data_value'], $WBConfig->getMySQLUsername().':'.$WBConfig->getMySQLPassword());
		}
	}
}

if (!function_exists('sessao_write'))
{
	function sessao_write( $aKey, $aVal )
	{
		global $WBConfig;

		db_query("UPDATE `".$WBConfig->getMySQLPrefix()."sessions` SET `data_value` = '".md5_encrypt($aVal, $WBConfig->getMySQLUsername().':'.$WBConfig->getMySQLPassword())."', `last_updated` = NOW() WHERE `session_id` = '".db_simple_escape($aKey)."'");
		return True;
	}
}

if (!function_exists('sessao_destroy'))
{
	function sessao_destroy( $aKey )
	{
		global $WBConfig;

		db_query("DELETE FROM `".$WBConfig->getMySQLPrefix()."sessions` WHERE `session_id` = '".db_simple_escape($aKey)."'");
		if (db_affected_rows() > 0)
			db_query("OPTIMIZE TABLE `".$WBConfig->getMySQLPrefix()."sessions`");
		return True;
	}
}

if (!function_exists('sessao_gc'))
{
	function sessao_gc( $aMaxLifeTime )
	{
		global $WBConfig;

		db_query("DELETE FROM `".$WBConfig->getMySQLPrefix()."sessions` WHERE UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(`last_updated`) > ".db_simple_escape($aMaxLifeTime));
		if (db_affected_rows() > 0)
			db_query("OPTIMIZE TABLE `".$WBConfig->getMySQLPrefix()."sessions`");
		return True;
	}
}

@session_set_save_handler("sessao_open", "sessao_close", "sessao_read", "sessao_write", "sessao_destroy", "sessao_gc");

@session_name($wb_session_name);
@session_start();

// TODO EXPERIMENTAL
// http://support.microsoft.com/default.aspx?scid=kb;EN-US;323752
// http://www.hypotext.de/Tipps+und+Tricks/Sessions+beim+Einbinden+externer+Inhalte+in+einen+Frameset_45.htxt
// header('p3p: CP="ALL DSP COR PSAa PSDa OUR NOR ONL UNI COM NAV"');
// header('P3P: CP="CAO PSA OUR"');

// Micro$hit IE cached die Index-Frameset-Seite...
// http://www.webmaster-eye.de/PHP-Dateien-nicht-cachen.254.artikel.html
// Die 'Laufzeit' der Datei wird auf den 10.1.1970 gesetzt, also schon lange abgelaufen ;)
header("Expires: Mon, 10 Jan 1970 01:01:01 GMT");
// Der 'Last-Modified' Parameter wird auf das aktuelle Datum gesetzt.
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
// Die für die Proxys interessante Cache-Control wird eingestellt.
header("Cache-Control: no-store, no-cache, must-revalidate");
// Siehe einen Kommentar weiter oben ...
header("Pragma: no-cache");
// Jetzt folgt der Inhalt der Seite ...

if (version_compare(PHP_VERSION, '5.1.2', 'lt') && isset($_COOKIE[$wb_session_name]) && eregi("\r|\n", $_COOKIE[$wb_session_name]))
{
	die('Angriff');
}

/* if (!preg_match("/^[0-9a-z]*$/i", session_id()))
{
	die($header.'Fehler! Die Session-ID ist ung&uuml;ltig.'.$footer);
} */

/*

Ich gebe es auf! Ich sitze seit 5 Tagen ununterbrochen daran,
session_regenerate_id auf allen 4 Testsystemen zum Laufen zu
bekommen, doch andauernd gehen die Session-Informationen verloren!
Ich denke, dass die untenstehende Lösung genug ausreicht.

$ary = explode('/', $_SERVER['PHP_SELF']);
if ($ary[count($ary)-1] == 'page.php')
{
	// @session_regenerate_id(true);

	@session_start();
	$old_sessid = @session_id();
	@session_regenerate_id();
	$new_sessid = @session_id();
	@session_id($old_sessid);
	@session_destroy();

	$old_session = $_SESSION;
	@session_id($new_sessid);
	@session_start();
	$_SESSION = $old_session;
}

*/

$usedns = TRUE;

$useragent = (isset($_SERVER['HTTP_USER_AGENT'])) ? $_SERVER['HTTP_USER_AGENT'] : '';
$host = fetchip();

if ($usedns) // <- war im Originalen $global['dns']... was soll das sein?!
	$dns = @gethostbyaddr($host);
else
	$dns = $host;

if ((isset($_SESSION['session_secured'])) && ($_SESSION['session_secured']))
{
	if ((($_SESSION['host'] != $host) && !$usedns)
		|| ($_SESSION['dns'] != $dns)
		|| ($_SESSION['useragent'] != $useragent)
	) {
		session_regenerate_id();
		session_unset();
		session_destroy();
	}
} else {
	$_SESSION['host'] = $host;
	$_SESSION['dns'] = $dns;
	$_SESSION['useragent'] = $useragent;
	$_SESSION['session_secured'] = 1;
}

// -----------------------------------------------------------------------------------------------------

define('SPERRMELDUNG', $header.'<h1>Fehler</h1>Ihr Benutzerkonto wurde auf diesem Personal WebBase-Server gesperrt. Bitte wenden Sie sich an den Serveradministrator.<br><br><a href="index.php">Zur&uuml;ck zum Webinterface</a>'.$footer);

function login_as_user($username, $password) {
	global $WBConfig, $benutzer, $m2; // TODO: $m2 besser als parameter, damit funktion auch von guest verwendet werden kann

	$res = db_query("SELECT * FROM `".$WBConfig->getMySQLPrefix()."users` WHERE `username` = '".db_escape($username)."' AND `password` = '".md5($password)."'");
	if (db_num($res) > 0)
	{
		$row = db_fetch($res);
		foreach ($row as $key => $value)
			$benutzer[$key] = $value;

		if ($benutzer['banned'] == '1')
		{
			@session_unset();
			@session_destroy();

			die(SPERRMELDUNG);
		}
		else
		{
			$_SESSION['last_login'] = $benutzer['last_login'];
			$_SESSION['last_login_ip'] = $benutzer['last_login_ip'];
			db_query("UPDATE `".$WBConfig->getMySQLPrefix()."users` SET `last_login` = NOW(), `last_login_ip` = '".$_SERVER['REMOTE_ADDR']."' WHERE `username` = '".db_escape($username)."'");
			$benutzer['last_login'] = db_time();
			$benutzer['last_login_ip'] = $_SERVER['REMOTE_ADDR'];

			$_SESSION['wb_user_type'] = '1';
			$_SESSION['wb_user_username'] = $username;
			$_SESSION['wb_user_password'] = $password;
		}
	}
	else
	{
		@session_unset();
		@session_destroy();

		wb_redirect_now('index.php?prv_modul='.$m2);
	}
}

// -----------------------------------------------------------------------------------------------------

if (!isset($wb_user_type)) $wb_user_type = -1;

if (isset($_POST['login_process']) && ($_POST['login_process'] == '1'))
{
	if ($wb_user_type == 2)
	{
		if (md5($wb_user_password) != $configuration['main_administration']['admin_pwd'])
		{
			wb_redirect_now('index.php?prv_modul=main_administration');
		}
		else
		{
			$_SESSION['last_login'] = $configuration['main_administration']['last_login'];
			$_SESSION['last_login_ip'] = $configuration['main_administration']['last_login_ip'];

			wb_change_config('last_login', db_time(), 'main_administration');
			wb_change_config('last_login_ip', $_SERVER['REMOTE_ADDR'], 'main_administration');

			$_SESSION['wb_user_type'] = $wb_user_type;
			$_SESSION['wb_user_password'] = $wb_user_password;
		}
	}

	if ($wb_user_type == '1')
	{
		if (($wb_user_username == $configuration['main_guest_login']['gast_username']) && ($wb_user_password == $configuration['main_guest_login']['gast_password']))
		{
			if ($configuration['main_guest_login']['enable_gast'])
			{
				$wb_user_type = '0';
			}
			else
			{
				@session_unset();
				@session_destroy();

				wb_redirect_now('index.php?prv_modul='.$m2);
			}
		} else {
			login_as_user($wb_user_username, $wb_user_password);
		}
	}

	if ($wb_user_type == '0')
	{
		if ($configuration['main_guest_login']['enable_gast'])
		{
			$res = db_query("SELECT * FROM `".$WBConfig->getMySQLPrefix()."users` WHERE `username` = '".db_escape($configuration['main_guest_login']['gast_username'])."' AND `password` = '".md5($configuration['main_guest_login']['gast_password'])."'");
			if (db_num($res) > 0)
			{
				$row = db_fetch($res);
				foreach ($row as $key => $value)
					$benutzer[$key] = $value;

				if ($benutzer['banned'] == '1')
				{
					@session_unset();
					@session_destroy();

					die(SPERRMELDUNG);
				}
				else
				{
					$_SESSION['last_login'] = $benutzer['last_login'];
					$_SESSION['last_login_ip'] = $benutzer['last_login_ip'];
					db_query("UPDATE `".$WBConfig->getMySQLPrefix()."users` SET `last_login` = NOW(), `last_login_ip` = '".$_SERVER['REMOTE_ADDR']."' WHERE `username` = '".db_escape($configuration['main_guest_login']['gast_username'])."'");
					$benutzer['last_login'] = db_time();
					$benutzer['last_login_ip'] = $_SERVER['REMOTE_ADDR'];

					$_SESSION['wb_user_type'] = $wb_user_type;
				}
			}
			else
			{
				@session_unset();
				@session_destroy();

				wb_redirect_now('index.php?prv_modul=main_guest_login');
			}
		}
		else
		{
			@session_unset();
			@session_destroy();

			wb_redirect_now('index.php?prv_modul=main_guest_login');
		}
	}
}
else
{
	if ((!isset($_SESSION['wb_user_type'])) || (($_SESSION['wb_user_type'] != '0') && ($_SESSION['wb_user_type'] != '1') && ($_SESSION['wb_user_type'] != '2')))
	{
		$wb_user_type = -1;

		load_fastlogin_cookie();
	}
	else
	{
		if ($_SESSION['wb_user_type'] == '0')
		{
			if ($configuration['main_guest_login']['enable_gast'])
			{
				$res = db_query("SELECT * FROM `".$WBConfig->getMySQLPrefix()."users` WHERE `username` = '".db_escape($configuration['main_guest_login']['gast_username'])."' AND `password` = '".md5($configuration['main_guest_login']['gast_password'])."'");
				if (db_num($res) > 0)
				{
					$row = db_fetch($res);
					foreach ($row as $key => $value)
						$benutzer[$key] = $value;

					if ($benutzer['banned'] == '1')
					{
						@session_unset();
						@session_destroy();

						die(SPERRMELDUNG);
					}
					else
					{
						$wb_user_type = $_SESSION['wb_user_type'];
						$wb_user_username = $configuration['main_guest_login']['gast_username'];
						$wb_user_password = $configuration['main_guest_login']['gast_password'];
					}
				}
				else
				{
					@session_unset();
					@session_destroy();

					wb_redirect_now('index.php?prv_modul=main_guest_login');
				}
			}
			else
			{
				@session_unset();
				@session_destroy();

				wb_redirect_now('index.php?prv_modul='.$m2);
			}
		}
		else if ($_SESSION['wb_user_type'] == '1')
		{
			$res = db_query("SELECT * FROM `".$WBConfig->getMySQLPrefix()."users` WHERE `username` = '".db_escape($_SESSION['wb_user_username'])."' AND `password` = '".md5($_SESSION['wb_user_password'])."'");
			if (db_num($res) > 0)
			{
				$row = db_fetch($res);
				foreach ($row as $key => $value)
					$benutzer[$key] = $value;

				if ($benutzer['banned'] == '1')
				{
					@session_unset();
					@session_destroy();

					die(SPERRMELDUNG);
				}
				else
				{
					$wb_user_type = $_SESSION['wb_user_type'];
					$wb_user_username = $_SESSION['wb_user_username'];
					$wb_user_password = $_SESSION['wb_user_password'];
				}
			}
			else
			{
				@session_unset();
				@session_destroy();

				wb_redirect_now('index.php?prv_modul='.$m2);
			}
		}
		else if ($_SESSION['wb_user_type'] == '2')
		{
			if (md5($_SESSION['wb_user_password']) != $configuration['main_administration']['admin_pwd'])
			{
				wb_redirect_now('index.php?prv_modul=main_administration');
			}
			else
			{
				$wb_user_type = $_SESSION['wb_user_type'];
				$wb_user_password = $_SESSION['wb_user_password'];
			}
		}
	}
}

?>
