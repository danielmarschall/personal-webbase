<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

if (strpos($update_checkurl, '://') === false)
  $update_checkurl = 'http://'.$update_checkurl;

header('location: '.$update_checkurl);

?>
