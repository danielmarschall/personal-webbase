<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne IronBASE ausgef&uuml;hrt werden.');

if (!url_protokoll_vorhanden($url)) $url = 'http://'.$url;

header('location: '.$url);

?>