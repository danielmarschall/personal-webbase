<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne IronBASE ausgef&uuml;hrt werden.');

ib_newdatabasetable('dateien', $m2, 'user', "bigint(21) NOT NULL default '0'",
                                    'name', "varchar(255) NOT NULL default ''",
                                    'folder', "bigint(21) NOT NULL default '0'",
                                    'dateiname', "varchar(255) NOT NULL default ''",
                                    'type', "varchar(255) NOT NULL default ''",
                                    'daten', "longblob NOT NULL");

if (function_exists('set_searchable')) set_searchable($m2, 'dateien', 1);

?>