<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

if ($wb_user_type < 2) die('Keine Zugriffsberechtigung');

    if ($aktion == 'changekonfig')
    {
      ib_change_config('internet-check-url', db_escape($internet_check_url), $modul);
      if (isset($internet_check_port) && is_numeric($internet_check_port))
        ib_change_config('internet-check-port', db_escape($internet_check_port), $modul);

      if (!isset($vonmodul)) $vonmodul = 'admin_konfig';
      if (!isset($vonseite)) $vonseite = 'inhalt';

      $check = inetconn_ok();

      if (!headers_sent())
      {
        if ($check)
          header('location: '.$_SERVER['PHP_SELF'].'?seite='.urlencode($vonseite).'&modul='.urlencode($vonmodul));
        else
          header('location: '.$_SERVER['PHP_SELF'].'?seite=konfig&modul='.urlencode($modul).'&vonseite='.urlencode($vonseite).'&vonmodul='.urlencode($vonmodul));
      }
    }

?>
