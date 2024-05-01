<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

function show_modul_search($modul, $seite)
{
	global $suchbegriff;

	if (!isset($suchbegriff)) $suchbegriff = '';

	echo '<form method="POST" name="mainform" action="'.$_SERVER['PHP_SELF'].'">
	<input type="hidden" name="seite" value="'.$seite.'">
	<input type="hidden" name="modul" value="'.$modul.'">

	<div align="center"><table cellspacing="0" cellpadding="2" border="0" width="90%">
	<tr>
	<td align="left" width="50%" valign="bottom">';

	if ($suchbegriff != '')
		echo 'Eintr&auml;ge mit Suchbegriff &quot;'.$suchbegriff.'&quot; sind <span class="red">hervorgehoben</span>.';
	else
		echo '&nbsp;';

	echo '</td>
	<td align="right" valign="middle">

	Suchen: <input type="text" name="suchbegriff" value="'.$suchbegriff.'" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" size="30">
	<input type="submit" class="button" onmouseover="this.className=\'button_act\';" onmouseout="this.className=\'button\';" value="Suchen">

	</td></tr></table></div>

	</form>';
}

function generate_search_query($table, $mode, $suchbegriff, $append = '')
{
	global $tables_database;
	global $WBConfig;
	global $benutzer;

	if (is_searchable($table))
	{
		// Mode 0: a b c --> %a b c%
		if ($mode == 0)
		{
			$que = "SELECT `id` FROM `".$WBConfig->getMySQLPrefix().db_escape($table)."` WHERE (";

			foreach ($tables_database[$WBConfig->getMySQLPrefix().$table] as $m1 => $m2)
			{
				if (($m1 != 'id') && ($m1 != 'user_cnid') && ($m1 != 'folder_cnid'))
				{
					$que .= "`$m1` LIKE '%".db_escape($suchbegriff)."%' OR ";
				}
			}

			unset($m1);
			unset($m2);

			$que = substr($que, 0, strlen($que)-4).") AND `user_cnid` = '".$benutzer['id']."'";
			if ($append != '') $que .= ' '.$append;
			return $que;
		}
		else
		{
			return false;
		}
	}
	else
	{
		return false;
	}
}

?>