<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

function abschnitt_bei_stelle($zahl, $stelle)
{
  return ((floor($zahl*pow(10,$stelle)))/pow(10,$stelle));
}

echo $header;

if (($kategorie != 'faecher') && ($kategorie != 'noten') && ($kategorie != 'auswertung') && ($kategorie != 'hausaufgaben') && ($kategorie != 'striche'))
  $kategorie = 'faecher';

$res = db_query("SELECT * FROM `".$mysql_zugangsdaten['praefix']."schule_jahrgaenge` WHERE `user` = '".$benutzer['id']."' AND `id` = '".db_escape($id)."';");
if (db_num($res) == 0) die('<b>Fehler</b><br><br>Datensatz nicht gefunden oder keine Berechtigung!');
$rw = db_fetch($res);

echo '<center>[ ';
if ($kategorie == 'faecher')
  echo 'Schulf&auml;cher';
else
  echo '<a href="'.$_SERVER['PHP_SELF'].'?modul='.urlencode($modul).'&amp;seite='.urlencode($seite).'&amp;id='.urlencode($id).'&amp;kategorie=faecher">Schulf&auml;cher</a>';
echo ' | ';
if ($kategorie == 'noten')
  echo 'Noten';
else
  echo '<a href="'.$_SERVER['PHP_SELF'].'?modul='.urlencode($modul).'&amp;seite='.urlencode($seite).'&amp;id='.urlencode($id).'&amp;kategorie=noten">Noten</a>';
echo ' | ';
if ($kategorie == 'auswertung')
  echo 'Auswertung';
else
  echo '<a href="'.$_SERVER['PHP_SELF'].'?modul='.urlencode($modul).'&amp;seite='.urlencode($seite).'&amp;id='.urlencode($id).'&amp;kategorie=auswertung">Auswertung</a>';
echo ' | ';
if ($kategorie == 'hausaufgaben')
  echo 'Hausaufgaben';
else
  echo '<a href="'.$_SERVER['PHP_SELF'].'?modul='.urlencode($modul).'&amp;seite='.urlencode($seite).'&amp;id='.urlencode($id).'&amp;kategorie=hausaufgaben">Hausaufgaben</a>';
echo ' | ';
if ($kategorie == 'striche')
  echo 'Striche';
else
  echo '<a href="'.$_SERVER['PHP_SELF'].'?modul='.urlencode($modul).'&amp;seite='.urlencode($seite).'&amp;id='.urlencode($id).'&amp;kategorie=striche">Striche</a>';
echo ' ]</center><br><br>

<form method="POST" action="'.$_SERVER['PHP_SELF'].'">
<input type="hidden" name="modul" value="'.$modul.'">
<input type="hidden" name="seite" value="'.$seite.'">
<input type="hidden" name="id" value="'.$id.'">
<input type="hidden" name="kategorie" value="'.$kategorie.'">
<input type="hidden" name="sent" value="yes">';

if ($kategorie == 'faecher')
{
  if (isset($sent) && ($sent))
    db_query("INSERT INTO `".$mysql_zugangsdaten['praefix']."schule_faecher` (`user`, `jahrgang`, `name`, `wertungsfaktor`) VALUES ('".$benutzer['id']."', '".db_escape($id)."', '".db_escape($name)."', '".db_escape($wertungsfaktor)."')");

  if (isset($delete) && ($delete))
  {
    db_query("DELETE FROM `".$mysql_zugangsdaten['praefix']."schule_faecher` WHERE `user` = '".$benutzer['id']."' AND `id` = '".db_escape($delete)."' AND `jahrgang` = '".db_escape($id)."'");
    if (db_affected_rows() > 0)
      db_query("OPTIMIZE TABLE `".$mysql_zugangsdaten['praefix']."schule_faecher`");
  }
  $res = db_query("SELECT `name`, `wertungsfaktor`, `id` FROM `".$mysql_zugangsdaten['praefix']."schule_faecher` WHERE `user` = '".$benutzer['id']."' AND `jahrgang` = '".db_escape($id)."'");
  gfx_begintable();
  gfx_tablecontent('', '<b>Fach</b>', '', '<b>Wertungsfaktor</b>', '', '<b>Aktionen</b>');
  while ($row = db_fetch($res))
    gfx_tablecontent('100%', $row['name'], '', $row['wertungsfaktor'], '', '<a href="javascript:abfrage(\''.$_SERVER['PHP_SELF'].'?modul='.urlencode($modul).'&amp;seite='.urlencode($seite).'&amp;id='.urlencode($id).'&amp;kategorie='.urlencode($kategorie).'&amp;delete='.urlencode($row['id']).'\')">L&ouml;schen</a>');
  gfx_tablecontent('', 'Neues Schulfach anlegen:<img src="design/spacer.gif" width="25" height="1" alt=""><input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="name">', '', '<input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="wertungsfaktor" value="1">', '', '<input type="submit" class="button" onmouseover="this.className=\'button_act\';" onmouseout="this.className=\'button\';" value)="Anlegen">');
  gfx_endtable();
}

