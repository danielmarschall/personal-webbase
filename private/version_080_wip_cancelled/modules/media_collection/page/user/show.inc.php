<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

echo $header;

function dreinull($inp)
{
	$out = $inp;
	if (strlen($inp) == 1) $out = '00'.$inp;
	if (strlen($inp) == 2) $out = '0'.$inp;
	return $out;
}

if (isset($aus)) db_query("UPDATE `".$WBConfig->getMySQLPrefix()."mediacollection_entries` SET `aussortiert` = '1' WHERE `category` = '".db_escape($id)."' AND `nr` = '".db_escape($aus)."' AND `user_cnid` = '".$benutzer['id']."'");
if (isset($ein)) db_query("UPDATE `".$WBConfig->getMySQLPrefix()."mediacollection_entries` SET `aussortiert` = '0' WHERE `category` = '".db_escape($id)."' AND `nr` = '".db_escape($ein)."' AND `user_cnid` = '".$benutzer['id']."'");

echo '<h1>Datentr&auml;gerarchiv</h1>';

echo '<b>Angezeigt wird: '.$id.'</b><br><br>';

$res2 = db_query("SELECT `nr`, `name`, `gebrannt`, `aussortiert` FROM `".$WBConfig->getMySQLPrefix()."mediacollection_entries` WHERE `category` = '".db_escape($id)."' AND `user_cnid` = '".$benutzer['id']."' ORDER BY `nr` ASC");
while ($row2 = db_fetch($res2))
{
	$res3 = db_query("SELECT `id` FROM `".$WBConfig->getMySQLPrefix()."mediacollection_content` WHERE `eintrag` = '".$row2['nr']."' AND `category` = '".db_escape($id)."' AND `user_cnid` = '".$benutzer['id']."'");
	if (db_num($res3) > 0)
	{
		$row3 = db_fetch($res3);
		$a3 = '<a href="?modul='.$modul.'&amp;seite=cdinhalt&amp;id='.$row3['id'].'">';
		$a4 = '</a>';
	}
	else
	{
		$a3 = '';
		$a4 = '';
	}
	if ($row2['gebrannt'] == '1')
	{
		$a1 = '<i>';
		$a2 = '</i>';
	}
	else
	{
		$a1 = '';
		$a2 = '';
	}
	if ($row2['aussortiert'] == '1')
	{
		$a1b = '<span class="grey">';
		$a2b = '</span>';
	}
	else
	{
		$a1b = '';
		$a2b = '';
	}
	if ($row2['aussortiert'] == '1')
		$xy = ' (<a href="?modul='.$modul.'&amp;seite=show&amp;id='.$id.'&amp;ein='.$row2['nr'].'">'.$a1b.'Einsortieren'.$a2b.'</a>)';
	else
		$xy = ' (<a href="?modul='.$modul.'&amp;seite=show&amp;id='.$id.'&amp;aus='.$row2['nr'].'">'.$a1b.'Aussortieren'.$a2b.'</a>)';
	echo $row2['nr'].'. '.$a3.$a1b.$a1.$row2['name'].$a2.$a4.$xy.$a2b.'<br>';
}
if (db_num($res2) == 0)
	echo 'Keine Eintr&auml;ge vorhanden!<br>';
echo '<br>';

echo '&lt;&lt; <a href="?modul='.$modul.'&amp;seite=main">Zur&uuml;ck zur &Uuml;bersicht</a>';

echo $footer;

?>