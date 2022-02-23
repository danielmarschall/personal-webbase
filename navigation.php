<?php

require 'includes/main.inc.php';

echo $header_navi;

?><table cellspacing="0" cellpadding="2" border="0" width="100%" style="height:100%">
<tr class="area_bar">
  <td valign="middle" align="center" colspan="5">

  <b><?php

$ueberschrift = '';
$menue = '';
if (isset($modul) && (file_exists('modules/'.wb_dir_escape($modul).'/area_'.wb_dir_escape($area).'.inc.php')))
  include('modules/'.wb_dir_escape($modul).'/area_'.wb_dir_escape($area).'.inc.php');

if (!isset($prv_seite)) $prv_seite = 'inhalt';

if ($ueberschrift != '')
{
  echo $ueberschrift;
}
else
{
  if ($ib_user_type == '0')
	echo 'Gastzugang';
  else if ($ib_user_type == '1')
	echo 'Benutzermen&uuml;';
  else if ($ib_user_type == '2')
	echo 'Verwaltung';
  else
	echo 'Hauptmen&uuml;';
}

  ?></b><img src="design/spacer.gif" alt="" width="1" height="14"></td>
</tr>

<?php

echo gfx_zeichnemenueplatzhalter();

$startgefunden = false;
if ($menue == '')
{
  $men = array();
  foreach ($module as $m1 => $m2)
  {
    if (file_exists('modules/'.wb_dir_escape($m2).'/var.inc.php'))
    {
      $modulueberschrift = $m2; // Wenn keine Überschrift in var.inc.php, dann wird das Modul nicht benannt
      $modulsekpos = '';
      $modulpos = '';
      $modulrechte = '';
      $autor = '';
      $version = '';
      $menuevisible = '';
      $license = '';
      $deaktiviere_zugangspruefung = 0;

      include('modules/'.wb_dir_escape($m2).'/var.inc.php');
      if (((($ib_user_type == 0) || ($ib_user_type == 1)) && ($modulrechte == 0)) || ($ib_user_type == $modulrechte))
      {
        if (($menuevisible) && (file_exists('modules/'.wb_dir_escape($m2).'/pages/inhalt.inc.php')))
        {
          if (file_exists('modules/'.wb_dir_escape($m2).'/images/menu/32.png'))
            $g = 'modules/'.wb_dir_escape($m2).'/images/menu/32.png';
          else if (file_exists('modules/'.wb_dir_escape($m2).'/images/menu/32.gif'))
            $g = 'modules/'.wb_dir_escape($m2).'/images/menu/32.gif';
          else
            $g = 'design/spacer.gif';

          if (file_exists('modules/'.wb_dir_escape($m2).'/images/menu/16.png'))
            $k = 'modules/'.wb_dir_escape($m2).'/images/menu/16.png';
          else if (file_exists('modules/'.wb_dir_escape($m2).'/images/menu/16.gif'))
            $k = 'modules/'.wb_dir_escape($m2).'/images/menu/16.gif';
          else
            $k = 'design/spacer.gif';

          if (!isset($men[$modulpos][$modulsekpos])) $men[$modulpos][$modulsekpos] = '';
          $men[$modulpos][$modulsekpos] .= gfx_zeichnemenuepunkt($m2, 'inhalt', my_htmlentities($modulueberschrift), $k, $g);
        }
        if (isset($prv_modul) && ($m2 == $prv_modul) && (file_exists('modules/'.wb_dir_escape($m2).'/pages/inhalt.inc.php')))
        {
          if (file_exists('modules/'.wb_dir_escape($m2).'/images/menu/32.png'))
            $g = 'modules/'.wb_dir_escape($m2).'/images/menu/32.png';
          else if (file_exists('modules/'.wb_dir_escape($m2).'/images/menu/32.gif'))
            $g = 'modules/'.wb_dir_escape($m2).'/images/menu/32.gif';
          else
            $g = 'design/spacer.gif';

          $endjs = '<script language="JavaScript" type="text/javascript">
		  <!--
		    oop(\''.$m2.'\', \''.$prv_seite.'\', \''.my_htmlentities($modulueberschrift).'\', \''.$g.'\');
		  // -->
</script>'."\n\n";
          $startgefunden = true;
        }
        else
        {
          if (($modulpos == 0) && ($modulsekpos == 0) && (!$startgefunden) && (file_exists('modules/'.wb_dir_escape($m2).'/pages/inhalt.inc.php')))
          {
            if (file_exists('modules/'.wb_dir_escape($m2).'/images/menu/32.png'))
              $g = 'modules/'.wb_dir_escape($m2).'/images/menu/32.png';
            else if (file_exists('modules/'.wb_dir_escape($m2).'/images/menu/32.gif'))
              $g = 'modules/'.wb_dir_escape($m2).'/images/menu/32.gif';
            else
              $g = 'design/spacer.gif';

            $endjs = '<script language="JavaScript" type="text/javascript">
		  <!--
		    oop(\''.$m2.'\', \'inhalt\', \''.my_htmlentities($modulueberschrift).'\', \''.$g.'\');
		  // -->
</script>'."\n\n";
            $startgefunden = true;
          }
        }
      }
    }
  }

  unset($m1);
  unset($m2);

  ksort($men);
  $first = true;
  foreach ($men as $m1 => $m2)
  {
    if ($first)
      $first = false;
    else
      echo gfx_zeichnemenueplatzhalter();
    ksort($men[$m1]);
    foreach ($men[$m1] as $x1 => $x2)
      echo $x2;
  }

  unset($m1);
  unset($m2);
}
else
  echo $menue;

?>

<tr>
  <td colspan="5" height="100%"><img src="design/spacer.gif" alt="" width="1" height="1"></td>
</tr>
</table>

<?php echo $endjs;

echo $footer;

?>
