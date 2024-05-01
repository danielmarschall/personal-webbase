<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

function fehler_melden($modul, $message)
{
	global $WBConfig;

	$res = db_query("SELECT `id` FROM `".$WBConfig->getMySQLPrefix()."recent_events` WHERE `module` = '".db_escape($modul)."' AND `message` = '".db_escape($message)."'", false);
	if (db_num($res) > 0)
	{
		$row = db_fetch($res);
		db_query("UPDATE `".$WBConfig->getMySQLPrefix()."recent_events` SET `appearances` = `appearances` + 1 WHERE `id` = '".$row['id']."'", false);
	}
	else
	{
		db_query("INSERT INTO `".$WBConfig->getMySQLPrefix()."recent_events` (`datetime`, `module`, `message`, `appearances`) VALUES (NOW(), '".db_escape($modul)."', '".db_escape($message)."', '1')", false);
	}
}

?>