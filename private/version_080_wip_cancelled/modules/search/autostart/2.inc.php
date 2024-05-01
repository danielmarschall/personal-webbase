<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

if (!isset($tables_database[$WBConfig->getMySQLPrefix().'modules']['is_searchable']))
	db_query("ALTER TABLE `".$WBConfig->getMySQLPrefix()."modules` ADD `is_searchable` ENUM('0', '1') NOT NULL DEFAULT '0'");

?>