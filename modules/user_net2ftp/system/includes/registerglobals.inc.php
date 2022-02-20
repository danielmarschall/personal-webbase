<?php

//   -------------------------------------------------------------------------------
//  |                  net2ftp: a web based FTP client                              |
//  |              Copyright (c) 2003-2007 by David Gartner                         |
//  |                                                                               |
//  | This program is free software; you can redistribute it and/or                 |
//  | modify it under the terms of the GNU General Public License                   |
//  | as published by the Free Software Foundation; either version 2                |
//  | of the License, or (at your option) any later version.                        |
//  |                                                                               |
//   -------------------------------------------------------------------------------

// Make sure this file is included by net2ftp, not accessed directly
defined("NET2FTP") or die("Direct access to this location is not allowed.");

// -------------------------------------------------------------------------
// Overview of the code
// 1   Replace \' by ' (remove_magic_quotes)
// 2   Start the session
// 3   Register $_SERVER variables
// 4.1 Register main variables - POST method
// 4.2 Register main variables - GET method
// 5.1 Delete the session data when logging out
// 5.2 Redirect to login_small if session has expired
// 6   Register $_COOKIE variables
// 7   Determine the browser agent, version and platform
// -------------------------------------------------------------------------

// -------------------------------------------------------------------------
// 1 When a variable is submitted, quotes ' are replaced by backslash-quotes \'
// This function removes the extra backslash that is added
// -------------------------------------------------------------------------
if (get_magic_quotes_gpc() == 1) {
	remove_magic_quotes($_POST);
	remove_magic_quotes($_GET);
	remove_magic_quotes($_COOKIE);
}

// Do not add remove_magic_quotes for $GLOBALS because this would call the same
// function a second time, replacing \' by ' and \" by "


// -------------------------------------------------------------------------
// 2 Start the session
// -------------------------------------------------------------------------

if (function_exists("session_name") == false) {
	$net2ftp_result["success"]         = false;
	$net2ftp_result["error_message"]   = "Sessions are not supported on this server.";
	$net2ftp_result["debug_backtrace"] = debug_backtrace();
	logError();
	return false;
}




// IronBASE: Auskommentierung

/*

// PMA - Cookies are safer
ini_set("session.use_cookies", true);

// PMA - but not all user allow cookies
ini_set("session.use_only_cookies", false);
ini_set("session.use_trans_sid", true);

// PMA - Delete session/cookies when browser is closed
ini_set("session.cookie_lifetime", 0);

// PMA - Warn but dont work with bug
ini_set("session.bug_compat_42", false);
ini_set("session.bug_compat_warn", true);

// PMA - Use more secure session ids (with PHP 5)
if (version_compare(PHP_VERSION, "5.0.0", "ge") && substr(PHP_OS, 0, 3) != "WIN") {
	ini_set("session.hash_function", 1);
	ini_set("session.hash_bits_per_character", 6);
}

// PMA - [2006-01-25] Nicola Asuni - www.tecnick.com: maybe the PHP directive
// session.save_handler is set to another value like "user"
ini_set("session.save_handler", "files");

// Start the session
// PMA - On some servers (for example, sourceforge.net), we get a permission error on the session data directory, so prefix with @
@session_start();

// Check if the session ID and the IP address have changed
if (isset($_SESSION["net2ftp_session_id_new"]) == true)  { $_SESSION["net2ftp_session_id_old"]  = $_SESSION["net2ftp_session_id_new"]; }
else                                                     { $_SESSION["net2ftp_session_id_old"]  = ""; }
if (isset($_SESSION["net2ftp_remote_addr_new"]) == true) { $_SESSION["net2ftp_remote_addr_old"] = $_SESSION["net2ftp_remote_addr_new"]; }
else                                                     { $_SESSION["net2ftp_remote_addr_old"] = ""; }
$_SESSION["net2ftp_session_id_new"]  = session_id();
$_SESSION["net2ftp_remote_addr_new"] = $_SERVER["REMOTE_ADDR"];

*/














// IronBASE-Spezifischer Session-Abschnitt



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

 if ($_SESSION['ib_user_type'] == '')
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


// Ende IronBASE-Abschnitt










// -------------------------------------------------------------------------
// 3 SERVER variabes
// -------------------------------------------------------------------------
if     (isset($_SERVER["SCRIPT_NAME"]) == true) { $net2ftp_globals["PHP_SELF"] = $_SERVER["SCRIPT_NAME"]; }
elseif (isset($_SERVER["PHP_SELF"]) == true)    { $net2ftp_globals["PHP_SELF"] = $_SERVER["PHP_SELF"]; }
else                                            { $net2ftp_globals["PHP_SELF"] = "index.php"; }
if (isset($_SERVER["HTTP_REFERER"]) == true)    { $net2ftp_globals["HTTP_REFERER"]    = $_SERVER["HTTP_REFERER"]; }
else                                            { $net2ftp_globals["HTTP_REFERER"]    = ""; }
if (isset($_SERVER["HTTP_USER_AGENT"]) == true) { $net2ftp_globals["HTTP_USER_AGENT"] = $_SERVER["HTTP_USER_AGENT"]; }
if (isset($_SERVER["REMOTE_ADDR"]) == true)     { $net2ftp_globals["REMOTE_ADDR"]     = $_SERVER["REMOTE_ADDR"]; }
if (isset($_SERVER["REMOTE_PORT"]) == true)     { $net2ftp_globals["REMOTE_PORT"]     = $_SERVER["REMOTE_PORT"]; }

