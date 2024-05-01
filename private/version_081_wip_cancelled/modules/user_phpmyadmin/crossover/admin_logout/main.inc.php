<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

// Umleiten

if (file_exists('modules/'.$m2.'/crossover/user_logout/main.inc.php')) {
	include('modules/'.$m2.'/crossover/user_logout/main.inc.php');
}

?>