<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne IronBASE ausgef&uuml;hrt werden.');

  echo $header;

if ($modulueberschrift == '') $modulueberschrift = $modul;
echo '<h1>'.htmlentities($modulueberschrift).'</h1>';

echo '<b>Informationen &uuml;ber diese IronBASE-Schnittstelle</b><br><br>

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

echo 'Es sind '.count($module).' IronBASE-Module installiert:<br><br>';

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
  if ((filetype('design/'.$file) == 'dir') && ($file <> '.') && ($file <> '..'))
  {
    $des .= $file.', ';
    $desi++;
  }
}

$des = substr($des, 0, strlen($des)-2);

$des .= '</code>';

echo 'Es sind '.$desi.' IronBASE-Designs installiert:<br><br>'.$des.'<br><br>';

echo 'E-Mail-Adresse des Serveradministrators: ';

if (check_email($konfiguration[$modul]['admin_mail']))
  echo secure_email($konfiguration[$modul]['admin_mail'], $konfiguration[$modul]['admin_mail'], 1);
else
  echo 'Keine angegeben';

echo '<br><br>';

echo '<b>Informationen &uuml;ber IronBASE</b><br><br>

IronBASE ist ein Datenbankprojekt von <a href="http://www.viathinksoft.de/" target="_blank">ViaThinkSoft</a>. Leider ist es aus Performance-
und Entwicklungsgr&uuml;nden nicht m&ouml;glich, eine Verschl&uuml;sselung zur
Verf&uuml;gung zu stellen. Daher k&ouml;nnen wir nicht garantieren, dass Ihre Daten auf
Nicht-ViaThinkSoft-Servern sicher behandelt werden.<br><br>

Weitere Informationen, Module und Designs sowie die aktuelle Publikation finden Sie im <a href="http://www.ironbase-portal.de.vu/" target="_blank">IronBASE Webportal</a>.<br><br>';

echo '<a href="handbuch.pdf" target="_blank"><b>IronBASE-Handbuch &ouml;ffnen (PDF)</b></a>';

  echo $footer;

?>