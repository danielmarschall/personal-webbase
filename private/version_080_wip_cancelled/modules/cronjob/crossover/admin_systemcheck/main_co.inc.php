<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

$meldung = '';

if ($configuration[$m2]['passivcron'] == '1')
{
	$meldung .= '<span class="red">Der serverseitige Crondienst ist auf diesem Server gest&ouml;rt oder deaktiviert!</span>';

	$url = 'http://www.personal-webbase.de/promoting.html';

	if ($_SERVER['SERVER_ADDR'] != '127.0.0.1')
	{
		$url .= '?url=';
		if ($WBConfig->getForceSSLFlag())
			$url .= 'https://';
		else
			$url .= 'http://';
		$url .= $_SERVER['HTTP_HOST'].str_replace('\\', '/', dirname($_SERVER['PHP_SELF']));
	}
	$meldung .= '<br>Tipp: <a href="'.deferer($url).'" target="_blank">Jetzt ViaThinkSoft-Promoting kostenlos nutzen!</a>';
}
else
	$meldung .= '<span class="green">Der serverseitige Crondienst ist im Moment auf diesem Server in Ordnung!</span>';

$meldung .= '<br>Der letzte Crondurchlauf war am <b>'.de_convertmysqldatetime($configuration[$m2]['last_cronjob']).'</b> durch einen <b>';

if ($configuration[$m2]['passivcron'] == '1')
	$meldung .= 'passiven';
else
	$meldung .= 'aktiven';

$meldung .= ' Aufruf</b>.';

if ($configuration[$m2]['passivcron'] == '0')
{
	$meldung .= '<br>Der letzte Aufruf wurde ';

	if ($configuration[$m2]['lastpromoter'] == '')
		$meldung .= 'von der <b>Shell</b> durchgef&uuml;hrt';
	else
		$meldung .= 'von einem fremden Rechner durchgef&uuml;hrt (promoting): <a href="'.deferer('http://'.$configuration[$m2]['lastpromoter'].'/').'" target="_blank"><b>'.$configuration[$m2]['lastpromoter'].'</b></a>';
}

?>