// Action URL
// Note that later on in this file parameters may be appended to the action_url (for Mambo and Drupal)
$net2ftp_globals["action_url"] = $net2ftp_globals["PHP_SELF"];


// -------------------------------------------------------------------------
// 4 Register main variables
// -------------------------------------------------------------------------

// ----------------------------------------------
// FTP server
// ----------------------------------------------
if     (isset($_POST["ftpserver"]) == true) { $net2ftp_globals["ftpserver"] = validateFtpserver($_POST["ftpserver"]); }
elseif (isset($_GET["ftpserver"]) == true)  { $net2ftp_globals["ftpserver"] = validateFtpserver($_GET["ftpserver"]); }
else                                        { $net2ftp_globals["ftpserver"] = validateFtpserver(""); }
$net2ftp_globals["ftpserver_html"] = htmlEncode2($net2ftp_globals["ftpserver"]);
$net2ftp_globals["ftpserver_url"]  = urlEncode2($net2ftp_globals["ftpserver"]);
$net2ftp_globals["ftpserver_js"]   = javascriptEncode2($net2ftp_globals["ftpserver"]);

// ----------------------------------------------
// FTP server port
// ----------------------------------------------
if     (isset($_POST["ftpserverport"]) == true) { $net2ftp_globals["ftpserverport"] = validateFtpserverport($_POST["ftpserverport"]); }
elseif (isset($_GET["ftpserverport"]) == true)  { $net2ftp_globals["ftpserverport"] = validateFtpserverport($_GET["ftpserverport"]); }
else                                            { $net2ftp_globals["ftpserverport"] = validateFtpserverport(""); }
$net2ftp_globals["ftpserverport_html"] = htmlEncode2($net2ftp_globals["ftpserverport"]);
$net2ftp_globals["ftpserverport_url"]  = urlEncode2($net2ftp_globals["ftpserverport"]);
$net2ftp_globals["ftpserverport_js"]   = javascriptEncode2($net2ftp_globals["ftpserverport"]);

// ----------------------------------------------
// Username
// ----------------------------------------------
if     (isset($_POST["username"]) == true) { $net2ftp_globals["username"] = validateUsername($_POST["username"]); }
elseif (isset($_GET["username"]) == true)  { $net2ftp_globals["username"] = validateUsername($_GET["username"]); }
else                                       { $net2ftp_globals["username"] = validateUsername(""); }
$net2ftp_globals["username_html"] = htmlEncode2($net2ftp_globals["username"]);
$net2ftp_globals["username_url"]  = urlEncode2($net2ftp_globals["username"]);
$net2ftp_globals["username_js"]   = javascriptEncode2($net2ftp_globals["username"]);

// ----------------------------------------------
// Password
// ----------------------------------------------
// From login form
if (isset($_POST["password"]) == true) {
	$net2ftp_globals["password_encrypted"]  = encryptPassword(trim($_POST["password"]));
	$_SESSION["net2ftp_password_encrypted_" . $net2ftp_globals["ftpserver"] . $net2ftp_globals["username"]] = encryptPassword(trim($_POST["password"]));
}
// From the upload page (SWFUpload Flash applet)
elseif (isset($_GET["password_encrypted"]) == true) {
	$net2ftp_globals["password_encrypted"]  = trim($_GET["password_encrypted"]);
	$_SESSION["net2ftp_password_encrypted_" . $net2ftp_globals["ftpserver"] . $net2ftp_globals["username"]] = trim($_GET["password_encrypted"]);
}

// ----------------------------------------------
// Language
// ----------------------------------------------
if     (isset($_POST["language"]) == true) { $net2ftp_globals["language"] = validateLanguage($_POST["language"]); }
elseif (isset($_GET["language"]) == true)  { $net2ftp_globals["language"] = validateLanguage($_GET["language"]); }
else                                       { $net2ftp_globals["language"] = validateLanguage(""); }
$net2ftp_globals["language_html"] = htmlEncode2($net2ftp_globals["language"]);
$net2ftp_globals["language_url"]  = urlEncode2($net2ftp_globals["language"]);
$net2ftp_globals["language_js"]   = javascriptEncode2($net2ftp_globals["language"]);

// ----------------------------------------------
// Skin
// ----------------------------------------------
if     (isset($_POST["skin"]) == true) { $net2ftp_globals["skin"] = validateSkin($_POST["skin"]); }
elseif (isset($_GET["skin"]) == true)  { $net2ftp_globals["skin"] = validateSkin($_GET["skin"]); }
else                                   { $net2ftp_globals["skin"] = validateSkin(""); }
$net2ftp_globals["skin_html"] = htmlEncode2($net2ftp_globals["skin"]);
$net2ftp_globals["skin_url"]  = urlEncode2($net2ftp_globals["skin"]);
$net2ftp_globals["skin_js"]   = javascriptEncode2($net2ftp_globals["skin"]);

$skinArray = getSkinArray();
$net2ftp_globals["image_url"] = $skinArray[$net2ftp_globals["skin"]]["image_url"];

