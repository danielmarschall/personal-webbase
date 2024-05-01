<?php

/*
 * ViaThinkSoft
 * PHP Simple Internet Class (HTTPC = HTTP Class)
 * Version: 1.4.1 (2009-08-06)
 * Source: http://www.viathinksoft.de/?page=projektanzeige&seite=download&id=152
 */

/* USAGE EXAMPLE */

/* function inetconn_ok() {
	return true;
}

$http = new HTTPClass;

// Everything is optional in this part
$http->connection_checker = 'inetconn_ok';
$http->user_agent = 'Hello World Browser';
$http->redirect_limit = 15;
$http->time_out = 10;
$http->error_level = HTTPC_ERRLVL_FATAL_ERRORS;
$http->use_old_http_protocol_version = false;
$http->use_post_method = false;
$http->additional_fields['Referer'] = 'http://www.viathinksoft.de/';

$res = $http->execute_http_request('http://www.example.com/');
if ($res->error != HTTPC_NO_ERROR) {
	echo 'Error!';
} else {
	if (!is_null($res->final_redirected_url)) echo '<p>Last redirection was: '.$res->final_redirected_url.'</p>';
	echo '<p><code>'.nl2br(wb_htmlentities($res->content)).'</code></p>';
} */

define('HTTPC_NO_ERROR', 0);
define('HTTPC_ERROR_INTERNET_CONNECTION', 1);
define('HTTPC_ERROR_PROTOCOL', 2);
define('HTTPC_ERROR_SOCKET', 3);
define('HTTPC_WARNING_HTTP_STATUS_CODE', 4);
define('HTTPC_ERROR_TOO_MANY_REDIRECTS', 5);
define('HTTPC_WARNING_UNKNOWN_STATUS', 6);
define('HTTPC_WARNING_REDIRECT_IGNORED', 7);
define('HTTPC_WARNING_CONNECTION_CHECKER_INVALID', 8);

class HTTPClassResult {

	public $content = null;
	public $status_code = null;
	public $error = HTTPC_NO_ERROR;
	public $error_info = null;
	public $final_redirected_url = null;
	public $redirect_counter = 0;
	public $header = null;

}

define('HTTPC_ERRLVL_NO_ERRORS', 0);
define('HTTPC_ERRLVL_FATAL_ERRORS', 1);
define('HTTPC_ERRLVL_WARNINGS', 2);

class HTTPClass {

	public $user_agent;
	public $redirect_limit;
	public $time_out;
	public $error_level;
	public $connection_checker;
	public $use_old_http_protocol_version;
	public $use_post_method;
	public $additional_fields;

	// Konstruktor

	function __construct()
	{
		$this->user_agent = 'PHP/'.phpversion();
		$this->redirect_limit = 50;
		$this->time_out = 10;
		$this->error_level = HTTPC_ERRLVL_WARNINGS;
		$this->connection_checker = null;
		$this->use_old_http_protocol_version = false;
		$this->use_post_method = false;
		$this->additional_fields = array();
	}

	// http://de.php.net/manual/de/function.fsockopen.php#73581
	// http://de.php.net/manual/de/function.fsockopen.php#75175

	private function decode_header ( $str )
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

	private function decode_body ( $info, $str, $eol = "\r\n" )
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

	private function url_protokoll_vorhanden($url)
	{
		$ary = explode('://', $url);
		return ((strpos($ary[0], '/') === false) && (isset($ary[1])));
	}

	private function get_error_class($code)
	{
		return floor($code / 100);
	}

