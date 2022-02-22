<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

global $suchbegriff;
if ((isset($suchbegriff)) && ($suchbegriff != '') && (function_exists('generate_search_query')))
{
  $rs = db_query(generate_search_query('confixx', 0, $suchbegriff, "AND `id` = '".db_escape($ary[$i]['id'])."'"));
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

gfx_tablecontent('', '<a name="item'.$ary[$i]['id'].'"></a><img src="design/spacer.gif" alt="" width="'.($einzug*$ordnereinzug).'" height="1"><img src="modules/'.wb_dir_escape($modul).'/item.gif" alt="Confixx"><img src="design/spacer.gif" alt="" width="5" height="1">'.$a.$ary[$i]['username'].'@'.$ary[$i]['server'].$b.'<br><img src="design/spacer.gif" alt="" width="1" height="1">', '100', '<a href="javascript:open_url(\''.$_SERVER['PHP_SELF'].'?seite=view&amp;modul='.urlencode($modul).'&amp;id='.urlencode($ary[$i]['id']).'\');" class="menu">'.$a.'Besuchen'.$b.'</a>', '175', '<a href="'.$_SERVER['PHP_SELF'].'?seite=edit&amp;modul='.urlencode($modul).'&amp;aktion=edit&amp;id='.urlencode($ary[$i]['id']).'" class="menu">'.$a.'Bearbeiten / Verschieben'.$b.'</a>', '75', '<a href="javascript:abfrage(\''.$_SERVER['PHP_SELF'].'?seite=kraftsetzung&amp;modul='.urlencode($modul).'&amp;aktion=delete&amp;id='.urlencode($ary[$i]['id']).'\');" class="menu">'.$a.'L&ouml;schen'.$b.'</a>');

?>
