<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

// Als erstes rekursiv die ungültigen Bezüge in der Ordnerstruktur löschen

$fortfahren = true;
while ($fortfahren)
{
	$my_str = "'0', ";
	$res = db_query("SELECT `id` FROM `".$WBConfig->getMySQLPrefix()."folders`");
	while ($row = db_fetch($res))
	{
		$my_str .= "'".$row['id']."', ";
	}
	$my_str = substr($my_str, 0, strlen($my_str)-2);

	db_query("DELETE FROM `".$WBConfig->getMySQLPrefix()."folders` WHERE `folder_cnid` NOT IN ($my_str)");

	if (db_affected_rows() > 0)
	{
		db_query("OPTIMIZE TABLE `".$WBConfig->getMySQLPrefix()."folders`");
	}
	else
	{
		$fortfahren = false;
	}
}

// Nun alle sonstigen Datensätze löschen, die auf keinen gültigen Ordner mehr zeigen

foreach ($tables_modules as $m1 => $m2)
{
	if (isset($tables_modules[$m1]['folder_cnid']))
	{
		// Prüfung auf $my_str = '' nicht nötig, da '0' immer als Element existiert

		db_query("DELETE FROM `$m1` WHERE `folder_cnid` NOT IN ($my_str)");
		if (db_affected_rows() > 0)
		{
			db_query("OPTIMIZE TABLE `$m1`");
		}
	}
}

?>