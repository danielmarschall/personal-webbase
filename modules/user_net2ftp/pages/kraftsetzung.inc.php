<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

  if ($aktion == 'edit')
  {
    $res = db_query("SELECT `user` FROM `".$mysql_zugangsdaten['praefix']."ordner` WHERE `id` = '".db_escape($folder)."'");
    $row = db_fetch($res);
    if ($row['user'] != $benutzer['id'])
      $folder = 0;

    db_query("UPDATE `".$mysql_zugangsdaten['praefix']."net2ftp` SET `folder` = '".db_escape($folder)."', `server` = '".db_escape($fserver)."', `username` = '".db_escape($fusername)."', `passwort` = '".db_escape($fpasswort)."', `startverzeichnis` = '".db_escape($fstart)."', `port` = '".db_escape($fport)."' WHERE `id` = '".db_escape($id)."' AND `user` = '".$benutzer['id']."'");
    if ($danach == 'A') if (!headers_sent()) header('location: '.$_SERVER['PHP_SELF'].'?seite=inhalt&modul='.urlencode($modul));
    if ($danach == 'B') if (!headers_sent()) header('location: '.$_SERVER['PHP_SELF'].'?seite=edit&modul='.urlencode($modul).'&aktion=new&danach='.urlencode($danach));
    if ($danach == 'C') if (!headers_sent()) header('location: '.$_SERVER['PHP_SELF'].'?seite=edit&modul='.urlencode($modul).'&aktion=new&folder='.urlencode($folder).'&danach='.urlencode($danach));
  }

  if ($aktion == 'new')
  {
    $res = db_query("SELECT `user` FROM `".$mysql_zugangsdaten['praefix']."ordner` WHERE `id` = '".db_escape($folder)."'");
    $row = db_fetch($res);
    if ($row['user'] != $benutzer['id'])
      $folder = 0;

    db_query("INSERT INTO `".$mysql_zugangsdaten['praefix']."net2ftp` (`folder`, `server`, `username`, `passwort`, `startverzeichnis`, `port`, `user`) VALUES ('".db_escape($folder)."', '".db_escape($fserver)."', '".db_escape($fusername)."', '".db_escape($fpasswort)."', '".db_escape($fstart)."', '".db_escape($fport)."', '".$benutzer['id']."')");
    if ($danach == 'A') if (!headers_sent()) header('location: '.$_SERVER['PHP_SELF'].'?seite=inhalt&modul='.urlencode($modul));
    if ($danach == 'B') if (!headers_sent()) header('location: '.$_SERVER['PHP_SELF'].'?seite=edit&modul='.urlencode($modul).'&aktion=new&danach='.urlencode($danach));
    if ($danach == 'C') if (!headers_sent()) header('location: '.$_SERVER['PHP_SELF'].'?seite=edit&modul='.urlencode($modul).'&aktion=new&folder='.urlencode($folder).'&danach='.urlencode($danach));
  }

  if ($aktion == 'delete')
  {
    db_query("DELETE FROM `".$mysql_zugangsdaten['praefix']."net2ftp` WHERE `id` = '".db_escape($id)."' AND `user` = '".$benutzer['id']."'");
    if (db_affected_rows() > 0)
      db_query("OPTIMIZE TABLE `".$mysql_zugangsdaten['praefix']."net2ftp`");

    if (!headers_sent()) header('location: '.$_SERVER['PHP_SELF'].'?seite=inhalt&modul='.urlencode($modul));
  }

?>
