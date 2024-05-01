<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

if ($aktion == 'wipe')
{
	db_query("DELETE FROM `".$WBConfig->getMySQLPrefix()."recent_events`");
	if (db_affected_rows() > 0)
		db_query("OPTIMIZE TABLE `".$WBConfig->getMySQLPrefix()."recent_events`");
	wb_redirect_now($_SERVER['PHP_SELF'].'?seite=main&modul='.$modul);
}

if ($aktion == 'delete')
{
	db_query("DELETE FROM `".$WBConfig->getMySQLPrefix()."recent_events` WHERE `id` = '".db_escape($id)."'");
	if (db_affected_rows() > 0)
		db_query("OPTIMIZE TABLE `".$WBConfig->getMySQLPrefix()."recent_events`");
	wb_redirect_now($_SERVER['PHP_SELF'].'?seite=main&modul='.$modul);
}

?>