<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne IronBASE ausgef&uuml;hrt werden.');

echo $header;

function dreinull($inp)
{
  $out = $inp;
  if (strlen($inp) == 1) $out = '00'.$inp;
  if (strlen($inp) == 2) $out = '0'.$inp;
  return $out;
}

if ($modulueberschrift == '') $modulueberschrift = $modul;
echo '<h1>'.htmlentities($modulueberschrift).'</h1>';

echo '[<a href="'.$_SERVER['PHP_SELF'].'?modul='.$modul.'&amp;seite=newkat">Neue Kategorie</a>] [<a href="?modul='.$modul.'&amp;seite=newdisk">Neuer Eintrag</a>] [<a href="?modul='.$modul.'&amp;seite=newinhalt">Neuer Inhalt</a>]<br><br>';

$res1 = db_query("SELECT `nummer`, `spalte`, `name` FROM `".$mysql_zugangsdaten['praefix']."datentraeger_kategorien` WHERE `user` = '".$benutzer['id']."' ORDER BY `spalte`, `nummer` ASC");
while ($row1 = db_fetch($res1))
{
  echo '<b>'.$row1['spalte'].dreinull($row1['nummer']).' - <a href="'.$_SERVER['PHP_SELF'].'?modul='.$modul.'&amp;seite=show&amp;id='.$row1['spalte'].$row1['nummer'].'">'.$row1['name'].'</a></b><br>';
}
if (db_num($res1) == 0)
  echo '<b>Keine Kategorien vorhanden!</b>';

$res3 = db_query("SELECT COUNT(`id`) AS `ct` FROM `".$mysql_zugangsdaten['praefix']."datentraeger_eintraege` WHERE `aussortiert` = '0' AND `user` = '".$benutzer['id']."'");
$row3 = db_fetch($res3);
echo '<br>Es befinden sich '.$row3['ct'].' Objekte im Datentr&auml;gerarchiv';

echo $footer;

?>