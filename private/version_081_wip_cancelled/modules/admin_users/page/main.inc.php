<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

	echo $header;

		
		echo '<h1>'.wb_htmlentities($module_information->caption).'</h1>';
		echo 'Hier sind alle Benutzer aufgelistet.<br><br>';

		wb_draw_table_begin();
		wb_draw_table_content('', '<b>Benutzername</b>', '', '<b>E-Mail-Adresse</b>', '100', '<b>Datens&auml;tze</b>', '100', '<b>Ordner</b>', '100', '<b>Aktionen</b>', '100', '', '100', '');

		$res = db_query("SELECT * FROM `".$WBConfig->getMySQLPrefix()."users` ORDER BY `id`");
		$eintrag = false;
		while ($row = db_fetch($res))
		{
			if (($configuration['main_guest_login']['enable_gast'] == '1') && ($row['username'] == $configuration['main_guest_login']['gast_username']) && ($row['password'] == md5($configuration['main_guest_login']['gast_password'])))
				$status = ' (Gast)';
			else
				$status = '';
			if ($row['banned'])
				$sperr = 'Entsperren';
			else
				$sperr = 'Sperren';

			$count_ds = 0;
			$count_o = 0;

			foreach ($tables_modules as $m1 => $m2)
			{
				if (isset($tables_database[$m1]['user_cnid']))
				{
					$res2 = db_query("SELECT COUNT(`id`) AS `cid` FROM `$m1` WHERE `user_cnid` = '".$row['id']."'");
					$row2 = db_fetch($res2);
					if ($m2 == 'folders')
						$count_o += $row2['cid'];
					else
						$count_ds += $row2['cid'];
				 }
			}

			unset($m1);
			unset($m2);

			if ($row['email'] != '')
				$maila = '<a href="mailto:'.$row['email'].'" class="menu">'.$row['email'].'</a>';
			else
				$maila = 'Unbekannt';

			wb_draw_table_content('', $row['username'].$status, '', $maila, '', $count_ds , '', $count_o, '', '<a href="'.$_SERVER['PHP_SELF'].'?modul='.$modul.'&amp;seite=operate&amp;aktion=lock&amp;id='.$row['id'].'" class="menu">'.$sperr.'</a>', '', '<a href="'.$_SERVER['PHP_SELF'].'?modul='.$modul.'&amp;seite=edit&amp;id='.$row['id'].'" class="menu">Bearbeiten</a>', '', '<a href="javascript:abfrage(\''.$_SERVER['PHP_SELF'].'?modul='.$modul.'&amp;seite=operate&amp;aktion=del&amp;id='.$row['id'].'\');" class="menu">L&ouml;schen</a>');

			$eintrag = true;
		}

		if (!$eintrag)
			wb_draw_table_content('', 'Keine Benutzer vorhanden!', '', '', '', '', '', '', '', '', '', '', '', '');
		wb_draw_table_end();

		echo $footer;

?>