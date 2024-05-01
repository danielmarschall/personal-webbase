<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

echo $header;


echo '<h1>'.wb_htmlentities($module_information->caption).'</h1>';
	if (isset($fertig) && ($fertig))
	{
		echo 'Die &Auml;nderung wurde &uuml;bernommen.';
	}
	else
	{
		if ($wb_user_type == '0')
		{
			echo 'In diesem Bereich k&ouml;nnen Benutzer ihr Passwort &auml;ndern bzw. das Konto l&ouml;schen, sofern der Administrator dies erlaubt.<br><br><span class="red">Diese Funktion ist im Gastzugang nicht verf&uuml;gbar.</span>';
		}
		else
		{
			echo '<form action="'.$_SERVER['PHP_SELF'].'" method="POST">
<input type="hidden" name="seite" value="operate">
<input type="hidden" name="aktion" value="pwd_aendern">
<input type="hidden" name="modul" value="'.$modul.'">

Hier k&ouml;nnen Sie Ihr Benutzerkonto verwalten.<br><br>';
			echo '<b>Passwort &auml;ndern</b><br><br>

<table cellspacing="0" cellpadding="2" border="0">
<tr>
	<td>Aktuelles Passwort:</td>
	<td><img src="designs/spacer.gif" alt="" width="5" height="1"></td>
	<td><input type="password" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="pwd" value=""></td>
</tr>
<tr>
	<td>Neues Passwort:</td>
	<td><img src="designs/spacer.gif" alt="" width="5" height="1"></td>
	<td><input type="password" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="newpwd1" value=""></td>
</tr>
<tr>
	<td>Wiederholung:</td>
	<td><img src="designs/spacer.gif" alt="" width="5" height="1"></td>
	<td><input type="password" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="newpwd2" value=""></td>
</tr>
</table><br>

<input type="submit" class="button" onmouseover="this.className=\'button_act\';" onmouseout="this.className=\'button\';" value="Passwort &auml;ndern"></form>

<b>Konto l&ouml;schen</b><br><br>';

			if ($configuration[$modul]['allow_user_selfdelete'] == '1')
			{
				echo '<form action="'.$_SERVER['PHP_SELF'].'" method="POST">
<input type="hidden" name="seite" value="operate">
<input type="hidden" name="aktion" value="acc_dele">
<input type="hidden" name="modul" value="'.$seite.'">

Bitte geben Sie zum L&ouml;schen des Personal WebBase-Accounts das Wort &quot;OK&quot; in das Sicherheitsfeld ein.<br><br>

<table cellspacing="0" cellpadding="2" border="0">
<tr>
	<td>Aktuelles Passwort:</td>
	<td><img src="designs/spacer.gif" alt="" width="5" height="1"></td>
	<td><input type="password" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="pwd" value=""></td>
</tr>
<tr>
	<td>Sicherheitsfrage:</td>
	<td><img src="designs/spacer.gif" alt="" width="5" height="1"></td>
	<td><input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="sic" value="" maxlength="2"></td>
</tr>
</table><br><input type="submit" class="button" onmouseover="this.className=\'button_act\';" onmouseout="this.className=\'button\';" value="Konto l&ouml;schen"></form>';
			}
			else
			{
					echo 'Information: Der Serveradministrator hat die Benutzer-Selbstl&ouml;schung deaktiviert.';
				}
		}
	}

	echo $footer;

?>