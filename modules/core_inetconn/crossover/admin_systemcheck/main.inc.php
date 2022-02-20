<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne IronBASE ausgef&uuml;hrt werden.');

$meldung = '';

$check = inetconn_ok();

if ($check)
{
  $meldung .= '<font color="#00BB00">Internetkonnektivit&auml;t OK</font>';
}
else
{
  $meldung .= '<font color="#FF0000">Keine Internetkonnektivit&auml;t oder falsche <a href="'.$_SERVER['PHP_SELF'].'?seite=konfig&amp;modul='.$m2.'&amp;vonseite='.$seite.'&amp;vonmodul='.$modul.'">Konfigurationwerte</a>!</font>';
}

?>