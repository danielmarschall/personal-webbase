<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

if ($aktion == 'change_configuration')
{
	if ((!isset($gastaktivierung)) || (($gastaktivierung == '') || (($gastaktivierung != '') && ($gastaktivierung != '1')))) $gastaktivierung = 0;
	if ((!isset($wipe_gastkonto)) || (($wipe_gastkonto == '') || (($wipe_gastkonto != '') && ($wipe_gastkonto != '1')))) $wipe_gastkonto = 0;

	wb_change_config('enable_gast', $gastaktivierung, $modul);
	wb_change_config('gast_username', $gastuser, $modul);
	wb_change_config('gast_password', $gastpassword, $modul);
	wb_change_config('wipe_gastkonto', $wipe_gastkonto, $modul);

	if ((isset($wipe_uhrzeit1)) && (is_numeric($wipe_uhrzeit1)) && (isset($wipe_uhrzeit2)) && (is_numeric($wipe_uhrzeit2)) && (isset($wipe_uhrzeit3)) && (is_numeric($wipe_uhrzeit3)))
	{
		if (($wipe_uhrzeit1 >= 0) && ($wipe_uhrzeit1 <= 24) && ($wipe_uhrzeit2 >= 0) && ($wipe_uhrzeit2 <= 60) && ($wipe_uhrzeit3 >= 0) && ($wipe_uhrzeit3 <= 60))
		{
			if (strlen($wipe_uhrzeit1) == 1) $wipe_uhrzeit1 = '0'.$wipe_uhrzeit1;
			if (strlen($wipe_uhrzeit2) == 1) $wipe_uhrzeit2 = '0'.$wipe_uhrzeit2;
			if (strlen($wipe_uhrzeit3) == 1) $wipe_uhrzeit3 = '0'.$wipe_uhrzeit3;

			$wipe_uhrzeit = $wipe_uhrzeit1.':'.$wipe_uhrzeit2.':'.$wipe_uhrzeit3;

			wb_change_config('wipe_uhrzeit', $wipe_uhrzeit, $modul);
		}
	}

	if (!isset($vonmodul)) $vonmodul = 'admin_configuration';
	if (!isset($vonseite)) $vonseite = 'main';

	wb_redirect_now($_SERVER['PHP_SELF'].'?seite='.$vonseite.'&modul='.$vonmodul);
}

?>