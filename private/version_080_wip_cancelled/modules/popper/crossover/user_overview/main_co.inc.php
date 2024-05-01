<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

// Neue E-Mails

$res = db_query("SELECT DISTINCT `konto_cnid` FROM `".$WBConfig->getMySQLPrefix()."popper_messages` WHERE `was_read` = '0' AND `user_cnid` = '".$benutzer['id']."'");
$ereignisse['email_neu'] = db_num($res);

if ($ereignisse['email_neu'] != 1)
	$plural_email = 'f&auml;cher';
else
	$plural_email = 'fach';

if ($ereignisse['email_neu'])
	$email_weiter = '<div align="right"><a href="'.$_SERVER['PHP_SELF'].'?inhalt=inhalt&amp;modul='.$m2.'" class="menu">Anzeigen &gt;&gt;</a></div>';
else
	$email_weiter = '';

if ($ereignisse['email_neu'] > 0)
{
	$a1 = '<span class="red">';
	$a2 = '</span>';
}
else
{
	$a1 = '';
	$a2 = '';
}

wb_draw_table_content('30', $a1.'<b>'.$ereignisse['email_neu'].'</b>'.$a2, $a1.''.$a2, $a1.'Post'.$plural_email.' mit neuen Nachrichten.'.$a2, $a1.''.$a2, $a1.$email_weiter.$a2);

?>