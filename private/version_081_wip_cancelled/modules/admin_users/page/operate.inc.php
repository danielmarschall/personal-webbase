<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

if ($aktion == 'lock')
{
	$res = db_query("SELECT `banned` FROM `".$WBConfig->getMySQLPrefix()."users` WHERE `id` = '".db_escape($id)."'");
	$row = db_fetch($res);

	if ($row['banned'] == '1')
		db_query("UPDATE `".$WBConfig->getMySQLPrefix()."users` SET `banned` = '0' WHERE `id` = '".db_escape($id)."'");
	else
		db_query("UPDATE `".$WBConfig->getMySQLPrefix()."users` SET `banned` = '1' WHERE `id` = '".db_escape($id)."'");

	wb_redirect_now($_SERVER['PHP_SELF'].'?modul='.$modul.'&seite=main');
}

if ($aktion == 'edit')
{
	if ($f_banned)
		$f_gesp = '1';
	else
		$f_gesp = '0';
	db_query("UPDATE `".$WBConfig->getMySQLPrefix()."users` SET `username` = '".db_escape($f_username)."', `personal_name` = '".db_escape($f_personal_name)."', `banned` = '".db_escape($f_gesp)."', `email` = '".db_escape($f_email)."' WHERE `id` = '".db_escape($id)."'");
	if ($f_neupwd) db_query("UPDATE `".$WBConfig->getMySQLPrefix()."users` SET `password` = '".md5($f_password)."' WHERE `id` = '".db_escape($id)."'");

	wb_redirect_now($_SERVER['PHP_SELF'].'?modul='.$modul.'&seite=main');
}

if ($aktion == 'del')
{
	db_query("DELETE FROM `".$WBConfig->getMySQLPrefix()."users` WHERE `id` = '".db_escape($id)."'");
	if (db_affected_rows() > 0)
		db_query("OPTIMIZE TABLE `".$WBConfig->getMySQLPrefix()."users`");

	wb_redirect_now($_SERVER['PHP_SELF'].'?modul='.$modul.'&seite=main');
}

?>