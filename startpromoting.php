<?php

// if (!headers_sent()) header('location: modulseite.php?modul=core_cronjob&seite=run&silent=yes');

$modul  = 'core_cronjob';
$seite  = 'run';
$silent = 'yes';

chdir(dirname($_SERVER['SCRIPT_FILENAME']));

$_SERVER['QUERY_STRING']    = '';
$_SERVER['HTTP_USER_AGENT'] = '';
$_SERVER['REMOTE_ADDR']     = '';

include('modulseite.php');

?>