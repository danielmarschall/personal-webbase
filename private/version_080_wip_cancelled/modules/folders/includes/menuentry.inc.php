<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

global $suchbegriff;
if ((isset($suchbegriff)) && ($suchbegriff != '') && (function_exists('generate_search_query')))
{
	$rs = db_query(generate_search_query('folders', 0, $suchbegriff, "AND `id` = '".db_escape($ary[$i]['id'])."'"));
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

wb_draw_table_content('', '<a name="folder'.$ary[$i]['id'].'"></a><img src="designs/spacer.gif" width="'.($einzug*$ordnereinzug).'" height="1" alt=""><img src="modules/user_folders/images/item.gif" alt="Ordner"><img src="designs/spacer.gif" width="5" height="1" alt="">'.$a.$ary[$i]['name'].$b.'<br><img src="designs/spacer.gif" alt="" width="1" height="1">', '150', '<a href="'.$_SERVER['PHP_SELF'].'?seite=edit&amp;modul='.$modul.'&amp;aktion=new&amp;folder='.$ary[$i]['id'].'" class="menu">'.$a.'Neuer Eintrag'.$b.'</a>', '175', '<a href="'.$_SERVER['PHP_SELF'].'?seite=edit&amp;modul=user_folders&amp;aktion=edit&amp;id='.$ary[$i]['id'].'&amp;category='.$modul.'" class="menu">'.$a.'Bearbeiten'.$b.'</a>', '75', '<a href="javascript:abfrage(\''.$_SERVER['PHP_SELF'].'?seite=operate&amp;modul=user_folders&amp;aktion=delete&amp;category='.$modul.'&amp;id='.$ary[$i]['id'].'\');" class="menu">'.$a.'L&ouml;schen'.$b.'</a>');

flush();

?>