<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

if ($aktion == 'send')
{
	$nachricht = "Diese Nachricht wird Ihnen von dem Administrator des Servers \"".$_SERVER['HTTP_HOST']."\", beidem Sie sich ein Personal WebBase-Konto eingerichtet haben, gesendet. Es handelt sich hierbei um ein Rundschreiben, das an alle nicht banneden Benutzer des Personal WebBase-Servers gerichtet ist. Bitte melden Sie Spam dem zustängigen Verwalter.\n\n-----------------------------------------\n\n".utf8_decode(decode_critical_html_characters($message));

	$res = db_query("SELECT `email` FROM `".$WBConfig->getMySQLPrefix()."users` WHERE `email` != '' AND `banned` = '0'");
	$betreff = 'Personal WebBase Rundschreiben';

	$mailer = new SecureMailer();
	if (($configuration['main_about']['admin_mail'] != '') && (check_email($configuration['main_about']['admin_mail'])))
	{
		$mailer->addHeader('From', $configuration['main_about']['admin_mail']);
		$mailer->addHeader('Reply-To', $configuration['main_about']['admin_mail']);
	}
	$mailer->addHeader('Content-Type', 'text/plain; charset=utf-8');

	$mailer->addHeader('X-Mailer', WBUserAgent());

	while ($row = db_fetch($res))
	{
		if (isset($row['email']) && ($row['email'] != '') && (check_email($row['email'])))
		{
			if ((!mailer->sendMail($row['email'], $betreff, $nachricht) && (function_exists('fehler_melden'))))
			{
				fehler_melden($modul, '<b>Mailsendung fehlgeschlagen!</b><br><br>Das Senden einer E-Mail mit dem Betreff &quot;'.$betreff.'&quot; an &quot;'.$row['email'].'&quot; ist fehlgeschlagen!');
			}
		}
	}
	wb_redirect_now($_SERVER['PHP_SELF'].'?seite=main&modul='.$modul);
}

?>
