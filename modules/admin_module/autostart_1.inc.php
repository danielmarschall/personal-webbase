<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne IronBASE ausgef&uuml;hrt werden.');

ib_newdatabasetable('module', $m2, 'modul', "varchar(255) NOT NULL default ''",
                                   'table', "varchar(255) NOT NULL default ''");

if (function_exists('set_searchable')) set_searchable($m2, 'module', 0);

my_add_key($mysql_zugangsdaten['praefix'].'module', 'table', true, 'table');

?>