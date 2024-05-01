<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

function abschnitt_bei_stelle($zahl, $stelle)
{
	return ((floor($zahl*pow(10,$stelle)))/pow(10,$stelle));
}

echo $header;

if (($category != 'faecher') && ($category != 'noten') && ($category != 'auswertung') && ($category != 'hausaufgaben') && ($category != 'striche'))
	$category = 'faecher';

$res = db_query("SELECT * FROM `".$WBConfig->getMySQLPrefix()."schule_jahrgaenge` WHERE `user_cnid` = '".$benutzer['id']."' AND `id` = '".db_escape($id)."';");
if (db_num($res) == 0) die('<b>Fehler</b><br><br>Datensatz nicht gefunden oder keine Berechtigung!');
$rw = db_fetch($res);

echo '<center>[ ';
if ($category == 'faecher')
	echo 'Schulf&auml;cher';
else
	echo '<a href="'.$_SERVER['PHP_SELF'].'?modul='.$modul.'&amp;seite='.$seite.'&amp;id='.$id.'&amp;category=faecher">Schulf&auml;cher</a>';
echo ' | ';
if ($category == 'noten')
	echo 'Noten';
else
	echo '<a href="'.$_SERVER['PHP_SELF'].'?modul='.$modul.'&amp;seite='.$seite.'&amp;id='.$id.'&amp;category=noten">Noten</a>';
echo ' | ';
if ($category == 'auswertung')
	echo 'Auswertung';
else
	echo '<a href="'.$_SERVER['PHP_SELF'].'?modul='.$modul.'&amp;seite='.$seite.'&amp;id='.$id.'&amp;category=auswertung">Auswertung</a>';
echo ' | ';
if ($category == 'hausaufgaben')
	echo 'Hausaufgaben';
else
	echo '<a href="'.$_SERVER['PHP_SELF'].'?modul='.$modul.'&amp;seite='.$seite.'&amp;id='.$id.'&amp;category=hausaufgaben">Hausaufgaben</a>';
echo ' | ';
if ($category == 'striche')
	echo 'Striche';
else
	echo '<a href="'.$_SERVER['PHP_SELF'].'?modul='.$modul.'&amp;seite='.$seite.'&amp;id='.$id.'&amp;category=striche">Striche</a>';
echo ' ]</center><br><br>

<form method="POST" action="'.$_SERVER['PHP_SELF'].'">
<input type="hidden" name="modul" value="'.$modul.'">
<input type="hidden" name="seite" value="'.$seite.'">
<input type="hidden" name="id" value="'.$id.'">
<input type="hidden" name="category" value="'.$category.'">
<input type="hidden" name="sent" value="yes">';

if ($category == 'faecher')
{
	if (isset($sent) && ($sent))
		db_query("INSERT INTO `".$WBConfig->getMySQLPrefix()."schule_faecher` (`user_cnid`, `year_cnid`, `name`, `wertungsfaktor`) VALUES ('".$benutzer['id']."', '".db_escape($id)."', '".db_escape($name)."', '".db_escape($wertungsfaktor)."')");

	if (isset($delete) && ($delete))
	{
		db_query("DELETE FROM `".$WBConfig->getMySQLPrefix()."schule_faecher` WHERE `user_cnid` = '".$benutzer['id']."' AND `id` = '".db_escape($delete)."' AND `year_cnid` = '".db_escape($id)."'");
		if (db_affected_rows() > 0)
			db_query("OPTIMIZE TABLE `".$WBConfig->getMySQLPrefix()."schule_faecher`");
	}
	$res = db_query("SELECT `name`, `wertungsfaktor`, `id` FROM `".$WBConfig->getMySQLPrefix()."schule_faecher` WHERE `user_cnid` = '".$benutzer['id']."' AND `year_cnid` = '".db_escape($id)."'");
	wb_draw_table_begin();
	wb_draw_table_content('', '<b>Fach</b>', '', '<b>Wertungsfaktor</b>', '', '<b>Aktionen</b>');
	while ($row = db_fetch($res))
		wb_draw_table_content('100%', $row['name'], '', $row['wertungsfaktor'], '', '<a href="javascript:abfrage(\''.$_SERVER['PHP_SELF'].'?modul='.$modul.'&amp;seite='.$seite.'&amp;id='.$id.'&amp;category='.$category.'&amp;delete='.$row['id'].'\')">L&ouml;schen</a>');
	wb_draw_table_content('', 'Neues Schulfach anlegen:<img src="designs/spacer.gif" width="25" height="1" alt=""><input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="name">', '', '<input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="wertungsfaktor" value="1">', '', '<input type="submit" class="button" onmouseover="this.className=\'button_act\';" onmouseout="this.className=\'button\';" value)="Anlegen">');
	wb_draw_table_end();
}

