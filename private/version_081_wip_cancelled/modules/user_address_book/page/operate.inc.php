<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

if ($aktion == 'edit')
{
	$res = db_query("SELECT `user_cnid` FROM `".$WBConfig->getMySQLPrefix()."folders` WHERE `id` = '".db_escape($folder)."'");
	$row = db_fetch($res);
	if ($row['user_cnid'] != $benutzer['id'])
		$folder = 0;

	db_query("UPDATE `".$WBConfig->getMySQLPrefix()."contacts` SET `name` = '".db_escape($name)."', `strasse` = '".db_escape($strasse)."', `plz` = '".db_escape($plz)."', `ort` = '".db_escape($ort)."', `land` = '".db_escape($land)."', `telefon` = '".$telefon1.'-'.$telefon2."', `mobil` = '".$mobil1.'-'.$mobil2."', `fax` = '".$fax1.'-'.$fax2."', `email` = '".db_escape($email)."', `icq` = '".db_escape($icq)."', `msn` = '".db_escape($msn)."', `aim` = '".db_escape($aim)."', `yahoo` = '".db_escape($yahoo)."', `kommentare` = '".db_escape($kommentare)."', `folder_cnid` = '".db_escape($folder)."', `skype` = '".db_escape($skype)."' WHERE `id` = '".db_escape($id)."' AND `user_cnid` = '".$benutzer['id']."'");
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

	db_query("INSERT INTO `".$WBConfig->getMySQLPrefix()."contacts` (`name`, `strasse`, `plz`, `ort`, `land`, `telefon`, `mobil`, `fax`, `email`, `icq`, `msn`, `aim`, `yahoo`, `kommentare`, `skype`, `user_cnid`, `folder_cnid`) VALUES ('".db_escape($name)."', '".db_escape($strasse)."', '".db_escape($plz)."', '".db_escape($ort)."', '".db_escape($land)."', '".$telefon1.'-'.$telefon2."', '".$mobil1.'-'.$mobil2."', '".$fax1.'-'.$fax2."', '".db_escape($email)."', '".db_escape($icq)."', '".db_escape($msn)."', '".db_escape($aim)."', '".db_escape($yahoo)."', '".db_escape($kommentare)."', '".db_escape($skype)."', '".$benutzer['id']."', '".db_escape($folder)."')");
	if ($danach == 'A') wb_redirect_now($_SERVER['PHP_SELF'].'?seite=main&modul='.$modul);
	if ($danach == 'B') wb_redirect_now($_SERVER['PHP_SELF'].'?seite=edit&modul='.$modul.'&aktion=new&danach='.$danach);
	if ($danach == 'C') wb_redirect_now($_SERVER['PHP_SELF'].'?seite=edit&modul='.$modul.'&aktion=new&folder='.$folder.'&danach='.$danach);
}

if ($aktion == 'delete')
{
	db_query("DELETE FROM `".$WBConfig->getMySQLPrefix()."contacts` WHERE `id` = '".db_escape($id)."' AND `user_cnid` = '".$benutzer['id']."'");
	if (db_affected_rows() > 0)
		db_query("OPTIMIZE TABLE `".$WBConfig->getMySQLPrefix()."contacts`");

	wb_redirect_now($_SERVER['PHP_SELF'].'?seite=main&modul='.$modul);
}

?>