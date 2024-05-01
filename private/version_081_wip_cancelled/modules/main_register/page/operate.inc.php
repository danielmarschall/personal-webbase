<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

if ($wb_user_type < 2) die('Keine Zugriffsberechtigung');

if ($aktion == 'change_configuration')
{
	if ((!isset($allowuserreg)) || (($allowuserreg == '') || (($allowuserreg != '') && ($allowuserreg != '1')))) $allowuserreg = 0;

	wb_change_config('enable_userreg', $allowuserreg, $modul);
	if ((isset($sperrdauer)) && (is_numeric($sperrdauer)))
		wb_change_config('sperrdauer', $sperrdauer, $modul);

	if (!isset($vonmodul)) $vonmodul = 'admin_configuration';
	if (!isset($vonseite)) $vonseite = 'main';

	wb_redirect_now($_SERVER['PHP_SELF'].'?seite='.$vonseite.'&modul='.$vonmodul);
}

?>