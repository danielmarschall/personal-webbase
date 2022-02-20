<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

if (($aktion == 'new') || ($aktion == 'edit'))
{
  echo str_replace('<body', '<body onload="self.focus();document.getElementById(\'name\').focus();"', $header);

  if ($aktion == 'new') echo '<h1>Neue HTML-Seite</h1>';
  if ($aktion == 'edit') echo '<h1>HTML-Seite bearbeiten</h1>';

  if ($aktion == 'edit')
  {
    $res = db_query("SELECT * FROM `".$mysql_zugangsdaten['praefix']."html` WHERE `id` = '".db_escape($id)."' AND `user` = '".$benutzer['id']."'");
    if (db_num($res) == 0)
      die($header.'Auf diesen Datensatz kann nicht zugegriffen werden. Entweder ist er nicht mehr verf&uuml;gbar, oder die Zugriffsberechtigungen sind falsch.'.$footer);
    $row = db_fetch($res);

    $auszuwaehlen = (isset($row['folder'])) ? $row['folder'] : '';
    $name = (isset($row['name'])) ? $row['name'] : '';
    $hcode = (isset($row['hcode'])) ? $row['hcode'] : '';
  }
  else
  {
    $auszuwaehlen = (isset($folder)) ? $folder : 0;
    $name = '';
    $hcode = '';
  }

  if (isset($vorlage) && ($vorlage != ''))
  {
    // Achtung! Ein Hacker könnte durch ../ die MySQL-Zugangsdaten statt einer Vorlage auslesen!
	if (strpos($vorlage, '..'))
      die($header.'<b>Fehler</b><br><br>Es ist eine Schutzverletzung aufgetreten!'.$footer);

    $hcode = '';

    $handle = @fopen('modules/'.$modul.'/vorlagen/'.$vorlage, 'r');
	if ($handle)
	{
	  while (!@feof($handle))
	    $hcode .= @fgets($handle, 4096);
    }
	@fclose($handle);
  }

echo '<script language="JavaScript" type="text/javascript">
<!--

function subm_form(act)
{
  if (act == 0)
  {
    document.forms["mainform"].target = \'\';
    document.forms["mainform"].elements["seite"].value = \'kraftsetzung\';
  }
  if (act == 1)
  {
    document.forms["mainform"].target = \'_blank\';
    document.forms["mainform"].elements["seite"].value = \'checksite\';
  }
  document.forms.mainform.submit();
}

// -->
</script>

<form method="POST" name="mainform" action="'.$_SERVER['PHP_SELF'].'">
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

  gfx_zeichneordnerbox($modul, 'ORDER BY id', 0, 0, $auszuwaehlen);

  echo '</td>
</tr>
<tr>
  <td colspan="2"><br><b>HTML-Daten</b><br><br></td>
</tr>
<tr>
  <td valign="top">HTML-Code:<img src="design/spacer.gif" height="1" width="35" alt=""></td>
  <td valign="top" width="100%">
  <table width="100%"><tr><td rowspan="8" style="vertical-align:top;width:100%">Verwenden Sie eine vordefinierte HTML-Seite wenn Sie z.B. ein automatisches Login-Formular erstellen, jedoch kein Personal WebBase-Modul schreiben m&ouml;chten.<br><br>
  <textarea style="width:100%; overflow:auto;" wrap="virtual" name="hcode" rows="15" cols="50">'.$hcode.'</textarea><br><br>
  Eine Vorlage kann Ihnen die Arbeit erleichtern. W&auml;hlen Sie eine Vorlage, wenn Sie dies w&uuml;nschen.
  <ul>';

function liste_vorlagen()
{
  global $modul;
  $ary = array();
  $i = 0;
  $v = 'modules/'.$modul.'/vorlagen/';
  $verz=opendir($v);

  while ($file = readdir($verz))
  {
    if (($file != '.') && ($file != '..')  && ($file != 'index.html') && (is_file($v.$file)))
    {
      $i++;
      $ary[$i] = $file;
    }
  }

  closedir($verz);
  sort($ary);

  return $ary;
}

$vorlagen = liste_vorlagen();

foreach ($vorlagen AS $m1 => $m2)
{
  if (!isset($id)) $id = 0;
  echo '<li><a href="'.$_SERVER['PHP_SELF'].'?seite='.$seite.'&amp;modul='.$modul.'&amp;aktion='.$aktion.'&amp;id='.$id.'&amp;vorlage='.$m2.'">'.$m2.'</a></li>';
}

unset($m1);
unset($m2);

if (!isset($danach)) $danach = 'A';

  echo '</ul>Bitte beachten Sie, dass beim &Ouml;ffnen einer Vorlage die aktuellen &Auml;nderungen &uuml;berschrieben werden.<br><br>
  <a href="javascript:subm_form(1);">Seite testen</a></td></tr></table>
  </td>
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
