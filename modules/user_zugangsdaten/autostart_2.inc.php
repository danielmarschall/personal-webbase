<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

ib_newdatabasetable('zugangsdaten', $m2, 'user', "bigint(21) NOT NULL default '0'",
                                         'folder', "bigint(21) NOT NULL default '0'",
                                         'name', "varchar(255) NOT NULL default ''",
                                         'url', "varchar(255) NOT NULL default ''",
                                         'status', "varchar(255) NOT NULL default ''",
                                         'text', "longtext NOT NULL");

if (function_exists('set_searchable')) set_searchable($m2, 'zugangsdaten', 1);

?>