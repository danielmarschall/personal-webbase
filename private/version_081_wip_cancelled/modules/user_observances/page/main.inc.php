<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

echo $header;

function martinus_parse_url($input) {
	return '<a target="_blank" href="'.deferer('http://www.daskirchenjahr.de/tag.php'.$input[1]).'"';
}

// Ich suche mir das aktuelle Kirchenfest von daskirchenjahr.de

$eingangsseite = my_get_contents('http://www.daskirchenjahr.de/index.php');

if ($eingangsseite == '') die('<b>Fehler: Konnte Ressourcen nicht beziehen!</b><br><br>Wenn das Problem weiterhin besteht, pr&uuml;fen Sie bitte Ihre PHP-Konfiguration.'.$footer);

preg_match('|<A HREF="([^"]+)" TITLE="Aktuelles Fest"><b>(.+)</b></A>|ismU', $eingangsseite, $omatch);
echo '<h1>'.wb_htmlentities($module_information->caption).'</h1>';

$festseite = my_get_contents('http://www.daskirchenjahr.de/'.$omatch[1]);
preg_match_all('/<\/A><\/P><BR>(.+?)<CENTER><TABLE WIDTH="90%" CELLSPACING="4" ALIGN=CENTER><TR><TD style="text-align:center; background-color:#dcdcee"><FONT SIZE="-1">Zuletzt/is', $festseite, $matches);
echo '<h2>Proprium</h2>';
$txt = $matches[1][0];

$txt = str_replace('<A HREF="', '<a target="_blank" href="', $txt);
$txt = preg_replace_callback('/<a target="_blank" href="tag.php(.+?)"/ism', 'martinus_parse_url', $txt);

$txt = str_replace('#DCDCDC', '#F4F4F4', $txt);
$txt = str_replace(' <FONT SIZE=2>()</FONT>', '', $txt);
$farbe = '?';
if (strpos($festseite, '<TD style="header;text-align:center;background-color:purple">') !== false) $farbe = 'Violett';
else if (strpos($festseite, '<TD style="header;text-align:center;background-color:white">') !== false) $farbe = 'Weiß';
else if (strpos($festseite, '<TD style="header;text-align:center;background-color:black">') !== false) $farbe = 'Schwarz';
else if (strpos($festseite, '<TD style="header;text-align:center;background-color:green">') !== false) $farbe = 'Grün';
else if (strpos($festseite, '<TD style="header;text-align:center;background-color:red">') !== false) $farbe = 'Rot';

preg_match_all('/<A class="mainmenu" style="background-color:#DCDCDC" href="(.+?)" title="(.+?)">(.+?)<\/A><BR><P style="text-align:center;background-color:#DFEAFF"><A class="submenu" style="background-color:#DFEAFF" href="tag.php(.+?)"/is', $festseite, $matches);
$ary = explode('"', $matches[3][0]);
$einordnung = '<a target="_blank" href="'.deferer('http://www.daskirchenjahr.de/'.$ary[count($ary)-4]).'">'.$ary[count($ary)-2].'</a>';

$dazwischen = '';
$dazwischen .= '<TR VALIGN="TOP"><TD WIDTH="22%" STYLE="background-color:#F4F4F4"><P ALIGN="RIGHT"><STRONG>Name:</STRONG></P></TD><TD WIDTH="78%" STYLE="background-color:#F4F4F4"><P>'.$omatch[2].'</P></TD></TR>';
$dazwischen .= '<TR VALIGN="TOP"><TD WIDTH="22%" STYLE="background-color:#F4F4F4"><P ALIGN="RIGHT"><STRONG>Einordnung:</STRONG></P></TD><TD WIDTH="78%" STYLE="background-color:#F4F4F4"><P>'.$einordnung.'</P></TD></TR>';
$dazwischen .= '<TR VALIGN="TOP"><TD WIDTH="22%" STYLE="background-color:#F4F4F4"><P ALIGN="RIGHT"><STRONG>Farbe:</STRONG></P></TD><TD WIDTH="78%" STYLE="background-color:#F4F4F4"><P>'.$farbe.'</P></TD></TR>';
$txt = str_replace('<COL WIDTH="201*"><TR VALIGN="TOP">', '<COL WIDTH="201*">'.$dazwischen.'<TR VALIGN="TOP">', $txt);
$txt = preg_replace('/<FONT SIZE=2>(.+?)<\/FONT>/is', '$1', $txt);

// Sonderzeichen
$txt = str_replace('&', '&amp;', $txt);
$txt = str_replace('Ä', '&Auml;', $txt);
$txt = str_replace('Ö', '&Ouml;', $txt);
$txt = str_replace('Ü', '&Uuml;', $txt);
$txt = str_replace('ä', '&auml;', $txt);
$txt = str_replace('ö', '&ouml;', $txt);
$txt = str_replace('ü', '&uuml;', $txt);
$txt = str_replace('ß', '&szlig;', $txt);

echo decode_critical_html_characters($txt);

echo '<h2>Weitere Informationen</h2>';
echo '<ul>';

preg_match_all('/<p class="topmenu" style="background-color:#DCDCDC">(.+?)<\/P>/is', $festseite, $matches);
$txt = $matches[1][0];
$txt = preg_replace('/<A(.+?)>Proprium<\/A> \| /is', '', $txt);
$txt = str_replace(' | ', '</li><li>', $txt);

$txt = str_replace('<A HREF="', '<a target="_blank" href="', $txt);
$txt = preg_replace_callback('/<a target="_blank" href="tag.php(.+?)"/ism', 'martinus_parse_url', $txt);

echo '<li>';

// Sonderzeichen
$txt = str_replace('&', '&amp;', $txt);
$txt = str_replace('Ä', '&Auml;', $txt);
$txt = str_replace('Ö', '&Ouml;', $txt);
$txt = str_replace('Ü', '&Uuml;', $txt);
$txt = str_replace('ä', '&auml;', $txt);
$txt = str_replace('ö', '&ouml;', $txt);
$txt = str_replace('ü', '&uuml;', $txt);
$txt = str_replace('ß', '&szlig;', $txt);

echo decode_critical_html_characters($txt);

echo '</li>';
echo '</ul>Diese Informationen wurden zusammengetragen aus <a target="_blank" href="'.deferer('http://www.daskirchenjahr.de/').'">Das Kirchenjahr</a> von Dr. Martinus.';

echo $footer;

?>
