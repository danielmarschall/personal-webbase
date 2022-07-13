<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

// Alle Datensätze löschen, zu denen kein gültiger Benutzereintrag gefunden wurde.

$my_str = '';
$res = db_query("SELECT `id` FROM `".$mysql_zugangsdaten['praefix']."users`");
while ($row = db_fetch($res))
  $my_str .= "'".$row['id']."', ";
$my_str = substr($my_str, 0, strlen($my_str)-2);

$res = db_query("SELECT `table` FROM `".$mysql_zugangsdaten['praefix']."module`");
while ($row = db_fetch($res))
{
  if (($my_str != '') && (isset($datenbanktabellen[$mysql_zugangsdaten['praefix'].$row['table']]['user'])))
  {
    db_query("DELETE FROM `".$mysql_zugangsdaten['praefix'].$row['table']."` WHERE `user` NOT IN ($my_str)");
    if (db_affected_rows() > 0)
      db_query("OPTIMIZE TABLE `".$mysql_zugangsdaten['praefix'].$row['table']."`");
  }
}

?>
