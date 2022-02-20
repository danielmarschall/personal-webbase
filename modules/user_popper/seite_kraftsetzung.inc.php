<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne IronBASE ausgef&uuml;hrt werden.');

  if ($aktion == 'new')
  {
    $res = db_query("SELECT `user` FROM `".$mysql_zugangsdaten['praefix']."ordner` WHERE `id` = '".db_escape($folder)."'");
    $row = db_fetch($res);
    if ($row['user'] != $benutzer['id'])
      $folder = 0;

    db_query("INSERT INTO ".$mysql_zugangsdaten['praefix']."popper_konten (`name`, `folder`, `server`, `username`, `passwort`, `personenname`, `replyaddr`, `user`) VALUES ('".db_escape($name)."', '".db_escape($folder)."', '".db_escape($mserver)."', '".db_escape($musername)."', '".db_escape($mpasswort)."', '".db_escape($personenname)."', '".db_escape($replyaddr)."', '".$benutzer['id']."')");
    if ($danach == 'A') if (!headers_sent()) header('location: '.$_SERVER['PHP_SELF'].'?seite=inhalt&modul='.$modul);
    if ($danach == 'B') if (!headers_sent()) header('location: '.$_SERVER['PHP_SELF'].'?seite=edit&modul='.$modul.'&aktion=new&danach='.$danach);
    if ($danach == 'C') if (!headers_sent()) header('location: '.$_SERVER['PHP_SELF'].'?seite=edit&modul='.$modul.'&aktion=new&folder='.$folder.'&danach='.$danach);
  }

  if ($aktion == 'edit')
  {
    $res = db_query("SELECT `user` FROM `".$mysql_zugangsdaten['praefix']."ordner` WHERE `id` = '".db_escape($folder)."'");
    $row = db_fetch($res);
    if ($row['user'] != $benutzer['id'])
      $folder = 0;

	db_query("UPDATE `".$mysql_zugangsdaten['praefix']."popper_konten` SET `name` = '".db_escape($name)."', `folder` = '".db_escape($folder)."', `server` = '".db_escape($mserver)."', `username` = '".db_escape($musername)."', `passwort` = '".db_escape($mpasswort)."', `personenname` = '".db_escape($personenname)."', `replyaddr` = '".db_escape($replyaddr)."' WHERE `id` = '".db_escape($id)."' AND `user` = '".$benutzer['id']."'");
    if ($danach == 'A') if (!headers_sent()) header('location: '.$_SERVER['PHP_SELF'].'?seite=inhalt&modul='.$modul);
    if ($danach == 'B') if (!headers_sent()) header('location: '.$_SERVER['PHP_SELF'].'?seite=edit&modul='.$modul.'&aktion=new&danach='.$danach);
    if ($danach == 'C') if (!headers_sent()) header('location: '.$_SERVER['PHP_SELF'].'?seite=edit&modul='.$modul.'&aktion=new&folder='.$folder.'&danach='.$danach);
  }

  if ($aktion == 'delete')
  {
	db_query("DELETE FROM `".$mysql_zugangsdaten['praefix']."popper_konten` WHERE `id` = '".db_escape($id)."' AND `user` = '".$benutzer['id']."'");
	if (db_affected_rows() > 0)
      db_query("OPTIMIZE TABLE `".$mysql_zugangsdaten['praefix']."popper_konten`");

	db_query("DELETE FROM `".$mysql_zugangsdaten['praefix']."popper_messages` WHERE `accounts` = '".db_escape($id)."'");
	if (db_affected_rows() > 0)
      db_query("OPTIMIZE TABLE `".$mysql_zugangsdaten['praefix']."popper_messages`");

    if (!headers_sent()) header('location: '.$_SERVER['PHP_SELF'].'?seite=inhalt&modul='.$modul);
  }

?>