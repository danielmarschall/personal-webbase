<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne IronBASE ausgef&uuml;hrt werden.');

ib_newdatabasetable('datentraeger_eintraege', $m2, 'user', "bigint(21) NOT NULL default '0'",
                                                   'nr', "bigint(21) NOT NULL default '0'",
                                                   'kategorie', "varchar(255) NOT NULL default '0'",
                                                   'name', "varchar(255) NOT NULL default ''",
                                                   'medium', "enum('CD','DVD') NOT NULL default 'CD'",
                                                   'einstellungsdatum', "datetime NOT NULL default '0000-00-00 00:00:00'",
                                                   'gebrannt', "enum('1','0') NOT NULL default '1'",
                                                   'aussortiert', "enum('1','0') NOT NULL default '0'");

if (function_exists('set_searchable')) set_searchable($m2, 'datentraeger_eintraege', 0);

ib_newdatabasetable('datentraeger_inhalt', $m2, 'user', "bigint(21) NOT NULL default '0'",
                                                'kategorie', "varchar(255) NOT NULL default ''",
                                                'eintrag', "bigint(21) NOT NULL default '0'",
                                                'komplett', "longtext NOT NULL");

if (function_exists('set_searchable')) set_searchable($m2, 'datentraeger_inhalt', 0);

my_add_key($mysql_zugangsdaten['praefix'].'datentraeger_inhalt', 'eintrag', true, 'eintrag');

// Abwärtskompatibilität, Update 0.58 -> 0.59
if (!isset($datenbanktabellen[$mysql_zugangsdaten['praefix'].'datentraeger_kategorien']['nummer']))
{
  db_query("ALTER TABLE `".$mysql_zugangsdaten['praefix']."datentraeger_kategorien` ADD `nummer` bigint(21) NOT NULL default '0'");
  $datenbanktabellen[$mysql_zugangsdaten['praefix'].'datentraeger_kategorien']['nummer'] = 'bigint(21)/NO//0/';
  db_query("UPDATE `".$mysql_zugangsdaten['praefix']."datentraeger_kategorien` SET `nummer` = `id`");
  db_query("ALTER TABLE `".$mysql_zugangsdaten['praefix']."datentraeger_kategorien` DROP `id`");
  db_query("ALTER TABLE `".$mysql_zugangsdaten['praefix']."datentraeger_kategorien` ADD `id` BIGINT(21) NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST");
}

ib_newdatabasetable('datentraeger_kategorien', $m2, 'user', "bigint(21) NOT NULL default '0'",
                                                    'name', "varchar(255) NOT NULL default ''",
                                                    'nummer', "bigint(21) NOT NULL default '0'",
                                                    'spalte', "char(1) NOT NULL default ''");

my_add_key($mysql_zugangsdaten['praefix'].'datentraeger_kategorien', 'spalte_and_nummer', true, 'spalte', 'nummer');

if (function_exists('set_searchable')) set_searchable($m2, 'datentraeger_kategorien', 0);

?>