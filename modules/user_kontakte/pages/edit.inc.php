<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

if (($aktion == 'new') || ($aktion == 'edit'))
{
  echo str_replace('<body', '<body onload="self.focus();document.getElementById(\'name\').focus();"', $header);

  // Länderliste von Lexas abrufen
  $std_land = 'deutschland';

  $k = my_get_contents('http://www.lexas.net/laender/a-z.htm');
  if ($k != '')
  {
    preg_match_all('/<select(.+?)<\/select>/is', $k, $m);

    preg_match_all('/<option value="http:\/\/www.lexas.net\/laender\/(.+?)\/(.+?)\/(.+?)" >(.+?)<\/option>/im', $m[0][0], $n);
    $laenderliste = '<select name="land">';
    for ($i = 0; isset($n[1][$i]); $i++)
    {
      if ($n[2][$i] == 'deutschland') $s = ' selected'; else $s = '';
      $laenderliste .= '<option value="'.$n[2][$i].'"'.$s.'>'.my_htmlentities($n[4][$i]).'</option>';
    }
    $laenderliste .= '</select>';
  }
  else
  {
    echo 'Fehler';
  }
  // Beendet

  if ($aktion == 'new') echo '<h1>Neuer Kontakt</h1>';
  if ($aktion == 'edit') echo '<h1>Kontakt bearbeiten</h1>';

  if ($aktion == 'edit')
  {
    $res = db_query("SELECT * FROM `".$mysql_zugangsdaten['praefix']."kontakte` WHERE `id` = '".db_escape($id)."' AND `user` = '".$benutzer['id']."'");
    if (db_num($res) == 0)
      die($header.'Auf diesen Datensatz kann nicht zugegriffen werden. Entweder ist er nicht mehr verf&uuml;gbar, oder die Zugriffsberechtigungen sind falsch.'.$footer);
    $row = db_fetch($res);

    $name = (isset($row['name'])) ? $row['name'] : '';
    $strasse = (isset($row['strasse'])) ? $row['strasse'] : '';
    $plz = (isset($row['plz'])) ? $row['plz'] : '';
    $ort = (isset($row['ort'])) ? $row['ort'] : '';
    $land = (isset($row['land'])) ? $row['land'] : '';
    $telefon = (isset($row['telefon'])) ? $row['telefon'] : '';
      $art = explode('-', $telefon);
      $telefon1 = $art[0];
      $telefon2 = $art[1];
    $mobil = (isset($row['mobil'])) ? $row['mobil'] : '';
      $art = explode('-', $mobil);
      $mobil1 = $art[0];
      $mobil2 = $art[1];
    $fax = (isset($row['fax'])) ? $row['fax'] : '';
      $art = explode('-', $fax);
      $fax1 = $art[0];
      $fax2 = $art[1];
    $email = (isset($row['email'])) ? $row['email'] : '';
    $icq = (isset($row['icq'])) ? $row['icq'] : '';
    $yahoo = (isset($row['yahoo'])) ? $row['yahoo'] : '';
    $msn = (isset($row['msn'])) ? $row['msn'] : '';
    $aim = (isset($row['aim'])) ? $row['aim'] : '';
    $skype = (isset($row['skype'])) ? $row['skype'] : '';
    $kommentare = (isset($row['kommentare'])) ? $row['kommentare'] : '';
    $auszuwaehlen = (isset($row['folder'])) ? $row['folder'] : '';
  }
  else
  {
	$name = '';
	$strasse = '';
	$plz = '';
	$ort = '';
	$land = '';
	$telefon1 = '';
	$telefon2 = '';
	$fax1 = '';
	$fax2 = '';
	$mobil1 = '';
	$mobil2 = '';
    $email = '';
    $icq = '';
    $yahoo = '';
    $msn = '';
    $aim = '';
    $skype = '';
    $kommentare = '';
	$auszuwaehlen = (isset($folder)) ? $folder : 0;
  }

echo '<form method="POST" name="mainform" action="'.$_SERVER['PHP_SELF'].'">
<input type="hidden" name="seite" value="kraftsetzung">
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
  <td valign="top">In Ordner:<img src="design/spacer.gif" height="1" width="35" alt=""></td>
  <td valign="top">';

  gfx_zeichneordnerbox($modul, 'ORDER BY `name`', 0, 0, $auszuwaehlen);

  echo '</td>
</tr>
<tr>
  <td colspan="2"><br><b>Detailierte Informationen</b><br><br></td>
</tr>
<tr>
  <td valign="top">Stra&szlig;e:<img src="design/spacer.gif" height="1" width="35" alt=""></td>
  <td valign="top"><input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="strasse" value="'.$strasse.'" size="54"></td>
</tr>
<tr>
  <td valign="top">Wohnort:<img src="design/spacer.gif" height="1" width="35" alt=""></td>
  <td valign="top"><input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="plz" value="'.$plz.'" size="15"> <input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="ort" value="'.$ort.'" size="35"></td>
</tr>
<tr>
  <td valign="top">Land:<img src="design/spacer.gif" height="1" width="35" alt=""></td>
  <td valign="top">'.$laenderliste.'</td>
</tr>
<tr>
  <td colspan="2"><br></td>
</tr>
<tr>
  <td valign="top">Telefon:<img src="design/spacer.gif" height="1" width="35" alt=""></td>
  <td valign="top"><input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="telefon1" value="'.$telefon1.'" size="25"> / <input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="telefon2" value="'.$telefon2.'" size="25"></td>
</tr>
<tr>
  <td valign="top">Telefax:<img src="design/spacer.gif" height="1" width="35" alt=""></td>
  <td valign="top"><input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="fax1" value="'.$fax1.'" size="25"> / <input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="fax2" value="'.$fax2.'" size="25"></td>
</tr>
<tr>
  <td valign="top">Mobil:<img src="design/spacer.gif" height="1" width="35" alt=""></td>
  <td valign="top"><input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="mobil1" value="'.$mobil1.'" size="20"> / <input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="mobil2" value="'.$mobil2.'" size="30"></td>
</tr>
<tr>
  <td colspan="2"><br></td>
</tr>
<tr>
  <td valign="top">E-Mail-Adresse:<img src="design/spacer.gif" height="1" width="35" alt=""></td>
  <td valign="top"><input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="email" value="'.$email.'" size="50"></td>
</tr>
<tr>
  <td valign="top">ICQ-Nummer:<img src="design/spacer.gif" height="1" width="35" alt=""></td>
  <td valign="top"><input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="icq" value="'.$icq.'" size="50"></td>
</tr>
<tr>
  <td valign="top">MSN-Messenger:<img src="design/spacer.gif" height="1" width="35" alt=""></td>
  <td valign="top"><input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="msn" value="'.$msn.'" size="50"></td>
</tr>
<tr>
  <td valign="top">AIM-Messenger:<img src="design/spacer.gif" height="1" width="35" alt=""></td>
  <td valign="top"><input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="aim" value="'.$aim.'" size="50"></td>
</tr>
<tr>
  <td valign="top">Yahoo-Messenger:<img src="design/spacer.gif" height="1" width="35" alt=""></td>
  <td valign="top"><input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="yahoo" value="'.$yahoo.'" size="50"></td>
</tr>
<tr>
  <td valign="top">Skype:<img src="design/spacer.gif" height="1" width="35" alt=""></td>
  <td valign="top"><input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="skype" value="'.$skype.'" size="50"></td>
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
    <option value="A"'; if ($danach == 'A') echo ' selected'; echo '>Zur&uuml;ck zum Hauptmen&uuml;</option>
    <option value="B"'; if ($danach == 'B') echo ' selected'; echo '>Neuer Eintrag in Kategorie</option>
    <option value="C"'; if ($danach == 'C') echo ' selected'; echo '>Neuer Eintrag im Ordner</option>
  </select></td>
</tr>
</table><br>
<a href="javascript:document.mainform.submit();">';

if ($aktion == 'new') echo 'Eintragung hinzuf&uuml;gen';
if ($aktion == 'edit') echo 'Eintragung aktualisieren';

echo '</a>&nbsp;|&nbsp;<a href="'.$_SERVER['PHP_SELF'].'?seite=inhalt&amp;modul='.urlencode($modul).'">Zur&uuml;ck</a>

</form>';

  echo $footer;

}

?>
