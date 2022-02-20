<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

if ($ib_user_type < 2) die('Keine Zugriffsberechtigung');

  echo $header;

  if (!isset($vonmodul)) $vonmodul = $modul;
  if (!isset($vonseite)) $vonseite = 'inhalt';

if ($modulueberschrift == '') $modulueberschrift = $modul;
    echo '<h1>'.my_htmlentities($modulueberschrift).'</h1>';
    echo 'Hier k&ouml;nnen Sie das Personal WebBase-Desing bestimmen. Es sind folgende Designs installiert:<br><br>';

  echo '<form action="'.$_SERVER['PHP_SELF'].'" method="POST" name="mainform" id="mainform">
<input type="hidden" name="seite" value="kraftsetzung">
<input type="hidden" name="aktion" value="changekonfig">
<input type="hidden" name="modul" value="'.$modul.'">
<input type="hidden" name="vonseite" value="'.$vonseite.'">
<input type="hidden" name="vonmodul" value="'.$vonmodul.'">';

  $i = 0;
  $v = 'design/';
  $verz=opendir($v);

  while ($file = readdir($verz))
  {
    if (($file != '.') && ($file != '..') && (is_dir($v.$file)))
    {
      $i++;
      if ($konfiguration[$modul]['design'] == $file)
        $zus = ' checked';
      else
        $zus = '';
      echo "<input type=\"radio\" name=\"newdesign\" value=\"$file\"$zus> $file<br>";
    }
  }

  closedir($verz);

  echo '<br>';

  echo '<input type="button" onclick="document.location.href=\''.$_SERVER['PHP_SELF'].'?modul='.$vonmodul.'&amp;seite='.$vonseite.'\';" class="button" onmouseover="this.className=\'button_act\';" onmouseout="this.className=\'button\';" value="Zur&uuml;ck">';
  echo '&nbsp;&nbsp;&nbsp;';
  echo '<input type="submit" value="&Auml;ndern" class="button" onmouseover="this.className=\'button_act\';" onmouseout="this.className=\'button\';">

  </form>';

      echo $footer;

?>
