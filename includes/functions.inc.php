<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

//////////////////////////////////////////////////////////////////////////////
// CODIERUNGSFUNKTIONEN                                                     //
//////////////////////////////////////////////////////////////////////////////

function transamp_replace_spitze_klammern($inp)
{
  $inp = str_replace('&', '&amp;', $inp);
  //$inp = str_replace('"', '&quot;', $inp);
  $inp = str_replace('<', '&lt;', $inp);
  $inp = str_replace('>', '&gt;', $inp);

  return $inp;
}

function undo_transamp_replace_spitze_klammern($inp)
{
  $inp = str_replace('&amp;', '&', $inp);
  //$inp = str_replace('&quot;', '"', $inp);
  $inp = str_replace('&lt;', '<', $inp);
  $inp = str_replace('&gt;', '>', $inp);

  return $inp;
}

function ausfuehrbarer_html_code($inp)
{
  // Wenn der Benutzer z.B. ä im HTML-Formular eingegeben hat, würde hier aufgrund von Unicode quatsch rauskommen
  $inp = my_htmlentities($inp);

  $inp = undo_transamp_replace_spitze_klammern($inp);

  $trans = get_html_translation_table(HTML_ENTITIES);
  foreach ($trans as $m1 => $m2)
  {
    if (($m2 != '&lt;') && ($m2 != '&gt;'))
      $inp = str_replace(str_replace('&', '&amp;', $m2), $m2, $inp);
  }
  unset($m1);
  unset($m2);

  // Erweiterte Zeichensatztabelle, die auch da Euro-Zeichen enthält
  // Entnommen von http://www.php.net/manual/de/function.get-html-translation-table.php#73410
  $trans2 = array('&apos;'=>'&#39;', '&minus;'=>'&#45;', '&circ;'=>'&#94;', '&tilde;'=>'&#126;', '&Scaron;'=>'&#138;', '&lsaquo;'=>'&#139;', '&OElig;'=>'&#140;', '&lsquo;'=>'&#145;', '&rsquo;'=>'&#146;', '&ldquo;'=>'&#147;', '&rdquo;'=>'&#148;', '&bull;'=>'&#149;', '&ndash;'=>'&#150;', '&mdash;'=>'&#151;', '&tilde;'=>'&#152;', '&trade;'=>'&#153;', '&scaron;'=>'&#154;', '&rsaquo;'=>'&#155;', '&oelig;'=>'&#156;', '&Yuml;'=>'&#159;', '&yuml;'=>'&#255;', '&OElig;'=>'&#338;', '&oelig;'=>'&#339;', '&Scaron;'=>'&#352;', '&scaron;'=>'&#353;', '&Yuml;'=>'&#376;', '&fnof;'=>'&#402;', '&circ;'=>'&#710;', '&tilde;'=>'&#732;', '&Alpha;'=>'&#913;', '&Beta;'=>'&#914;', '&Gamma;'=>'&#915;', '&Delta;'=>'&#916;', '&Epsilon;'=>'&#917;', '&Zeta;'=>'&#918;', '&Eta;'=>'&#919;', '&Theta;'=>'&#920;', '&Iota;'=>'&#921;', '&Kappa;'=>'&#922;', '&Lambda;'=>'&#923;', '&Mu;'=>'&#924;', '&Nu;'=>'&#925;', '&Xi;'=>'&#926;', '&Omicron;'=>'&#927;', '&Pi;'=>'&#928;', '&Rho;'=>'&#929;', '&Sigma;'=>'&#931;', '&Tau;'=>'&#932;', '&Upsilon;'=>'&#933;', '&Phi;'=>'&#934;', '&Chi;'=>'&#935;', '&Psi;'=>'&#936;', '&Omega;'=>'&#937;', '&alpha;'=>'&#945;', '&beta;'=>'&#946;', '&gamma;'=>'&#947;', '&delta;'=>'&#948;', '&epsilon;'=>'&#949;', '&zeta;'=>'&#950;', '&eta;'=>'&#951;', '&theta;'=>'&#952;', '&iota;'=>'&#953;', '&kappa;'=>'&#954;', '&lambda;'=>'&#955;', '&mu;'=>'&#956;', '&nu;'=>'&#957;', '&xi;'=>'&#958;', '&omicron;'=>'&#959;', '&pi;'=>'&#960;', '&rho;'=>'&#961;', '&sigmaf;'=>'&#962;', '&sigma;'=>'&#963;', '&tau;'=>'&#964;', '&upsilon;'=>'&#965;', '&phi;'=>'&#966;', '&chi;'=>'&#967;', '&psi;'=>'&#968;', '&omega;'=>'&#969;', '&thetasym;'=>'&#977;', '&upsih;'=>'&#978;', '&piv;'=>'&#982;', '&ensp;'=>'&#8194;', '&emsp;'=>'&#8195;', '&thinsp;'=>'&#8201;', '&zwnj;'=>'&#8204;', '&zwj;'=>'&#8205;', '&lrm;'=>'&#8206;', '&rlm;'=>'&#8207;', '&ndash;'=>'&#8211;', '&mdash;'=>'&#8212;', '&lsquo;'=>'&#8216;', '&rsquo;'=>'&#8217;', '&sbquo;'=>'&#8218;', '&ldquo;'=>'&#8220;', '&rdquo;'=>'&#8221;', '&bdquo;'=>'&#8222;', '&dagger;'=>'&#8224;', '&Dagger;'=>'&#8225;', '&bull;'=>'&#8226;', '&hellip;'=>'&#8230;', '&permil;'=>'&#8240;', '&prime;'=>'&#8242;', '&Prime;'=>'&#8243;', '&lsaquo;'=>'&#8249;', '&rsaquo;'=>'&#8250;', '&oline;'=>'&#8254;', '&frasl;'=>'&#8260;', '&euro;'=>'&#8364;', '&image;'=>'&#8465;', '&weierp;'=>'&#8472;', '&real;'=>'&#8476;', '&trade;'=>'&#8482;', '&alefsym;'=>'&#8501;', '&larr;'=>'&#8592;', '&uarr;'=>'&#8593;', '&rarr;'=>'&#8594;', '&darr;'=>'&#8595;', '&harr;'=>'&#8596;', '&crarr;'=>'&#8629;', '&lArr;'=>'&#8656;', '&uArr;'=>'&#8657;', '&rArr;'=>'&#8658;', '&dArr;'=>'&#8659;', '&hArr;'=>'&#8660;', '&forall;'=>'&#8704;', '&part;'=>'&#8706;', '&exist;'=>'&#8707;', '&empty;'=>'&#8709;', '&nabla;'=>'&#8711;', '&isin;'=>'&#8712;', '&notin;'=>'&#8713;', '&ni;'=>'&#8715;', '&prod;'=>'&#8719;', '&sum;'=>'&#8721;', '&minus;'=>'&#8722;', '&lowast;'=>'&#8727;', '&radic;'=>'&#8730;', '&prop;'=>'&#8733;', '&infin;'=>'&#8734;', '&ang;'=>'&#8736;', '&and;'=>'&#8743;', '&or;'=>'&#8744;', '&cap;'=>'&#8745;', '&cup;'=>'&#8746;', '&int;'=>'&#8747;', '&there4;'=>'&#8756;', '&sim;'=>'&#8764;', '&cong;'=>'&#8773;', '&asymp;'=>'&#8776;', '&ne;'=>'&#8800;', '&equiv;'=>'&#8801;', '&le;'=>'&#8804;', '&ge;'=>'&#8805;', '&sub;'=>'&#8834;', '&sup;'=>'&#8835;', '&nsub;'=>'&#8836;', '&sube;'=>'&#8838;', '&supe;'=>'&#8839;', '&oplus;'=>'&#8853;', '&otimes;'=>'&#8855;', '&perp;'=>'&#8869;', '&sdot;'=>'&#8901;', '&lceil;'=>'&#8968;', '&rceil;'=>'&#8969;', '&lfloor;'=>'&#8970;', '&rfloor;'=>'&#8971;', '&lang;'=>'&#9001;', '&rang;'=>'&#9002;', '&loz;'=>'&#9674;', '&spades;'=>'&#9824;', '&clubs;'=>'&#9827;', '&hearts;'=>'&#9829;', '&diams;'=>'&#9830;');
  $trans2 = array_flip($trans2);
  foreach ($trans2 as $m1 => $m2)
  {
    // Funktioniert chr() bei den 8... Einträgen? Finde Eurozeichen nicht bei chr(8364)!
    $m1 = chr(substr($m1, 2, strlen($m1)-3));

    if (($m2 != '&lt;') && ($m2 != '&gt;'))
      $inp = str_replace(str_replace('&', '&amp;', $m2), $m2, $inp);
  }
  unset($m1);
  unset($m2);

  return undo_transamp_replace_spitze_klammern($inp);
}

