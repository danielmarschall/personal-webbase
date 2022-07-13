<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

// Wir löschen ungültige Ordnerbezüge der Personal WebBase-Tabellen.
// Wenn ein Benutzer einen Ordner löscht, dann werden die Einträge und Unterordner nicht mitgelöscht
// Je nachdem, wie viele Unterordner existiert haben, hat die Datenbank nach wenigen Durchläufen
// dieser Funktion keine ungültigen Bezüge mehr.

$my_str = "'0', ";
$res = db_query("SELECT `id` FROM `".$mysql_zugangsdaten['praefix']."ordner`");
while ($row = db_fetch($res))
  $my_str .= "'".$row['id']."', ";
$my_str = substr($my_str, 0, strlen($my_str)-2);

$res = db_query("SELECT `table` FROM `".$mysql_zugangsdaten['praefix']."module`");
while ($row = db_fetch($res))
{
  if (isset($datenbanktabellen[$mysql_zugangsdaten['praefix'].$row['table']]['folder']))
  {
    db_query("DELETE FROM `".$mysql_zugangsdaten['praefix'].$row['table']."` WHERE `folder` NOT IN ($my_str)");
    if (db_affected_rows() > 0)
      db_query("OPTIMIZE TABLE `".$mysql_zugangsdaten['praefix'].$row['table']."`");
  }
}

?>
