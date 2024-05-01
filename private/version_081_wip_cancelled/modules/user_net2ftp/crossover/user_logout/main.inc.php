<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

// Scan aller Cookies im Quellcode von net2ftp 0.98

$cookies_to_delete = array();

$cookies_to_delete[] = 'net2ftpcookie_ftpserver';
$cookies_to_delete[] = 'net2ftpcookie_directory';
$cookies_to_delete[] = 'net2ftpcookie_ftpmode';
$cookies_to_delete[] = 'net2ftpcookie_ftpserverport';
$cookies_to_delete[] = 'net2ftpcookie_language';
$cookies_to_delete[] = 'net2ftpcookie_passivemode';
$cookies_to_delete[] = 'net2ftpcookie_skin';
$cookies_to_delete[] = 'net2ftpcookie_sort';
$cookies_to_delete[] = 'net2ftpcookie_sortorder';
$cookies_to_delete[] = 'net2ftpcookie_sslconnect';
$cookies_to_delete[] = 'net2ftpcookie_username';
$cookies_to_delete[] = 'net2ftpcookie_viewmode';

foreach($cookies_to_delete as $val) {
	wbUnsetCookie($val, 'modules/'.$m2.'/system/');
}

unset($val);
unset($cookies_to_delete);

?>
