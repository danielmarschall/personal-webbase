<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

wb_newdatabasetable('fatalvortex', $m2, 'user_cnid', "bigint(21) NOT NULL default '0'",
	'folder_cnid', "bigint(21) NOT NULL default '0'",
	'name', "varchar(255) NOT NULL default ''",
	'username', "varchar(255) NOT NULL default ''",
	'password', "varchar(255) NOT NULL default ''");

if (function_exists('set_searchable')) set_searchable($m2, 'fatalvortex', 1);

?>