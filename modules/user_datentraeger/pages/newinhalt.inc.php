<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

echo str_replace('<body', '<body onload="self.focus();document.getElementById(\'eintrag\').focus();"', $header);

if (isset($sent) && ($sent == '1'))
{
  if (($wurzel == '') && ($ordner == '') && ($komplett == ''))
  {
    db_query("DELETE FROM `".$mysql_zugangsdaten['praefix']."datentraeger_inhalt` WHERE `eintrag` = '".db_escape($eintrag)."' AND `kategorie` = '".$kategorie."' AND `user` = '".$benutzer['id']."'");
    if (db_affected_rows() > 0)
      db_query("OPTIMIZE TABLE `".$mysql_zugangsdaten['praefix']."datentraeger_inhalt`");
  }
  else
  {
    $ary = explode('-', $eintrag);
    $kategorie = $ary[0];
    $eintrag = $ary[1];
    $komplett = $komplett;
    $komplett = str_replace('„', '&auml;', $komplett);
    $komplett = str_replace('”', '&ouml;', $komplett);
    $komplett = str_replace('?', '&uuml;', $komplett);
    $komplett = str_replace('Ž', '&Auml;', $komplett);
    $komplett = str_replace('™', '&Ouml;', $komplett);
    $komplett = str_replace('š', '&Uuml;', $komplett);
    $komplett = str_replace('á', '&szlig;', $komplett);
    db_query("UPDATE `".$mysql_zugangsdaten['praefix']."datentraeger_inhalt` SET `komplett` = '".db_escape($komplett)."' WHERE `eintrag` = '".db_escape($eintrag)."' AND `kategorie` = '".db_escape($kategorie)."' AND `user` = '".$benutzer['id']."'");
    db_query("INSERT INTO `".$mysql_zugangsdaten['praefix']."datentraeger_inhalt` (`eintrag`, `komplett`, `kategorie`, `user`) VALUES ('".db_escape($eintrag)."', '".db_escape($komplett)."', '".db_escape($kategorie)."', '".$benutzer['id']."')");
  }
}

  echo '<h1>Neuen Inhalt erstellen</h1>';

  echo '<form method="post" action="'.$_SERVER['PHP_SELF'].'" name="mainform">';
  echo '<input type="hidden" name="modul" value="'.$modul.'">';
  echo '<input type="hidden" name="seite" value="newinhalt">';
  echo '<input type="hidden" name="sent" value="1">';

  echo 'Datentr&auml;ger: <select name="eintrag" id="eintrag">';
  $res2 = db_query("SELECT `nummer`, `spalte`, `name` FROM `".$mysql_zugangsdaten['praefix']."datentraeger_kategorien` WHERE `user` = '".$benutzer['id']."' ORDER BY `spalte`, `nummer` ASC");
  while ($row2 = db_fetch($res2))
  {
    $res3 = db_query("SELECT `id`, `nr`, `name` FROM `".$mysql_zugangsdaten['praefix']."datentraeger_eintraege` WHERE `kategorie` = '".$row2['spalte'].$row2['nummer']."' AND `user` = '".$benutzer['id']."' ORDER BY `id` ASC");
    while ($row3 = db_fetch($res3))
      echo '<option value="'.$row2['spalte'].$row2['nummer'].'-'.$row3['id'].'">'.$row2['spalte'].$row2['nummer'].' - ('.$row3['nr'].') '.$row3['name'].'</option>';
  }
  echo '</select><br><br>';

  echo 'Komplettinhalt (tree x: /f /a)<br><br><textarea name="komplett" cols="70" rows="10"></textarea><br><br>';

  echo '<input type="submit" class="button" onmouseover="this.className=\'button_act\';" onmouseout="this.className=\'button\';" value="Inhalt einf&uuml;gen"> <input type="button" value="Abbrechen" onclick="document.location.href=\'?modul='.urlencode($modul).'&amp;seite=inhalt\'" class="button" onmouseover="this.className=\'button_act\';" onmouseout="this.className=\'button\';">';

  echo '</form>';

  echo $footer;

?>
