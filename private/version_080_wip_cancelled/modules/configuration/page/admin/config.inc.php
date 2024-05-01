<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

echo $header;

if (!isset($vonmodul)) $vonmodul = $modul;
if (!isset($vonseite)) $vonseite = 'main';

echo '<h1>'.htmlentities($module_information->caption).'</h1>';
echo 'Hier k&ouml;nnen Sie Konfigurationen an Personal WebBase-Modulen manuell vornehmen. Dies wird jedoch nicht empfohlen, da auch Fehlkonfigurationen mit ung&uuml;ltigen Werten angenommen werden.<br><br>';

wb_draw_table_begin();
wb_draw_table_content('', '<b>Modul</b>', '', '<b>Eigenschaft</b>', '', '<b>Wert</b>', '', '<b>Aktionen</b>', '', '');
$res = db_query("SELECT `id`, `name`, `value`, `module` FROM `".$WBConfig->getMySQLPrefix()."configuration` ORDER BY `module` ASC, `name` ASC");
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
	if (is_dir('modules/'.$row['module']))
	{
		$z = '';
		$x = 'Standard herstellen';
	}
	else
	{
		$z = ' (Nicht mehr installiert)';
		$x = 'Wert entfernen';
	}
	wb_draw_table_content('', $s1.htmlentities($row['module']).$z.$s2, '',	$s1.htmlentities($row['name']).$s2, '', $s1.htmlentities($row['value']).$s2, '', '<a href="'.$_SERVER['PHP_SELF'].'?modul='.$modul.'&amp;seite=edit&amp;id='.$row['id'].'" class="menu">'.$s1.'Bearbeiten'.$s2.'</a>', '', '<a href="javascript:abfrage(\''.$_SERVER['PHP_SELF'].'?modul='.$modul.'&amp;seite=operate&amp;aktion=delete&amp;id='.$row['id'].'\');" class="menu">'.$s1.$x.$s2.'</a>');
}
wb_draw_table_end();

echo '<input type="button" onclick="document.location.href=\''.$_SERVER['PHP_SELF'].'?modul='.$vonmodul.'&amp;seite='.$vonseite.'\';" class="button" onmouseover="this.className=\'button_act\';" onmouseout="this.className=\'button\';" value="Zur&uuml;ck">';

echo $footer;

?>