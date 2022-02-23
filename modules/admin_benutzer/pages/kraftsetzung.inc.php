<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

  if ($aktion == 'lock')
  {
    $res = db_query("SELECT `gesperrt` FROM `".$mysql_zugangsdaten['praefix']."users` WHERE `id` = '".db_escape($id)."'");
    $row = db_fetch($res);

    if ($row['gesperrt'] == '1')
      db_query("UPDATE `".$mysql_zugangsdaten['praefix']."users` SET `gesperrt` = '0' WHERE `id` = '".db_escape($id)."'");
    else
      db_query("UPDATE `".$mysql_zugangsdaten['praefix']."users` SET `gesperrt` = '1' WHERE `id` = '".db_escape($id)."'");

    if (!headers_sent()) header('location: '.$_SERVER['PHP_SELF'].'?modul='.urlencode($modul).'&seite=inhalt');
  }

  if ($aktion == 'edit')
  {
    if ($f_gesperrt)
      $f_gesp = '1';
    else
      $f_gesp = '0';
    db_query("UPDATE `".$mysql_zugangsdaten['praefix']."users` SET `username` = '".db_escape($f_username)."', `personenname` = '".db_escape($f_personenname)."', `gesperrt` = '".db_escape($f_gesp)."', `email` = '".db_escape($f_email)."' WHERE `id` = '".db_escape($id)."'");
    if ($f_neupwd) db_query("UPDATE `".$mysql_zugangsdaten['praefix']."users` SET `passwort` = '".md5($f_passwort)."' WHERE `id` = '".db_escape($id)."'"); // TODO: use sha3 hash, salted and peppered

    if (!headers_sent()) header('location: '.$_SERVER['PHP_SELF'].'?modul='.urlencode($modul).'&seite=inhalt');
  }

  if ($aktion == 'del')
  {
    db_query("DELETE FROM `".$mysql_zugangsdaten['praefix']."users` WHERE `id` = '".db_escape($id)."'");
    if (db_affected_rows() > 0)
      db_query("OPTIMIZE TABLE `".$mysql_zugangsdaten['praefix']."users`");

    if (!headers_sent()) header('location: '.$_SERVER['PHP_SELF'].'?modul='.urlencode($modul).'&seite=inhalt');
  }

?>
