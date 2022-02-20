<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne IronBASE ausgef&uuml;hrt werden.');

$meldung = '';

$cont = my_get_contents('http://www.viathinksoft.de/update/?id=ironbase');

if ($cont == '')
{
  $meldung .= '<font color="#FF0000">Es konnte nicht nach Updates f&uuml;r IronBASE gesucht werden. Pr&uuml;fen Sie Ihre PHP-Einstellungen oder versuchen Sie es zu einem sp&auml;teren Zeitpunkt noch einmal.</font>';
}
else
{
  if ($cont == $revision)
  {
    $meldung .= 'Es sind keine Updates f&uuml;r IronBASE verf&uuml;gbar.';
  }
  else
  {
    $meldung .= '<font color="#00BB00">IronBASE ist in einer neuen Version erschienen!</font> <a href="http://www.viathinksoft.de/update/?id=@ironbase" target="_blank">Download</a>';
  }
}

?>