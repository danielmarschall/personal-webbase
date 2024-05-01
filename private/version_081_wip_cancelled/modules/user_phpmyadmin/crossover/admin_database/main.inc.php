<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

echo '<li>';
if (file_exists('modules/'.$m2.'/system/_wbver.inc.php')) {
	include('modules/'.$m2.'/system/_wbver.inc.php');
} else {
	echo '<span class="red">Unbekanntes System von '.$m2.'</span>';
}

echo ' <a href="'.$_SERVER['PHP_SELF'].'?modul='.$m2.'&amp;seite=view" target="_blank">&ouml;ffnen</a></li>';

?>