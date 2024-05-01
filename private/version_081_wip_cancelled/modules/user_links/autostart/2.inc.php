<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

wb_newdatabasetable('links', $m2, 'user_cnid', "bigint(21) NOT NULL default '0'",
	'folder_cnid', "bigint(21) NOT NULL default '0'",
	'name', "text NOT NULL",
	'url', "text NOT NULL",
	'update_enabled', "enum('0','1') NOT NULL default '0'",
	'update_checkurl', "varchar(255) NOT NULL default ''",
	'update_text_begin', "longtext NOT NULL",
	'update_text_end', "longtext NOT NULL",
	'update_lastchecked', "datetime NOT NULL default '0000-00-00 00:00:00'",
	'update_lastcontent', "varchar(255) NOT NULL default ''",
	'new_tag', "enum('0','1') NOT NULL default '0'",
	'broken_tag', "enum('0','1') NOT NULL default '0'");

if (function_exists('set_searchable')) set_searchable($m2, 'links', 1);

wb_add_config('update_checkinterval_min', '60', $m2);
wb_add_config('kaputt_checkinterval_min', '5', $m2);

?>