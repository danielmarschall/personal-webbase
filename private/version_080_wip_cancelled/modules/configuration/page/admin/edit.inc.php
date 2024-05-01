<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

	echo str_replace('<body', '<body onload="self.focus();document.getElementById(\'wert\').focus();"', $header);

	$res = db_query("SELECT `name`, `value`, `module` FROM `".$WBConfig->getMySQLPrefix()."configuration` WHERE `id` = '".db_escape($id)."'");
	$row = db_fetch($res);

	echo '<h1>Konfiguration bearbeiten</h1>

Sie bearbeiten den Wert &quot;'.$row['module'].'/'.$row['name'].'&quot;<br>

<form method="POST" action="'.$_SERVER['PHP_SELF'].'" name="mainform" id="mainform">
<input type="hidden" name="seite" value="operate">
<input type="hidden" name="aktion" value="edit">
<input type="hidden" name="modul" value="'.$modul.'">
<input type="hidden" name="name" value="'.$row['name'].'">
<input type="hidden" name="kmodul" value="'.$row['module'].'">

<input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="wert" id="wert" value="'.$row['value'].'"><br><br>

<input type="button" onclick="document.location.href=\''.$_SERVER['PHP_SELF'].'?modul='.$modul.'&amp;seite=config\';" class="button" onmouseover="this.className=\'button_act\';" onmouseout="this.className=\'button\';" value="Zur&uuml;ck">
&nbsp;&nbsp;&nbsp;
<input type="submit" class="button" onmouseover="this.className=\'button_act\';" onmouseout="this.className=\'button\';" value="Wert &auml;ndern">

</form>';

	echo $footer;

?>