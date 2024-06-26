<?
# phpop RCS version info:
# $Id: class.pop3.inc.php,v 1.4.2.1 2005/02/27 04:51:43 roytoo Exp $
/*

	class.POP3.php3 v1.0	99/03/24 CDI cdi@thewebmasters.net
	Copyright (c) 1999 - CDI (cdi@thewebmasters.net) All Rights Reserved

	An RFC 1939 compliant wrapper class for the POP3 protocol.
*/
class POP3
{
	var $ERROR		= "";		//	Error string.

	var $TIMEOUT	= 60;		//	Default timeout before giving up on a
								//	network operation.

	var $COUNT		= -1;		//	Mailbox msg count

	var $BUFFER		= 512;		//	Socket buffer for socket fgets() calls.
								//	Per RFC 1939 the returned line a POP3
								//	server can send is 512 bytes.

	var $FP			= "";		//	The connection to the server's
								//	file descriptor


	var $DEBUG		= false;	// set to true to echo pop3
								// commands and responses to error_log
								// this WILL log passwords!

	var $BANNER		= "";		//	Holds the banner returned by the
								//	pop server - used for apop()

	var $RFC1939	= true;		//	Set by noop(). See rfc1939.txt
								//

	var $ALLOWAPOP	= false;	//	Allow or disallow apop()
								//	This must be set to true
								//	manually.

	var $VMAILMGR	= false;		// Set to true if using VMailMgr

	var $MAILSERVER	= "";		// Holds the server name

	function POP3 ( $server = "localhost", $timeout = "" )
	{
		settype($this->BUFFER,"integer");

		if(!empty($server)) {
			$this->MAILSERVER = $server;
		}

		if(!empty($timeout)) {
			settype($timeout,"integer");
			$this->TIMEOUT = $timeout;
			@set_time_limit($timeout);
		}

		return true;
	}

	function pop_login ($login, $pass) {
		# connect to the pop server
		if (!$this->connect($this->MAILSERVER) ) {
		  	$error_msg .= sprintf("Failed to connect to POP server %s on port %s.<br><small>%s</small>", $auth->auth["server"], $auth->auth["port"], $pop3->ERROR);
			return false;
		}

		# login to the POP server
		$count = $this->apop($login, $pass);

		if ( $count < 0 ) {
			$error_msg .= "Failed to login to POP server<br><small>$pop3->ERROR</small>";
			return $count;
		}

		return $count;
	}

	function update_timer ()
	{
		@set_time_limit($this->TIMEOUT);
		return true;
	}

	function connect ($server, $port = 110)
	{
		//	Opens a socket to the specified server. Unless overridden,
		//	port defaults to 110. Returns true on success, false on fail

		if(empty($server)) {
			$this->ERROR = "POP3 connect: No server specified";
			unset($this->FP);
			return false;
		} else {
			$this->MAILSERVER = $server;
		}

		$fp = @fsockopen("$server", $port, &$errno, &$errstr, $this->TIMEOUT);

		if(!$fp)
		{
			$this->ERROR = "POP3 connect: Error [$errno] [$errstr]";
			unset($this->FP);
			return false;
		}

		set_socket_blocking($fp,-1);
		$this->update_timer();
		$reply = fgets($fp,$this->BUFFER);
		$reply = $this->strip_clf($reply);
		if($this->DEBUG) { error_log("POP3 SEND [connect: $server] GOT [$reply]",0); }
		if(!$this->is_ok($reply))
		{
			$this->ERROR = "POP3 connect: Error [$reply]";
			unset($this->FP);
			return false;
		}
		$this->FP = $fp;
		$this->BANNER = $this->parse_banner($reply);
		/*$this->RFC1939 = $this->noop();
		if($this->RFC1939)
		{
	      if ($this->VMAILMGR) {
	      } else {
	  			$this->ERROR = "POP3: premature NOOP OK, NOT an RFC 1939 Compliant server";
		  		$this->quit();
			  	return false;
	      }
		}*/
		return true;
	}

	function noop ()
	{
		if(!isset($this->FP))
		{
			$this->ERROR = "POP3 noop: No connection to server";
			return false;
		}
		$cmd = "NOOP";
		$reply = $this->send_cmd($cmd);
		if(!$this->is_ok($reply))
		{
			return false;
		}
		return true;
	}

