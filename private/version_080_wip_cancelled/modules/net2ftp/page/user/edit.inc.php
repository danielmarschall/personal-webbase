<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

if (($aktion == 'new') || ($aktion == 'edit'))
{
	echo str_replace('<body', '<body onload="self.focus();document.getElementById(\'fusername\').focus();"', $header);

	if ($aktion == 'new') echo '<h1>Neues FTP-Konto</h1>';
	if ($aktion == 'edit') echo '<h1>FTP-Konto bearbeiten</h1>';

	if ($aktion == 'edit')
	{
		$res = db_query("SELECT * FROM `".$WBConfig->getMySQLPrefix()."net2ftp` WHERE `id` = '".db_escape($id)."' AND `user_cnid` = '".$benutzer['id']."'");
		if (db_num($res) == 0)
			die($header.'Auf diesen Datensatz kann nicht zugegriffen werden. Entweder ist er nicht mehr verf&uuml;gbar, oder die Zugriffsberechtigungen sind falsch.'.$footer);
		$row = db_fetch($res);

		$auszuwaehlen = (isset($row['folder_cnid'])) ? $row['folder_cnid'] : '';
		$fusername = (isset($row['username'])) ? $row['username'] : '';
		$fpassword = (isset($row['password'])) ? $row['password'] : '';
		$fserver = (isset($row['server'])) ? $row['server'] : '';
		$fstart = (isset($row['home_directory'])) ? $row['home_directory'] : '';
		$fport = (isset($row['port'])) ? $row['port'] : '21';
	}
	else
	{
		$auszuwaehlen = (isset($folder)) ? $folder : 0;
		$fusername = '';
		$fpassword = '';
		$fserver = '';
		$fstart = '';
		$fport = '21';
	}

echo '<form method="POST" name="mainform" action="'.$_SERVER['PHP_SELF'].'">
<input type="hidden" name="seite" value="operate">
<input type="hidden" name="aktion" value="'.$aktion.'">
<input type="hidden" name="modul" value="'.$modul.'">';

if ($aktion == 'edit')
	echo '<input type="hidden" name="id" value="'.$id.'">';

echo '<table cellspacing="0" cellpadding="0" border="0">
<tr>
	<td colspan="2"><b>Allgemeine Informationen</b><br><br></td>
</tr>
<tr>
	<td valign="top">In Ordner:<img src="designs/spacer.gif" height="1" width="35" alt=""></td>
	<td valign="top">';

	gfx_zeichneordnerbox($modul, 0, 0, $auszuwaehlen);

	if (!isset($danach)) $danach = 'A';

	echo '</td>
</tr>
<tr>
	<td colspan="2"><br><b>Zugangsdaten</b><br><br></td>
</tr>
<tr>
	<td valign="top">Benutzername:<img src="designs/spacer.gif" height="1" width="35" alt=""></td>
	<td valign="top"><input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="fusername" id="fusername" value="'.$fusername.'" size="50"></td>
</tr>
<tr>
	<td valign="top">Passwort:<img src="designs/spacer.gif" height="1" width="35" alt=""></td>
	<td valign="top"><input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="fpassword" value="'.$fpassword.'" size="50"></td>
</tr>
<tr>
	<td valign="top">Server:<img src="designs/spacer.gif" height="1" width="35" alt=""></td>
	<td valign="top"><input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="fserver" value="'.$fserver.'" size="40"> : <input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="fport" value="'.$fport.'" size="5"></td>
</tr>
<tr>
	<td valign="top">Startverzeichnis:<img src="designs/spacer.gif" height="1" width="35" alt=""></td>
	<td valign="top"><input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="fstart" value="'.$fstart.'" size="50"></td>
</tr>
<tr>
	<td colspan="2"><br><b>Nach Speicherung</b><br><br></td>
</tr>
<tr>
	<td valign="top">Aktion: </td>
	<td><select name="danach">
		<option value="A"'; if ($danach == 'A') echo ' selected'; echo '>Zur&uuml;ck zum Hauptmen&uuml;</option>
		<option value="B"'; if ($danach == 'B') echo ' selected'; echo '>Neuer Eintrag in Kategorie</option>
		<option value="C"'; if ($danach == 'C') echo ' selected'; echo '>Neuer Eintrag im Ordner</option>
	</select></td>
</tr>
</table><br>
<a href="javascript:document.mainform.submit();">';

if ($aktion == 'new') echo 'Eintragung hinzuf&uuml;gen';
if ($aktion == 'edit') echo 'Eintragung aktualisieren';

echo '</a>&nbsp;|&nbsp;<a href="'.$_SERVER['PHP_SELF'].'?seite=main&amp;modul='.$modul.'">Zur&uuml;ck</a>

</form>';

	echo $footer;
}

?>