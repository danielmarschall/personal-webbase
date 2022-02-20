<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne IronBASE ausgef&uuml;hrt werden.');

  echo str_replace('<body', '<body onload="self.focus();document.getElementById(\'message\').focus();"', $header);

if ($modulueberschrift == '') $modulueberschrift = $modul;
echo '<h1>'.htmlentities($modulueberschrift).'</h1>';

 echo 'M&ouml;chten Sie Ihren Mitgliedern etwas mitteilen? Dies k&ouml;nnen Sie hier tun.<br><br>';

    echo '<form method="POST" action="'.$_SERVER['PHP_SELF'].'" name="mainform" id="mainform">
<input type="hidden" name="seite" value="kraftsetzung">
<input type="hidden" name="aktion" value="send">
<input type="hidden" name="modul" value="'.$modul.'">

<center><textarea rows="20" cols="75" name="message" id="message"></textarea><br><br>

<input type="submit" class="button" onmouseover="this.className=\'button_act\';" onmouseout="this.className=\'button\';" value="Nachricht absenden"></center>

</form>';

      echo $footer;
?>