<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

if (($aktion == 'new') || ($aktion == 'edit'))
{
  echo str_replace('<body', '<body onload="self.focus();document.getElementById(\'name\').focus();"', $header);

  if ($aktion == 'new') echo '<h1>Neuer Termin</h1>';
  if ($aktion == 'edit') echo '<h1>Termin bearbeiten</h1>';

  if ($aktion == 'edit')
  {
    $res = db_query("SELECT * FROM ".$mysql_zugangsdaten['praefix']."kalender WHERE id = '".db_escape($id)."' AND user = '".$benutzer['id']."'");
    if (db_num($res) == 0)
      die($header.'Auf diesen Datensatz kann nicht zugegriffen werden. Entweder ist er nicht mehr verf&uuml;gbar, oder die Zugriffsberechtigungen sind falsch.'.$footer);
    $row = db_fetch($res);

    $name = (isset($row['name'])) ? $row['name'] : '';
    $start_date = (isset($row['start_date'])) ? $row['start_date'] : '0000-00-00';
	  $ary1 = explode('-', $start_date);
      $datum1 = $ary1[2];
	  $datum2 = $ary1[1];
	  $datum3 = $ary1[0];
    $start_time = (isset($row['start_time'])) ? $row['start_time'] : '00:00:00';
	  $ary2 = explode(':', $start_time);
	  $zeit1 = $ary2[0];
	  $zeit2 = $ary2[1];
    $kommentare = (isset($row['kommentare'])) ? $row['kommentare'] : '';
  }
  else
  {
	$name = '';
	$timestamp = '';
    $kommentare = '';
    $zeit1 = '';
    $zeit2 = '';
    $datum1 = '';
    $datum2 = date("m");
    $datum3 = date("Y");
  }

echo '<form method="POST" name="mainform" action="'.$_SERVER['PHP_SELF'].'">
<input type="hidden" name="seite" value="kraftsetzung">
<input type="hidden" name="herkunft" value="'.$herkunft.'">
<input type="hidden" name="aktion" value="'.$aktion.'">
<input type="hidden" name="modul" value="'.$modul.'">';

if ($aktion == 'edit')
  echo '<input type="hidden" name="id" value="'.$id.'">';

if (!isset($danach)) $danach = 'A';

echo '<table cellspacing="0" cellpadding="0" border="0">
<tr>
  <td colspan="2"><b>Allgemeine Informationen</b><br><br></td>
</tr>
<tr>
  <td valign="top">Name:<img src="design/spacer.gif" height="1" width="35" alt=""></td>
  <td valign="top"><input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="name" id="name" value="'.$name.'" size="50"></td>
</tr>
<tr>
  <td colspan="2"><br><b>Detailierte Informationen</b><br><br></td>
</tr>
<tr>
  <td valign="top">Datum:<img src="design/spacer.gif" height="1" width="35" alt=""></td>
  <td valign="top"><input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="datum1" value="'.$datum1.'" size="3"> . <input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="datum2" value="'.$datum2.'" size="3"> . <input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="datum3" value="'.$datum3.'" size="6"></td>
</tr>
<tr>
  <td valign="top"><br>Uhrzeit:<img src="design/spacer.gif" height="1" width="35" alt=""></td>
  <td valign="top"><br><input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="zeit1" value="'.$zeit1.'" size="3"> : <input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="zeit2" value="'.$zeit2.'" size="3"></td>
</tr>
<tr>
  <td colspan="2"><br></td>
</tr>
<tr>
  <td valign="top">Kommentare:<img src="design/spacer.gif" height="1" width="35" alt=""></td>
  <td valign="top"><textarea name="kommentare" cols="40" rows="8">'.$kommentare.'</textarea></td>
</tr>
<tr>
  <td colspan="2"><br><b>Nach Speicherung</b><br><br></td>
</tr>
<tr>
  <td valign="top">Aktion: </td>
  <td><select name="danach">
    <option value="A"'; if ($danach == 'A') echo ' selected'; echo '>Zur&uuml;ck zur Wochenauflistung</option>
    <option value="B"'; if ($danach == 'B') echo ' selected'; echo '>Zur&uuml;ck zur Terminauflistung</option>
    <option value="C"'; if ($danach == 'C') echo ' selected'; echo '>Neuer Eintrag</option>
  </select></td>
</tr>
</table><br>
<a href="javascript:document.mainform.submit();">';

if ($aktion == 'new') echo 'Eintragung hinzuf&uuml;gen';
if ($aktion == 'edit') echo 'Eintragung aktualisieren';

echo '</a>&nbsp;|&nbsp;<a href="'.$_SERVER['PHP_SELF'].'?seite='.$herkunft.'&amp;modul='.$modul.'">Zur&uuml;ck</a>

</form>';

  echo $footer;
}

?>
