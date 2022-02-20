<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

global $suchbegriff;
if ((isset($suchbegriff)) && ($suchbegriff != '') && (function_exists('generate_search_query')))
{
  $rs = db_query(generate_search_query('popper_konten', 0, $suchbegriff, "AND `id` = '".db_escape($ary[$i]['id'])."'"));
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

$res = db_query("SELECT COUNT(`id`) AS `ct` FROM `".$mysql_zugangsdaten['praefix']."popper_messages` WHERE `user` = '".$ary[$i]['id']."' AND `was_read` = '0'");
$row = db_fetch($res);
gfx_tablecontent('', '<a name="item'.$ary[$i]['id'].'"></a><img src="design/spacer.gif" width="'.($einzug*$ordnereinzug).'" height="1" alt=""><img src="modules/'.$modul.'/item.gif" alt="E-Mail-Konto"><img src="design/spacer.gif" width="5" height="1" alt="">'.$a.$ary[$i]['name'].' ('.$row['ct'].')'.$b.'<br><img src="design/spacer.gif" alt="" width="1" height="1">', '100', '<a href="'.$_SERVER['PHP_SELF'].'?seite=view&amp;modul=user_popper&amp;id='.$ary[$i]['id'].'" target="_parent" class="menu">'.$a.'Anzeigen'.$b.'</a>', '175', '<a href="'.$_SERVER['PHP_SELF'].'?seite=edit&amp;modul='.$modul.'&amp;aktion=edit&amp;id='.$ary[$i]['id'].'" class="menu">'.$a.'Bearbeiten / Verschieben'.$b.'</a>', '75', '<a href="javascript:abfrage(\''.$_SERVER['PHP_SELF'].'?seite=kraftsetzung&amp;modul='.$modul.'&amp;aktion=delete&amp;id='.$ary[$i]['id'].'\');" class="menu">'.$a.'L&ouml;schen'.$b.'</a>');

?>
