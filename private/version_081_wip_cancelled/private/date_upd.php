<?php

if (isset($_SERVER['SERVER_NAME']))
{
	die('Bitte f&uuml;hren Sie dieses Script separat &uuml;ber den PHP-Interpreter aus.');
}

define('SHOW_OUTPUT', false);

/* --------------------------- */

function getAllFiles($directory, $recursive = true) {
	$result = array();
	$handle =  opendir($directory);
	while ($datei = readdir($handle))
	{
		if (($datei != '.') && ($datei != '..'))
		{
			$file = $directory.$datei;
			if (is_dir($file)) {
				if ($recursive) {
					$result = array_merge($result, getAllFiles($file.'/'));
				}
			} else {
				$result[] = $file;
			}
		}
	}
	closedir($handle);
	return $result;
}

function getHighestFileTimestamp($directory, $recursive = true) {
	$allFiles = getAllFiles($directory, $recursive);
	$highestKnown = 0;
	foreach ($allFiles as $val) {
		// WebBase-Spezifisch: Die eigenen Revisionsdaten gelten nicht als Relevant!
		if (($val != $directory.'revision.inc.php') && ($val != $directory.'info.xml')) {
			$currentValue = filemtime($val);
			if ($currentValue > $highestKnown) $highestKnown = $currentValue;
		}
	}
	return $highestKnown;
}

/* --------------------------- */

$dir = dirname($_SERVER['SCRIPT_NAME']);
$dir .= '/../';
$dir = realpath($dir);

chdir($dir);

$ary = array();
$i = 0;
$v = 'modules/';
$verz = opendir($v);

while ($file = readdir($verz))
{
	if (($file != '.') && ($file != '..') && (is_dir($v.$file)))
	{
		$i++;
		$ary[$i] = $file;
	}
}

closedir($verz);
sort($ary);

foreach ($ary as $val)
{
	$mod_timestamp = getHighestFileTimestamp('modules/'.$val.'/');
	$dat = date('Y-m-d', $mod_timestamp);

	if (file_exists('modules/'.$val.'/info.xml'))
	{
		if (SHOW_OUTPUT) echo "Module '$val' has now the modification date '$dat'.\n";

		$inhalt = file_get_contents('modules/'.$val.'/info.xml');
		$inhalt = preg_replace('/<version>(.+?)<\/version>/im', '<version>'.$dat.'</version>', $inhalt);

		$handle = fopen('modules/'.$val.'/info.xml', 'w');
		fwrite($handle, $inhalt);
		fclose($handle);
	}
}
unset($val);

/* --------------------------- */

$ary = array();
$i = 0;
$v = 'designs/';
$verz = opendir($v);

while ($file = readdir($verz))
{
	if (($file != '.') && ($file != '..') && (is_dir($v.$file)))
	{
		$i++;
		$ary[$i] = $file;
	}
}

closedir($verz);
sort($ary);

foreach ($ary as $val)
{
	$mod_timestamp = getHighestFileTimestamp('designs/'.$val.'/');
	$dat = date('Y-m-d', $mod_timestamp);

	if (file_exists('designs/'.$val.'/info.xml'))
	{
		if (SHOW_OUTPUT) echo "Design '$val' has now the modification date '$dat'.\n";

		$inhalt = file_get_contents('designs/'.$val.'/info.xml');
		$inhalt = preg_replace('/<version>(.+?)<\/version>/im', '<version>'.$dat.'</version>', $inhalt);

		$handle = fopen('designs/'.$val.'/info.xml', 'w');
		fwrite($handle, $inhalt);
		fclose($handle);
	}
}
unset($val);

/* --------------------------- */

if (file_exists('includes/revision.inc.php'))
{
	$mod_timestamp = getHighestFileTimestamp('./');
	$dat = date('d.m.Y', $mod_timestamp);

	ob_start();
	readfile('includes/revision.inc.php');
	$buffer = ob_get_contents();
	@ob_end_clean();

	$ary = explode("\n", $buffer);

	foreach ($ary as $val)
	{
		$bry = explode(' = ', $val);

		if ($bry[0] == '$rev_datum')
		{
			$buffer = str_replace('$rev_datum = '.$bry[1], '$rev_datum = \''.$dat.'\';', $buffer);
		}
	}
	unset($val);

	$handle = fopen('includes/revision.inc.php', 'w');
	fwrite($handle, $buffer);
	fclose($handle);

	if (SHOW_OUTPUT) echo "The system has now the modification date '$dat'.\n";
}

if (SHOW_OUTPUT) {
	die("\nDie Datumsangaben aller Module/Designs und die Revisionsinformation wurden aktualisiert!\n");
}

?>