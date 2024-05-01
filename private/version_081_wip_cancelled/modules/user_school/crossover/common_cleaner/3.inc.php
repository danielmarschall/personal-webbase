<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

// Datenbankreinigung: IDs sammeln

$faecher = '';
$res = db_query("SELECT `id` FROM `".$WBConfig->getMySQLPrefix()."schule_faecher`");
while ($row = db_fetch($res))
{
	$faecher .= "'".$row['id']."', ";
}
$faecher = substr($faecher, 0, strlen($faecher)-2);

$jahrgaenge = '';
$res = db_query("SELECT `id` FROM `".$WBConfig->getMySQLPrefix()."schule_jahrgaenge`");
while ($row = db_fetch($res))
{
	$jahrgaenge .= "'".$row['id']."', ";
}
$jahrgaenge = substr($jahrgaenge, 0, strlen($jahrgaenge)-2);

// Alle Noten löschen, zu denen kein gültiges Fach/Jahrgang gefunden wurde.

if (($faecher != '') && ($jahrgaenge != ''))
{
	$add = "WHERE `fach_cnid` NOT IN ($faecher) OR `year_cnid` NOT IN ($jahrgaenge)";
}
else
{
	$add = '';
}

db_query("DELETE FROM `".$WBConfig->getMySQLPrefix()."schule_noten`$add");

if (db_affected_rows() > 0)
{
	db_query("OPTIMIZE TABLE `".$WBConfig->getMySQLPrefix()."schule_noten`");
}

// Alle Fächer löschen, zu denen kein gültiger Jahrgang gefunden wurde.

if ($jahrgaenge != '')
{
	$add = "WHERE `year_cnid` NOT IN ($jahrgaenge)";
}
else
{
	$add = '';
}

db_query("DELETE FROM `".$WBConfig->getMySQLPrefix()."schule_faecher`$add");

if (db_affected_rows() > 0)
{
	db_query("OPTIMIZE TABLE `".$WBConfig->getMySQLPrefix()."schule_faecher`");
}

// Alle Hausaufgaben löschen, zu denen kein gültiges Fach/Jahrgang gefunden wurde.

if (($faecher != '') && ($jahrgaenge != ''))
{
	$add = "WHERE `fach_cnid` NOT IN ($faecher) OR `year_cnid` NOT IN ($jahrgaenge)";
}
else
{
	$add = '';
}

db_query("DELETE FROM `".$WBConfig->getMySQLPrefix()."schule_hausaufgaben`$add");

if (db_affected_rows() > 0)
{
	db_query("OPTIMIZE TABLE `".$WBConfig->getMySQLPrefix()."schule_hausaufgaben`");
}

?>