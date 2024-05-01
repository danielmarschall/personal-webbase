<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

$desname = '';

if (file_exists('designs/default.inc.php'))
{
	include ('designs/default.inc.php');
}

wb_add_config('design', $desname, $m2);

?>