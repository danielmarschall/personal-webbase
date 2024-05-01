<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

wb_add_config('enable_gast', '0', $m2);
wb_add_config('gast_username', 'test', $m2);
wb_add_config('gast_password', 'iridium', $m2);
wb_add_config('wipe_gastkonto', '0', $m2);
wb_add_config('last_wipe', '0000-00-00', $m2);
wb_add_config('wipe_uhrzeit', '03:00:00', $m2);

$res = db_query("SELECT * FROM `".$WBConfig->getMySQLPrefix()."users` WHERE `username` = 'test'");
if (db_num($res) == 0)
	db_query("INSERT INTO `".$WBConfig->getMySQLPrefix()."users` (`username`, `email`, `banned`, `personal_name`, `password`, `created_database`, `last_login`) VALUES ('test', '', '0', 'Personal WebBase Testbenutzer', '".md5('iridium')."', NOW(), '0000-00-00 00:00:00')");

?>