if ($category == 'noten')
{
	if (isset($sent) && ($sent))
		db_query("INSERT INTO `".$WBConfig->getMySQLPrefix()."schule_noten` (`user_cnid`, `year_cnid`, `fach_cnid`, `name`, `wertung`, `note`) VALUES ('".$benutzer['id']."', '".db_escape($id)."', '".db_escape($fach)."', '".db_escape($name)."', '".db_escape($wertung)."', '".db_escape($note)."')");

	if (isset($delete) && ($delete))
	{
		db_query("DELETE FROM `".$WBConfig->getMySQLPrefix()."schule_noten` WHERE `user_cnid` = '".$benutzer['id']."' AND `id` = '".db_escape($delete)."' AND `year_cnid` = '".db_escape($id)."'");
		if (db_affected_rows() > 0)
			db_query("OPTIMIZE TABLE `".$WBConfig->getMySQLPrefix()."schule_noten`");
	}

	$res = db_query("SELECT `id`, `fach_cnid`, `name`, `wertung`, `note` FROM `".$WBConfig->getMySQLPrefix()."schule_noten` WHERE `user_cnid` = '".$benutzer['id']."' AND `year_cnid` = '".db_escape($id)."'");
	wb_draw_table_begin();
	if ($rw['notensystem'] == 0)
		wb_draw_table_content('', '<b>Fach</b>', '', '<b>Name</b>', '', '<b>Wertung</b>', '', '<b>Note</b>', '', '<b>Aktionen</b>');
	if ($rw['notensystem'] == 1)
		wb_draw_table_content('', '<b>Fach</b>', '', '<b>Name</b>', '', '<b>Wertung</b>', '', '<b>Notenpunkte</b>', '', '<b>Note</b>', '', '<b>Aktionen</b>');
	while ($row = db_fetch($res))
	{
		$res2 = db_query("SELECT `name` FROM `".$WBConfig->getMySQLPrefix()."schule_faecher` WHERE `id` = '".db_escape($row['fach_cnid'])."' AND `user_cnid` = '".$benutzer['id']."' AND `year_cnid` = '".db_escape($id)."'");
		$row2 = db_fetch($res2);
		$fach = $row2['name'];

		if ($rw['notensystem'] == 0)
			wb_draw_table_content('', $fach, '', $row['name'], '', $row['wertung'], '', $row['note'], '', '<a href="javascript:abfrage(\''.$_SERVER['PHP_SELF'].'?modul='.$modul.'&amp;seite='.$seite.'&amp;id='.$id.'&amp;category='.$category.'&amp;delete='.$row['id'].'\')">L&ouml;schen</a>');
		if ($rw['notensystem'] == 1)
			wb_draw_table_content('', $fach, '', $row['name'], '', $row['wertung'], '', $row['note'], '', abschnitt_bei_stelle(6-($row['note']/15)*5, 2), '', '<a href="'.$_SERVER['PHP_SELF'].'?modul='.$modul.'&amp;seite='.$seite.'&amp;id='.$id.'&amp;category='.$category.'&amp;delete='.$row['id'].'">L&ouml;schen</a>');
	}
	$fach_dropdown = '<select name="fach">';
	$faecher_vorhanden = false;
	$res = db_query("SELECT `name`, `id` FROM `".$WBConfig->getMySQLPrefix()."schule_faecher` WHERE `user_cnid` = '".$benutzer['id']."' AND `year_cnid` = '".db_escape($id)."'");
	while ($row = db_fetch($res))
	{
		$fach_dropdown .= '<option value="'.$row['id'].'">'.$row['name'].'</option>';
		$faecher_vorhanden = true;
	}
	$fach_dropdown .= '</select>';
	if ($faecher_vorhanden)
	{
		if ($rw['notensystem'] == 0)
			wb_draw_table_content('', $fach_dropdown, '', '<input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="name">', '', '<input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="wertung">', '', '<input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="note">', '', '<input type="submit" class="button" onmouseover="this.className=\'button_act\';" onmouseout="this.className=\'button\';" value="Eintragen">');
		if ($rw['notensystem'] == 1)
			wb_draw_table_content('', $fach_dropdown, '', '<input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="name">', '', '<input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="wertung">', '', '<input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="note">', '', '<img src="designs/spacer.gif" width="115" height="1" alt="">', '', '<input type="submit" class="button" onmouseover="this.className=\'button_act\';" onmouseout="this.className=\'button\';" value="Eintragen">');
	}
	else
	{
		if ($rw['notensystem'] == 0)
			wb_draw_table_content('', 'Bitte zuerst <a href="'.$_SERVER['PHP_SELF'].'?seite='.$seite.'&modul='.$modul.'&category=faecher&id='.$id.'">F&auml;cher anlegen</a>!', '', '', '', '', '', '', '', '');
		if ($rw['notensystem'] == 1)
			wb_draw_table_content('', 'Bitte zuerst <a href="'.$_SERVER['PHP_SELF'].'?seite='.$seite.'&modul='.$modul.'&category=faecher&id='.$id.'">F&auml;cher anlegen</a>!', '', '', '', '', '', '', '', '', '', '');
	}
	wb_draw_table_end();
}

