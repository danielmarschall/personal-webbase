<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

$cookies_to_delete = array();

$cookies_to_delete[] = 'wb_fastlogin_key';

foreach($cookies_to_delete as $val) {
	wbUnsetCookie($val);
}

unset($val);
unset($cookies_to_delete);

?>
