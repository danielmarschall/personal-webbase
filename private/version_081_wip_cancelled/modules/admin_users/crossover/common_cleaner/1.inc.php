<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

$my_str = '';
$res = db_query("SELECT `id` FROM `".$WBConfig->getMySQLPrefix()."users`");
while ($row = db_fetch($res))
{
	$my_str .= "'".$row['id']."', ";
}
$my_str = substr($my_str, 0, strlen($my_str)-2);

foreach ($tables_modules as $m1 => $m2)
{
	if (isset($tables_modules[$m1]['user_cnid']))
	{
		if ($my_str != '')
		{
			$add = " WHERE `user_cnid` NOT IN ($my_str)";
		}
		else
		{
			$add = '';
		}

		db_query("DELETE FROM `$m1`$add");
		if (db_affected_rows() > 0)
		{
			db_query("OPTIMIZE TABLE `$m1`");
		}
	}
}

?>