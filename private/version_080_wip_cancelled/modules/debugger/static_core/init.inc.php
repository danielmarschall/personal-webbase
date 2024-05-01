<?php

function getmicrotime() {
	list($usec, $sec) = explode(' ', microtime());
	return ((float)$usec + (float)$sec);
}

$time_start = getmicrotime();
$mysql_count = 0;
$mysql_time = 0;
$xml_count = 0;
$xml_time = 0;

// Required hard coded in includes/datanase.inc.php: db_query()
function dbg_log_db_query($query) {
	global $sql_transkript;
	$sql_transkript .= date('d.m.Y H:i:s')."\t$query\r\n";
}

?>