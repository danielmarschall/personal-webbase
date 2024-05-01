<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

if ($aktion == 'edit')
{
	db_query("UPDATE `".$WBConfig->getMySQLPrefix()."calendar` SET `name` = '".db_escape($name)."', `start_date` = '".$datum3.'-'.$datum2.'-'.$datum1."', `start_time` = '".$zeit1.':'.$zeit2.':00'."', `kommentare` = '".db_escape($kommentare)."' WHERE `id` = '".db_escape($id)."' AND `user_cnid` = '".$benutzer['id']."'");
	if ($danach == 'A') wb_redirect_now($_SERVER['PHP_SELF'].'?seite=main&modul='.$modul);
	if ($danach == 'B') wb_redirect_now($_SERVER['PHP_SELF'].'?seite=auflistung&modul='.$modul);
	if ($danach == 'C') wb_redirect_now($_SERVER['PHP_SELF'].'?seite=edit&modul='.$modul.'&aktion=new&danach='.$danach);
}

if ($aktion == 'new')
{
	db_query("INSERT INTO `".$WBConfig->getMySQLPrefix()."calendar` (`name`, `start_date`, `start_time`, `kommentare`, `user_cnid`) VALUES ('".db_escape($name)."', '".$datum3.'-'.$datum2.'-'.$datum1."', '".$zeit1.':'.$zeit2.':00'."', '".db_escape($kommentare)."', '".$benutzer['id']."')");
	if ($danach == 'A') wb_redirect_now($_SERVER['PHP_SELF'].'?seite=main&modul='.$modul);
	if ($danach == 'B') wb_redirect_now($_SERVER['PHP_SELF'].'?seite=auflistung&modul='.$modul);
	if ($danach == 'C') wb_redirect_now($_SERVER['PHP_SELF'].'?seite=edit&herkunft='.$herkunft.'&modul='.$modul.'&aktion=new&danach='.$danach);
}

if ($aktion == 'delete')
{
	db_query("DELETE FROM `".$WBConfig->getMySQLPrefix()."calendar` WHERE `id` = '".db_escape($id)."' AND `user_cnid` = '".$benutzer['id']."'");
	if (db_affected_rows() > 0)
		db_query("OPTIMIZE TABLE `".$WBConfig->getMySQLPrefix()."calendar`");

	wb_redirect_now($_SERVER['PHP_SELF'].'?seite='.$zurueck.'&modul='.$modul);
}

?>