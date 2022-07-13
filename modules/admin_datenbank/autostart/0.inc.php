<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

// Auslesen der Datenbanktabellen und deren Felder

$datenbanktabellen = array();
$qs = db_query('SHOW TABLES');
while ($qr = db_fetch($qs))
{
  $qs2 = db_query("SHOW FIELDS FROM `".db_escape($qr[0])."`");
  while ($qr2 = db_fetch($qs2))
  {
    $datenbanktabellen[$qr[0]][$qr2[0]] = $qr2[1].'/'.$qr2[2].'/'.$qr2[3].'/'.$qr2[4].'/'.$qr2[5];
  }
}

// Important, must exist

if (!array_key_exists($mysql_zugangsdaten['praefix'].'module', $datenbanktabellen)) {
	$tabellen = array();
	ib_newdatabasetable('module', 'admin_module', 'modul', "varchar(255) NOT NULL default ''",
									   'table', "varchar(255) NOT NULL default ''");
}

if (function_exists('set_searchable')) set_searchable($m2, 'module', 0);

my_add_key($mysql_zugangsdaten['praefix'].'module', 'table', true, 'table');

// Array $tabellen erstellen und dabei ungültige Einträge der Modultabelle entfernen...

$tabellen = array();
$res = db_query("SELECT `table` FROM `".$mysql_zugangsdaten['praefix']."module` ORDER BY `id`");
while ($row = db_fetch($res))
{
  if (!isset($datenbanktabellen[$mysql_zugangsdaten['praefix'].$row['table']]))
  {
	db_query("DELETE FROM `".$mysql_zugangsdaten['praefix']."module` WHERE `table` = '".$row['table']."'");
	if (db_affected_rows() > 0)
	  db_query("OPTIMIZE TABLE `".$mysql_zugangsdaten['praefix']."module`");
  }
  else
  {
	$tabellen[] = $row['table'];
  }
}

// Diese Funktion erstellt eine Datebanktabelle und fügt ggf. neue Felder hinzu
// Parameter: name (ohne Präfix), modul, Feld_1 Name, Feld_1 Eigenschaften, Feld_2 ...
function ib_newdatabasetable($name, $modul)
{
  global $datenbanktabellen, $mysql_zugangsdaten, $tabellen;

  if (!isset($datenbanktabellen[$mysql_zugangsdaten['praefix'].$name]))
    db_query("CREATE TABLE `".$mysql_zugangsdaten['praefix'].db_escape($name)."` (
   `id` bigint(21) NOT NULL auto_increment,
   PRIMARY KEY (`id`)
)");

  for ($i=1; $i<@func_num_args()-2; $i++)
  {
    if ($i%2)
    {
      if (isset($datenbanktabellen[$mysql_zugangsdaten['praefix'].$name][@func_get_arg($i+1)]))
      {
        // Wenn der Feldtyp bei einem Versionstyp gewechselt hat, dann normalisieren
        // Achtung: Es wird nur der FELDTYP kontrolliert!
        $x = $datenbanktabellen[$mysql_zugangsdaten['praefix'].$name][@func_get_arg($i+1)]; // Workaround für "Can't be used as a function parameter"
        $art = explode('/', $x);
        $y = @func_get_arg($i+2); // Workaround für "Can't be used as a function parameter"
        $arm = explode(' ', $y);
        if (strtolower($art[0]) <> strtolower($arm[0]))
        {
          db_query("ALTER TABLE `".$mysql_zugangsdaten['praefix'].$name."` CHANGE `".@func_get_arg($i+1)."` `".@func_get_arg($i+1)."` ".@func_get_arg($i+2));
        }
      }
      else
      {
        db_query("ALTER TABLE `".$mysql_zugangsdaten['praefix'].db_escape($name)."` ADD `".@func_get_arg($i+1)."` ".@func_get_arg($i+2));
      }
    }
  }

  $nellebat = array_flip($tabellen);
  if (!isset($nellebat[$name]))
  {
    db_query("INSERT INTO `".$mysql_zugangsdaten['praefix']."module` (`modul`, `table`) VALUES ('".db_escape($modul)."', '".db_escape($name)."')");
    $tabellen[] = $name;
  }
}

// Sorgt dafür, dass keine Duplicate-Fehler entstehen, wenn Indexe erstellt werden
// Index werden nur einmalig erstellt oder ggf aktualisiert
function my_add_key($table, $name, $unique, $column)
{
  // Funktioniert nicht für PRIMARY KEY

  if ($unique)
    $erwarte_non_unique = '0';
  else
    $erwarte_non_unique = '1';

  //$breaki = false;
  $rs = db_query("SHOW INDEX FROM `$table`");
  while ($rw = db_fetch($rs))
  {
    for ($i=0; $i<@func_num_args()-3; $i++)
    {
      if (($rw['Column_name'] == @func_get_arg($i+3)) && ($rw['Key_name'] != $name))
      {
        db_query("ALTER TABLE `$table` DROP INDEX `".$rw['Key_name']."`");
        //$breaki = true;
        //break;
      }
    }
    //if ($breaki) break;
  }

  $breaki = false;
  $rs = db_query("SHOW INDEX FROM `$table`");
  while ($rw = db_fetch($rs))
  {
    if ($rw['Key_name'] == $name)
    {
      for ($i=0; $i<@func_num_args()-3; $i++)
      {
        if ($rw['Column_name'] == @func_get_arg($i+3))
        {
          if ($rw['Non_unique'] == $erwarte_non_unique)
          {
            ${'vorgekommen_'.@func_get_arg($i+3)} = true;
          }
          else
          {
            db_query("ALTER TABLE `$table` DROP INDEX `$name`");
            $breaki = true;
            break;
          }
        }
      }
    }
    if ($breaki) break;
  }

  $alles_vorgekommen = true;

  for ($i=0; $i<@func_num_args()-3; $i++)
  {
    if ((!isset(${'vorgekommen_'.@func_get_arg($i+3)})) || (!${'vorgekommen_'.@func_get_arg($i+3)}))
    {
      $alles_vorgekommen = false;
    }
  }

  if (!$alles_vorgekommen)
  {
    $colo = '';

    for ($i=0; $i<@func_num_args()-3; $i++)
    {
      $colo .= '`'.@func_get_arg($i+3).'`, ';
    }

    $colo = substr($colo, 0, strlen($colo)-2);

    if ($unique)
      db_query("ALTER TABLE `$table` ADD UNIQUE `$name` ($colo)");
    else
      db_query("ALTER TABLE `$table` ADD KEY `$name` ($colo)");
  }
}

?>
