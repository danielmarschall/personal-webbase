<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

global $suchbegriff;
if ((isset($suchbegriff)) && ($suchbegriff != '') && (function_exists('generate_search_query')))
{
  $rs = db_query(generate_search_query('zugangsdaten', 0, $suchbegriff, "AND `id` = '".db_escape($ary[$i]['id'])."'"));
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

gfx_tablecontent('', '<a name="item'.$ary[$i]['id'].'"></a><img src="design/spacer.gif" width="'.($einzug*$ordnereinzug).'" height="1" alt=""><img src="modules/'.$modul.'/item.gif" alt="Zugangsdaten"><img src="design/spacer.gif" width="5" height="1" alt="">'.$a.$ary[$i]['name'].$b.'<br><img src="design/spacer.gif" width="1" height="1" alt="">', '', '', '175', '<a href="'.$_SERVER['PHP_SELF'].'?seite=edit&amp;modul='.$modul.'&amp;aktion=edit&amp;id='.$ary[$i]['id'].'" class="menu">'.$a.'Bearbeiten / Verschieben'.$b.'</a>', '75', '<a href="javascript:abfrage(\''.$_SERVER['PHP_SELF'].'?seite=kraftsetzung&amp;modul='.$modul.'&amp;aktion=delete&amp;id='.$ary[$i]['id'].'\');" class="menu">'.$a.'L&ouml;schen'.$b.'</a>');

?>
