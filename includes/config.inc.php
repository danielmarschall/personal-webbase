<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne IronBASE ausgef&uuml;hrt werden.');

// ANGABEN ZUR DATENBANKKONNEKTIVIT�T

$mysql_zugangsdaten['server'] = 'localhost';
$mysql_zugangsdaten['port'] = '';

// achtung! user_popper ist noch nicht dazu f�hig, mit anderen datenbank-pr�fixes umzugehen!
$mysql_zugangsdaten['praefix'] = 'ironbase_';

$mysql_zugangsdaten['username'] = 'root';
$mysql_zugangsdaten['passwort'] = '';
$mysql_zugangsdaten['datenbank'] = 'ironbase';

$mysql_zugangsdaten['use_mysqli'] = false;

// WEITERE ANGABEN

$lock = 0;
$force_ssl = 0;

?>