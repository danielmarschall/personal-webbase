<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne IronBASE ausgef&uuml;hrt werden.');

if (!isset($datenbanktabellen[$mysql_zugangsdaten['praefix'].'users']['new_password']))
  db_query("ALTER TABLE `".$mysql_zugangsdaten['praefix']."users` ADD `new_password` VARCHAR(10) NOT NULL");

?>