	function user ($user = "")
	{
		// Sends the USER command, returns true or false

		if(empty($user))
		{
			$this->ERROR = "POP3 user: no user id submitted";
			return false;
		}
		if(!isset($this->FP))
		{
			$this->ERROR = "POP3 user: connection not established";
			return false;
		}

		if ($this->VMAILMGR) {
		  $user = sprintf("%s:%s", $user, $this->MAILSERVER);
		}

    $reply = $this->send_cmd("USER $user");
		if(!$this->is_ok($reply))
		{
			$this->ERROR = "POP3 user: Error [$reply]";
			return false;
		}
		return true;
	}

	function pass ($pass = "")
	{
		// Sends the PASS command, returns # of msgs in mailbox,
		// returns false (undef) on Auth failure

		if(empty($pass))
		{
			$this->ERROR = "POP3 pass: no password submitted";
			return -2;
		}
		if(!isset($this->FP))
		{
			$this->ERROR = "POP3 pass: connection not established";
			return -3;
		}
		$reply = $this->send_cmd("PASS $pass");
		if(!$this->is_ok($reply))
		{
			$this->ERROR = "POP3 pass: authentication failed [$reply]";
			$this->quit();
			return -4;
		}
		//	Auth successful.
		$count = $this->last("count");
		$this->COUNT = $count;
		$this->RFC1939 = $this->noop();
		if(!$this->RFC1939)
		{
			$this->ERROR = "POP3 pass: NOOP failed. Server not RFC 1939 compliant";
			$this->quit();
			return -5;
		}
		return $count;
	}

	function apop ($login,$pass)
	{
		//	Attempts an APOP login. If this fails, it'll
		//	try a standard login. YOUR SERVER MUST SUPPORT
		//	THE USE OF THE APOP COMMAND!
		//	(apop is optional per rfc1939)

		if(!isset($this->FP))
		{
			$this->ERROR = "POP3 apop: No connection to server";
			return false;
		}

		if(!$this->ALLOWAPOP)
		{
			$retVal = $this->login($login,$pass);
			return $retVal;
		}

		if(empty($login))
		{
			$this->ERROR = "POP3 apop: No login ID submitted";
			return false;
		}
		if(empty($pass))
		{
			$this->ERROR = "POP3 apop: No password submitted";
			return false;
		}
		$banner = $this->BANNER;
		if( (!$banner) or (empty($banner)) )
		{
			$this->ERROR = "POP3 apop: No server banner - aborted";
			$retVal = $this->login($login,$pass);
			return $retVal;
		}
		$AuthString = $banner;
		$AuthString .= $pass;
		$APOPString = md5($AuthString);
		$cmd = "APOP $login $APOPString";
		$reply = $this->send_cmd($cmd);
		if(!$this->is_ok($reply))
		{
			$this->ERROR = "POP3 apop: apop authentication failed - abort";
			$retVal = $this->login($login,$pass);
			return $retVal;
		}
		//	Auth successful.
		$count = $this->last("count");
		$this->COUNT = $count;
		$this->RFC1939 = $this->noop();
		if(!$this->RFC1939)
		{
			$this->ERROR = "POP3 apop: NOOP failed. Server not RFC 1939 compliant";
			$this->quit();
			return false;
		}
		return $count;
	}

	function login ($login = "", $pass = "")
	{
		// Sends both user and pass. Returns # of msgs in mailbox or
		// false on failure (or -1, if the error occurs while getting
		// the number of messages.)

		if(!isset($this->FP))
		{
			$this->ERROR = "POP3 login: No connection to server";
			return false;
		}
		$fp = $this->FP;
		if(!$this->user($login))
		{
			//	Preserve the error generated by user()
			return false;
		}
		$count = $this->pass($pass);

		return $count;
	}

