<?php
/* $Id: session.inc.php 10422 2007-06-05 16:32:49Z lem9 $ */
// vim: expandtab sw=4 ts=4 sts=4:
/**
 * session handling
 *
 * @todo    add failover or warn if sessions are not configured properly
 * @todo    add an option to use mm-module for session handler
 * @see     http://www.php.net/session
 * @uses    session_name()
 * @uses    session_start()
 * @uses    ini_set()
 * @uses    version_compare()
 * @uses    PHP_VERSION
 */









  // http://de3.php.net/md5: Alexander Valyalkin

  function get_rnd_iv($iv_len)
  {
      $iv = '';
      while ($iv_len-- > 0) {
          $iv .= chr(mt_rand() & 0xff);
      }
      return $iv;
  }

  function ib_encrypt($plain_text, $password, $iv_len = 16)
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

  function ib_decrypt($enc_text, $password, $iv_len = 16)
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
  }

  define('IBLEGAL', '1');
  global $mysql_zugangsdaten;
  include '../../../includes/config.inc.php';

  if ((isset($lock)) && ($lock))
  {
    die('<h1>IronBASE ist gesperrt</h1>Die Variable &quot;$lock&quot; in &quot;includes/config.inc.php&quot; steht auf 1 bzw. true. Setzen Sie diese Variable erst auf 0, wenn das Hochladen der Dateien beim Installations- bzw. Updateprozess beendet ist. Wenn Sie IronBASE freigeben, bevor der Upload abgeschlossen ist, kann es zu einer Besch&auml;digung der Kundendatenbank kommen!');
  }

  //@ini_set('session.auto_start', 0);
  @ini_set('session.cache_expire', 180);
  @ini_set('session.use_trans_sid', 0);
  @ini_set('session.use_cookies', 1);
  @ini_set('session.use_only_cookies', 1);
  if ($force_ssl) @ini_set('session.cookie_secure', 1);
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
 //@ini_set('arg_separator.output', '&amp;');
 //@ini_set('url_rewriter.tags', 'a=href,area=href,frame=src,input=src,fieldset=');

  $ib_session_name = 'ironbase';

  @session_unset();
  @session_destroy();

  /* ib_newdatabasetable('sessions', $m2, 'SessionID', "varchar(255) NOT NULL",
                                       'LastUpdated', "datetime NOT NULL",
                                       'DataValue', "text"); */

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
         global $mysql_zugangsdaten;

         $ib_conn = @mysql_connect($mysql_zugangsdaten['server'], $mysql_zugangsdaten['username'], $mysql_zugangsdaten['passwort']);
         $ib_selc = @mysql_select_db($mysql_zugangsdaten['datenbank'], $ib_conn);

         $busca = mysql_query("SELECT `DataValue` FROM `".$mysql_zugangsdaten['praefix']."sessions` WHERE `SessionID` = '".mysql_real_escape_string($aKey)."'");
         if (mysql_num_rows($busca) == 0)
         {
               mysql_query("INSERT INTO `".$mysql_zugangsdaten['praefix']."sessions` (`SessionID`, `LastUpdated`, `DataValue`) VALUES ('".mysql_real_escape_string($aKey)."', NOW(), '')");

               @mysql_close($ib_conn);

               return '';
         }
         else
         {
               $r = mysql_fetch_array($busca);

               @mysql_close($ib_conn);

               return ib_decrypt($r['DataValue'], $mysql_zugangsdaten['username'].':'.$mysql_zugangsdaten['passwort']);
         }
  }

  function sessao_write( $aKey, $aVal )
  {
         global $mysql_zugangsdaten;

         $ib_conn = @mysql_connect($mysql_zugangsdaten['server'], $mysql_zugangsdaten['username'], $mysql_zugangsdaten['passwort']);
         $ib_selc = @mysql_select_db($mysql_zugangsdaten['datenbank'], $ib_conn);

         mysql_query("UPDATE `".$mysql_zugangsdaten['praefix']."sessions` SET `DataValue` = '".ib_encrypt($aVal, $mysql_zugangsdaten['username'].':'.$mysql_zugangsdaten['passwort'])."', `LastUpdated` = NOW() WHERE `SessionID` = '".mysql_real_escape_string($aKey)."'");

         @mysql_close($ib_conn);

         return True;
  }

  function sessao_destroy( $aKey )
  {
         global $mysql_zugangsdaten;

         $ib_conn = @mysql_connect($mysql_zugangsdaten['server'], $mysql_zugangsdaten['username'], $mysql_zugangsdaten['passwort']);
         $ib_selc = @mysql_select_db($mysql_zugangsdaten['datenbank'], $ib_conn);

         mysql_query("DELETE FROM `".$mysql_zugangsdaten['praefix']."sessions` WHERE `SessionID` = '".mysql_real_escape_string($aKey)."'");
         if (mysql_affected_rows() > 0)
           mysql_query("OPTIMIZE TABLE `".$mysql_zugangsdaten['praefix']."sessions`");

         @mysql_close($ib_conn);

         return True;
  }

  function sessao_gc( $aMaxLifeTime )
  {
         global $mysql_zugangsdaten;

         $ib_conn = @mysql_connect($mysql_zugangsdaten['server'], $mysql_zugangsdaten['username'], $mysql_zugangsdaten['passwort']);
         $ib_selc = @mysql_select_db($mysql_zugangsdaten['datenbank'], $ib_conn);

         mysql_query("DELETE FROM `".$mysql_zugangsdaten['praefix']."sessions` WHERE UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(`LastUpdated`) > ".mysql_real_escape_string($aMaxLifeTime));
         if (mysql_affected_rows() > 0)
           mysql_query("OPTIMIZE TABLE `".$mysql_zugangsdaten['praefix']."sessions`");

         @mysql_close($ib_conn);

         return True;
  }

  @session_set_save_handler("sessao_open", "sessao_close", "sessao_read", "sessao_write", "sessao_destroy", "sessao_gc");

  @session_name($ib_session_name);
  @session_start();

  if ((isset($_SESSION['ib_user_type'])) &&  ($_SESSION['ib_user_type'] == ''))
  {
  die('<script language="JavaScript">
  <!--
    alert("Sie sind nicht mehr in IronBASE eingeloggt!");
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

function fetchip()
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
}

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







/*










// verify if PHP supports session, die if it does not

if (!@function_exists('session_name')) {
    $cfg = array('DefaultLang'           => 'en-iso-8859-1',
                 'AllowAnywhereRecoding' => false);
    // Loads the language file
    require_once('./libraries/select_lang.lib.php');
    // Displays the error message
    // (do not use &amp; for parameters sent by header)
    header('Location: ' . (defined('PMA_SETUP') ? '../' : '') . 'error.php'
            . '?lang='  . urlencode($available_languages[$lang][2])
            . '&dir='   . urlencode($text_dir)
            . '&type='  . urlencode($strError)
            . '&error=' . urlencode(sprintf($strCantLoad, 'session')));
    exit();
} elseif (ini_get('session.auto_start') == true && session_name() != 'phpMyAdmin') {
    $_SESSION = array();
    if (isset($_COOKIE[session_name()])) {
        PMA_removeCookie(session_name());
    }
    session_unset();
    @session_destroy();
}

// disable starting of sessions before all settings are done
// does not work, besides how it is written in php manual
//ini_set('session.auto_start', 0);

// session cookie settings
session_set_cookie_params(0, PMA_Config::getCookiePath() . '; HttpOnly',
    '', PMA_Config::isHttps());

// cookies are safer
ini_set('session.use_cookies', true);

// but not all user allow cookies
ini_set('session.use_only_cookies', false);
ini_set('session.use_trans_sid', true);
ini_set('url_rewriter.tags',
    'a=href,frame=src,input=src,form=fakeentry,fieldset=');
//ini_set('arg_separator.output', '&amp;');

// delete session/cookies when browser is closed
ini_set('session.cookie_lifetime', 0);

// warn but dont work with bug
ini_set('session.bug_compat_42', false);
ini_set('session.bug_compat_warn', true);

// use more secure session ids (with PHP 5)
if (version_compare(PHP_VERSION, '5.0.0', 'ge')
  && substr(PHP_OS, 0, 3) != 'WIN') {
    ini_set('session.hash_function', 1);
    ini_set('session.hash_bits_per_character', 6);
}

// some pages (e.g. stylesheet) may be cached on clients, but not in shared
// proxy servers
session_cache_limiter('private');

// start the session
// on some servers (for example, sourceforge.net), we get a permission error
// on the session data directory, so I add some "@"

// See bug #1538132. This would block normal behavior on a cluster
//ini_set('session.save_handler', 'files');

$session_name = 'phpMyAdmin';
@session_name($session_name);
// strictly, PHP 4 since 4.4.2 would not need a verification
if (version_compare(PHP_VERSION, '5.1.2', 'lt')
 && isset($_COOKIE[$session_name])
 && eregi("\r|\n", $_COOKIE[$session_name])) {
    die('attacked');
}

if (! isset($_COOKIE[$session_name])) {
    // on first start of session we will check for errors
    // f.e. session dir cannot be accessed - session file not created
    ob_start();
    $old_display_errors = ini_get('display_errors');
    $old_error_reporting = error_reporting(E_ALL);
    ini_set('display_errors', 1);
    $r = session_start();
    ini_set('display_errors', $old_display_errors);
    error_reporting($old_error_reporting);
    unset($old_display_errors, $old_error_reporting);
    $session_error = ob_get_contents();
    ob_end_clean();
    if ($r !== true || ! empty($session_error)) {
        setcookie($session_name, '', 1);
        $cfg = array('DefaultLang'           => 'en-iso-8859-1',
                     'AllowAnywhereRecoding' => false);
        // Loads the language file
        require_once './libraries/select_lang.lib.php';
        // Displays the error message
        // (do not use &amp; for parameters sent by header)
        header('Location: ' . (defined('PMA_SETUP') ? '../' : '') . 'error.php'
                . '?lang='  . urlencode($available_languages[$lang][2])
                . '&dir='   . urlencode($text_dir)
                . '&type='  . urlencode($strError)
                . '&error=' . urlencode($strSessionStartupErrorGeneral));
        exit();
    }
} else {
    @session_start();
}




*/




/**
 * Token which is used for authenticating access queries.
 * (we use "space PMA_token space" to prevent overwriting)
 */
if (!isset($_SESSION[' PMA_token '])) {
    $_SESSION[' PMA_token '] = md5(uniqid(rand(), true));
}

/**
 * tries to secure session from hijacking and fixation
 * should be called before login and after successfull login
 * (only required if sensitive information stored in session)
 *
 * @uses    session_regenerate_id() to secure session from fixation
 * @uses    session_id()            to set new session id
 * @uses    strip_tags()            to prevent XSS attacks in SID
 * @uses    function_exists()       for session_regenerate_id()
 */
function PMA_secureSession()
{
    // prevent session fixation and XSS
    /* if (function_exists('session_regenerate_id')) {
        session_regenerate_id(true);
    } else {
        session_id(strip_tags(session_id()));
    } */
}
?>
