<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

$meldung = '';

if (!inetconn_ok())
{
	$meldung .= '<span class="red">Konnte nicht nach Updates pr&uuml;fen, da Internetkonnektivit&auml;t gest&ouml;rt ist.</span>';
}
else
{
	$cont = my_get_contents('http://www.personal-webbase.de/module.html');

	if ($cont === false)
	{
		$meldung .= '<span class="red">Es konnte nicht nach Updates f&uuml;r das Modul gesucht werden. Versuchen Sie es zu einem sp&auml;teren Zeitpunkt nocheinmal.</span>';
	}
	else
	{
		if (strpos($cont, '<!-- UpdateSection: '.$m2.' '.$module_information->version.' -->') !== false)
		{
			$meldung .= 'Es sind keine Updates f&uuml;r das Modul verf&uuml;gbar.';
		}
		else
		{
			$meldung .= '<span class="green">Das Modul ist in einer neuen Version erschienen!</span> <a href="'.deferer('http://www.personal-webbase.de/downloads/module/'.$m2.'.zip').'" target="_blank">Download</a>';
		}
	}
}

if (decoct(@fileperms('modules/'.$m2.'/system/temp/')) != 40777)
	$meldung .= '<br><br><span class="red">Die Funktionalit&auml;t dieses Modules k&ouml;nnte beeintr&auml;chtigt sein, da der Administrator folgendes Verzeichnis nicht schreibbar (CHMOD 0777) gemacht hat: modules/'.$m2.'/system/temp/</span>';

?>