// ----------------------------------------------
// FTP mode
// ----------------------------------------------
if     (isset($_POST["ftpmode"]) == true) { $net2ftp_globals["ftpmode"] = validateFtpmode($_POST["ftpmode"]); }
elseif (isset($_GET["ftpmode"]) == true)  { $net2ftp_globals["ftpmode"] = validateFtpmode($_GET["ftpmode"]); }
else                                      { $net2ftp_globals["ftpmode"] = validateFtpmode(""); }
$net2ftp_globals["ftpmode_html"] = htmlEncode2($net2ftp_globals["ftpmode"]);
$net2ftp_globals["ftpmode_url"]  = urlEncode2($net2ftp_globals["ftpmode"]);
$net2ftp_globals["ftpmode_js"]   = javascriptEncode2($net2ftp_globals["ftpmode"]);

// ----------------------------------------------
// Passive mode
// ----------------------------------------------
if     (isset($_POST["passivemode"]) == true) { $net2ftp_globals["passivemode"] = validatePassivemode($_POST["passivemode"]); }
elseif (isset($_GET["passivemode"]) == true)  { $net2ftp_globals["passivemode"] = validatePassivemode($_GET["passivemode"]); }
else                                          { $net2ftp_globals["passivemode"] = validatePassivemode(""); }
$net2ftp_globals["passivemode_html"] = htmlEncode2($net2ftp_globals["passivemode"]);
$net2ftp_globals["passivemode_url"]  = urlEncode2($net2ftp_globals["passivemode"]);
$net2ftp_globals["passivemode_js"]   = javascriptEncode2($net2ftp_globals["passivemode"]);

// ----------------------------------------------
// SSL connect
// ----------------------------------------------
if     (isset($_POST["sslconnect"]) == true) { $net2ftp_globals["sslconnect"] = validateSslconnect($_POST["sslconnect"]); }
elseif (isset($_GET["sslconnect"]) == true)  { $net2ftp_globals["sslconnect"] = validateSslconnect($_GET["sslconnect"]); }
else                                         { $net2ftp_globals["sslconnect"] = validateSslconnect(""); }
$net2ftp_globals["sslconnect_html"] = htmlEncode2($net2ftp_globals["sslconnect"]);
$net2ftp_globals["sslconnect_url"]  = urlEncode2($net2ftp_globals["sslconnect"]);
$net2ftp_globals["sslconnect_js"]   = javascriptEncode2($net2ftp_globals["sslconnect"]);

// ----------------------------------------------
// View mode
// ----------------------------------------------
if     (isset($_POST["viewmode"]) == true) { $net2ftp_globals["viewmode"] = validateViewmode($_POST["viewmode"]); }
elseif (isset($_GET["viewmode"]) == true)  { $net2ftp_globals["viewmode"] = validateViewmode($_GET["viewmode"]); }
else                                       { $net2ftp_globals["viewmode"] = validateViewmode(""); }
$net2ftp_globals["viewmode_html"] = htmlEncode2($net2ftp_globals["viewmode"]);
$net2ftp_globals["viewmode_url"]  = urlEncode2($net2ftp_globals["viewmode"]);
$net2ftp_globals["viewmode_js"]   = javascriptEncode2($net2ftp_globals["viewmode"]);

// ----------------------------------------------
// Sort
// ----------------------------------------------
if     (isset($_POST["sort"]) == true) { $net2ftp_globals["sort"] = validateSort($_POST["sort"]); }
elseif (isset($_GET["sort"]) == true)  { $net2ftp_globals["sort"] = validateSort($_GET["sort"]); }
else                                   { $net2ftp_globals["sort"] = validateSort(""); }
$net2ftp_globals["sort_html"] = htmlEncode2($net2ftp_globals["sort"]);
$net2ftp_globals["sort_url"]  = urlEncode2($net2ftp_globals["sort"]);
$net2ftp_globals["sort_js"]   = javascriptEncode2($net2ftp_globals["sort"]);

// ----------------------------------------------
// Sort order
// ----------------------------------------------
if     (isset($_POST["sortorder"]) == true) { $net2ftp_globals["sortorder"] = validateSortorder($_POST["sortorder"]); }
elseif (isset($_GET["sortorder"]) == true)  { $net2ftp_globals["sortorder"] = validateSortorder($_GET["sortorder"]); }
else                                        { $net2ftp_globals["sortorder"] = validateSortorder(""); }
$net2ftp_globals["sortorder_html"] = htmlEncode2($net2ftp_globals["sortorder"]);
$net2ftp_globals["sortorder_url"]  = urlEncode2($net2ftp_globals["sortorder"]);
$net2ftp_globals["sortorder_js"]   = javascriptEncode2($net2ftp_globals["sortorder"]);

// ----------------------------------------------
// State
// ----------------------------------------------
if     (isset($_POST["state"]) == true) { $net2ftp_globals["state"] = validateState($_POST["state"]); }
elseif (isset($_GET["state"]) == true)  { $net2ftp_globals["state"] = validateState($_GET["state"]); }
else                                    { $net2ftp_globals["state"] = validateState(""); }
$net2ftp_globals["state_html"] = htmlEncode2($net2ftp_globals["state"]);
$net2ftp_globals["state_url"]  = urlEncode2($net2ftp_globals["state"]);
$net2ftp_globals["state_js"]   = javascriptEncode2($net2ftp_globals["state"]);

