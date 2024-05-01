<?php

/*========================================================================
A POP3 web mail-client written in PHP
Copyright (C) 2000 by Jean-Pierre Bergamin

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License.

For more information see the file gpl.txt or go to
http://www.gnu.org/copyleft/gpl.html

==========================================================================*/

session_name('webbase');
session_start();
$webbase_username = $_SESSION['wb_user_username'];
$webbase_userid = '';
session_write_close();

	function dbg($string) {
		//echo("DEBUG_OUT: $string<br>");
	}

	register_shutdown_function('sd');
	function sd()
	{
		session_write_close();
	}
	session_name('popper');

	// Check for PHP4
	if (substr(phpversion(), 0, 1) == "3") {
		die("<h1>PHP3 is not supported!</h1>Install PHP4: http://www.php.net");
	}

	define("MAIL_UNREAD", 0);
	define("MAIL_READ", 1);
	define("MAIL_REPLIED", 2);
	define("MAIL_FORWARDED", 3);

	define("HIGHEST_PRIORITY", 1);
	define("HIGH_PRIORITY", 2);
	define("NORMAL_PRIORITY", 3);
	define("LOW_PRIORITY", 4);
	define("LOWEST_PRIORITY", 5);

	define("FULL_VIEW", 0);
	define("MID_VIEW", 1);
	define("MIN_VIEW", 2);

	define("POPUP_VIEW", 0);
	define("IN_VIEW", 1);
	define("SEP_VIEW", 2);
	define("FRAME_VIEW", 3);

	$action    = $_REQUEST['action'];
	$popper    =& $_SESSION['popper'];
	$logged_in = $_SESSION['logged_in'];
	$login     = $_REQUEST['login'];

	function is_logged_in() {
		global $logged_in;
		return (isset($logged_in) && session_is_registered("logged_in") && $logged_in == 1);
	}

	global $strings, $locale;

	@set_time_limit(60);

	include("class.popper.inc.php");

	session_start();

	if (isset($_SESSION['userid'])) $user_id = $_SESSION['userid'];

		if (!ini_get('register_globals'))
		{
		  $types_to_register = array('GET','POST','COOKIE','SESSION','SERVER');
		  foreach ($types_to_register as $type)
		  {
		    if (@count(${'HTTP_' . $type . '_VARS'}) > 0)
		      extract(${'HTTP_' . $type . '_VARS'}, EXTR_OVERWRITE);
		  }
}

	if ($poppercookie["language"]) {
		$lang_file = "lang/lang.".$poppercookie["language"].".inc.php";
	}
	else {
		if (isset($popper->config["language"]) && !empty($popper->config["language"])) {
			$lang_file = "lang/lang.".$popper->config["language"].".inc.php";
		}
		else {
			$lang_file = "lang/lang.english.inc.php";
		}
	}

	if (!file_exists($lang_file)) {
		$lang_file = "lang/lang.english.inc.php";
	}

	include($lang_file);
	setlocale(LC_ALL, $locale);


	if (!isset($popper) || !is_object($popper)) {
		$popper = new popper;
	}

	if (isset($action) && $action == "lostpwd") {
		$popper->show_in_window("lostpwd");
		exit;
	}

	if (!isset($popper->db_tool)) {
		$popper->db_tool = new db_tool("popper.inc.php");
	}

	if (isset($user_id) && !is_logged_in()) {
		$logged_in = 1;
		$popper->set_user($user_id);

$_SESSION['popper'] = $popper;
$_SESSION['userid'] = $user_id;
$_SESSION['logged_in'] = $logged_in;

		Header("Location: $PHP_SELF");
	}
	else if (is_logged_in()) {
		// Remove previously created tmp-files
		$popper->unlink_tmp();

		if ($ok == "OK") {
			if ($popper->config["mailview"] == FRAME_VIEW) {
				$popper->show_frame_list();
			}
			else {
				$popper->show("main");
			}
			return;
		}

		if (isset($action)) {

			$popper->pre_frame();

			if ($action == "showfolder") {
				$popper->show($folder);
			}
			else if ($action == "list") {
				$popper->show_frame_list();
			}
			else if ($action == "mail_cont") {
				$popper->show_mail_frame();
			}
			else if ($action == "showmail") {
				$popper->show_popup_mail();
				//$popper->show_form("newmail", $strings["l_ShowMail"]);
			}
			else if ($action == "showsources") {
				$popper->show_sources();
			}
			else if ($action == "logoff") {
				session_destroy();
				echo '<script> document.location.href="../../../?seite=user_popper"; </script>';
				return;
			}
			else if ($action == "newmail") {
				$popper->show_in_window("newmail", $strings["l_NewMail"]);
			}
			else if ($action == "printmail") {
				$popper->show_popup_mail();
			}
			else if ($action == "reply") {
				$popper->show_in_window("newmail", $strings["l_ReplyMail"]);
			}
			else if ($action == "replytoall") {
				$popper->show_in_window("newmail", $strings["l_ReplyAllMail"]);
			}
			else if ($action == "forward") {
				$popper->show_in_window("newmail", $strings["l_ForwardMail"]);
			}
			else if ($action == "showmail") {
				$popper->show_popup_mail();
			}
			else if ($action == "openmail") {
				$popper->show_in_window("newmail", $strings["l_ShowMail"]);
			}
			else if ($action == "choosen") {
				$popper->show_in_window("newmail", $strings["l_Choosen"]);
			}
			else if ($action == "cancel") {
				if (isset($old_uri) && $popper->config["mailview"] != FRAME_VIEW) {
					Header("Location: $old_uri");
				}
				else {
					$popper->show_form("main");
				}
				return;
			}
			else if ($action == "storemail") {
				$msg = $popper->store_mail();
				if ($popper->config["mailview"] == FRAME_VIEW) {
					$popper->show_form("main");
				}
				else {
					Header("Location: $old_uri");
				}
				//$popper->show_form("main", $msg);
			}
			else if ($action == "checkrep") {
				$popper->check_repetitive();
			}
			else if ($action == "sendandreceive") {
				if (!isset($what)) {
					if ($popper->config["mailview"] == FRAME_VIEW) {
						$popper->show_small_window("sendreceive", $strings["l_SendReceive"]);
					}
					else {
						$popper->show_in_window("sendreceive", $strings["l_SendReceive"]);
					}
				}
				else {
					$popper->send_and_receive();
				}
			}
			else if ($action == "getattachment") {
				$popper->get_attachment();
			}
			else if ($action == "config") {
				if (isset($GLOBALS[conf_submit])) {
					$popper->store_config();

					$lang_file = "lang/lang.".$popper->config["language"].".inc.php";

					include($lang_file);

					setlocale(LC_ALL, $locale);

					$popper->show();
				}
				else if (isset($changepwd)) {
					$popper->show_in_window("changepwd", $strings["l_ChangePwd"]);
				}
				else {
					$popper->show_in_window("config", $strings["l_Config"]);
				}
			}
			else if ($action == "deletemail") {
				$popper->delete_mail();
			}
			else if ($action == "selected") {
				if (isset($GLOBALS["delete_x"]) || isset($GLOBALS["ack"])) {
					$popper->delete_mails();
				}
				else if (isset($GLOBALS["add_addr_x"])) {
					$popper->add_sel_addr();
					if ($popper->config["mailview"] == FRAME_VIEW) {
						$popper->show_frame_list();
					}
					else {
						$popper->show();
					}

				}
				else if (isset($GLOBALS["move"])) {
					//$popper->move_to();
					$popper->report_error("Not implemented yet", "Not implemented");
				}
			}
			else if ($action == "deleteall") {
				$popper->delete_all();
			}
			else if ($action == "notification") {
				$popper->send_notification();
				if ($popper->config["mailview"] == IN_VIEW) {
					Header("Location: ".$GLOBALS[PHP_SELF]."?action=showfolder&folder=".$popper->folder."&mail_id=".$popper->cur_message_id);
				}
				else if ($popper->config["mailview"] == FRAME_VIEW) {
					$popper->show_mail_frame();
				}
				else {
					Header("Location: ".$GLOBALS[PHP_SELF]."?action=showmail&mail_id=".$popper->cur_message_id);
				}


			}
			else {
				$popper->show();
			}
		}
		else {
			$popper->show();
		}
	}
	else {
		$popper->show_in_window("home", $strings["l_Welcome"]);
	}
	$cururi = getenv("REQUEST_URI");
	if ($uri != $cururi) {
		$old_uri = $uri;
	}
	$uri = $cururi;
 $_SESSION["old_uri"] = $old_uri;
$_SESSION["uri"] = $uri;
?>
