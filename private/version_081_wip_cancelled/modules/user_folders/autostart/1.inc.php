<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

function gfx_zeichneordnerbox($modul, $dir = 0, $einzug = 0, $auszuwaehlen = 0, $ausschluss = 0)
{
	global $WBConfig;

	$ary = liste_ordner($modul, $dir, $ausschluss);
	if ($dir == 0)
	{
		echo '<select name="folder" id="folder">';
		echo '<option value="0">Wurzelverzeichnis</option>';
	}
	for ($i=1; isset($ary[$i]['id']); $i++)
	{
		$x = '';
		for ($j=0; $j<=$einzug; $j++) $x .= '-- ';
		$y = '';
		if ($auszuwaehlen == $ary[$i]['id']) $y = ' selected';
		echo '<option value="'.$ary[$i]['id'].'"'.$y.'>'.$x.$ary[$i]['name'].'</option>';
		gfx_zeichneordnerbox($modul, $ary[$i]['id'], $einzug+1, $auszuwaehlen, $ausschluss);
	}
	if ($einzug == 0) echo '</select>';
}

function gfx_zeichneordner($modul, $table, $append, $dir = 0, $einzug = 0)
{
	global $ordnereinzug, $WBConfig;

	$ary = liste_ordner($modul, $dir);
	$durchlauf = 0;
	for ($i=1; isset($ary[$i]['id']); $i++)
	{
		$durchlauf++;
		if (file_exists('modules/user_folders/includes/menuentry.inc.php'))
		{
			include 'modules/user_folders/includes/menuentry.inc.php';
		}
		echo "\n";
		gfx_zeichneordner($modul, $table, $append, $ary[$i]['id'], $einzug+1);
		$durchlauf += wb_draw_item($modul, $table, $append, $ary[$i]['id'], $einzug+1);
	}

	if ($einzug == 0)
	{
		$durchlauf += wb_draw_item($modul, $table, $append, $dir);
		if ($durchlauf == 0)
		wb_draw_table_content('100%', 'Es sind keine Elemente in dieser Sektion vorhanden.', '', '', '', '', '', '');
	}
}

function liste_ordner($modul, $dir = 0, $ausschluss = 0)
{
	global $benutzer, $WBConfig;
	$i = 0;

	if (!isset($erg)) $erg = array();

	$res = db_query("SELECT * FROM `".$WBConfig->getMySQLPrefix()."folders` WHERE `folder_cnid` = '".db_escape($dir)."' AND `category` = '".db_escape($modul)."' AND `user_cnid` = '".$benutzer['id']."' ORDER BY `name` ASC");
	while ($row = db_fetch($res))
	{
		if (($ausschluss == 0) || (($ausschluss != 0) && ($row['id'] != $ausschluss)))
		{
			$i++;
			$erg[$i] = $row;
		}
	}

	return $erg;
}

$ordnereinzug = 23;

?>