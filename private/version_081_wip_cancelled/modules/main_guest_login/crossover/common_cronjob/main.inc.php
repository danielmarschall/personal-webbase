<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

if (($configuration[$m2]['enable_gast'] == '1') && ($configuration[$m2]['wipe_gastkonto']))
{
	$rs = db_query("SELECT `id` FROM `".$WBConfig->getMySQLPrefix()."users` WHERE `username` = '".$configuration[$m2]['gast_username']."' AND MD5('".$configuration[$m2]['gast_password']."') = `password`");

	if (db_num($rs) == 1)
	{
		$rw = db_fetch($rs);
		$my_id = $rw['id'];

		$res = db_query("SELECT * FROM `".$WBConfig->getMySQLPrefix()."configuration` WHERE `name` = 'last_wipe' AND CONCAT(`value`, ' ', '".$configuration[$m2]['wipe_uhrzeit']."') <= DATE_SUB(NOW(), INTERVAL 1 DAY) AND `module` = '".db_escape($m2)."'");
		if (db_num($res) > 0)
		{
			$ary = explode(' ', db_time());
			$dat = $ary[0];

			wb_change_config('last_wipe', $dat, $m2);

			foreach($tables_modules as $m1 => $m2)
			{
				if (isset($tables_database[$m1]['user_cnid']))
				{
					db_query("DELETE FROM `$m1` WHERE `user_cnid` = '$my_id'");
					if (db_affected_rows() > 0)
					{
						db_query("OPTIMIZE TABLE `$m1`");
					}
				}
			}

			unset($m1);
			unset($m2);
		}
	}
}

?>