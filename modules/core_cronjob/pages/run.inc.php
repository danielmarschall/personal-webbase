<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

function cron_shutdown()
{
  global $modul;
  global $passiv;
  global $logge_fehler;
  global $out;

  if ($logge_fehler)
  {
    $out = ob_get_contents();
    if ((ob_get_level() > 0) || (ob_get_length() !== FALSE))
      ob_end_clean();
  }

  if (($out != '') && (function_exists('fehler_melden')))
  {
    db_connect(); // Durch die übliche Shutdown-Funktion ist die DB-Verbindung bereits getrennt
    fehler_melden($modul, '<b>Cron-Ausgabe nicht leer</b><br><br>Der Crondurchlauf ist unsauber, da ein Modul Ausgaben verursacht. Dies zeigt in der Regel eine Fehlfunktion des Systems oder eine St&ouml;rung der Cronjobs<!-- und kann sich auf das ViaThinkSoft-Promoting auswirken-->. Die komplette Ausgabe des Crondurchlaufes ist:<br><br>'.$out);
    db_disconnect();
  }
}

// Cron-Jobs nur jede Minute zulassen, nicht öfter
$rsc = db_query("SELECT * FROM `".$mysql_zugangsdaten['praefix']."konfig` WHERE `name` = 'last_cronjob' AND `wert` <= DATE_SUB(NOW(), INTERVAL 1 MINUTE)");
if (db_num($rsc) > 0)
{
  // Fehlerlogging starten
  $logge_fehler = true;

  register_shutdown_function('cron_shutdown');

  // Für was den ganzen Fetz? Wenn PHP und MySQL Zeit verschieden sind (z.B. auf unterschiedliche Server verteilt), gäbe es Probleme!
  $res = db_query("SELECT NOW()");
  $row = db_fetch($res);

  ib_change_config('last_cronjob', $row[0], $modul);
  ib_change_config('lastpromotor', $_SERVER['REMOTE_ADDR'], $modul);

  ob_start();

  foreach ($module as $m1 => $m2)
  {
    $modulueberschrift = '';
    $modulsekpos = '';
    $modulpos = '';
    $modulrechte = '';
    $autor = '';
    $version = '';
    $menuevisible = '';
    $license = '';
    $deaktiviere_zugangspruefung = 0;

    // Info: eval() statt include(), damit Parsing-Fehler gemeldet werden können, die der Admin nicht sehen würde!

    // Damit die Modulseiten auch auf ihre eigenen Modulvariablen zugreifen können, var.inc.php einbinden
    if (file_exists('modules/'.wb_dir_escape($m2).'/var.inc.php'))
      eval('?>' . trim(implode("\n", file('modules/'.wb_dir_escape($m2).'/var.inc.php'))));

    // Nun die Modulcrons laden
    if (file_exists('modules/'.wb_dir_escape($m2).'/crossover/'.wb_dir_escape($modul).'/main.inc.php'))
      eval('?>' . trim(implode("\n", file('modules/'.wb_dir_escape($m2).'/crossover/'.wb_dir_escape($modul).'/main.inc.php'))));
  }

  unset($m1);
  unset($m2);

  $success = true;
}
else
{
  $success = false;
}

// Ab hier keine Fehler mehr loggen...
$out = ob_get_contents();
if ((ob_get_level() > 0) || (ob_get_length() !== FALSE))
  ob_end_clean();
$logge_fehler = false;

if ((isset($passiv)) && ($passiv == 1))
{
  // Wird bei der Hinzufügung der "GIF"-Datei gesetzt, nicht hier
  // ib_change_config('passivcron', '0', $modul);

  // Wir tun so, als wären wir ein Spacer
  if (!headers_sent()) header('Content-type: image/gif');
  readfile('design/spacer.gif');
}
else
{
  ib_change_config('passivcron', '0', $modul);
  if ((!isset($silent)) || ($silent != 'yes'))
  {
    if ($success)
      echo $header.'<b>Cronjobs ausgef&uuml;hrt</b><br><br>Die Cronjobs wurden erfolgreich durchgef&uuml;hrt'.$footer;
    else
      echo $header.'<b>Cronjobs nicht ausgef&uuml;hrt</b><br><br>Die Cronjobs k&ouml;nnen nur jede Minute ausgef&uuml;hrt werden.'.$footer;
  }
}

?>
