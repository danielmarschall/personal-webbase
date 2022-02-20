<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne IronBASE ausgef&uuml;hrt werden.');

if (($aktion == 'new') || ($aktion == 'edit'))
{
  echo str_replace('<body', '<body onload="self.focus();document.getElementById(\'name\').focus();"', $header);

  if ($aktion == 'new') echo '<h1>Neuer Link</h1>';
  if ($aktion == 'edit') echo '<h1>Link bearbeiten</h1>';

  if ($aktion == 'edit')
  {
    $res = db_query("SELECT `name`, `url`, `folder`, `update_text_begin`, `update_text_end`, `update_checkurl`, `update_enabled`, `update_lastchecked` FROM `".$mysql_zugangsdaten['praefix']."links` WHERE `id` = '".db_escape($id)."' AND `user` = '".$benutzer['id']."'");
    if (db_num($res) == 0)
      die($header.'Auf diesen Datensatz kann nicht zugegriffen werden. Entweder ist er nicht mehr verf&uuml;gbar, oder die Zugriffsberechtigungen sind falsch.'.$footer);
    $row = db_fetch($res);

    $name = (isset($row['name'])) ? $row['name'] : '';
    $url = (isset($row['url'])) ? $row['url'] : '';
    $auszuwaehlen = (isset($row['folder'])) ? $row['folder'] : '';
    $update_text_begin = (isset($row['update_text_begin'])) ? $row['update_text_begin'] : '';
    $update_text_end = (isset($row['update_text_end'])) ? $row['update_text_end'] : '';
    $update_checkurl = (isset($row['update_checkurl'])) ? $row['update_checkurl'] : '';
    $update_enabled = (isset($row['update_enabled'])) ? $row['update_enabled'] : '';
    $update_lastchecked = (isset($row['update_lastchecked'])) ? $row['update_lastchecked'] : '';
  }
  else
  {
	$name = '';
	$url = '';
    $update_text_begin = '';
    $update_text_end = '';
    $update_checkurl = '';
    $update_enabled = '0';
    $update_lastchecked = '0000-00-00 00:00:00';

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
    document.forms["mainform"].elements["seite"].value = 'checkparsing';
  }
  if (act == 2)
  {
    document.forms["mainform"].target = '_blank';
    document.forms["mainform"].elements["seite"].value = 'test_url';
  }
  if (act == 3)
  {
    document.forms["mainform"].target = '_blank';
    document.forms["mainform"].elements["seite"].value = 'test_checkurl';
  }
  document.forms.mainform.submit();
}

// -->
</script><?php

echo '<form method="POST" action="'.$_SERVER['PHP_SELF'].'" name="mainform" id="mainform">
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
  <td valign="top">Adresse:<img src="design/spacer.gif" height="1" width="35" alt=""></td>
  <td valign="top"><input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="url" value="'.$url.'" size="50"> [<a href="javascript:subm_form(2);">Test</a>]</td>
</tr>
<tr>
  <td valign="top">In Ordner:<img src="design/spacer.gif" height="1" width="35" alt=""></td>
  <td valign="top">';

  gfx_zeichneordnerbox($modul, 'ORDER BY `name`', 0, 0, $auszuwaehlen);

  if ($update_enabled == '1') $zus = ' checked'; else $zus = '';

  if (!isset($danach)) $danach = 'A';

  echo '</td>
</tr>
<tr>
  <td colspan="2"><br>Information: Wenn Sie keinen Linknamen angeben, wird IronBASE versuchen,
den Titel der Webseite automatisch herauszufinden.<br><br><b>Update-Service</b><br><br></td>
</tr>
<tr>
  <td valign="top">Status:<img src="design/spacer.gif" height="1" width="35" alt=""></td>
  <td valign="top"><input type="checkbox" name="update_enabled" value="1"'.$zus.'> Aktiviert</td>
</tr>
<tr>
  <td valign="top">Letzte Pr&uuml;fung:<img src="design/spacer.gif" height="1" width="35" alt=""></td>
  <td valign="top">'.de_convertmysqldatetime($update_lastchecked).'</td>
</tr>

<tr>
  <td valign="top">Update-Interval:<img src="design/spacer.gif" height="1" width="35" alt=""></td>
  <td valign="top">'.$konfiguration[$modul]['update_checkinterval_min'].' Minuten (von dem Administrator festgelegt)</td>
</tr>
<tr>
  <td valign="top">Pr&uuml;fungsinterval bei kaputten Links:<img src="design/spacer.gif" height="1" width="35" alt=""></td>
  <td valign="top">'.$konfiguration[$modul]['kaputt_checkinterval_min'].' Minuten (von dem Administrator festgelegt)</td>
</tr>
<tr>
  <td valign="top">Update-URL:<img src="design/spacer.gif" height="1" width="35" alt=""></td>
  <td valign="top"><input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="update_checkurl" value="'.$update_checkurl.'" size="50"> [<a href="javascript:subm_form(3);">Test</a>]</td>
</tr>
<tr>
  <td valign="top">Textbeginn:<img src="design/spacer.gif" height="1" width="35" alt=""></td>
  <td valign="top"><textarea name="update_text_begin" cols="40" rows="8">'.$update_text_begin.'</textarea></td>
</tr>
<tr>
  <td valign="top">Textende:<img src="design/spacer.gif" height="1" width="35" alt=""></td>
  <td valign="top"><textarea name="update_text_end" cols="40" rows="8">'.$update_text_end.'</textarea><br>
[<a href="javascript:subm_form(1);">Parsing testen</a>]</td>
</tr>
<tr>
  <td colspan="2"><br>Information: Bei Webseiten mit dynamischen Elementen (wie z.B. ein sich st&auml;ndig aktualisierender Counter oder ein Zufallsbild) m&uuml;ssen Sie relevante Ver&auml;nderungsmuster (wie z.B. ein Aktualisierungsdatum der Webseite) parsen. Bitte bedenken Sie, dass Sie f&uuml;r die Update-Jobs, die Sie in Auftrag geben, selbst verantwortlich sind. Absichtlich herbeigef&uuml;hrte, extreme Serverauslastungen k&ouml;nnen die K&uuml;ndigung Ihres IronBASE-Accounts bewirken.</td>
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