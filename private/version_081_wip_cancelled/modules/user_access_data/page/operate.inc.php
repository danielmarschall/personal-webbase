<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

if ($aktion == 'new')
{
	if (!url_protokoll_vorhanden($url)) $url = 'http://'.$url;

	$res = db_query("SELECT `user_cnid` FROM `".$WBConfig->getMySQLPrefix()."folders` WHERE `id` = '".db_escape($folder)."'");
	$row = db_fetch($res);
	if ($row['user_cnid'] != $benutzer['id'])
		$folder = 0;

	$res = db_query("INSERT INTO `".$WBConfig->getMySQLPrefix()."access_data` (`name`, `url`, `text`, `folder_cnid`, `status`, `user_cnid`) VALUES ('".db_escape($name)."', '".db_escape($url)."', '".db_escape($text)."', '".db_escape($folder)."', '".db_escape($status)."', '".$benutzer['id']."')");
	if ($danach == 'A') wb_redirect_now($_SERVER['PHP_SELF'].'?seite=main&modul='.$modul);
	if ($danach == 'B') wb_redirect_now($_SERVER['PHP_SELF'].'?seite=edit&modul='.$modul.'&aktion=new&danach='.$danach);
	if ($danach == 'C') wb_redirect_now($_SERVER['PHP_SELF'].'?seite=edit&modul='.$modul.'&aktion=new&folder='.$folder.'&danach='.$danach);
}

if ($aktion == 'edit')
{
	if (!url_protokoll_vorhanden($url)) $url = 'http://'.$url;

	$res = db_query("SELECT `user_cnid` FROM `".$WBConfig->getMySQLPrefix()."folders` WHERE `id` = '".db_escape($folder)."'");
	$row = db_fetch($res);
	if ($row['user_cnid'] != $benutzer['id'])
		$folder = 0;

	db_query("UPDATE `".$WBConfig->getMySQLPrefix()."access_data` SET `name` = '".db_escape($name)."', `url` = '".db_escape($url)."', `text` = '".db_escape($text)."', `folder_cnid` = '".db_escape($folder)."', `status` = '".db_escape($status)."' WHERE `id` = '".db_escape($id)."' AND `user_cnid` = '".$benutzer['id']."'");
	if ($danach == 'A') wb_redirect_now($_SERVER['PHP_SELF'].'?seite=main&modul='.$modul);
	if ($danach == 'B') wb_redirect_now($_SERVER['PHP_SELF'].'?seite=edit&modul='.$modul.'&aktion=new&danach='.$danach);
	if ($danach == 'C') wb_redirect_now($_SERVER['PHP_SELF'].'?seite=edit&modul='.$modul.'&aktion=new&folder='.$folder.'&danach='.$danach);
}

if ($aktion == 'delete')
{
	db_query("DELETE FROM `".$WBConfig->getMySQLPrefix()."access_data` WHERE `id` = '".db_escape($id)."' AND `user_cnid` = '".$benutzer['id']."'");
	if (db_affected_rows() > 0)
		db_query("OPTIMIZE TABLE `".$WBConfig->getMySQLPrefix()."access_data`");

	wb_redirect_now($_SERVER['PHP_SELF'].'?seite=main&modul='.$modul);
}

?>