<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

  if ($aktion == 'new')
  {
    $res = db_query("SELECT `user` FROM `".$mysql_zugangsdaten['praefix']."ordner` WHERE `id` = '".db_escape($folder)."'");
    $row = db_fetch($res);
    if ($row['user'] != $benutzer['id'])
      $folder = 0;

    if ($_FILES['datei']['tmp_name'] != '')
    {
      $pfad_zur_datei = $_FILES['datei']['tmp_name'];
      $dateiname = $_FILES['datei']['name'];
      $data = fread(fopen($pfad_zur_datei, 'r'), filesize($pfad_zur_datei));
      $dtype = $_FILES['datei']['type'];
      db_query("INSERT INTO `".$mysql_zugangsdaten['praefix']."dateien` (`name`, `folder`, `dateiname`, `user`, `type`, `daten`) VALUES ('".db_escape($name)."', '".db_escape($folder)."', '".db_escape($dateiname)."', '".$benutzer['id']."', '".db_escape($dtype)."', '".db_escape($data)."')");
    }
    else
      db_query("INSERT INTO `".$mysql_zugangsdaten['praefix']."dateien` (`name`, `folder`, `user`) VALUES ('".db_escape($name)."', '".db_escape($folder)."', '".$benutzer['id']."')");

    if ($danach == 'A') if (!headers_sent()) header('location: '.$_SERVER['PHP_SELF'].'?seite=inhalt&modul='.$modul);
    if ($danach == 'B') if (!headers_sent()) header('location: '.$_SERVER['PHP_SELF'].'?seite=edit&modul='.$modul.'&aktion=new&danach='.$danach);
    if ($danach == 'C') if (!headers_sent()) header('location: '.$_SERVER['PHP_SELF'].'?seite=edit&modul='.$modul.'&aktion=new&folder='.$folder.'&danach='.$danach);
  }

  if ($aktion == 'edit')
  {
    $res = db_query("SELECT user FROM ".$mysql_zugangsdaten['praefix']."ordner WHERE id = '".db_escape($folder)."'");
    $row = db_fetch($res);
    if ($row['user'] != $benutzer['id'])
      $folder = 0;

    if ($_FILES['datei']['tmp_name'] != '')
    {
      $pfad_zur_datei = $_FILES['datei']['tmp_name'];
      $dateiname = $_FILES['datei']['name'];
      $data = fread(fopen($pfad_zur_datei, 'r'), filesize($pfad_zur_datei));
      $dtype = $_FILES['datei']['type'];
      db_query("UPDATE `".$mysql_zugangsdaten['praefix']."dateien` SET `name` = '".db_escape($name)."', `folder` = '".db_escape($folder)."', `dateiname` = '".db_escape($dateiname)."', `daten` = '".db_escape($data)."', `type` = '".db_escape($dtype)."' WHERE `user` = '".$benutzer['id']."' AND `id` = '".db_escape($id)."'");
    }
    else
      db_query("UPDATE `".$mysql_zugangsdaten['praefix']."dateien` SET `name` = '".db_escape($name)."', `folder` = '".db_escape($folder)."' WHERE `user` = '".$benutzer['id']."' AND `id` = '".db_escape($id)."'");

    if ($danach == 'A') if (!headers_sent()) header('location: '.$_SERVER['PHP_SELF'].'?seite=inhalt&modul='.$modul);
    if ($danach == 'B') if (!headers_sent()) header('location: '.$_SERVER['PHP_SELF'].'?seite=edit&modul='.$modul.'&aktion=new&danach='.$danach);
    if ($danach == 'C') if (!headers_sent()) header('location: '.$_SERVER['PHP_SELF'].'?seite=edit&modul='.$modul.'&aktion=new&folder='.$folder.'&danach='.$danach);
  }

  if ($aktion == 'delete')
  {
    db_query("DELETE FROM `".$mysql_zugangsdaten['praefix']."dateien` WHERE `id` = '".db_escape($id)."' AND `user` = '".$benutzer['id']."'");
    if (db_affected_rows() > 0)
      db_query("OPTIMIZE TABLE `".$mysql_zugangsdaten['praefix']."dateien`");

    if (!headers_sent()) header('location: '.$_SERVER['PHP_SELF'].'?seite=inhalt&modul='.$modul);
  }

?>
