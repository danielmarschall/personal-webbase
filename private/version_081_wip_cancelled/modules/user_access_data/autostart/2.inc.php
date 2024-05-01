<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

wb_newdatabasetable('access_data', $m2, 'user_cnid', "bigint(21) NOT NULL default '0'",
	'folder_cnid', "bigint(21) NOT NULL default '0'",
	'name', "varchar(255) NOT NULL default ''",
	'url', "varchar(255) NOT NULL default ''",
	'status', "varchar(255) NOT NULL default ''",
	'text', "longtext NOT NULL");

if (function_exists('set_searchable')) set_searchable($m2, 'access_data', 1);

?>