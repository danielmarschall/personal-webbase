<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

echo str_replace('<body', '<body onload="self.focus();document.getElementById(\'ftpserver\').focus();"', $header);

if (!isset($vonmodul)) $vonmodul = $modul;
if (!isset($vonseite)) $vonseite = 'main';

echo '<h1>'.wb_htmlentities($module_information->caption).'</h1>';
echo 'Damit einige Module korrekt funktionieren k&ouml;nnen, wird ein g&uuml;ltiger FTP-Zugang mit Schreibzugriff auf das Personal WebBase-Verzeichnis ben&ouml;tigt. Das Verzeichnis muss mit abschlie&szlig;endem Slash angegeben werden (z.B. /html/webbase/ bei Confixx-Systemen oder /webbase/ bei Nicht-Confixx-Systemen).<br><br>';

$conn_id = @ftp_connect($configuration[$modul]['ftp-server'], $configuration[$modul]['ftp-port']);
$login_result = @ftp_login ($conn_id, $configuration[$modul]['ftp-username'], $configuration[$modul]['ftp-password']);

$fehler = false;

if ((!$conn_id) || (!$login_result))
{
	echo '<span class="red">Die FTP-Zugangsdaten sind falsch! Bitte korrigieren Sie diese.</span>';
	$fehler = true;
}

if ((!$fehler) && (substr($configuration[$modul]['ftp-verzeichnis'], strlen($configuration[$modul]['ftp-verzeichnis'])-1, 1) != '/'))
{
	echo '<span class="red">Das FTP-Verzeichnis muss einen abschlie&szlig;enden Slash (/) erhalten!</span>';
	$fehler = true;
}

if ((!$fehler) && (substr($configuration[$modul]['ftp-verzeichnis'], 0, 1) != '/'))
{
	echo '<span class="red">Das FTP-Verzeichnis muss mit einem Slash (/) beginnen!</span>';
	$fehler = true;
}

if ((!$fehler) && (@ftp_size($conn_id, $configuration[$modul]['ftp-verzeichnis'].'modules/moddir.txt') == -1))
{
	echo '<span class="red">Kann modules/moddir.txt nicht finden. Zeigt das FTP-Verzeichnis wirklich auf Personal WebBase?</span>';
	$fehler = true;
}

if ((!$fehler) && (@ftp_size($conn_id, $configuration[$modul]['ftp-verzeichnis'].'designs/desdir.txt') == -1))
{
	echo '<span class="red">Kann designs/desdir.txt nicht finden. Zeigt das FTP-Verzeichnis wirklich auf Personal WebBase?</span>';
	$fehler = true;
}

if (!$fehler)
{
	echo 'Es gibt derzeit kein Problem mit den FTP-Zugangsdaten.';
}

echo '<br><br>';

@ftp_quit($conn_id);

echo '<script language="JavaScript" type="text/javascript">
<!--

function subm_form(act)
{
	if (act == 0)
	{
		document.forms["mainform"].elements["zwischenspeichern"].value = "0";
	}
	if (act == 1)
	{
		document.forms["mainform"].elements["zwischenspeichern"].value = "1";
	}
	document.forms.mainform.submit();
}

// -->
</script>

<form action="'.$_SERVER['PHP_SELF'].'" method="POST" name="mainform" id="mainform">
<input type="hidden" name="seite" value="operate">
<input type="hidden" name="aktion" value="change_configuration">
<input type="hidden" name="modul" value="'.$modul.'">
<input type="hidden" name="vonseite" value="'.$vonseite.'">
<input type="hidden" name="vonmodul" value="'.$vonmodul.'">
<input type="hidden" name="zwischenspeichern" value="0">'; ?>

<table cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td>FTP-Server:</td>
		<td><img src="designs/spacer.gif" width="15" height="1" alt=""></td>
		<td><input type="text" id="ftpserver" name="ftpserver" class="normal" onmouseover="this.className='highlight';" onmouseout="this.className='normal';" value="<?php echo $configuration[$modul]['ftp-server']; ?>"> : <input type="text" size="5" name="ftpport" class="normal" onmouseover="this.className='highlight';" onmouseout="this.className='normal';" value="<?php echo $configuration[$modul]['ftp-port']; ?>"></td>
	</tr>
	<tr>
		<td>FTP-Benutzername:</td>
		<td><img src="designs/spacer.gif" width="15" height="1" alt=""></td>
		<td><input type="text" name="ftpuser" class="normal" onmouseover="this.className='highlight';" onmouseout="this.className='normal';" value="<?php echo $configuration[$modul]['ftp-username']; ?>"></td>
	</tr>
	<tr>
		<td>FTP-Passwort:</td>
		<td><img src="designs/spacer.gif" width="15" height="1" alt=""></td>
		<td><input type="text" name="ftppassword" class="normal" onmouseover="this.className='highlight';" onmouseout="this.className='normal';" value="<?php echo $configuration[$modul]['ftp-password']; ?>"></td>
	</tr>
	<tr>
		<td>FTP-Verzeichnis:</td>
		<td><img src="designs/spacer.gif" width="15" height="1" alt=""></td>
		<td><input type="text" name="ftpverzeichnis" class="normal" onmouseover="this.className='highlight';" onmouseout="this.className='normal';" value="<?php echo $configuration[$modul]['ftp-verzeichnis']; ?>"></td>
	</tr>
</table><br>

	<input type="button" onclick="document.location.href='<?php echo $_SERVER['PHP_SELF']; ?>?modul=<?php echo $vonmodul; ?>&amp;seite=<?php echo $vonseite; ?>';" class="button" onmouseover="this.className='button_act';" onmouseout="this.className='button';" value="Zur&uuml;ck">
	&nbsp;&nbsp;&nbsp;
	<input onclick="subm_form(1);" type="button" value="Zwischenspeichern" class="button" onmouseover="this.className='button_act';" onmouseout="this.className='button';">
	&nbsp;&nbsp;&nbsp;
	<input onclick="subm_form(0);" type="button" value="Speichern" class="button" onmouseover="this.className='button_act';" onmouseout="this.className='button';">

	</form>

<?php

echo $footer;

?>