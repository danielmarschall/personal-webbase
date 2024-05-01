<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

if ($wb_user_type < 2) die('Keine Zugriffsberechtigung');

	echo $header;

	if (!isset($vonmodul)) $vonmodul = $modul;
	if (!isset($vonseite)) $vonseite = 'main';


		echo '<h1>'.wb_htmlentities($module_information->caption).'</h1>';
		echo 'Hier k&ouml;nnen Sie das Personal WebBase-Desing bestimmen. Es sind folgende Designs installiert:<br><br>';

	echo '<form action="'.$_SERVER['PHP_SELF'].'" method="POST" name="mainform" id="mainform">
<input type="hidden" name="seite" value="operate">
<input type="hidden" name="aktion" value="change_configuration">
<input type="hidden" name="modul" value="'.$modul.'">
<input type="hidden" name="vonseite" value="'.$vonseite.'">
<input type="hidden" name="vonmodul" value="'.$vonmodul.'">';

	$i = 0;
	$v = 'designs/';
	$verz=opendir($v);

	while ($file = readdir($verz))
	{
		if (($file != '.') && ($file != '..') && (is_dir($v.$file)))
		{
			$i++;
			if ($configuration[$modul]['design'] == $file)
				$zus = ' checked';
			else
				$zus = '';

			$design_information = get_design_information($file);

			echo '<input type="radio" name="newdesign" value="'.$file.'"'.$zus.'> '.$design_information->name.' ('.$file.')<br>';
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