<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne IronBASE ausgef&uuml;hrt werden.');

$meldung = '';

if (!inetconn_ok())
{
  $meldung .= '<font color="#FF0000">Konnte nicht nach Updates pr&uuml;fen, da Internetkonnektivit&auml;t gest&ouml;rt ist.</font>';
}
else
{
  $cont = my_get_contents('http://www.viathinksoft.de/info/ironbase/module.php');

  if ($cont == '')
  {
    $meldung .= '<font color="#FF0000">Es konnte nicht nach Updates f&uuml;r das Modul gesucht werden. Pr&uuml;fen Sie Ihre PHP-Einstellungen oder versuchen Sie es zu einem sp&auml;teren Zeitpunkt nocheinmal.</font>';
  }
  else
  {
    if (strpos($cont, '<!-- UpdateSection: '.$m2.' '.$version.' -->') !== false)
    {
      $meldung .= 'Es sind keine Updates f&uuml;r das Modul verf&uuml;gbar.';
    }
    else
    {
      $meldung .= '<font color="#00BB00">Das Modul ist in einer neuen Version erschienen!</font> <a href="http://www.viathinksoft.de/info/ironbase/downloads/'.$m2.'.zip" target="_blank">Download</a>';
    }
  }
}

?>