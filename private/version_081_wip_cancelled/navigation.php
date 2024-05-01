<?php

require 'includes/main.inc.php';
require 'includes/modulinit.inc.php';

echo $header_navi;

?><table cellspacing="0" cellpadding="2" border="0" width="100%" style="height:100%">
<tr class="area_bar">
	<td valign="middle" align="center" colspan="5">

	<b><?php

$ueberschrift = '';
$menue = '';

if (!isset($prv_seite)) $prv_seite = 'main';

if ($ueberschrift != '')
{
	echo $ueberschrift;
}
else
{
	if ($wb_user_type == '0')
		echo 'Gastzugang';
	else if ($wb_user_type == '1')
		echo 'Benutzermen&uuml;';
	else if ($wb_user_type == '2')
		echo 'Verwaltung';
	else
		echo 'Hauptmen&uuml;';
}

	?></b><img src="designs/spacer.gif" alt="" width="1" height="14"></td>
</tr>

<?php

echo wb_draw_menu_spacer();

$startgefunden = false;
if ($menue == '')
{
	// Wenn Sek-Pos nicht gegeben, nach Überschrift sortieren
	$sort_by_captions = array();
	foreach ($modules as $m1 => $m2)
	{
		$module_information = get_module_information($m2);
		$sort_by_captions[$m2] = $module_information->caption;
	}
	unset($m1);
	unset($m2);
	asort($sort_by_captions);

	// Nun einzelne Einträge abgehen
	$men = array();
	foreach ($sort_by_captions as $m1 => $m2)
	{
		$module_information = get_module_information($m1);

		if (((($wb_user_type == 0) || ($wb_user_type == 1)) && ($module_information->rights == 0)) || ($wb_user_type == $module_information->rights))
		{
			if (($module_information->menu_visible) && (file_exists('modules/'.$m1.'/page/main.inc.php')))
			{
				if (file_exists('modules/'.$m1.'/images/menu/32.gif'))
					$g = 'modules/'.$m1.'/images/menu/32.gif';
				else if (file_exists('modules/'.$m1.'/images/menu/32.png'))
					$g = 'modules/'.$m1.'/images/menu/32.png';
				else
					$g = 'designs/spacer.gif';

				if (file_exists('modules/'.$m1.'/images/menu/16.gif'))
					$k = 'modules/'.$m1.'/images/menu/16.gif';
				else if (file_exists('modules/'.$m1.'/images/menu/16.png'))
					$k = 'modules/'.$m1.'/images/menu/16.png';
				else
					$k = 'designs/spacer.gif';

				if (!isset($men[$module_information->primary_position][$module_information->secondary_position])) $men[$module_information->primary_position][$module_information->secondary_position] = '';
				$men[$module_information->primary_position][$module_information->secondary_position] .= wb_draw_menu_item($m1, 'main', wb_htmlentities($module_information->caption), $k, $g);
			}
			if (isset($prv_modul) && ($m1 == $prv_modul) && (file_exists('modules/'.$m1.'/page/main.inc.php')))
			{
				if (file_exists('modules/'.$m1.'/images/menu/32.gif'))
					$g = 'modules/'.$m1.'/images/menu/32.gif';
				else if (file_exists('modules/'.$m1.'/images/menu/32.png'))
					$g = 'modules/'.$m1.'/images/menu/32.png';
				else
					$g = 'designs/spacer.gif';

				$endjs = '<script language="JavaScript" type="text/javascript">
				<!--
					oop(\''.$m1.'\', \''.$prv_seite.'\', \''.wb_htmlentities($module_information->caption).'\', \''.$g.'\');
				// -->
</script>'."\n\n";
				$startgefunden = true;
			}
			else
			{
				if (($module_information->primary_position == 0) && ($module_information->secondary_position == 0) && (!$startgefunden) && (file_exists('modules/'.$m1.'/page/main.inc.php')))
				{
					if (file_exists('modules/'.$m1.'/images/menu/32.gif'))
						$g = 'modules/'.$m1.'/images/menu/32.gif';
					else if (file_exists('modules/'.$m1.'/images/menu/32.png'))
						$g = 'modules/'.$m1.'/images/menu/32.png';
					else
						$g = 'designs/spacer.gif';

					$endjs = '<script language="JavaScript" type="text/javascript">
				<!--
					oop(\''.$m1.'\', \'main\', \''.wb_htmlentities($module_information->caption).'\', \''.$g.'\');
				// -->
</script>'."\n\n";
					$startgefunden = true;
				}
			}
		}
	}
	unset($m1);
	unset($m2);

	$first = true;
	ksort($men);
	foreach ($men as $m1 => $m2)
	{
		if ($first)
			$first = false;
		else
			echo wb_draw_menu_spacer();
		ksort($men[$m1]);
		foreach ($men[$m1] as $x1 => $x2)
			echo $x2;
	}

	unset($m1);
	unset($m2);
}
else
{
	echo $menue;
}

?>

<tr>
	<td colspan="5" height="100%"><img src="designs/spacer.gif" alt="" width="1" height="1"></td>
</tr>
</table>

<?php

echo $endjs;

echo $footer;

?>