if ($category == 'auswertung')
{
	wb_draw_table_begin();

	if ($rw['notensystem'] == 0)
		wb_draw_table_content('', '<b>Fach</b>', '', '<b>Wertungsfaktor</b>', '', '<b>Bewertungen</b>', '', '<b>Durchschnitt</b>');
	if ($rw['notensystem'] == 1)
		wb_draw_table_content('', '<b>Fach</b>', '', '<b>Wertungsfaktor</b>', '', '<b>Bewertungen</b>', '', '<b>Durchschnitt</b>', '', '<b>Note</b>');

	$sum_c = 0;
	$sum = 0;
	$sum2 = 0;
	$faecher_vorhanden = false;
	$res = db_query("SELECT `id`, `name`, `wertungsfaktor` FROM `".$WBConfig->getMySQLPrefix()."schule_faecher` WHERE `user_cnid` = '".$benutzer['id']."' AND `year_cnid` = '".db_escape($id)."'");
	while ($row = db_fetch($res))
	{
		$faecher_vorhanden = true;
		$sum_note = 0;
		$sum_wertung = 0;
		$c_id = 0;
		$res3 = db_query("SELECT `note`, `wertung` FROM `".$WBConfig->getMySQLPrefix()."schule_noten` WHERE `user_cnid` = '".$benutzer['id']."' AND `fach_cnid` = '".$row['id']."' AND `year_cnid` = '".db_escape($id)."'");
		while ($row3 = db_fetch($res3))
		{
			$c_id++;
			if (strpos($row3['wertung'], '/') === false)
			{
				$sum_note += $row3['note']*$row3['wertung'];
				$sum_wertung += $row3['wertung'];
			}
			else
			{
				$ary = explode('/', $row3['wertung']);
				if ($ary[1] <> 0)
				{
					$temp_wertung = $ary[0]/$ary[1];
					$sum_note += $row3['note']*$temp_wertung;
					$sum_wertung += $temp_wertung;
				}
			}
		}

		if ($sum_wertung <> 0)
		{
			if ($rw['notensystem'] == 0)
				wb_draw_table_content('', $row['name'], '', $row['wertungsfaktor'], '', $c_id, '', round($sum_note/$sum_wertung, 2));
			if ($rw['notensystem'] == 1)
				wb_draw_table_content('', $row['name'], '', $row['wertungsfaktor'], '', $c_id, '', round($sum_note/$sum_wertung, 2), '', abschnitt_bei_stelle(6-(($sum_note/$sum_wertung)/15)*5, 2));
			$sum2 += $c_id;
			$sum_c += $row['wertungsfaktor'];
			$sum += $row['wertungsfaktor']*($sum_note/$sum_wertung);
		}
		else
		{
			if ($rw['notensystem'] == 0)
				wb_draw_table_content('', $row['name'], '', $row['wertungsfaktor'], '', $c_id, '', '-');
			if ($rw['notensystem'] == 1)
				wb_draw_table_content('', $row['name'], '', $row['wertungsfaktor'], '', $c_id, '', '-', '', '-');
		}
	}

	if ($faecher_vorhanden)
	{
		if ($sum_c == 0)
		{
			$durchschnitt = '-';
			if ($rw['notensystem'] == 1)
				$transform = '-';
		}
		else
		{
			$durchschnitt = round($sum/$sum_c, 2);
			if ($rw['notensystem'] == 1)
				$transform = abschnitt_bei_stelle(6-(($sum/$sum_c)/15)*5, 2);
		}

		if ($rw['notensystem'] == 0)
			wb_draw_table_content('', '<b>Gesamtdurchschnitt</b>', '', '', '', '<b>'.$sum2.'</b>', '', '<b>'.$durchschnitt.'</b>');
		if ($rw['notensystem'] == 1)
			wb_draw_table_content('', '<b>Gesamtdurchschnitt</b>', '', '', '', '<b>'.$sum2.'</b>', '', '<b>'.$durchschnitt.'</b>', '', '<b>'.$transform.'</b>');
	}
	else
	{
		if ($rw['notensystem'] == 0)
			wb_draw_table_content('', 'Bitte zuerst <a href="'.$_SERVER['PHP_SELF'].'?seite='.$seite.'&modul='.$modul.'&category=faecher&id='.$id.'">F&auml;cher anlegen</a>!', '', '', '', '', '', '');
		if ($rw['notensystem'] == 1)
			wb_draw_table_content('', 'Bitte zuerst <a href="'.$_SERVER['PHP_SELF'].'?seite='.$seite.'&modul='.$modul.'&category=faecher&id='.$id.'">F&auml;cher anlegen</a>!', '', '', '', '', '', '', '', '');
	}

	wb_draw_table_end();
}

