<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

wb_newdatabasetable('configuration', $m2, 'name', "varchar(255) NOT NULL default ''",
	'value', "varchar(255) NOT NULL default ''",
	'module', "varchar(255) NOT NULL default ''");

if (function_exists('set_searchable')) set_searchable($m2, 'configuration', 0);

my_add_key($WBConfig->getMySQLPrefix().'configuration', 'name_and_module', true, 'name', 'module');

// $configuration erstellen
$configuration = array();
$res = db_query("SELECT * FROM `".$WBConfig->getMySQLPrefix()."configuration` ORDER BY `id`");
while ($row = db_fetch($res))
	$configuration[$row['module']][$row['name']] = $row['value'];

// Funktion für das ändern eines Konfigurationswertes inkl. Änderung von $configuration
function wb_change_config($name, $value, $modul)
{
	global $WBConfig, $configuration;

	if ($configuration[$modul][$name] != $value)
	{
		db_query("UPDATE `".$WBConfig->getMySQLPrefix()."configuration` SET `value` = '".db_escape($value)."' WHERE `name` = '".db_escape($name)."' AND `module` = '".db_escape($modul)."'");
		if (db_affected_rows() > 0)
			$configuration[$modul][$name] = $value;
	}
}

// Funktion für das hinzufügen eines Konfigurationswertes inkl. Änderung von $configuration
function wb_add_config($name, $value, $modul)
{
	global $WBConfig, $configuration;

	if (!isset($configuration[$modul][$name]))
	{
		db_query("INSERT INTO `".$WBConfig->getMySQLPrefix()."configuration` (`name`, `value`, `module`) VALUES ('".db_escape($name)."', '".db_escape($value)."', '".db_escape($modul)."')");
		if (db_affected_rows() > 0)
			$configuration[$modul][$name] = $value;
	}
}

?>