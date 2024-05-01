<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

echo str_replace('<body', '<body onload="self.focus();document.getElementById(\'rusername\').focus();"', $header);

echo '<h1>'.htmlentities($module_information->caption).'</h1>';

$res = db_query("SELECT * FROM `".$WBConfig->getMySQLPrefix()."users` WHERE `creator_ip` = '".$_SERVER['REMOTE_ADDR']."' AND `created_database` >= DATE_SUB(NOW(), INTERVAL ".db_escape($configuration[$modul]['sperrdauer'])." MINUTE)");
if (db_num($res))
	die($footer.'<span class="red">Sie k&ouml;nnen mit dieser IP-Adresse nur jede '.$configuration[$modul]['sperrdauer'].' Minuten ein neues Konto er&ouml;ffnen!</span>'.$header);

if ($configuration[$modul]['enable_userreg'])
{
	$ok = true;
	if (isset($reg) && ($reg == '1'))
	{
		$ok = false;
		if (($rusername == '') || ($rpersonal_name == '') || ($rpassword == '') || ($rpassword2 == ''))
		{
			echo '<span class="red"><b>Fehler:</b> Sie m&uuml;ssen die erforderlichen Fehler ausf&uuml;llen, um sich zu registrieren.</span><br><br>';
			$ok = true;
		}
		else
		{
			if ($rpassword != $rpassword2)
			{
				 echo '<span class="red"><b>Fehler:</b> Die zwei Passw&ouml;rter stimmen nicht &uuml;berein.</span><br><br>';
				 $ok = true;
			}
			else
			{
				$res = db_query("SELECT `id` FROM `".$WBConfig->getMySQLPrefix()."users` WHERE `username` = '".db_escape($rusername)."'");
				if (db_num($res) > 0)
				{
					echo '<span class="red"><b>Fehler:</b> Der Benutzername &quot;'.$rusername.'&quot; ist bereits vergeben.</span><br><br>';
					$ok = true;
				}
				else
				{
					db_query("INSERT INTO `".$WBConfig->getMySQLPrefix()."users` (`username`, `personal_name`, `password`, `email`, `created_database`, `creator_ip`) VALUES ('".db_escape($rusername)."', '".db_escape($rpersonal_name)."', '".md5($rpassword)."', '".db_escape($remail)."', NOW(), '".$_SERVER['REMOTE_ADDR']."')");
					echo '<b>Sie haben Ihr Konto auf diesem Personal WebBase-Server erfolgreich registriert.</b><br><br>Das Konto ist sofort verwendbar. Wir w&uuml;nschen Ihnen viel Freude mit Personal WebBase!';
				}
			}
		}
	}
	if ($ok)
	{

		if (!isset($rusername)) $rusername = '';
		if (!isset($rpersonal_name)) $rpersonal_name = '';
		if (!isset($rpassword)) $rpassword = '';
		if (!isset($rpassword2)) $rpassword2 = '';
		if (!isset($remail)) $remail = '';

		echo '<b>Hier k&ouml;nnen Sie sich ein Konto auf diesem Personal WebBase-Server errichten.</b><br><br>

Die Angabe einer E-Mail-Adresse ist optional.<br><br>

<form action="'.$_SERVER['PHP_SELF'].'" method="POST" name="frm">
<input type="hidden" name="seite" value="'.$seite.'">
<input type="hidden" name="modul" value="'.$modul.'">
<input type="hidden" name="reg" value="1">

<table cellspacing="0" cellpadding="2" border="0">
<tr>
	<td>Benutzername:</td>
	<td><img src="designs/spacer.gif" alt="" width="5" height="1"></td>
	<td><input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="rusername" id="rusername" value="'.$rusername.'"></td>
</tr>
<tr>
	<td>Personenname:</td>
	<td><img src="designs/spacer.gif" alt="" width="5" height="1"></td>
	<td><input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="rpersonal_name" value="'.$rpersonal_name.'"></td>
</tr>
<tr>
	<td>Passwort:</td>
	<td><img src="designs/spacer.gif" alt="" width="5" height="1"></td>
	<td><input type="password" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="rpassword" value="'.$rpassword.'"></td>
</tr>
<tr>
	<td>Wiederholung:</td>
	<td><img src="designs/spacer.gif" alt="" width="5" height="1"></td>
	<td><input type="password" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="rpassword2" value="'.$rpassword2.'"></td>
</tr>
<tr>
	<td>E-Mail-Adresse:</td>
	<td><img src="designs/spacer.gif" alt="" width="5" height="1"></td>
	<td><input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="remail" value="'.$remail.'"></td>
</tr>
</table><br>

<input type="submit" class="button" onmouseover="this.className=\'button_act\';" onmouseout="this.className=\'button\';" value="Registrieren">

</form>';
	}
}
else
{
	echo '<span class="red">Das Registrieren bei Personal WebBase wurde von dem Administrator nicht aktiviert.</span>';
}

	echo $footer;

?>