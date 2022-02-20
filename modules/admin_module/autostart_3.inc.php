<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne IronBASE ausgef&uuml;hrt werden.');

// Alle modulbezogenen Tabellen löschen, beidenen das Modul nicht mehr in dem Modulordner vorhanden ist.

/* $res = db_query("SELECT `id`, `table` FROM `".$mysql_zugangsdaten['praefix']."module`");
while ($row = db_fetch($res))
{
  if (file_exists('modules/moddir.txt') && (!is_dir('modules/'.$row['modul'])))
  {
    db_query("DELETE FROM `".$mysql_zugangsdaten['praefix'].$row['table']."`");
    if (db_affected_rows() > 0)
      db_query("OPTIMIZE TABLE `".$mysql_zugangsdaten['praefix'].$row['table']."`");

    db_query("DELETE FROM `".$mysql_zugangsdaten['praefix']."module` WHERE `id` = '".$row['id']."'");
    if (db_affected_rows() > 0)
      db_query("OPTIMIZE TABLE `".$mysql_zugangsdaten['praefix']."module`");
  }
} */

?>