<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

	if (function_exists('show_modul_search'))
		echo str_replace('<body', '<body onload="self.focus();document.getElementById(\'suchbegriff\').focus();"', $header);
	else
		echo $header;

	

	if ((!isset($onlyupdates)) || (!$onlyupdates))
	{
		echo '<h1>'.htmlentities($module_information->caption).'</h1>';

		if (function_exists('show_modul_search')) show_modul_search($modul, $seite);

		wb_draw_table_begin();

		// wb_draw_table_content('', '<b>Name</b>', '', '<b>Aktionen</b>', '', '', '', '');
		gfx_zeichneordner($modul, $WBConfig->getMySQLPrefix().'links', 'ORDER BY `name`');
		wb_draw_table_end();
		echo '<a href="'.$_SERVER['PHP_SELF'].'?seite=edit&amp;modul='.$modul.'&amp;aktion=new">Einen neuen Link hinzuf&uuml;gen</a>';
		echo '<br><a href="'.$_SERVER['PHP_SELF'].'?seite=edit&amp;modul=user_folders&amp;aktion=new&amp;category='.$modul.'">Einen neuen Ordner hinzuf&uuml;gen</a>';
	}
	else
	{
		echo '<h1>'.htmlentities($module_information->caption).' (nur Updates)</h1>';
		wb_draw_table_begin();

		// wb_draw_table_content('', '<b>Name</b>', '', '<b>Aktionen</b>', '', '', '', '');
		wb_draw_item_filter($modul, $WBConfig->getMySQLPrefix().'links', "WHERE `update_enabled` = '1' AND `user_cnid` = '".$benutzer['id']."' ORDER BY `name`");
		wb_draw_table_end();
	}

	echo $footer;

?>