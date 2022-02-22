<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

  echo $header;

if ($modulueberschrift == '') $modulueberschrift = $modul;
echo '<h1>'.my_htmlentities($modulueberschrift).'</h1>';

echo '<b>Informationen &uuml;ber diese Personal WebBase-Schnittstelle</b><br><br>

Version des Systems: Version '.$revision.' ('.$rev_datum.')<br>';

if ($konfiguration['core_cronjob']['passivcron'] == '1')
{
  echo 'Passive Cronjobs';
}
else
{
  if ($konfiguration['core_cronjob']['lastpromotor'] == '')
  {
    echo 'Aktive Cronjobs (Shell)';
  }
  else
  {
    echo 'Aktive Cronjobs (Promotor: <a href="http://'.$konfiguration['core_cronjob']['lastpromotor'].'/" target="_blank">'.$konfiguration['core_cronjob']['lastpromotor'].'</a>)';
  }
}

echo '<br><br>';

echo 'Es sind '.count($module).' Personal WebBase-Module installiert:<br><br>';

$mod = '';
foreach ($module as $m1 => $m2)
{
  $mod .= $module[$m1].', ';
}

unset($m1);
unset($m2);

echo '<code>'.substr($mod, 0, strlen($mod)-2).'</code><br><br>';

$des = '<code>';
$desi = 0;

$handle = @opendir('design/');
while ($file = @readdir($handle))
{
  if ((filetype('design/'.wb_dir_escape($file)) == 'dir') && ($file <> '.') && ($file <> '..'))
  {
    $des .= $file.', ';
    $desi++;
  }
}

$des = substr($des, 0, strlen($des)-2);

$des .= '</code>';

echo 'Es sind '.$desi.' Personal WebBase-Designs installiert:<br><br>'.$des.'<br><br>';

echo 'E-Mail-Adresse des Serveradministrators: ';

if (check_email($konfiguration[$modul]['admin_mail']))
  echo secure_email($konfiguration[$modul]['admin_mail'], $konfiguration[$modul]['admin_mail'], 1);
else
  echo 'Keine angegeben';

echo '<br><br>';

echo '<b>Informationen &uuml;ber Personal WebBase</b><br><br>

Personal WebBase ist ein Datenbankprojekt von <a href="https://www.viathinksoft.de/" target="_blank">ViaThinkSoft</a>.
Wichtig: Benutzerdaten werden serverseitig NICHT verschl&uuml;sselt, daher ist es
sehr zu empfehlen, Personal WebBase nur auf nicht-&ouml;ffentlichen Webservern auszuf&uuml;hren (z.B. im Intranet oder auf dem
Localhost).<br><br>

Weitere Informationen, Module und Designs sowie die aktuelle Softwareversion finden Sie im <a href="https://www.personal-webbase.de/" target="_blank">Personal WebBase Webportal</a>.<br><br>';

echo '<a href="handbuch.pdf" target="_blank"><b>Personal WebBase-Handbuch &ouml;ffnen (PDF)</b></a>';

  echo $footer;

?>
