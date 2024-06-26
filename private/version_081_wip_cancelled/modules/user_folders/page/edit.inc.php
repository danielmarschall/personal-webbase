<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

if (($aktion == 'new') || ($aktion == 'edit'))
{
	echo str_replace('<body', '<body onload="self.focus();document.getElementById(\'name\').focus();"', $header);

	if ($aktion == 'new') echo '<h1>Neuer Ordner</h1>';
	if ($aktion == 'edit') echo '<h1>Ordner bearbeiten</h1>';

	if ($aktion == 'edit')
	{
		$res = db_query("SELECT `name`, `folder_cnid` FROM `".$WBConfig->getMySQLPrefix()."folders` WHERE `id` = '".db_escape($id)."' AND `user_cnid` = '".$benutzer['id']."'");
		if (db_num($res) == 0)
			die($header.'Auf diesen Datensatz kann nicht zugegriffen werden. Entweder ist er nicht mehr verf&uuml;gbar, oder die Zugriffsberechtigungen sind falsch.'.$footer);
		$row = db_fetch($res);

		$name = (isset($row['name'])) ? $row['name'] : '';
		$auszuwaehlen = (isset($row['folder_cnid'])) ? $row['folder_cnid'] : '';
	}
	else
	{
		$name = '';
		$auszuwaehlen = (isset($folder)) ? $folder : 0;
	}

	echo '<form action="'.$_SERVER['PHP_SELF'].'" method="POST" name="mainform">
<input type="hidden" name="seite" value="operate">
<input type="hidden" name="aktion" value="'.$aktion.'">
<input type="hidden" name="modul" value="'.$modul.'">
<input type="hidden" name="category" value="'.$category.'">';

	if ($aktion == 'edit')
		echo '<input type="hidden" name="id" value="'.$id.'">';

	$module_information = get_module_information($category);

	echo '<table cellspacing="0" cellpadding="0" border="0">
<tr>
	<td valign="top">Kategorie:<img src="designs/spacer.gif" height="1" width="35" alt=""></td>
	<td valign="top">'.$module_information->caption.'</td>
</tr>
<tr>
	<td valign="top">Name:<img src="designs/spacer.gif" height="1" width="35" alt=""></td>
	<td valign="top"><input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="name" id="name" value="'.$name.'"></td>
</tr>
<tr>
	<td valign="top">In Ordner:<img src="designs/spacer.gif" height="1" width="35" alt=""></td>
	<td valign="top">';

	if (!isset($id)) $id = 0;
	gfx_zeichneordnerbox($category, 0, 0, $auszuwaehlen, $id);

	if (!isset($danach)) $danach = 'A';

	echo '</td>
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

	echo '</a>&nbsp;|&nbsp;<a href="'.$_SERVER['PHP_SELF'].'?seite=main&amp;modul='.$category.'">Zur&uuml;ck</a>

</form>';

	echo $footer;
}

?>