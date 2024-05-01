<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

if ($aktion == 'new')
{
	$res = db_query("SELECT `user_cnid` FROM `".$WBConfig->getMySQLPrefix()."folders` WHERE `id` = '".db_escape($folder)."'");
	$row = db_fetch($res);
	if ($row['user_cnid'] != $benutzer['id'])
		$folder = 0;

	if ($_FILES['datei']['tmp_name'] != '')
	{
		$pfad_zur_datei = $_FILES['datei']['tmp_name'];
		$dateiname = $_FILES['datei']['name'];
		$data = fread(fopen($pfad_zur_datei, 'r'), filesize($pfad_zur_datei));
		$dtype = $_FILES['datei']['type'];
		db_query("INSERT INTO `".$WBConfig->getMySQLPrefix()."files` (`name`, `folder_cnid`, `filename`, `user_cnid`, `type`, `data`) VALUES ('".db_escape($name)."', '".db_escape($folder)."', '".db_escape($dateiname)."', '".$benutzer['id']."', '".db_escape($dtype)."', '".db_escape($data)."')");
	}
	else
		db_query("INSERT INTO `".$WBConfig->getMySQLPrefix()."files` (`name`, `folder_cnid`, `user_cnid`) VALUES ('".db_escape($name)."', '".db_escape($folder)."', '".$benutzer['id']."')");

	if ($danach == 'A') wb_redirect_now($_SERVER['PHP_SELF'].'?seite=main&modul='.$modul);
	if ($danach == 'B') wb_redirect_now($_SERVER['PHP_SELF'].'?seite=edit&modul='.$modul.'&aktion=new&danach='.$danach);
	if ($danach == 'C') wb_redirect_now($_SERVER['PHP_SELF'].'?seite=edit&modul='.$modul.'&aktion=new&folder='.$folder.'&danach='.$danach);
}

if ($aktion == 'edit')
{
	$res = db_query("SELECT `user_cnid` FROM `".$WBConfig->getMySQLPrefix()."folders` WHERE `id` = '".db_escape($folder)."'");
	$row = db_fetch($res);
	if ($row['user_cnid'] != $benutzer['id'])
		$folder = 0;

	if ($_FILES['datei']['tmp_name'] != '')
	{
		$pfad_zur_datei = $_FILES['datei']['tmp_name'];
		$dateiname = $_FILES['datei']['name'];
		$data = fread(fopen($pfad_zur_datei, 'r'), filesize($pfad_zur_datei));
		$dtype = $_FILES['datei']['type'];
		db_query("UPDATE `".$WBConfig->getMySQLPrefix()."files` SET `name` = '".db_escape($name)."', `folder_cnid` = '".db_escape($folder)."', `filename` = '".db_escape($dateiname)."', `data` = '".db_escape($data)."', `type` = '".db_escape($dtype)."' WHERE `user_cnid` = '".$benutzer['id']."' AND `id` = '".db_escape($id)."'");
	}
	else
		db_query("UPDATE `".$WBConfig->getMySQLPrefix()."files` SET `name` = '".db_escape($name)."', `folder_cnid` = '".db_escape($folder)."' WHERE `user_cnid` = '".$benutzer['id']."' AND `id` = '".db_escape($id)."'");

	if ($danach == 'A') wb_redirect_now($_SERVER['PHP_SELF'].'?seite=main&modul='.$modul);
	if ($danach == 'B') wb_redirect_now($_SERVER['PHP_SELF'].'?seite=edit&modul='.$modul.'&aktion=new&danach='.$danach);
	if ($danach == 'C') wb_redirect_now($_SERVER['PHP_SELF'].'?seite=edit&modul='.$modul.'&aktion=new&folder='.$folder.'&danach='.$danach);
}

if ($aktion == 'delete')
{
	db_query("DELETE FROM `".$WBConfig->getMySQLPrefix()."files` WHERE `id` = '".db_escape($id)."' AND `user_cnid` = '".$benutzer['id']."'");
	if (db_affected_rows() > 0)
		db_query("OPTIMIZE TABLE `".$WBConfig->getMySQLPrefix()."files`");

	wb_redirect_now($_SERVER['PHP_SELF'].'?seite=main&modul='.$modul);
}

?>