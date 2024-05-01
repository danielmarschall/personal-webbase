<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

wb_newdatabasetable('schule_jahrgaenge', $m2, 'user_cnid', "bigint(21) NOT NULL default '0'",
	'folder_cnid', "bigint(21) NOT NULL default '0'",
	'name', "varchar(255) NOT NULL default ''",
	'notensystem', "bigint(11) NOT NULL default '0'",
	'jahr', "varchar(4)");

if (function_exists('set_searchable')) set_searchable($m2, 'schule_jahrgaenge', 1);


wb_newdatabasetable('schule_faecher', $m2, 'user_cnid', "bigint(21) NOT NULL default '0'",
	'year_cnid', "bigint(21) NOT NULL default '0'",
	'name', "varchar(255) NOT NULL default ''",
	'wertungsfaktor', "bigint(11) NOT NULL default '1'",
	'positiv', "float NOT NULL default '0'",
	'negativ', "float NOT NULL default '0'");

if (function_exists('set_searchable')) set_searchable($m2, 'schule_faecher', 0);

wb_newdatabasetable('schule_noten', $m2, 'user_cnid', "bigint(21) NOT NULL default '0'",
	'year_cnid', "bigint(21) NOT NULL default '0'",
	'fach_cnid', "bigint(21) NOT NULL default '0'",
	'name', "varchar(255) NOT NULL default ''",
	'wertung', "varchar(5) NOT NULL default ''",
	'note', "varchar(5) NOT NULL default ''");

if (function_exists('set_searchable')) set_searchable($m2, 'schule_noten', 0);

wb_newdatabasetable('schule_hausaufgaben', $m2, 'user_cnid', "bigint(21) NOT NULL default '0'",
	'year_cnid', "bigint(21) NOT NULL default '0'",
	'fach_cnid', "bigint(21) NOT NULL default '0'",
	'text', "varchar(255) NOT NULL default ''");

if (function_exists('set_searchable')) set_searchable($m2, 'schule_hausaufgaben', 0);

?>