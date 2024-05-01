<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

if ($aktion == 'change_configuration')
{
	wb_change_config('internet-check-url', db_escape($internet_check_url), $modul);
	if ((isset($internet-check-port)) && (is_numeric($internet-check-port)))
		wb_change_config('internet-check-port', db_escape($internet_check_port), $modul);

	if (!isset($vonmodul)) $vonmodul = 'admin_configuration';
	if (!isset($vonseite)) $vonseite = 'main';

	$check = inetconn_ok();

	if ($check)
		wb_redirect_now($_SERVER['PHP_SELF'].'?seite='.$vonseite.'&modul='.$vonmodul);
	else
		wb_redirect_now($_SERVER['PHP_SELF'].'?seite=config&modul='.$modul.'&vonseite='.$vonseite.'&vonmodul='.$vonmodul);
}

?>