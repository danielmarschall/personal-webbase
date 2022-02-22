<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

if ($ib_user_type < 2) die('Keine Zugriffsberechtigung');

  if ($aktion == 'changekonfig')
  {
    ib_change_config('ftp-server', db_escape($ftpserver), $modul);
    ib_change_config('ftp-username', db_escape($ftpuser), $modul);
    ib_change_config('ftp-passwort', db_escape($ftppassword), $modul);
    ib_change_config('ftp-verzeichnis', db_escape($ftpverzeichnis), $modul);
    if ((isset($ftpport)) && (is_numeric($ftpport)))
      ib_change_config('ftp-port', db_escape($ftpport), $modul);

    if (!isset($vonmodul)) $vonmodul = 'admin_konfig';
    if (!isset($vonseite)) $vonseite = 'inhalt';

    if ((isset($zwischenspeichern)) && ($zwischenspeichern == '1'))
    {
      if (!headers_sent()) header('location: '.$_SERVER['PHP_SELF'].'?seite=konfig&modul='.urlencode($modul).'&vonmodul='.urlencode($vonmodul).'&vonseite='.urlencode($vonseite));
    }
    else
    {
      if (!headers_sent()) header('location: '.$_SERVER['PHP_SELF'].'?seite='.urlencode($vonseite).'&modul='.urlencode($vonmodul));
    }
  }

?>
