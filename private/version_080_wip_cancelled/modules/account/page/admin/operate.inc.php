<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

if ($aktion == 'change_configuration')
{
	if ((!isset($userselfdel)) || (($userselfdel == '') || (($userselfdel != '') && ($userselfdel != '1')))) $userselfdel = 0;

	wb_change_config('allow_user_selfdelete', $userselfdel, $modul);

	if (!isset($vonmodul)) $vonmodul = 'admin_configuration';
	if (!isset($vonseite)) $vonseite = 'main';

	wb_redirect_now($_SERVER['PHP_SELF'].'?seite='.$vonseite.'&modul='.$vonmodul);
}

?>