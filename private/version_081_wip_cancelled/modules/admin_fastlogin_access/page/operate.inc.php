<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

if ($aktion == 'change_configuration')
{
	if ((!isset($sa_enabled)) || (($sa_enabled == '') || (($sa_enabled != '') && ($sa_enabled != '1')))) $sa_enabled = 0;

	wb_change_config('enabled', $sa_enabled, $modul);

	if (!isset($vonmodul)) $vonmodul = 'admin_configuration';
	if (!isset($vonseite)) $vonseite = 'main';

	wb_redirect_now($_SERVER['PHP_SELF'].'?seite='.$vonseite.'&modul='.$vonmodul);
}

?>