// ----------------------------------------------
// State2
// ----------------------------------------------
if     (isset($_POST["state2"]) == true) { $net2ftp_globals["state2"] = validateState2($_POST["state2"]); }
elseif (isset($_GET["state2"]) == true)  { $net2ftp_globals["state2"] = validateState2($_GET["state2"]); }
else                                     { $net2ftp_globals["state2"] = validateState2(""); }
$net2ftp_globals["state2_html"] = htmlEncode2($net2ftp_globals["state2"]);
$net2ftp_globals["state2_url"]  = urlEncode2($net2ftp_globals["state2"]);
$net2ftp_globals["state2_js"]   = javascriptEncode2($net2ftp_globals["state2"]);

// ----------------------------------------------
// Directory
// ----------------------------------------------
if     (isset($_POST["directory"]) == true) { $net2ftp_globals["directory"] = validateDirectory($_POST["directory"]); }
elseif (isset($_GET["directory"]) == true)  { $net2ftp_globals["directory"] = validateDirectory($_GET["directory"]); }
else                                        { $net2ftp_globals["directory"] = ""; }
$net2ftp_globals["directory_html"] = htmlEncode2($net2ftp_globals["directory"]);
$net2ftp_globals["directory_url"]  = urlEncode2($net2ftp_globals["directory"]);
$net2ftp_globals["directory_js"]   = javascriptEncode2($net2ftp_globals["directory"]);

// printdirectory
if ($net2ftp_globals["directory"] != "" && $net2ftp_globals["directory"] != "/") {
	$net2ftp_globals["printdirectory"] = $net2ftp_globals["directory"];
}
else {
	$net2ftp_globals["printdirectory"] = "/";
}

// ----------------------------------------------
// Entry
// ----------------------------------------------
if     (isset($_POST["entry"]) == true) { $net2ftp_globals["entry"] = validateEntry($_POST["entry"]); }
elseif (isset($_GET["entry"]) == true)  { $net2ftp_globals["entry"] = validateEntry($_GET["entry"]); }
else                                    { $net2ftp_globals["entry"] = ""; }

// Do not validate $entry when following symlinks, as this removes the -> symbol
// Validation of $entry is done in /modules/followsymlink/followsymlink.inc.php
if ($net2ftp_globals["state"] == "followsymlink") {
	if     (isset($_POST["entry"]) == true) { $net2ftp_globals["entry"] = $_POST["entry"]; }
	elseif (isset($_GET["entry"]) == true)  { $net2ftp_globals["entry"] = $_GET["entry"]; }
}

$net2ftp_globals["entry_html"] = htmlEncode2($net2ftp_globals["entry"]);
$net2ftp_globals["entry_url"]  = urlEncode2($net2ftp_globals["entry"]);
$net2ftp_globals["entry_js"]   = javascriptEncode2($net2ftp_globals["entry"]);


// ----------------------------------------------
// Screen
// ----------------------------------------------
if     (isset($_POST["screen"]) == true) { $net2ftp_globals["screen"] = validateScreen($_POST["screen"]); }
elseif (isset($_GET["screen"]) == true)  { $net2ftp_globals["screen"] = validateScreen($_GET["screen"]); }
else                                     { $net2ftp_globals["screen"] = validateScreen(""); }
$net2ftp_globals["screen_html"] = htmlEncode2($net2ftp_globals["screen"]);
$net2ftp_globals["screen_url"]  = urlEncode2($net2ftp_globals["screen"]);
$net2ftp_globals["screen_js"]   = javascriptEncode2($net2ftp_globals["screen"]);

// ----------------------------------------------
// MAMBO variables
// ----------------------------------------------
if (defined("_VALID_MOS") == true) {
	$option = $_GET["option"];
	$Itemid = $_GET["Itemid"];
	$net2ftp_globals["action_url"] .= "?option=$option&amp;Itemid=$Itemid";
}

// ----------------------------------------------
// DRUPAL variables
// ----------------------------------------------
if (defined("CACHE_PERMANENT") == true) {
	$q = $_GET["q"];
	$net2ftp_globals["action_url"] .= "?q=$q";
}


// -------------------------------------------------------------------------
// 5.1 Delete the session data when logging out
// -------------------------------------------------------------------------
if ($net2ftp_globals["state"] == "logout") {
	$_SESSION["net2ftp_password_encrypted_" . $net2ftp_globals["ftpserver"] . $net2ftp_globals["username"]] = "";
}

// -------------------------------------------------------------------------
// 5.2 Redirect to login_small
//         if session has expired
//         if the IP address has changed (disabled as this may cause problems for some people)
//         if the password is blank
// -------------------------------------------------------------------------

// IronBASE-Auskommentierung

/* if ($net2ftp_globals["state"] != "login" && $net2ftp_globals["state"] != "login_small" &&
	$_SESSION["net2ftp_session_id_old"] != $_SESSION["net2ftp_session_id_new"]) {
	$net2ftp_globals["go_to_state"]  = $net2ftp_globals["state"];
	$net2ftp_globals["go_to_state2"] = $net2ftp_globals["state2"];
	$net2ftp_globals["state"]        = "login_small";
	$net2ftp_globals["state2"]       = "session_expired";
}
//elseif ($net2ftp_globals["state"] != "login" && $net2ftp_globals["state"] != "login_small" &&
//	$_SESSION["net2ftp_remote_addr_old"] != $_SESSION["net2ftp_remote_addr_new"]) {
//	$net2ftp_globals["go_to_state"]  = $net2ftp_globals["state"];
//	$net2ftp_globals["go_to_state2"] = $net2ftp_globals["state2"];
//	$net2ftp_globals["state"]        = "login_small";
//	$net2ftp_globals["state2"]       = "session_ipchanged";
//}
elseif (substr($net2ftp_globals["state"], 0, 5) != "admin" && $net2ftp_globals["state"] != "clearcookies" &&
	$net2ftp_globals["state"] != "login" && $net2ftp_globals["state"] != "login_small" &&
	$net2ftp_globals["state"] != "logout" && $_SESSION["net2ftp_password_encrypted_" . $net2ftp_globals["ftpserver"] . $net2ftp_globals["username"]] == "") {
	$net2ftp_globals["state"]        = "login";
	$net2ftp_globals["state2"]       = "";
} */

