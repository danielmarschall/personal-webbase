<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

if (!isset($skey)) $skey = '';

$skey_decoded = wb_decrypt($skey, '@ibs');

$skey_ary = explode('@', $skey_decoded);
$id = $skey_ary[0];

$res = db_query("SELECT `user_cnid` FROM `".$WBConfig->getMySQLPrefix()."links` WHERE `id` = '".db_escape($id)."'");
$row = db_fetch($res);
$lid = $row['user_cnid'];

$res2 = db_query("SELECT `password` FROM `".$WBConfig->getMySQLPrefix()."users` WHERE `id` = '$lid'");
$row2 = db_fetch($res2);
$erw = md5($row2['password']);

if ($erw == $skey_ary[1])
{
	$module_information = WBModuleHandler::get_module_information('user_links');

	$benutzer['id'] = $lid;

	if (file_exists('modules/user_links/page/view.inc.php'))
		include 'modules/user_links/page/view.inc.php';
}
else
{
	echo $header.'Sicherheitsschl&uuml;ssel fehlerhaft.'.$footer;
}

?>
