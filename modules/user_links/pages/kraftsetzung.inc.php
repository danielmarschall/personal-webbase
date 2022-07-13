<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

  if ($aktion == 'edit')
  {
    // Hat der Dabbes das "http://" vergessen?
    if (!url_protokoll_vorhanden($update_checkurl)) $update_checkurl = 'http://'.$update_checkurl;
    if (!url_protokoll_vorhanden($url)) $url = 'http://'.$url;

    // Titel selbstständig hinzufügen
    if ($name == '')
    {
	  if (inetconn_ok())
	  {
	    $dateiinhalt = my_get_contents($url);
	    @preg_match_all('/<title>(.+?)<\/title>/im', $dateiinhalt, $matches);
        if (isset($matches[1][0]))
        {
          $tmp = $matches[1][0];
          if ($tmp != '')
	        $lname = $matches[1][0];
	      else
            $lname = 'Unbenannte Webseite';
        }
        else
        {
          $lname = 'Unbenannte Webseite';
        }
      }
      else
      {
        $lname = 'Unbenannte Webseite';
      }
    }
    else
    {
      $lname = $name;
    }

    // Enthält Check-URL einen Anker? Entfernen
    $update_checkurl = entferne_anker($update_checkurl);

    if (!isset($update_enabled)) $update_enabled = '0';

    // Ersten Inhalt hinzufügen, sofern Link-Updates aktiviert und Internetverbindung vorhanden
    if (($update_enabled) && (inetconn_ok()))
    {
      $cont = zwischen_url($update_checkurl, undo_transamp_replace_spitze_klammern($update_text_begin), undo_transamp_replace_spitze_klammern($update_text_end));
	  $cont = md5($cont);
	  $zus = ", `update_lastchecked` = NOW(), `update_lastcontent` = '".db_escape($cont)."'";
	}
	else
	{
	  $zus = '';
	}

    // Gehört der Ordner auch dem Benutzer?
    $res = db_query("SELECT `user` FROM `".$mysql_zugangsdaten['praefix']."ordner` WHERE `id` = '".db_escape($folder)."'");
    $row = db_fetch($res);
    if ($row['user'] != $benutzer['id'])
      $folder = 0;

    // Ausführen
	db_query("UPDATE `".$mysql_zugangsdaten['praefix']."links` SET `name` = '".db_escape($name)."', `folder` = '".db_escape($folder)."', `url` = '".db_escape($url)."', `update_enabled` = '".db_escape($update_enabled)."', `update_checkurl` = '".db_escape($update_checkurl)."', `update_text_begin` = '".db_escape($update_text_begin)."', `update_text_end` = '".db_escape($update_text_end)."'$zus WHERE `id` = '".db_escape($id)."' AND `user` = '".$benutzer['id']."'");
    if ($danach == 'A') if (!headers_sent()) header('location: '.$_SERVER['PHP_SELF'].'?seite=inhalt&modul='.urlencode($modul));
    if ($danach == 'B') if (!headers_sent()) header('location: '.$_SERVER['PHP_SELF'].'?seite=edit&modul='.urlencode($modul).'&aktion=new&danach='.urlencode($danach));
    if ($danach == 'C') if (!headers_sent()) header('location: '.$_SERVER['PHP_SELF'].'?seite=edit&modul='.urlencode($modul).'&aktion=new&folder='.urlencode($folder).'&danach='.urlencode($danach));
  }

  if ($aktion == 'new')
  {
    // Hat der Dabbes das "http://" vergessen?
    if (!url_protokoll_vorhanden($update_checkurl)) $update_checkurl = 'http://'.$update_checkurl;
    if (!url_protokoll_vorhanden($url)) $url = 'http://'.$url;

    // Titel selbstständig hinzufügen
    if ($name == '')
    {
	  if (inetconn_ok())
	  {
	    $dateiinhalt = my_get_contents($url);
	    @preg_match_all('/<title>(.+?)<\/title>/im', $dateiinhalt, $matches);
        if (isset($matches[1][0]))
        {
          $tmp = $matches[1][0];
          if ($tmp != '')
	        $lname = $matches[1][0];
	      else
            $lname = 'Unbenannte Webseite';
        }
        else
        {
          $lname = 'Unbenannte Webseite';
        }
      }
      else
      {
        $lname = 'Unbenannte Webseite';
      }
    }
    else
    {
      $lname = $name;
    }

    // Enthält Check-URL einen Anker? Entfernen
    $update_checkurl = entferne_anker($update_checkurl);

    if (!isset($update_enabled)) $update_enabled = '0';

    // Ersten Inhalt hinzufügen, sofern Link-Updates aktiviert und Internetverbindung vorhanden
    if (($update_enabled) && (inetconn_ok()))
    {
      $cont = zwischen_url($update_checkurl, undo_transamp_replace_spitze_klammern($update_text_begin), undo_transamp_replace_spitze_klammern($update_text_end));
	  $cont = md5($cont);
	  $zus1 = "`update_lastchecked`, `update_lastcontent`, ";
	  $zus2 = "NOW(), '".db_escape($cont)."', ";
	}
	else
	{
	  $zus1 = '';
	  $zus2 = '';
	}

    // Gehört der Ordner auch dem Benutzer?
    $res = db_query("SELECT `user` FROM `".$mysql_zugangsdaten['praefix']."ordner` WHERE `id` = '".db_escape($folder)."'");
    $row = db_fetch($res);
    if ($row['user'] != $benutzer['id'])
      $folder = 0;

    if (!isset($update_enabled)) $update_enabled = '0';

    // Ausführen
    db_query("INSERT INTO `".$mysql_zugangsdaten['praefix']."links` (`name`, `url`, `folder`, `update_enabled`, `update_checkurl`, `update_text_begin`, `update_text_end`, $zus1`neu_flag`, `kaputt_flag`, `user`) VALUES ('".db_escape($lname)."', '".db_escape($url)."', '".db_escape($folder)."', '".db_escape($update_enabled)."', '".db_escape($update_checkurl)."', '".db_escape($update_text_begin)."', '".db_escape($update_text_end)."', $zus2'0', '0', '".$benutzer['id']."')");
    if ($danach == 'A') if (!headers_sent()) header('location: '.$_SERVER['PHP_SELF'].'?seite=inhalt&modul='.urlencode($modul));
    if ($danach == 'B') if (!headers_sent()) header('location: '.$_SERVER['PHP_SELF'].'?seite=edit&modul='.urlencode($modul).'&aktion=new&danach='.urlencode($danach));
    if ($danach == 'C') if (!headers_sent()) header('location: '.$_SERVER['PHP_SELF'].'?seite=edit&modul='.urlencode($modul).'&aktion=new&folder='.urlencode($folder).'&danach='.urlencode($danach));
  }

  if ($aktion == 'delete')
  {
    db_query("DELETE FROM `".$mysql_zugangsdaten['praefix']."links` WHERE `id` = '".db_escape($id)."' AND `user` = '".$benutzer['id']."'");
    if (db_affected_rows() > 0)
      db_query("OPTIMIZE TABLE `".$mysql_zugangsdaten['praefix']."links`");

    if (!headers_sent()) header('location: '.$_SERVER['PHP_SELF'].'?seite=inhalt&modul='.urlencode($modul));
  }

if (($aktion == 'changekonfig') && ($wb_user_type >= 2))
{
  if ($aktion == 'changekonfig')
  {
    if ((isset($update_checkinterval_min)) && (is_numeric($update_checkinterval_min)))
      ib_change_config('update_checkinterval_min', db_escape($update_checkinterval_min), $modul);

    if ((isset($kaputt_checkinterval_min)) && (is_numeric($kaputt_checkinterval_min)))
      ib_change_config('kaputt_checkinterval_min', db_escape($kaputt_checkinterval_min), $modul);

    if (!isset($vonmodul)) $vonmodul = 'admin_konfig';
    if (!isset($vonseite)) $vonseite = 'inhalt';

    if (!headers_sent())
      header('location: '.$_SERVER['PHP_SELF'].'?seite='.urlencode($vonseite).'&modul='.urlencode($vonmodul));
  }
}
else
  die('Keine Zugriffsberechtigung');

?>
