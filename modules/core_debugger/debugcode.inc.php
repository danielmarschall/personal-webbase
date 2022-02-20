<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

// $i = Die gesamte gepufferte Ausgabe

    $debugging = '<hr><center><font color="#FF0000" size="+1"><b>Debug-Modus</b></font><br><form method="post" enctype="multipart/form-data" action="http://validator.w3.org/check" target="_blank">

<br><input type="submit" value="HTML-Validit&auml;t pr&uuml;fen" class="button" onmouseover="this.className=\'button_act\';" onmouseout="this.className=\'button\';">

<input type="hidden" name="fragment" value="'.my_htmlentities($i).'">

</form>

<b>MySQL-Transkript</b><br><br>

<textarea cols="100" rows="10" wrap="off">'.$sql_transkript.'</textarea><br><br>

<b>Session-Inhalt (Name: '.session_name().', ID: '.session_id().')</b><br><br>

<textarea cols="100" rows="10" wrap="off">';

ob_start();
print_r($_SESSION);
$debugging .= ob_get_contents();
ob_end_clean();

$debugging .= '</textarea></center><hr>';

echo str_replace('</body>', $debugging.'</body>', $i);

?>
