<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne IronBASE ausgef&uuml;hrt werden.');

ib_newdatabasetable('ordner', $m2, 'user', "bigint(21) NOT NULL default '0'",
                                   'folder', "bigint(21) NOT NULL default '0'",
                                   'kategorie', "varchar(255) NOT NULL default ''",
                                   'name', "text NOT NULL");

if (function_exists('set_searchable')) set_searchable($m2, 'ordner', 1);

?>