<?php

//////////////////////////////////////////////////////////////////////////////
// SICHERHEITSVARIABLE                                                      //
//////////////////////////////////////////////////////////////////////////////
// Ohne diese werden Modulinhalte nicht ausgeführt                          //
//////////////////////////////////////////////////////////////////////////////

define('WBLEGAL', '1');

header('Content-Type: text/html; charset=ISO-8859-1');
mb_internal_encoding("ISO-8859-1");

//////////////////////////////////////////////////////////////////////////////
// FUNKTIONEN                                                               //
//////////////////////////////////////////////////////////////////////////////

require 'includes/functions.inc.php';

//////////////////////////////////////////////////////////////////////////////
// PRÜFUNG VON MODDIR.TXT                                                   //
//////////////////////////////////////////////////////////////////////////////

if (!file_exists('modules/moddir.txt'))
{
  die('<h1>Personal WebBase ist gesperrt</h1>Kann Datei modules/moddir.txt, die das Modulverzeichnis identifiziert, nicht finden. Ist diese vorhanden, sind die Zugriffsberechtigungen der Dateien falsch. Empfohlen: Ordner CHMOD 755, Dateien CHMOD 644.');
}

//////////////////////////////////////////////////////////////////////////////
// KOMPATIBILITÄT                                                           //
//////////////////////////////////////////////////////////////////////////////
// Hier werden Einstellunen von PHP lokal verändert oder Variablen          //
// bearbeitet, sodass Personal WebBase möglichst unabhängig von fremden             //
// Konfigurationen wird und funktionell bleibt!                             //
//////////////////////////////////////////////////////////////////////////////

// 1. Magic Quotes Sybase abschalten
@ini_set('magic_quotes_sybase', 'Off');

// 2. Magic Quotes Runtime abschalten
if (function_exists('set_magic_quotes_runtime'))
{
  @set_magic_quotes_runtime(0);
}

// 3. variables_order / gpc_order ersetzen
@ini_set('register_long_arrays', '1');
$types_to_register = array('ENV', 'GET', 'POST', 'COOKIE', 'SERVER'); // SESSION und FILES werden nicht extrahiert
foreach ($types_to_register as $rtype)
{
  // 4. Funktion von "Register Globals" ersetzen, wenn es ausgeschaltet ist
  if ((!ini_get('register_globals')) && isset(${'_'.$rtype}) && (@count(${'_'.$rtype}) > 0))
    extract(${'_'.$rtype}, EXTR_OVERWRITE);

  // Workaround, wenn register_long_arrays nicht auf 1 gesetzt werden konnte
  $ch = '_'.$rtype;

  // 5. Wenn "Magic Quotes GPC" aktiviert, dann die Aenderungen an GET/POST/COOKIE wieder rueckgaengig machen!
  // Wir haben db_escape(), um SQL-Strings vor Injektionen zu schuetzen. Wir brauchen Magic Quotes nicht!
  if (function_exists('get_magic_quotes_gpc') && (get_magic_quotes_gpc() == 1) && (($rtype == 'GET') || ($rtype == 'POST') || ($rtype == 'COOKIE')))
  {
    foreach ($$ch AS $m1 => $m2)
    {
      $$m1 = stripslashes($$m1);
      ${'_'.$rtype}[$m1] = stripslashes(${'_'.$rtype}[$m1]);
    }

    unset($m1);
    unset($m2);
  }

  // 6. In HTML-Zeichen translatieren
  // Wenn Benutzer z.B. &auml; in ein Formular eingeben, soll dies nicht uebersetzt werden etc!
  // Übersetzung von < und > verhindert HTML-Code-Ausführung
  if (($rtype == 'GET') || ($rtype == 'POST') || ($rtype == 'COOKIE'))
  {
    foreach ($$ch AS $m1 => $m2)
    {
      $$m1 = transamp_replace_spitze_klammern($$m1);
      ${'_'.$rtype}[$m1] = transamp_replace_spitze_klammern(${'_'.$rtype}[$m1]);
    }

    unset($m1);
    unset($m2);
  }
}

// 7. Deutsche Umgebung setzen
$ary = explode('.', phpversion());
if (((int)$ary[0] < 4) || (((int)$ary[0] == 4) && ((int)$ary[1] < 3)))
  setlocale(LC_ALL, 'german');
else
  setlocale(LC_ALL, 'de_DE@euro', 'de_DE', 'de', 'ge', 'german');
@ini_set('date.timezone', 'Europe/Zurich');

// 8. MAX_EXECUTION_TIME
@set_time_limit(0);

// 9. Um unsauber entwickelte Module zu verhindern, höchstes Fehlerlevel aktivieren
if ((int)$ary[0] >= 5)
  @error_reporting(E_ALL | E_STRICT);
else
  @error_reporting(E_ALL);

//////////////////////////////////////////////////////////////////////////////
// VARIABLEN-INCLUDES                                                       //
//////////////////////////////////////////////////////////////////////////////

$revision = '?';
$rev_datum = '?';
$mysql_zugangsdaten = array();
$mysql_zugangsdaten['server'] = 'localhost';
$mysql_zugangsdaten['praefix'] = 'ironbase_';
$mysql_zugangsdaten['username'] = 'root';
$mysql_zugangsdaten['passwort'] = '';
$mysql_zugangsdaten['datenbank'] = 'ironbase';
$lock = 0;
$force_ssl = 0;

if (file_exists('includes/rev.inc.php'))
  include 'includes/rev.inc.php';
if (file_exists('includes/config.inc.php'))
  include 'includes/config.inc.php';

