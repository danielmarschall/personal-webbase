<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

if ($ib_user_type < 2) die('Keine Zugriffsberechtigung');

  echo $header;

  if (!isset($vonmodul)) $vonmodul = $modul;
  if (!isset($vonseite)) $vonseite = 'inhalt';

if ($modulueberschrift == '') $modulueberschrift = $modul;
echo '<h1>'.my_htmlentities($modulueberschrift).'</h1>';
  echo 'Hier k&ouml;nnen Sie Konfigurationen an Personal WebBase-Modulen manuell vornehmen. Dies wird jedoch nicht empfohlen, da auch Fehlkonfigurationen mit ung&uuml;ltigen Werten angenommen werden.<br><br>';

  gfx_begintable();
  gfx_tablecontent('', '<b>Modul</b>', '', '<b>Eigenschaft</b>', '', '<b>Wert</b>', '', '<b>Aktionen</b>', '', '');
  $res = db_query("SELECT `id`, `name`, `wert`, `modul` FROM `".$mysql_zugangsdaten['praefix']."konfig` ORDER BY `modul` ASC, `name` ASC");
  while ($row = db_fetch($res))
  {
    if (isset($only) && ($row['modul'] == $only))
    {
	  $s1 = '<font color="#FF0000">';
	  $s2 = '</font>';
	}
	else
	{
      $s1 = '';
      $s2 = '';
    }
    if (is_dir('modules/'.$row['modul']))
    {
      $z = '';
      $x = 'Standard herstellen';
    }
    else
    {
      $z = ' (Nicht mehr installiert)';
      $x = 'Wert entfernen';
    }
    gfx_tablecontent('', $s1.my_htmlentities($row['modul']).$z.$s2, '',  $s1.my_htmlentities($row['name']).$s2, '', $s1.my_htmlentities($row['wert']).$s2, '', '<a href="'.$_SERVER['PHP_SELF'].'?modul='.$modul.'&amp;seite=edit&amp;id='.$row['id'].'" class="menu">'.$s1.'Bearbeiten'.$s2.'</a>', '', '<a href="javascript:abfrage(\''.$_SERVER['PHP_SELF'].'?modul='.$modul.'&amp;seite=kraftsetzung&amp;aktion=delete&amp;id='.$row['id'].'\');" class="menu">'.$s1.$x.$s2.'</a>');
  }
  gfx_endtable();

  echo '<input type="button" onclick="document.location.href=\''.$_SERVER['PHP_SELF'].'?modul='.$vonmodul.'&amp;seite='.$vonseite.'\';" class="button" onmouseover="this.className=\'button_act\';" onmouseout="this.className=\'button\';" value="Zur&uuml;ck">';

  echo $footer;

?>
