<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne IronBASE ausgef&uuml;hrt werden.');

ib_newdatabasetable('dokumente', $m2, 'user', "bigint(21) NOT NULL default '0'",
                                      'folder', "bigint(21) NOT NULL default '0'",
                                      'name', "varchar(255) NOT NULL default ''",
                                      'text', "longtext NOT NULL");

if (function_exists('set_searchable')) set_searchable($m2, 'dokumente', 1);

?>