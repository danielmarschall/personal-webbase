<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

ib_newdatabasetable('kalender', $m2, 'user', "bigint(21) NOT NULL default '0'",
                                    'name', "varchar(255) NOT NULL default ''",
                                    'start_date', "date NULL",
                                    'start_time', "time NULL",
                                    'kommentare', "longtext NOT NULL");

if (function_exists('set_searchable')) set_searchable($m2, 'kalender', 1);

?>