// -------------------------------------------------------------------------
// 6 COOKIE variabes
// -------------------------------------------------------------------------
if (isset($_COOKIE["net2ftpcookie_ftpserver"])     == true) { $net2ftp_globals["cookie_ftpserver"]     = validateFtpserver($_COOKIE["net2ftpcookie_ftpserver"]); }
else                                                        { $net2ftp_globals["cookie_ftpserver"]     = ""; }
if (isset($_COOKIE["net2ftpcookie_ftpserverport"]) == true) { $net2ftp_globals["cookie_ftpserverport"] = validateFtpserverport($_COOKIE["net2ftpcookie_ftpserverport"]); }
else                                                        { $net2ftp_globals["cookie_ftpserverport"] = ""; }
if (isset($_COOKIE["net2ftpcookie_username"])      == true) { $net2ftp_globals["cookie_username"]      = validateUsername($_COOKIE["net2ftpcookie_username"]); }
else                                                        { $net2ftp_globals["cookie_username"]      = ""; }
if (isset($_COOKIE["net2ftpcookie_language"])      == true) { $net2ftp_globals["cookie_language"]      = validateLanguage($_COOKIE["net2ftpcookie_language"]); }
else                                                        { $net2ftp_globals["cookie_language"]      = ""; }
if (isset($_COOKIE["net2ftpcookie_skin"])          == true) { $net2ftp_globals["cookie_skin"]          = validateSkin($_COOKIE["net2ftpcookie_skin"]); }
else                                                        { $net2ftp_globals["cookie_skin"]          = ""; }
if (isset($_COOKIE["net2ftpcookie_ftpmode"])       == true) { $net2ftp_globals["cookie_ftpmode"]       = validateFtpmode($_COOKIE["net2ftpcookie_ftpmode"]); }
else                                                        { $net2ftp_globals["cookie_ftpmode"]       = ""; }
if (isset($_COOKIE["net2ftpcookie_passivemode"])   == true) { $net2ftp_globals["cookie_passivemode"]   = validatePassivemode($_COOKIE["net2ftpcookie_passivemode"]); }
else                                                        { $net2ftp_globals["cookie_passivemode"]   = ""; }
if (isset($_COOKIE["net2ftpcookie_sslconnect"])    == true) { $net2ftp_globals["cookie_sslconnect"]    = validateSslconnect($_COOKIE["net2ftpcookie_sslconnect"]); }
else                                                        { $net2ftp_globals["cookie_sslconnect"]    = ""; }
if (isset($_COOKIE["net2ftpcookie_viewmode"])      == true) { $net2ftp_globals["cookie_viewmode"]      = validateViewmode($_COOKIE["net2ftpcookie_viewmode"]); }
else                                                        { $net2ftp_globals["cookie_viewmode"]      = ""; }
if (isset($_COOKIE["net2ftpcookie_directory"])     == true) { $net2ftp_globals["cookie_directory"]     = validateDirectory($_COOKIE["net2ftpcookie_directory"]); }
else                                                        { $net2ftp_globals["cookie_directory"]     = ""; }
if (isset($_COOKIE["net2ftpcookie_sort"])          == true) { $net2ftp_globals["cookie_sort"]          = validateSort($_COOKIE["net2ftpcookie_sort"]); }
else                                                        { $net2ftp_globals["cookie_sort"]          = ""; }
if (isset($_COOKIE["net2ftpcookie_sortorder"])     == true) { $net2ftp_globals["cookie_sortorder"]     = validateSortorder($_COOKIE["net2ftpcookie_sortorder"]); }
else                                                        { $net2ftp_globals["cookie_sortorder"]     = ""; }


// -------------------------------------------------------------------------
// 7 Get information about the browser and protocol
// -------------------------------------------------------------------------
$net2ftp_globals["browser_agent"]    = getBrowser("agent");
$net2ftp_globals["browser_version"]  = getBrowser("version");
$net2ftp_globals["browser_platform"] = getBrowser("platform");





// **************************************************************************************
// **************************************************************************************
// **                                                                                  **
// **                                                                                  **

function remove_magic_quotes(&$x, $keyname="") {

	// http://www.php.net/manual/en/configuration.php#ini.magic-quotes-gpc (by the way: gpc = get post cookie)
	// if (magic_quotes_gpc == 1), then PHP converts automatically " --> \", ' --> \'
	// Has only to be done when getting info from get post cookie
	if (get_magic_quotes_gpc() == 1) {

		if (is_array($x)) {
			while (list($key,$value) = each($x)) {
				if ($value) { remove_magic_quotes($x[$key],$key); }
			}
		}
		else {
			$quote = "'";
			$doublequote = "\"";
			$backslash = "\\";

			$x = str_replace("$backslash$quote", $quote, $x);
			$x = str_replace("$backslash$doublequote", $doublequote, $x);
			$x = str_replace("$backslash$backslash", $backslash, $x);
		}

	} // end if get_magic_quotes_gpc

	return $x;

} // end function remove_magic_quotes

