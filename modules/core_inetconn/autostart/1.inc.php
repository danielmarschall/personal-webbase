<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

function inetconn_ok()
{
  global $konfiguration;

  // Ergebnis für Scriptlaufzeit zwischenspeichern aufgrund von Performancegründen
  if (defined('inet_conn_result'))
  {
    return inet_conn_result;
  }
  else
  {
    $r = fsockopen($konfiguration['core_inetconn']['internet-check-url'], $konfiguration['core_inetconn']['internet-check-port'], $errno, $errstr, 5);
    define('inet_conn_result', $r);
    return $r;
  }
}

?>
