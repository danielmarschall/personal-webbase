<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne IronBASE ausgef&uuml;hrt werden.');

ib_add_config('last_cronjob', '0000-00-00 00:00:00', $m2);
ib_add_config('passivcron', '0', $m2);
ib_add_config('lastpromotor', '', $m2);

?>