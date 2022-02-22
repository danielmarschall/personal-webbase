<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

if ($ib_user_type < 2) die('Keine Zugriffsberechtigung');

  if ($aktion == 'changekonfig')
  {
    if ((!isset($enabledebug)) || (($enabledebug == '') || (($enabledebug != '') && ($enabledebug != '1')))) $enabledebug = 0;

    if (!isset($vonmodul)) $vonmodul = 'admin_konfig';
    if (!isset($vonseite)) $vonseite = 'inhalt';

    if ($enabledebug)
      $enabledebug = '1';
    else
      $enabledebug = '0';

    ib_change_config('debug', $enabledebug, $modul);

    if (!headers_sent()) header('location: '.$_SERVER['PHP_SELF'].'?seite='.urlencode($vonseite).'&modul='.urlencode($vonmodul).'');
  }

?>
