<?php

if (!defined('WBLEGAL')) die('Kann nicht ohne Personal WebBase ausgef&uuml;hrt werden.');

//////////////////////////////////////////////////////////////////////////////
// CODIERUNGSFUNKTIONEN                                                     //
//////////////////////////////////////////////////////////////////////////////

function wb_htmlentities($x) {
	return htmlentities($x, ENT_COMPAT, 'iso-8859-1');
}

function encode_critical_html_characters($inp)
{
	$inp = str_replace('&', '&amp;', $inp);
	//$inp = str_replace('"', '&quot;', $inp);
	$inp = str_replace('<', '&lt;', $inp);
	$inp = str_replace('>', '&gt;', $inp);

	return $inp;
}

function decode_critical_html_characters($inp)
{
	$inp = str_replace('&amp;', '&', $inp);
	//$inp = str_replace('&quot;', '"', $inp);
	$inp = str_replace('&lt;', '<', $inp);
	$inp = str_replace('&gt;', '>', $inp);

	return $inp;
}

function executable_html_code($inp)
{
	// Wenn der Benutzer z.B. ä im HTML-Formular eingegeben hat, würde hier aufgrund von Unicode quatsch rauskommen
	$inp = wb_htmlentities($inp, ENT_COMPAT, 'UTF-8');

	$inp = decode_critical_html_characters($inp);

	$trans = get_html_translation_table(HTML_ENTITIES);
	foreach ($trans as $m1 => $m2)
	{
		if (($m2 != '&lt;') && ($m2 != '&gt;'))
		{
			$inp = str_replace(str_replace('&', '&amp;', $m2), $m2, $inp);
		}
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

	return decode_critical_html_characters($inp);
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

function wb_encrypt($message, $key)
{
	return md5_encrypt($message, $key);
}

function wb_decrypt($message, $key)
{
	return md5_decrypt($message, $key);
}

//////////////////////////////////////////////////////////////////////////////
// NÜTZLICHE FUNKTIONEN                                                     //
//////////////////////////////////////////////////////////////////////////////

function WBUserAgent() {
	global $WBConfig;
	return 'ViaThinkSoft Personal WebBase '.$WBConfig->getRevision().' (PHP/'.phpversion().')';
}

// Anmerkung: Subdomains sind nicht gültig.

// @param $name Name des Cookies
// @value $value Wert des Cookies
// @param $time 0 für "Ende der Sitzung" oder Sekundenanzahl als Gültigkeit
function wbSetCookie($name, $value, $time) {
	global $WBConfig;
	if ($time != 0) $time += time();
	setCookie($name, $value, $time, RELATIVE_DIR, /* $_SERVER['HTTP_HOST'] */ '', $WBConfig->getForceSSLFlag());
}

// @param $name
// @param $wb_rel_path Path relative to the WebBase directory (for third-party systems!)
function wbUnsetCookie($name, $wb_rel_path = '') {
	global $WBConfig;
	setCookie($name, '', -1, RELATIVE_DIR.$wb_rel_path, /* $_SERVER['HTTP_HOST'] */ '', $WBConfig->getForceSSLFlag());
}

// TODO (Prüfen)
// Das Argument von deferer() sollte aufgrund der W3C-Konformität &amp; statt & enthalten

function deferer($url) {
	return 'deferer.php?target='.urlencode($url);
}

function ip_tracer($ip) {
	return deferer('http://www.ripe.net/fcgi-bin/whois?form_type=simple&full_query_string=&searchtext='.$ip.'&submit.x=0&submit.y=0');
}

function url_protokoll_vorhanden($url)
{
	$ary = explode('://', $url);
	return ((strpos($ary[0], '/') === false) && (isset($ary[1])));
}

function wb_redirect_now($url) {

	if (url_protokoll_vorhanden($url)) {
		// Umwechseln von HTTP<->HTTPS ist bei gleicher Adresse ohne Deferrer erlaubt
		if ((str_replace('https://', '', $url) != $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']) &&
			(str_replace('http://',  '', $url) != $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']))
		{
			$url = deferer($url); // Umleitung auf eine externe Seite
		}
	}

	if (!headers_sent()) {
		header('Location: '.$url);
	} else {
		// HTML-Weiterleitung
		echo 'Redirect: <a href="'.$url.'">'.$url.'</a><br>'."\r\n\r\n";
		echo '<script language ="JavaScript">
		<!--
			window.location.replace("'.$url.'");
		// -->
		</script>';
	}

	die('');
}

function add_trailing_path_delimiter($url_or_directory) {
	if (substr($url_or_directory, strlen($url_or_directory)-1, 1) != '/') {
		$url_or_directory .= '/';
	}
	return $url_or_directory;
}

function dirname_with_pathdelimiter($directory)
{
	$tmp = dirname($directory);
	$tmp = str_replace('\\', '/', $tmp);
	$tmp = add_trailing_path_delimiter($tmp);
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

function my_wb_htmlentities($inp, $charset = 'utf-8')
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

	return @wb_htmlentities($inp, ENT_NOQUOTES, $cs);
}

function check_email($email_adresse)
{
	if(preg_match("|^[_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,4}$|ismU",$email_adresse))
		return true;
	else
		return false;
}

function return_bytes($val)
{
	$val = trim($val);
	$last = strtolower($val{strlen($val)-1});
	switch($last)
	{
		case 'g':
			$val *= 1024;
		case 'm':
			$val *= 1024;
		case 'k':
			$val *= 1024;
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

function dir_add_trailing_backslash($directory) {
	if (substr($directory, strlen($directory)-1, 1) != '/') $directory .= '/';
	return $directory;
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
			$text = str_replace('/', '\/', $text); // W3C Validation </a> -> <\/a>
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

function oop_link_to_modul($modul, $seite = 'main', $titelzeile_modul = '')
{
	if ($titelzeile_modul == '') $titelzeile_modul = $modul;

	$module_information = WBModuleHandler::get_module_information($titelzeile_modul);

	if (file_exists('modules/'.$titelzeile_modul.'/images/menu/32.gif'))
		$g = 'modules/'.$titelzeile_modul.'/images/menu/32.gif';
	else if (file_exists('modules/'.$titelzeile_modul.'/images/menu/32.png'))
		$g = 'modules/'.$titelzeile_modul.'/images/menu/32.png';
	else
		$g = 'designs/spacer.gif';

	return "javascript:oop('".$modul."', '".$seite."', '".wb_htmlentities($module_information->caption)."', '".$g."');";
}

function wb_list_items($modul, $table, $append, $dir = 0)
{
	global $benutzer;

	if (!isset($erg)) $erg = array();

	$i = 0;
	$res = db_query("SELECT * FROM `$table` WHERE `folder_cnid` = '".db_escape($dir)."' AND `user_cnid` = '".$benutzer['id']."' $append");
	while ($row = db_fetch($res))
	{
		$i++;
		$erg[$i] = $row;
	}

	return $erg;
}

function wb_list_items_filter($modul, $table, $append)
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

function wb_draw_table_begin()
{
	echo '<div align="center"><table cellspacing="0" cellpadding="2" border="0" width="90%">';
}

function wb_draw_table_end()
{
	echo '</table></div><br>';
}

function wb_draw_table_content()
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

function wb_draw_table_span_content($highlight, $span, $text)
{
	if ($highlight == 1) $hfarb = '4';
	if ($highlight == 0) $hfarb = '5';
	if ($highlight == 2) $hfarb = '6';
	echo '<tr class="row_tab" onmouseover="this.className=\'row_tab_act\';" onmouseout="this.className=\'row_tab\';">';
	echo '<td valign="top" align="left" colspan="'.$span.'">'.$text.'</td>';
	echo '</tr>';

}

function wb_draw_item_filter($modul, $table, $append)
{
	global $ordnereinzug, $WBConfig;

	$einzug = 0;
	$ary = wb_list_items_filter($modul, $table, $append);
	$durchlauf = 0;
	for ($i=1; isset($ary[$i]['id']); $i++)
	{
		$durchlauf++;

		if (file_exists('modules/'.$modul.'/includes/menuentry.inc.php'))
			include('modules/'.$modul.'/includes/menuentry.inc.php');

		echo "\n";
	}

	return $durchlauf;
}

function wb_draw_item($modul, $table, $append, $folder = 0, $einzug = 0)
{
	global $ordnereinzug, $WBConfig;

	$ary = wb_list_items($modul, $table, $append, $folder);
	$durchlauf = 0;
	for ($i=1; isset($ary[$i]['id']); $i++)
	{
		$durchlauf++;

		if (file_exists('modules/'.$modul.'/includes/menuentry.inc.php'))
			include('modules/'.$modul.'/includes/menuentry.inc.php');
	}

	return $durchlauf;
}

function wb_draw_menu_item($modul, $seite, $titel, $klein, $gross)
{
	if (file_exists($gross))
		$g = $gross;
	else
		$g = 'designs/spacer.gif';

	if (file_exists($klein))
		$k = $klein;
	else
		$k = 'designs/spacer.gif';

	return '<tr class="row_nav" onmouseover="this.className=\'row_nav_act\';" onmouseout="this.className=\'row_nav\';">
	<td onclick="oop(\''.$modul.'\', \''.$seite.'\', \''.$titel.'\', \''.$g.'\');" valign="middle" align="left"><img src="designs/spacer.gif" height="1" width="3" alt=""></td>
	<td onclick="oop(\''.$modul.'\', \''.$seite.'\', \''.$titel.'\', \''.$g.'\');" valign="bottom" align="left"><img src="'.$k.'" height="16" width="16" alt=""></td>
	<td onclick="oop(\''.$modul.'\', \''.$seite.'\', \''.$titel.'\', \''.$g.'\');" valign="bottom" align="left"><img src="designs/spacer.gif" height="1" width="5" alt=""></td>
	<td onclick="oop(\''.$modul.'\', \''.$seite.'\', \''.$titel.'\', \''.$g.'\');" valign="bottom" align="left" width="100%"><a href="javascript:oop(\''.$modul.'\', \''.$seite.'\', \''.$titel.'\', \''.$g.'\');" class="menu_blk">'.$titel.'</a></td>
	<td onclick="oop(\''.$modul.'\', \''.$seite.'\', \''.$titel.'\', \''.$g.'\');" valign="middle" align="left"><img src="designs/spacer.gif" alt="" width="1" height="1"></td>
</tr>'."\n";
}

function wb_draw_menu_spacer()
{
	return '<tr>
	<td colspan="5"><img src="designs/spacer.gif" alt="" width="1" height="14"></td>
</tr>';
}

//////////////////////////////////////////////////////////////////////////////
// FUNKTIONEN FÜR MODUL-XML UND DESIGN-XML																	//
//////////////////////////////////////////////////////////////////////////////

require 'includes/xml.class.inc.php';
require 'includes/SecureMailer.class.php';

//////////////////////////////////////////////////////////////////////////////
// FUNKTIONEN FÜR MODUL-XML UND DESIGN-XML																	//
//////////////////////////////////////////////////////////////////////////////

class WebBase_Module_Info
{
	private $f_name;
	private $f_author;
	private $f_version;
	private $f_language;

	// 0 = Public Freeware
	// 1 = Public Shareware
	// 2 = Private Secured
	// 3 = Personal WebBase-Core
	// 4 = Personal WebBase-Enclosure
	private $f_license;

	function name() {
		return $this->f_name;
	}

	function author() {
		return $this->f_author;
	}

	function version() {
		return $this->f_version;
	}

	function language() {
		return $this->f_language;
	}

	function license() {
		return $this->f_license;
	}

	function WebBase_Module_Info($name, $author, $version, $language, $license) {
		$this->f_name = $name;
		$this->f_author = $author;
		$this->f_version = $version;
		$this->f_language = $language;
		$this->f_license = $license;
	}
};

class WBModuleHandler {

	private static $cache_module_information = Array();

	function get_module_information($modulename)
	{
		if (isset(self::$cache_module_information[$modulename])) {
			return self::$cache_module_information[$modulename];
		}

		if (function_exists('getmicrotime')) $ss = getmicrotime();

		$xml = new xml();

		if ((!strpos($modulename, '..')) && (file_exists('modules/'.$modulename.'/info.xml')))
		{
			$object = $xml->xml_file_to_object('modules/'.$modulename.'/info.xml');

			if ($object->name == 'moduleinfo')
			{
				$v_expected_name = '';
				$v_author = '';
				$v_version = '';
				$v_language = '';
				$v_license = '';

				foreach ($object->children as $m1 => $m2)
				{
					if ($object->children[$m1]->name == 'expected_name') $v_expected_name = $object->children[$m1]->content;
					if ($object->children[$m1]->name == 'author') $v_author = $object->children[$m1]->content;
					if ($object->children[$m1]->name == 'version') $v_version = $object->children[$m1]->content;
					if ($object->children[$m1]->name == 'language') $v_language = $object->children[$m1]->content;
					if ($object->children[$m1]->name == 'license') $v_license = $object->children[$m1]->content;
				}

				$output = new WebBase_Module_Info($v_expected_name, $v_author, $v_version, $v_language, $v_license);

				if ($output->caption == '') $output->caption = $modulename;

				if (function_exists('getmicrotime')) {
					$ee = getmicrotime();
					global $xml_time;
					$xml_time += $ee-$ss;
					global $xml_count;
					$xml_count++;
				}

				self::$cache_module_information[$modulename] = $output;

				return $output;
			}
			else
			{
				return NULL;
			}
		}
		else
		{
			return NULL;
		}
	}

}

class WebBase_Design_Info
{
	private $f_name;
	private $f_author;
	private $f_version;

	// 0 = Third-Party-Product
	// 1 = Official Product
	private $f_license;

	function name() {
		return $this->f_name;
	}

	function author() {
		return $this->f_author;
	}

	function version() {
		return $this->f_version;
	}

	function license() {
		return $this->f_license;
	}

	function WebBase_Design_Info($name, $author, $version, $license) {
		$this->f_name = $name;
		$this->f_author = $author;
		$this->f_version = $version;
		$this->f_license = $license;
	}
};

class WBModuleHandler {

	private static $cache_design_information = Array();

	function get_design_information($designname)
	{
		if (isset(self::$cache_design_information[$designname])) {
			return self::$cache_design_information[$designname];
		}

		if (function_exists('getmicrotime')) $ss = getmicrotime();

		$xml = new xml();

		if ((!strpos($designname, '..')) && (file_exists('designs/'.$designname.'/info.xml')))
		{
			$object = $xml->xml_file_to_object('designs/'.$designname.'/info.xml');

			if ($object->name == 'designinfo')
			{
				$v_name = '';
				$v_author = '';
				$v_version = '';
				$v_license = '';

				foreach ($object->children as $m1 => $m2)
				{
					if ($object->children[$m1]->name == 'name') $v_name = $object->children[$m1]->content;
					if ($object->children[$m1]->name == 'author') $v_author = $object->children[$m1]->content;
					if ($object->children[$m1]->name == 'version') $v_version = $object->children[$m1]->content;
					if ($object->children[$m1]->name == 'license') $v_license = $object->children[$m1]->content;
				}

				$output = new WebBase_Design_Info($v_name, $v_author, $v_version, $v_license);

				if ($output->name == '') $output->name = $designname;

				if (function_exists('getmicrotime')) {
					$ee = getmicrotime();
					global $xml_time;
					$xml_time += $ee-$ss;
					global $xml_count;
					$xml_count++;
				}

				self::$cache_design_information[$designname] = $output;

				return $output;
			}
			else
			{
				return NULL;
			}
		}
		else
		{
			return NULL;
		}
	}
}

/* Konstanten */

define('RELATIVE_DIR', dir_add_trailing_backslash(dirname($_SERVER['PHP_SELF'])));

?>
