<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

$meldung = '';

$check = inetconn_ok();

if ($check)
{
	$meldung .= '<span class="green">Internetkonnektivit&auml;t OK</span>';
}
else
{
	$meldung .= '<span class="red">Keine Internetkonnektivit&auml;t oder falsche <a href="'.$_SERVER['PHP_SELF'].'?seite=config&amp;modul='.$m2.'&amp;vonseite='.$seite.'&amp;vonmodul='.$modul.'">Konfigurationwerte</a>!</span>';
}

?>