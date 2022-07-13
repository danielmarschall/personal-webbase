<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

$meldung = '';

if (isset($konfiguration[$m2]['debug']) && ($konfiguration[$m2]['debug']))
  $meldung .= 'Der Debug-Modus ist eingeschaltet! Der SQL-Datenverkehr wird am Seitenfu&szlig; angezeigt, was ein Sicherheitsrisiko darstellt.';

?>
