<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

if (($ary[$i]['broken_tag'] == '1') && ($ary[$i]['new_tag'] == '1') && ($ary[$i]['update_enabled'] == '1'))
{
	$xx = '3';
	$linkinfo = ' - Update vorhanden, jedoch Seite derzeit nicht erreichbar!';
}
else if (($ary[$i]['broken_tag'] == '1') && ($ary[$i]['update_enabled'] == '1'))
{
	$xx = '2';
	$linkinfo = ' - Updatepr&uuml;fung fehlgeschlagen!';
}
else if (($ary[$i]['new_tag'] == '1') && ($ary[$i]['update_enabled'] == '1'))
{
	$xx = '1';
	$linkinfo = ' - Update vorhanden!';
}
else
{
	$xx = '0';
	if ($ary[$i]['update_enabled'] == '1')
		$linkinfo = ' - Kein Update vorhanden';
	else
		$linkinfo = ' - Updateservice deaktiviert';
}

global $suchbegriff;
if ((isset($suchbegriff)) && ($suchbegriff != '') && (function_exists('generate_search_query')))
{
	$rs = db_query(generate_search_query('links', 0, $suchbegriff, "AND `id` = '".db_escape($ary[$i]['id'])."'"));
	if (db_num($rs) != 0)
	{
		$a = '<span class="red">';
		$b = '</span>';
	}
	else
	{
		$a = '';
		$b = '';
	}
}
else
{
	$a = '';
	$b = '';
}

wb_draw_table_content('', '<a name="item'.$ary[$i]['id'].'"></a><img alt="" src="designs/spacer.gif" width="'.($einzug*$ordnereinzug).'" height="1"><img src="modules/'.$modul.'/images/item'.$xx.'.gif" alt="Link'.$linkinfo.'"><img src="designs/spacer.gif" alt="" width="5" height="1">'.$a.$ary[$i]['name'].$b.'<br><img src="designs/spacer.gif" alt="" width="1" height="1">', '100', '<a href="'.$_SERVER['PHP_SELF'].'?modul='.$modul.'&amp;seite=view&amp;id='.$ary[$i]['id'].'" target="_blank" class="menu">'.$a.'Besuchen'.$b.'</a>', '175', '<a href="'.$_SERVER['PHP_SELF'].'?seite=edit&amp;modul='.$modul.'&amp;aktion=edit&amp;id='.$ary[$i]['id'].'" class="menu">'.$a.'Bearbeiten'.$b.'</a>', '75', '<a href="javascript:abfrage(\''.$_SERVER['PHP_SELF'].'?seite=operate&amp;modul='.$modul.'&amp;aktion=delete&amp;id='.$ary[$i]['id'].'\');" class="menu">'.$a.'L&ouml;schen'.$b.'</a>');

flush();

?>