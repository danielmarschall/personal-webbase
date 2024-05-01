<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

echo str_replace('<body', '<body onload="self.focus();document.getElementById(\'internet-check-url\').focus();"', $header);

if (!isset($vonmodul)) $vonmodul = $modul;
if (!isset($vonseite)) $vonseite = 'main';

echo '<h1>'.wb_htmlentities($module_information->caption).'</h1>';

echo '<form action="'.$_SERVER['PHP_SELF'].'" method="POST" name="mainform" id="mainform">
<input type="hidden" name="seite" value="operate">
<input type="hidden" name="aktion" value="change_configuration">
<input type="hidden" name="modul" value="'.$modul.'">
<input type="hidden" name="vonseite" value="'.$vonseite.'">
<input type="hidden" name="vonmodul" value="'.$vonmodul.'">';

if (inetconn_ok())
	echo '<span class="green">Internetverbindung OK</span>';
else
	echo '<span class="red">Internetverbindung nicht OK oder ung&uuml;ltige(r) Pr&uuml;f-URL/Port</span>';

?><br><br>

<table cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td>Internet-Test-URL</td>
		<td><img src="designs/spacer.gif" width="15" height="1" alt=""></td>
		<td>http://<input type="text" size="30" name="internet_check_url" id="internet_check_url" class="normal" onmouseover="this.className='highlight';" onmouseout="this.className='normal';" value="<?php echo $configuration[$modul]['internet-check-url']; ?>">/ auf Port <input type="text" size="5" name="internet_check_port" id="internet_check_port" class="normal" onmouseover="this.className='highlight';" onmouseout="this.className='normal';" value="<?php echo $configuration[$modul]['internet-check-port']; ?>"></td>
	</tr>
</table><br>

	<input type="button" onclick="document.location.href='<?PHP echo $_SERVER['PHP_SELF']; ?>?modul=<?php echo $vonmodul; ?>&amp;seite=<?php echo $vonseite; ?>';" class="button" onmouseover="this.className='button_act';" onmouseout="this.className='button';" value="Zur&uuml;ck">
	&nbsp;&nbsp;&nbsp;
	<input type="submit" value="&Auml;ndern" class="button" onmouseover="this.className='button_act';" onmouseout="this.className='button';">

	</form>

<?php

echo $footer;

?>