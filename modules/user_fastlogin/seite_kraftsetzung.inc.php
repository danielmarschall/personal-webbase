<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne IronBASE ausgef&uuml;hrt werden.');

if ($ib_user_type == 0)
{
  die($header.'Keine Zugriffsberechtigung'.$footer);
}

if ($aktion == 'activate')
{
  $hex = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');

  $new_secret_key = '';
  for ($i=0; $i<255; $i++)
  {
    $new_secret_key .= $hex[mt_rand(0, 15)];
  }

  db_query("UPDATE `".$mysql_zugangsdaten['praefix']."users` SET `fastlogin_secret` = '".$new_secret_key."' WHERE `id` = '".$benutzer['id']."'");
  if (!headers_sent()) header('location: '.$_SERVER['PHP_SELF'].'?seite=inhalt&modul='.$modul);
}

if ($aktion == 'deactivate')
{
  db_query("UPDATE `".$mysql_zugangsdaten['praefix']."users` SET `fastlogin_secret` = '' WHERE `id` = '".$benutzer['id']."'");
  if (!headers_sent()) header('location: '.$_SERVER['PHP_SELF'].'?seite=inhalt&modul='.$modul);
}

?>