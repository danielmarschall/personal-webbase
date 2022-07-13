<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

ib_newdatabasetable('confixx', $m2, 'user', "bigint(21) NOT NULL default '0'",
                                    'folder', "bigint(21) NOT NULL default '0'",
                                    'username', "varchar(255) NOT NULL default ''",
                                    'passwort', "varchar(255) NOT NULL default ''",
                                    'server', "varchar(255) NOT NULL default ''");

if (function_exists('set_searchable')) set_searchable($m2, 'confixx', 1);

?>
