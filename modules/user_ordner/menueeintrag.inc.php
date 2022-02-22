<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

global $suchbegriff;
if ((isset($suchbegriff)) && ($suchbegriff != '') && (function_exists('generate_search_query')))
{
  $rs = db_query(generate_search_query('ordner', 0, $suchbegriff, "AND `id` = '".db_escape($ary[$i]['id'])."'"));
  if (db_num($rs) != 0)
  {
    $a = '<font color="#FF0000">';
    $b = '</font>';
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


if (file_exists(__DIR__.'/images/menu/16.png')) {
	$ordner_16_pic = 'modules/user_ordner/images/menu/16.png';
} else if (file_exists(__DIR__.'/images/menu/16.gif')) {
	$ordner_16_pic = 'modules/user_ordner/images/menu/16.gif';
} else {
	$ordner_16_pic = 'design/spacer.gif';
}
gfx_tablecontent('', '<a name="ordner'.$ary[$i]['id'].'"></a><img src="design/spacer.gif" width="'.($einzug*$ordnereinzug).'" height="1" alt=""><img src="'.$ordner_16_pic.'" alt="Ordner"><img src="design/spacer.gif" width="5" height="1" alt="">'.$a.$ary[$i]['name'].$b.'<br><img src="design/spacer.gif" alt="" width="1" height="1">', '150', '<a href="'.$_SERVER['PHP_SELF'].'?seite=edit&amp;modul='.urlencode($modul).'&amp;aktion=new&amp;folder='.urlencode($ary[$i]['id']).'" class="menu">'.$a.'Neuer Eintrag'.$b.'</a>', '175', '<a href="'.$_SERVER['PHP_SELF'].'?seite=edit&amp;modul=user_ordner&amp;aktion=edit&amp;id='.urlencode($ary[$i]['id']).'&amp;kategorie='.urlencode($modul).'" class="menu">'.$a.'Bearbeiten / Verschieben'.$b.'</a>', '75', '<a href="javascript:abfrage(\''.$_SERVER['PHP_SELF'].'?seite=kraftsetzung&amp;modul=user_ordner&amp;aktion=delete&amp;kategorie='.urlencode($modul).'&amp;id='.urlencode($ary[$i]['id']).'\');" class="menu">'.$a.'L&ouml;schen'.$b.'</a>');

?>
