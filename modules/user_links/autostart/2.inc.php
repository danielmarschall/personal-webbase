<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

ib_newdatabasetable('links', $m2, 'user', "bigint(21) NOT NULL default '0'",
                                  'folder', "bigint(21) NOT NULL default '0'",
                                  'name', "text NOT NULL",
                                  'url', "text NOT NULL",
                                  'update_enabled', "enum('0','1') NOT NULL default '0'",
                                  'update_checkurl', "varchar(255) NOT NULL default ''",
                                  'update_text_begin', "longtext NOT NULL",
                                  'update_text_end', "longtext NOT NULL",
                                  'update_lastchecked', "datetime NULL",
                                  'update_lastcontent', "varchar(255) NOT NULL default ''",
                                  'neu_flag', "enum('0','1') NOT NULL default '0'",
                                  'kaputt_flag', "enum('0','1') NOT NULL default '0'");

// Abwärtskompatibilität, Update 0.58 -> 0.59
if (isset($datenbanktabellen[$mysql_zugangsdaten['praefix'].'links']['update_flag']))
{
  db_query("UPDATE `".$mysql_zugangsdaten['praefix']."links` SET `neu_flag` = '1' WHERE `update_flag` = '1'");
  db_query("UPDATE `".$mysql_zugangsdaten['praefix']."links` SET `kaputt_flag` = '1' WHERE `update_flag` = '2'");
  db_query("ALTER TABLE `".$mysql_zugangsdaten['praefix']."links` DROP `update_flag`");
}

if (function_exists('set_searchable')) set_searchable($m2, 'links', 1);

ib_add_config('update_checkinterval_min', '60', $m2);
ib_add_config('kaputt_checkinterval_min', '5', $m2);

?>
