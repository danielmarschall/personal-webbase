<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

wb_newdatabasetable('recent_events', $m2, 'datetime', "datetime NOT NULL default '0000-00-00 00:00:00'",
	'module', "varchar(255) NOT NULL default ''",
	'message', "text NOT NULL default ''",
	'appearances', "bigint(21) NOT NULL default '1'");

?>