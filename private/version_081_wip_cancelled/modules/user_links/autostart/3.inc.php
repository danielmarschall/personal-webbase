<?php

function entferne_anker($url)
{
	if (strpos($url, '#') !== false)
	{
		$ary = explode('#', $url);

		$tmp = '';
		for ($i=0; $i<=count($ary)-2; $i++)
		{
			$tmp .= $ary[$i].'#';
		}
		$url = substr($tmp, 0, strlen($tmp)-1);
	}

	return $url;
}

?>