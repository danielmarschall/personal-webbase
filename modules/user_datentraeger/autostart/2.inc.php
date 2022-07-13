<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

ib_newdatabasetable('datentraeger_eintraege', $m2, 'user', "bigint(21) NOT NULL default '0'",
                                                   'nr', "bigint(21) NOT NULL default '0'",
                                                   'kategorie', "varchar(255) NOT NULL default '0'",
                                                   'name', "varchar(255) NOT NULL default ''",
                                                   'medium', "enum('CD','DVD') NOT NULL default 'CD'",
                                                   'einstellungsdatum', "datetime NULL",
                                                   'gebrannt', "enum('1','0') NOT NULL default '1'",
                                                   'aussortiert', "enum('1','0') NOT NULL default '0'");

if (function_exists('set_searchable')) set_searchable($m2, 'datentraeger_eintraege', 0);

ib_newdatabasetable('datentraeger_inhalt', $m2, 'user', "bigint(21) NOT NULL default '0'",
                                                'kategorie', "varchar(255) NOT NULL default ''",
                                                'eintrag', "bigint(21) NOT NULL default '0'",
                                                'komplett', "longtext NOT NULL");

if (function_exists('set_searchable')) set_searchable($m2, 'datentraeger_inhalt', 0);

my_add_key($mysql_zugangsdaten['praefix'].'datentraeger_inhalt', 'eintrag', true, 'eintrag');

ib_newdatabasetable('datentraeger_kategorien', $m2, 'user', "bigint(21) NOT NULL default '0'",
                                                    'name', "varchar(255) NOT NULL default ''",
                                                    'nummer', "bigint(21) NOT NULL default '0'",
                                                    'spalte', "char(1) NOT NULL default ''");

my_add_key($mysql_zugangsdaten['praefix'].'datentraeger_kategorien', 'spalte_and_nummer', true, 'spalte', 'nummer');

if (function_exists('set_searchable')) set_searchable($m2, 'datentraeger_kategorien', 0);
