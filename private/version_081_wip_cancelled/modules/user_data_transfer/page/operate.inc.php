<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

if ($aktion == 'dest')
{
	if (isset($pwd) && ($pwd != $wb_user_password) && ($wb_user_type == 1))
		die($header.'<h1>'.$module_information->caption.'</h1>Es wurde ein falsches Passwort eingegeben.'.$footer);

	if (strtoupper($sic) != 'OK')
		die($header.'<h1>'.$module_information->caption.'</h1>Sie m&uuml;ssen das Sicherheitsfeld ausf&uuml;llen!'.$footer);

	foreach ($tables_modules as $m1 => $m2)
	{
		if (isset($tables_modules[$m1]['user_cnid']))
		{
			db_query("DELETE FROM `$m1` WHERE `user_cnid` = '".$benutzer['id']."'");
			if (db_affected_rows() > 0)
				db_query("OPTIMIZE TABLE `$m1`");
		}
	}

	unset($m1);
	unset($m2);

	echo $header.'<h1>'.$module_information->caption.'</h1>Es wurden alle Datens&auml;tze entfernt.'.$footer;
}

if ($aktion == 'dump')
{
	// Datenbank vor Cleaner-Funktion schützen (beim Hochladen können ungültige Ordner- oder sonstige Bezüge entstehen)

	if (isset($configuration[$modul]['lock_cleaner_hours']))
	{
		$hours = $configuration[$modul]['lock_cleaner_hours'];
	}
	else
	{
		$hours = '';
	}

	if (($hours != '') && (is_numeric($hours)))
	{
		$res = db_query("SELECT DATE_ADD(NOW(), INTERVAL $hours HOUR)");
		$row = db_fetch($res);

		wb_change_config('lock_cleaner_until', $row[0], 'common_cleaner');
	}

	// Problem: Wenn man ZUR SELBEN SEKUNDE wie der Cleaner im Cronjob das Hochladen startet, hat man ggf. gelitten

	// Nun beginnen

	if (isset($pwd) && ($pwd != $wb_user_password) && ($wb_user_type == 1))
	{
		echo $header.'<h1>'.$module_information->caption.'</h1>Es wurde ein falsches Passwort eingegeben.'.$footer;
	}
	else
	{
		if($_FILES['dfile']['tmp_name'])
		{
				$queries = array();
				$m = '';

				// Größten Datensatz finden, um Dateiduplikate zu verhindern

				$max = 0;
				foreach ($tables_modules as $m1 => $m2)
				{
					$rs = db_query("SELECT MAX(`id`) AS `ma` FROM `$m1`");
					$rw = db_fetch($rs);
					if ($rw['ma'] > $max)
						$max = $rw['ma'];
				}

				unset($m1);
				unset($m2);

				$xml = new xml();
				$array = $xml->xml_file_to_object($_FILES['dfile']['tmp_name']);

				// Anmerkung: XML-Datei wird nur oberflächlich auf Malformation untersucht. Zusätzliche Attribute oder zusätzliche Knotenpunkte werden ignoriert

				function is_cnid($fieldname)
				{
					if (strlen($fieldname) < strlen('_cnid'))
					{
						return false;
					}
					else
					{
						return (substr(strtolower($fieldname), strlen($fieldname)-strlen('_cnid'), strlen('_cnid')) == '_cnid');
					}
				}

				if (($array->name != 'webbasedump') || ($array->attributes['version'] != '1.0'))
				{
					echo '<b>Fehler</b><br><br>Dies ist keine g&uuml;ltige Personal WebBase-Datensicherung oder sie ist veraltet.';
				}
				else
				{
					foreach ($array->children as $x1 => $x2)
					{
						$table = $array->children[$x1];
						if ($table->name == 'table')
						{
							if (!isset($table->attributes['name']))
							{
								// Fehlermeldung: Malformatierte XML-Struktur
							}
							else if (!isset($tables_modules[$WBConfig->getMySQLPrefix().$table->attributes['name']]))
							{
								// Fehlermeldung: Tabelle ist nicht vorhanden
							}
							else if (!isset($tables_modules[$WBConfig->getMySQLPrefix().$table->attributes['name']]['user_cnid']))
							{
								// Fehlermeldung: Tabelle hat kein Benutzerfeld
							}
							else
							{
								foreach ($table->children as $y1 => $y2)
								{
									$element = $table->children[$y1];
									if ($element->name == 'element')
									{
										$s_namen = '`user_cnid`, ';
										$s_werte = "'".$benutzer['id']."', ";
										foreach ($element->children as $z1 => $z2)
										{
											$value = $element->children[$z1];
											if ($value->name == 'value')
											{
												$name = $value->attributes['name'];
												if (strtolower($name) == 'user_cnid')
												{
													// Fehlermeldung: Versuch, Benutzer zu setzen
												}
												else if ((strtolower($name) == 'folder_cnid') && ($value->content < 0))
												{
													// Fehlermeldung: Ordner-ID im negativen Bereich
												}
												else if ((is_cnid($name)) && ($value->content < 1))
												{
													// Fehlermeldung: Connected-ID kleiner gleich 0.
												}
												else if ((strtolower($name) == 'id') && ($value->content < 1))
												{
													// Fehlermeldung: ID kleiner gleich 0.
												}
												else if (!isset($tables_modules[$WBConfig->getMySQLPrefix().$table->attributes['name']][$name]))
												{
													// Fehlermeldung: Feld nicht vorhanden in Tabelle
												}
												else
												{
													$s_namen .= '`'.$name.'`, ';
													if (isset($value->content))
													{
														if (isset($value->attributes['encode']) && (strtolower($value->attributes['encode']) == 'base64'))
														{
															if ((strtolower($name) == 'id') || (is_cnid($name)))
															{
																$s_werte .= '0x'.string2hex(base64_decode($value->content+$max)).', ';
															}
															else
															{
																if ((strtolower($name) == 'folder_cnid') && ($value->content != '0'))
																{
																	$s_werte .= '0x'.string2hex(base64_decode($value->content+$max)).', ';
																}
																else
																{
																	$s_werte .= '0x'.string2hex(base64_decode($value->content)).', ';
																}
															}
														}
														else
														{
															if ((strtolower($name) == 'id') || (is_cnid($name)))
															{
																$s_werte .= "'".db_escape($value->content+$max)."', ";
															}
															else
															{
																if ((strtolower($name) == 'folder_cnid') && ($value->content != '0'))
																{
																	$s_werte .= "'".db_escape($value->content+$max)."', ";
																}
																else
																{
																	$aesc = $value->content;
																	$s_werte .= "'".db_escape($aesc)."', ";
																}
															}
														}
													}
													else
													{
														$s_werte .= "'', ";
													}
												}
											}
										}
										unset($z1);
										unset($z2);
										$s_namen = substr($s_namen, 0, strlen($s_namen)-2);
										$s_werte = substr($s_werte, 0, strlen($s_werte)-2);
										$queries[] = "INSERT INTO `".$WBConfig->getMySQLPrefix().db_escape($table->attributes['name'])."` ($s_namen) VALUES ($s_werte)";
									}
								}
								unset($y1);
								unset($y2);
							}
						}
					}
					unset($x1);
					unset($x2);
				}
				echo $header;
				echo '<h1>'.$module_information->caption.'</h1>';
				if ($m != '')
				{
					echo '<b>Bei der Daten&uuml;bertragung sind einige Fehler aufgetreten. Sie sind hier aufgelistet.</b><br><br>'.$m;
				}
				else
				{
					foreach ($queries as $q1 => $q2)
					{
						db_query($q2);
						//echo $q2.'<br>';
					}
					unset($q1);
					unset($q2);
					echo '<b>Die Daten&uuml;bertragung wurde erfolgreich beendet!</b>';
				}
				echo $footer;
		}
		else
		{
			echo "$headerBitte geben Sie eine Datei an!$footer";
		}
	}

	// Cleaner wieder aktivieren

	wb_change_config('lock_cleaner_until', '0000-00-00 00:00:00', 'common_cleaner');
}

?>