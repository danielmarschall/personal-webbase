<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

$res = db_query("SELECT `data`, `type`, `filename` FROM `".$WBConfig->getMySQLPrefix()."files` WHERE `id` = '".db_escape($id)."' AND `user_cnid` = '".$benutzer['id']."'");

if (db_num($res) == 0)
	die($header.'<b>Fehler</b><br><br>Der Download wurde nicht gefunden.'.$footer);

$row = db_fetch($res);

// Abgeänderte Version von http://www.php.net/manual/de/function.fread.php (Benutzerkommentar)

$size = strlen($row['data']);
$filename = $row['filename'];
$ctype = $row['type']; //application/force-download

if (strstr($_SERVER['HTTP_USER_AGENT'], "MSIE"))
	$filename = preg_replace('/\./', '%2e', $filename, substr_count($filename, '.') - 1);

//if (!headers_sent()) header("Cache-Control:");
//if (!headers_sent()) header("Cache-Control: public");
if (!headers_sent()) header("Content-Type: $ctype");
if (!headers_sent()) header('Content-Disposition: attachment; filename="'.$filename.'"');
if (!headers_sent()) header("Accept-Ranges: bytes");

if (isset($_SERVER['HTTP_RANGE']))
{
	$ary = explode("=",$_SERVER['HTTP_RANGE']);
	if (count($ary) != 2) die(''); // Hinzugefügt
	list($a, $range) = $ary;
	str_replace($range, "-", $range);
	$size2=$size-1;
	$new_length=$size2-$range;
	if (!headers_sent()) header("HTTP/1.1 206 Partial Content");
	if (!headers_sent()) header("Content-Length: $new_length");
	if (!headers_sent()) header("Content-Range: bytes $range$size2/$size");
}
else
{
	$size2=$size-1;
	if (!headers_sent()) header("Content-Range: bytes 0-$size2/$size");
	if (!headers_sent()) header("Content-Length: ".$size);
}

flush();

$buffer = 1024*8;
$range = 0;
while ($range <= $size)
{
	print(substr($row['data'], $range, $buffer)); // binary
	$range += $buffer;
	flush();
}

die();

// Das "die" verhindert im Debugmodus die Fehlermeldung
// Notice:  Trying to get property of non-object in /usr/share/php/Services/W3C/HTMLValidator.php on line 316

// Info: http://wordpress.macosbrain.com/2006/04/30/php-download-funktion-mit-multipart-und-resume/

?>