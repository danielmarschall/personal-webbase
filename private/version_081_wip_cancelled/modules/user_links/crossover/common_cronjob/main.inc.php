<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

if (inetconn_ok())
{
	$res3 = db_query("SELECT `id`, `url`, `name`, `update_text_begin`, `update_text_end`, `update_lastchecked`, `update_lastcontent`, `update_checkurl`, `new_tag`, `broken_tag`, `user_cnid` FROM `".$WBConfig->getMySQLPrefix()."links` WHERE (`update_enabled` = '1') AND (((`update_lastchecked` <= DATE_SUB(NOW(), INTERVAL ".$configuration[$m2]['update_checkinterval_min']." MINUTE)) AND (`broken_tag` = '0')) OR ((`update_lastchecked` <= DATE_SUB(NOW(), INTERVAL ".$configuration[$m2]['kaputt_checkinterval_min']." MINUTE)) AND (`broken_tag` = '1'))) ORDER BY `id`");
	while ($row3 = db_fetch($res3))
	{
		// Ist unsere Bedingung immer noch aktuell? Da sich die Cron-Scripts aufgrund Überlastung
		// überschneiden können, könnte ohne diese Prüfung ein Link 10 Mal pro Sitzung geprüft werden
		$res_check = db_query("SELECT `id` FROM `".$WBConfig->getMySQLPrefix()."links` WHERE (`update_enabled` = '1') AND (((`update_lastchecked` <= DATE_SUB(NOW(), INTERVAL ".$configuration[$m2]['update_checkinterval_min']." MINUTE)) AND (`broken_tag` = '0')) OR ((`update_lastchecked` <= DATE_SUB(NOW(), INTERVAL ".$configuration[$m2]['kaputt_checkinterval_min']." MINUTE)) AND (`broken_tag` = '1'))) AND (`id` = '".db_escape($row3['id'])."')");
		if (db_num($res_check) > 0)
		{
			db_query("UPDATE `".$WBConfig->getMySQLPrefix()."links` SET `update_lastchecked` = NOW() WHERE `id` = '".db_escape($row3['id'])."'");

			$update_checkurl = $row3['update_checkurl'];

			if (strpos($update_checkurl, '://') === false)
				$update_checkurl = 'http://'.$update_checkurl;

			$update_checkurl = entferne_anker($update_checkurl);
			$update_checkurl = decode_critical_html_characters($update_checkurl);

			$a = zwischen_url($update_checkurl, decode_critical_html_characters($row3['update_text_begin']), decode_critical_html_characters($row3['update_text_end']));
			$fehler = $a === false;

			// Debuginformationen
			$debug = $a;

			$a = md5($a);
			$b = $row3['update_lastcontent'];

			if ($fehler)
			{
				$kaputt = '1';
				$new = $row3['new_tag'];
			}
			else
			{
				$kaputt = '0';
				$new = ($a == $b) ? '0' : '1';
			}

			if ($row3['broken_tag'] != $kaputt)
			{
				db_query("UPDATE `".$WBConfig->getMySQLPrefix()."links` SET `broken_tag` = '".db_escape($kaputt)."' WHERE `id` = '".db_escape($row3['id'])."'");
			}

			if ($row3['new_tag'] != $new)
			{
				if ($new == '1')
				{
					db_query("UPDATE `".$WBConfig->getMySQLPrefix()."links` SET `new_tag` = '".db_escape($new)."', update_lastcontent = '".db_escape($a)."' WHERE `id` = '".db_escape($row3['id'])."'");

					// Dual-Crossover (statisch)
					$x2 = 'common_links_notifier';
					$inp_user = $row3['user_cnid'];

					$module_information = get_module_information($x2);

					if (file_exists('modules/'.$x2.'/static/'.$m2.'/notify.inc.php'))
					{
						include 'modules/'.$x2.'/static/'.$m2.'/notify.inc.php';
					}
				}
				else
				{
					db_query("UPDATE `".$WBConfig->getMySQLPrefix()."links` SET `new_tag` = '".db_escape($new)."' WHERE `id` = '".db_escape($row3['id'])."'");
				}
			}
		}
	}
}

?>