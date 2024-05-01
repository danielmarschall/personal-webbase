<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

wb_newdatabasetable('net2ftp', $m2, 'user_cnid', "bigint(21) NOT NULL default '0'",
	'folder_cnid', "bigint(21) NOT NULL default '0'",
	'username', "varchar(255) NOT NULL default ''",
	'password', "varchar(255) NOT NULL default ''",
	'server', "varchar(255) NOT NULL default ''",
	'port', "int(11) NOT NULL default 21",
	'home_directory', "varchar(255) NOT NULL default ''");

if (function_exists('set_searchable')) set_searchable($m2, 'net2ftp', 1);

?>