<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

$meldung = '';

$cont = my_get_contents('https://www.viathinksoft.de/update/?id=ironbase');

if ($cont == '')
{
  $meldung .= '<font color="#FF0000">Es konnte nicht nach Updates f&uuml;r Personal WebBase gesucht werden. Pr&uuml;fen Sie Ihre PHP-Einstellungen oder versuchen Sie es zu einem sp&auml;teren Zeitpunkt noch einmal.</font>';
}
else
{
  if ($cont == $revision)
  {
    $meldung .= 'Es sind keine Updates f&uuml;r Personal WebBase verf&uuml;gbar.';
  }
  else
  {
    $meldung .= '<font color="#00BB00">Personal WebBase ist in einer neuen Version erschienen!</font> <a href="https://www.personal-webbase.de/" target="_blank">Download</a>';
  }
}

?>