//////////////////////////////////////////////////////////////////////////////
// VERSCHLÜSSELUNGSFUNKTIONEN FÜR SESSIONS U.A.                             //
//////////////////////////////////////////////////////////////////////////////

function special_hash($string)
{
  $iterations = 10;

  $last = $string;
  $out = '';
  for ($i=0; $i<$iterations; $i++)
  {
    $last = md5($last);
    $out .= $last;
  }

  $garbarge_count = 0;
  for ($i=0; $i<strlen($last); $i++)
  {
    if (($last[$i] == '0') || ($last[$i] == '1') || ($last[$i] == '2') || ($last[$i] == '3') ||
        ($last[$i] == '4') || ($last[$i] == '5') || ($last[$i] == '6') || ($last[$i] == '7') ||
        ($last[$i] == '8') || ($last[$i] == '9'))
    {
      $garbarge_count = $garbarge_count + $last[$i];
    }
  }

  for ($i=0; $i<=$garbarge_count; $i++)
  {
    $out = $last[0].$out.$last[1];
  }

  if (strlen($out) > 1024) $out = substr($out, 0, 1024);

  return $out;
}

function get_rnd_iv($iv_len)
{
    $iv = '';
    while ($iv_len-- > 0) {
        $iv .= chr(mt_rand() & 0xff);
    }
    return $iv;
}

