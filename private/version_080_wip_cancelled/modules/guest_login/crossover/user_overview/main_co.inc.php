<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

if (($configuration[$m2]['wipe_gastkonto']) && ($wb_user_type == 0))
{
	wb_draw_table_content('30', '<b>!</b>', '', 'Der Datenbestand dieses Gastkontos wird t&auml;glich um <span class="red">'.$configuration[$m2]['wipe_uhrzeit'].' Uhr</span> gel&ouml;scht!', '', '');
}

?>