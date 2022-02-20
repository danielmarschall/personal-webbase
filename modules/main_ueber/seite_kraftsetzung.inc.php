<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne IronBASE ausgef&uuml;hrt werden.');

if ($ib_user_type < 2) die('Keine Zugriffsberechtigung');

  if ($aktion == 'changekonfig')
  {
    ib_change_config('admin_mail', db_escape($admin_mail), $modul);

  if (!isset($vonmodul)) $vonmodul = 'admin_konfig';
  if (!isset($vonseite)) $vonseite = 'inhalt';

    if (!headers_sent()) header('location: '.$_SERVER['PHP_SELF'].'?seite='.$vonseite.'&modul='.$vonmodul);
  }

?>