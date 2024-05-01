<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

// In PWB-Arbeitsverzeichnis wandern
$olddir = getcwd();
chdir('../../../');

// Schlecht wegen dem Gleichrichter
// include 'includes/main.inc.php';

include 'includes/configmanager.class.php';
include 'includes/functions.inc.php';

$WBConfig = new WBConfigManager();
$WBConfig->init(); // Hier findet ein include statt, deswegen bleiben wir im PWB-Arbeitsverzeichnis

chdir($olddir);
unset($olddir);

// http://www.php.net/manual/en/function.realpath.php#57016
function cleanPath($path) {
    $result = array();
    // $pathA = preg_split('/[\/\\\]/', $path);
    $pathA = explode('/', $path);
    if (!$pathA[0])
        $result[] = '';
    foreach ($pathA AS $key => $dir) {
        if ($dir == '..') {
            if (end($result) == '..') {
                $result[] = '..';
            } elseif (!array_pop($result)) {
                $result[] = '..';
            }
        } elseif ($dir && $dir != '.') {
            $result[] = $dir;
        }
    }
    if (!end($pathA))
        $result[] = '';
    return implode('/', $result);
}

define('RELATIVE_DIR2', cleanPath(RELATIVE_DIR.'../../../'));

// Wird Umleitung nach HTTPS erzwungen?

        if ($WBConfig->getForceSSLFlag())
        {
                @ini_set('session.cookie_secure', 1);

                // Wenn keine SSL Verbindung da, dann zu SSL umleiten
                if (!isset($_SERVER['HTTPS']) || (strtolower($_SERVER['HTTPS']) != 'on'))
                {
                        wb_redirect_now('https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                }
        }

// Backup der Einstellungen

$backup_session_save_handler = @ini_get('session.save_handler');

// Personal WebBase-Spezifischer Session-Abschnitt

// http://de3.php.net/md5: Alexander Valyalkin

/* function get_rnd_iv($iv_len)
{
	$iv = '';
	while ($iv_len-- > 0) {
		$iv .= chr(mt_rand() & 0xff);
	}
	return $iv;
}

function wb_encrypt($plain_text, $password, $iv_len = 16)
{
	$plain_text .= "\x13";
	$n = strlen($plain_text);
	if ($n % 16) $plain_text .= str_repeat("\0", 16 - ($n % 16));
	$i = 0;
	$enc_text = get_rnd_iv($iv_len);
	$iv = substr($password ^ $enc_text, 0, 512);
	while ($i < $n) {
		$block = substr($plain_text, $i, 16) ^ pack('H*', md5($iv));
		$enc_text .= $block;
		$iv = substr($block . $iv, 0, 512) ^ $password;
		$i += 16;
	}
	return base64_encode($enc_text);
}

function wb_decrypt($enc_text, $password, $iv_len = 16)
{
	$enc_text = base64_decode($enc_text);
	$n = strlen($enc_text);
	$i = $iv_len;
	$plain_text = '';
	$iv = substr($password ^ substr($enc_text, 0, $iv_len), 0, 512);
	while ($i < $n) {
		$block = substr($enc_text, $i, 16);
		$plain_text .= $block ^ pack('H*', md5($iv));
		$iv = substr($block . $iv, 0, 512) ^ $password;
		$i += 16;
	}
	return preg_replace('/\\x13\\x00*$/', '', $plain_text);
} */

global $WBConfig;

if ($WBConfig->getLockFlag())
{
	die('<h1>Personal WebBase ist gesperrt</h1>Die Variable &quot;$lock&quot; in &quot;includes/config.inc.php&quot; steht auf 1 bzw. true. Setzen Sie diese Variable erst auf 0, wenn das Hochladen der Dateien beim Installations- bzw. Updateprozess beendet ist. Wenn Sie Personal WebBase freigeben, bevor der Upload abgeschlossen ist, kann es zu einer Besch&auml;digung der Kundendatenbank kommen!');
}

@session_cache_limiter('private');
@ini_set('session.cookie_path', RELATIVE_DIR2);
//@ini_set('session.cookie_domain', $_SERVER['HTTP_HOST']);
//@session_set_cookie_params(0, RELATIVE_DIR2, $_SERVER['HTTP_HOST'], $WBConfig->getForceSSLFlag());

//@ini_set('session.auto_start', 0);
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
// @ini_set('session.save_path', '../../../includes/session/');
// @ini_set('arg_separator.output', '&amp;');
// @ini_set('url_rewriter.tags', 'a=href,area=href,frame=src,input=src,fieldset=');

$wb_session_name = 'webbase';

@session_unset();
@session_destroy();

// wb_newdatabasetable('sessions', $m2, 'session_id', "varchar(255) NOT NULL",
//                                      'last_updated', "datetime NOT NULL",
//                                      'data_value', "text");

function sessao_open($aSavaPath, $aSessionName)
{
	sessao_gc( ini_get('session.gc_maxlifetime') );
	return True;
}

function sessao_close()
{
	return True;
}

function sessao_read( $aKey )
{
	global $WBConfig;

	$wb_conn = @mysql_connect($WBConfig->getMySQLServer(), $WBConfig->getMySQLUsername(), $WBConfig->getMySQLPassword());
	$wb_selc = @mysql_select_db($WBConfig->getMySQLDatabase(), $wb_conn);

	$busca = mysql_query("SELECT `data_value` FROM `".$WBConfig->getMySQLPrefix()."sessions` WHERE `session_id` = '".mysql_real_escape_string($aKey)."'");
	if (mysql_num_rows($busca) == 0)
	{
		mysql_query("INSERT INTO `".$WBConfig->getMySQLPrefix()."sessions` (`session_id`, `last_updated`, `data_value`) VALUES ('".mysql_real_escape_string($aKey)."', NOW(), '')");

		@mysql_close($wb_conn);

		return '';
	}
	else
	{
		$r = mysql_fetch_array($busca);

		@mysql_close($wb_conn);

		return wb_decrypt($r['data_value'], $WBConfig->getMySQLUsername().':'.$WBConfig->getMySQLPassword());
	}
}

function sessao_write( $aKey, $aVal )
{
	global $WBConfig;

	$wb_conn = @mysql_connect($WBConfig->getMySQLServer(), $WBConfig->getMySQLUsername(), $WBConfig->getMySQLPassword());
	$wb_selc = @mysql_select_db($WBConfig->getMySQLDatabase(), $wb_conn);

	mysql_query("UPDATE `".$WBConfig->getMySQLPrefix()."sessions` SET `data_value` = '".wb_encrypt($aVal, $WBConfig->getMySQLUsername().':'.$WBConfig->getMySQLPassword())."', `last_updated` = NOW() WHERE `session_id` = '".mysql_real_escape_string($aKey)."'");

	@mysql_close($wb_conn);

	return True;
}

function sessao_destroy( $aKey )
{
	global $WBConfig;

	$wb_conn = @mysql_connect($WBConfig->getMySQLServer(), $WBConfig->getMySQLUsername(), $WBConfig->getMySQLPassword());
	$wb_selc = @mysql_select_db($WBConfig->getMySQLDatabase(), $wb_conn);

	mysql_query("DELETE FROM `".$WBConfig->getMySQLPrefix()."sessions` WHERE `session_id` = '".mysql_real_escape_string($aKey)."'");
	if (mysql_affected_rows() > 0)
	mysql_query("OPTIMIZE TABLE `".$WBConfig->getMySQLPrefix()."sessions`");

	@mysql_close($wb_conn);

	return True;
}

function sessao_gc( $aMaxLifeTime )
{
	global $WBConfig;

	$wb_conn = @mysql_connect($WBConfig->getMySQLServer(), $WBConfig->getMySQLUsername(), $WBConfig->getMySQLPassword());
	$wb_selc = @mysql_select_db($WBConfig->getMySQLDatabase(), $wb_conn);

	mysql_query("DELETE FROM `".$WBConfig->getMySQLPrefix()."sessions` WHERE UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(`last_updated`) > ".mysql_real_escape_string($aMaxLifeTime));
	if (mysql_affected_rows() > 0)
	mysql_query("OPTIMIZE TABLE `".$WBConfig->getMySQLPrefix()."sessions`");

	@mysql_close($wb_conn);

	return True;
}

@session_set_save_handler("sessao_open", "sessao_close", "sessao_read", "sessao_write", "sessao_destroy", "sessao_gc");

if (isset($_COOKIE[$wb_session_name])) @session_id($_COOKIE[$wb_session_name]);
@session_name($wb_session_name);
@session_start();

if ((!isset($_SESSION['wb_user_type'])) || ((isset($_SESSION['wb_user_type'])) && ($_SESSION['wb_user_type'] == '')))
{
	die('<script language="JavaScript">
	<!--
	alert("Sie sind nicht mehr in Personal WebBase eingeloggt!");
	parent.window.close();
	// -->
	</script>');

}

if (version_compare(PHP_VERSION, '5.1.2', 'lt') && isset($_COOKIE[$session_name]) && eregi("\r|\n", $_COOKIE[$session_name]))
{
	die('Angriff');
}

// http://lists.phpbar.de/pipermail/php/Week-of-Mon-20040322/007749.html
// Entnommen von functions.inc.php

/* function fetchip()
{
	$client_ip = (isset($_SERVER['HTTP_CLIENT_IP'])) ? $_SERVER['HTTP_CLIENT_IP'] : '';
	$x_forwarded_for = (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : '';
	$remote_addr = (isset($_SERVER['REMOTE_ADDR'])) ? $_SERVER['REMOTE_ADDR'] : '';

	if (!empty($client_ip))
	{
		$ip_expl = explode('.',$client_ip);
		$referer = explode('.',$remote_addr);
		if($referer[0] != $ip_expl[0])
		{
			$ip=array_reverse($ip_expl);
			$return=implode('.',$ip);
		}
		else
		{
			$return = $client_ip;
		}
	}
	else if (!empty($x_forwarded_for))
	{
		if(strstr($x_forwarded_for,','))
		{
			$ip_expl = explode(',',$x_forwarded_for);
			$return = end($ip_expl);
		}
		else
		{
			$return = $x_forwarded_for;
		}
	}
	else
	{
		$return = $remote_addr;
	}
	unset ($client_ip, $x_forwarded_for, $remote_addr, $ip_expl);
	return $return;
} */

$usedns = TRUE;

$useragent = $_SERVER['HTTP_USER_AGENT'];
$host = fetchip();

if ($usedns) // <- war im Originalen $global['dns']... was soll das sein?!
$dns = @gethostbyaddr($host);
else
$dns = $host;

if ((isset($_SESSION['session_secured'])) && ($_SESSION['session_secured']))
{
	if (
	(($_SESSION['host'] != $host) && !$usedns)
	|| ($_SESSION['dns'] != $dns)
	|| ($_SESSION['useragent'] != $useragent)
	) {
		session_regenerate_id();
		session_unset();
	}
	} else {
	$_SESSION['host'] = $host;
	$_SESSION['dns'] = $dns;
	$_SESSION['useragent'] = $useragent;
	$_SESSION['session_secured'] = 1;
}


// Zusatz für phpMyAdmin ...
// Inhalte für die config.inc.php zwischenspeichern und Zustand wiederherstellen

$WB_BAK_SESSION = $_SESSION;
global $WB_BAK_SESSION;

@session_write_close();
@session_unset();
@session_regenerate_id();

// Wiederherstellen der Dinge

@ini_set('session.save_handler', $backup_session_save_handler);

unset($backup_session_save_handler);

// Ende Personal WebBase-Abschnitt

?>