if ($category == 'hausaufgaben')
{
	if (isset($sent) && ($sent))
		db_query("INSERT INTO `".$WBConfig->getMySQLPrefix()."schule_hausaufgaben` (`user_cnid`, `year_cnid`, `fach_cnid`, `text`) VALUES ('".$benutzer['id']."', '".db_escape($id)."', '".db_escape($fach)."', '".db_escape($text)."')");

	if (isset($delete) && ($delete))
	{
		db_query("DELETE FROM `".$WBConfig->getMySQLPrefix()."schule_hausaufgaben` WHERE `user_cnid` = '".$benutzer['id']."' AND `id` = '".db_escape($delete)."' AND `year_cnid` = '".db_escape($id)."'");
		if (db_affected_rows() > 0)
			db_query("OPTIMIZE TABLE `".$WBConfig->getMySQLPrefix()."schule_hausaufgaben`");
	}

	$res = db_query("SELECT `id`, `fach_cnid`, `text` FROM `".$WBConfig->getMySQLPrefix()."schule_hausaufgaben` WHERE `user_cnid` = '".$benutzer['id']."' AND `year_cnid` = '".db_escape($id)."'");

	wb_draw_table_begin();
	wb_draw_table_content('', '<b>Fach</b>', '', '<b>Text</b>', '', '<b>Aktionen</b>');

	while ($row = db_fetch($res))
	{
		$res2 = db_query("SELECT `name` FROM `".$WBConfig->getMySQLPrefix()."schule_faecher` WHERE `id` = '".db_escape($row['fach_cnid'])."' AND `user_cnid` = '".$benutzer['id']."' AND `year_cnid` = '".db_escape($id)."'");
		$row2 = db_fetch($res2);
		$fach = $row2['name'];

		wb_draw_table_content('', $fach, '', $row['text'], '', '<a href="javascript:abfrage(\''.$_SERVER['PHP_SELF'].'?modul='.$modul.'&amp;seite='.$seite.'&amp;id='.$id.'&amp;category='.$category.'&amp;delete='.$row['id'].'\')">L&ouml;schen</a>');
	}
	$faecher_vorhanden = false;
	$res = db_query("SELECT `name`, `id` FROM `".$WBConfig->getMySQLPrefix()."schule_faecher` WHERE `user_cnid` = '".$benutzer['id']."' AND `year_cnid` = '".db_escape($id)."'");
	$fach_dropdown = '<select name="fach">';
	while ($row = db_fetch($res))
	{
		$faecher_vorhanden = true;
		$fach_dropdown .= '<option value="'.$row['id'].'">'.$row['name'].'</option>';
	}
	$fach_dropdown .= '</select>';
	if ($faecher_vorhanden)
		wb_draw_table_content('', $fach_dropdown, '', '<input type="text" class="normal" onmouseover="this.className=\'highlight\';" onmouseout="this.className=\'normal\';" name="text">', '', '<input type="submit" class="button" onmouseover="this.className=\'button_act\';" onmouseout="this.className=\'button\';" value="Eintragen">');
	else
		wb_draw_table_content('', 'Bitte zuerst <a href="'.$_SERVER['PHP_SELF'].'?seite='.$seite.'&modul='.$modul.'&category=faecher&id='.$id.'">F&auml;cher anlegen</a>!', '', '', '', '');
	wb_draw_table_end();
}

