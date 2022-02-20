<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

function gfx_zeichneordnerbox($modul, $append, $dir = 0, $einzug = 0, $auszuwaehlen = 0, $ausschluss = 0)
{
  global $mysql_zugangsdaten;

  $ary = liste_ordner($modul, $append, $dir, $ausschluss);
  if ($dir == 0)
  {
  	echo '<select name="folder" id="folder">';
    echo '<option value="0">Wurzelverzeichnis</option>';
  }
  for ($i=1; isset($ary[$i]['id']); $i++)
  {
    $x = '';
    for ($j=0; $j<=$einzug; $j++) $x .= '-- ';
    $y = '';
    if ($auszuwaehlen == $ary[$i]['id']) $y = ' selected';
	echo '<option value="'.$ary[$i]['id'].'"'.$y.'>'.$x.$ary[$i]['name'].'</option>';
	gfx_zeichneordnerbox($modul, $append, $ary[$i]['id'], $einzug+1, $auszuwaehlen, $ausschluss);
  }
  if ($einzug == 0) echo '</select>';
}

function gfx_zeichneordner($modul, $table, $append, $dir = 0, $einzug = 0)
{
  global $ordnereinzug, $mysql_zugangsdaten;

  $ary = liste_ordner($modul, '', $dir);
  $durchlauf = 0;
  for ($i=1; isset($ary[$i]['id']); $i++)
  {
    $durchlauf++;
    if (file_exists('modules/user_ordner/menueeintrag.inc.php'))
      include 'modules/user_ordner/menueeintrag.inc.php';
    echo "\n";
    gfx_zeichneordner($modul, $table, $append, $ary[$i]['id'], $einzug+1);
    $durchlauf += gfx_zeichneitems($modul, $table, $append, $ary[$i]['id'], $einzug+1);
  }

  if ($einzug == 0)
  {
    $durchlauf += gfx_zeichneitems($modul, $table, $append, $dir);
    if ($durchlauf == 0)
    gfx_tablecontent('100%', 'Es sind keine Elemente in dieser Sektion vorhanden.', '', '', '', '', '', '');
  }
}

function liste_ordner($modul, $append, $dir = 0, $ausschluss = 0)
{
  global $benutzer, $mysql_zugangsdaten;
  $i = 0;

  if (!isset($erg)) $erg = array();

  $res = db_query("SELECT * FROM `".$mysql_zugangsdaten['praefix']."ordner` WHERE `folder` = '".db_escape($dir)."' AND `kategorie` = '".db_escape($modul)."' AND `user` = '".$benutzer['id']."' $append");
  while ($row = db_fetch($res))
  {
	if (($ausschluss == 0) || (($ausschluss != 0) && ($row['id'] != $ausschluss)))
	{
	  $i++;
      $erg[$i] = $row;
	}
  }

  return $erg;
}

$ordnereinzug = 23;

?>
