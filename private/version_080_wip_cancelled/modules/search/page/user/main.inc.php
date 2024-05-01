<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

	echo str_replace('<body', '<body onload="self.focus();document.getElementById(\'suchbegriff\').focus();"', $header);


echo '<h1>'.htmlentities($module_information->caption).'</h1>';

	if (!isset($suchbegriff)) $suchbegriff = '';

	echo 'Hier k&ouml;nnen Sie Ihre Personal WebBase-Datenbank durchsuchen.
	Bitte beachten Sie, dass nur Datenbankeintr&auml;ge von Modulen gefunden werden
	k&ouml;nnen, die von den Entwicklern mit einer Suchschnittstelle ausgestattet wurden.
	Es werden in der Regel nur die Datens&auml;tze durchsucht, keine Systeme von Drittanbietern
	(z.B. Posteinfach oder Inhalte von Datenbanken/FTP-Servern etc).<br><br>

<form method="POST" name="mainform" action="'.$_SERVER['PHP_SELF'].'">
<input type="hidden" name="seite" value="'.$seite.'">
<input type="hidden" name="modul" value="'.$modul.'">
Suchbegriff:<br><input type="text" name="suchbegriff" value="'.$suchbegriff.'" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" size="50">
<input type="submit" class="button" onmouseover="this.className=\'button_act\';" onmouseout="this.className=\'button\';" value="Suchen">
</form>';

	if ($suchbegriff != '')
	{
		echo '<b>Suchergebnisse f&uuml;r &quot;'.$suchbegriff.'&quot;:</b><br><br>';
		wb_draw_table_begin();
		$etwas_gefunden = false;
		wb_draw_table_content('30', '', '', '<b>Modul</b>', '', '<b>ID</b>', '', '<b>Titel</b>', '', '', '', '');
		$res = db_query("SELECT `module`, `table` FROM `".$WBConfig->getMySQLPrefix()."modules` WHERE `is_searchable` = '1'");
		while ($row = db_fetch($res))
		{
			$module_information = WBModuleHandler::get_module_information($row['module']);

			$module_information->caption_a = $module_information->caption;

			if (($wb_user_type >= $module_information->rights) && ((file_exists('modules/'.$row['module'].'/page/edit.inc.php')) || (file_exists('modules/'.$row['module'].'/page/view.inc.php'))))
			{
				$que = generate_search_query($row['table'], 0, $suchbegriff);
				$res2 = db_query($que);

				while ($row2 = db_fetch($res2))
				{
					if (isset($tables_database[$WBConfig->getMySQLPrefix().$row['table']]['name']))
					{
						$res3 = db_query("SELECT `name` FROM `".$WBConfig->getMySQLPrefix().db_escape($row['table'])."` WHERE `id` = '".$row2['id']."'");
						$row3 = db_fetch($res3);
						if ($row3['name'] != '')
							$titel = $row3['name'];
						else
							$titel = '<i>Keine Angabe</i>';
					}
					else
						$titel = '<i>Keine Modulbetitelung</i>';

					$etwas_gefunden = true;

					if (file_exists('modules/'.$row['module'].'/images/menu/32.gif'))
						$g = 'modules/'.$row['module'].'/images/menu/32.gif';
					else if (file_exists('modules/'.$row['module'].'/images/menu/32.png'))
						$g = 'modules/'.$row['module'].'/images/menu/32.png';
					else
						$g = 'designs/spacer.gif';

					if (file_exists('modules/'.$row['module'].'/images/menu/16.gif'))
						$k = 'modules/'.$row['module'].'/images/menu/16.gif';
					else if (file_exists('modules/'.$row['module'].'/images/menu/16.png'))
						$k = 'modules/'.$row['module'].'/images/menu/16.png';
					else
					{
						if (file_exists('modules/'.$modul.'/item.gif'))
							$k = 'modules/'.$modul.'/item.gif';
						else if (file_exists('modules/'.$modul.'/item.png'))
							$k = 'modules/'.$modul.'/item.png';
						else
							$k = 'designs/spacer.gif';
					}

					$a = '';
					$b = '';

					if ($row['module'] == 'user_folders')
					{
						$res4 = db_query("SELECT `category` FROM `".$WBConfig->getMySQLPrefix()."folders` WHERE `id` = '".$row2['id']."'");
						$row4 = db_fetch($res4);

						$module_information = WBModuleHandler::get_module_information($row4['category']);

						$module_information->caption_b = $module_information->caption;

						if (file_exists('modules/'.$row4['category'].'/page/main.inc.php'))
							$a = '<a href="javascript:oop2(\''.$_SERVER['PHP_SELF'].'?seite=main&amp;modul='.$row4['category'].'#folder'.$row2['id'].'\', \''.$module_information->caption_a.'\', \''.$g.'\');" class="menu">&Ouml;ffnen</a>';

						if (file_exists('modules/'.$row4['category'].'/page/main.inc.php'))
							$c = '<a href="'.oop_link_to_modul($row4['category']).'" class="menu">'.$module_information->caption_b.'</a> ('.$module_information->caption_a.')';
						else
							$c = $module_information->caption_b.' ('.$module_information->caption_a.')';
					}
					else
					{
						if (file_exists('modules/'.$row['module'].'/page/view.inc.php'))
							$a = '<a href="javascript:oop2(\''.$_SERVER['PHP_SELF'].'?seite=view&amp;modul='.$row['module'].'&amp;id='.$row2['id'].'\', \''.$module_information->caption_a.'\', \''.$g.'\');" class="menu">&Ouml;ffnen</a>';

						if (file_exists('modules/'.$row['module'].'/page/edit.inc.php'))
							$b = '<a href="javascript:oop2(\''.$_SERVER['PHP_SELF'].'?seite=edit&amp;modul='.$row['module'].'&amp;aktion=edit&amp;id='.$row2['id'].'\', \''.$module_information->caption_a.'\', \''.$g.'\');" class="menu">Bearbeiten</a>';

						if (file_exists('modules/'.$row['module'].'/page/main.inc.php'))
							$c = '<a href="'.oop_link_to_modul($row['module']).'" class="menu">'.$module_information->caption_a.'</a>';
						else
							$c = $module_information->caption_a;
					}

					wb_draw_table_content('', '<img src="'.$k.'" alt="" width="16" height="16">', '', $c, '', $row2['id'], '', $titel, '100', $a, '100', $b);
				}
			}
		}
		if (!$etwas_gefunden)
			wb_draw_table_content('', 'Kein Datensatz gefunden!', '', '', '', '', '', '', '', '', '', '');
		wb_draw_table_end();
	}

	echo $footer;

?>