<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne IronBASE ausgef&uuml;hrt werden.');

// db_query("DELETE FROM `".$mysql_zugangsdaten['praefix']."kalender` WHERE (((`end_date` >= `start_date`) AND (`end_date` <= DATE_SUB(NOW(), INTERVAL 7 DAY))) OR ((`end_date` > `start_date`) AND (`start_date` <= DATE_SUB(NOW(), INTERVAL 7 DAY))))");
// if (db_affected_rows() > 0)
//   db_query("OPTIMIZE TABLE `".$mysql_zugangsdaten['praefix']."kalender`");

db_query("DELETE FROM `".$mysql_zugangsdaten['praefix']."kalender` WHERE `start_date` <= DATE_SUB(NOW(), INTERVAL 7 DAY)");
if (db_affected_rows() > 0)
  db_query("OPTIMIZE TABLE `".$mysql_zugangsdaten['praefix']."kalender`");

?>