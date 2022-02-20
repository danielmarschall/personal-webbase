<?php

if (!defined('IBLEGAL')) die('Kann nicht ohne IronBASE ausgef&uuml;hrt werden.');

  if ($aktion == 'dest')
  {
    if (isset($pwd) && ($pwd != $ib_user_passwort) && ($ib_user_type == 1))
      die($header.'<h1>Daten&uuml;bertragung</h1>Es wurde ein falsches Passwort eingegeben.'.$footer);

    if (strtoupper($sic) != 'OK')
      die($header.'<h1>Daten&uuml;bertragung</h1>Sie m&uuml;ssen das Sicherheitsfeld ausf&uuml;llen!'.$footer);

    foreach ($tabellen as $m1 => $m2)
    {
      if (isset($datenbanktabellen[$mysql_zugangsdaten['praefix'].$m2]['user']))
      {
        db_query("DELETE FROM `".$mysql_zugangsdaten['praefix'].$m2."` WHERE `user` = '".$benutzer['id']."'");
        if (db_affected_rows() > 0)
          db_query("OPTIMIZE TABLE `".$mysql_zugangsdaten['praefix'].$m2."`");
      }
    }

    unset($m1);
	unset($m2);

    echo $header.'<h1>Daten&uuml;bertragung</h1>Es wurden alle Datens&auml;tze entfernt.'.$footer;
  }

  if ($aktion == 'dump')
  {
    if (isset($pwd) && ($pwd != $ib_user_passwort) && ($ib_user_type == 1))
    {
      echo $header.'<h1>Daten&uuml;bertragung</h1>Es wurde ein falsches Passwort eingegeben.'.$footer;
    }
    else
    {
      if($_FILES['dfile']['tmp_name'])
      {
          ob_start();
          readfile($_FILES['dfile']['tmp_name']);
          $inh = ob_get_contents();
          ob_end_clean();

          $m = '';

		  // Größten Datensatz finden, um Dateiduplikate zu verhindern
		  $max = 0;
		  foreach ($tabellen as $m1 => $m2)
		  {
		    $rs = db_query("SELECT MAX(`id`) AS `ma` FROM `".$mysql_zugangsdaten['praefix'].db_escape($m2)."`");
		    $rw = db_fetch($rs);
		    if ($rw['ma'] > $max)
		      $max = $rw['ma'];
		  }

		  unset($m1);
		  unset($m2);

		  $warn = '';
		  $firstds = true;
		  $falsche_rev = false;
		  $aktionzeile = 1;
		  $inh = str_replace("\r", '', $inh);
		  $inh = str_replace("\n", '', $inh);
		  $ar1 = explode(";", $inh);
		  foreach ($ar1 as $a11 => $a12)
		  {
		    if ($firstds)
		    {
		      $firstds = false;
		      if ($a12 != 'IRONBASE#1')
		      {
		        $falsche_rev = true;
		        $warn .= '<b>Schwerer Fehler:</b><br><br>Dies ist keine g&uuml;ltige IronBASE-Datensicherung. Das Kopfzeilenelement &quot;IRONBASE#1&quot; wurde nicht gefunden.';
		      }
		    }
		    else if ((!$falsche_rev) && ($a12 != ''))
		    {
		      $aktionzeile++;
		      $namen = '';
		      $werte = '';
		      $ar2 = explode('*', $a12);
		      $t = $ar2[0];
		      $d = $ar2[1];
		      $temp = $tabellen;
		      @array_flip($temp);
		      if (!array_key_exists($t, $temp))
		      {
		        $ar3 = explode(',', $d);
		        foreach ($ar3 as $a31 => $a32)
		        {
		          $ar4 = explode('~', $a32);
		          $neu_namen = "`".db_escape(base64_decode($ar4[0]))."`, ";
                  if (base64_decode($ar4[0]) == 'id')
		          {
		            $neu_werte = "'".db_escape(base64_decode($ar4[1])+$max)."', ";
		          }
		          else
		          {
		            if ((base64_decode($ar4[0]) == 'folder') && (base64_decode($ar4[1]) != 0))
		              $neu_werte = "'".db_escape(base64_decode($ar4[1])+$max)."', ";
		            else
		              $neu_werte = "'".db_escape(base64_decode($ar4[1]))."', ";
		          }

		          // Benutzerfeld darf nicht vom Datensatz aus hervorgehen!
		          if ($ar4[0] == 'user')
		          {
		            $warn .= 'Schutzverletzung des Typs B beim Versuch, den Benutzer bei folgender Stelle zu setzen:<br><code>Backup-Zeile: #'.$aktionzeile.'</code><br><br>';
		          }
		          else
		          {
		            $namen .= $neu_namen;
		            $werte .= $neu_werte;
		          }
		        }
		      }
		      else
		      {
		        $warn .= 'Schutzverletzung des Typs A beim Versuch, Daten in folgende nichtexistente Tabelle einzuf&uuml;gen:<br><code>'.htmlentities(base64_decode($t)).'</code><br><br>';
		      }
		      $sql = "INSERT INTO `".$mysql_zugangsdaten['praefix'].base64_decode($t)."` ($namen`user`) VALUES ($werte'".$benutzer['id']."')";
		      // Debug: echo htmlentities($sql).'<br><br>';
		      if (!db_query($sql))
		       $warn .= 'Fehler beim Ausf&uuml;hren des Befehls:<br><code>'.htmlentities($sql).'</code><br>MySQL gab folgende Fehlermeldung aus:<br><code>'.mysql_error().'</code><br><br>';
		    }
		  }
		  $m = $warn;

          echo $header;
          echo '<h1>Daten&uuml;bertragung</h1>';
          if ($m != '')
            echo '<b>Bei der Daten&uuml;bertragung sind einige Fehler aufgetreten. Sie sind hier aufgelistet.</b><br><br>'.$m;
          else
            echo '<b>Die Daten&uuml;bertragung wurde erfolgreich beendet!</b>';
          echo $footer;
      }
      else
      {
          echo "$headerBitte geben Sie eine Datei an!$footer";
      }
    }
  }

?>