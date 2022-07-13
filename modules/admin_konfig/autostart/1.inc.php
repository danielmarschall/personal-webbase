<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

ib_newdatabasetable('konfig', $m2, 'name', "varchar(255) NOT NULL default ''",
                                   'wert', "varchar(255) NOT NULL default ''",
                                   'modul', "varchar(255) NOT NULL default ''");

if (function_exists('set_searchable')) set_searchable($m2, 'konfig', 0);

my_add_key($mysql_zugangsdaten['praefix'].'konfig', 'name_and_module', true, 'name', 'modul');

// $konfiguration erstellen
$konfiguration = array();
$res = db_query("SELECT * FROM `".$mysql_zugangsdaten['praefix']."konfig` ORDER BY `id`");
while ($row = db_fetch($res))
  $konfiguration[$row['modul']][$row['name']] = $row['wert'];

// Funktion für das ändern eines Konfigurationswertes inkl. Änderung von $konfiguration
function ib_change_config($name, $wert, $modul)
{
  global $mysql_zugangsdaten, $konfiguration;

  if ($konfiguration[$modul][$name] != $wert)
  {
    db_query("UPDATE `".$mysql_zugangsdaten['praefix']."konfig` SET `wert` = '".db_escape($wert)."' WHERE `name` = '".db_escape($name)."' AND `modul` = '".db_escape($modul)."'");
    if (db_affected_rows() > 0)
      $konfiguration[$modul][$name] = $wert;
  }
}

// Funktion für das hinzufügen eines Konfigurationswertes inkl. Änderung von $konfiguration
function ib_add_config($name, $wert, $modul)
{
  global $mysql_zugangsdaten, $konfiguration;

  if (!isset($konfiguration[$modul][$name]))
  {
    db_query("INSERT INTO `".$mysql_zugangsdaten['praefix']."konfig` (`name`, `wert`, `modul`) VALUES ('".db_escape($name)."', '".db_escape($wert)."', '".db_escape($modul)."')");
    if (db_affected_rows() > 0)
      $konfiguration[$modul][$name] = $wert;
  }
}

?>
