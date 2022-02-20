<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne IronBASE ausgef&uuml;hrt werden.');

if (($konfiguration[$m2]['wipe_gastkonto']) && ($ib_user_type == 0))
{
  gfx_tablecontent('30', '<b>!</b>', '', 'Der Datenbestand dieses Gastkontos wird regelm&auml;&szlig;ig um <font color="#FF0000">'.$konfiguration[$m2]['wipe_uhrzeit'].' Uhr</font> gel&ouml;scht!', '', '');
}

?>