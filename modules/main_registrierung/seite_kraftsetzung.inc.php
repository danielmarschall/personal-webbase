<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

if ($ib_user_type < 2) die('Keine Zugriffsberechtigung');

  if ($aktion == 'changekonfig')
  {
    if ((!isset($allowuserreg)) || (($allowuserreg == '') || (($allowuserreg != '') && ($allowuserreg != '1')))) $allowuserreg = 0;

    ib_change_config('enable_userreg', $allowuserreg, $modul);
    if ((isset($sperrdauer)) && (is_numeric($sperrdauer)))
      ib_change_config('sperrdauer', $sperrdauer, $modul);

    if (!isset($vonmodul)) $vonmodul = 'admin_konfig';
    if (!isset($vonseite)) $vonseite = 'inhalt';

    if (!headers_sent()) header('location: '.$_SERVER['PHP_SELF'].'?seite='.$vonseite.'&modul='.$vonmodul);
  }

?>
