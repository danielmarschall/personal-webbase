<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

echo $header;

echo '<h1>Parsing checken</h1>';

if ($update_checkurl == '')
{
	echo '<span class="red"><b>Fehler!</b> Keine URL angegeben.</span>';
}
else
{
	if (!inetconn_ok())
	{
		// Kann auftreten, wenn Personal WebBase von localhost aufgerufen wird
		echo '<span class="red"><b>Fehler!</b> Es gibt derzeit ein Problem mit der Internetkonnektivit&auml;t des Systems.</span>';
	}
	else
	{
		$update_checkurl = entferne_anker($update_checkurl);
		$update_checkurl = decode_critical_html_characters($update_checkurl);

		if (!url_protokoll_vorhanden($update_checkurl))
		{
			$update_checkurl = 'http://'.$update_checkurl;
		}

		$site = my_get_contents($update_checkurl);

		if ($site === false)
		{
			echo '<span class="red"><b>Fehler!</b> URL &quot;'.$update_checkurl.'&quot; fehlerhaft.</span>';
		}
		else
		{
			$pattern = '/<meta(.+?)charset=(.+?)"(.+?)>/is';
			preg_match($pattern, $site, $matches);
			$charset = '';
			if (isset($matches[2])) $charset = $matches[2];

			echo '<p><b>Gepr&uuml;ft wird folgendes Parsing:</b></p>

			<p>Check-URL: <a href="'.$update_checkurl.'" target="_blank">'.$update_checkurl.'</a></p>

			<p>Linke Grenze';

			if ($update_text_begin != '')
			{
				if (@strpos($site, decode_critical_html_characters($update_text_begin)) === false)
				{
					echo ' (<span class="red">Nicht gefunden!</span>)';
				}
				else
				{
					echo ' (<span class="green">Gefunden!</span>)';
				}
			}

			echo ':</p><p><code>';

			if ($update_text_begin == '')
			{
				echo '<i>Keine</i>';
			}
			else
			{
				echo nl2br($update_text_begin);
			}

			echo '</code></p>
			<p>Rechte Grenze';

			if ($update_text_end != '')
			{
				if (@strpos($site, decode_critical_html_characters($update_text_end)) === false)
					echo ' (<span class="red">Nicht gefunden!</span>)';
				else
					echo ' (<span class="green">Gefunden!</span>)';
			}

			echo ':</p><p><code>';

			if ($update_text_end == '')
			{
				echo '<i>Keine</i>';
			}
			else
			{
				echo nl2br($update_text_end);
			}

			echo '</code></p>';

			$cont1 = zwischen_str($site, decode_critical_html_characters($update_text_begin), decode_critical_html_characters($update_text_end));
			$cont1 = my_htmlentities($cont1, $charset);
			$cont1 = str_replace("\n", '<br>', $cont1);
			//$cont1 = str_replace("\r", '<br>', $cont1);

			$cont2 = zwischen_str($site, decode_critical_html_characters($update_text_begin), decode_critical_html_characters($update_text_end));
			$cont2 = my_htmlentities($cont2, $charset);
			$cont2 = str_replace("\n", '<br>', $cont2);
			//$cont2 = str_replace("\r", '<br>', $cont2);

			if ($cont1 == $cont2)
			{
				echo '<center><hr><span class="green"><b>Es existieren derzeit keine dynamischen (sich bei jedem Seitenaufruf ver&auml;ndernden) Inhalte.</b></span><hr></center>';
				echo '<font face="courier">'.$cont1.'</font>';
			}
			else
			{
				echo '<center><hr><span class="red"><b>WARNUNG! Es existieren derzeit dynamische (sich bei jedem Seitenaufruf ver&auml;ndernde) Inhalte! Die abweichenden Zeilen wurden rot markiert.<br>Flankieren Sie die von Ihnen gew&uuml;nschten Informationen, da der Update-Service ansonsten st&auml;ndig ein Seitenupdate meldet.</b></span><hr></center>';
				echo '<code>';
				$ary1 = explode("<br>", $cont1);
				$ary2 = explode("<br>", $cont2);

				foreach ($ary1 as $m1 => $m2)
				{
					if ($ary1[$m1] == $ary2[$m1])
						echo $ary1[$m1].'<br>';
					else
						echo '<span class="red">'.$ary1[$m1].'</span><br>';
				}

				unset($m1);
				unset($m2);

				echo '</code>';
			}
		}
	}
}

echo '<br><br><div align="center">';
echo '<input type="submit" onclick="javascript:window.close();" value="Schlie&szlig;en" class="button" onmouseover="this.className=\'button_act\';" onmouseout="this.className=\'button\';">';
echo '</div>';

echo $footer;

?>