// **                                                                                  **
// **                                                                                  **
// **************************************************************************************
// **************************************************************************************





// **************************************************************************************
// **************************************************************************************
// **                                                                                  **
// **                                                                                  **

function validateFtpserver($ftpserver) {

// --------------
// Input: " ftp://something.domainname.com:123/directory/file "
// Output: "something.domainname.com"
// --------------

// Remove invisible characters in the beginning and at the end
	$ftpserver = trim($ftpserver);

// Remove possible "ftp://"
	if (substr($ftpserver, 0, 6) == "ftp://") {
		$ftpserver = substr($ftpserver, 6);
	}

// Remove a possible port nr ":123"
	if (preg_match("/(.*)[:]{1}[0-9]+/", $ftpserver, $regs) == true) {
		$ftpserver = $regs[1];
	}

// Remove a possible trailing / or \
// Remove a possible directory and file "/directory/file"
	if (preg_match("/[\\/\\\\]*(.*)[\\/\\\\]{1,}.*/", $ftpserver, $regs) == true) {
		// Any characters like / or \
		// Anything
		// Followed by at least one / or \
		// Followed by any characters
		$ftpserver = $regs[1];
	}

// FTP server may only contain specific characters
	$ftpserver = preg_replace("/[^A-Za-z0-9._-]/", "", $ftpserver);

	return $ftpserver;

} // end validateFTPserver

// **                                                                                  **
// **                                                                                  **
// **************************************************************************************
// **************************************************************************************





// **************************************************************************************
// **************************************************************************************
// **                                                                                  **
// **                                                                                  **

function validateFtpserverport($ftpserverport) {

// --------------
// This function validates the FTP server port
// --------------

// Remove invisible characters in the beginning and at the end
	$ftpserverport = trim($ftpserverport);

// FTP server port must be numeric and > 0 and < 65536, else set it to 21
	if (is_numeric($ftpserverport) != true || $ftpserverport < 0 || $ftpserverport > 65536) {
		$ftpserverport = 21;
	}

	return $ftpserverport;

} // end validateFtpserverport

// **                                                                                  **
// **                                                                                  **
// **************************************************************************************
// **************************************************************************************





// **************************************************************************************
// **************************************************************************************
// **                                                                                  **
// **                                                                                  **

function validateUsername($username) {

// --------------
// This function validates the username
// --------------

// Remove invisible characters in the beginning and at the end
	$username = trim($username);

// Username may only contain specific characters
//	$username = preg_replace("/[^A-Za-z0-9@+._\\/-]/", "", $username);

	return $username;

} // end validateUsername

// **                                                                                  **
// **                                                                                  **
// **************************************************************************************
// **************************************************************************************





// **************************************************************************************
// **************************************************************************************
// **                                                                                  **
// **                                                                                  **

function validatePasswordEncrypted($password_encrypted) {

// --------------
// This function validates the encrypted password
// --------------

// Remove invisible characters in the beginning and at the end
	$password_encrypted = trim($password_encrypted);

// Encrypted password may only contain specific characters
	$password_encrypted = preg_replace("/[^A-Fa-f0-9]/", "", $password_encrypted);

	return $password_encrypted;

} // end validatePasswordEncrypted

// **                                                                                  **
// **                                                                                  **
// **************************************************************************************
// **************************************************************************************





// **************************************************************************************
// **************************************************************************************
// **                                                                                  **
// **                                                                                  **

function validatePassword($password) {

// --------------
// This function validates the plain password
// --------------

// Remove invisible characters in the beginning and at the end
	$password = trim($password);

	return $password;

} // end validatePassword

// **                                                                                  **
// **                                                                                  **
// **************************************************************************************
// **************************************************************************************





// **************************************************************************************
// **************************************************************************************
// **                                                                                  **
// **                                                                                  **

function validateLanguage($language) {

// --------------
// This function validates the language
// --------------

	global $net2ftp_settings;
	$languageArray = getLanguageArray();
	if (isset($languageArray[$language]) == true) {
		return $language;
	}
	elseif (isset($_COOKIE["net2ftpcookie_language"]) == true && isset($languageArray[$_COOKIE["net2ftpcookie_language"]]) == true) {
		return $_COOKIE["net2ftpcookie_language"];
	}
	elseif (isset($languageArray[$net2ftp_settings["default_language"]]) == true){
		return $net2ftp_settings["default_language"];
	}
	else {
		return "en";
	}

} // end validateLanguage

// **                                                                                  **
// **                                                                                  **
// **************************************************************************************
// **************************************************************************************





// **************************************************************************************
// **************************************************************************************
// **                                                                                  **
// **                                                                                  **

function validateSkin($skin) {

// --------------
// This function validates the skin
// --------------

	global $net2ftp_settings;
	$skinArray = getSkinArray();
	if (isset($skinArray[$skin]) == true) {
		return $skin;
	}
	elseif (isset($_COOKIE["net2ftpcookie_skin"]) == true && isset($skinArray[$_COOKIE["net2ftpcookie_skin"]]) == true) {
		return $_COOKIE["net2ftpcookie_skin"];
	}
	else {
		if     (defined("_VALID_MOS")      == true) { return "mambo"; }
		elseif (defined("CACHE_PERMANENT") == true) { return "drupal"; }
		elseif (defined("XOOPS_ROOT_PATH") == true) { return "xoops"; }
		elseif (getBrowser("platform") == "Mobile") { return "mobile"; }
		elseif (isset($skinArray[$net2ftp_settings["default_skin"]]) == true){ return $net2ftp_settings["default_skin"]; }
		else                                        { return "india"; }
	}

} // end validateSkin

