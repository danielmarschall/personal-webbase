<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

wb_newdatabasetable('calendar', $m2, 'user_cnid', "bigint(21) NOT NULL default '0'",
	'name', "varchar(255) NOT NULL default ''",
	'start_date', "date NOT NULL default '0000-00-00'",
	'start_time', "time NOT NULL default '00:00:00'",
	'note', "longtext NOT NULL");

if (function_exists('set_searchable')) set_searchable($m2, 'calendar', 1);

?>