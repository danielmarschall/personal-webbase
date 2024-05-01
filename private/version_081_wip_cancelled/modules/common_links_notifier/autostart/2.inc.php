<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

if ((isset($_SERVER['HTTP_HOST'])) && (isset($_SERVER['PHP_SELF'])))
{
	if ($WBConfig->getForceSSLFlag())
	{
		$wburl = 'https://';
	}
	else
	{
		$wburl = 'http://';
	}
	$wburl .= $_SERVER['HTTP_HOST'];
	$wburl .= dirname_with_pathdelimiter($_SERVER['PHP_SELF']);
}
else
{
	$wburl = '';
}

if (isset($configuration[$m2]['wb_system_url']))
{
	if ($configuration[$m2]['wb_system_url'] != $wburl)
	{
		wb_change_config('wb_system_url', $wburl, $m2);
	}
}
else
{
	wb_add_config('wb_system_url', $wburl, $m2);
}

unset($wburl);

?>
