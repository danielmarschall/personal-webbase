<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

ib_newdatabasetable('tabellen', $m2, 'user', "bigint(21) NOT NULL default '0'",
                                     'folder', "bigint(21) NOT NULL default '0'",
                                     'name', "varchar(255) NOT NULL default ''",
                                     'data', "longtext NOT NULL");

if (function_exists('set_searchable')) set_searchable($m2, 'tabellen', 1);

?>