function md5_encrypt($plain_text, $password, $iv_len = 16)
{
    $plain_text .= "\x13";
    $n = strlen($plain_text);
    if ($n % 16) $plain_text .= str_repeat("\0", 16 - ($n % 16));
    $i = 0;
    $enc_text = get_rnd_iv($iv_len);
    $iv = substr($password ^ $enc_text, 0, 512);
    while ($i < $n) {
        $block = substr($plain_text, $i, 16) ^ pack('H*', md5($iv));
        $enc_text .= $block;
        $iv = substr($block . $iv, 0, 512) ^ $password;
        $i += 16;
    }
    return base64_encode($enc_text);
}

function md5_decrypt($enc_text, $password, $iv_len = 16)
{
    $enc_text = base64_decode($enc_text);
    $n = strlen($enc_text);
    $i = $iv_len;
    $plain_text = '';
    $iv = substr($password ^ substr($enc_text, 0, $iv_len), 0, 512);
    while ($i < $n) {
        $block = substr($enc_text, $i, 16);
        $plain_text .= $block ^ pack('H*', md5($iv));
        $iv = substr($block . $iv, 0, 512) ^ $password;
        $i += 16;
    }
    return preg_replace('/\\x13\\x00*$/', '', $plain_text);
}

function ib_encrypt($message, $key)
{
  return md5_encrypt($message, $key);
}

function ib_decrypt($message, $key)
{
  return md5_decrypt($message, $key);
}

//////////////////////////////////////////////////////////////////////////////
// NÜTZLICHE FUNKTIONEN                                                     //
//////////////////////////////////////////////////////////////////////////////

function dirname_with_pathdelimiter($directory)
{
  $tmp = dirname($directory);
  $tmp = str_replace('\\', '/', $tmp);
  if (substr($tmp, strlen($tmp)-1, 1) != '/') $tmp .= '/';
  return $tmp;
}

function string2hex($str)
{
  if (trim($str) != "")
  {
    $hex = "";
    $length = strlen($str);
    for ($i=0; $i<$length; $i++)
    {
      $hex .= str_pad(dechex(ord($str[$i])), 2, 0, STR_PAD_LEFT);
    }
    return $hex;
  }
}

function hex2string($hex)
{
  $string = '';

  $hex = str_replace(array("\n","\r"," "), "", $hex);

  for ($ix=0; $ix < strlen($hex); $ix=$ix+2)
  {
    $ord = hexdec(substr($hex, $ix, 2));
    $string .= chr($ord);
  }

  return $string;
}

// http://lists.phpbar.de/pipermail/php/Week-of-Mon-20040322/007749.html