// **                                                                                  **
// **                                                                                  **
// **************************************************************************************
// **************************************************************************************





// **************************************************************************************
// **************************************************************************************
// **                                                                                  **
// **                                                                                  **

function validateFtpmode($ftpmode) {

// --------------
// This function validates the FTP mode
// --------------

	if ($ftpmode == "ascii" || $ftpmode == "binary" || $ftpmode == "automatic") {
		return $ftpmode;
	}
	elseif (isset($_COOKIE["net2ftpcookie_ftpmode"]) == true && ($_COOKIE["net2ftpcookie_ftpmode"] == "ascii" || $_COOKIE["net2ftpcookie_ftpmode"] == "binary" || $_COOKIE["net2ftpcookie_ftpmode"] == "automatic")) {
		return $_COOKIE["net2ftpcookie_ftpmode"];
	}
	else {
// Before PHP version 4.3.11, bug 27633 can cause problems in ASCII mode ==> use BINARY mode
// As from PHP version 4.3.11, bug 27633 is fixed ==> use Automatic mode
		if (version_compare(phpversion(), "4.3.11", "<")) { return "binary"; }
		else                                              { return "automatic"; }
	}

} // end validateFtpmode

// **                                                                                  **
// **                                                                                  **
// **************************************************************************************
// **************************************************************************************





// **************************************************************************************
// **************************************************************************************
// **                                                                                  **
// **                                                                                  **

function validatePassivemode($passivemode) {

// --------------
// This function validates the passive mode
// --------------

	if ($passivemode != "yes") {
		$passivemode = "no";
	}
	return $passivemode;

} // end validatePassivemode

// **                                                                                  **
// **                                                                                  **
// **************************************************************************************
// **************************************************************************************





// **************************************************************************************
// **************************************************************************************
// **                                                                                  **
// **                                                                                  **

function validateSslconnect($sslmode) {

// --------------
// This function validates the SSL mode
// --------------

	if ($sslmode != "yes") {
		$sslmode = "no";
	}
	return $sslmode;

} // end validateSslconnect

// **                                                                                  **
// **                                                                                  **
// **************************************************************************************
// **************************************************************************************





// **************************************************************************************
// **************************************************************************************
// **                                                                                  **
// **                                                                                  **

function validateViewmode($viewmode) {

// --------------
// This function validates the view mode
// --------------

	if ($viewmode != "icons") {
		$viewmode = "list";
	}
	return $viewmode;

} // end validateViewmode

// **                                                                                  **
// **                                                                                  **
// **************************************************************************************
// **************************************************************************************





// **************************************************************************************
// **************************************************************************************
// **                                                                                  **
// **                                                                                  **

function validateSort($sort) {

// --------------
// This function validates the sorting criteria
// --------------

	if (	$sort != "" &&
		$sort != "dirfilename" &&
		$sort != "type" &&
		$sort != "size" &&
		$sort != "owner" &&
		$sort != "group" &&
		$sort != "permissions" &&
		$sort != "mtime") {
		$sort = "dirfilename";
	}
	return $sort;

} // end validateSort

// **                                                                                  **
// **                                                                                  **
// **************************************************************************************
// **************************************************************************************





// **************************************************************************************
// **************************************************************************************
// **                                                                                  **
// **                                                                                  **

function validateSortorder($sortorder) {

// --------------
// This function validates the sort order
// --------------

	if (	$sortorder != "" &&
		$sortorder != "descending") {
		$sortorder = "ascending";
	}
	return $sortorder;

} // end validateSortorder

// **                                                                                  **
// **                                                                                  **
// **************************************************************************************
// **************************************************************************************





// **************************************************************************************
// **************************************************************************************
// **                                                                                  **
// **                                                                                  **

function validateState($state) {

// --------------
// This function validates the state variable
// --------------

	$statelist[] = "admin";
	$statelist[] = "admin_createtables";
	$statelist[] = "admin_emptylogs";
	$statelist[] = "admin_viewlogs";
	$statelist[] = "advanced";
	$statelist[] = "advanced_ftpserver";
	$statelist[] = "advanced_parsing";
	$statelist[] = "advanced_webserver";
	$statelist[] = "bookmark";
	$statelist[] = "browse";
	$statelist[] = "calculatesize";
	$statelist[] = "chmod";
	$statelist[] = "clearcookies";
	$statelist[] = "copymovedelete";
	$statelist[] = "downloadfile";
	$statelist[] = "downloadzip";
	$statelist[] = "edit";
	$statelist[] = "findstring";
	$statelist[] = "followsymlink";
	$statelist[] = "install";
	$statelist[] = "jupload";
	$statelist[] = "login";
	$statelist[] = "login_small";
	$statelist[] = "logout";
	$statelist[] = "newdir";
	$statelist[] = "newfile";
	$statelist[] = "raw";
	$statelist[] = "rename";
	$statelist[] = "unzip";
	$statelist[] = "upload";
      $statelist[] = "view";
	$statelist[] = "zip";

	if (in_array($state, $statelist) == false) {
		$state = "login";
	}

	return $state;

} // end validateState

