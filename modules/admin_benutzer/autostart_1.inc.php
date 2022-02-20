<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

ib_newdatabasetable('users', $m2, 'username', "varchar(255) NOT NULL default ''",
                                  'email', "varchar(255) NOT NULL default ''",
                                  'gesperrt', "enum('0','1') NOT NULL default '0'",
                                  'personenname', "varchar(255) NOT NULL default ''",
                                  'passwort', "varchar(255) NOT NULL default ''",
                                  'created_database', "datetime NULL",
                                  'creator_ip', "varchar(15) NOT NULL default ''",
                                  'last_login', "datetime NULL",
                                  'last_login_ip', "varchar(45) NOT NULL default ''");

if (function_exists('set_searchable')) set_searchable($m2, 'users', 0);

my_add_key($mysql_zugangsdaten['praefix'].'users', 'username', true, 'username');

?>
