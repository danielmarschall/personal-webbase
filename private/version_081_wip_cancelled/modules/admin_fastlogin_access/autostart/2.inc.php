<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

wb_add_config('enabled', '1', $m2);

if (!isset($tables_database[$WBConfig->getMySQLPrefix().'users']['fastlogin_secret'])) {
	db_query("ALTER TABLE `".$WBConfig->getMySQLPrefix()."users` ADD `fastlogin_secret` varchar(255) NOT NULL default ''");
}

if (!isset($tables_database[$WBConfig->getMySQLPrefix().'users']['fastlogin_serial'])) {
	db_query("ALTER TABLE `".$WBConfig->getMySQLPrefix()."users` ADD `fastlogin_serial` int(11) NOT NULL default '0'");
}

?>