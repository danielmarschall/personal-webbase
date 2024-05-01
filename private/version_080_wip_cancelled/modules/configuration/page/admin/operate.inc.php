<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

if ($aktion == 'edit')
{
	wb_change_config(db_escape($name), db_escape($wert), db_escape($kmodul));
	wb_redirect_now($_SERVER['PHP_SELF'].'?modul='.$modul.'&seite=config');
}

if ($aktion == 'delete')
{
	db_query("DELETE FROM `".$WBConfig->getMySQLPrefix()."configuration` WHERE `id` = '".db_escape($id)."'");
	if (db_affected_rows() > 0) {
		db_query("OPTIMIZE TABLE `".$WBConfig->getMySQLPrefix()."configuration`");
	}
	wb_redirect_now($_SERVER['PHP_SELF'].'?modul='.$modul.'&seite=config');
}

?>