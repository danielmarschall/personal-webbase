<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

echo $header;

echo '<h1>'.htmlentities($module_information->caption).'</h1>';
echo 'Hier sind alle Datenbanken der Module aufgelistet.<br><br>';

wb_draw_table_begin();
$res = db_query("SELECT * FROM `".$WBConfig->getMySQLPrefix()."modules` ORDER BY `id`");
wb_draw_table_content('', '<b>Tabellenname</b>', '', '<b>Modul</b>', '', '<b>Datens&auml;tze</b>', '', '<b>Aktionen</b>');
while ($row = db_fetch($res))
{
	if (isset($only) && ($row['module'] == $only))
	{
		$s1 = '<span class="red">';
		$s2 = '</span>';
	}
	else
	{
		$s1 = '';
		$s2 = '';
	}
	$ars = db_query("SELECT COUNT(*) AS `ct` FROM `".$WBConfig->getMySQLPrefix().$row['table']."`");
	$arw = db_fetch($ars);
	if (!is_dir('modules/'.$row['module']))
	{
		$z = ' (Nicht mehr installiert)';
		$x = 'Tabelle entfernen';
	}
	else
	{
		$z = '';
		$x = 'Tabelle neu anlegen';
	}
	wb_draw_table_content('', $s1.$WBConfig->getMySQLPrefix().$row['table'].$s2, '', $s1.$row['module'].$z.$s2, '', $s1.$arw['ct'].$s2, '', '<a href="javascript:abfrage(\''.$_SERVER['PHP_SELF'].'?seite=operate&amp;modul='.$modul.'&amp;aktion=delete&amp;id='.$row['id'].'\');" class="menu">'.$x.'</a>');
}
wb_draw_table_end();

echo '<b>Schnittstellen</b><ul>';
$welchegefunden = false;
foreach ($modules as $m1 => $m2)
{
	$module_information = WBModuleHandler::get_module_information($m2);

	// Nun die Modulcrons laden
	if (file_exists('modules/'.$m2.'/crossover/'.$modul.'/main.inc.php'))
	{
		include('modules/'.$m2.'/crossover/'.$modul.'/main.inc.php');
		$welchegefunden = true;
	}
}

unset($m1);
unset($m2);

if (!$welchegefunden)
	echo '<li>Keine gefunden!</li>';
echo '</ul>';

if ((isset($vonmodul)) && (isset($vonseite)) && ($vonmodul != '') && ($vonseite != ''))
	echo '<input type="button" onclick="document.location.href=\''.$_SERVER['PHP_SELF'].'?modul='.$vonmodul.'&amp;seite='.$vonseite.'\';" class="button" onmouseover="this.className=\'button_act\';" onmouseout="this.className=\'button\';" value="Zur&uuml;ck">';

echo '<br>';

echo $footer;

?>