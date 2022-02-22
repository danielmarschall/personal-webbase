<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

if (!inetconn_ok())
{
  fehler_melden($m2, '<b>Internetanbindung gest&ouml;rt</b><br><br>Es gab ein Problem mit der Internetverbindung des Servers. Der Link-Updateservice und andere Module, die auf eine korrekte Internetverbindung angewiesen sind, waren entweder eingeschr&auml;nkt oder in ihrer Funktion fehlerhaft.');
}

?>
