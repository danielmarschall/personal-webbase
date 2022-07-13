<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

// Alle Konfigurationswerte löschen, bei denen kein Modul im Modulordner gefunden werden kann.

/* $res = db_query("SELECT `id`, `modul` FROM `".$mysql_zugangsdaten['praefix']."konfig`");
while ($row = db_fetch($res))
{
  if (file_exists('modules/moddir.txt') && (!is_dir('modules/'.wb_dir_escape($row['modul']))))
  {
    db_query("DELETE FROM `".$mysql_zugangsdaten['praefix']."konfig` WHERE `id` = '".$row['id']."'");
    if (db_affected_rows() > 0)
      db_query("OPTIMIZE TABLE `".$mysql_zugangsdaten['praefix']."konfig`");
  }
} */

?>
