<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

echo str_replace('<body', '<body onload="self.focus();document.getElementById(\'kategorie\').focus();"', $header);

if (isset($sent) && ($sent == '1'))
{
  $ary = explode("\n", $eintraege);

  for ($i=0; $i <= count($ary); $i++)
  {
    $res3 = db_query("SELECT MAX(`nr`) AS `mx` FROM `".$mysql_zugangsdaten['praefix']."datentraeger_eintraege` WHERE `kategorie` = '".$kategorie."' AND `user` = '".$benutzer['id']."'");
    $row3 = db_fetch($res3);
    $new = $row3['mx'];

    if (isset($ary[$i]) && ($ary[$i] != ''))
    {
      if (strpos($ary[$i], '*'))
      {
        $ary[$i] = str_replace('*', '', $ary[$i]);
        $gebrannt = '1';
      }
      else
      {
        $gebrannt = '0';
      }
      db_query("INSERT INTO `".$mysql_zugangsdaten['praefix']."datentraeger_eintraege` (`nr`, `name`, `kategorie`, `einstellungsdatum`, `gebrannt`, `user`) VALUES ('".($new+1)."', '".db_escape($ary[$i])."', '".db_escape($kategorie)."', NOW(), '".db_escape($gebrannt)."', '".$benutzer['id']."')");
    }
  }
}

  echo '<h1>Neue Eintr&auml;ge erstellen</h1>';

  echo '<form method="post" action="'.$_SERVER['PHP_SELF'].'" name="mainform">';
  echo '<input type="hidden" name="modul" value="'.$modul.'">';
  echo '<input type="hidden" name="seite" value="'.$seite.'">';
  echo '<input type="hidden" name="sent" value="1">';

  echo 'Kategorie: <select name="kategorie" id="kategorie">';
  $res2 = db_query("SELECT `nummer`, `spalte`, `name` FROM `".$mysql_zugangsdaten['praefix']."datentraeger_kategorien` WHERE `user` = '".$benutzer['id']."' ORDER BY `spalte`, `nummer` ASC");
  while ($row2 = db_fetch($res2))
    echo '<option value="'.$row2['spalte'].$row2['nummer'].'">'.$row2['spalte'].$row2['nummer'].' - '.$row2['name'].'</option>';
  echo '</select><br><br>';

  echo '<textarea name="eintraege" cols="70" rows="10"></textarea><br>';

  echo '<br><input type="submit" class="button" onmouseover="this.className=\'button_act\';" onmouseout="this.className=\'button\';" value="Eintr&auml;ge Erstellen"> <input type="button" value="Abbrechen" onclick="document.location.href=\''.$_SERVER['PHP_SELF'].'?modul='.urlencode($modul).'&amp;seite=inhalt\'" class="button" onmouseover="this.className=\'button_act\';" onmouseout="this.className=\'button\';">';

  echo '</form>';

  echo $footer;

?>
