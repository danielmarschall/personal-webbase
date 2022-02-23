<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

if ($ib_user_type < 2) die('Keine Zugriffsberechtigung');

  if ($aktion == 'edit')
  {
    ib_change_config(db_escape($name), db_escape($wert), db_escape($kmodul));
    if (!headers_sent()) header('location: '.$_SERVER['PHP_SELF'].'?modul='.urlencode($modul).'&seite=konfig');
  }

  if ($aktion == 'delete')
  {
    db_query("DELETE FROM `".$mysql_zugangsdaten['praefix']."konfig` WHERE `id` = '".db_escape($id)."'");
    if (!headers_sent()) header('location: '.$_SERVER['PHP_SELF'].'?modul='.urlencode($modul).'&seite=konfig');
  }

?>
