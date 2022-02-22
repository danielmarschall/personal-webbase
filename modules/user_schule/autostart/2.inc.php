<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

ib_newdatabasetable('schule_jahrgaenge', $m2, 'user', "bigint(21) NOT NULL default '0'",
                                              'folder', "bigint(21) NOT NULL default '0'",
                                              'name', "varchar(255) NOT NULL default ''",
                                              'notensystem', "bigint(11) NOT NULL default '0'",
                                              'jahr', "varchar(4)");

if (function_exists('set_searchable')) set_searchable($m2, 'schule_jahrgaenge', 1);


ib_newdatabasetable('schule_faecher', $m2, 'user', "bigint(21) NOT NULL default '0'",
                                           'jahrgang', "bigint(21) NOT NULL default '0'",
                                           'name', "varchar(255) NOT NULL default ''",
                                           'wertungsfaktor', "bigint(11) NOT NULL default '1'",
                                           'positiv', "float NOT NULL default '0'",
                                           'negativ', "float NOT NULL default '0'");

if (function_exists('set_searchable')) set_searchable($m2, 'schule_faecher', 0);

ib_newdatabasetable('schule_noten', $m2, 'user', "bigint(21) NOT NULL default '0'",
                                         'jahrgang', "bigint(21) NOT NULL default '0'",
                                         'fach', "bigint(21) NOT NULL default '0'",
                                         'name', "varchar(255) NOT NULL default ''",
                                         'wertung', "varchar(5) NOT NULL default ''",
                                         'note', "varchar(5) NOT NULL default ''");

if (function_exists('set_searchable')) set_searchable($m2, 'schule_noten', 0);

ib_newdatabasetable('schule_hausaufgaben', $m2, 'user', "bigint(21) NOT NULL default '0'",
                                                'jahrgang', "bigint(21) NOT NULL default '0'",
                                                'fach', "bigint(21) NOT NULL default '0'",
                                                'text', "varchar(255) NOT NULL default ''");

if (function_exists('set_searchable')) set_searchable($m2, 'schule_hausaufgaben', 0);

?>
