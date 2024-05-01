<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

echo $header;

$my_str = '';
$res = db_query("SELECT `id` FROM `".$WBConfig->getMySQLPrefix()."users`");
while ($row = db_fetch($res))
	$my_str .= "'".$row['id']."', ";
$my_str = substr($my_str, 0, strlen($my_str)-2);

	$count_ds = 0;
	$count_o = 0;

	foreach ($tables_modules as $m1 => $m2)
	{
		if (($my_str != '') && (isset($tables_database[$m1]['user_cnid'])))
		{
			$res = db_query("SELECT COUNT(`id`) AS `cid` FROM `$m1` WHERE `user_cnid` IN ($my_str)");
			$row = db_fetch($res);
			if ($m2 == 'folders')
				$count_o += $row['cid'];
			else
				$count_ds += $row['cid'];
		}
	}

	unset($m1);
	unset($m2);

	echo '<h1>'.htmlentities($module_information->caption).'</h1>';

	echo '<span style="font-size:1.2em"><b>Serverdaten</b></span><br><br>';
	wb_draw_table_begin();
	wb_draw_table_content('40%', '<b>Anmeldeserver</b>', '60%', $WBConfig->getMySQLServer());

	if ($configuration['main_about']['admin_mail'] != '')
		$addr = '<a href="mailto:'.$configuration['main_about']['admin_mail'].'" class="menu">'.$configuration['main_about']['admin_mail'].'</a>';
	else
		$addr = 'Keine E-Mail-Adresse angegeben';

	wb_draw_table_content('40%', '<b>Administrator E-Mail-Adresse</b>', '60%', $addr.' (<a href="'.$_SERVER['PHP_SELF'].'?seite=config&amp;modul=main_about&amp;vonmodul='.$modul.'&amp;vonseite='.$seite.'" class="menu">&Auml;ndern</a>)');

	$db_time = db_time();

	if (date('Y-m-d H:i:s') != $db_time)
	{
		// Kann vorkommen, wenn MySQL-Server sich auf einem anderen System befindet
		wb_draw_table_content('40%', '<b>PHP-Zeit</b>', '60%', de_convertmysqldatetime(date('Y-m-d, H:i:s'), true));
		wb_draw_table_content('40%', '<b>MySQL-Zeit</b>', '60%', de_convertmysqldatetime($db_time, true));
	}
	else
	{
		wb_draw_table_content('40%', '<b>Serverzeit</b>', '60%', de_convertmysqldatetime(date('Y-m-d, H:i:s'), true));
	}

	wb_draw_table_end();

	echo '<span style="font-size:1.2em"><b>Datenbankstatistik</b></span><br><br>';
	wb_draw_table_begin();

	wb_draw_table_content('40%', '<b>Letzter Login</b>', '60%', de_convertmysqldatetime($_SESSION['last_login']));

	if ($_SESSION['last_login_ip'] == '')
		$ueip = 'Unbekannt';
	else
		$ueip = '<a href="'.ip_tracer($_SESSION['last_login_ip']).'" target="_blank" class="menu">'.$_SESSION['last_login_ip'].'</a> (DNS: '.@gethostbyaddr($_SESSION['last_login_ip']).')';

	wb_draw_table_content('40%', '<b>&Uuml;ber IP</b>', '60%', $ueip);
	wb_draw_table_content('40%', '<b>Benutzer-Datens&auml;tze der Datenbank</b>', '60%', $count_ds);
	wb_draw_table_content('40%', '<b>Benutzer-Ordner der Datenbank</b>', '60%', $count_o);
	wb_draw_table_content('40%', '<b>Installierte Module</b>', '60%', count($modules).' (<a href="'.oop_link_to_modul('admin_modules').'" class="menu">Verwalten</a>)');
	wb_draw_table_content('40%', '<b>Angelegte Tabellen</b>', '60%', count($tables_modules).' (<a href="'.oop_link_to_modul('admin_database').'" class="menu">Verwalten</a>)');
	wb_draw_table_end();

	echo '<span style="font-size:1.2em"><b>Installierte Module</b></span><br><br>';

	$i = -1;
	foreach ($modules as $m1 => $m2)
	{
		if (file_exists('modules/'.$m2.'/page/main.inc.php'))
		{
			$module_information = WBModuleHandler::get_module_information($m2);

			if (($module_information->rights == 2) && ($module_information->menu_visible) && ($modul != $m2))
			{
				$i++;

				if ($i == 0)
				echo '<center><table cellspacing="6" cellpadding="6" border="0" width="90%"><tr>';

				if (($i % 7 == 0) && ($i != 0))
				echo '</tr><tr>';

				echo '<td valign="middle" align="center" width="14%">';

				if (file_exists('modules/'.$m2.'/images/menu/32.gif'))
					$g = 'modules/'.$m2.'/images/menu/32.gif';
				else if (file_exists('modules/'.$m2.'/images/menu/32.png'))
					$g = 'modules/'.$m2.'/images/menu/32.png';
				else
					$g = 'designs/spacer.gif';

				echo '<a href="'.oop_link_to_modul($m2).'" class="menu">';
				echo '<img src="'.$g.'" border="0" width="32" height="32" alt="">';
				echo '<br>'.htmlentities($module_information->caption).'</a></td>';
			}
		}
	}

	unset($m1);
	unset($m2);

	if ($i > -1)
	{
		$i++;
		for (;$i%7<>0;$i++)
		{
			echo '<td valign="middle" align="center"><img src="designs/spacer.gif" width="32" height="32" alt=""></td>';
		}
		echo '</tr></table><br></center>';
	} else {
		echo 'Keine entsprechenden Module gefunden!<br><br>';
	}

	echo $footer;

?>