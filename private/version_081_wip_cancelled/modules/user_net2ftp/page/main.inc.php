<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

if (function_exists('show_modul_search'))
	echo str_replace('<body', '<body onload="self.focus();document.getElementById(\'suchbegriff\').focus();"', $header);
else
	echo $header;


echo '<h1>'.wb_htmlentities($module_information->caption).'</h1>';

if (decoct(@fileperms('modules/'.$modul.'/system/temp/')) != 40777)
	echo '<p><span class="red"><b>Die Funktionalit&auml;t dieses Modules k&ouml;nnte beeintr&auml;chtigt sein, da der Administrator folgendes Verzeichnis nicht schreibbar (CHMOD 0777) gemacht hat:</b><br>modules/'.$modul.'/system/temp/</span></p>';

if (function_exists('show_modul_search')) show_modul_search($modul, $seite);

wb_draw_table_begin();

// wb_draw_table_content('', '<b>Name</b>', '', '<b>Aktionen</b>', '', '', '', '');
gfx_zeichneordner($modul, $WBConfig->getMySQLPrefix().'net2ftp', 'ORDER BY id');
wb_draw_table_end();
echo '<a href="'.$_SERVER['PHP_SELF'].'?seite=edit&amp;modul='.$modul.'&amp;aktion=new">Einen neues Konto hinzuf&uuml;gen</a>';
echo '<br><a href="'.$_SERVER['PHP_SELF'].'?seite=edit&amp;modul=user_folders&amp;aktion=new&amp;category='.$modul.'">Einen neuen Ordner hinzuf&uuml;gen</a>';

echo '<br><br>Es wird folgende Websoftware verwendet: ';
if (file_exists('modules/'.$modul.'/system/_wbver.inc.php'))
{
	include('modules/'.$modul.'/system/_wbver.inc.php');
}
else
{
	echo '<span class="red">modules/'.$modul.'/system/_wbver.inc.php wurde nicht gefunden!</span>';
}
echo '<br><br>';

echo $footer;

?>