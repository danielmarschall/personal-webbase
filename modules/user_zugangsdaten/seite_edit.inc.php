<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne IronBASE ausgef&uuml;hrt werden.');

if (($aktion == 'new') || ($aktion == 'edit'))
{

$zugangsdaten_status[1] = 'Funktioniert';
$zugangsdaten_status[2] = 'Abgemeldet';
$zugangsdaten_status[3] = 'Gesperrt';
$zugangsdaten_status[4] = 'Unbekannt';

echo str_replace('<body', '<body onload="self.focus();document.getElementById(\'name\').focus();"', $header);

  if ($aktion == 'new') echo '<h1>Neue Zugangsinformation</h1>';
  if ($aktion == 'edit') echo '<h1>Zugangsinformation bearbeiten</h1>';

  if ($aktion == 'edit')
  {
    $res = db_query("SELECT name, folder, text, url, status FROM ".$mysql_zugangsdaten['praefix']."zugangsdaten WHERE id = '".db_escape($id)."' AND user = '".$benutzer['id']."'");
    if (db_num($res) == 0)
      die($header.'Auf diesen Datensatz kann nicht zugegriffen werden. Entweder ist er nicht mehr verf&uuml;gbar, oder die Zugriffsberechtigungen sind falsch.'.$footer);
    $row = db_fetch($res);

    $name = (isset($row['name'])) ? $row['name'] : '';
    $url = (isset($row['url'])) ? $row['url'] : '';
    $text = (isset($row['text'])) ? $row['text'] : '';
    $status = (isset($row['status'])) ? $row['status'] : '';
    $auszuwaehlen = (isset($row['folder'])) ? $row['folder'] : '';
  }
  else
  {
    $name = '';
    $url = '';
    $text = '';
    $status = '';
    $auszuwaehlen = (isset($folder)) ? $folder : 0;
  }

?><script language="JavaScript" type="text/javascript">
<!--

function subm_form(act)
{
  if (act == 0)
  {
    document.forms["mainform"].target = '_self';
    document.forms["mainform"].elements["seite"].value = 'kraftsetzung';
  }
  if (act == 1)
  {
    document.forms["mainform"].target = '_blank';
    document.forms["mainform"].elements["seite"].value = 'test_url';
  }
  document.forms.mainform.submit();
}

// -->
</script><?php

echo '<form method="POST" name="mainform" action="'.$_SERVER['PHP_SELF'].'">
<input type="hidden" name="seite" value="">
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
  <td colspan="2"><br><b>Detailierte Informationen</b><br><br></td>
</tr>
<tr>
  <td valign="top">Status:<img src="design/spacer.gif" height="1" width="35" alt=""></td>
  <td valign="top"><select name="status">';

  for ($i=1; $zugangsdaten_status[$i] != ''; $i++)
  {
    if ($status == $i)
	  $x = 'selected';
	else
	  $x = '';
	echo '<option value="'.$i.'"'.$x.'>'.$zugangsdaten_status[$i].'</option>';
  }

  echo '</select></td>
</tr>
<tr>
  <td valign="top">Webseite:<img src="design/spacer.gif" height="1" width="35" alt=""></td>
  <td valign="top"><input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="url" value="'.$url.'" size="50"> [<a href="javascript:subm_form(1);">Besuchen</a>]</td>
</tr>
<tr>
  <td colspan="2"><br><b>Inhalt der Zugangsinformation</b><br><br></td>
</tr>
<tr>
  <td valign="top">Text:<img src="design/spacer.gif" height="1" width="35" alt=""></td>
  <td valign="top"><textarea name="text" cols="40" rows="8">'.$text.'</textarea></td>
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
<a href="javascript:subm_form(0);">';

if ($aktion == 'new') echo 'Eintragung hinzuf&uuml;gen';
if ($aktion == 'edit') echo 'Eintragung aktualisieren';

echo '</a>&nbsp;|&nbsp;<a href="'.$_SERVER['PHP_SELF'].'?seite=inhalt&amp;modul='.$modul.'">Zur&uuml;ck</a>

</form>';

echo $footer;
}

?>