<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

/* if (!@is_writable('includes/session/'))
{
  die($header.'<h1>Fehler</h1>Das Verzeichnis includes/session/ muss schreibbar sein (CHMOD 777)!'.$footer);
} */

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
//@ini_set('session.save_handler', 'user'); // Auskommentiert. Geht mit aktuellen PHP Versionen nicht mehr, denn man muss session_set_save_handler() aufrufen (siehe https://bugs.php.net/bug.php?id=77384 )
// @ini_set('session.save_path', 'includes/session/');
//@ini_set('arg_separator.output', '&amp;');
//@ini_set('url_rewriter.tags', 'a=href,area=href,frame=src,input=src,fieldset=');

$ib_session_name = 'ironbase';

@session_unset();
@session_destroy();

ib_newdatabasetable('sessions', $m2, 'SessionID', "varchar(255) NOT NULL",
                                     'LastUpdated', "datetime NOT NULL",
                                     'DataValue', "text");

if (function_exists('set_searchable')) set_searchable($m2, 'sessions', 0);

my_add_key($mysql_zugangsdaten['praefix'].'sessions', 'SessionID', false, 'SessionID');

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
       global $mysql_zugangsdaten;

       $busca = db_query("SELECT `DataValue` FROM `".$mysql_zugangsdaten['praefix']."sessions` WHERE `SessionID` = '".db_simple_escape($aKey)."'");
       if (db_num($busca) == 0)
       {
             db_query("INSERT INTO `".$mysql_zugangsdaten['praefix']."sessions` (`SessionID`, `LastUpdated`, `DataValue`) VALUES ('".db_simple_escape($aKey)."', NOW(), '')");
             return '';
       }
       else
       {
             $r = db_fetch($busca);
             return md5_decrypt($r['DataValue'], $mysql_zugangsdaten['username'].':'.$mysql_zugangsdaten['passwort']);
       }
}
}

if (!function_exists('sessao_write'))
{
function sessao_write( $aKey, $aVal )
{
       global $mysql_zugangsdaten;

       db_query("UPDATE `".$mysql_zugangsdaten['praefix']."sessions` SET `DataValue` = '".md5_encrypt($aVal, $mysql_zugangsdaten['username'].':'.$mysql_zugangsdaten['passwort'])."', `LastUpdated` = NOW() WHERE `SessionID` = '".db_simple_escape($aKey)."'");
       return True;
}
}

if (!function_exists('sessao_destroy'))
{
function sessao_destroy( $aKey )
{
       global $mysql_zugangsdaten;

       db_query("DELETE FROM `".$mysql_zugangsdaten['praefix']."sessions` WHERE `SessionID` = '".db_simple_escape($aKey)."'");
       if (db_affected_rows() > 0)
         db_query("OPTIMIZE TABLE `".$mysql_zugangsdaten['praefix']."sessions`");
       return True;
}
}

if (!function_exists('sessao_gc'))
{
function sessao_gc( $aMaxLifeTime )
{
       global $mysql_zugangsdaten;

       db_query("DELETE FROM `".$mysql_zugangsdaten['praefix']."sessions` WHERE UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(`LastUpdated`) > ".db_simple_escape($aMaxLifeTime));
       if (db_affected_rows() > 0)
         db_query("OPTIMIZE TABLE `".$mysql_zugangsdaten['praefix']."sessions`");
       return True;
}
}

@session_set_save_handler("sessao_open", "sessao_close", "sessao_read", "sessao_write", "sessao_destroy", "sessao_gc");

@session_name($ib_session_name);
@session_start();

if (version_compare(PHP_VERSION, '5.1.2', 'lt') && isset($_COOKIE[$ib_session_name]) && eregi("\r|\n", $_COOKIE[$ib_session_name]))
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
if ($ary[count($ary)-1] == 'modulseite.php')
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

$useragent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
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

// -----------------------------------------------------------------------------------------------------