	public function execute_http_request($url, $data_to_send)
	{
		$result = new HTTPClassResult();

		if (!is_null($this->connection_checker)) {
			if (!function_exists($this->connection_checker)) {
				if ($this->error_level >= HTTPC_ERRLVL_WARNINGS) {
					trigger_error("The connection checker function does not exists!", E_USER_WARNING);
				}
				$result->error = HTTPC_WARNING_CONNECTION_CHECKER_INVALID;
				$result->error_info = null;
			} else {
				if (!call_user_func($this->connection_checker)) {
					if ($this->error_level >= HTTPC_ERRLVL_FATAL_ERRORS) {
						trigger_error('No internet connection', E_USER_ERROR);
					}
					$result->error = HTTPC_ERROR_INTERNET_CONNECTION;
					return $result;
				}
			}
		}

		for ($result->redirect_counter = 0; $result->redirect_counter <= $this->redirect_limit; $result->redirect_counter++) {
			if (!$this->url_protokoll_vorhanden($url)) $url = 'http://'.$url;

			// URL splitten
			$ary = explode('://', $url);
			$cry = explode('/', $ary[1]);
			$bry = explode(':', $cry[0]);

			// Protokoll festlegen
			$protocol = strtolower($ary[0]);

			// Und nun prüfen, ob das Protokoll gültig ist
			if (($protocol != 'http') && ($protocol != 'https')) {
				if ($this->error_level >= HTTPC_ERRLVL_FATAL_ERRORS) {
					trigger_error("Unknown protocol '$protocol'", E_USER_ERROR);
				}
				$result->error = HTTPC_ERROR_PROTOCOL;
				$result->error_info = $protocol;
				return $result;
			}

			// Host festlegen
			$host = $bry[0];

			// Port festlegen und ggf. SSL-Präfix setzen
			if (isset($bry[1])) {
				// Es ist ein Port angegeben
				$port = $bry[1];
			} else {
				// Wenn nicht, dann den Standardports für das Protokoll anwählen

				if ($protocol == 'http') {
					$port = 80;
				} else if ($protocol == 'https') {
					$port = 443;
				}
			}

			// Wenn SSL verwendet wird, dann den Präfix setzen
			if ($protocol == 'https') {
				$ssl_prefix = 'ssl://';
			} else {
				$ssl_prefix = '';
			}

			// Request-String festlegen
			$req = '';
			for ($i=1; isset($cry[$i]); $i++) {
				$req .= '/'.$cry[$i];
			}
			if ($req == '') $req = '/';

			// Anfrage starten
			$fp = @fsockopen($ssl_prefix.$host, $port, $errno, $errstr, $this->time_out);
			if (!$fp) {
				if ($this->error_level >= HTTPC_ERRLVL_FATAL_ERRORS) {
					trigger_error("Could not open socket: '$errstr' ($errno)", E_USER_ERROR);
				}
				$result->error = HTTPC_ERROR_SOCKET;
				$result->error_info = "$errstr ($errno)";
				return $result;
			}

			if ($this->use_post_method) {
				// Anmerkung: Es gab Fälle, bei denen PHP in eine Endlosschleife stieg, wenn man bei POST nicht einzelne puts() verwendet

				if ($this->use_old_http_protocol_version) {
					@fputs ($fp, "POST $req HTTP/1.0\r\n");
				} else {
					@fputs ($fp, "POST $req HTTP/1.1\r\n");
					@fputs ($fp, "Host: $host\r\n");
					@fputs ($fp, "Connection: close\r\n");
				}

				foreach ($this->additional_fields as $akey => $aval) {
					@fputs ($fp, "$akey: $aval\r\n");
				}

				if ($data_to_send != '') {
					fputs($fp, "Content-length: ". strlen($data_to_send) ."\r\n");
				}

				@fputs ($fp, "User-Agent: ".$this->user_agent."\r\n\r\n");
				@fputs($fp, $data_to_send);
			} else {
				if ($this->use_old_http_protocol_version) {
					$request  = "GET $req HTTP/1.0\r\n";
				} else {
					$request  = "GET $req HTTP/1.1\r\n";
					$request .= "Host: $host\r\n";
					$request .= "Connection: close\r\n";
				}

				foreach ($this->additional_fields as $akey => $aval) {
					$request .= "$akey: $aval\r\n";
				}

				if ($data_to_send != '') {
					fputs($fp, "Content-length: ". strlen($data_to_send) ."\r\n");
				}

				$request .= "User-Agent: ".$this->user_agent."\r\n\r\n";
				$request .= $data_to_send;

				@fputs ($fp, $request);
			}

			$tmp = '';
			while (!@feof($fp)) {
				$tmp .= @fgets($fp,128);
			}
			@fclose($fp);

			// Die Kopfzeilen auswerten

			$result->header = $this->decode_header($tmp);

			if (isset($result->header['status'])) {
				$result->status_code = $result->header['status'];
			} else {
				// Das sollte niemals passieren ...

				if ($this->error_level >= HTTPC_ERRLVL_WARNINGS) {
					trigger_error("HTTP-Status-Code unknown!", E_USER_WARNING);
				}
				$result->error = HTTPC_WARNING_UNKNOWN_STATUS;
				$result->error_info = null;

				$result->status_code = 0;
			}

			// Fehler (Status-Klassen ab 4)?

			if ($this->get_error_class($result->status_code) >= 4) {
				if ($this->error_level >= HTTPC_ERRLVL_WARNINGS) {
					trigger_error("HTTP-Status-Code: '".$result->status_code."'!", E_USER_WARNING);
				}
				$result->error = HTTPC_WARNING_HTTP_STATUS_CODE;
				$result->error_info = $result->status_code;
				// Here NO return, since we also want to see the HTML-content of the error page
			}

			// Prüfen, ob eine Weiterleitung vorhanden ist.

			$location_vorhanden = ((isset($result->header['location'])) && ($result->header['location'] != ''));

			if ((($this->get_error_class($result->status_code) == 3) || ($result->status_code == 201)) &&
				 ($location_vorhanden)) {
				// Anmerkung: Laut RFC2616 ist das Feld "Location" scheinbar nur bei HTTP-Code 201 oder 3xx gültig.
				// Daher prüfe ich zusätzlich, ob der Statuscode 3xx oder 201 vorliegt.
				$weiterleitung = $result->header['location'];
			} else {
				$weiterleitung = null;

				if ($location_vorhanden) {
					// Das sollte eigentlich nicht passieren ...

					if ($this->error_level >= HTTPC_ERRLVL_WARNINGS) {
						trigger_error("A redirect was found but ignored because the status code '".$result->status_code."' did not allow it", E_USER_WARNING);
					}
					$result->error = HTTPC_WARNING_REDIRECT_IGNORED;
					$result->error_info = $result->header['location']." (".$result->status_code.")";
				}
			}

			if (!is_null($weiterleitung)) {
				if (strpos($weiterleitung, '://') !== false) {
					// 1. Fall: http://www.example.com/test.php

					$url = $weiterleitung;
				} else if (substr($weiterleitung, 0, 2) == './') {
					// 2. Fall: ./test.php

					if (substr($req, strlen($req)-1, 1) != '/') {
						// Entweder ein Verzeichnis ohne / am Ende oder eine Datei
						// Letztes Element muss abgeschnitten werden
						$x = '';
						$gry = explode('/', $req);
						for ($j=1; isset($gry[$j+1]); $j++) {
							$x .= '/'.$gry[$j];
						}
						$x .= '/';
					} else {
						$x = $req;
					}
					$x .= substr($weiterleitung, 2, strlen($weiterleitung)-2);

					$url = $protocol.'://'.$host.$x;
				} else if (substr($weiterleitung, 0, 1) == '/') {
					// 3. Fall: /test.php

					$x = $weiterleitung;

					$url = $protocol.'://'.$host.$x;
				} else {
					// 4. Fall: test.php (= ./test.php)

					$x = $req;
					if (substr($req, strlen($req)-1, 1) != '/') {
						// Entweder ein Verzeichnis ohne / am Ende oder eine Datei
						// Letztes Element muss abgeschnitten werden
						$x = '';
						$gry = explode('/', $req);
						for ($j=1; isset($gry[$j+1]); $j++) {
							$x .= '/'.$gry[$j];
						}
						$x .= '/';
					} else {
						$x = $req;
					}
					$x .= $weiterleitung;

					$url = $protocol.'://'.$host.$x;
				}

				$result->header = null;
				$result->final_redirected_url = $url;
			} else {
				// Keine Weiterleitungen vorhanden

				// Content filtern
				$con = explode("\r\n\r\n", $tmp);
				$tmp = '';
				for ($i=1; isset($con[$i]); $i++) {
					$tmp .= $con[$i];
					if (isset($con[$i+1])) $tmp .= "\r\n\r\n";
				}

				$result->content = $this->decode_body($result->header, $tmp);
				return $result;
			}
		}

		// Es wurde zu oft umgeleitet
		if ($this->error_level >= HTTPC_ERRLVL_FATAL_ERRORS) {
			trigger_error("Redirect limit of '".$this->redirect_limit."' at URL '".$url."' redirects exceeded", E_USER_ERROR);
		}
		$result->error = HTTPC_ERROR_TOO_MANY_REDIRECTS;
		$result->error_info = $this->redirect_limit;
		return $result;
	}
}

?>
