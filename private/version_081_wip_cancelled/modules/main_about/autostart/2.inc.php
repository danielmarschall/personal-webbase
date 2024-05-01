<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

if (isset($_SERVER['SERVER_ADMIN']))
	$adm = $_SERVER['SERVER_ADMIN'];
else
	$adm = '';

wb_add_config('admin_mail', $adm, $m2);

?>