	function top ($msgNum, $numLines = "0")
	{
		//	Gets the header and first $numLines of the msg body
		//	returns data in an array with each returned line being
		//	an array element. If $numLines is empty, returns
		//	only the header information, and none of the body.

		if(!isset($this->FP))
		{
			$this->ERROR = "POP3 top: No connection to server";
			return false;
		}
		$this->update_timer();

		$fp = $this->FP;
		$buffer = $this->BUFFER;
		$cmd = "TOP $msgNum $numLines";
		fwrite($fp, "TOP $msgNum $numLines\r\n");
		$reply = fgets($fp, $buffer);
		$reply = $this->strip_clf($reply);
		if($this->DEBUG) { @error_log("POP3 SEND [$cmd] GOT [$reply]",0); }
		if(!$this->is_ok($reply))
		{
			$this->ERROR = "POP3 top: Error [$reply]";
			return false;
		}

		$count = 0;

		$line = fgets($fp,$buffer);
		while(!ereg("^\.\r\n",$line))
		{
			$msg .= $line;
			$line = fgets($fp,$buffer);
			if(empty($line)) {
				break;
			}
		}
		return $msg;
	}

	function pop_list ($msgNum = "")
	{
		//	If called with an argument, returns that msgs' size in octets
		//	No argument returns an associative array of undeleted
		//	msg numbers and their sizes in octets

		if(!isset($this->FP))
		{
			$this->ERROR = "POP3 pop_list: No connection to server";
			return false;
		}
		$fp = $this->FP;
		$Total = $this->COUNT;
		if( (!$Total) or ($Total == -1) )
		{
			return false;
		}
		if($Total == 0)
		{
			return array("0","0");
			// return -1;	// mailbox empty
		}

		$this->update_timer();

		if(!empty($msgNum))
		{
			$cmd = "LIST $msgNum";
			fwrite($fp,"$cmd\r\n");
			$reply = fgets($fp,$this->BUFFER);
			$reply = $this->strip_clf($reply);
			if($this->DEBUG) { @error_log("POP3 SEND [$cmd] GOT [$reply]",0); }
			if(!$this->is_ok($reply))
			{
				$this->ERROR = "POP3 pop_list: Error [$reply]";
				return false;
			}
			list($junk,$num,$size) = explode(" ",$reply);
			return $size;
		}
		$cmd = "LIST";
		$reply = $this->send_cmd($cmd);
		if(!$this->is_ok($reply))
		{
			$reply = $this->strip_clf($reply);
			$this->ERROR = "POP3 pop_list: Error [$reply]";
			return false;
		}
		$MsgArray = array();
		$MsgArray[0] = $Total;
		$line = fgets($fp,$this->BUFFER);
		$line = $this->strip_clf($line);

		while(!ereg("^\.", $line))
		{
			list($thisMsg,$msgSize) = explode(" ",$line);
			$MsgArray["$thisMsg"] = $msgSize;
			$line = fgets($fp,$this->BUFFER);
			$line = $this->strip_clf($line);
		}
		return $MsgArray;
	}

	function get ($msgNum)
	{
		//	Retrieve the specified msg number. Returns an array
		//	where each line of the msg is an array element.

		if(!isset($this->FP))
		{
			$this->ERROR = "POP3 get: No connection to server";
			return false;
		}

		$this->update_timer();

		$fp = $this->FP;
		$buffer = $this->BUFFER;
		$cmd = "RETR $msgNum";
		$reply = $this->send_cmd($cmd);

		if(!$this->is_ok($reply))
		{
			$this->ERROR = "POP3 get: Error [$reply]";
			return false;
		}

		$MsgArray = array();

		$line = fgets($fp,$buffer);
		while(!ereg("^\.\r\n",$line))
		{
			$MsgArray[] = $line;
			$line = fgets($fp,$buffer);
			if(empty($line)) {
				break;
			}
		}
		return $MsgArray;
	}

	function get_text($msgNum) {
		//	Retrieve the specified msg number. Returns the
		//  mail as plain text.

		if(!isset($this->FP))
		{
			$this->ERROR = "POP3 get: No connection to server";
			return false;
		}

		$this->update_timer();

		$fp = $this->FP;
		$buffer = $this->BUFFER;
		$cmd = "RETR $msgNum";
		$reply = $this->send_cmd($cmd);

		if(!$this->is_ok($reply))
		{
			$this->ERROR = "POP3 get: Error [$reply]";
			return false;
		}

		$line = fgets($fp,$buffer);
		while(!ereg("^\.\r\n",$line))
		{
			$msg .= $line;
			$line = fgets($fp,$buffer);
			if(empty($line)) {
				break;
			}
		}
		return $msg;
	}

	function get_mail($msgNum) {
	// This function returns an array which contains all headers.
		// Get the message. Every array element is a single line.
      	$message = $this->get($msgNum);

		$mail = new mime_mail($message);

		return $mail;
	}

