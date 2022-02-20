<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne IronBASE ausgef&uuml;hrt werden.');

$res = db_query("SELECT `url`, `update_enabled`, `update_text_begin`, `update_text_end`, `update_checkurl` FROM `".$mysql_zugangsdaten['praefix']."links` WHERE `id` = '".db_escape($id)."' AND `user` = '".$benutzer['id']."'");
$row = db_fetch($res);

$url = entferne_anker($row['url']);

if (inetconn_ok())
{
  $site = my_get_contents($url);

  if ($site !== false)
  {
    if ($row['update_enabled'])
    {
      $cont = zwischen_url($row['update_checkurl'], undo_transamp_replace_spitze_klammern($row['update_text_begin']), undo_transamp_replace_spitze_klammern($row['update_text_end']));
      $cont = md5($cont);

      db_query("UPDATE `".$mysql_zugangsdaten['praefix']."links` SET `update_lastcontent` = '".db_escape($cont)."', `update_lastchecked` = NOW(), `neu_flag` = '0', `kaputt_flag` = '0' WHERE `id` = '".db_escape($id)."' AND `user` = '".$benutzer['id']."'");
    }
  }
  else
  {
    db_query("UPDATE `".$mysql_zugangsdaten['praefix']."links` SET `kaputt_flag` = '1' WHERE `id` = '".db_escape($id)."' AND `user` = '".$benutzer['id']."'");

    die($header.'<h1>Fehler</h1>Die Webseite <a href="'.$row['url'].'" target="_blank">'.$row['url'].'</a> konnte nicht ge&ouml;ffnet werden. Eventuell ist die URL falsch oder die Seite tempor&auml;r nicht vorhanden.'.$footer);
  }
}

if (!headers_sent()) header('location: '.$url);

?>