$gesperrt = $header.'<h1>Fehler</h1>Sie wurden als Benutzer von Personal WebBase gesperrt. Bitte wenden Sie sich an den Serveradministrator.<br><br><a href="index.php">Zur&uuml;ck zum Webinterface</a>'.$footer;

if (!isset($ib_user_type)) $ib_user_type = -1;

if (isset($_POST['login_process']) && ($_POST['login_process'] == '1'))
{
  if ($ib_user_type == 2)
  {
    if (md5($ib_user_passwort) != $konfiguration['main_administration']['admin_pwd'])
    {
      if (!headers_sent()) header('location: index.php?prv_modul=main_administration');
    }
    else
    {
      $_SESSION['last_login'] = $konfiguration['main_administration']['last_login'];
      $_SESSION['last_login_ip'] = $konfiguration['main_administration']['last_login_ip'];

      $res = db_query("SELECT NOW()");
      $row = db_fetch($res);

      ib_change_config('last_login', $row[0], 'main_administration');
      ib_change_config('last_login_ip', $_SERVER['REMOTE_ADDR'], 'main_administration');

      $_SESSION['ib_user_type'] = $ib_user_type;
      $_SESSION['ib_user_passwort'] = $ib_user_passwort;
    }
  }

  if ($ib_user_type == '1')
  {
    if (($ib_user_username == $konfiguration['main_gastzugang']['gast_username']) && ($ib_user_passwort == $konfiguration['main_gastzugang']['gast_passwort']))
    {
      if ($konfiguration['main_gastzugang']['enable_gast'])
      {
        $ib_user_type = '0';
      }
      else
      {
        @session_unset();
        @session_destroy();

        if (!headers_sent()) header('location: index.php?prv_modul='.urlencode($m2));
      }
    }

    $res = db_query("SELECT * FROM `".$mysql_zugangsdaten['praefix']."users` WHERE `username` = '".db_escape($ib_user_username)."' AND `passwort` = '".md5($ib_user_passwort)."'");
    if (db_num($res) > 0)
    {
      $row = db_fetch($res);
      foreach ($row as $key => $value)
        $benutzer[$key] = $value;

      if ($benutzer['gesperrt'] == '1')
      {
        @session_unset();
        @session_destroy();

        die($gesperrt);
      }
      else
      {
        $rs = db_query("SELECT NOW()");
        $rw = db_fetch($rs);

        $_SESSION['last_login'] = $benutzer['last_login'];
        $_SESSION['last_login_ip'] = $benutzer['last_login_ip'];
        db_query("UPDATE `".$mysql_zugangsdaten['praefix']."users` SET `last_login` = '".$rw[0]."', `last_login_ip` = '".$_SERVER['REMOTE_ADDR']."' WHERE `username` = '".db_escape($ib_user_username)."'");
        $benutzer['last_login'] = $rw[0];
        $benutzer['last_login_ip'] = $_SERVER['REMOTE_ADDR'];

        $_SESSION['ib_user_type'] = $ib_user_type;
        $_SESSION['ib_user_username'] = $ib_user_username;
        $_SESSION['ib_user_passwort'] = $ib_user_passwort;
      }
    }
    else
    {
      @session_unset();
      @session_destroy();

      if (!headers_sent()) header('location: index.php?prv_modul='.urlencode($m2));
    }
  }

  if ($ib_user_type == '0')
  {
    if ($konfiguration['main_gastzugang']['enable_gast'])
    {
      $res = db_query("SELECT * FROM `".$mysql_zugangsdaten['praefix']."users` WHERE `username` = '".db_escape($konfiguration['main_gastzugang']['gast_username'])."' AND `passwort` = '".md5($konfiguration['main_gastzugang']['gast_passwort'])."'");
      if (db_num($res) > 0)
      {
        $row = db_fetch($res);
        foreach ($row as $key => $value)
          $benutzer[$key] = $value;

        if ($benutzer['gesperrt'] == '1')
        {
          @session_unset();
          @session_destroy();

          die($gesperrt);
        }
        else
        {
          $rs = db_query("SELECT NOW()");
          $rw = db_fetch($rs);

          $_SESSION['last_login'] = $benutzer['last_login'];
          $_SESSION['last_login_ip'] = $benutzer['last_login_ip'];
          db_query("UPDATE `".$mysql_zugangsdaten['praefix']."users` SET `last_login` = '".$rw[0]."', `last_login_ip` = '".$_SERVER['REMOTE_ADDR']."' WHERE `username` = '".db_escape($konfiguration['main_gastzugang']['gast_username'])."'");
          $benutzer['last_login'] = $rw[0];
          $benutzer['last_login_ip'] = $_SERVER['REMOTE_ADDR'];

          $_SESSION['ib_user_type'] = $ib_user_type;
        }
      }
      else
      {
        @session_unset();
        @session_destroy();

        if (!headers_sent()) header('location: index.php?prv_modul=main_gastzugang');
      }
    }
    else
    {
      @session_unset();
      @session_destroy();

      if (!headers_sent()) header('location: index.php?prv_modul=main_gastzugang');
    }
  }
}
else
{
  if ((!isset($_SESSION['ib_user_type'])) || (($_SESSION['ib_user_type'] != '0') && ($_SESSION['ib_user_type'] != '1') && ($_SESSION['ib_user_type'] != '2')))
  {
    $ib_user_type = -1;
  }
  else
  {
    if ($_SESSION['ib_user_type'] == '0')
    {
      if ($konfiguration['main_gastzugang']['enable_gast'])
      {
        $res = db_query("SELECT * FROM `".$mysql_zugangsdaten['praefix']."users` WHERE `username` = '".db_escape($konfiguration['main_gastzugang']['gast_username'])."' AND `passwort` = '".md5($konfiguration['main_gastzugang']['gast_passwort'])."'");
        if (db_num($res) > 0)
        {
          $row = db_fetch($res);
          foreach ($row as $key => $value)
            $benutzer[$key] = $value;

          if ($benutzer['gesperrt'] == '1')
          {
            @session_unset();
            @session_destroy();

            die($gesperrt);
          }
          else
          {
            $ib_user_type = $_SESSION['ib_user_type'];
            $ib_user_username = $konfiguration['main_gastzugang']['gast_username'];
            $ib_user_passwort = $konfiguration['main_gastzugang']['gast_passwort'];
          }
        }
        else
        {
          @session_unset();
          @session_destroy();

          if (!headers_sent()) header('location: index.php?prv_modul=main_gastzugang');
        }
      }
      else
      {
        @session_unset();
        @session_destroy();

        if (!headers_sent()) header('location: index.php?prv_modul='.urlencode($m2));
      }
    }
    else if ($_SESSION['ib_user_type'] == '1')
    {
      $res = db_query("SELECT * FROM `".$mysql_zugangsdaten['praefix']."users` WHERE `username` = '".db_escape($_SESSION['ib_user_username'])."' AND `passwort` = '".md5($_SESSION['ib_user_passwort'])."'");
      if (db_num($res) > 0)
      {
        $row = db_fetch($res);
        foreach ($row as $key => $value)
          $benutzer[$key] = $value;

        if ($benutzer['gesperrt'] == '1')
        {
          @session_unset();
          @session_destroy();

          die($gesperrt);
        }
        else
        {
          $ib_user_type = $_SESSION['ib_user_type'];
          $ib_user_username = $_SESSION['ib_user_username'];
          $ib_user_passwort = $_SESSION['ib_user_passwort'];
        }
      }
      else
      {
        @session_unset();
        @session_destroy();

        if (!headers_sent()) header('location: index.php?prv_modul='.urlencode($m2));
      }
    }
    else if ($_SESSION['ib_user_type'] == '2')
    {
      if (md5($_SESSION['ib_user_passwort']) != $konfiguration['main_administration']['admin_pwd'])
      {
        if (!headers_sent()) header('location: index.php?prv_modul=main_administration');
      }
      else
      {
        $ib_user_type = $_SESSION['ib_user_type'];
        $ib_user_passwort = $_SESSION['ib_user_passwort'];
      }
    }
  }
}

?>
