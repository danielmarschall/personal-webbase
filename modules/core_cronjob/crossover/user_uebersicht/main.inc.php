<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

if ($konfiguration[$m2]['passivcron'] == '1')
  gfx_tablecontent('30', '<b>!</b>', '', 'Der Server-Crondienst ist gest&ouml;rt oder deaktiviert! Anfragen k&ouml;nnen sich folglich etwas verz&ouml;gern.', '', '');

?>
