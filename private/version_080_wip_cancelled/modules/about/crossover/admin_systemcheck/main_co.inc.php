<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

$meldung = '';

$cont = my_get_contents('http://www.viathinksoft.de/update/?id=personal-webbase');

if ($cont === false)
{
	$meldung .= '<span class="red">Es konnte nicht nach Updates f&uuml;r Personal WebBase gesucht werden. Pr&uuml;fen Sie Ihre PHP-Einstellungen oder versuchen Sie es zu einem sp&auml;teren Zeitpunkt noch einmal.</span>';
}
else
{
	if ($cont == $WBConfig->getRevision())
	{
		$meldung .= 'Es sind keine Updates f&uuml;r Personal WebBase verf&uuml;gbar.';
	}
	else
	{
		$meldung .= '<span class="green">Personal WebBase ist in einer neuen Version erschienen!</span> <a href="'.deferer('http://www.viathinksoft.de/update/?id=@personal-webbase').'" target="_blank">Download</a>';
	}
}

?>
