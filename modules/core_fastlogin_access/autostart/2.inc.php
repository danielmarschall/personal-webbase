<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

ib_add_config('enabled', '1', $m2);

if (!isset($datenbanktabellen[$mysql_zugangsdaten['praefix'].'users']['fastlogin_secret']))
  db_query("ALTER TABLE `".$mysql_zugangsdaten['praefix']."users` ADD `fastlogin_secret` varchar(255) NOT NULL default ''");

?>
