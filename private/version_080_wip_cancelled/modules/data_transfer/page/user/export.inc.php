<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

if (!headers_sent()) header("Pragma: public");
if (!headers_sent()) header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
if (!headers_sent()) header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
if (!headers_sent()) header("Cache-Control: private", false);
if (!headers_sent()) header("Content-type: application/octet-stream");
if (!headers_sent()) header("Content-Disposition: attachment; filename=\"Personal WebBase-Dump.xml\"");
if (!headers_sent()) header("Content-Transfer-Encoding: binary");

flush();

// Kleinsten Datensatz finden, um Exportdatei übersichtlich zu halten (kleinster Wert bekommt id=1)

$min = 'x';
foreach ($tables_modules as $m1 => $m2)
{
	$rs = db_query("SELECT MIN(`id`) AS `mi` FROM `$m1`");
	$rw = db_fetch($rs);
	if ((($rw['mi'] < $min) || ($min == 'x')) && ($rw['mi'] != ''))
		$min = $rw['mi'];
}
unset($m1);
unset($m2);
if ($min == 'x') $min = 0;

function binaere_daten($inp)
{
	$res = false;
	for ($i=0; $i<=31; $i++)
	{
		// Ausnahme: 09h, 0Ah, 0Dh
		if ((strpos($inp, chr($i)) !== false) && ($i != 9) && ($i != 10) && ($i != 13))
		{
			$res = true;
		}
	}
	return $res;
}

// Exportieren

$webbasedump = new XmlElement;

$webbasedump->name					= 'webbasedump';
$webbasedump->attributes['xmlns']	= 'http://www.personal-webbase.de/';
$webbasedump->attributes['version'] = '1.0';
$webbasedump->attributes['server']	= $configuration['common_links_notifier']['wb_system_url'];
$webbasedump->attributes['account'] = $wb_user_username;
$webbasedump->attributes['date']	= date('Y-m-d');
$webbasedump->attributes['time']	= date('H:i:s');

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

foreach ($tables_modules as $n1 => $n2)
{
	if (isset($tables_database[$n1]['user_cnid']))
	{
		$res = db_query("SELECT * FROM `$n1` WHERE `user_cnid` = '".$benutzer['id']."'");
		if (db_num($res) > 0)
		{
			$table = new XmlElement;
			$table->name							 = 'table';
			$table->attributes['name'] = substr(strtolower($n1), strlen($WBConfig->getMySQLPrefix()), strlen($n1)-strlen($WBConfig->getMySQLPrefix()));

			while ($row = db_fetch($res))
			{
				$element = new XmlElement;
				$element->name = 'element';

				$i = 0;
				foreach ($row as $m1 => $m2)
				{
					$i++;
					if ($i % 2 == 0)
					{
						if (strtolower($m1) != 'user_cnid')
						{
							$value = new XmlElement;
							$value->name							 = 'value';
							$value->attributes['name'] = strtolower($m1);

							if ((($m1 == 'id') || (is_cnid($m1))) && ((strtolower($m1) != 'folder_cnid') || ($m2 != '0')))
							{
								// Datensatz-Wert (ID-Nummer) im Datensatz anpassen
								// Bedingung: Feldname = "ID" oder Postfix "_CNID" vorhanden
								// Ausnahme:	Feld "FOLDER_CNID" hat den legalen Wert "0"
								$value->content = $m2-$min+1;
							}
							else
							{
								if (binaere_daten($m2))
								{
									$value->content = base64_encode($m2);
									$value->attributes['encode'] = 'base64';
								}
								else
								{
									$value->content = $m2;
								}
							}

							$element->children[] = $value;
						}
					}
				}
				$table->children[] = $element;

				unset($m1);
				unset($m2);
			}
			$webbasedump->children[] = $table;
		}
	}
}

unset($n1);
unset($n2);

$xml = new xml();
$output = $xml->object_to_xml_code($webbasedump);

$buffersize = 1024*8;
for ($i=0; $i<strlen($output); $i=$i+$buffersize)
{
	if (strlen($output) < $i+$buffersize)
	{
		$tmp = substr($output, $i, strlen($output)-$i-1);
	}
	else
	{
		$tmp = substr($output, $i, $buffersize);
	}
	echo $tmp;
	flush();
}

?>