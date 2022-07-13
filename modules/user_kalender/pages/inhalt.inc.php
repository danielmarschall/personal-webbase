<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

  echo $header;

if ($modulueberschrift == '') $modulueberschrift = $modul;
echo '<h1>'.my_htmlentities($modulueberschrift).'</h1>';

  echo '<center><b>Wochenauflistung</b> - <a href="'.$_SERVER['PHP_SELF'].'?modul='.urlencode($modul).'&amp;seite=auflistung"><b>Terminauflistung</b></a> - <a href="'.$_SERVER['PHP_SELF'].'?modul='.urlencode($modul).'&amp;seite=edit&amp;aktion=new&amp;herkunft='.urlencode($seite).'"><b>Neuer Eintrag</b></a><br><br></center>';

// http://news.php.net/php.notes/102689

function get_week_boundaries($int_time)
{
  // first: find monday 0:00
  $weekdayid=date("w",$int_time);

  // christliche zeitrechnung (woche beginnt mit sonntag) umgehen
  if ($weekdayid == 0) $weekdayid = 7;

  $dayid=date("j",$int_time);
  $monthid=date("n", $int_time);
  $yearid=date("Y", $int_time);
  $beginofday=mktime(0,0,0,$monthid,$dayid,$yearid);
  $beginofweek=$beginofday - (($weekdayid-1) * 86400); //86400 == seconds of one day (24 hours)
  //now add the value of one week and call it the end of the week
  //NOTE: End of week is Sunday, 23:59:59. I think you could also use Monday 00:00:00 but I though that'd suck
  $endofweek=($beginofweek + 7 * 86400)-1;
  $week["begin"]=$beginofweek;
  $week["end"]=$endofweek;
  $week["pov"]=$int_time;
  return $week;
}

function zweinull($e)
{
  if (strlen($e) == 1)
    return '0'.$e;
  else
    return $e;
}

function wochenstat($woche)
{
  global $mysql_zugangsdaten, $benutzer, $modul, $seite;

  gfx_begintable();

  gfx_tablecontent('100', '<b>Tag</b>', '', '<b>Name</b>', '190', '<b>Startzeitpunkt</b>', '130', '<b>Verbleibende Zeit</b>', '100', '<b>Aktionen</b>', '100', '');

  $current_week = get_week_boundaries(time()+$woche*60*60*24*7);

  $eintr = false;
  for ($i=0; $i<7; $i++)
  {
    $wbeg = $current_week["begin"]+$i*60*60*24;
    $wd = date("d", $wbeg);
    $wm = date("m", $wbeg);
    $wy = date("Y", $wbeg);

    if ((date("d") == $wd) && (date("m") == $wm) && (date("Y") == $wy))
    {
      $a1 = '<font color="#FF0000"><b>';
      $a2 = '</b></font>';
    }
    else
    {
      $a1 = '';
      $a2 = '';
    }
    $res = db_query("SELECT `id`, `name`, `start_time` FROM `".$mysql_zugangsdaten['praefix']."kalender` WHERE `user` = '".$benutzer['id']."' AND SUBSTRING(`start_date`, 1, 4) = '$wy' AND SUBSTRING(`start_date`, 6, 2) = '$wm' AND SUBSTRING(`start_date`, 9, 2) = '$wd' ORDER BY `start_date`, `start_time`, `id`");
    while ($row = db_fetch($res))
    {
      $eintr = true;
      $z = ceil((mktime(0, 0, 0, $wm, $wd, $wy)-mktime(0, 0, 0, date('m'), date('d'), date('Y')))/60/60/24);
      if ($z < 0)
      {
        $a1 = '<font color="#666666">';
        $a2 = '</font>';
      }

      $wochentag = '';
      if ($i == 0) $wochentag = 'Montag';
      if ($i == 1) $wochentag = 'Dienstag';
      if ($i == 2) $wochentag = 'Mittwoch';
      if ($i == 3) $wochentag = 'Donnerstag';
      if ($i == 4) $wochentag = 'Freitag';
      if ($i == 5) $wochentag = 'Samstag';
      if ($i == 6) $wochentag = 'Sonntag';

      $verbleibend = '';
      if ($z < 0) $verbleibend = 'Abgelaufen';
      if ($z == 0) $verbleibend = 'Heute';
      if ($z == 1) $verbleibend = 'Morgen';
      if ($z == 2) $verbleibend = '&Uuml;bermorgen';
      if ($z > 2) $verbleibend = $z.' Tage';

      gfx_tablecontent('', $a1.$wochentag.$a2, '', $a1.$row['name'].$a2, '', $a1.de_convertmysqldatetime($wy.'-'.$wm.'-'.$wd.' '.$row['start_time']).$a2, '', $a1.$verbleibend.$a2, '', '<a href="'.$_SERVER['PHP_SELF'].'?seite=edit&amp;modul='.urlencode($modul).'&amp;aktion=edit&amp;danach=A&amp;id='.urlencode($row['id']).'&amp;herkunft='.urlencode($seite).'" class="menu">Bearbeiten</a>', '', '<a href="javascript:abfrage(\''.$_SERVER['PHP_SELF'].'?seite=kraftsetzung&amp;modul='.urlencode($modul).'&amp;aktion=delete&amp;zurueck='.urlencode($seite).'&amp;id='.urlencode($row['id']).'\');" class="menu">L&ouml;schen</a>');
    }
  }
  if (!$eintr)
  {
    gfx_tablespancontent(0, 6, 'Keine Termine vorhanden!');
  }

  gfx_endtable();
}

$d = date('j');
$m = date('n');
$y = date('Y');

$anzahl_wochen = 5; // Konfigurierbar

for ($ii=0; $ii<=$anzahl_wochen; $ii++)
{
  if ($ii == 0)
    $ueb = 'diese Woche';
  else if ($ii == 1)
    $ueb = 'n&auml;chste Woche';
  else if ($ii == 2)
    $ueb = '&uuml;bern&auml;chste Woche';
  else if ($ii > 2)
    $ueb = 'in '.$ii.' Wochen';

  $uri = get_week_boundaries(mktime(0,0,0,$m,$d+7*$ii,$y));
  echo '<b>Termine '.$ueb.'</b> (Kalenderwoche '.date('W/Y', mktime(0,0,0,$m,$d+7*$ii,$y)).' von '.date("d.m.Y", $uri['begin']).' - '.date("d.m.Y", $uri['end']).')<br><br>';
  wochenstat($ii);
}

  echo $footer;

?>
