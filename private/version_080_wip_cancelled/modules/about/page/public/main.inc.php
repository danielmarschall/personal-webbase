<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

echo $header;

echo '<h1>'.htmlentities($module_information->caption).'</h1>';

echo '<center><b>Informationen &uuml;ber dieses Personal WebBase System</b></center><br>';

$info_version = 'Personal WebBase '.$WBConfig->getRevision().', Revision '.$WBConfig->getRevDatum();

$info_url = '<a href="'.deferer($configuration['common_links_notifier']['wb_system_url']).'" target="_blank" class="menu">'.$configuration['common_links_notifier']['wb_system_url'].'</a>';

$info_ip = '<a href="'.ip_tracer($_SERVER['SERVER_ADDR']).'" target="_blank" class="menu">'.$_SERVER['SERVER_ADDR'].'</a>';

$info_systemzeit = date('Y-m-d, H:i:s');
$info_systemzeit = de_convertmysqldatetime($info_systemzeit);

if ($configuration['common_cronjob']['passivcron'] == '1')
{
	$info_cronjobs = 'Passive Cronjobs';
}
else
{
	if ($configuration['common_cronjob']['lastpromoter'] == '')
	{
		$info_cronjobs = 'Aktive Cronjobs (Shell)';
	}
	else
	{
		$info_cronjobs = 'Aktive Cronjobs (Promoter: <a href="'.deferer('http://'.$configuration['common_cronjob']['lastpromoter'].'/').'" target="_blank" class="menu">http://'.$configuration['common_cronjob']['lastpromoter'].'/</a>)';
	}
}

$info_module = count($modules);

$info_designs = 0;
$handle = @opendir('designs/');
while ($file = @readdir($handle))
{
	if ((filetype('designs/'.$file) == 'dir') && ($file <> '.') && ($file <> '..'))
	{
		$info_designs++;
	}
}

$design_information = WBDesignHandler::get_design_information($configuration['admin_designs']['design']);

$info_design = $design_information->name;

$info_datenbank = 'mysql://';
$info_datenbank .= $WBConfig->getMySQLUsername();
$info_datenbank .= '@';
$info_datenbank .= $WBConfig->getMySQLServer();
if ($WBConfig->getMySQLPort() != '')
{
	$info_datenbank .= ':';
	$info_datenbank .= $WBConfig->getMySQLPort();
}
$info_datenbank .= '/';
$info_datenbank .= $WBConfig->getMySQLDatabase();
$info_datenbank .= '/';
$info_datenbank .= $WBConfig->getMySQLPrefix();
$info_datenbank .= '*';

if (check_email($configuration[$modul]['admin_mail']))
{
	$info_admin = secure_email($configuration[$modul]['admin_mail'], $configuration[$modul]['admin_mail'], 1);
	$info_admin = str_replace('<a href=\"', '<a class=\"menu\" href=\"', $info_admin);
}
else
{
	$info_admin = 'Keine E-Mail-Adresse angegeben';
}

wb_draw_table_begin();
wb_draw_table_content('35%', '<b>System-Version</b>', '65%', $info_version);
wb_draw_table_content('35%', '<b>System-URL</b>', '65%', $info_url);
wb_draw_table_content('35%', '<b>IP-Adresse</b>', '65%', $info_ip);
wb_draw_table_content('35%', '<b>Systemzeit</b>', '65%', $info_systemzeit);
wb_draw_table_content('35%', '<b>Cronjobs</b>', '65%', $info_cronjobs);
wb_draw_table_content('35%', '<b>Installierte Module</b>', '65%', $info_module);
wb_draw_table_content('35%', '<b>Installierte Designs</b>', '65%', $info_designs);
wb_draw_table_content('35%', '<b>Aktuelles Design</b>', '65%', $info_design);
wb_draw_table_content('35%', '<b>Datenbank-Speicherort</b>', '65%', $info_datenbank);
wb_draw_table_content('35%', '<b>Administrator-Kontakt</b>', '65%', $info_admin);
wb_draw_table_end();

echo '<center>&copy; 2004 - '.date('Y').' <a href="'.deferer('http://www.viathinksoft.de/').'" target="_blank">ViaThinkSoft</a>. Alle Rechte vorbehalten!<br>
<b><a href="'.deferer('http://www.personal-webbase.de/').'" target="_blank">Personal WebBase Webportal</a></b></center>';

echo $footer;

?>
