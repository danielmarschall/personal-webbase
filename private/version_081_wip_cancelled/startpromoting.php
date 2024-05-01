<?php

// wb_redirect_now('page.php?modul=common_cronjob&seite=run&silent=yes');

$modul	= 'common_cronjob';
$seite	= 'run';
$silent	= 'yes';

if (isset($_SERVER['SHELL']))
{
	// Das Script wird von der Shell aufgerufen

	// Diese Variablen sind bei einem Browseraufruf, aber nicht bei einem Shellaufruf gesetzt

	$_SERVER['GATEWAY_INTERFACE']		= '';
	$_SERVER['HTTP________________ ']	= '';
	$_SERVER['HTTP_ACCEPT']				= '';
	$_SERVER['HTTP_ACCEPT_CHARSET']		= '';
	$_SERVER['HTTP_ACCEPT_LANGUAGE ']	= '';
	$_SERVER['HTTP_CONNECTION']			= '';
	$_SERVER['HTTP_COOKIE']				= '';
	$_SERVER['HTTP_HOST']				= '';
	$_SERVER['HTTP_KEEP_ALIVE']			= '';
	$_SERVER['HTTP_USER_AGENT']			= '';
	$_SERVER['QUERY_STRING ']			= '';
	$_SERVER['REMOTE_ADDR']				= '';
	$_SERVER['REMOTE_PORT']				= '';
	$_SERVER['REQUEST_METHOD ']			= '';
	$_SERVER['REQUEST_URI']				= '';
	$_SERVER['SERVER_ADDR']				= '';
	$_SERVER['SERVER_ADMIN ']			= '';
	$_SERVER['SERVER_NAME']				= '';
	$_SERVER['SERVER_PORT']				= '';
	$_SERVER['SERVER_PROTOCOL']			= '';
	$_SERVER['SERVER_SIGNATURE ']		= '';
	$_SERVER['SERVER_SOFTWARE']			= '';
	$_SERVER['UNIQUE_ID']				= '';

	// Include-Pfad korrekt setzen

	chdir(dirname($_SERVER['PHP_SELF']));
}

include('page.php');

?>