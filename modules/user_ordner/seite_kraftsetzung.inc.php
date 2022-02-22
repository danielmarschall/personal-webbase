<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

  if ($aktion == 'edit')
  {
	if ($id == $folder)
	  die($header.'Fehler: Ordner kann nicht in sich selbst verschoben werden!'.$footer);

    $res = db_query("SELECT `user` FROM `".$mysql_zugangsdaten['praefix']."ordner` WHERE `id` = '".db_escape($folder)."'");
    $row = db_fetch($res);
    if ($row['user'] != $benutzer['id'])
      $folder = 0;

    db_query("UPDATE `".$mysql_zugangsdaten['praefix']."ordner` SET `name` = '".db_escape($name)."', `folder` = '".db_escape($folder)."' WHERE `id` = '".db_escape($id)."' AND `user` = '".$benutzer['id']."'");
    if ($danach == 'A') if (!headers_sent()) header('location: '.$_SERVER['PHP_SELF'].'?seite=inhalt&modul='.urlencode($kategorie));
    if ($danach == 'B') if (!headers_sent()) header('location: '.$_SERVER['PHP_SELF'].'?seite=edit&kategorie='.urlencode($kategorie).'&modul='.urlencode($modul).'&aktion=new&danach='.urlencode($danach));
    if ($danach == 'C') if (!headers_sent()) header('location: '.$_SERVER['PHP_SELF'].'?seite=edit&kategorie='.urlencode($kategorie).'&modul='.urlencode($modul).'&aktion=new&folder='.urlencode($folder).'&danach='.urlencode($danach));
  }

  if ($aktion == 'new')
  {
    $res = db_query("SELECT `user` FROM `".$mysql_zugangsdaten['praefix']."ordner` WHERE `id` = '".db_escape($folder)."'");
    $row = db_fetch($res);
    if ($row['user'] != $benutzer['id'])
      $folder = 0;

    db_query("INSERT INTO `".$mysql_zugangsdaten['praefix']."ordner` (`name`, `kategorie`, `folder`, `user`) VALUES ('".db_escape($name)."', '".db_escape($kategorie)."', '".db_escape($folder)."', '".$benutzer['id']."')");
    if ($danach == 'A') if (!headers_sent()) header('location: '.$_SERVER['PHP_SELF'].'?seite=inhalt&modul='.urlencode($kategorie));
    if ($danach == 'B') if (!headers_sent()) header('location: '.$_SERVER['PHP_SELF'].'?seite=edit&kategorie='.urlencode($kategorie).'&modul='.urlencode($modul).'&aktion=new&danach='.urlencode($danach));
    if ($danach == 'C') if (!headers_sent()) header('location: '.$_SERVER['PHP_SELF'].'?seite=edit&kategorie='.urlencode($kategorie).'&modul='.urlencode($modul).'&aktion=new&folder='.urlencode($folder).'&danach='.urlencode($danach));
  }

  if ($aktion == 'delete')
  {
	db_query("DELETE FROM `".$mysql_zugangsdaten['praefix']."ordner` WHERE `id` = '".db_escape($id)."' AND `user` = '".$benutzer['id']."'");
	if (db_affected_rows() > 0)
      db_query("OPTIMIZE TABLE `".$mysql_zugangsdaten['praefix']."ordner`");

    if (!headers_sent()) header('location: '.$_SERVER['PHP_SELF'].'?seite=inhalt&modul='.urlencode($kategorie));
  }

?>
