<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

echo $header;

echo '<h1>'.wb_htmlentities($module_information->caption).'</h1>';

echo '<table cellspacing="0" cellpadding="0" border="0" width="100%">';

foreach ($modules as $m1 => $m2)
{
	if (file_exists('modules/'.$m2.'/crossover/'.$modul.'/main.inc.php'))
	{
		echo '<tr>';

		echo '<td align="center" valign="top">';

		if (file_exists('modules/'.$m2.'/images/menu/32.gif'))
			echo '<img src="modules/'.$m2.'/images/menu/32.gif" alt="" width="32" height="32">';
		else if (file_exists('modules/'.$m2.'/images/menu/32.png'))
			echo '<img src="modules/'.$m2.'/images/menu/32.png" alt="" width="32" height="32">';
		else
			echo '<img src="designs/spacer.gif" alt="" width="32" height="32">';

		echo '</td><td><img src="designs/spacer.gif" alt="" width="10" height="1"></td><td width="100%" valign="top" align="left">';

		$module_information = get_module_information($m2);

		$meldung = '';
		include 'modules/'.$m2.'/crossover/'.$modul.'/main.inc.php';
		if ($meldung == '')
			echo '<b>'.$m2.'</b> gab keine R&uuml;ckmeldung.';
		else
			echo '<b>'.$m2.'</b> hat folgende Nachricht zur&uuml;ckgegeben:<br><br>'.$meldung;

		echo '</td></tr><tr><td colspan="3">&nbsp;</td></tr>';
	}
}

unset($m1);
unset($m2);

echo '<tr><td colspan="3">Der Systemcheck ist beendet.</td></tr></table>';

echo $footer;

?>