	function last ( $type = "count" )
	{
		//	Returns the highest msg number in the mailbox.
		//	returns -1 on error, 0+ on success, if type != count
		//	results in a popstat() call (2 element array returned)

		$last = -1;
		if(!isset($this->FP))
		{
			$this->ERROR = "POP3 last: No connection to server";
			return $last;
		}

		$reply = $this->send_cmd("STAT");
		if(!$this->is_ok($reply))
		{
			$this->ERROR = "POP3 last: error [$reply]";
			return $last;
		}

		$Vars = explode(" ",$reply);
		$count = $Vars[1];
		$size = $Vars[2];
		settype($count,"integer");
		settype($size,"integer");
		if($type != "count")
		{
			return array($count,$size);
		}
		return $count;
	}

	function reset ()
	{
		//	Resets the status of the remote server. This includes
		//	resetting the status of ALL msgs to not be deleted.
		//	This method automatically closes the connection to the server.

		if(!isset($this->FP))
		{
			$this->ERROR = "POP3 reset: No connection to server";
			return false;
		}
		$reply = $this->send_cmd("RSET");
		if(!$this->is_ok($reply))
		{
			//	The POP3 RSET command -never- gives a -ERR
			//	response - if it ever does, something truely
			//	wild is going on.

			$this->ERROR = "POP3 reset: Error [$reply]";
			@error_log("POP3 reset: ERROR [$reply]",0);
		}
		$this->quit();
		return true;
	}

	function send_cmd ( $cmd = "" )
	{
		//	Sends a user defined command string to the
		//	POP server and returns the results. Useful for
		//	non-compliant or custom POP servers.
		//	Do NOT include the \r\n as part of your command
		//	string - it will be appended automatically.

		//	The return value is a standard fgets() call, which
		//	will read up to $this->BUFFER bytes of data, until it
		//	encounters a new line, or EOF, whichever happens first.

		//	This method works best if $cmd responds with only
		//	one line of data.

		if(!isset($this->FP))
		{
			$this->ERROR = "POP3 send_cmd: No connection to server";
			return false;
		}

		if(empty($cmd))
		{
			$this->ERROR = "POP3 send_cmd: Empty command string";
			return "";
		}

		$fp = $this->FP;
		$buffer = $this->BUFFER;
		$this->update_timer();
		fwrite($fp,"$cmd\r\n");
		$reply = fgets($fp,$buffer);
		$reply = $this->strip_clf($reply);
		if($this->DEBUG) { @error_log("POP3 SEND [$cmd] GOT [$reply]",0); }
		return $reply;
	}

	function quit ()
	{
		//	Closes the connection to the POP3 server, deleting
		//	any msgs marked as deleted.

		if(!isset($this->FP))
		{
			$this->ERROR = "POP3 quit: connection does not exist";
			return false;
		}
		$fp = $this->FP;
		$cmd = "QUIT";
		fwrite($fp,"$cmd\r\n");
		$reply = fgets($fp,$this->BUFFER);
		$reply = $this->strip_clf($reply);
		if($this->DEBUG) { @error_log("POP3 SEND [$cmd] GOT [$reply]",0); }
		fclose($fp);
		unset($this->FP);
		return true;
	}

	function popstat ()
	{
		//	Returns an array of 2 elements. The number of undeleted
		//	msgs in the mailbox, and the size of the mbox in octets.

		$PopArray = $this->last("array");

		if($PopArray == -1) { return false; }

		if( (!$PopArray) or (empty($PopArray)) )
		{
			return false;
		}
		return $PopArray;
	}

	function own_uidl($msgNum) {
		$top = $this->top($msgNum, 1);
		if ($top === false) {
			return false;
		}

		// Some POP-server add a Status header to the mail as soon as it got read
		// We remove this header for the uidl calculction, that the checksum
		// is not different when you read the mail for the very first time
		// (without this Status header)

		$top = preg_replace("/(Status: RO\r\n)/U", "", $top);
		/*echo nl2br($top);
		echo "<br>".md5($top)."<br>";*/
		return md5($top);
	}

