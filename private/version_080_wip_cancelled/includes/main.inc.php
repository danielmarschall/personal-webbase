<?php

//////////////////////////////////////////////////////////////////////////////
// SICHERHEITSKONSTANTE                                                     //
//////////////////////////////////////////////////////////////////////////////
// Ohne diese werden Modulinhalte nicht ausgeführt                          //
//////////////////////////////////////////////////////////////////////////////

define('WBLEGAL', '1');

//////////////////////////////////////////////////////////////////////////////
// FUNKTIONEN                                                               //
//////////////////////////////////////////////////////////////////////////////

require 'includes/functions.inc.php';

//////////////////////////////////////////////////////////////////////////////
// PRÜFUNG VON MODDIR.TXT                                                   //
//////////////////////////////////////////////////////////////////////////////

if (!file_exists('modules/moddir.txt'))
{
	die('<h1>Personal WebBase ist gesperrt</h1>Kann Datei modules/moddir.txt, die das Modulverzeichnis idendifiziert, nicht finden. Ist diese vorhanden, sind die Zugriffsberechtigungen der Dateien falsch. Empfohlen: Ordner CHMOD 755, Dateien CHMOD 644.');
}

//////////////////////////////////////////////////////////////////////////////
// KOMPATIBILITÄT                                                           //
//////////////////////////////////////////////////////////////////////////////
// Hier werden Einstellunen von PHP lokal verändert oder Variablen          //
// bearbeitet, sodass Personal WebBase möglichst unabhängig von fremden     //
// Konfigurationen wird und funktionell bleibt!                             //
//////////////////////////////////////////////////////////////////////////////

// TODO Gleichrichter Vollrevision. Alles nochmal prüfen und erneuern

// 1. Magic Quotes Sybase abschalten
@ini_set('magic_quotes_sybase', 'Off');

// 2. Magic Quotes Runtime abschalten
if (function_exists('set_magic_quotes_runtime')) set_magic_quotes_runtime(0);

// 3. variables_order / gpc_order ersetzen
@ini_set('register_long_arrays', '1');
$types_to_register = array('ENV', 'GET', 'POST', 'COOKIE', 'SERVER'); // SESSION und FILES werden nicht extrahiert
foreach ($types_to_register as $rtype)
{
	// 4. Funktion von "Register Globals" ersetzen, wenn es ausgeschaltet ist
	if (!ini_get('register_globals')) {
		if (@count(${'_'.$rtype}) > 0) {
			extract(${'_'.$rtype}, EXTR_OVERWRITE);
		} else if (@count(${'HTTP_'.$rtype.'_VARS'}) > 0) {
			extract(${'_'.$rtype}, EXTR_OVERWRITE);
		}
	}

	// Workaround, wenn register_long_arrays nicht auf 1 gesetzt werden konnte
	if (ini_get('register_long_arrays') == '1')
		$ch = 'HTTP_'.$rtype.'_VARS';
	else
		$ch = '_'.$rtype;

	// 5. Wenn "Magic Quotes GPC" aktiviert, dann die Aenderungen an GET/POST/COOKIE wieder rueckgaengig machen!
	// Wir haben db_escape(), um SQL-Strings vor Injektionen zu schuetzen. Wir brauchen Magic Quotes nicht!
	if ((get_magic_quotes_gpc() == 1) && (($rtype == 'GET') || ($rtype == 'POST') || ($rtype == 'COOKIE')))
	{
		foreach ($$ch AS $m1 => $m2)
		{
			$$m1 = stripslashes($$m1);
			${'HTTP_'.$rtype.'_VARS'}[$m1] = stripslashes(${'HTTP_'.$rtype.'_VARS'}[$m1]);
#			${'_'.$rtype}[$m1] = stripslashes(${'_'.$rtype}[$m1]);
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
			$$m1 = encode_critical_html_characters($$m1);
#			${'HTTP_'.$rtype.'_VARS'}[$m1] = encode_critical_html_characters(${'HTTP_'.$rtype.'_VARS'}[$m1]);
			${'_'.$rtype}[$m1] = encode_critical_html_characters(${'_'.$rtype}[$m1]);
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

// Konfiguration laden

if (file_exists('includes/configmanager.class.php')) {
	include 'includes/configmanager.class.php';
}

$WBConfig = new WBConfigManager();
$WBConfig->init();

//////////////////////////////////////////////////////////////////////////////
// MANUELLE SPERRUNG DURCH LOCK-VARIABLE                                    //
//////////////////////////////////////////////////////////////////////////////

if ($WBConfig->getLockFlag())
{
	die('<h1>Personal WebBase ist gesperrt</h1>Die Variable &quot;$lock&quot; in &quot;includes/config.inc.php&quot; steht auf 1 bzw. true. Setzen Sie diese Variable erst auf 0, wenn das Hochladen der Dateien beim Installations- bzw. Updateprozess beendet ist. Wenn Sie Personal WebBase freigeben, bevor der Upload abgeschlossen ist, kann es zu einer Besch&auml;digung der Kundendatenbank kommen!');
}

//////////////////////////////////////////////////////////////////////////////
// SSL-VERBINDUNG ERZWINGEN? (NICHT BEI CRONJOBS)                           //
//////////////////////////////////////////////////////////////////////////////

if (!((isset($modul)) && ($modul == 'core_cronjob')))
{
	if ($WBConfig->getForceSSLFlag())
	{
		@ini_set('session.cookie_secure', 1);

		// Wenn keine SSL Verbindung da, dann zu SSL umleiten
		if (!isset($_SERVER['HTTPS']) || (strtolower($_SERVER['HTTPS']) != 'on'))
		{
			wb_redirect_now('https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
		}
	}
}

//////////////////////////////////////////////////////////////////////////////
// DEBUG-INITIALISIERUNG                                                    //
//////////////////////////////////////////////////////////////////////////////

if (file_exists('modules/common_debugger/static_core/init.inc.php')) {
	include('modules/common_debugger/static_core/init.inc.php');
}

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
			parent.Content.location.href = "page.php?'.(((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != '')) ? $_SERVER['QUERY_STRING'].'&' : '').'modul="+modul+"&seite="+seite;
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
			window.open(myurl, "_blank");
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
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="robots" content="noindex">
	</head>

	<body>'.$javascript;

$header_navi = '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
	<head>
		<title>ViaThinkSoft Personal WebBase</title>
		<link href="style.css.php" rel="stylesheet" type="text/css">
		<meta name="robots" content="noindex">
	</head>

	<body class="margin_middle">'.$javascript;

$footer = '</body></html>';

?>
