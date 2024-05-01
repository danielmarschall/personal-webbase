<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

global $suchbegriff;
if ((isset($suchbegriff)) && ($suchbegriff != '') && (function_exists('generate_search_query')))
{
	$rs = db_query(generate_search_query('phpmyadmin', 0, $suchbegriff, "AND `id` = '".db_escape($ary[$i]['id'])."'"));
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

wb_draw_table_content('', '<a name="item'.$ary[$i]['id'].'"></a><img src="designs/spacer.gif" width="'.($einzug*$ordnereinzug).'" height="1" alt=""><img src="modules/'.$modul.'/images/item.gif" alt="phpMyAdmin-Konto"><img src="designs/spacer.gif" width="5" height="1" alt="">'.$a.$ary[$i]['username'].'@'.$ary[$i]['server'].$b.'<br><img src="designs/spacer.gif" alt="" width="1" height="1">', '100', '<a href="'.$_SERVER['PHP_SELF'].'?seite=view&amp;modul='.$modul.'&amp;id='.$ary[$i]['id'].'" target="_blank" class="menu">'.$a.'Besuchen'.$b.'</a>', '175', '<a href="'.$_SERVER['PHP_SELF'].'?seite=edit&amp;modul='.$modul.'&amp;aktion=edit&amp;id='.$ary[$i]['id'].'" class="menu">'.$a.'Bearbeiten'.$b.'</a>', '75', '<a href="javascript:abfrage(\''.$_SERVER['PHP_SELF'].'?seite=operate&amp;modul='.$modul.'&amp;aktion=delete&amp;id='.$ary[$i]['id'].'\');" class="menu">'.$a.'L&ouml;schen'.$b.'</a>');

flush();

?>