<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

if ($aktion == 'delete')
{
	$res = db_query("SELECT `table`, `module` FROM `".$WBConfig->getMySQLPrefix()."modules` WHERE `id` = '".db_escape($id)."'");
	$row = db_fetch($res);

	if (is_dir('modules/'.$row['module']))
	{
		db_query("TRUNCATE TABLE `".$WBConfig->getMySQLPrefix().$row['table']."`");
	}
	else
	{
		db_query("DROP TABLE `".$WBConfig->getMySQLPrefix().$row['table']."`");
	}

	wb_redirect_now($_SERVER['PHP_SELF'].'?seite=main&modul='.$modul);
}

?>