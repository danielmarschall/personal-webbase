<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

$meldung = '';

if (!inetconn_ok())
{
  $meldung .= '<font color="#FF0000">Konnte nicht nach Updates pr&uuml;fen, da Internetkonnektivit&auml;t gest&ouml;rt ist.</font>';
}
else
{
  $cont = my_get_contents('https://www.personal-webbase.de/module_version.txt');

  if ($cont == '')
  {
    $meldung .= '<font color="#FF0000">Es konnte nicht nach Updates f&uuml;r das Modul gesucht werden. Pr&uuml;fen Sie Ihre PHP-Einstellungen oder versuchen Sie es zu einem sp&auml;teren Zeitpunkt nocheinmal.</font>';
  }
  else
  {
    if (strpos($cont, '['.$m2.' '.$version.']') !== false)
    {
      $meldung .= 'Es sind keine Updates f&uuml;r das Modul verf&uuml;gbar.';
    }
    else
    {
      $meldung .= '<font color="#00BB00">Das Modul ist in einer neuen Version erschienen!</font> <a href="https://www.personal-webbase.de/" target="_blank">Download</a>';
    }
  }
}

?>
