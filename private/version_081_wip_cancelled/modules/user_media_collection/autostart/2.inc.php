<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

wb_newdatabasetable('mediacollection_entries', $m2, 'user_cnid', "bigint(21) NOT NULL default '0'",
	'nr', "bigint(21) NOT NULL default '0'",
	'category', "varchar(255) NOT NULL default '0'",
	'name', "varchar(255) NOT NULL default ''",
	'medium', "enum('CD','DVD') NOT NULL default 'CD'",
	'einstellungsdatum', "datetime NOT NULL default '0000-00-00 00:00:00'",
	'gebrannt', "enum('1','0') NOT NULL default '1'",
	'aussortiert', "enum('1','0') NOT NULL default '0'");

if (function_exists('set_searchable')) set_searchable($m2, 'mediacollection_entries', 0);

wb_newdatabasetable('mediacollection_content', $m2, 'user_cnid', "bigint(21) NOT NULL default '0'",
	'category', "varchar(255) NOT NULL default ''",
	'eintrag', "bigint(21) NOT NULL default '0'",
	'komplett', "longtext NOT NULL");

if (function_exists('set_searchable')) set_searchable($m2, 'mediacollection_content', 0);

my_add_key($WBConfig->getMySQLPrefix().'mediacollection_content', 'eintrag', true, 'eintrag');

wb_newdatabasetable('mediacollection_categories', $m2, 'user_cnid', "bigint(21) NOT NULL default '0'",
	'name', "varchar(255) NOT NULL default ''",
	'nummer', "bigint(21) NOT NULL default '0'",
	'spalte', "char(1) NOT NULL default ''");

my_add_key($WBConfig->getMySQLPrefix().'mediacollection_categories', 'spalte_and_nummer', true, 'spalte', 'nummer');

if (function_exists('set_searchable')) set_searchable($m2, 'mediacollection_categories', 0);

?>