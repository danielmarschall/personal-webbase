<?php defined("NET2FTP") or die("Direct access to this location is not allowed."); ?>
<!-- Template /skins/blue/manage.template.php begin -->
			<div class="header21">
<?php			printTitleIcon(); ?>
			<?php echo $title; ?>
			</div>
			<form id="<?php echo $formname; ?>" action="<?php echo $net2ftp_globals["action_url"]; ?>" <?php if (isset($enctype)) { echo $enctype; } ?> method="post">
<?php			printLoginInfo(); ?>
			<input type="hidden" name="state"     value="<?php echo $net2ftp_globals["state"]; ?>" />
			<input type="hidden" name="state2"    value="<?php echo $net2ftp_globals["state2"]; ?>" />
<?php			if ($net2ftp_globals["state"] != "upload") { ?>
			<input type="hidden" name="directory" value="<?php echo $net2ftp_globals["directory_html"]; ?>" />
<?php			} ?>
			<input type="hidden" name="screen"    value="<?php echo $nextscreen; ?>" />

<?php /* ----- Back icon ----- */ ?>
<?php			printActionIcon("back", $back_onclick, ""); ?> &nbsp; 

<?php /* ----- Submit icon - only for transactions which have a 2nd screen ----- */ ?>
<?php			if ($net2ftp_globals["screen"] == 1
			&& ($net2ftp_globals["state"] == "admin_createtables" || $net2ftp_globals["state"] == "advanced_ftpserver" || 
                      $net2ftp_globals["state"] == "chmod"      || $net2ftp_globals["state"] == "copymovedelete" || 
                      $net2ftp_globals["state"] == "findstring" || $net2ftp_globals["state"] == "newdir" || 
                      $net2ftp_globals["state"] == "raw"        || $net2ftp_globals["state"] == "rename" || 
                      $net2ftp_globals["state"] == "unzip"      || $net2ftp_globals["state"] == "zip") 
					|| $net2ftp_globals["state"] == "upload") {
				printActionIcon("forward", $forward_onclick, ""); 
			} ?>

			<br /><br />
<?php	require_once($net2ftp_globals["application_skinsdir"] . "/" . $net2ftp_globals["skin"] . "/" . $net2ftp_globals["state"] . $net2ftp_globals["screen"] . ".template.php"); ?>
			</form>
                      </td>
                    </tr>
<?php require_once($net2ftp_globals["application_skinsdir"] . "/" . $net2ftp_globals["skin"] . "/footer.template.php"); ?>
<!-- Template /skins/blue/manage.template.php end -->
