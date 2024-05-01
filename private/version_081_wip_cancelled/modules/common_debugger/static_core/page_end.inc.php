<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

// TODO: text-wrap mit css funktioniert nicht

// TODO: Adresse konfigurierbar machen
// "Es wird standardgemäß für jede Webseite eine W3C Markup Validation durchgeführt.
// ist das PEAR Package 'Services_W3C_HTMLValidator' (http://pear.php.net/package/Services_W3C_HTMLValidator)
// sowie eine lokale Installation des W3C-Validators (http://validator.w3.org/) installiert,
// wird die Validation direkt über die API (http://validator.w3.org/docs/api.html) durchgeführt.
// Ansonsten wird das Fragment zu folgender externen Seite gepostet und das Ergebnis geparsed. [Hier Adresse eingebbar machen]
// Warnung: Die Fragmentdaten enthalten alle Daten, die übertragen wurden inklusive Daten Ihrer Benutzer."

define('URL_TO_VALIDATOR', 'http://validator.w3.org/');
//define('URL_TO_VALIDATOR', 'https://www.personal-webbase.de/w3c-markup-validator/');

// TODO: W3C Check auch komplett deaktivierbar machen
$w3c_check_enabled = true;

if (isset($configuration['common_debugger']['debug']) && ($configuration['common_debugger']['debug']))
{
	if ($w3c_check_enabled) {
		if (file_exists('modules/'.$m2.'/includes/w3c_fragment_checker.class.php')) {
			include 'modules/'.$m2.'/includes/w3c_fragment_checker.class.php';
		}
	}

	// Puffer der Seite auslesen
	$buffered_output = ob_get_contents();
	@ob_end_clean();

	// Alle definierten Variablen
	$dbg_def_vars = get_defined_vars();
	$dbg_var_list = '';
	foreach ($dbg_def_vars as $dbg_def_var_key => $dbg_def_var_val) {
		$dbg_var_list .= '$'.$dbg_def_var_key."\r\n";
	}
	unset($dbg_def_var_val);
	unset($dbg_def_var_key);
	unset($dbg_def_vars);

	// Alle definierten Konstanten
	$dbg_def_consts = get_defined_constants();
	$dbg_const_list = '';
	foreach ($dbg_def_consts as $dbg_def_const_key => $dbg_def_const_val) {
		$dbg_const_list .= $dbg_def_const_key."\r\n";
	}
	unset($dbg_def_const_val);
	unset($dbg_def_const_key);
	unset($dbg_def_consts);

	// Alle definierten Benutzerfunktionen
	$dbg_def_functs = get_defined_functions();
	$dbg_user_funct_list = '';
	foreach ($dbg_def_functs['user'] as $dbg_def_user_funct_key => $dbg_def_user_funct_val) {
		$dbg_user_funct_list .= $dbg_def_user_funct_val."()\r\n";
	}
	unset($dbg_def_user_funct_val);
	unset($dbg_def_user_funct_key);
	unset($dbg_def_functs);

	// Alle deklarierten Klassen
	$dbg_def_class = get_declared_classes();
	$dbg_class_list = '';
	foreach ($dbg_def_class as $dbg_def_class_key => $dbg_def_class_val) {
		$dbg_class_list .= $dbg_def_class_val."\r\n";
	}
	unset($dbg_def_class_val);
	unset($dbg_def_class_key);
	unset($dbg_def_class);

	// Alle deklarierten Interfaces
	$dbg_def_interfaces = get_declared_interfaces();
	$dbg_interfaces_list = '';
	foreach ($dbg_def_interfaces as $dbg_def_interfaces_key => $dbg_def_interfaces_val) {
		$dbg_interfaces_list .= $dbg_def_interfaces_val."\r\n";
	}
	unset($dbg_def_interfaces_val);
	unset($dbg_def_interfaces_key);
	unset($dbg_def_interfaces);

	// Sessiondaten Dump
	ob_start();
	print_r($_SESSION);
	$session_content .= ob_get_contents();
	@ob_end_clean();

	// Seite automatisch auf W3C-Konformität prüfen
	if ($w3c_check_enabled) {
		$dbg_w3c_start_time = getmicrotime();
		$dbg_w3c_check_result = w3c_fragment_checker::auto_perform_w3c_check($buffered_output, add_trailing_path_delimiter(URL_TO_VALIDATOR));
		if (is_null($dbg_w3c_check_result)) {
			$dbg_w3c_check_result_text = '<span class="warning"><b>Fehler bei W3C-Pr&uuml;fung!</b></span>';
		} else if ($dbg_w3c_check_result) {
			$dbg_w3c_check_result_text = '<span class="green"><b>Seite ist W3C-Konform!</b></span>';
		} else {
			$dbg_w3c_check_result_text = '<span class="red"><b>Seite ist nicht W3C-Konform!</b></span>';
		}
		$dbg_w3c_end_time = getmicrotime();
		unset($dbg_w3c_check_result);
		$dbg_w3c_time = $dbg_w3c_end_time - $dbg_w3c_start_time;
		unset($dbg_w3c_end_time);
		unset($dbg_w3c_start_time);
	} else {
		$dbg_w3c_check_result_text = '<span class="grey"><b>W3C-Pr&uuml;fung ist abgeschaltet!</b></span>';
		$dbg_w3c_time = 0;
	}

	// Zeitberechnungen
	$time_end = getmicrotime();
	$time  = round($time_end - $time_start + $dbg_w3c_time, 4);
	$time2 = round($mysql_time, 4);
	$time3 = round($xml_time, 4);
	$time5 = round($dbg_w3c_time, 4);
	$time4 = $time - $time2 - $time3 - $time5;
	$time_analyze = "Seite in $time Sekunden generiert ($mysql_count MySQL-Anfragen: $time2; $xml_count XML-Anfragen: $time3; W3C-Anfrage: $time5; Rest: $time4)";
	unset($time);
	unset($time2);
	unset($time3);
	unset($time4);
	unset($time5);

	// TODO: Status für dieses Toggle merken ( http://www.traum-projekt.com/forum/101-javascript/78788-div-aufklappen-zuklappen-status-merken.html )
	// TODO: Ein- und Ausklappen anderer Text...
	// IDEE: Togglefunktion ins Framework nehmen?

	$debugging = '<script language="JavaScript" type="text/javascript">
	<!--
	function toggleDebug() {
		var id = "pwb_debug_mode";
		if(document.getElementById(id).style.display == "none")
		{
			document.getElementById(id).style.display = "block";
		}
		else
		{
			document.getElementById(id).style.display = "none";
		}
	}
	// -->
	</script>

	<div id="pwb_debug_mode" style="display:none"><hr><center><span class="red"><font size="+1"><b>Debug-Modus</b></font></span>

	<p>'.$dbg_w3c_check_result_text.'</p>

	<form method="post" enctype="multipart/form-data" action="'.add_trailing_path_delimiter(URL_TO_VALIDATOR).'check" target="_blank">
	<input type="hidden" name="fragment" value="'.wb_htmlentities($buffered_output).'">
	<input type="submit" value="Ergebnis anzeigen" class="button" onmouseover="this.className=\'button_act\';" onmouseout="this.className=\'button\';">
	</form>

	<p><b>MySQL-Transkript</b></p>

	<textarea cols="100" rows="10" style="text-wrap:none">'.$sql_transkript.'</textarea>

	<p><b>Session-Inhalt (Name: '.session_name().', ID: '.session_id().')</b></p>

	<textarea cols="100" rows="10" style="text-wrap:none">'.$session_content.'</textarea>

	<p><b>Definierte Variablen</b></p>

	<textarea cols="100" rows="10" style="text-wrap:none">'.$dbg_var_list.'</textarea>

	<p><b>Definierte Konstanten</b></p>

	<textarea cols="100" rows="10" style="text-wrap:none">'.$dbg_const_list.'</textarea>

	<p><b>Definierte Funktionen</b></p>

	<textarea cols="100" rows="10" style="text-wrap:none">'.$dbg_user_funct_list.'</textarea>

	<p><b>Deklarierte Klassen</b></p>

	<textarea cols="100" rows="10" style="text-wrap:none">'.$dbg_class_list.'</textarea>

	<p><b>Deklarierte Interfaces</b></p>

	<textarea cols="100" rows="10" style="text-wrap:none">'.$dbg_interfaces_list.'</textarea>

	<p>'.$time_analyze.'</p></center><hr></div>

	<p align="center">[ <a href="javascript:toggleDebug()">Debug-Modus anzeigen/verstecken</a> ]</p>';

	echo str_replace('</body>', $debugging.'</body>', $buffered_output);

	unset($debugging);
	unset($buffered_output);
}

?>
