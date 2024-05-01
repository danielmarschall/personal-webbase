<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

wb_newdatabasetable('files', $m2, 'user_cnid', "bigint(21) NOT NULL default '0'",
	'name', "varchar(255) NOT NULL default ''",
	'folder_cnid', "bigint(21) NOT NULL default '0'",
	'filename', "varchar(255) NOT NULL default ''",
	'type', "varchar(255) NOT NULL default ''",
	'data', "longblob NOT NULL");

if (function_exists('set_searchable')) set_searchable($m2, 'files', 1);

?>