if ($kategorie == 'noten')
{
  if (isset($sent) && ($sent))
    db_query("INSERT INTO `".$mysql_zugangsdaten['praefix']."schule_noten` (`user`, `jahrgang`, `fach`, `name`, `wertung`, `note`) VALUES ('".$benutzer['id']."', '".db_escape($id)."', '".db_escape($fach)."', '".db_escape($name)."', '".db_escape($wertung)."', '".db_escape($note)."')");

  if (isset($delete) && ($delete))
  {
    db_query("DELETE FROM `".$mysql_zugangsdaten['praefix']."schule_noten` WHERE `user` = '".$benutzer['id']."' AND `id` = '".db_escape($delete)."' AND `jahrgang` = '".db_escape($id)."'");
    if (db_affected_rows() > 0)
      db_query("OPTIMIZE TABLE `".$mysql_zugangsdaten['praefix']."schule_noten`");
  }

  $res = db_query("SELECT `id`, `fach`, `name`, `wertung`, `note` FROM `".$mysql_zugangsdaten['praefix']."schule_noten` WHERE `user` = '".$benutzer['id']."' AND `jahrgang` = '".db_escape($id)."'");
  gfx_begintable();
  if ($rw['notensystem'] == 0)
    gfx_tablecontent('', '<b>Fach</b>', '', '<b>Name</b>', '', '<b>Wertung</b>', '', '<b>Note</b>', '', '<b>Aktionen</b>');
  if ($rw['notensystem'] == 1)
    gfx_tablecontent('', '<b>Fach</b>', '', '<b>Name</b>', '', '<b>Wertung</b>', '', '<b>Notenpunkte</b>', '', '<b>Note</b>', '', '<b>Aktionen</b>');
  while ($row = db_fetch($res))
  {
    $res2 = db_query("SELECT `name` FROM `".$mysql_zugangsdaten['praefix']."schule_faecher` WHERE `id` = '".db_escape($row['fach'])."' AND `user` = '".$benutzer['id']."' AND `jahrgang` = '".db_escape($id)."'");
    $row2 = db_fetch($res2);
    $fach = $row2['name'];

    if ($rw['notensystem'] == 0)
      gfx_tablecontent('', $fach, '', $row['name'], '', $row['wertung'], '', $row['note'], '', '<a href="javascript:abfrage(\''.$_SERVER['PHP_SELF'].'?modul='.urlencode($modul).'&amp;seite='.urlencode($seite).'&amp;id='.urlencode($id).'&amp;kategorie='.urlencode($kategorie).'&amp;delete='.urlencode($row['id']).'\')">L&ouml;schen</a>');
    if ($rw['notensystem'] == 1)
      gfx_tablecontent('', $fach, '', $row['name'], '', $row['wertung'], '', $row['note'], '', abschnitt_bei_stelle(6-($row['note']/15)*5, 2), '', '<a href="'.$_SERVER['PHP_SELF'].'?modul='.urlencode($modul).'&amp;seite='.urlencode($seite).'&amp;id='.urlencode($id).'&amp;kategorie='.urlencode($kategorie).'&amp;delete='.urlencode($row['id']).'">L&ouml;schen</a>');
  }
  $fach_dropdown = '<select name="fach">';
  $faecher_vorhanden = false;
  $res = db_query("SELECT `name`, `id` FROM `".$mysql_zugangsdaten['praefix']."schule_faecher` WHERE `user` = '".$benutzer['id']."' AND `jahrgang` = '".db_escape($id)."'");
  while ($row = db_fetch($res))
  {
    $fach_dropdown .= '<option value="'.$row['id'].'">'.$row['name'].'</option>';
    $faecher_vorhanden = true;
  }
  $fach_dropdown .= '</select>';
  if ($faecher_vorhanden)
  {
    if ($rw['notensystem'] == 0)
      gfx_tablecontent('', $fach_dropdown, '', '<input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="name">', '', '<input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="wertung">', '', '<input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="note">', '', '<input type="submit" class="button" onmouseover="this.className=\'button_act\';" onmouseout="this.className=\'button\';" value="Eintragen">');
    if ($rw['notensystem'] == 1)
      gfx_tablecontent('', $fach_dropdown, '', '<input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="name">', '', '<input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="wertung">', '', '<input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="note">', '', '<img src="design/spacer.gif" width="115" height="1" alt="">', '', '<input type="submit" class="button" onmouseover="this.className=\'button_act\';" onmouseout="this.className=\'button\';" value="Eintragen">');
  }
  else
  {
    if ($rw['notensystem'] == 0)
      gfx_tablecontent('', 'Bitte zuerst <a href="'.$_SERVER['PHP_SELF'].'?seite='.urlencode($seite).'&modul='.urlencode($modul).'&kategorie=faecher&id='.urlencode($id).'">F&auml;cher anlegen</a>!', '', '', '', '', '', '', '', '');
    if ($rw['notensystem'] == 1)
      gfx_tablecontent('', 'Bitte zuerst <a href="'.$_SERVER['PHP_SELF'].'?seite='.urlencode($seite).'&modul='.urlencode($modul).'&kategorie=faecher&id='.urlencode($id).'">F&auml;cher anlegen</a>!', '', '', '', '', '', '', '', '', '', '');
  }
  gfx_endtable();
}