// **                                                                                  **
// **                                                                                  **
// **************************************************************************************
// **************************************************************************************





// **************************************************************************************
// **************************************************************************************
// **                                                                                  **
// **                                                                                  **

function validateState2($state2) {

// --------------
// This function validates the state2 variable
// --------------

	if ($state2 != "") {

// State2 may only contain specific characters
		$state2 = preg_replace("/[^A-Za-z0-9_-]/", "", $state2);
	}

	return $state2;

} // end validateState2

// **                                                                                  **
// **                                                                                  **
// **************************************************************************************
// **************************************************************************************





// **************************************************************************************
// **************************************************************************************
// **                                                                                  **
// **                                                                                  **

function validateEntry($entry) {

// --------------
// This function validates the entry
// Remove the following characters \/:*?"<>|
// --------------

// Remove \ / : * ? < > |
	$entry = preg_replace("/[\\\\\\/\\:\\*\\?\\<\\>\\|]/", "", $entry);

	return $entry;

} // end validateEntry

// **                                                                                  **
// **                                                                                  **
// **************************************************************************************
// **************************************************************************************





// **************************************************************************************
// **************************************************************************************
// **                                                                                  **
// **                                                                                  **

function validateScreen($screen) {

// --------------
// This function validates the screen variable
// --------------

	if ($screen != 1 && $screen != 2 && $screen != 3) {
		$screen = 1;
	}
	return $screen;

} // end validateScreen

// **                                                                                  **
// **                                                                                  **
// **************************************************************************************
// **************************************************************************************





// **************************************************************************************
// **************************************************************************************
// **                                                                                  **
// **                                                                                  **

function validateDirectory($directory) {

// --------------
// Input: "/dir1/dir2/dir3/../../dir4/dir5"
// Output: "/dir1/dir4/dir5"
// Remove the following characters \/:*?"<>|
// --------------

// -------------------------------------------------------------------------
// Nothing to do if the directory is the root directory
// -------------------------------------------------------------------------
	if     ($directory == "")  { return ""; }
	elseif ($directory == "/") { return "/"; }

// -------------------------------------------------------------------------
// Check if the directory contains ".."
// -------------------------------------------------------------------------
	if (strpos($directory, "..") === false) {
		$directory = "/" . stripDirectory($directory);
	}
	else {
		$directory = stripDirectory($directory);

// Split down into parts
// directoryparts[0] contains the first part, directoryparts[1] the second,...
		$directoryparts = explode("/", $directory);

// Start from the end
// If you encounter N times a "..", do not take into account the next N parts which are not ".."
// Example: "/dir1/dir2/dir3/../../dir4/dir5"  ---->  "/dir1/dir4/dir5"
		$doubledotcounter = 0;
		$newdirectory = "";
		$sizeof_directoryparts = sizeof($directoryparts);
		for ($i=$sizeof_directoryparts-1; $i>=0; $i=$i-1) {
			if ($directoryparts[$i] == "..") { $doubledotcounter = $doubledotcounter + 1; }
			else {
				if     ($doubledotcounter == 0) { $newdirectory = $directoryparts[$i] . "/" . $newdirectory; } // Add the new part in front
				elseif ($doubledotcounter > 0)  { $doubledotcounter = $doubledotcounter - 1; }                 // Don't add the part, and reduce the counter by 1
			}
		} // end for

		$directory = "/" . stripDirectory($newdirectory);

	} // end if else

// Remove : * ? " < > |
//	$directory = preg_replace("/[\\:\\*\\?\\\"\\<\\>\\|]/", "", $directory);

// Remove : * ? < > |
	$directory = preg_replace("/[\\:\\*\\?\\<\\>\\|]/", "", $directory);

	return $directory;

} // end validateDirectory

// **                                                                                  **
// **                                                                                  **
// **************************************************************************************
// **************************************************************************************





// **************************************************************************************
// **************************************************************************************
// **                                                                                  **
// **                                                                                  **

function validateFileGetContents($file) {

// --------------
// This function validates a filename; it may not contain ../ or ..\ or %00
// This is used to secure tiny_mce_gzip.php
// --------------

	$file = str_replace("../", "", $file);
	$file = str_replace("..\\", "", $file);
	$file = str_replace("%00", "", $file);
	return $file;

} // end validateFileGetContents

// **                                                                                  **
// **                                                                                  **
// **************************************************************************************
// **************************************************************************************





// **************************************************************************************
// **************************************************************************************
// **                                                                                  **
// **                                                                                  **

function validateGenericInput($input) {

// --------------
// Remove the following characters <>
// --------------

	$input = preg_replace("/\\<\\>]/", "", $input);
	return $input;

} // end validateGenericInput

// **                                                                                  **
// **                                                                                  **
// **************************************************************************************
// **************************************************************************************





// **************************************************************************************
// **************************************************************************************
// **                                                                                  **
// **                                                                                  **

function validateTextareaType($textareaType) {

// --------------
// Remove the following characters <>
// --------------

	if (	$textareaType != "plain" &&
		$textareaType != "fckeditor" &&
		$textareaType != "tinymce" &&
		$textareaType != "codepress") {
		$textareaType = "plain";
	}
	return $textareaType;

} // end validateTextareaType

// **                                                                                  **
// **                                                                                  **
// **************************************************************************************
// **************************************************************************************

?>