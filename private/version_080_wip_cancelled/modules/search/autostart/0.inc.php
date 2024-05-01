<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

function set_searchable($mod, $tab, $sta)
{
	global $WBConfig, $tables_database;

	if (isset($tables_database[$WBConfig->getMySQLPrefix().'modules']['is_searchable']))
		db_query("UPDATE `".$WBConfig->getMySQLPrefix()."modules` SET `is_searchable` = '$sta' WHERE `module` = '$mod' AND `table` = '$tab'");
}

function is_searchable($tab)
{
	global $WBConfig, $tables_database;

	if (isset($tables_database[$WBConfig->getMySQLPrefix().'modules']['is_searchable']))
	{
		$rs = db_query("SELECT `is_searchable` FROM `".$WBConfig->getMySQLPrefix()."modules` WHERE `table` = '$tab'");
		$rw = db_fetch($rs);
		return $rw['is_searchable'];
	}
	else
	{
		return false;
	}
}

?>