if ($kategorie == 'auswertung')
{
  gfx_begintable();

  if ($rw['notensystem'] == 0)
    gfx_tablecontent('', '<b>Fach</b>', '', '<b>Wertungsfaktor</b>', '', '<b>Bewertungen</b>', '', '<b>Durchschnitt</b>');
  if ($rw['notensystem'] == 1)
    gfx_tablecontent('', '<b>Fach</b>', '', '<b>Wertungsfaktor</b>', '', '<b>Bewertungen</b>', '', '<b>Durchschnitt</b>', '', '<b>Note</b>');

  $sum_c = 0;
  $sum = 0;
  $sum2 = 0;
  $faecher_vorhanden = false;
  $res = db_query("SELECT `id`, `name`, `wertungsfaktor` FROM `".$mysql_zugangsdaten['praefix']."schule_faecher` WHERE `user` = '".$benutzer['id']."' AND `jahrgang` = '".db_escape($id)."'");
  while ($row = db_fetch($res))
  {
    $faecher_vorhanden = true;
    $sum_note = 0;
    $sum_wertung = 0;
    $c_id = 0;
    $res3 = db_query("SELECT `note`, `wertung` FROM `".$mysql_zugangsdaten['praefix']."schule_noten` WHERE `user` = '".$benutzer['id']."' AND `fach` = '".$row['id']."' AND `jahrgang` = '".db_escape($id)."'");
    while ($row3 = db_fetch($res3))
    {
      $c_id++;
      if (strpos($row3['wertung'], '/') === false)
      {
        $sum_note += $row3['note']*$row3['wertung'];
        $sum_wertung += $row3['wertung'];
      }
      else
      {
        $ary = explode('/', $row3['wertung']);
        if ($ary[1] <> 0)
        {
          $temp_wertung = $ary[0]/$ary[1];
          $sum_note += $row3['note']*$temp_wertung;
          $sum_wertung += $temp_wertung;
        }
      }
    }

    if ($sum_wertung <> 0)
    {
      if ($rw['notensystem'] == 0)
        gfx_tablecontent('', $row['name'], '', $row['wertungsfaktor'], '', $c_id, '', round($sum_note/$sum_wertung, 2));
      if ($rw['notensystem'] == 1)
        gfx_tablecontent('', $row['name'], '', $row['wertungsfaktor'], '', $c_id, '', round($sum_note/$sum_wertung, 2), '', abschnitt_bei_stelle(6-(($sum_note/$sum_wertung)/15)*5, 2));
      $sum2 += $c_id;
      $sum_c += $row['wertungsfaktor'];
      $sum += $row['wertungsfaktor']*($sum_note/$sum_wertung);
    }
    else
    {
      if ($rw['notensystem'] == 0)
        gfx_tablecontent('', $row['name'], '', $row['wertungsfaktor'], '', $c_id, '', '-');
      if ($rw['notensystem'] == 1)
        gfx_tablecontent('', $row['name'], '', $row['wertungsfaktor'], '', $c_id, '', '-', '', '-');
    }
  }

  if ($faecher_vorhanden)
  {
    if ($sum_c == 0)
    {
      $durchschnitt = '-';
      if ($rw['notensystem'] == 1)
        $transform = '-';
    }
    else
    {
      $durchschnitt = round($sum/$sum_c, 2);
      if ($rw['notensystem'] == 1)
        $transform = abschnitt_bei_stelle(6-(($sum/$sum_c)/15)*5, 2);
    }

    if ($rw['notensystem'] == 0)
      gfx_tablecontent('', '<b>Gesamtdurchschnitt</b>', '', '', '', '<b>'.$sum2.'</b>', '', '<b>'.$durchschnitt.'</b>');
    if ($rw['notensystem'] == 1)
      gfx_tablecontent('', '<b>Gesamtdurchschnitt</b>', '', '', '', '<b>'.$sum2.'</b>', '', '<b>'.$durchschnitt.'</b>', '', '<b>'.$transform.'</b>');
  }
  else
  {
    if ($rw['notensystem'] == 0)
      gfx_tablecontent('', 'Bitte zuerst <a href="'.$_SERVER['PHP_SELF'].'?seite='.urlencode($seite).'&modul='.urlencode($modul).'&kategorie=faecher&id='.urlencode($id).'">F&auml;cher anlegen</a>!', '', '', '', '', '', '');
    if ($rw['notensystem'] == 1)
      gfx_tablecontent('', 'Bitte zuerst <a href="'.$_SERVER['PHP_SELF'].'?seite='.urlencode($seite).'&modul='.urlencode($modul).'&kategorie=faecher&id='.urlencode($id).'">F&auml;cher anlegen</a>!', '', '', '', '', '', '', '', '');
  }

  gfx_endtable();
}

