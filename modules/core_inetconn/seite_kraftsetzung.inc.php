<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne IronBASE ausgef&uuml;hrt werden.');

if ($ib_user_type < 2) die('Keine Zugriffsberechtigung');

    if ($aktion == 'changekonfig')
    {
      ib_change_config('internet-check-url', db_escape($internet_check_url), $modul);
      if ((isset($internet-check-port)) && (is_numeric($internet-check-port)))
        ib_change_config('internet-check-port', db_escape($internet_check_port), $modul);

      if (!isset($vonmodul)) $vonmodul = 'admin_konfig';
      if (!isset($vonseite)) $vonseite = 'inhalt';

      $check = inetconn_ok();

      if (!headers_sent())
      {
        if ($check)
          header('location: '.$_SERVER['PHP_SELF'].'?seite='.$vonseite.'&modul='.$vonmodul);
        else
          header('location: '.$_SERVER['PHP_SELF'].'?seite=konfig&modul='.$modul.'&vonseite='.$vonseite.'&vonmodul='.$vonmodul);
      }
    }

?>