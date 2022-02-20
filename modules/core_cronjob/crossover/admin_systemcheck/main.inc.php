<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

$meldung = '';

if ($konfiguration[$m2]['passivcron'] == '1')
{
  $meldung .= '<font color="#FF0000">Der serverseitige Crondienst ist auf diesem Server gest&ouml;rt oder deaktiviert!</font>';

  /*
  $meldung .= '<br>Tipp: <a href="https://personal-webbase.de/promoting.html';

  if ($_SERVER["SERVER_ADDR"] != '127.0.0.1')
  {
    $meldung .= '?url=';
    if ($force_ssl)
      $meldung .= 'https://';
    else
      $meldung .= 'http://';
    $meldung .= $_SERVER["HTTP_HOST"].str_replace('\\', '/', dirname($_SERVER["PHP_SELF"]));
  }
  $meldung .= '" target="_blank">Jetzt ViaThinkSoft-Promoting kostenlos nutzen!</a>';
  */
}
else
  $meldung .= '<font color="#00BB00">Der serverseitige Crondienst ist im Moment auf diesem Server in Ordnung!</font>';

$meldung .= '<br>Der letzte Crondurchlauf war am <b>'.de_convertmysqldatetime($konfiguration[$m2]['last_cronjob']).'</b> durch einen <b>';

if ($konfiguration[$m2]['passivcron'] == '1')
  $meldung .= 'passiven';
else
  $meldung .= 'aktiven';

$meldung .= ' Aufruf</b>.';

if ($konfiguration[$m2]['passivcron'] == '0')
{
  $meldung .= '<br>Der letzte Aufruf wurde ';

  if ($konfiguration[$m2]['lastpromotor'] == '')
    $meldung .= 'von der <b>Shell</b> durchgef&uuml;hrt';
  else
    $meldung .= 'von einem fremden Rechner durchgef&uuml;hrt (promoting): <a href="http://'.$konfiguration[$m2]['lastpromotor'].'/" target="_blank"><b>'.$konfiguration[$m2]['lastpromotor'].'</b></a>';
}

?>
