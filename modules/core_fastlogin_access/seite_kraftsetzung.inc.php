<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne IronBASE ausgef&uuml;hrt werden.');

if ($ib_user_type < 2) die('Keine Zugriffsberechtigung');

  if ($aktion == 'changekonfig')
  {
    if ((!isset($sa_enabled)) || (($sa_enabled == '') || (($sa_enabled != '') && ($sa_enabled != '1')))) $sa_enabled = 0;

    ib_change_config('enabled', $sa_enabled, $modul);

    if (!isset($vonmodul)) $vonmodul = 'admin_konfig';
    if (!isset($vonseite)) $vonseite = 'inhalt';

    if (!headers_sent()) header('location: '.$_SERVER['PHP_SELF'].'?seite='.$vonseite.'&modul='.$vonmodul);
  }

?>