<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne IronBASE ausgef&uuml;hrt werden.');

if (!headers_sent()) header("Pragma: public");
if (!headers_sent()) header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
if (!headers_sent()) header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
if (!headers_sent()) header("Cache-Control: private",false);
if (!headers_sent()) header("Content-type: application/octet-stream");
if (!headers_sent()) header("Content-Disposition: attachment; filename=\"Dump.ibd\"");
if (!headers_sent()) header("Content-Transfer-Encoding: binary");

// Kleinsten Datensatz finden, um Exportdatei übersichtlich zu halten (kleinster Wert bekommt id=1)

$min = 'x';
foreach ($tabellen as $m1 => $m2)
{
  $rs = db_query("SELECT MIN(`id`) AS `mi` FROM `".$mysql_zugangsdaten['praefix'].db_escape($m2)."`");
  $rw = db_fetch($rs);
  if ((($rw['mi'] < $min) || ($min == 'x')) && ($rw['mi'] != ''))
    $min = $rw['mi'];
}
unset($m1);
unset($m2);
if ($min == 'x') $min = 0;

// Exportieren

$ende = 'IRONBASE#1;';

foreach ($tabellen as $n1 => $n2)
{
  if (isset($datenbanktabellen[$mysql_zugangsdaten['praefix'].$n2]['user']))
  {
    $v = '';
    $res = db_query("SELECT * FROM `".$mysql_zugangsdaten['praefix']."$n2` WHERE `user` = '".$benutzer['id']."'");
    while ($row = db_fetch($res))
    {
      $i = 0;
      $v .= base64_encode($n2).'*';
      foreach($row as $m1 => $m2)
      {
        $i++;
        if ($i % 2 == 0)
        {
          if ($m1 != 'user')
          {
            if ($m1 == 'id')
            {
              $v .= base64_encode($m1).'~'.base64_encode($m2-$min+1).',';
            }
            else
            {
              if (($m1 == 'folder') && ($m2 != '0'))
                $v .= base64_encode($m1).'~'.base64_encode($m2-$min+1).',';
              else
                $v .= base64_encode($m1).'~'.base64_encode($m2).',';
            }
          }
        }
      }

      unset($m1);
	  unset($m2);

      $v = substr($v, 0, strlen($v)-1).";";
    }
    $ende .= $v;
  }
}

for ($i=0; $i<=(strlen($ende)/100); $i++)
{
  echo substr($ende, $i*100, 100)."\r\n";
}

?>