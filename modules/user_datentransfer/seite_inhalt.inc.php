<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

  echo $header;

if ($modulueberschrift == '') $modulueberschrift = $modul;
echo '<h1>'.my_htmlentities($modulueberschrift).'</h1>';
    echo '<b>Datensicherung herunterladen</b><br><br>

Hier k&ouml;nnen Sie eine Datensicherung durchf&uuml;hren, um beispielsweise auf einen anderen Personal WebBase-Server umzuziehen.<br><br>

<input type="button" class="button" onmouseover="this.className=\'button_act\';" onmouseout="this.className=\'button\';" onclick="document.location.href=\''.$_SERVER['PHP_SELF'].'?modul='.$modul.'&amp;seite=export\'" value="Datensicherung"><br><br>
<b>Datensicherung importieren</b><br><br>
Hier k&ouml;nnen Sie eine Personal WebBase-Datensicherung einf&uuml;gen.<br><br>

Achtung: Wenn die Personal WebBase-Schnittstelle, mit der Sie die Sicherung durchgef&uuml;hrt haben, mehr Module enthielt als diese Personal WebBase-Schnittstelle, so werden nur die Datens&auml;tze importiert, zu denen die Module gefunden wurden.<br><br>

Bitte Beachten Sie: Wenn Sie Datens&auml;tze hochladen, die die selbe ID-Nummer enthalten, wird Personal WebBase die ID-Nummern erh&ouml;hen, sodass das Einf&uuml;gen erfolgreich wird. Duplikate sind somit m&ouml;glich. Maximale Dateigr&ouml;&szlig;e: '.ini_get('post_max_size').'B<br><br>

<form enctype="multipart/form-data" action="'.$_SERVER['PHP_SELF'].'" method="post">
<input type="hidden" name="seite" value="kraftsetzung">
<input type="hidden" name="modul" value="'.$modul.'">
<input type="hidden" name="aktion" value="dump">
<input type="hidden" name="MAX_FILE_SIZE" value="'.return_bytes(ini_get('post_max_size')).'">

<table cellspacing="0" cellpadding="2" border="0">
<tr>
  <td>Aktuelles Passwort:</td>
  <td><img src="design/spacer.gif" alt="" width="5" height="1"></td>
  <td>';

  if ($ib_user_type == 0)
    echo 'Im Gastkonto wird kein Passwort ben&ouml;tigt.';
  else
    echo '<input type="password" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="pwd" value="">';

  echo '</td>
</tr>
<tr>
  <td>Datensicherung:</td>
  <td><img src="design/spacer.gif" alt="" width="5" height="1"></td>
  <td><input name="dfile" type="file"></td>
</tr>
</table><br>

<input type="submit" class="button" onmouseover="this.className=\'button_act\';" onmouseout="this.className=\'button\';" value="Hochladen">
</form>

<b>Alle Datens&auml;tze entfernen</b><br><br>

Mit dieser Funktion k&ouml;nnen Sie <i>alle Datens&auml;tze</i> aus Ihrer Personal WebBase-Datenbank entfernen! Bitte geben Sie das Wort &quot;OK&quot; in das Sicherheitsfeld ein. Dieser Vorgang kann nicht mehr r&uuml;ckg&auml;ngig gemacht werden.<br><br>

<form action="'.$_SERVER['PHP_SELF'].'" method="POST">
<input type="hidden" name="seite" value="kraftsetzung">
<input type="hidden" name="modul" value="'.$modul.'">
<input type="hidden" name="aktion" value="dest">

<table cellspacing="0" cellpadding="2" border="0">
<tr>
  <td>Aktuelles Passwort:</td>
  <td><img src="design/spacer.gif" alt="" width="5" height="1"></td>
  <td>';

  if ($ib_user_type == 0)
    echo 'Im Gastkonto wird kein Passwort ben&ouml;tigt.';
  else
    echo '<input type="password" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="pwd" value="">';

  echo '</td>
</tr>
<tr>
  <td>Sicherheitsfeld:</td>
  <td><img src="design/spacer.gif" alt="" width="5" height="1"></td>
  <td><input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="sic" value=""></td>
</tr>
</table><br>

<input type="submit" class="button" onmouseover="this.className=\'button_act\';" onmouseout="this.className=\'button\';" value="Datens&auml;tze entfernen">
</form>';

  echo $footer;

?>
