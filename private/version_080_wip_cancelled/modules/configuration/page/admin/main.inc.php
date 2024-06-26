<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

echo $header;

echo '<h1>'.htmlentities($module_information->caption).'</h1>';

echo 'Folgende Module enthalten eine designte Konfigurationsm&ouml;glichkeit:<br><br>';

$i = -1;
foreach ($modules as $m1 => $m2)
{
	if (file_exists('modules/'.$m2.'/page/config.inc.php'))
	{
		$module_information = WBModuleHandler::get_module_information($m2);
		$titel = $module_information->caption;

		$i++;

		if ($i == 0)
			echo '<center><table cellspacing="6" cellpadding="6" border="0"><tr>';

		if (($i % 5 == 0) && ($i != 0))
			echo '</tr><tr>';

		echo '<td valign="middle" align="center">';
		echo '<a href="'.$_SERVER['PHP_SELF'].'?seite=config&amp;modul='.$m2.'&amp;vonmodul='.$modul.'&amp;vonseite='.$seite.'" class="menu">';
		if (file_exists('modules/'.$m2.'/images/menu/32.gif'))
			echo '<img src="modules/'.$m2.'/images/menu/32.gif" border="0" width="32" height="32" alt="">';
		else if (file_exists('modules/'.$m2.'/images/menu/32.png'))
			echo '<img src="modules/'.$m2.'/images/menu/32.png" border="0" width="32" height="32" alt="">';
		else
			echo '<img src="designs/spacer.gif" border="0" width="32" height="32" alt="">';
		echo '<br>'.htmlentities($titel).'</a></td>';
	}
}

unset($m1);
unset($m2);

if ($i > -1)
{
	$i++;
	for (;$i%5<>0;$i++)
	{
		echo '<td valign="middle" align="center"><img src="designs/spacer.gif" width="32" height="32" alt=""></td>';
	}
	echo '</tr></table><br></center>';
}
else
{
	echo 'Keine entsprechenden Module gefunden!<br><br>';
}

echo $footer;

?>