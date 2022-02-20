<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

// TODO: integrate these functions in our db_*() function wrappers
require __DIR__.'/mysql_replacement.inc.php';

if (isset($mysql_zugangsdaten['port']) && ($mysql_zugangsdaten['port'] != ''))
  $zus = ':'.$mysql_zugangsdaten['port'];
else
  $zus = '';

function db_connect()
{
  global $mysql_zugangsdaten;
  global $ib_selc;
  global $ib_conn;

  try {
    if (((isset($mysql_zugangsdaten['use_mysqli'])) && ($mysql_zugangsdaten['use_mysqli'])))
    {
      $ib_conn = @mysqli_connect($mysql_zugangsdaten['server'].$zus, $mysql_zugangsdaten['username'], $mysql_zugangsdaten['passwort']);
      $ib_selc = @mysqli_select_db($mysql_zugangsdaten['datenbank'], $ib_conn);
    }
    else
    {
      $ib_conn = @mysql_connect($mysql_zugangsdaten['server'].$zus, $mysql_zugangsdaten['username'], $mysql_zugangsdaten['passwort']);
      $ib_selc = @mysql_select_db($mysql_zugangsdaten['datenbank'], $ib_conn);
    }
  } catch (Exception $e) {
    die('<h1>Fehler</h1>Datenbankverbindung kann nicht hergestellt werden. Bitte pr&uuml;fen Sie die Datei config.inc.php.<br><br>'.$e);
  }

  if ((!$ib_selc) || (!$ib_conn))
    die('<h1>Fehler</h1>Es konnte keine Verbindung zu dem Datenbankserver hergestellt werden.<br><br>Bitte pr&uuml;fen Sie den Serverstatus und die G&uuml;ltigkeit der Konfigurationsdatei &quot;includes/config.inc.php&quot;.<br><br>MySQL meldet folgendes:<br><br><code>'.mysql_errno().': '.mysql_error().'</code>');
}

function db_query($inp, $halte_an_bei_fehler = true)
{
  global $konfiguration;
  global $sql_transkript;
  global $mysql_zugangsdaten;

  $sql_transkript .= $inp."\n";

  if (((isset($mysql_zugangsdaten['use_mysqli'])) && ($mysql_zugangsdaten['use_mysqli'])))
    $x = @mysqli_query($inp);
  else
    $x = @mysql_query($inp);

  if ($halte_an_bei_fehler)
  {
    if (((isset($mysql_zugangsdaten['use_mysqli'])) && ($mysql_zugangsdaten['use_mysqli'])))
      $e = @mysqli_error();
    else
      $e = @mysql_error();

    if ($e != '')
    {
      $mess = '<b>MySQL-Fehler!</b><br><br>Folgender MySQL-Fehler ist aufgetreten:<br><br><code>'.$e.'</code><br><br>Folgende Query wurde ausgef&uuml;hrt:<br><br><code>'.my_htmlentities($inp).'</code><br><br>Die Scriptausf&uuml;hrung wurde aus Sicherheitsgr&uuml;nden abgebrochen.';

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
  global $mysql_zugangsdaten;

  if (((isset($mysql_zugangsdaten['use_mysqli'])) && ($mysql_zugangsdaten['use_mysqli'])))
    return @mysqli_fetch_array($inp);
  else
    return @mysql_fetch_array($inp);
}

function db_escape($inp)
{
  global $mysql_zugangsdaten;

  if (((isset($mysql_zugangsdaten['use_mysqli'])) && ($mysql_zugangsdaten['use_mysqli'])))
    return @mysqli_real_escape_string($inp);
  else
    return @mysql_real_escape_string($inp);
}

function db_simple_escape($inp)
{
  global $mysql_zugangsdaten;

  if (((isset($mysql_zugangsdaten['use_mysqli'])) && ($mysql_zugangsdaten['use_mysqli'])))
    return @mysqli_escape_string($inp);
  else
    return @mysql_escape_string($inp);
}

function db_num($inp)
{
  global $mysql_zugangsdaten;

  if (((isset($mysql_zugangsdaten['use_mysqli'])) && ($mysql_zugangsdaten['use_mysqli'])))
    return @mysqli_num_rows($inp);
  else
    return @mysql_num_rows($inp);
}

function db_affected_rows()
{
  global $mysql_zugangsdaten;

  if (((isset($mysql_zugangsdaten['use_mysqli'])) && ($mysql_zugangsdaten['use_mysqli'])))
    return @mysqli_affected_rows();
  else
    return @mysql_affected_rows();
}

function db_list_dbs()
{
  global $mysql_zugangsdaten;

  if (((isset($mysql_zugangsdaten['use_mysqli'])) && ($mysql_zugangsdaten['use_mysqli'])))
    return @mysqli_list_dbs();
  else
    return @mysql_list_dbs();
}

function db_list_tables($db)
{
  global $mysql_zugangsdaten;

  if (((isset($mysql_zugangsdaten['use_mysqli'])) && ($mysql_zugangsdaten['use_mysqli'])))
    return @mysqli_list_tables($db);
  else
    return @mysql_list_tables($db);
}

function db_error()
{
  global $mysql_zugangsdaten;

  if (((isset($mysql_zugangsdaten['use_mysqli'])) && ($mysql_zugangsdaten['use_mysqli'])))
    return @mysqli_error();
  else
    return @mysql_error();
}

function db_disconnect()
{
  global $mysql_zugangsdaten;
  @session_write_close();

  if (((isset($mysql_zugangsdaten['use_mysqli'])) && ($mysql_zugangsdaten['use_mysqli'])))
    @mysqli_close();
  else
    @mysql_close();
}

register_shutdown_function('db_disconnect');
db_connect();

?>
