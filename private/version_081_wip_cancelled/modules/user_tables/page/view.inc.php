<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

	// Initialisierung
	$res = db_query("SELECT name, data FROM ".$WBConfig->getMySQLPrefix()."tabellen WHERE id = '".db_escape($id)."' AND user = '".$benutzer['id']."'");
	$row = db_fetch($res);
	$text = $row['data'];
	echo '<b>'.$row['name'].'</b><br><br>';

	// Konstanten
	$umbruch_zeile = ':';
	$umbruch_item = '-';
	$max_laenge = 50;

	// Inhaltsabfrage
	$ary1 = explode($umbruch_zeile, $text);
	echo '<center><table border="1" cellspacing="3" cellpadding="3" width="95%">';
	for ($j=0; $ary1[$j]!=''; $j++)
	{
		$ary2 = explode($umbruch_item, $ary1[$j]);
		if ($j == 0)
		{
			echo '<tr bgcolor="#DDDDDD">';
			for ($i=0; $ary2[$i]!=''; $i++)
			{
				$tname = 'type'.$i;
				$$tname = substr($ary2[$i], 0, 1);
				$titel = substr($ary2[$i], 1, strlen($ary2[$i])-1);
				$titel = base64_decode($titel);
				if (strlen($titel) > $max_laenge)
					$titel = substr($titel, 0, $max_laenge).'...';
				$titel = wb_htmlentities($titel);
				echo '<td><b>'.$titel.'</b></td>';
			}
			echo '</tr>';
		}
		else
		{
				echo '<tr>';
			for ($i=0; $ary2[$i]!=''; $i++)
			{
				$tname = 'type'.$i;
				$inhalt = '<span class="red">Inhaltstyp fehlerhaft</span>';
				if ($$tname == 'C')
				{
					$inhalt = base64_decode($ary2[$i]);
					if ($inhalt == '1')
							$x = ' checked';
					else
						$x = '';
						$inhalt = '<input type="checkbox"'.$x.' disabled>';
				}
				else if ($$tname == 'T')
				{
					$inhalt = base64_decode($ary2[$i]);
					if (strlen($inhalt) > $max_laenge)
						$inhalt = substr($inhalt, 0, $max_laenge).'...';
					$inhalt = wb_htmlentities($inhalt);
				}
				echo '<td>'.$inhalt.'</td>';
			}
			echo '</tr>';
		}
	}
	echo '</table><br></center>';

?>