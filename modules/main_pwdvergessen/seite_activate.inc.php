<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

  echo $header;

  echo '<h1>Konto reaktivieren</h1>';

  $res = db_query("SELECT `new_password` FROM `".$mysql_zugangsdaten['praefix']."users` WHERE `id` = '".db_escape($id)."' AND MD5(MD5(`new_password`)) = '".db_escape($code)."' AND `new_password` != ''");
  if (db_num($res) > 0)
  {
    db_query("UPDATE `".$mysql_zugangsdaten['praefix']."users` SET `passwort` = MD5(`new_password`), `new_password` = '' WHERE `id` = '".db_escape($id)."'");

    echo '<b>Aktivierung erfolgreich</b><br><br>Ihr Konto wurde erfolgreich reaktiviert. Sie k&ouml;nnen sich nun mit den neuen Zugangsdaten einloggen.<br><br><a href="index.php">Zum Personal WebBase-Webinterface</a>';
  }
  else
    echo '<b>Fehler bei Aktivierung</b><br><br>Die Aktivierung war nicht erfolgreich.';

  echo $footer;

?>
