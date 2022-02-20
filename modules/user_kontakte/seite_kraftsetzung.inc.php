<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

  if ($aktion == 'edit')
  {
    $res = db_query("SELECT `user` FROM `".$mysql_zugangsdaten['praefix']."ordner` WHERE `id` = '".db_escape($folder)."'");
    $row = db_fetch($res);
    if ($row['user'] != $benutzer['id'])
      $folder = 0;

    db_query("UPDATE `".$mysql_zugangsdaten['praefix']."kontakte` SET `name` = '".db_escape($name)."', `strasse` = '".db_escape($strasse)."', `plz` = '".db_escape($plz)."', `ort` = '".db_escape($ort)."', `land` = '".db_escape($land)."', `telefon` = '".$telefon1.'-'.$telefon2."', `mobil` = '".$mobil1.'-'.$mobil2."', `fax` = '".$fax1.'-'.$fax2."', `email` = '".db_escape($email)."', `icq` = '".db_escape($icq)."', `msn` = '".db_escape($msn)."', `aim` = '".db_escape($aim)."', `yahoo` = '".db_escape($yahoo)."', `kommentare` = '".db_escape($kommentare)."', `folder` = '".db_escape($folder)."', `skype` = '".db_escape($skype)."' WHERE `id` = '".db_escape($id)."' AND `user` = '".$benutzer['id']."'");
    if ($danach == 'A') if (!headers_sent()) header('location: '.$_SERVER['PHP_SELF'].'?seite=inhalt&modul='.$modul);
    if ($danach == 'B') if (!headers_sent()) header('location: '.$_SERVER['PHP_SELF'].'?seite=edit&modul='.$modul.'&aktion=new&danach='.$danach);
    if ($danach == 'C') if (!headers_sent()) header('location: '.$_SERVER['PHP_SELF'].'?seite=edit&modul='.$modul.'&aktion=new&folder='.$folder.'&danach='.$danach);
  }

  if ($aktion == 'new')
  {
    $res = db_query("SELECT `user` FROM `".$mysql_zugangsdaten['praefix']."ordner` WHERE `id` = '".db_escape($folder)."'");
    $row = db_fetch($res);
    if ($row['user'] != $benutzer['id'])
      $folder = 0;

    db_query("INSERT INTO `".$mysql_zugangsdaten['praefix']."kontakte` (`name`, `strasse`, `plz`, `ort`, `land`, `telefon`, `mobil`, `fax`, `email`, `icq`, `msn`, `aim`, `yahoo`, `kommentare`, `skype`, `user`, `folder`) VALUES ('".db_escape($name)."', '".db_escape($strasse)."', '".db_escape($plz)."', '".db_escape($ort)."', '".db_escape($land)."', '".$telefon1.'-'.$telefon2."', '".$mobil1.'-'.$mobil2."', '".$fax1.'-'.$fax2."', '".db_escape($email)."', '".db_escape($icq)."', '".db_escape($msn)."', '".db_escape($aim)."', '".db_escape($yahoo)."', '".db_escape($kommentare)."', '".db_escape($skype)."', '".$benutzer['id']."', '".db_escape($folder)."')");
    if ($danach == 'A') if (!headers_sent()) header('location: '.$_SERVER['PHP_SELF'].'?seite=inhalt&modul='.$modul);
    if ($danach == 'B') if (!headers_sent()) header('location: '.$_SERVER['PHP_SELF'].'?seite=edit&modul='.$modul.'&aktion=new&danach='.$danach);
    if ($danach == 'C') if (!headers_sent()) header('location: '.$_SERVER['PHP_SELF'].'?seite=edit&modul='.$modul.'&aktion=new&folder='.$folder.'&danach='.$danach);
  }

  if ($aktion == 'delete')
  {
    db_query("DELETE FROM `".$mysql_zugangsdaten['praefix']."kontakte` WHERE `id` = '".db_escape($id)."' AND `user` = '".$benutzer['id']."'");
    if (db_affected_rows() > 0)
      db_query("OPTIMIZE TABLE `".$mysql_zugangsdaten['praefix']."kontakte`");

    if (!headers_sent()) header('location: '.$_SERVER['PHP_SELF'].'?seite=inhalt&modul='.$modul);
  }

?>
