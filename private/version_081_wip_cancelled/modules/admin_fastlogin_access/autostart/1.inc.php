<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

// @return true if suceed
function wb_decode_fast_login_key($key, &$ret_user, &$ret_pwd) {
	global $WBConfig, $configuration;

	$ret_user = '';
	$ret_pwd = '';

	// TODO: Hier auf "FastLogin-Enabled" prüfen?

	// Benutzer-ID vom Anfang des Keys abschneiden
	define('WB_FL_DELIM', '@@');
	$pos = strpos($key, WB_FL_DELIM);
	if ($pos === false) return false;
	$id = substr($key, 0, $pos);
	$key = substr($key, strlen($id)+strlen(WB_FL_DELIM), strlen($key)-(strlen($id)+strlen(WB_FL_DELIM)));

	$res = db_query("SELECT `username`, `password`, `fastlogin_secret`, `last_login`, `last_login_ip` FROM `".$WBConfig->getMySQLPrefix()."users` WHERE `banned` = '0' AND `fastlogin_secret` != '' AND `id` = '".db_escape($id)."'");
	if (db_num($res) != 1) return false;
	$row = db_fetch($res);

	// Gastzugang verbieten. Es wird nicht geprüft, ob Gastaccount aktiviert ist oder nicht. (siehe user_login)
	if (($row['username'] == $configuration['main_guest_login']['gast_username'])
		// || ($row['password'] == md5($configuration['main_guest_login']['gast_password']))
	) return false;

	$dec = wb_decrypt($key, $row['fastlogin_secret']);
	$ary = explode("\n", $dec);

	if (count($ary) != 4) return false;

	if (($ary[0] != $row['username']) || ($ary[1] != special_hash($ary[0])) ||
		(md5($ary[2]) != $row['password']) || ($ary[3] != special_hash($ary[2]))) return false;

	$ret_user = $ary[0];
	$ret_pwd = $ary[2];

	return true;
}

// TODO: Hier Hartcodierung von main_login/autostart/2 einfügen

?>