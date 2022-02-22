<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

if (inetconn_ok())
{
  $res3 = db_query("SELECT `id`, `url`, `name`, `update_text_begin`, `update_text_end`, `update_lastchecked`, `update_lastcontent`, `update_checkurl`, `neu_flag`, `kaputt_flag`, `user` FROM `".$mysql_zugangsdaten['praefix']."links` WHERE (`update_enabled` = '1') AND (((`update_lastchecked` <= DATE_SUB(NOW(), INTERVAL ".$konfiguration[$m2]['update_checkinterval_min']." MINUTE)) AND (`kaputt_flag` = '0')) OR ((`update_lastchecked` <= DATE_SUB(NOW(), INTERVAL ".$konfiguration[$m2]['kaputt_checkinterval_min']." MINUTE)) AND (`kaputt_flag` = '1'))) ORDER BY `id`");
  while ($row3 = db_fetch($res3))
  {
    // Ist unsere Bedingung immer noch aktuell? Da sich die Cron-Scripts aufgrund Überlastung
    // überschneiden können, könnte ohne diese Prüfung ein Link 10 Mal pro Sitzung geprüft werden
    $res_check = db_query("SELECT `id` FROM `".$mysql_zugangsdaten['praefix']."links` WHERE (`update_enabled` = '1') AND (((`update_lastchecked` <= DATE_SUB(NOW(), INTERVAL ".$konfiguration[$m2]['update_checkinterval_min']." MINUTE)) AND (`kaputt_flag` = '0')) OR ((`update_lastchecked` <= DATE_SUB(NOW(), INTERVAL ".$konfiguration[$m2]['kaputt_checkinterval_min']." MINUTE)) AND (`kaputt_flag` = '1'))) AND (`id` = '".db_escape($row3['id'])."')");
    if (db_num($res_check) > 0)
    {
      db_query("UPDATE `".$mysql_zugangsdaten['praefix']."links` SET `update_lastchecked` = NOW() WHERE `id` = '".db_escape($row3['id'])."'");

      $update_checkurl = $row3['update_checkurl'];

      if (strpos($update_checkurl, '://') === false)
        $update_checkurl = 'http://'.$update_checkurl;

      $update_checkurl = entferne_anker($update_checkurl);

      $a = zwischen_url($update_checkurl, str_replace('&amp;', '&', $row3['update_text_begin']), str_replace('&amp;', '&', $row3['update_text_end']));
      $fehler = $a === false;

      $a = md5($a);
      $b = $row3['update_lastcontent'];

      if ($fehler)
      {
        $kaputt = '1';
        $new = $row3['neu_flag'];
      }
      else
      {
        $kaputt = '0';
        $new = ($a == $b) ? '0' : '1';
      }

      if ($row3['kaputt_flag'] != $kaputt)
      {
        db_query("UPDATE `".$mysql_zugangsdaten['praefix']."links` SET `kaputt_flag` = '".db_escape($kaputt)."' WHERE `id` = '".db_escape($row3['id'])."'");
      }

      if (($row3['neu_flag'] == '0') && ($new == '1'))
      {
        if ($new == '1') $zus = ", update_lastcontent = '".db_escape($a)."'"; else $zus = '';
        db_query("UPDATE `".$mysql_zugangsdaten['praefix']."links` SET `neu_flag` = '".db_escape($new)."'$zus WHERE `id` = '".db_escape($row3['id'])."'");

        // Dual-Crossover (statisch)
        $x2 = 'core_links_notifier';
        $inp_user = $row3['user'];

        $modulueberschrift = '';
        $modulsekpos = '';
        $modulpos = '';
        $modulrechte = '';
        $autor = '';
        $version = '';
        $menuevisible = '';
        $license = '';
        $deaktiviere_zugangspruefung = 0;

        if (file_exists('modules/'.wb_dir_escape($x2).'/var.inc.php'))
          include 'modules/'.wb_dir_escape($x2).'/var.inc.php';

        if (file_exists('modules/'.wb_dir_escape($x2).'/crossover/'.wb_dir_escape($m2).'/notify.inc.php'))
          include 'modules/'.wb_dir_escape($x2).'/crossover/'.wb_dir_escape($m2).'/notify.inc.php';
      }
    }
  }
}

?>