	function uidl ($msgNum = 0, &$own_uidl)
	{
		//	Returns the UIDL of the msg specified. If called with
		//	no arguments, returns an associative array where each
		//	undeleted msg num is a key, and the msg's uidl is the element
		//	Array element 0 will contain the total number of msgs

		if(!isset($this->FP))
		{
			$this->ERROR = "POP3 uidl: No connection to server";
			return false;
		}

		$fp = $this->FP;
		$buffer = $this->BUFFER;

		if($msgNum != 0)
		{
			$cmd = "UIDL $msgNum";
			$reply = $this->send_cmd($cmd);
			if(!$this->is_ok($reply))
			{
				if ($myUidl = $this->own_uidl($msgNum) === false) {
					$this->ERROR = "POP3 uidl: Error [$reply]";
					return false;
				}
				$own_uidl = true;
				return $myUidl;
			}
			list ($_SESSION['ok'],$num,$myUidl) = explode(" ",$reply);
			return $myUidl;
		}
		else
		{
			$this->update_timer();

			$UIDLArray = array();
			$Total = $this->COUNT;
			$UIDLArray[0] = $Total;

			if ($Total < 1)
			{
				return $UIDLArray;
			}

			$cmd = "UIDL";
			fwrite($fp, "UIDL\r\n");
			$reply = fgets($fp, $buffer);
			$reply = $this->strip_clf($reply);
			if($this->DEBUG) { @error_log("POP3 SEND [$cmd] GOT [$reply]",0); }
			if(!$this->is_ok($reply))
			{
				// Try to calculate our own uidls
				$get = $this->pop_list();

				if ($get === false) {
					$this->ERROR = "POP3 uidl: Error [$reply]";
					return false;
				}

				// The first entry contains the no. of mails. Remove it
				array_shift($get);

				foreach($get as $get_now => $size) {
					$num = $get_now + 1;
					$uidl = $this->own_uidl($num);

					if ($uidl === false) {
						$this->ERROR = "POP3 uidl: Error [$reply]";
						return false;
					}
					$UIDLArray[$num] = $uidl;
				}

				$own_uidl = true;

				return $UIDLArray;
			}

			$line = "";
			$count = 1;
			$line = fgets($fp,$buffer);
			while ( !ereg("^\.\r\n",$line))
			{
				if(ereg("^\.\r\n",$line))
				{
					break;
				}
				list ($msg,$msgUidl) = explode(" ",$line);
				$msgUidl = $this->strip_clf($msgUidl);
				if($count == $msg)
				{
					$UIDLArray[$msg] = $msgUidl;
				}
				else
				{
					$UIDLArray[$count] = "deleted";
				}
				$count++;
				$line = fgets($fp,$buffer);
			}
		}
		return $UIDLArray;
	}

	function delete ($msgNum = "")
	{
		//	Flags a specified msg as deleted. The msg will not
		//	be deleted until a quit() method is called.

		if(!isset($this->FP))
		{
			$this->ERROR = "POP3 delete: No connection to server";
			return false;
		}
		if(empty($msgNum))
		{
			$this->ERROR = "POP3 delete: No msg number submitted";
			return false;
		}
		$reply = $this->send_cmd("DELE $msgNum");
		if(!$this->is_ok($reply))
		{
			$this->ERROR = "POP3 delete: Command failed [$reply]";
			return false;
		}
		return true;
	}

	//	*********************************************************

	//	The following methods are internal to the class.

	function is_ok ($cmd = "")
	{
		//	Return true or false on +OK or -ERR

		if(empty($cmd))					{ return false; }
		if ( ereg ("^\+OK", $cmd ) )	{ return true; }
		return false;
	}

	function strip_clf ($text = "")
	{
		// Strips \r\n from server responses

		if(empty($text)) { return $text; }
		$stripped = ereg_replace("\r","",$text);
		$stripped = ereg_replace("\n","",$stripped);
		return $stripped;
	}

	function parse_banner ( $server_text )
	{
		$outside = true;
		$banner = "";
		$length = strlen($server_text);
		for($count =0; $count < $length; $count++)
		{
			$digit = substr($server_text,$count,1);
			if(($digit == "0") || !empty($digit))
			{
				if( ($outside != true) and ($digit != '<') and ($digit != '>') )
				{
					$banner .= $digit;
				}
				if ($digit == '<')
				{
					$outside = false;
				}
				if($digit == '>')
				{
					$outside = true;
				}
			}
		}
		$banner = $this->strip_clf($banner);	// Just in case
		return "<$banner>";
	}

}	// End class
?>