//////////////////////////////////////////////////////////////////////////////
// MANUELLE SPERRUNG DURCH LOCK-VARIABLE                                    //
//////////////////////////////////////////////////////////////////////////////

if ($lock)
{
  die('<h1>Personal WebBase ist gesperrt</h1>Die Variable &quot;$lock&quot; in &quot;includes/config.inc.php&quot; steht auf 1 bzw. true. Setzen Sie diese Variable erst auf 0, wenn das Hochladen der Dateien beim Installations- bzw. Updateprozess beendet ist. Wenn Sie Personal WebBase freigeben, bevor der Upload abgeschlossen ist, kann es zu einer Besch&auml;digung der Kundendatenbank kommen!');
}

//////////////////////////////////////////////////////////////////////////////
// SSL-VERBINDUNG ERZWINGEN?                                                //
//////////////////////////////////////////////////////////////////////////////

// Hotfix exklusiv für VTS Demosystem
//if ((isset($modul)) && ($modul == 'core_cronjob')) {
//} else {

if ($force_ssl) @ini_set('session.cookie_secure', 1);

if (($force_ssl) && (!isset($_SERVER['HTTPS']) || (strtolower($_SERVER['HTTPS']) != 'on')))
{
  if (!headers_sent()) header('Location: https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
  exit();
}

//}

//////////////////////////////////////////////////////////////////////////////
// DATENBANKKONNEKTIVITÄT                                                   //
//////////////////////////////////////////////////////////////////////////////

require 'includes/database.inc.php';

//////////////////////////////////////////////////////////////////////////////
// KONSTANTEN FÜR DESIGN                                                    //
//////////////////////////////////////////////////////////////////////////////

$javascript = '<script language="JavaScript" type="text/javascript">
  <!--

  function abfrage(url)
  {
    var is_confirmed = confirm("M\u00f6chten Sie diese Aktion wirklich ausf\u00fchren?");
    if (is_confirmed)
    {
      document.location.href = url;
    }
  }

  function open_url(uri)
  {
       w = screen.availWidth/1.35;
       h = screen.availHeight/1.35;
       x = screen.availWidth/2-w/2;
       y = screen.availHeight/2-h/2;
       var load = window.open(\'\', \'\', \'height=\'+h+\',width=\'+w+\',left=\'+x+\',top=\'+y+\',screenX=\'+x+\',screenY=\'+y+\',scrollbars=yes,resizable=yes,toolbar=no,location=no,menubar=no,status=no\');
       load.document.location.href = uri;
  }

  function oop(modul, seite, titel, gross)
  {
    if (parent.Caption.fertig != "1")
    {
  	window.setTimeout("oop(\'"+modul+"\', \'"+seite+"\', \'"+titel+"\', \'"+gross+"\')", 10);
    }
    else
    {
      titel = \'<img src="\'+gross+\'" alt="Icon" width="32" height="32"> \'+titel;
      if (parent.Caption.document.getElementById) parent.Caption.document.getElementById("ueberschrift").innerHTML = titel; else if (parent.Caption.document.all) parent.Caption.document.ueberschrift.innerHTML = titel;
      parent.Inhalt.location.href = "modulseite.php?'.(($_SERVER["QUERY_STRING"] != '') ? $_SERVER["QUERY_STRING"].'&' : '').'modul="+modul+"&seite="+seite;
    }
  }

  function oop2(myurl, titel, gross)
  {
    if (parent.Caption.fertig != "1")
    {
   	  window.setTimeout("oop(\'"+modul+"\', \'"+seite+"\', \'"+titel+"\', \'"+gross+"\')", 10);
    }
    else
    {
      titel = \'<img src="\'+gross+\'" alt="Icon" width="32" height="32"> \'+titel;
      if (parent.Caption.document.getElementById) parent.Caption.document.getElementById("ueberschrift").innerHTML = titel; else if (parent.Caption.document.all) parent.Caption.document.ueberschrift.innerHTML = titel;
      open_url(myurl);
    }
  }

  // -->
</script>';

$header = '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
  <head>
	<title>ViaThinkSoft Personal WebBase</title>
    <link href="style.css.php" rel="stylesheet" type="text/css">
    <link rel="SHORTCUT ICON" href="favicon.ico">
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
  </head>

  <body>'.$javascript;

$header_navi = '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

  <html>
    <head>
  	  <title>ViaThinkSoft Personal WebBase</title>
      <link href="style.css.php" rel="stylesheet" type="text/css">
      <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
    </head>

  <body class="dark">'.$javascript;

$footer = '</body></html>';

//////////////////////////////////////////////////////////////////////////////
// MODULINITIALISIERUNG                                                     //
//////////////////////////////////////////////////////////////////////////////

// 1. Modulliste laden

function liste_module()
{
  $ary = array();
  $i = 0;
  $v = 'modules/';
  $verz = opendir($v);

  while ($file = readdir($verz))
  {
    if (($file != '.') && ($file != '..') && (is_dir($v.$file)))
    {
      $i++;
      $ary[$i] = $file;
    }
  }

  closedir($verz);
  sort($ary);

  return $ary;
}

$module = liste_module();

// 2. Modul-Autostarts ausführen

$erf = false;
for ($st=0; true; $st++)
{
  $erf = false;
  foreach ($module AS $m1 => $m2)
  {
    if (file_exists('modules/'.wb_dir_escape($m2).'/autostart/'.wb_dir_escape($st).'.inc.php'))
    {
      include 'modules/'.wb_dir_escape($m2).'/autostart/'.wb_dir_escape($st).'.inc.php';
      $erf = true;
    }
  }

  unset($m1);
  unset($m2);

  if (!$erf) break;
}

