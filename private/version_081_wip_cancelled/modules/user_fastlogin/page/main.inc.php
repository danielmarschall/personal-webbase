<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

echo $header;

echo '<h1>'.wb_htmlentities($module_information->caption).'</h1>';

echo '<b>Aktueller Status</b><br><br>';

if ($wb_user_type == 0)
{
	echo '<span class="red">Diese Funktion ist im Gastzugang nicht verf&uuml;gbar.</span>';
}
else
{
	if (!$configuration['common_fastlogin_access']['enabled'])
	{
		echo '<span class="red">Der Administrator hat die Schnellanmeldung deaktiviert.</span>';
	}
	else
	{
		echo '<table cellspacing="0" cellpadding="0" border="0">
<tr>
	<td valign="top">Status:<img src="designs/spacer.gif" height="1" width="35" alt=""></td>
	<td valign="top">';

		if ((isset($benutzer['fastlogin_secret'])) && ($benutzer['fastlogin_secret'] != ''))
		{
			echo '<p><span class="green"><b>Dienst aktiviert</b></span> (Ein Schnellanmeldegeheimnis liegt vor)</p>';

			echo '<p>Seriennummer Ihres Schnellanmeldegeheimnisses: '.$benutzer['fastlogin_serial'].'.</p>';

			// Anmerkung: Der Cookieinhalt wird nicht auf Gültigkeit geprüft
			// Wäre der Inhalt ungültig, würde main_login/autostart/2.inc.php beim nächsten
			// Sessionverlust (= Auslesen des Cookies) den Fehler erkennen und das Cookie löschen.

			if (isset($_COOKIE['wb_fastlogin_key'])) {
				echo '<p>Das Cookie f&uuml;r das dauerhafte Einloggen ist derzeit in diesem Browser <span class="green"><b>eingerichtet</b></span>.</p>';
			} else {
				echo '<p>Das Cookie f&uuml;r das dauerhafte Einloggen ist derzeit in diesem Browser <span class="red"><b>nicht eingerichtet</b></span>.</p>';
			}

			echo '<br></td></tr><tr>
	<td valign="top">Aktionen:<img src="designs/spacer.gif" height="1" width="35" alt=""></td>
	<td valign="top">';

			if (isset($_COOKIE['wb_fastlogin_key'])) {
				echo '<p><a href="'.$_SERVER['PHP_SELF'].'?modul='.$modul.'&amp;seite=operate&amp;aktion=delcookie">Cookie f&uuml;r die Daueranmeldung an diesem Browser entfernen</a><br>
				Dieser Browser loggt sich danach nicht mehr dauerhaft ein. Diese Aktion wird ebenfalls bei einem Klick auf "Ausloggen" durchgef&uuml;hrt.</p>';
			} else {
				echo '<p><a href="'.$_SERVER['PHP_SELF'].'?modul='.$modul.'&amp;seite=operate&amp;aktion=reget">Cookie einrichten, ohne das Schnellanmeldegeheimnis zu &auml;ndern</a><br>
				Geeignet bei gleichzeitiger Benutzung auf einem weiteren Computer/Browser oder zur einmaligen Einrichtung.</p>';
			}

			echo '<p><a href="'.$_SERVER['PHP_SELF'].'?modul='.$modul.'&amp;seite=operate&amp;aktion=generate">Schnellanmeldegeheimnis neu generieren und das neue Cookie auf diesem Browser einrichten</a><br>
			Ein neues Cookie wird eingerichtet und alle bisherigen Cookies werden ung&uuml;ltig.</p>';

			echo '<p><a href="'.$_SERVER['PHP_SELF'].'?modul='.$modul.'&amp;seite=operate&amp;aktion=destroy">Diesen Dienst deaktivieren, Schnellanmeldegeheimnis vernichten und Cookie bei diesem Browser l&ouml;schen</a><br>
			Sie k&ouml;nnen den Dienst nach der Abmeldung jederzeit wieder aktivieren.</p>';
		}
		else
		{
			echo '<p><span class="red"><b>Dienst deaktiviert</b></font> (Ex ist kein Schnellanmeldegeheimnis hinterlegt)</p>';

			echo '<br></td></tr><tr>
	<td valign="top">Aktionen:<img src="designs/spacer.gif" height="1" width="35" alt=""></td>
	<td valign="top">';

			echo '<p><a href="'.$_SERVER['PHP_SELF'].'?modul='.$modul.'&amp;seite=operate&amp;aktion=generate">Dienst aktivieren, ein Schnellanmeldegeheimnis generieren und das Cookie einrichten</a><br>
			Damit wird Ihr Browser f&uuml;r das dauerhafte Login eingerichtet.</p>';
		}

		echo '</td>
</tr>
</table>';
	}
}