if ($kategorie == 'hausaufgaben')
{
  if (isset($sent) && ($sent))
    db_query("INSERT INTO `".$mysql_zugangsdaten['praefix']."schule_hausaufgaben` (`user`, `jahrgang`, `fach`, `text`) VALUES ('".$benutzer['id']."', '".db_escape($id)."', '".db_escape($fach)."', '".db_escape($text)."')");

  if (isset($delete) && ($delete))
  {
    db_query("DELETE FROM `".$mysql_zugangsdaten['praefix']."schule_hausaufgaben` WHERE `user` = '".$benutzer['id']."' AND `id` = '".db_escape($delete)."' AND `jahrgang` = '".db_escape($id)."'");
    if (db_affected_rows() > 0)
      db_query("OPTIMIZE TABLE `".$mysql_zugangsdaten['praefix']."schule_hausaufgaben`");
  }

  $res = db_query("SELECT `id`, `fach`, `text` FROM `".$mysql_zugangsdaten['praefix']."schule_hausaufgaben` WHERE `user` = '".$benutzer['id']."' AND `jahrgang` = '".db_escape($id)."'");

  gfx_begintable();
  gfx_tablecontent('', '<b>Fach</b>', '', '<b>Text</b>', '', '<b>Aktionen</b>');

  while ($row = db_fetch($res))
  {
    $res2 = db_query("SELECT `name` FROM `".$mysql_zugangsdaten['praefix']."schule_faecher` WHERE `id` = '".db_escape($row['fach'])."' AND `user` = '".$benutzer['id']."' AND `jahrgang` = '".db_escape($id)."'");
    $row2 = db_fetch($res2);
    $fach = $row2['name'];

    gfx_tablecontent('', $fach, '', $row['text'], '', '<a href="javascript:abfrage(\''.$_SERVER['PHP_SELF'].'?modul='.urlencode($modul).'&amp;seite='.urlencode($seite).'&amp;id='.urlencode($id).'&amp;kategorie='.urlencode($kategorie).'&amp;delete='.urlencode($row['id']).'\')">L&ouml;schen</a>');
  }
  $faecher_vorhanden = false;
  $res = db_query("SELECT `name`, `id` FROM `".$mysql_zugangsdaten['praefix']."schule_faecher` WHERE `user` = '".$benutzer['id']."' AND `jahrgang` = '".db_escape($id)."'");
  $fach_dropdown = '<select name="fach">';
  while ($row = db_fetch($res))
  {
    $faecher_vorhanden = true;
    $fach_dropdown .= '<option value="'.$row['id'].'">'.$row['name'].'</option>';
  }
  $fach_dropdown .= '</select>';
  if ($faecher_vorhanden)
    gfx_tablecontent('', $fach_dropdown, '', '<input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="text">', '', '<input type="submit" class="button" onmouseover="this.className=\'button_act\';" onmouseout="this.className=\'button\';" value="Eintragen">');
  else
    gfx_tablecontent('', 'Bitte zuerst <a href="'.$_SERVER['PHP_SELF'].'?seite='.urlencode($seite).'&modul='.urlencode($modul).'&kategorie=faecher&id='.urlencode($id).'">F&auml;cher anlegen</a>!', '', '', '', '');
  gfx_endtable();
}

