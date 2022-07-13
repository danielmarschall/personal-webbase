<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

if ($wb_user_type < 2) die('Keine Zugriffsberechtigung');

  if ($aktion == 'changekonfig')
  {
    ib_change_config('admin_mail', db_escape($admin_mail), $modul);

  if (!isset($vonmodul)) $vonmodul = 'admin_konfig';
  if (!isset($vonseite)) $vonseite = 'inhalt';

    if (!headers_sent()) header('location: '.$_SERVER['PHP_SELF'].'?seite='.urlencode($vonseite).'&modul='.urlencode($vonmodul));
  }

?>
