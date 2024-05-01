<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

if ($aktion == 'edit')
{
	// Hat der Dabbes das "http://" vergessen?
	if (!url_protokoll_vorhanden($update_checkurl)) $update_checkurl = 'http://'.$update_checkurl;
	if (!url_protokoll_vorhanden($url)) $url = 'http://'.$url;

	// Titel selbstständig hinzufügen
	if ($name == '')
	{
		if (inetconn_ok())
		{
			$dateiinhalt = my_get_contents($url);
			@preg_match_all('/<title>(.+?)<\/title>/im', $dateiinhalt, $matches);
			if (isset($matches[1][0]))
			{
				$tmp = $matches[1][0];
				if ($tmp != '')
					$lname = $matches[1][0];
				else
					$lname = 'Unbenannte Webseite';
			}
			else
			{
				$lname = 'Unbenannte Webseite';
			}
		}
		else
		{
			$lname = 'Unbenannte Webseite';
		}
	}
	else
	{
		$lname = $name;
	}

	// Enthält Check-URL einen Anker? Entfernen
	$update_checkurl = entferne_anker($update_checkurl);

	if (!isset($update_enabled)) $update_enabled = '0';

	// Ersten Inhalt hinzufügen, sofern Link-Updates aktiviert und Internetverbindung vorhanden
	if (($update_enabled) && (inetconn_ok()))
	{
		$cont = zwischen_url($update_checkurl, decode_critical_html_characters($update_text_begin), decode_critical_html_characters($update_text_end));
		// TODO: zwischen_url() === false beachten
		$cont = md5($cont);
		$zus = ", `update_lastchecked` = NOW(), `update_lastcontent` = '".db_escape($cont)."'";
	}
	else
	{
		$zus = '';
	}

	// Gehört der Ordner auch dem Benutzer?
	$res = db_query("SELECT `user_cnid` FROM `".$WBConfig->getMySQLPrefix()."folders` WHERE `id` = '".db_escape($folder)."'");
	$row = db_fetch($res);
	if ($row['user_cnid'] != $benutzer['id'])
		$folder = 0;

	// Ausführen
	db_query("UPDATE `".$WBConfig->getMySQLPrefix()."links` SET `name` = '".db_escape($name)."', `folder_cnid` = '".db_escape($folder)."', `url` = '".db_escape($url)."', `update_enabled` = '".db_escape($update_enabled)."', `update_checkurl` = '".db_escape($update_checkurl)."', `update_text_begin` = '".db_escape($update_text_begin)."', `update_text_end` = '".db_escape($update_text_end)."'$zus WHERE `id` = '".db_escape($id)."' AND `user_cnid` = '".$benutzer['id']."'");
	if ($danach == 'A') wb_redirect_now($_SERVER['PHP_SELF'].'?seite=main&modul='.$modul);
	if ($danach == 'B') wb_redirect_now($_SERVER['PHP_SELF'].'?seite=edit&modul='.$modul.'&aktion=new&danach='.$danach);
	if ($danach == 'C') wb_redirect_now($_SERVER['PHP_SELF'].'?seite=edit&modul='.$modul.'&aktion=new&folder='.$folder.'&danach='.$danach);
}

if ($aktion == 'new')
{
	// Hat der Dabbes das "http://" vergessen?
	if (!url_protokoll_vorhanden($update_checkurl)) $update_checkurl = 'http://'.$update_checkurl;
	if (!url_protokoll_vorhanden($url)) $url = 'http://'.$url;

	// Titel selbstständig hinzufügen
	if ($name == '')
	{
		if (inetconn_ok())
		{
			$dateiinhalt = my_get_contents($url);
			@preg_match_all('/<title>(.+?)<\/title>/im', $dateiinhalt, $matches);
			if (isset($matches[1][0]))
			{
				$tmp = $matches[1][0];
				if ($tmp != '')
					$lname = $matches[1][0];
				else
					$lname = 'Unbenannte Webseite';
			}
			else
			{
				$lname = 'Unbenannte Webseite';
			}
		}
		else
		{
			$lname = 'Unbenannte Webseite';
		}
	}
	else
	{
		$lname = $name;
	}

	// Enthält Check-URL einen Anker? Entfernen
	$update_checkurl = entferne_anker($update_checkurl);

	if (!isset($update_enabled)) $update_enabled = '0';

	// Ersten Inhalt hinzufügen, sofern Link-Updates aktiviert und Internetverbindung vorhanden
	if (($update_enabled) && (inetconn_ok()))
	{
		$cont = zwischen_url($update_checkurl, decode_critical_html_characters($update_text_begin), decode_critical_html_characters($update_text_end));
		// TODO: zwischen_url() === false beachten
		$cont = md5($cont);
		$zus1 = "`update_lastchecked`, `update_lastcontent`, ";
		$zus2 = "NOW(), '".db_escape($cont)."', ";
	}
	else
	{
		$zus1 = '';
		$zus2 = '';
	}

	// Gehört der Ordner auch dem Benutzer?
	$res = db_query("SELECT `user_cnid` FROM `".$WBConfig->getMySQLPrefix()."folders` WHERE `id` = '".db_escape($folder)."'");
	$row = db_fetch($res);
	if ($row['user_cnid'] != $benutzer['id'])
		$folder = 0;

	if (!isset($update_enabled)) $update_enabled = '0';

	// Ausführen
	db_query("INSERT INTO `".$WBConfig->getMySQLPrefix()."links` (`name`, `url`, `folder_cnid`, `update_enabled`, `update_checkurl`, `update_text_begin`, `update_text_end`, $zus1`new_tag`, `broken_tag`, `user_cnid`) VALUES ('".db_escape($lname)."', '".db_escape($url)."', '".db_escape($folder)."', '".db_escape($update_enabled)."', '".db_escape($update_checkurl)."', '".db_escape($update_text_begin)."', '".db_escape($update_text_end)."', $zus2'0', '0', '".$benutzer['id']."')");
	if ($danach == 'A') wb_redirect_now($_SERVER['PHP_SELF'].'?seite=main&modul='.$modul);
	if ($danach == 'B') wb_redirect_now($_SERVER['PHP_SELF'].'?seite=edit&modul='.$modul.'&aktion=new&danach='.$danach);
	if ($danach == 'C') wb_redirect_now($_SERVER['PHP_SELF'].'?seite=edit&modul='.$modul.'&aktion=new&folder='.$folder.'&danach='.$danach);
}

if ($aktion == 'delete')
{
	db_query("DELETE FROM `".$WBConfig->getMySQLPrefix()."links` WHERE `id` = '".db_escape($id)."' AND `user_cnid` = '".$benutzer['id']."'");
	if (db_affected_rows() > 0)
		db_query("OPTIMIZE TABLE `".$WBConfig->getMySQLPrefix()."links`");

	wb_redirect_now($_SERVER['PHP_SELF'].'?seite=main&modul='.$modul);
}

?>