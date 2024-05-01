<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

echo str_replace('<body', '<body onload="self.focus();document.getElementById(\'eintrag\').focus();"', $header);

if (isset($sent) && ($sent == '1'))
{
	if ((!isset($eintrag)) || ((isset($eintrag)) && ($eintrag == ''))) die(''); // Alternativ: Prüfen, ob der Datenträger wirklich existiert!

	if (($wurzel == '') && ($ordner == '') && ($komplett == ''))
	{
		db_query("DELETE FROM `".$WBConfig->getMySQLPrefix()."mediacollection_content` WHERE `eintrag` = '".db_escape($eintrag)."' AND `category` = '".$category."' AND `user_cnid` = '".$benutzer['id']."'");
		if (db_affected_rows() > 0)
			db_query("OPTIMIZE TABLE `".$WBConfig->getMySQLPrefix()."mediacollection_content`");
	}
	else
	{
		$ary = explode('-', $eintrag);
		$category = $ary[0];
		$eintrag = $ary[1];
		$komplett = $komplett;
		$komplett = str_replace('„', '&auml;', $komplett);
		$komplett = str_replace('”', '&ouml;', $komplett);
		$komplett = str_replace('?', '&uuml;', $komplett);
		$komplett = str_replace('Ž', '&Auml;', $komplett);
		$komplett = str_replace('™', '&Ouml;', $komplett);
		$komplett = str_replace('š', '&Uuml;', $komplett);
		$komplett = str_replace('á', '&szlig;', $komplett);
		db_query("UPDATE `".$WBConfig->getMySQLPrefix()."mediacollection_content` SET `komplett` = '".db_escape($komplett)."' WHERE `eintrag` = '".db_escape($eintrag)."' AND `category` = '".db_escape($category)."' AND `user_cnid` = '".$benutzer['id']."'");
		db_query("INSERT INTO `".$WBConfig->getMySQLPrefix()."mediacollection_content` (`eintrag`, `komplett`, `category`, `user_cnid`) VALUES ('".db_escape($eintrag)."', '".db_escape($komplett)."', '".db_escape($category)."', '".$benutzer['id']."')");
	}
}

echo '<h1>Neuen Inhalt erstellen</h1>';

$disks = '';

$something_found = false;
$res2 = db_query("SELECT `nummer`, `spalte`, `name` FROM `".$WBConfig->getMySQLPrefix()."mediacollection_categories` WHERE `user_cnid` = '".$benutzer['id']."' ORDER BY `spalte`, `nummer` ASC");
while ($row2 = db_fetch($res2))
{
	$res3 = db_query("SELECT `id`, `nr`, `name` FROM `".$WBConfig->getMySQLPrefix()."mediacollection_entries` WHERE `category` = '".$row2['spalte'].$row2['nummer']."' AND `user_cnid` = '".$benutzer['id']."' ORDER BY `id` ASC");
	while ($row3 = db_fetch($res3)) {
		$disks .= '<option value="'.$row2['spalte'].$row2['nummer'].'-'.$row3['id'].'">'.$row2['spalte'].$row2['nummer'].' - ('.$row3['nr'].') '.$row3['name'].'</option>';
		$something_found = true;
	}
}

if (!$something_found) {
	echo '<p>Es existieren keine Datentr&auml;ger.</p>';
	echo '<p><a href="'.$_SERVER['PHP_SELF'].'?modul='.$modul.'&amp;seite=newdisk">Einen Datentr&auml;ger hinzuf&uuml;gen</a></p>';
	echo '<p><a href="'.$_SERVER['PHP_SELF'].'?modul='.$modul.'&amp;seite=main">Zur&uuml;ck zum Hauptmen&uuml;</a></p>';
} else {
	echo '<form method="post" action="'.$_SERVER['PHP_SELF'].'" name="mainform">';
	echo '<input type="hidden" name="modul" value="'.$modul.'">';
	echo '<input type="hidden" name="seite" value="newinhalt">';
	echo '<input type="hidden" name="sent" value="1">';

	echo 'Datentr&auml;ger: <select name="eintrag" id="eintrag">';
	echo $disks;
	echo '</select><br><br>';

	echo 'Komplettinhalt (tree x: /f /a)<br><br><textarea name="komplett" cols="70" rows="10"></textarea><br><br>';

	echo '<input type="submit" class="button" onmouseover="this.className=\'button_act\';" onmouseout="this.className=\'button\';" value="Inhalt einf&uuml;gen"> <input type="button" value="Abbrechen" onclick="document.location.href=\'?modul='.$modul.'&amp;seite=main\'" class="button" onmouseover="this.className=\'button_act\';" onmouseout="this.className=\'button\';">';

	echo '</form>';
}

unset($something_found);
unset($disks);

echo $footer;

?>