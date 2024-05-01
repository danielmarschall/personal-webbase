<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

echo $header;

if ($ansicht == '') $ansicht = 'wurzel';

// $res2 = db_query("SELECT `eintrag`, `komplett` FROM `".$WBConfig->getMySQLPrefix()."mediacollection_content` WHERE `id` = '".db_escape($id)."' AND `user_cnid` = '".$benutzer['id']."'");
// $row2 = db_fetch($res2);

$res3 = db_query("SELECT `category`, `name` FROM `".$WBConfig->getMySQLPrefix()."mediacollection_entries` WHERE `id` = '".db_escape($id)."' AND `user_cnid` = '".$benutzer['id']."'");
$row3 = db_fetch($res3);

echo '<h1>Datentr&auml;gerarchiv</h1>';

echo '<b>Angezeigt wird der Inhalt von: '.$row3['name'].' ('.$row3['category'].')</b><br><br>';

if ($ansicht == 'wurzel')
{
	$a1a = '';
	$a1b = '';
}
else
{
	$a1a = '<a href="?modul='.$modul.'&amp;seite=cdinhalt&amp;id='.$id.'&amp;ansicht=wurzel">';
	$a1b = '</a>';
}

if ($ansicht == 'ordner')
{
	$a2a = '';
	$a2b = '';
}
else
{
	$a2a = '<a href="?modul='.$modul.'&amp;seite=cdinhalt&amp;id='.$id.'&amp;ansicht=ordner">';
	$a2b = '</a>';
}

if ($ansicht == 'komplett')
{
	$a3a = '';
	$a3b = '';
}
else
{
	$a3a = '<a href="?modul='.$modul.'&amp;seite=cdinhalt&amp;id='.$id.'&amp;ansicht=komplett">';
	$a3b = '</a>';
}

echo '['.$a1a.'Wurzelansicht'.$a1b.'] ['.$a2a.'Ordneransicht'.$a2b.'] ['.$a3a.'Komplettansicht'.$a3b.']<br><br>';

$roh = '';
$ary = explode("\n", $row2['komplett']);
for ($i=0; array_key_exists($i, $ary); $i++)
{
	if (($ansicht == 'wurzel') && (substr($ary[$i], 1, 3) == '---'))
		$roh .= $ary[$i]."\n";
	if (($ansicht == 'wurzel') && (substr($ary[$i], 0, 4) == '|	 ') && (substr($ary[$i], 5, 1) != ' '))
		$roh .= $ary[$i]."\n";
	if (($ansicht == 'ordner') && (strpos($ary[$i], '---')))
		$roh .= $ary[$i]."\n";
	if ($ansicht == 'komplett')
		$roh .= $ary[$i]."\n";
}

$zus = "Wurzelverzeichnis\n";

$inh = str_replace(' ', '&nbsp;', nl2br(htmlentities($zus.$roh)));

if ($row2['komplett'] == '') $inh = 'Kein Inhalt definiert';

echo '<code>'.$inh.'</code><br>';

echo '&lt;&lt; <a href="show.php?id='.$row3['category'].'">Zur&uuml;ck zu den Eintr&auml;gen</a>';

echo $footer;

?>