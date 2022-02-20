<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne IronBASE ausgef&uuml;hrt werden.');

  echo $header;

// Ich suche mir das aktuelle Kirchenfest von daskirchenjahr.de

$eingangsseite = my_get_contents('http://www.daskirchenjahr.de/index.php');

if ($eingangsseite == '') die('<b>Fehler: Konnte Ressourcen nicht beziehen!</b><br><br>Wenn das Problem weiterhin besteht, pr&uuml;fen Sie bitte Ihre PHP-Konfiguration.'.$footer);

preg_match_all('/Aktuelles Fest: <A HREF="(.+?)"(.+?)><B>(.+?)<\/B><\/A>/im', $eingangsseite, $omatches);
echo '<h1>'.htmlentities($modulueberschrift).'</h1>';

$festseite = my_get_contents('http://www.daskirchenjahr.de/'.$omatches[1][0].'&amp;typ=proprium');
preg_match_all('/<\/A><\/P><BR>(.+?)<CENTER><TABLE WIDTH="90%" CELLSPACING="4" ALIGN=CENTER><TR><TD style="text-align:center; background-color:#dcdcee"><FONT SIZE="-1">Zuletzt/is', $festseite, $matches);
echo '<h2>Proprium</h2>';
$txt = $matches[1][0];
$txt = str_replace('<A HREF="tag.php', '<A HREF="http://www.daskirchenjahr.de/tag.php', $txt);
$txt = str_replace('<A HREF="', '<A TARGET="_blank" HREF="', $txt);
$txt = str_replace('#DCDCDC', '#F4F4F4', $txt);
$txt = str_replace(' <FONT SIZE=2>()</FONT>', '', $txt);
  if (strpos($festseite, '<TD style="header;text-align=center;background-color:purple">')) $farbe = 'Violett';
  if (strpos($festseite, '<TD style="header;text-align=center;background-color:white">')) $farbe = 'Weiß';
  if (strpos($festseite, '<TD style="header;text-align=center;background-color:black">')) $farbe = 'Schwarz';
  if (strpos($festseite, '<TD style="header;text-align=center;background-color:green">')) $farbe = 'Grün';
  if (strpos($festseite, '<TD style="header;text-align=center;background-color:red">')) $farbe = 'Rot';

  preg_match_all('/<A class="mainmenu" style="background-color:#DCDCDC" href="(.+?)" title="(.+?)">(.+?)<\/A><BR><P style="text-align:center;background-color:#DFEAFF"><A class="submenu" style="background-color:#DFEAFF" href="tag.php(.+?)"/is', $festseite, $matches);
  $ary = explode('"', $matches[3][0]);
  $einordnung = '<a href="http://www.daskirchenjahr.de/'.$ary[count($ary)-4].'" target="_blank">'.$ary[count($ary)-2].'</a>';

  $dazwischen = '';
  $dazwischen .= '<TR VALIGN="TOP"><TD WIDTH="22%" STYLE="background-color:#F4F4F4"><P ALIGN="RIGHT"><STRONG>Name:</STRONG></P></TD><TD WIDTH="78%" STYLE="background-color:#F4F4F4"><P>'.$omatches[3][0].'</P></TD></TR>';
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

echo undo_transamp_replace_spitze_klammern($txt);

echo '<h2>Weitere Informationen</h2>';
echo '<ul>';

preg_match_all('/<p class="topmenu" style="background-color:#DCDCDC">(.+?)<\/P>/is', $festseite, $matches);
$txt = $matches[1][0];
$txt = preg_replace('/<A(.+?)>Proprium<\/A> \| /is', '', $txt);
$txt = str_replace(' | ', '</li><li>', $txt);
$txt = str_replace('<A HREF="tag.php', '<A HREF="http://www.daskirchenjahr.de/tag.php', $txt);
$txt = str_replace('<A HREF="', '<A TARGET="_blank" HREF="', $txt);
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

echo undo_transamp_replace_spitze_klammern($txt);

echo '</li>';
echo '</ul>Diese Informationen wurden zusammengetragen aus <a href="http://www.daskirchenjahr.de/" target="_blank">Das Kirchenjahr</a> von Dr. Martinus.';

  echo $footer;

?>