function fetchip()
{
  $client_ip = (isset($_SERVER['HTTP_CLIENT_IP'])) ? $_SERVER['HTTP_CLIENT_IP'] : '';
  $x_forwarded_for = (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : '';
  $remote_addr = (isset($_SERVER['REMOTE_ADDR'])) ? $_SERVER['REMOTE_ADDR'] : '';

  if (!empty($client_ip))
  {
    $ip_expl = explode('.',$client_ip);
    $referer = explode('.',$remote_addr);
    if($referer[0] != $ip_expl[0])
    {
      $ip=array_reverse($ip_expl);
      $return=implode('.',$ip);
    }
    else
    {
      $return = $client_ip;
    }
  }
  else if (!empty($x_forwarded_for))
  {
    if(strstr($x_forwarded_for,','))
    {
      $ip_expl = explode(',',$x_forwarded_for);
      $return = end($ip_expl);
    }
    else
    {
      $return = $x_forwarded_for;
    }
  }
  else
  {
    $return = $remote_addr;
  }
  unset ($client_ip, $x_forwarded_for, $remote_addr, $ip_expl);
  return $return;
}

// http://de.php.net/manual/de/function.fsockopen.php#73581
// http://de.php.net/manual/de/function.fsockopen.php#75175

function decode_header ( $str )
{
    $part = preg_split ( "/\r?\n/", $str, -1, PREG_SPLIT_NO_EMPTY );
    $out = array ();

    for ( $h = 0; $h < sizeof ( $part ); $h++ )
    {
        if ( $h != 0 )
        {
            $pos = strpos ( $part[$h], ':' );
            $k = strtolower ( str_replace ( ' ', '', substr ( $part[$h], 0, $pos ) ) );
            $v = trim ( substr ( $part[$h], ( $pos + 1 ) ) );
        }
        else
        {
            $k = 'status';
            $v = explode ( ' ', $part[$h] );
            $v = $v[1];
        }

        if ($k == '') break; // Zusatz von Personal WebBase

        if ( $k == 'set-cookie' )
        {
                $out['cookies'][] = $v;
        }
        else if ( $k == 'content-type' )
        {
            if ( ( $cs = strpos ( $v, ';' ) ) !== false )
            {
                $out[$k] = substr ( $v, 0, $cs );
            }
            else
            {
                $out[$k] = $v;
            }
        }
        else
        {
            $out[$k] = $v;
        }
    }

    return $out;
}

function decode_body ( $info, $str, $eol = "\r\n" )
{
  $tmp = $str;
  $add = strlen ( $eol );
  $str = '';
  if ( isset ( $info['transfer-encoding'] ) && $info['transfer-encoding'] == 'chunked' )
  {
    do
    {
      $tmp = ltrim ( $tmp );
      $pos = strpos ( $tmp, $eol );
      $len = hexdec ( substr ( $tmp, 0, $pos ) );
      if ( isset ( $info['content-encoding'] ) )
      {
        $str .= gzinflate ( substr ( $tmp, ( $pos + $add + 10 ), $len ) );
      }
      else
      {
        $str .= substr ( $tmp, ( $pos + $add ), $len );
      }

      $tmp = substr ( $tmp, ( $len + $pos + $add ) );
      $check = trim ( $tmp );
    }
    while ( ! empty ( $check ) );
  }
  else if ( isset ( $info['content-encoding'] ) )
  {
    $str = gzinflate ( substr ( $tmp, 10 ) );
  }
  else {
    $str = $tmp;
  }
  return $str;
}

function url_protokoll_vorhanden($url)
{
  $ary = explode('://', $url);
  return ((strpos($ary[0], '/') === false) && (isset($ary[1])));
}

function my_get_contents($url, $show_errors = false, $ignore_status_code = false, $time_out = 10, $umleitung_limit = 50, $umleitung_count = 0)
{
  if (!url_protokoll_vorhanden($url)) $url = 'http://'.$url;

  if (!inetconn_ok())
  {
    if ($show_errors)
    {
      echo '<b>Fehler:</b> my_get_contents('.$url.'): Es existiert keine Internetverbindung.<br>';
    }
    return false;
  }

  // Jetzt reichts abba...
  if ($umleitung_count > $umleitung_limit)
  {
    if ($show_errors)
    {
      echo '<b>Fehler:</b> my_get_contents('.$url.'): Umleitungslimit von 50 erreicht.<br>';
    }
    return false;
  }

  // URL splitten
  $ary = explode('://', $url);
  $cry = explode('/', $ary[1]);
  $bry = explode(':', $cry[0]);

  // Host festlegen
  $ssl = '';
  $host = $bry[0];

  // Port festlegen und ggf. SSL-Präfix setzen
  if (isset($bry[1]))
  {
    $port = $bry[1];
  }
  else
  {
    if ($ary[0] == 'ftp')
    {
      $port = 21;
    }
    if ($ary[0] == 'http')
    {
      $port = 80;
    }
    else if ($ary[0] == 'https')
    {
      $ssl = 'ssl://';
      $port = 443;
    }
    else
    {
      $port = 80; // Problem
    }
  }

  // Request-String festlegen
  $req = '';
  for ($i=1; isset($cry[$i]); $i++)
  {
    $req .= '/'.$cry[$i];
  }
  if ($req == '') $req = '/';

  // User-Agent = Personal WebBase
  $revision = '???';
  if (file_exists('includes/rev.inc.php')) include('includes/rev.inc.php');
  $uagent = 'ViaThinkSoft-Personal WebBase/'.$revision;

  // Anfrage starten
  $fp = @fsockopen($ssl.$host, $port, $errno, $errstr, $time_out);
  if (!$fp)
  {
    if ($show_errors)
    {
      echo '<b>Fehler:</b> my_get_contents('.$url.'): Fehler beim &ouml;ffnen des Sockets - '.$errstr.' ('.$errno.')<br>';
    }
    return false;
  }
  else
  {
    $tmp = '';
    @fputs ($fp, "GET $req HTTP/1.1\r\nHost: $host\r\nConnection: close\r\nUser-Agent: $uagent\r\n\r\n");
    while (!@feof($fp))
    {
      $tmp .= @fgets($fp,128);
    }
    @fclose($fp);

    $info = decode_header($tmp);

    // Fehler?
    if ((!$ignore_status_code) && (isset($info['status'])) && ($info['status'] >= 400))
    {
      if ($show_errors)
      {
        echo '<b>Fehler:</b> my_get_contents('.$url.'): HTTP-Status-Code '.$info['status'].'<br>';
      }
      return false;
    }

    // Umleitung vorhanden?
    if ((isset($info['location'])) && ($info['location'] != ''))
    {
      if (strpos($info['location'], '://') !== false)
      {
        // 1. Fall: http://www.example.com/test.php

        return my_get_contents($info['location'], $show_errors, $ignore_status_code, $time_out, $umleitung_limit, $umleitung_count+1);
      }
      else if (substr($info['location'], 0, 2) == './')
      {
        // 2. Fall: ./test.php

        if (substr($req, strlen($req)-1, 1) != '/')
        {
          // Entweder ein Verzeichnis ohne / am Ende oder eine Datei
          // Letztes Element muss abgeschnitten werden
          $x = '';
          $gry = explode('/', $req);
          for ($j=1; isset($gry[$j+1]); $j++)
          {
            $x .= '/'.$gry[$j];
          }
          $x .= '/';
        }
        else
        {
          $x = $req;
        }
        $x .= substr($info['location'], 2, strlen($info['location'])-2);

        return my_get_contents($ary[0].'://'.$host.$x, $show_errors, $ignore_status_code, $time_out, $umleitung_limit, $umleitung_count+1);
      }
      else if (substr($info['location'], 0, 1) == '/')
      {
        // 3. Fall: /test.php

        $x = $info['location'];

        return my_get_contents($ary[0].'://'.$host.$x, $show_errors, $ignore_status_code, $time_out, $umleitung_limit, $umleitung_count+1);
      }
      else
      {
        // 4. Fall: test.php (= ./test.php)

        $x = $req;
        if (substr($req, strlen($req)-1, 1) != '/')
        {
          // Entweder ein Verzeichnis ohne / am Ende oder eine Datei
          // Letztes Element muss abgeschnitten werden
          $x = '';
          $gry = explode('/', $req);
          for ($j=1; isset($gry[$j+1]); $j++)
          {
            $x .= '/'.$gry[$j];
          }
          $x .= '/';
        }
        else
        {
          $x = $req;
        }
        $x .= $info['location'];

        return my_get_contents($ary[0].'://'.$host.$x, $show_errors, $ignore_status_code, $time_out, $umleitung_limit, $umleitung_count+1);
      }
    }

    // Content filtern
    $con = explode("\r\n\r\n", $tmp);
    $tmp = '';
    for ($i=1; isset($con[$i]); $i++)
    {
      $tmp .= $con[$i];
      if (isset($con[$i+1])) $tmp .= "\r\n\r\n";
    }

    return decode_body ( $info, $tmp );
  }
}

function my_htmlentities($inp, $charset = 'iso-8859-1')
{
  // http://www.php.net/manual/de/function.htmlspecialchars.php
  // PHP-Version wird nicht kontrolliert...
  $cs = 'utf-8';

  if (strtolower($charset) == 'iso-8859-1') $cs = 'ISO-8859-1';
  if (strtolower($charset) == 'iso8859-1') $cs = 'ISO-8859-1';
  if (strtolower($charset) == 'iso-8859-15') $cs = 'ISO-8859-15';
  if (strtolower($charset) == 'iso8859-15') $cs = 'ISO-8859-15';
  if (strtolower($charset) == 'utf-8') $cs = 'UTF-8';
  if (strtolower($charset) == 'cp866') $cs = 'cp866';
  if (strtolower($charset) == 'ibm866') $cs = 'cp866';
  if (strtolower($charset) == '866') $cs = 'cp866';
  if (strtolower($charset) == 'cp1251') $cs = 'cp1251';
  if (strtolower($charset) == 'windows-1251') $cs = 'cp1251';
  if (strtolower($charset) == 'win-1251') $cs = 'cp1251';
  if (strtolower($charset) == '1251') $cs = 'cp1251';
  if (strtolower($charset) == 'cp1252') $cs = 'cp1252';
  if (strtolower($charset) == 'windows-1252') $cs = 'cp1252';
  if (strtolower($charset) == '1252') $cs = 'cp1252';
  if (strtolower($charset) == 'koi8-r') $cs = 'KOI8-R';
  if (strtolower($charset) == 'koi8-ru') $cs = 'KOI8-R';
  if (strtolower($charset) == 'koi8r') $cs = 'KOI8-R';
  if (strtolower($charset) == 'big5') $cs = 'BIG5';
  if (strtolower($charset) == '950') $cs = 'BIG5';
  if (strtolower($charset) == 'gb2312') $cs = 'GB2312';
  if (strtolower($charset) == '936') $cs = 'GB2312';
  if (strtolower($charset) == 'big5-hkscs') $cs = 'BIG5-HKSCS';
  if (strtolower($charset) == 'shift_jis') $cs = 'Shift_JIS';
  if (strtolower($charset) == 'sjis') $cs = 'Shift_JIS';
  if (strtolower($charset) == '932') $cs = 'Shift_JIS';
  if (strtolower($charset) == 'euc-jp') $cs = 'EUC-JP';
  if (strtolower($charset) == 'eucjp') $cs = 'EUC-JP';

  return @htmlentities($inp, ENT_NOQUOTES, $cs);
}

function check_email($email_adresse)
{
  return preg_match("/^[_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,4}$/",$email_adresse);
}

function return_bytes($val)
{
  $val = trim($val);
  if (is_numeric($val)) return $val;
  $last = strtolower($val[strlen($val)-1]);
  $val = substr($val,0,strlen($val)-1);
  switch($last)
  {
    case 'g':
      $val *= 1024;
      /* ... falls through ... */
    case 'm':
      $val *= 1024;
      /* ... falls through ... */
    case 'k':
      $val *= 1024;
      /* ... falls through ... */
  }
  return $val;
}

function zufall($size)
{
  $result = "";

  srand((double)microtime()*1000000);

   for($i=0; $i < $size; $i++)
  {
    $num = rand(48,120);
    while (($num >= 58 && $num <= 64) || ($num >= 91 && $num <= 96))
       $num = rand(48,120);

    $result .= chr($num);
  }
  return $result;
}

function runden($inp, $nachkommastellen = 0)
{
  return number_format($inp, $nachkommastellen, ",", ".");
}

// PHP-AntiSpam-Funktion "secure_email", Version 3.0
// von Daniel Marschall [www.daniel-marschall.de]

function secure_email($email, $linktext, $crypt_linktext)
{
  if (!function_exists('alas_js_crypt'))
  {
    function alas_js_crypt($text)
    {
      $tmp = '';
      for ($i=0; $i<strlen($text); $i++)
      {
        $tmp .= 'document.write("&#'.ord(substr($text, $i, 1)).';");';
      }
      return $tmp;
    }
  }

  if (!function_exists('alas_js_write'))
  {
    function alas_js_write($text)
    {
      $text = str_replace('\\', '\\\\', $text);
      $text = str_replace('"', '\"', $text);
      return 'document.write("'.$text.'");';
    }
  }

  $aus = '';
  if ($email != '')
  {
    $aus .= '<script language="JavaScript" type="text/javascript"><!--'."\n";
    $aus .= alas_js_write('<a href="');
    $aus .= alas_js_crypt('mailto:'.$email);
    $aus .= alas_js_write('">');
    $aus .= $crypt_linktext ? alas_js_crypt($linktext) : alas_js_write($linktext);
    $aus .= alas_js_write('</a>').'// --></script>';
  }
  return $aus;
}

function de_convertmysqldatetime($datum, $zeige_sekunden = false)
{
  if (($datum == '') || ($datum == '0000-00-00 00:00:00'))
  {
	return 'Unbekannt';
  }
  else
  {

	$date = explode(" ", $datum);
    $ddatum = explode("-", $date[0]);
    if (isset($date[1]))
    {
      $date = explode(":", $date[1]);
    }
    else
    {
      $date[0] = '';
      $date[1] = '';
      $date[2] = '';
    }


    if ($ddatum[1] == '01') $mon = 'Januar';
    if ($ddatum[1] == '02') $mon = 'Februar';
    if ($ddatum[1] == '03') $mon = 'M&auml;rz';
    if ($ddatum[1] == '04') $mon = 'April';
    if ($ddatum[1] == '05') $mon = 'Mai';
    if ($ddatum[1] == '06') $mon = 'Juni';
    if ($ddatum[1] == '07') $mon = 'Juli';
    if ($ddatum[1] == '08') $mon = 'August';
    if ($ddatum[1] == '09') $mon = 'September';
    if ($ddatum[1] == '10') $mon = 'Oktober';
    if ($ddatum[1] == '11') $mon = 'November';
    if ($ddatum[1] == '12') $mon = 'Dezember';
    $tag = sprintf("%d",$ddatum[2]);
    $datum = $tag.". ".$mon." ".$ddatum[0];

    if (($date[0] != '') && ($date[1] != ''))
    {
      if ($zeige_sekunden) $zus = ':'.$date[2]; else $zus = '';
      return $datum.', '.$date[0].':'.$date[1].$zus.' Uhr';
    }
    else
      return $datum;
  }
}

function zwischen_url($url, $von, $bis, $flankierungen_miteinbeziehen = true)
{
  return zwischen_str(my_get_contents($url), $von, $bis, $flankierungen_miteinbeziehen);
}

function zwischen_str($str, $von, $bis, $flankierungen_miteinbeziehen = true)
{
  $ausgabe = $str;

  if ($von != '')
  {
    $pos = strpos($ausgabe, $von);
    if ($pos !== false)
    {
      $ausgabe = substr($ausgabe, $pos, strlen($ausgabe)-$pos);
      if (!$flankierungen_miteinbeziehen)
        $ausgabe = substr($ausgabe, strlen($von), strlen($ausgabe)-strlen($von)-1); // -1 ?
    }
  }

  if ($bis != '')
  {
    $pos = strpos($ausgabe, $bis);
    if ($pos !== false)
    {
      $ausgabe = substr($ausgabe, 0, $pos+strlen($bis));
      if (!$flankierungen_miteinbeziehen)
        $ausgabe = substr($ausgabe, 0, strlen($ausgabe)-strlen($bis));
    }
  }

  return $ausgabe;
}

//////////////////////////////////////////////////////////////////////////////
// GFX/LISTE/OOP-FUNKTIONEN                                                 //
//////////////////////////////////////////////////////////////////////////////

function oop_link_to_modul($modul, $seite = 'inhalt', $titelzeile_modul = '')
{
  $titel = $modul;

  $modulueberschrift = '';
  $modulsekpos = '';
  $modulpos = '';
  $modulrechte = '';
  $autor = '';
  $version = '';
  $menuevisible = '';
  $license = '';
  $deaktiviere_zugangspruefung = 0;

  if ($titelzeile_modul == '') $titelzeile_modul = $modul;

  if (file_exists('modules/'.wb_dir_escape($titelzeile_modul).'/var.inc.php'))
  {
    include('modules/'.wb_dir_escape($titelzeile_modul).'/var.inc.php');
    $titel = $modulueberschrift;
  }

  if (file_exists('modules/'.wb_dir_escape($titelzeile_modul).'/images/menu/32.png'))
    $g = 'modules/'.wb_dir_escape($titelzeile_modul).'/images/menu/32.png';
  else if (file_exists('modules/'.wb_dir_escape($titelzeile_modul).'/images/menu/32.gif'))
    $g = 'modules/'.wb_dir_escape($titelzeile_modul).'/images/menu/32.gif';
  else
    $g = 'design/spacer.gif';

  return "javascript:oop('".$modul."', '".$seite."', '".my_htmlentities($titel)."', '".$g."');";
}

function liste_items($modul, $table, $append, $dir = 0)
{
  global $benutzer;

  if (!isset($erg)) $erg = array();

  $i = 0;
  $res = db_query("SELECT * FROM `$table` WHERE `folder` = '".db_escape($dir)."' AND `user` = '".$benutzer['id']."' $append");
  while ($row = db_fetch($res))
  {
    $i++;
    $erg[$i] = $row;
  }

  return $erg;
}

function liste_items_filter($modul, $table, $append)
{
  $i = 0;

  $res = db_query("SELECT * FROM `$table` $append");
  while ($row = db_fetch($res))
  {
    $i++;
    $erg[$i] = $row;
  }

  return $erg;
}

function gfx_begintable()
{
  echo '<div align="center"><table cellspacing="0" cellpadding="2" border="0" width="90%">';
}

function gfx_endtable()
{
  echo '</table></div><br>';
}

function gfx_tablecontent()
{
  echo '<tr class="row_tab" onmouseover="this.className=\'row_tab_act\';" onmouseout="this.className=\'row_tab\';">';
  $j = 0;
  for ($i=0; $i < @func_num_args(); $i=$i+2)
  {
    $j++;
    if (@func_get_arg($i) != '')
	  $w = 'width="'.@func_get_arg($i).'" ';
	else
      $w = '';
    echo '<td valign="top" align="left" '.$w.'>'.@func_get_arg($i+1).'</td>';
  }
  if ($j == 0)
	echo '<td valign="top" align="left" width="100%">&nbsp;</td>';
  echo '</tr>'."\n";
}

function gfx_tablespancontent($highlight, $span, $text)
{
  if ($highlight == 1) $hfarb = '4';
  if ($highlight == 0) $hfarb = '5';
  if ($highlight == 2) $hfarb = '6';
  echo '<tr class="row_tab" onmouseover="this.className=\'row_tab_act\';" onmouseout="this.className=\'row_tab\';">';
  echo '<td valign="top" align="left" colspan="'.$span.'">'.$text.'</td>';
  echo '</tr>';

}

function gfx_zeichneitems_filter($modul, $table, $append)
{
  global $ordnereinzug, $mysql_zugangsdaten;

  $einzug = 0;
  $ary = liste_items_filter($modul, $table, $append);
  $durchlauf = 0;
  for ($i=1; isset($ary[$i]['id']); $i++)
  {
    $durchlauf++;

    if (file_exists('modules/'.wb_dir_escape($modul).'/menueeintrag.inc.php'))
      include('modules/'.wb_dir_escape($modul).'/menueeintrag.inc.php');

    echo "\n";
  }

  return $durchlauf;
}

function gfx_zeichneitems($modul, $table, $append, $folder = 0, $einzug = 0)
{
  global $ordnereinzug, $mysql_zugangsdaten;

  $ary = liste_items($modul, $table, $append, $folder);
  $durchlauf = 0;
  for ($i=1; isset($ary[$i]['id']); $i++)
  {
    $durchlauf++;

    if (file_exists('modules/'.wb_dir_escape($modul).'/menueeintrag.inc.php'))
      include('modules/'.wb_dir_escape($modul).'/menueeintrag.inc.php');
  }

  return $durchlauf;
}

function gfx_zeichnemenuepunkt($modul, $seite, $titel, $klein, $gross)
{
  if (file_exists($gross))
    $g = $gross;
  else
    $g = 'design/spacer.gif';

  if (file_exists($klein))
    $k = $klein;
  else
    $k = 'design/spacer.gif';

  return '<tr class="row_nav" onmouseover="this.className=\'row_nav_act\';" onmouseout="this.className=\'row_nav\';">
  <td onclick="oop(\''.$modul.'\', \''.$seite.'\', \''.$titel.'\', \''.$g.'\');" valign="middle" align="left"><img src="design/spacer.gif" height="1" width="3" alt=""></td>
  <td onclick="oop(\''.$modul.'\', \''.$seite.'\', \''.$titel.'\', \''.$g.'\');" valign="bottom" align="left"><img src="'.$k.'" height="16" width="16" alt=""></td>
  <td onclick="oop(\''.$modul.'\', \''.$seite.'\', \''.$titel.'\', \''.$g.'\');" valign="bottom" align="left"><img src="design/spacer.gif" height="1" width="5" alt=""></td>
  <td onclick="oop(\''.$modul.'\', \''.$seite.'\', \''.$titel.'\', \''.$g.'\');" valign="bottom" align="left" width="100%"><a href="javascript:oop(\''.$modul.'\', \''.$seite.'\', \''.$titel.'\', \''.$g.'\');" class="menu_blk">'.$titel.'</a></td>
  <td onclick="oop(\''.$modul.'\', \''.$seite.'\', \''.$titel.'\', \''.$g.'\');" valign="middle" align="left"><img src="design/spacer.gif" alt="" width="1" height="1"></td>
</tr>'."\n";
}

function gfx_zeichnemenueplatzhalter()
{
  return '<tr>
  <td colspan="5"><img src="design/spacer.gif" alt="" width="1" height="14"></td>
</tr>';
}

function wb_dir_escape($s) {
	$s = str_replace('..', '__', $s);
	$s = str_replace('~', '_', $s);
	$s = str_replace('/', '_', $s);
	$s = str_replace('\\', '_', $s);
	$s = str_replace(chr(0), '_', $s);
	return $s;
}
