<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

// Datenbankreinigung: IDs sammeln
$faecher = '';
$res = db_query("SELECT `id` FROM `".$mysql_zugangsdaten['praefix']."schule_faecher`");
while ($row = db_fetch($res))
  $faecher .= "'".$row['id']."', ";
$faecher = substr($faecher, 0, strlen($faecher)-2);

$jahrgaenge = '';
$res = db_query("SELECT `id` FROM `".$mysql_zugangsdaten['praefix']."schule_jahrgaenge`");
while ($row = db_fetch($res))
  $jahrgaenge .= "'".$row['id']."', ";
$jahrgaenge = substr($jahrgaenge, 0, strlen($jahrgaenge)-2);

// Alle Noten l�schen, zu denen kein g�ltiges Fach/Jahrgang gefunden wurde.
if (($faecher != '') && ($jahrgaenge != ''))
{
  db_query("DELETE FROM `".$mysql_zugangsdaten['praefix']."schule_noten` WHERE `fach` NOT IN ($faecher) AND `jahrgang` NOT IN ($jahrgaenge)");
  if (db_affected_rows() > 0)
    db_query("OPTIMIZE TABLE `".$mysql_zugangsdaten['praefix']."schule_noten`");
}

// Alle F�cher l�schen, zu denen kein g�ltiger Jahrgang gefunden wurde.
if ($jahrgaenge != '')
{
  db_query("DELETE FROM `".$mysql_zugangsdaten['praefix']."schule_faecher` WHERE `jahrgang` NOT IN ($jahrgaenge)");
  if (db_affected_rows() > 0)
    db_query("OPTIMIZE TABLE `".$mysql_zugangsdaten['praefix']."schule_faecher`");
}

// Alle Hausaufgaben l�schen, zu denen kein g�ltiger Jahrgang gefunden wurde.
if ($jahrgaenge != '')
{
  db_query("DELETE FROM `".$mysql_zugangsdaten['praefix']."schule_hausaufgaben` WHERE `jahrgang` NOT IN ($jahrgaenge)");
  if (db_affected_rows() > 0)
    db_query("OPTIMIZE TABLE `".$mysql_zugangsdaten['praefix']."schule_hausaufgaben`");
}

?>
