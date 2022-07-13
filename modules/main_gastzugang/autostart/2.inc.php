<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

ib_add_config('enable_gast', '0', $m2);
ib_add_config('gast_username', 'guest', $m2);
ib_add_config('gast_passwort', '', $m2);
ib_add_config('wipe_gastkonto', '0', $m2);
ib_add_config('last_wipe', '0000-00-00', $m2);
ib_add_config('wipe_uhrzeit', '03:00:00', $m2);

$res = db_query("SELECT * FROM `".$mysql_zugangsdaten['praefix']."users` WHERE `username` = 'test'");
if (db_num($res) == 0)
  db_query("INSERT INTO `".$mysql_zugangsdaten['praefix']."users` (`username`, `email`, `gesperrt`, `personenname`, `passwort`, `created_database`, `last_login`) VALUES ('guest', '', '0', 'Personal WebBase Testbenutzer', '".md5('')."', NOW(), NULL)");// TODO: use sha3 hash, salted and peppered

?>
