<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

include('modules/'.$m2.'/includes/http_class.inc.php');

function inetconn_ok()
{
	global $configuration;

	// Ergebnis für Scriptlaufzeit zwischenspeichern aufgrund von Performancegründen
	if (defined('inet_conn_result'))
	{
		return inet_conn_result;
	}
	else
	{
		$r = @fsockopen($configuration['common_internet']['internet-check-url'], $configuration['common_internet']['internet-check-port'], $errno, $errstr, 5);
		define('inet_conn_result', $r);
		return $r;
	}
}

$httpc = new HTTPClass;

$httpc->connection_checker = 'inetconn_ok';
$httpc->error_level = HTTPC_ERRLVL_FATAL_ERRORS;

$httpc->user_agent = WBUserAgent();

function my_get_contents($url) {
	global $httpc;

	$httpc_res = $httpc->execute_http_request($url, '');

	if ($httpc_res->error != HTTPC_NO_ERROR) {
		return false;
	} else {
		return $httpc_res->content;
	}
}

function zwischen_url($url, $von, $bis, $flankierungen_miteinbeziehen = true)
{
	$cont = my_get_contents($url);

	if ($cont === false) return false;

	return zwischen_str($cont, $von, $bis, $flankierungen_miteinbeziehen);
}

?>
