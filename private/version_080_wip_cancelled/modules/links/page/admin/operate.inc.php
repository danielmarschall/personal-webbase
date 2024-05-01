<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

if ($aktion == 'change_configuration')
{
	if ((isset($update_checkinterval_min)) && (is_numeric($update_checkinterval_min)))
		wb_change_config('update_checkinterval_min', db_escape($update_checkinterval_min), $modul);

	if ((isset($kaputt_checkinterval_min)) && (is_numeric($kaputt_checkinterval_min)))
		wb_change_config('kaputt_checkinterval_min', db_escape($kaputt_checkinterval_min), $modul);

	if (!isset($vonmodul)) $vonmodul = 'admin_configuration';
	if (!isset($vonseite)) $vonseite = 'main';

	wb_redirect_now($_SERVER['PHP_SELF'].'?seite='.$vonseite.'&modul='.$vonmodul);
}

?>