<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

// TODO: Konfigurierbar machen?
define('COOKIE_VALIDITY', time()+60*60*24*36525); // 100 Jahre gültig

if ($wb_user_type == 0)
{
	die($header.'Keine Zugriffsberechtigung'.$footer);
}

if ($aktion == 'generate')
{
	$hex = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9',
		'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
		'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
		'.', ',', '$', '#', '!', '?', '=', '~', '*', '/', '\\', '+', '-', '_', '&', '%', '$', '§', '"', "'", ';', ':');
	// TODO: Noch besser: Einfach jedes Nicht-Binärzeichen wählen

	$new_secret_key = '';
	for ($i=0; $i<255; $i++)
	{
		$new_secret_key .= $hex[mt_rand(0, count($hex)-1)];
	}

	db_query("UPDATE `".$WBConfig->getMySQLPrefix()."users` SET `fastlogin_serial` = `fastlogin_serial` + 1, `fastlogin_secret` = '".db_escape($new_secret_key)."' WHERE `id` = '".$benutzer['id']."'");

	$benutzer['fastlogin_secret'] = $new_secret_key;

	$aktion = 'reget';
}

if ($aktion == 'reget')
{
	function wb_generate_fast_login_key() {
		global $wb_user_username, $wb_user_password, $benutzer;

		// Angabe der ID verhindert das Durchlaufen der Datenbank zum Suchen des passenden Eintrags

		define('WB_FL_DELIM', '@@');

		$secret_key  = $wb_user_username."\n";
		$secret_key .= special_hash($wb_user_username)."\n";
		$secret_key .= $wb_user_password."\n";
		$secret_key .= special_hash($wb_user_password);
		$secret_key  = $benutzer['id'].WB_FL_DELIM.wb_encrypt($secret_key, $benutzer['fastlogin_secret']);

		return $secret_key;
	}

	$secret_key = wb_generate_fast_login_key();

	wbSetCookie('wb_fastlogin_key', $secret_key, COOKIE_VALIDITY);

	wb_redirect_now($_SERVER['PHP_SELF'].'?seite=main&modul='.$modul);
}

if ($aktion == 'destroy')
{
	db_query("UPDATE `".$WBConfig->getMySQLPrefix()."users` SET `fastlogin_secret` = '' WHERE `id` = '".$benutzer['id']."'");

	$aktion = 'delcookie';
}

if ($aktion == 'delcookie')
{
	wbUnsetCookie('wb_fastlogin_key');

	wb_redirect_now($_SERVER['PHP_SELF'].'?seite=main&modul='.$modul);
}

?>
