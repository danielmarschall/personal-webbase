<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

// TODO: Besser Umleiten auf user_logout?

$_SESSION = array();

@session_unset();
@session_destroy();

echo $header;

echo '<h1>'.htmlentities($module_information->caption).'</h1>';

foreach ($modules as $m1 => $m2) {
	if (file_exists('modules/'.$m2.'/crossover/'.$modul.'/main.inc.php')) {
		include('modules/'.$m2.'/crossover/'.$modul.'/main.inc.php');
	}
}

unset($m1);
unset($m2);

echo '<b>Sie werden weitergeleitet</b><br><br>Bitte warten...<br><br><script language="JavaScript" type="text/javascript">
<!--
	parent.location.href = \'index.php\';
// -->
</script>';

echo $footer;

?>