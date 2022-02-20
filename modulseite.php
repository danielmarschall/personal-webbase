<?php

require 'includes/main.inc.php';

if (!isset($modul)) $modul = '';
if (!isset($seite)) $seite = '';
if (!isset($aktion)) $aktion = '';
if (!isset($kategorie)) $kategorie = '';

$modulueberschrift = '';
$modulsekpos = '';
$modulpos = '';
$modulrechte = '';
$autor = '';
$version = '';
$menuevisible = '';
$license = '';
$deaktiviere_zugangspruefung = 0;

// Damit die Modulseiten auch auf ihre eigenen Modulvariablen zugreifen können, var.inc.php einbinden
if (file_exists('modules/'.$modul.'/var.inc.php'))
  include('modules/'.$modul.'/var.inc.php');

if (($ib_user_type >= $modulrechte) || ($deaktiviere_zugangspruefung))
{
  if (isset($konfiguration['core_debugger']['debug']) && ($konfiguration['core_debugger']['debug'])) ob_start();

  // Nun die Modulseite laden
  if (file_exists('modules/'.$modul.'/seite_'.$seite.'.inc.php'))
    include('modules/'.$modul.'/seite_'.$seite.'.inc.php');
  else
    echo $header.'<b>Fehler beim Laden der Seite</b><br><br>Die angefragte Seite wurde im Modulverzeichnis nicht gefunden.'.$footer;

  if (isset($konfiguration['core_debugger']['debug']) && ($konfiguration['core_debugger']['debug']))
  {
    $i = ob_get_contents();
    ob_end_clean();

    if (file_exists('modules/core_debugger/debugcode.inc.php'))
      include('modules/core_debugger/debugcode.inc.php');
  }
}
else
{
  @session_unset();
  @session_destroy();
  die($header.'<h1>Session abgelaufen</h1>Ihre Session ist abgelaufen oder ung&uuml;tig geworden. Bitte loggen Sie sich neu ein.<br><br><a href="index.php" target="_parent">Zum Hauptmen&uuml;</a>'.$footer);
}

?>
