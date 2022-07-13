<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

  echo $header;

if ($modulueberschrift == '') $modulueberschrift = $modul;
echo '<h1>'.my_htmlentities($modulueberschrift).'</h1>';

  echo '<center><a href="'.$_SERVER['PHP_SELF'].'?modul='.urlencode($modul).'&amp;seite=inhalt"><b>Wochenauflistung</b></a> - <b>Terminauflistung</b> - <a href="'.$_SERVER['PHP_SELF'].'?modul='.urlencode($modul).'&amp;seite=edit&amp;aktion=new&amp;herkunft='.urlencode($seite).'"><b>Neuer Eintrag</b></a><br><br></center>';

  echo '<b>Einmalige Termine</b><br><br>';

  gfx_begintable();

  gfx_tablecontent('', '<b>Tag</b>', '', '<b>Name</b>', '', '<b>Startzeitpunkt</b>', '', '<b>Uhrzeit</b>', '', '<b>Verbleibende Zeit</b>', '', '<b>Aktionen</b>', '', '');

  $eingetr = false;

  $res = db_query("SELECT `id`, `name`, `start_date`, `start_time` FROM `".$mysql_zugangsdaten['praefix']."kalender` WHERE `user` = '".$benutzer['id']."' AND `start_date` >= NOW() ORDER BY `start_date`, `start_time`, `id`");
  while ($row = db_fetch($res))
  {
    $eingetr = true;

    $wd = substr($row['start_date'], 8, 2);
    $wm = substr($row['start_date'], 5, 2);
    $wy = substr($row['start_date'], 0, 4);

    $z = ceil((mktime(0, 0, 0, $wm, $wd, $wy)-mktime(0, 0, 0, date('m'), date('d'), date('Y')))/60/60/24);
    if ($z == 0)
    {
      $a1 = '<font color="#FF0000"><b>';
      $a2 = '</b></font>';
    }
    else if ($z < 0)
    {
      $a1 = '<font color="#666666">';
      $a2 = '</font>';
    }
    else
    {
      $a1 = '';
      $a2 = '';
    }

    $verbleibend = '';
    if ($z < 0) $verbleibend = 'Abgelaufen';
    if ($z == 0) $verbleibend = 'Heute';
    if ($z == 1) $verbleibend = 'Morgen';
    if ($z == 2) $verbleibend = '&Uuml;bermorgen';
    if ($z > 2) $verbleibend = $z.' Tage';

    $wten = date('w', mktime(0, 0, 0, $wm, $wd, $wy));
    if ($wten == 0) $wtag =  'Sonntag';
    if ($wten == 1) $wtag =  'Montag';
    if ($wten == 2) $wtag =  'Dienstag';
    if ($wten == 3) $wtag =  'Mittwoch';
    if ($wten == 4) $wtag =  'Donnerstag';
    if ($wten == 5) $wtag =  'Freitag';
    if ($wten == 6) $wtag =  'Samstag';

    gfx_tablecontent('', $a1.$wtag.$a2, '', $a1.$row['name'].$a2, '', $a1.de_convertmysqldatetime($row['start_date']).$a2, '', $a1.$row['start_time'].' Uhr'.$a2, '', $a1.$verbleibend.$a2, '', '<a href="'.$_SERVER['PHP_SELF'].'?seite=edit&amp;modul='.urlencode($modul).'&amp;aktion=edit&amp;danach=B&amp;id='.urlencode($row['id']).'&amp;herkunft='.urlencode($seite).'" class="menu">Bearbeiten</a>', '', '<a href="javascript:abfrage(\''.$_SERVER['PHP_SELF'].'?seite=kraftsetzung&amp;modul='.urlencode($modul).'&amp;aktion=delete&amp;zurueck='.urlencode($seite).'&amp;id='.urlencode($row['id']).'\');" class="menu">L&ouml;schen</a>');
  }

  if (!$eingetr)
    gfx_tablespancontent(0, 7, 'Keine Termine vorhanden!');

  gfx_endtable();

  echo $footer;

?>
