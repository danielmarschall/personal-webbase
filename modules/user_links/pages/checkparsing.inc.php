<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

echo $header;

echo '<h1>Parsing checken</h1>';

if ($update_checkurl == '')
{
  echo '<font color="#FF0000"><b>Fehler!</b> Keine URL angegeben.</font>';
}
else
{

if (!inetconn_ok())
{
  // Kann auftreten, wenn Personal WebBase von localhost aufgerufen wird
  echo '<font color="#FF0000"><b>Fehler!</b> Es gibt derzeit ein Problem mit der Internetkonnektivit&auml;t des Systems.</font>';
}
else
{

if (strpos($update_checkurl, '://') === false)
  $update_checkurl = 'http://'.$update_checkurl;

$site = my_get_contents($update_checkurl);

if ($site === false)
{
  echo '<font color="#FF0000"><b>Fehler!</b> URL &quot;'.$update_checkurl.'&quot; fehlerhaft.</font>';
}
else
{

$pattern = '/<meta(.+?)charset=(.+?)"(.+?)>/is';
preg_match($pattern, $site, $matches);
$charset = '';
if (isset($matches[2])) $charset = $matches[2];

echo '<b>Gepr&uuml;ft wird folgendes Parsing:</b><br><br>

Check-URL: <a href="'.$update_checkurl.'" target="_blank">'.$update_checkurl.'</a><br><br>

Linke Grenze';

if ($update_text_begin != '')
{
  if (@strpos($site, undo_transamp_replace_spitze_klammern($update_text_begin)) === false)
    echo ' (<font color="#FF0000">Nicht gefunden!</font>)';
  else
    echo ' (<font color="#00BB00">Gefunden!</font>)';
}

echo ':<br><br><code>';

if ($update_text_begin == '')
  echo '<i>Keine</i>';
else
  echo nl2br($update_text_begin);

echo '</code><br><br>
Rechte Grenze';

if ($update_text_end != '')
{
  if (strpos($site, undo_transamp_replace_spitze_klammern($update_text_end)) === false)
    echo ' (<font color="#FF0000">Nicht gefunden!</font>)';
  else
    echo ' (<font color="#00BB00">Gefunden!</font>)';
}

echo ':<br><br><code>';

if ($update_text_end == '')
  echo '<i>Keine</i>';
else
  echo nl2br($update_text_end);

echo '</code><br><br>';

$cont1 = zwischen_str($site, undo_transamp_replace_spitze_klammern($update_text_begin), undo_transamp_replace_spitze_klammern($update_text_end));
$cont1 = my_htmlentities($cont1, $charset);
$cont1 = str_replace("\n", '<br>', $cont1);
//$cont1 = str_replace("\r", '<br>', $cont1);

$cont2 = zwischen_str($site, undo_transamp_replace_spitze_klammern($update_text_begin), undo_transamp_replace_spitze_klammern($update_text_end));
$cont2 = my_htmlentities($cont2, $charset);
$cont2 = str_replace("\n", '<br>', $cont2);
//$cont2 = str_replace("\r", '<br>', $cont2);

if ($cont1 == $cont2)
{
  echo '<center><hr><font color="#00BB00"><b>Es existieren derzeit keine dynamischen (sich bei jedem Seitenaufruf ver&auml;ndernden) Inhalte.</b></font><hr></center>';
  echo '<font face="courier">'.$cont1.'</font>';
}
else
{
  echo '<center><hr><font color="#FF0000"><b>WARNUNG! Es existieren derzeit dynamische (sich bei jedem Seitenaufruf ver&auml;ndernde) Inhalte! Die abweichenden Zeilen wurden rot markiert.<br>Flankieren Sie die von Ihnen gew&uuml;nschten Informationen, da der Update-Service ansonsten st&auml;ndig ein Seitenupdate meldet.</b></font><hr></center>';
  echo '<font face="courier">';
  $ary1 = explode("<br>", $cont1);
  $ary2 = explode("<br>", $cont2);

  foreach ($ary1 as $m1 => $m2)
  {
    if ($ary1[$m1] == $ary2[$m1])
      echo $ary1[$m1].'<br>';
    else
      echo '<font color="#FF0000">'.$ary1[$m1].'</font><br>';
  }

  unset($m1);
  unset($m2);

  echo '</font>';
}

}

}

}

echo '<br><br><div align="center">';
echo '<input type="submit" onclick="javascript:window.close();" value="Schlie&szlig;en" class="button" onmouseover="this.className=\'button_act\';" onmouseout="this.className=\'button\';">';
echo '</div>';

echo $footer;

?>
