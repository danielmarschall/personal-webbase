<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne IronBASE ausgef&uuml;hrt werden.');

if (isset($_SERVER['SERVER_ADMIN']))
  $adm = $_SERVER['SERVER_ADMIN'];
else
  $adm = '';

ib_add_config('admin_mail', $adm, $m2);

?>