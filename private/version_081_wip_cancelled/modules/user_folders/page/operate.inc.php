<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

if ($aktion == 'edit')
{
	if ($id == $folder)
		die($header.'Fehler: Ordner kann nicht in sich selbst verschoben werden!'.$footer);

	$res = db_query("SELECT `user_cnid` FROM `".$WBConfig->getMySQLPrefix()."folders` WHERE `id` = '".db_escape($folder)."'");
	$row = db_fetch($res);
	if ($row['user_cnid'] != $benutzer['id'])
		$folder = 0;

	db_query("UPDATE `".$WBConfig->getMySQLPrefix()."folders` SET `name` = '".db_escape($name)."', `folder_cnid` = '".db_escape($folder)."' WHERE `id` = '".db_escape($id)."' AND `user_cnid` = '".$benutzer['id']."'");
	if ($danach == 'A') wb_redirect_now($_SERVER['PHP_SELF'].'?seite=main&modul='.$category);
	if ($danach == 'B') wb_redirect_now($_SERVER['PHP_SELF'].'?seite=edit&category='.$category.'&modul='.$modul.'&aktion=new&danach='.$danach);
	if ($danach == 'C') wb_redirect_now($_SERVER['PHP_SELF'].'?seite=edit&category='.$category.'&modul='.$modul.'&aktion=new&folder='.$folder.'&danach='.$danach);
}

if ($aktion == 'new')
{
	$res = db_query("SELECT `user_cnid` FROM `".$WBConfig->getMySQLPrefix()."folders` WHERE `id` = '".db_escape($folder)."'");
	$row = db_fetch($res);
	if ($row['user_cnid'] != $benutzer['id'])
		$folder = 0;

	db_query("INSERT INTO `".$WBConfig->getMySQLPrefix()."folders` (`name`, `category`, `folder_cnid`, `user_cnid`) VALUES ('".db_escape($name)."', '".db_escape($category)."', '".db_escape($folder)."', '".$benutzer['id']."')");
	if ($danach == 'A') wb_redirect_now($_SERVER['PHP_SELF'].'?seite=main&modul='.$category);
	if ($danach == 'B') wb_redirect_now($_SERVER['PHP_SELF'].'?seite=edit&category='.$category.'&modul='.$modul.'&aktion=new&danach='.$danach);
	if ($danach == 'C') wb_redirect_now($_SERVER['PHP_SELF'].'?seite=edit&category='.$category.'&modul='.$modul.'&aktion=new&folder='.$folder.'&danach='.$danach);
}

if ($aktion == 'delete')
{
	db_query("DELETE FROM `".$WBConfig->getMySQLPrefix()."folders` WHERE `id` = '".db_escape($id)."' AND `user_cnid` = '".$benutzer['id']."'");
	if (db_affected_rows() > 0)
		db_query("OPTIMIZE TABLE `".$WBConfig->getMySQLPrefix()."folders`");

	wb_redirect_now($_SERVER['PHP_SELF'].'?seite=main&modul='.$category);
}

?>