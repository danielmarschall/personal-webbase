<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

if ($aktion == 'change_configuration')
{
	if ((!isset($enabledebug)) || (($enabledebug == '') || (($enabledebug != '') && ($enabledebug != '1')))) $enabledebug = 0;

	if (!isset($vonmodul)) $vonmodul = 'admin_configuration';
	if (!isset($vonseite)) $vonseite = 'main';

	if ($enabledebug)
		$enabledebug = '1';
	else
		$enabledebug = '0';

	wb_change_config('debug', $enabledebug, $modul);

	wb_redirect_now($_SERVER['PHP_SELF'].'?seite='.$vonseite.'&modul='.$vonmodul.'');
}

?>