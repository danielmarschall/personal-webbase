<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

echo $header;

if (!isset($vonmodul)) $vonmodul = $modul;
if (!isset($vonseite)) $vonseite = 'main';

echo '<h1>'.htmlentities($module_information->caption).'</h1>';
echo 'Hier k&ouml;nnen Sie Konfigurationen des Modules vornehmen.<br><br>';

echo '<form action="'.$_SERVER['PHP_SELF'].'" method="POST" name="mainform" id="mainform">
<input type="hidden" name="seite" value="operate">
<input type="hidden" name="aktion" value="change_configuration">
<input type="hidden" name="modul" value="'.$modul.'">
<input type="hidden" name="vonseite" value="'.$vonseite.'">
<input type="hidden" name="vonmodul" value="'.$vonmodul.'">';

if ($configuration[$modul]['allow_user_selfdelete'] == '1')
	$zus = 'checked';
else
	$zus = '';

?>

<input type="checkbox" name="userselfdel" value="1"<?php echo $zus; ?>> Benutzerselbstl&ouml;schung erlauben<br><br>

	<input type="button" onclick="document.location.href='<?php echo $_SERVER['PHP_SELF']; ?>?modul=<?php echo $vonmodul; ?>&amp;seite=<?php echo $vonseite; ?>';" class="button" onmouseover="this.className='button_act';" onmouseout="this.className='button';" value="Zur&uuml;ck">
	&nbsp;&nbsp;&nbsp;
	<input type="submit" value="&Auml;ndern" class="button" onmouseover="this.className='button_act';" onmouseout="this.className='button';">

	</form>

<?php

echo $footer;

?>