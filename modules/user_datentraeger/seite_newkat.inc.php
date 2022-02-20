<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

echo str_replace('<body', '<body onload="self.focus();document.getElementById(\'spalte1\').focus();"', $header);

if (isset($sent) && ($sent == '1'))
{
  for ($i=1; $i<=10; $i++)
  {
    $tmp1 = 'spalte'.$i;
    $tmp2 = 'id'.$i;
    $tmp3 = 'name'.$i;

    if (($$tmp1 != '') || ($$tmp2 != '') || ($$tmp3 != ''))
      db_query("INSERT INTO `".$mysql_zugangsdaten['praefix']."datentraeger_kategorien` (`nummer`, `name`, `spalte`, `user`) VALUES ('".$$tmp2."', '".$$tmp3."', '".$$tmp1."', '".$benutzer['id']."')");
  }
}

  echo '<h1>Neue Kategorien erstellen</h1>';

  echo '<form method="post" action="'.$_SERVER['PHP_SELF'].'" name="mainform">';
  echo '<input type="hidden" name="modul" value="'.$modul.'">';
  echo '<input type="hidden" name="seite" value="'.$seite.'">';
  echo '<input type="hidden" name="sent" value="1">';

  echo '<input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="spalte1"  id="spalte1" value="" size="2"> <input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="id1" value="" size="2"> - <input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="name1" value="" size="60"><br>';
  echo '<input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="spalte2"               value="" size="2"> <input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="id2" value="" size="2"> - <input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="name2" value="" size="60"><br>';
  echo '<input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="spalte3"               value="" size="2"> <input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="id3" value="" size="2"> - <input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="name3" value="" size="60"><br>';
  echo '<input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="spalte4"               value="" size="2"> <input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="id4" value="" size="2"> - <input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="name4" value="" size="60"><br>';
  echo '<input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="spalte5"               value="" size="2"> <input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="id5" value="" size="2"> - <input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="name5" value="" size="60"><br>';
  echo '<input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="spalte6"               value="" size="2"> <input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="id6" value="" size="2"> - <input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="name6" value="" size="60"><br>';
  echo '<input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="spalte7"               value="" size="2"> <input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="id7" value="" size="2"> - <input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="name7" value="" size="60"><br>';
  echo '<input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="spalte8"               value="" size="2"> <input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="id8" value="" size="2"> - <input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="name8" value="" size="60"><br>';
  echo '<input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="spalte9"               value="" size="2"> <input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="id9" value="" size="2"> - <input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="name9" value="" size="60"><br>';
  echo '<input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="spalte10"              value="" size="2"> <input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="id10" value="" size="2"> - <input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="name10" value="" size="60"><br>';

  echo '<br><input type="submit" class="button" onmouseover="this.className=\'button_act\';" onmouseout="this.className=\'button\';" value="Kategorien Erstellen"> <input type="button" value="Abbrechen" onclick="document.location.href=\''.$_SERVER['PHP_SELF'].'?modul='.$modul.'&amp;seite=inhalt\'" class="button" onmouseover="this.className=\'button_act\';" onmouseout="this.className=\'button\';">';

  echo '</form>';

  echo $footer;

?>
