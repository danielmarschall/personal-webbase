<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

if ($aktion == 'change_configuration')
{
	wb_change_config('ftp-server', db_escape($ftpserver), $modul);
	wb_change_config('ftp-username', db_escape($ftpuser), $modul);
	wb_change_config('ftp-password', db_escape($ftppassword), $modul);
	wb_change_config('ftp-verzeichnis', db_escape($ftpverzeichnis), $modul);
	if ((isset($ftpport)) && (is_numeric($ftpport)))
	{
		wb_change_config('ftp-port', db_escape($ftpport), $modul);
	}

	if (!isset($vonmodul)) $vonmodul = 'admin_configuration';
	if (!isset($vonseite)) $vonseite = 'main';

	if ((isset($zwischenspeichern)) && ($zwischenspeichern == '1'))
	{
		wb_redirect_now($_SERVER['PHP_SELF'].'?seite=config&modul='.$modul.'&vonmodul='.$vonmodul.'&vonseite='.$vonseite);
	}
	else
	{
		wb_redirect_now($_SERVER['PHP_SELF'].'?seite='.$vonseite.'&modul='.$vonmodul);
	}
}

?>