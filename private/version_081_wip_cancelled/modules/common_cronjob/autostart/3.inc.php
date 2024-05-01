<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

// Server-Cronjobs sind ausgeschaltet... (Über 2 Minuten kein Cron)
// -> Zwangsweise über HTTP-Abruf!
$rsc = db_query("SELECT * FROM `".$WBConfig->getMySQLPrefix()."configuration` WHERE `name` = 'last_cronjob' AND `value` <= DATE_SUB(NOW(), INTERVAL 2 MINUTE)");
if (db_num($rsc) > 0)
{
	$footer = '<img src="'.$_SERVER['PHP_SELF'].'?modul='.$m2.'&amp;seite=run&amp;passiv=1" alt="" width="1" height="1">'.$footer;
	wb_change_config('passivcron', '1', $m2);
}

?>