<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

wb_newdatabasetable('folders', $m2, 'user_cnid', "bigint(21) NOT NULL default '0'",
	'folder_cnid', "bigint(21) NOT NULL default '0'",
	'category', "varchar(255) NOT NULL default ''",
	'name', "text NOT NULL");

if (function_exists('set_searchable')) set_searchable($m2, 'folders', 1);

?>