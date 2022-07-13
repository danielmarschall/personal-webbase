<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

ib_newdatabasetable('kontakte', $m2, 'user', "bigint(21) NOT NULL default '0'",
                                     'folder', "bigint(21) NOT NULL default '0'",
                                     'name', "varchar(255) NOT NULL default ''",
                                     'strasse', "varchar(255) NOT NULL default ''",
                                     'plz', "varchar(255) NOT NULL default ''",
                                     'ort', "varchar(255) NOT NULL default ''",
                                     'land', "varchar(255) NOT NULL default ''",
                                     'telefon', "varchar(255) NOT NULL default ''",
                                     'mobil', "varchar(255) NOT NULL default ''",
                                     'fax', "varchar(255) NOT NULL default ''",
                                     'email', "varchar(255) NOT NULL default ''",
                                     'icq', "varchar(255) NOT NULL default ''",
                                     'msn', "varchar(255) NOT NULL default ''",
                                     'aim', "varchar(255) NOT NULL default ''",
                                     'yahoo', "varchar(255) NOT NULL default ''",
                                     'skype', "varchar(255) NOT NULL default ''",
                                     'kommentare', "longtext NOT NULL");

if (function_exists('set_searchable')) set_searchable($m2, 'kontakte', 1);

?>
