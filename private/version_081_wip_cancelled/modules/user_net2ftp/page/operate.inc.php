<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

if ($aktion == 'edit')
{
	$res = db_query("SELECT `user_cnid` FROM `".$WBConfig->getMySQLPrefix()."folders` WHERE `id` = '".db_escape($folder)."'");
	$row = db_fetch($res);
	if ($row['user_cnid'] != $benutzer['id'])
		$folder = 0;

	db_query("UPDATE `".$WBConfig->getMySQLPrefix()."net2ftp` SET `folder_cnid` = '".db_escape($folder)."', `server` = '".db_escape($fserver)."', `username` = '".db_escape($fusername)."', `password` = '".db_escape($fpassword)."', `home_directory` = '".db_escape($fstart)."', `port` = '".db_escape($fport)."' WHERE `id` = '".db_escape($id)."' AND `user_cnid` = '".$benutzer['id']."'");
	if ($danach == 'A') wb_redirect_now($_SERVER['PHP_SELF'].'?seite=main&modul='.$modul);
	if ($danach == 'B') wb_redirect_now($_SERVER['PHP_SELF'].'?seite=edit&modul='.$modul.'&aktion=new&danach='.$danach);
	if ($danach == 'C') wb_redirect_now($_SERVER['PHP_SELF'].'?seite=edit&modul='.$modul.'&aktion=new&folder='.$folder.'&danach='.$danach);
}

if ($aktion == 'new')
{
	$res = db_query("SELECT `user_cnid` FROM `".$WBConfig->getMySQLPrefix()."folders` WHERE `id` = '".db_escape($folder)."'");
	$row = db_fetch($res);
	if ($row['user_cnid'] != $benutzer['id'])
		$folder = 0;

	db_query("INSERT INTO `".$WBConfig->getMySQLPrefix()."net2ftp` (`folder_cnid`, `server`, `username`, `password`, `home_directory`, `port`, `user_cnid`) VALUES ('".db_escape($folder)."', '".db_escape($fserver)."', '".db_escape($fusername)."', '".db_escape($fpassword)."', '".db_escape($fstart)."', '".db_escape($fport)."', '".$benutzer['id']."')");
	if ($danach == 'A') wb_redirect_now($_SERVER['PHP_SELF'].'?seite=main&modul='.$modul);
	if ($danach == 'B') wb_redirect_now($_SERVER['PHP_SELF'].'?seite=edit&modul='.$modul.'&aktion=new&danach='.$danach);
	if ($danach == 'C') wb_redirect_now($_SERVER['PHP_SELF'].'?seite=edit&modul='.$modul.'&aktion=new&folder='.$folder.'&danach='.$danach);
}

if ($aktion == 'delete')
{
	db_query("DELETE FROM `".$WBConfig->getMySQLPrefix()."net2ftp` WHERE `id` = '".db_escape($id)."' AND `user_cnid` = '".$benutzer['id']."'");
	if (db_affected_rows() > 0)
		db_query("OPTIMIZE TABLE `".$WBConfig->getMySQLPrefix()."net2ftp`");

	wb_redirect_now($_SERVER['PHP_SELF'].'?seite=main&modul='.$modul);
}

?>