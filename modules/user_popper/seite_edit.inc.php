<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

if (($aktion == 'new') || ($aktion == 'edit'))
{
  echo str_replace('<body', '<body onload="self.focus();document.getElementById(\'name\').focus();"', $header);

  if ($aktion == 'new') echo '<h1>Neues Postfach</h1>';
  if ($aktion == 'edit') echo '<h1>Postfach bearbeiten</h1>';

  if ($aktion == 'edit')
  {
    $res = db_query("SELECT `name`, `folder`, `server`, `username`, `passwort`, `personenname`, `replyaddr` FROM `".$mysql_zugangsdaten['praefix']."popper_konten` WHERE `id` = '".db_escape($id)."' AND `user` = '".$benutzer['id']."'");
    if (db_num($res) == 0)
      die($header.'Auf diesen Datensatz kann nicht zugegriffen werden. Entweder ist er nicht mehr verf&uuml;gbar, oder die Zugriffsberechtigungen sind falsch.'.$footer);
    $row = db_fetch($res);

    $name = (isset($row['name'])) ? $row['name'] : '';
    $auszuwaehlen = (isset($row['folder'])) ? $row['folder'] : '';
    $mserver = (isset($row['server'])) ? $row['server'] : '';
    $musername = (isset($row['username'])) ? $row['username'] : '';
    $mpasswort = (isset($row['passwort'])) ? $row['passwort'] : '';
    $personenname = (isset($row['personenname'])) ? $row['personenname'] : '';
    $replyaddr = (isset($row['replyaddr'])) ? $row['replyaddr'] : '';
  }
  else
  {
	$name = '';
    $auszuwaehlen = (isset($folder)) ? $folder : 0;
    $mserver = '';
    $musername = '';
    $mpasswort = '';
    $personenname = '';
    $replyaddr = '';
  }

echo '<form method="POST" name="mainform" action="'.$_SERVER['PHP_SELF'].'">
<input type="hidden" name="seite" value="kraftsetzung">
<input type="hidden" name="aktion" value="'.$aktion.'">
<input type="hidden" name="modul" value="'.$modul.'">';

if ($aktion == 'edit')
  echo '<input type="hidden" name="id" value="'.$id.'">';

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

  if (!isset($danach)) $danach = 'A';

  echo '</td>
</tr>
<tr>
  <td colspan="2"><br><b>POP3-Informationen</b><br><br></td>
</tr>
<tr>
  <td valign="top">Server:<img src="design/spacer.gif" height="1" width="35" alt=""></td>
  <td valign="top"><input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="mserver" value="'.$mserver.'" size="50"></td>
</tr>
<tr>
  <td valign="top">Benutzername:<img src="design/spacer.gif" height="1" width="35" alt=""></td>
  <td valign="top"><input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="musername" value="'.$musername.'" size="50"></td>
</tr>
<tr>
  <td valign="top">Passwort:<img src="design/spacer.gif" height="1" width="35" alt=""></td>
  <td valign="top"><input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="mpasswort" value="'.$mpasswort.'" size="50"></td>
</tr>
<tr>
  <td colspan="2"><br><b>Weitere Informationen</b><br><br></td>
</tr>
<tr>
  <td valign="top">Name der Person:<img src="design/spacer.gif" height="1" width="35" alt=""></td>
  <td valign="top"><input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="personenname" value="'.$personenname.'" size="50"></td>
</tr>
<tr>
  <td valign="top">Antwortadresse:<img src="design/spacer.gif" height="1" width="35" alt=""></td>
  <td valign="top"><input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="replyaddr" value="'.$replyaddr.'" size="50"></td>
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
