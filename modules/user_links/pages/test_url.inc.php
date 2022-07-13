<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

if (!url_protokoll_vorhanden($url)) $url = 'http://'.$url;

header('location: '.$url);

?>
