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


echo '<h1>'.wb_htmlentities($module_information->caption).'</h1>';

echo '[<a href="'.$_SERVER['PHP_SELF'].'?modul='.$modul.'&amp;seite=newkat">Neue Kategorie</a>] [<a href="?modul='.$modul.'&amp;seite=newdisk">Neuer Eintrag</a>] [<a href="?modul='.$modul.'&amp;seite=newinhalt">Neuer Inhalt</a>]<br><br>';

$res1 = db_query("SELECT `nummer`, `spalte`, `name` FROM `".$WBConfig->getMySQLPrefix()."mediacollection_categories` WHERE `user_cnid` = '".$benutzer['id']."' ORDER BY `spalte`, `nummer` ASC");
while ($row1 = db_fetch($res1))
{
	echo '<b>'.$row1['spalte'].dreinull($row1['nummer']).' - <a href="'.$_SERVER['PHP_SELF'].'?modul='.$modul.'&amp;seite=show&amp;id='.$row1['spalte'].$row1['nummer'].'">'.$row1['name'].'</a></b><br>';
}
if (db_num($res1) == 0)
	echo '<b>Keine Kategorien vorhanden!</b>';

$res3 = db_query("SELECT COUNT(`id`) AS `ct` FROM `".$WBConfig->getMySQLPrefix()."mediacollection_entries` WHERE `aussortiert` = '0' AND `user_cnid` = '".$benutzer['id']."'");
$row3 = db_fetch($res3);
echo '<br>Es befinden sich '.$row3['ct'].' Objekte im Datentr&auml;gerarchiv';

echo $footer;

?>