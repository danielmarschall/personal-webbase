<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

$res = db_query("SELECT `url`, `update_enabled`, `update_text_begin`, `update_text_end`, `update_checkurl` FROM `".$WBConfig->getMySQLPrefix()."links` WHERE `id` = '".db_escape($id)."' AND `user_cnid` = '".$benutzer['id']."'");
$row = db_fetch($res);

$url = entferne_anker($row['url']);
$url = decode_critical_html_characters($url);

if (inetconn_ok())
{
	$site = my_get_contents($url);

	if ($site !== false)
	{
		if ($row['update_enabled'])
		{
			$update_checkurl = $row['update_checkurl'];

			if (strpos($update_checkurl, '://') === false)
				$update_checkurl = 'http://'.$update_checkurl;

			$update_checkurl = entferne_anker($update_checkurl);
			$update_checkurl = decode_critical_html_characters($update_checkurl);

			$cont = zwischen_url($update_checkurl, decode_critical_html_characters($row['update_text_begin']), decode_critical_html_characters($row['update_text_end']));
			// TODO: zwischen_url() === false beachten
			$cont = md5($cont);

			db_query("UPDATE `".$WBConfig->getMySQLPrefix()."links` SET `update_lastcontent` = '".db_escape($cont)."', `update_lastchecked` = NOW(), `new_tag` = '0', `broken_tag` = '0' WHERE `id` = '".db_escape($id)."' AND `user_cnid` = '".$benutzer['id']."'");
		}
	}
	else
	{
		db_query("UPDATE `".$WBConfig->getMySQLPrefix()."links` SET `broken_tag` = '1' WHERE `id` = '".db_escape($id)."' AND `user_cnid` = '".$benutzer['id']."'");

		die($header.'<h1>Fehler</h1>Die Webseite <a href="'.$row['url'].'" target="_blank">'.$row['url'].'</a> konnte nicht ge&ouml;ffnet werden. Eventuell ist die URL falsch oder die Seite tempor&auml;r nicht vorhanden.'.$footer);
	}
}

wb_redirect_now($url);

?>
