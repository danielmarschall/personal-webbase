<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

function wb_idendify_fields($table)
{
	$ret = array();
	$qs2 = db_query("SHOW FIELDS FROM `".db_escape($table)."`");
	while ($qr2 = db_fetch($qs2))
	{
		$ret[strtolower($qr2[0])] = $qr2[1].'/'.$qr2[2].'/'.$qr2[3].'/'.$qr2[4].'/'.$qr2[5];
	}
	return $ret;
}

// Auslesen der Datenbanktabellen und deren Felder

$tables_database = array();
$qs = db_query('SHOW TABLES');
while ($qr = db_fetch($qs))
{
	$tables_database[strtolower($qr[0])] = wb_idendify_fields($qr[0]);
}

// Array $tables_modules erstellen und dabei ungültige Einträge der Modultabelle entfernen...

$tables_modules = array();

if (isset($tables_database[$WBConfig->getMySQLPrefix().'modules']))
{
	$res = db_query("SELECT `table` FROM `".$WBConfig->getMySQLPrefix()."modules` ORDER BY `id`");
	while ($row = db_fetch($res))
	{
		if (isset($tables_database[$WBConfig->getMySQLPrefix().$row['table']]))
		{
			$tables_modules[$WBConfig->getMySQLPrefix().strtolower($row['table'])] = $tables_database[$WBConfig->getMySQLPrefix().strtolower($row['table'])];
		}
		else
		{
			db_query("DELETE FROM `".$WBConfig->getMySQLPrefix()."modules` WHERE `table` = '".$row['table']."'");
			if (db_affected_rows() > 0)
			{
				db_query("OPTIMIZE TABLE `".$WBConfig->getMySQLPrefix()."modules`");
			}
		}
	}
}

// Modultabelle erstellen

wb_newdatabasetable('modules', $m2, 'module', "varchar(255) NOT NULL default ''",
	'table', "varchar(255) NOT NULL default ''");

my_add_key($WBConfig->getMySQLPrefix().'modules', 'table', true, 'table');

// Diese Funktion erstellt eine Datebanktabelle und fügt ggf. neue Felder hinzu
// Parameter: name (ohne Präfix), modul, Feld_1 Name, Feld_1 Eigenschaften, Feld_2 ...
function wb_newdatabasetable($name, $modul)
{
	global $tables_database, $WBConfig, $tables_modules;

	if (!isset($tables_database[$WBConfig->getMySQLPrefix().strtolower($name)]))
	{
		db_query("CREATE TABLE `".$WBConfig->getMySQLPrefix().db_escape(strtolower($name))."` (`id` bigint(21) NOT NULL auto_increment, PRIMARY KEY (`id`))");
	}

	for ($i=1; $i<@func_num_args()-2; $i++)
	{
		if ($i%2)
		{
			if (isset($tables_database[$WBConfig->getMySQLPrefix().strtolower($name)][strtolower(@func_get_arg($i+1))]))
			{
				// Wenn der Feldtyp bei einem Versionstyp gewechselt hat, dann normalisieren
				// Achtung: Es wird nur der FELDTYP kontrolliert!
				$tmp = $tables_database[$WBConfig->getMySQLPrefix().strtolower($name)][strtolower(@func_get_arg($i+1))]; // Workaround für "Can't be used as a function parameter"
				$art = explode('/', $tmp);
				$tmp = strtolower(@func_get_arg($i+2)); // Workaround für "Can't be used as a function parameter"
				$arm = explode(' ', $tmp);
				if (strtolower($art[0]) <> strtolower($arm[0]))
				{
					db_query("ALTER TABLE `".$WBConfig->getMySQLPrefix().db_escape(strtolower($name))."` CHANGE `".strtolower(@func_get_arg($i+1))."` `".strtolower(@func_get_arg($i+1))."` ".strtolower(@func_get_arg($i+2)));
				}
			}
			else
			{
				db_query("ALTER TABLE `".$WBConfig->getMySQLPrefix().db_escape(strtolower($name))."` ADD `".strtolower(@func_get_arg($i+1))."` ".strtolower(@func_get_arg($i+2)));
			}
		}
	}

	if (!isset($tables_modules[$WBConfig->getMySQLPrefix().strtolower($name)]))
	{
		db_query("INSERT INTO `".$WBConfig->getMySQLPrefix()."modules` (`module`, `table`) VALUES ('".db_escape($modul)."', '".db_escape(strtolower($name))."')");
		$tables_modules[strtolower($name)] = '?'; /* wb_idendify_fields($name); */
	}
}

// Sorgt dafür, dass keine Duplicate-Fehler entstehen, wenn Indexe erstellt werden
// Index werden nur einmalig erstellt oder ggf aktualisiert
function my_add_key($table, $name, $unique, $column)
{
	// Funktioniert nicht für PRIMARY KEY

	global $tables_database, $WBConfig;

	if (!isset($tables_database[$table]))
	{
		return false;
	}
	else
	{
		if ($unique)
		{
			$erwarte_non_unique = '0';
		}
		else
		{
			$erwarte_non_unique = '1';
		}

		//$breaki = false;
		$rs = db_query("SHOW INDEX FROM `".db_escape($table)."`");
		while ($rw = db_fetch($rs))
		{
			for ($i=0; $i<@func_num_args()-3; $i++)
			{
				if ((strtolower($rw['Column_name']) == strtolower(@func_get_arg($i+3))) && (strtolower($rw['Key_name']) != strtolower($name)))
				{
					db_query("ALTER TABLE `".db_escape($table)."` DROP INDEX `".$rw['Key_name']."`");
					//$breaki = true;
					//break;
				}
			}
			//if ($breaki) break;
		}

		$vorgekommen = array();

		$breaki = false;
		$rs = db_query("SHOW INDEX FROM `".db_escape($table)."`");
		while ($rw = db_fetch($rs))
		{
			if (strtolower($rw['Key_name']) == strtolower($name))
			{
				for ($i=0; $i<@func_num_args()-3; $i++)
				{
					if (strtolower($rw['Column_name']) == strtolower(@func_get_arg($i+3)))
					{
						if (strtolower($rw['Non_unique']) == $erwarte_non_unique)
						{
							$vorgekommen[strtolower(@func_get_arg($i+3))] = true;
						}
						else
						{
							db_query("ALTER TABLE `".db_escape($table)."` DROP INDEX `".db_escape(strtolower($name))."`");
							$breaki = true;
							break;
						}
					}
				}
			}
			if ($breaki) break;
		}

		if (count($vorgekommen) == 0)
		{
			$alles_vorgekommen = false;
		}
		else
		{
			$alles_vorgekommen = true;
			for ($i=0; $i<@func_num_args()-3; $i++)
			{
				if ((!isset($vorgekommen[strtolower(@func_get_arg($i+3))])) || (!$vorgekommen[strtolower(@func_get_arg($i+3))]))
				{
					$alles_vorgekommen = false;
				}
			}
		}

		if (!$alles_vorgekommen)
		{
			$colo = '';

			for ($i=0; $i<@func_num_args()-3; $i++)
			{
				$colo .= '`'.db_escape(strtolower(@func_get_arg($i+3))).'`, ';
			}

			$colo = substr($colo, 0, strlen($colo)-2);

			if ($unique)
			{
				db_query("ALTER TABLE `".db_escape($table)."` ADD UNIQUE `".db_escape(strtolower($name))."` ($colo)");
			}
			else
			{
				db_query("ALTER TABLE `".db_escape($table)."` ADD KEY `".db_escape(strtolower($name))."` ($colo)");
			}
		}
	}
}

?>