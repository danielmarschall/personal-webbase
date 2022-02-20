<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne IronBASE ausgef&uuml;hrt werden.');

if (!isset($datenbanktabellen[$mysql_zugangsdaten['praefix'].'module']['is_searchable']))
  db_query("ALTER TABLE `".$mysql_zugangsdaten['praefix']."module` ADD `is_searchable` ENUM('0', '1') NOT NULL DEFAULT '0'");

?>