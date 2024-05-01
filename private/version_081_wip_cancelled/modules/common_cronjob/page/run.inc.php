<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

function cron_shutdown()
{
	global $modul;
	global $passiv;
	global $logge_fehler;
	global $out;

	if ($logge_fehler)
	{
		$out = ob_get_contents();
		if ((ob_get_level() > 0) || (ob_get_length() !== FALSE))
			@ob_end_clean();
	}

	if (($out != '') && (function_exists('fehler_melden')))
	{
		db_connect(); // Durch die �bliche Shutdown-Funktion ist die DB-Verbindung bereits getrennt
		fehler_melden($modul, '<b>Cron-Ausgabe nicht leer</b><br><br>Der Crondurchlauf ist unsauber, da ein Modul Ausgaben verursacht. Dies zeigt in der Regel eine St&ouml;rung des Systems oder eine Fehlfunktion der Module. Die komplette Ausgabe des Crondurchlaufes ist:<br><br>'.$out);
		db_disconnect();
	}
}

// Cron-Jobs nur jede Minute zulassen, nicht �fter
// Wenn Cron-Job �berp�nktlich, z.B. bei I=59s, dann w�rde der Cronjob ausfallen, daher pr�fe ich auf 50 Sekunden-Zyklus
$rsc = db_query("SELECT * FROM `".$WBConfig->getMySQLPrefix()."configuration` WHERE `name` = 'last_cronjob' AND `value` <= DATE_SUB(NOW(), INTERVAL 50 SECOND)");
if (db_num($rsc) > 0)
{
	// Fehlerlogging starten
	$logge_fehler = true;

	register_shutdown_function('cron_shutdown');

	wb_change_config('last_cronjob', db_time(), $modul);
	wb_change_config('lastpromoter', $_SERVER['REMOTE_ADDR'], $modul);

	ob_start();

	// Reinigungsmodul statisch aufrufen, bevor die Cronjobs von den Modulen durchgef�hrt werden.
	// Grund: Bei den Cronjob-Arbeiten sollen die Module m�glichst keine Datens�tze mit ung�ltigen Bez�gen bearbeiten
	$modul_bak = $modul;

	$modul = 'common_cleaner';
	$module_information = get_module_information($modul);

	if (file_exists('modules/'.$modul.'/static/'.$modul_bak.'/main.inc.php'))
	{
		$filename = 'modules/'.$modul.'/static/'.$modul_bak.'/main.inc.php';

		// eval() statt include(), damit Parsing-Fehler gemeldet werden k�nnen, die der Admin nicht sehen w�rde!
		eval('?>' . trim(implode("\n", file($filename))));
	}

	$modul = $modul_bak;

	// Nun die Modulcronjobs durchf�hren

	foreach ($modules as $m1 => $m2)
	{
		$module_information = get_module_information($m2);

		// Nun die Modulcrons laden
		if (file_exists('modules/'.$m2.'/crossover/'.$modul.'/main.inc.php'))
		{
			$filename = 'modules/'.$m2.'/crossover/'.$modul.'/main.inc.php';

			// eval() statt include(), damit Parsing-Fehler gemeldet werden k�nnen, die der Admin nicht sehen w�rde!
			eval('?>' . trim(implode("\n", file($filename))));
		}
	}

	unset($m1);
	unset($m2);

	$success = true;
}
else
{
	$success = false;
}

// Ab hier keine Fehler mehr loggen...
$out = ob_get_contents();
if ((ob_get_level() > 0) || (ob_get_length() !== FALSE))
	@ob_end_clean();
$logge_fehler = false;

if ((isset($passiv)) && ($passiv == 1))
{
	// Wird bei der Hinzuf�gung der "GIF"-Datei gesetzt, nicht hier
	// wb_change_config('passivcron', '0', $modul);

	// Wir tun so, als w�ren wir ein Spacer
	if (!headers_sent()) header('Content-type: image/gif');
	readfile('designs/spacer.gif');
}
else
{
	wb_change_config('passivcron', '0', $modul);
	if ((!isset($silent)) || ($silent != 'yes'))
	{
		if ($success)
			echo $header.'<b>Cronjobs ausgef&uuml;hrt</b><br><br>Die Cronjobs wurden erfolgreich durchgef&uuml;hrt'.$footer;
		else
			echo $header.'<b>Cronjobs nicht ausgef&uuml;hrt</b><br><br>Die Cronjobs k&ouml;nnen nur jede Minute ausgef&uuml;hrt werden.'.$footer;
	}
}

?>