<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

// Sicherheitsabschnitt

$ary = explode('/', $_SERVER['PHP_SELF']);

if (($configuration['main_administration']['admin_pwd'] == '') && ($ary[count($ary)-1] != 'style.css.php'))
{
	$fehler = '';
	if ((isset($setapwd)) && ($setapwd == '1'))
	{
		if ($apw1 == '')
			$fehler .= '<p><span class="red">Fehler: Es muss ein Passwort angegeben werden!</span></p>';

		if ($apw1 != $apw2)
			$fehler .= '<p><span class="red">Fehler: Die beiden Passw&ouml;rter sind verschieden!</span></p>';

		if (($validuser != $WBConfig->getMySQLUsername()) || ($validpass != $WBConfig->getMySQLPassword()))
			$fehler .= '<p><span class="red">Fehler: Die MySQL-Validierungsdaten sind falsch!</span></p>';

		if ($fehler == '')
		{
			wb_change_config('admin_pwd', md5($apw1), 'main_administration');
			wb_redirect_now($_SERVER['PHP_SELF']);
		}
	}
	die($header.'<h1>Aktivierung von Personal WebBase</h1>Personal WebBase nutzt derzeit noch das Administratorpasswort, das bei der Auslieferung gesetzt wurde. Sie <u>m&uuml;ssen</u> ein eigenes Administratorpasswort eingeben!<br><br>
	Bitte loggen Sie sich danach in den Administrationsbereich ein, um ggf. die Konfigurationswerte anzupassen.<br><br><form action="'.$_SERVER['PHP_SELF'].'" method="POST">
	<input type="hidden" name="setapwd" value="1">
	<table cellpadding="0" cellspacing="0" border="0">
	<tr><td width="225">Administratorpasswort festlegen auf:</td><td>&nbsp;&nbsp;&nbsp;</td><td><input type="password" name="apw1" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';"></td></tr>
	<tr><td>Eingabe wiederholen:</td><td>&nbsp;&nbsp;&nbsp;</td><td><input type="password" name="apw2" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';"></td></tr>
	</table><br>Damit Personal WebBase sicherstellen kann, dass Sie derjenige sind, der Personal WebBase auch installiert hat, geben Sie bitte jetzt noch die MySQL-Zugangsdaten ein, das Sie in der Konfigurationsdatei <code>includes/config.inc.php</code> bei <code>$mysql_access_data[\'username\']</code> und <code>$mysql_access_data[\'password\']</code> eingetragen haben.<br><br>
	<table cellpadding="0" cellspacing="0" border="0">
	<tr><td width="225">MySQL-Benutzername:</td><td>&nbsp;&nbsp;&nbsp;</td><td><input type="text" name="validuser" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';"></td></tr>
	<tr><td width="225">MySQL-Passwort:</td><td>&nbsp;&nbsp;&nbsp;</td><td><input type="password" name="validpass" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';"></td></tr>
	<tr><td colspan="2"><br><input type="submit" value="Festlegen" class="button" onmouseover="this.className=\'button_act\';" onmouseout="this.className=\'button\';"></td></tr>
	</table><br>'.$fehler.'
	</form>'.$footer);
}

?>