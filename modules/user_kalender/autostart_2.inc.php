<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne IronBASE ausgef&uuml;hrt werden.');

ib_newdatabasetable('kalender', $m2, 'user', "bigint(21) NOT NULL default '0'",
                                    'name', "varchar(255) NOT NULL default ''",
                                    'start_date', "date NOT NULL default '0000-00-00'",
                                    'start_time', "time NOT NULL default '00:00:00'",
                                    'kommentare', "longtext NOT NULL");

if (function_exists('set_searchable')) set_searchable($m2, 'kalender', 1);

?>