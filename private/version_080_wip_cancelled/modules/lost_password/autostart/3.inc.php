<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

if (!isset($tables_database[$WBConfig->getMySQLPrefix().'users']['new_password']))
{
	db_query("ALTER TABLE `".$WBConfig->getMySQLPrefix()."users` ADD `new_password` VARCHAR(10) NOT NULL");
}

?>