echo '<p><b>Hintergrundinformation</b></p>

<p>Um schneller auf Ihre Personal WebBase-Datenbank zugreifen zu k&ouml;nnen,
haben Sie hier die M&ouml;glichkeit, ein Cookie einzurichten, damit Sie dauerhaft
eingeloggt bleiben.</p>

<p>Es handelt sich hierbei um eine Cookie mit einer geheimen Sequenz
die in verschl&uuml;sselter Form Ihre Zugangsdaten enth&auml;lt und Ihnen das Einloggen
erleichert. Dass Entschl&uuml;sselungspasswort f&uuml;r das Cookie liegt auf dem
Server vor und kann jederzeit neu generiert werden, um alle ggf. gestohlenen Cookies
ung&uuml;ltig zu machen.</p>

<p>Achtung! Lassen Sie niemals Fremde an Ihren Computer, wenn das Cookie vergeben ist
(Das Selbe gilt f&uuml;r gespeicherte Passw&ouml;rter, die ausgelesen werden k&ouml;nnen)!
Ein Fremder k&ouml;nnte den Inhalt des Cookies, der auf Ihrem Browser gespeichert ist,
stehlen und sich damit in Ihren Account einloggen. Ihr tats&auml;chliches Passwort
kann jedoch aus dem Cookie nicht rekonstruiert werden, da es zwar als Autorisierungsmittel
gilt, jedoch weder von Ihnen, noch von einem Hacker entschl&uuml;sselt werden kann,
da das Passwort auf dem Server stationiert ist. Da Passw&ouml;rter nur mit einem Passwort
ge&auml;ndert werden k&ouml;nnen, bleibt Ihr Account deshalb auch bei einem Hack-Szenario
erhalten. (Die Benutzerdaten k&ouml;nnen jedoch gelesen, manipuliert oder vernichtet werden).</p>

<p>Die Information, die in Ihrem Cookie gespeichert ist, wird wertlos, sobald Sie Ihre
interne Datenbank-ID, Ihren Benutzernamen, Ihr Passwort oder Ihr Schnellanmeldegeheimnis (das auf dem Server gespeicherte Entschl&uuml;sselungspasswort)
&auml;ndern. &Auml;ndern Sie daher das Schnellanmeldegeheimnis mehrmals, wenn Sie an nur einem
Computer/Browser arbeiten. Arbeiten Sie an mehreren Computern/Browsern, m&uuml;ssen Sie jedem Browser das
selbe Cookie geben, damit alle den Dauerzugang erhalten. Eine Passwort&auml;nderung hat dann
zur Folge, dass Sie sich auf allen Computern nocheinmal einloggen und das Cookie einrichten m&uuml;ssen.</p>

<p>Sollen Sie den Verdacht haben, dass Ihr Cookie ausgelesen wurde, sollten Sie dringenst Ihr
Schnellanmeldegeheimnis neu generieren. Dadurch verlieren alle bisher vergebenen Cookies Ihre G&uuml;ltigkeit.
Damit ein im Moment eingeloggter Benutzer sofort den Zugang verliert, sollten
Sie zus&auml;tzlich Ihr Passwort &auml;ndern, damit die bestehende Kurzzeitsession,
die durch das Cookie eingerichtet wurde, ebenfalls ihre G&uuml;ltigkeit verliert.</p>

<p>Aktivieren Sie diese Funktionalit&auml;t daher nur, wenn Sie den Dauerzugang auch
tats&auml;chlich nutzen. Ist der Zugang aktiviert, ist ein potenzieller Angriff m&ouml;glich.</p>

<p>Diagramme: <a href="modules/'.$modul.'/images/diagramme/diagramm1.gif" target="_blank">Setzen eines Cookies</a>,
<a href="modules/'.$modul.'/images/diagramme/diagramm2.gif" target="_blank">Lesen eines Cookies</a>,
<a href="modules/'.$modul.'/images/diagramme/diagramme.ppt" target="_blank">PowerPoint Format</a></p>';

echo $footer;

?>