if ($category == 'striche')
{
	if (isset($plus) && ($plus <> '') && ($what == 'pos'))
		db_query("UPDATE `".$WBConfig->getMySQLPrefix()."schule_faecher` SET `positiv` = `positiv` + '".db_escape($amount)."' WHERE `id` = '".db_escape($plus)."' AND `user_cnid` = '".$benutzer['id']."' AND `year_cnid` = '".db_escape($id)."'");
	if (isset($plus) && ($plus <> '') && ($what == 'neg'))
		db_query("UPDATE `".$WBConfig->getMySQLPrefix()."schule_faecher` SET `negativ` = `negativ` + '".db_escape($amount)."' WHERE `id` = '".db_escape($plus)."' AND `user_cnid` = '".$benutzer['id']."' AND `year_cnid` = '".db_escape($id)."'");

	$faecher_vorhanden = false;
	$res = db_query("SELECT `name`, `positiv`, `negativ`, `id` FROM `".$WBConfig->getMySQLPrefix()."schule_faecher` WHERE `user_cnid` = '".$benutzer['id']."' AND `year_cnid` = '".db_escape($id)."'");
	wb_draw_table_begin();
	wb_draw_table_content('', '<b>Fach</b>', '', '<b>Positiv</b>', '', '', '', '', '', '<b>Negativ</b>', '', '', '', '');
	while ($row = db_fetch($res))
	{
		$faecher_vorhanden = true;
		wb_draw_table_content('', $row['name'], '', round($row['positiv'], 2), '', '<a href="'.$_SERVER['PHP_SELF'].'?modul='.$modul.'&amp;seite='.$seite.'&amp;id='.$id.'&amp;category='.$category.'&amp;plus='.$row['id'].'&amp;amount=1&amp;what=pos">+1.00</a> <a href="'.$_SERVER['PHP_SELF'].'?modul='.$modul.'&amp;seite='.$seite.'&amp;id='.$id.'&amp;category='.$category.'&amp;plus='.$row['id'].'&amp;amount=0.5&amp;what=pos">+0.50</a> <a href="'.$_SERVER['PHP_SELF'].'?modul='.$modul.'&amp;seite='.$seite.'&amp;id='.$id.'&amp;category='.$category.'&amp;plus='.$row['id'].'&amp;amount=0.25&amp;what=pos">+0.25</a>',
																																			'', '<a href="'.$_SERVER['PHP_SELF'].'?modul='.$modul.'&amp;seite='.$seite.'&amp;id='.$id.'&amp;category='.$category.'&amp;plus='.$row['id'].'&amp;amount=-1&amp;what=pos">-1.00</a> <a href="'.$_SERVER['PHP_SELF'].'?modul='.$modul.'&amp;seite='.$seite.'&amp;id='.$id.'&amp;category='.$category.'&amp;plus='.$row['id'].'&amp;amount=-0.5&amp;what=pos">-0.50</a> <a href="'.$_SERVER['PHP_SELF'].'?modul='.$modul.'&amp;seite='.$seite.'&amp;id='.$id.'&amp;category='.$category.'&amp;plus='.$row['id'].'&amp;amount=-0.25&amp;what=pos">-0.25</a>',
																			 '', round($row['negativ'], 2), '', '<a href="'.$_SERVER['PHP_SELF'].'?modul='.$modul.'&amp;seite='.$seite.'&amp;id='.$id.'&amp;category='.$category.'&amp;plus='.$row['id'].'&amp;amount=1&amp;what=neg">+1.00</a> <a href="'.$_SERVER['PHP_SELF'].'?modul='.$modul.'&amp;seite='.$seite.'&amp;id='.$id.'&amp;category='.$category.'&amp;plus='.$row['id'].'&amp;amount=0.5&amp;what=neg">+0.50</a> <a href="'.$_SERVER['PHP_SELF'].'?modul='.$modul.'&amp;seite='.$seite.'&amp;id='.$id.'&amp;category='.$category.'&amp;plus='.$row['id'].'&amp;amount=0.25&amp;what=neg">+0.25</a>',
																																			'', '<a href="'.$_SERVER['PHP_SELF'].'?modul='.$modul.'&amp;seite='.$seite.'&amp;id='.$id.'&amp;category='.$category.'&amp;plus='.$row['id'].'&amp;amount=-1&amp;what=neg">-1.00</a> <a href="'.$_SERVER['PHP_SELF'].'?modul='.$modul.'&amp;seite='.$seite.'&amp;id='.$id.'&amp;category='.$category.'&amp;plus='.$row['id'].'&amp;amount=-0.5&amp;what=neg">-0.50</a> <a href="'.$_SERVER['PHP_SELF'].'?modul='.$modul.'&amp;seite='.$seite.'&amp;id='.$id.'&amp;category='.$category.'&amp;plus='.$row['id'].'&amp;amount=-0.25&amp;what=neg">-0.25</a>');
	}

	if (!$faecher_vorhanden)
	{
		wb_draw_table_content('', 'Bitte zuerst <a href="'.$_SERVER['PHP_SELF'].'?seite='.$seite.'&modul='.$modul.'&category=faecher&id='.$id.'">F&auml;cher anlegen</a>!', '', '', '', '', '', '', '', '', '', '', '', '');
	}

	wb_draw_table_end();
}

echo '</form>';

echo $footer;

?>