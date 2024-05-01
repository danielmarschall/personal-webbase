<?php

if (isset($_SERVER['SERVER_NAME']))
{
	die("Bitte f&uuml;hren Sie dieses Script separat &uuml;ber den PHP-Interpreter aus.\n");
}

// $re...

if (!isset($re)) die("Nichts zu ersetzen...\n");

$my_dir = '/home/webbase/public_html/dev/';

if (!is_dir($my_dir)) die("FEHLER: Verzeichnis '$my_dir' existiert nicht!!\n");

function work($file) {
	global $re;

	if (!fnmatch('*.php', $file)) {
		return false;
	}

	if (!is_readable($file)) {
		echo "FEHLER: Datei '$file' ist nicht lesbar!\n";
		return false;
	}

	$cont = file_get_contents($file);
	$vcont = $cont;

	foreach ($re as $a => $b) {
		$cont = str_replace($a, $b, $cont);
	}

	if ($vcont != $cont) {
		if (!is_writable($file)) {
			echo "FEHLER: Datei '$file' kann nicht geschrieben werden!\n";
			return false;
		} else {
			$h = fopen($file, 'w');
			fputs($h, $cont);
			fclose($h);
		}
	}

	return true;
}

function rec($verzeichnis) {
	$handle = opendir($verzeichnis);
	while ($datei = readdir($handle))
	{
		if (($datei != '.') && ($datei != '..'))
		{
			$file = $verzeichnis.$datei;
			if (is_dir($file)) // Wenn Verzeichniseintrag ein Verzeichnis ist
			{
				if ($datei != 'system') { // Keine 3Ps
					// Erneuter Funktionsaufruf, um das aktuelle Verzeichnis auszulesen
					rec($file.'/');
				}
			} else {
				work($file);
			}
		}
	}
	closedir($handle);
}

rec($my_dir);

// Positive Ausnahmen (da alle "system" Verzeichnisse ausgeschlossen)
work('/home/webbase/public_html/dev/modules/user_phpmyadmin/system/config.inc.php');

?>