if ($kategorie == 'striche')
{
  if (isset($plus) && ($plus <> '') && ($what == 'pos'))
    db_query("UPDATE `".$mysql_zugangsdaten['praefix']."schule_faecher` SET `positiv` = `positiv` + '".db_escape($amount)."' WHERE `id` = '".db_escape($plus)."' AND `user` = '".$benutzer['id']."' AND `jahrgang` = '".db_escape($id)."'");
  if (isset($plus) && ($plus <> '') && ($what == 'neg'))
    db_query("UPDATE `".$mysql_zugangsdaten['praefix']."schule_faecher` SET `negativ` = `negativ` + '".db_escape($amount)."' WHERE `id` = '".db_escape($plus)."' AND `user` = '".$benutzer['id']."' AND `jahrgang` = '".db_escape($id)."'");

  $faecher_vorhanden = false;
  $res = db_query("SELECT `name`, `positiv`, `negativ`, `id` FROM `".$mysql_zugangsdaten['praefix']."schule_faecher` WHERE `user` = '".$benutzer['id']."' AND `jahrgang` = '".db_escape($id)."'");
  gfx_begintable();
  gfx_tablecontent('', '<b>Fach</b>', '', '<b>Positiv</b>', '', '', '', '', '', '<b>Negativ</b>', '', '', '', '');
  while ($row = db_fetch($res))
  {
    $faecher_vorhanden = true;
    gfx_tablecontent('', $row['name'], '', round($row['positiv'], 2), '', '<a href="'.$_SERVER['PHP_SELF'].'?modul='.urlencode($modul).'&amp;seite='.urlencode($seite).'&amp;id='.urlencode($id).'&amp;kategorie='.urlencode($kategorie).'&amp;plus='.urlencode($row['id']).'&amp;amount=1&amp;what=pos" >+1.00</a> <a href="'.$_SERVER['PHP_SELF'].'?modul='.urlencode($modul).'&amp;seite='.urlencode($seite).'&amp;id='.urlencode($id).'&amp;kategorie='.urlencode($kategorie).'&amp;plus='.urlencode($row['id']).'&amp;amount=0.5&amp;what=pos" >+0.50</a> <a href="'.$_SERVER['PHP_SELF'].'?modul='.urlencode($modul).'&amp;seite='.urlencode($seite).'&amp;id='.urlencode($id).'&amp;kategorie='.urlencode($kategorie).'&amp;plus='.urlencode($row['id']).'&amp;amount=0.25&amp;what=pos" >+0.25</a>',
                                                                      '', '<a href="'.$_SERVER['PHP_SELF'].'?modul='.urlencode($modul).'&amp;seite='.urlencode($seite).'&amp;id='.urlencode($id).'&amp;kategorie='.urlencode($kategorie).'&amp;plus='.urlencode($row['id']).'&amp;amount=-1&amp;what=pos">-1.00</a> <a href="'.$_SERVER['PHP_SELF'].'?modul='.urlencode($modul).'&amp;seite='.urlencode($seite).'&amp;id='.urlencode($id).'&amp;kategorie='.urlencode($kategorie).'&amp;plus='.urlencode($row['id']).'&amp;amount=-0.5&amp;what=pos">-0.50</a> <a href="'.$_SERVER['PHP_SELF'].'?modul='.urlencode($modul).'&amp;seite='.urlencode($seite).'&amp;id='.urlencode($id).'&amp;kategorie='.urlencode($kategorie).'&amp;plus='.urlencode($row['id']).'&amp;amount=-0.25&amp;what=pos">-0.25</a>',
                                       '', round($row['negativ'], 2), '', '<a href="'.$_SERVER['PHP_SELF'].'?modul='.urlencode($modul).'&amp;seite='.urlencode($seite).'&amp;id='.urlencode($id).'&amp;kategorie='.urlencode($kategorie).'&amp;plus='.urlencode($row['id']).'&amp;amount=1&amp;what=neg" >+1.00</a> <a href="'.$_SERVER['PHP_SELF'].'?modul='.urlencode($modul).'&amp;seite='.urlencode($seite).'&amp;id='.urlencode($id).'&amp;kategorie='.urlencode($kategorie).'&amp;plus='.urlencode($row['id']).'&amp;amount=0.5&amp;what=neg" >+0.50</a> <a href="'.$_SERVER['PHP_SELF'].'?modul='.urlencode($modul).'&amp;seite='.urlencode($seite).'&amp;id='.urlencode($id).'&amp;kategorie='.urlencode($kategorie).'&amp;plus='.urlencode($row['id']).'&amp;amount=0.25&amp;what=neg" >+0.25</a>',
                                                                      '', '<a href="'.$_SERVER['PHP_SELF'].'?modul='.urlencode($modul).'&amp;seite='.urlencode($seite).'&amp;id='.urlencode($id).'&amp;kategorie='.urlencode($kategorie).'&amp;plus='.urlencode($row['id']).'&amp;amount=-1&amp;what=neg">-1.00</a> <a href="'.$_SERVER['PHP_SELF'].'?modul='.urlencode($modul).'&amp;seite='.urlencode($seite).'&amp;id='.urlencode($id).'&amp;kategorie='.urlencode($kategorie).'&amp;plus='.urlencode($row['id']).'&amp;amount=-0.5&amp;what=neg">-0.50</a> <a href="'.$_SERVER['PHP_SELF'].'?modul='.urlencode($modul).'&amp;seite='.urlencode($seite).'&amp;id='.urlencode($id).'&amp;kategorie='.urlencode($kategorie).'&amp;plus='.urlencode($row['id']).'&amp;amount=-0.25&amp;what=neg">-0.25</a>');
  }

  if (!$faecher_vorhanden)
  {
    gfx_tablecontent('', 'Bitte zuerst <a href="'.$_SERVER['PHP_SELF'].'?seite='.urlencode($seite).'&modul='.urlencode($modul).'&kategorie=faecher&id='.urlencode($id).'">F&auml;cher anlegen</a>!', '', '', '', '', '', '', '', '', '', '', '', '');
  }

  gfx_endtable();
}

echo '</form>';

echo $footer;

?>
