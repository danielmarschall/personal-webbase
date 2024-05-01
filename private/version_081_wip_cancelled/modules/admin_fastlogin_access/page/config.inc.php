<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

echo $header;

if (!isset($vonmodul)) $vonmodul = $modul;
if (!isset($vonseite)) $vonseite = 'main';

echo '<h1>'.wb_htmlentities($module_information->caption).'</h1>';
echo 'Hier k&ouml;nnen Sie die Schnellanmeldung konfigurieren.<br><br>';

echo '<form action="'.$_SERVER['PHP_SELF'].'" method="POST" name="mainform" id="mainform">
<input type="hidden" name="seite" value="operate">
<input type="hidden" name="aktion" value="change_configuration">
<input type="hidden" name="modul" value="'.$modul.'">
<input type="hidden" name="vonseite" value="'.$vonseite.'">
<input type="hidden" name="vonmodul" value="'.$vonmodul.'">';

if ($configuration[$modul]['enabled'])
	$zus = ' checked';
else
	$zus = '';

?>

<table cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td>Schnellanmeldung aktivieren:</td>
		<td><img src="designs/spacer.gif" width="15" height="1" alt=""></td>
		<td><input type="checkbox" name="sa_enabled" value="1"<?php echo $zus; ?>></td>
	</tr>
</table><br>

	<input type="button" onclick="document.location.href='<?php echo $_SERVER['PHP_SELF']; ?>?modul=<?php echo $vonmodul; ?>&amp;seite=<?php echo $vonseite; ?>';" class="button" onmouseover="this.className='button_act';" onmouseout="this.className='button';" value="Zur&uuml;ck">
	&nbsp;&nbsp;&nbsp;
	<input type="submit" value="&Auml;ndern" class="button" onmouseover="this.className='button_act';" onmouseout="this.className='button';">

	</form>

	<script language="JavaScript" type="text/javascript">
	<!--
		document.mainform.sa_enabled.focus();
	// -->
</script><?php

echo $footer;

?>