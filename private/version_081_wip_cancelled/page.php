<?php

require 'includes/main.inc.php';
require 'includes/modulinit.inc.php';

$modul    = isset($_REQUEST['modul']) ? $_REQUEST['modul'] : '';
$seite    = isset($_REQUEST['seite']) ? $_REQUEST['seite'] : '';
$aktion   = isset($_REQUEST['aktion']) ? $_REQUEST['aktion'] : '';
$category = isset($_REQUEST['category']) ? $_REQUEST['category'] : '';

$module_information = get_module_information($modul);

if (!$module_information) {
	die($header.'<b>Fehler beim Laden der Seite</b><br><br>Das Modul ist nicht installiert.'.$footer);
}

if (((isset($wb_user_type)) && ($wb_user_type >= $module_information->rights)) || ($module_information->no_security == '1'))
{
	$m2 = 'common_debugger';
	if (file_exists('modules/'.$m2.'/static_core/page_start.inc.php')) {
		include('modules/'.$m2.'/static_core/page_start.inc.php');
	}
	unset($m2);

	// Nun die Modulseite laden
	if (file_exists('modules/'.$modul.'/page/'.$seite.'.inc.php'))
	{
		include('modules/'.$modul.'/page/'.$seite.'.inc.php');
	}
	else
	{
		echo $header.'<b>Fehler beim Laden der Seite</b><br><br>Die angefragte Seite wurde im Modulverzeichnis nicht gefunden.'.$footer;
	}

	$m2 = 'common_debugger';
	if (file_exists('modules/'.$m2.'/static_core/page_end.inc.php')) {
		include('modules/'.$m2.'/static_core/page_end.inc.php');
	}
	unset($m2);
}
else
{
	@session_unset();
	@session_destroy();
	die($header.'<h1>Session abgelaufen</h1>Ihre Session ist abgelaufen oder ung&uuml;tig geworden. Bitte loggen Sie sich neu ein.<br><br><a href="index.php" target="_parent">Zum Hauptmen&uuml;</a>'.$footer);
}

?>