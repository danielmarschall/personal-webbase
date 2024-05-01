<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

// ANGABEN ZUR DATENBANKKONNEKTIVITÄT

$mysql_access_data['server'] = 'localhost';
$mysql_access_data['port'] = '';
$mysql_access_data['prefix'] = 'webbase_';
$mysql_access_data['username'] = 'root';
$mysql_access_data['password'] = '';
$mysql_access_data['database'] = 'webbase';
$mysql_access_data['use_mysqli'] = false;

// WEITERE ANGABEN

$lock = 0;
$force_ssl = 0;

?>
