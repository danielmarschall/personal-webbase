<?php defined("NET2FTP") or die("Direct access to this location is not allowed."); ?>
<!-- Template /skins/drupal/statusbar.php begin -->
<script type="text/javascript" src="<?php echo $net2ftp_globals["application_rootdir_url"]; ?>/skins/<?php echo $net2ftp_globals["skin"]; ?>/status/status.js"></script>
<table border="0" cellspacing="0" cellpadding="0" id="header" style="width: 100%; margin-left: auto; margin-right: auto;">
	<tr style="height: 32px; vertical-align: middle;">
		<td style="font-size: 120%; font-weight: bold;"><?php echo $net2ftp_globals["ftpserver"]; ?></td>
		<td style="width:30px;">&nbsp;</td>
		<td>
<?php require_once($net2ftp_globals["application_skinsdir"] . "/" . $net2ftp_globals["skin"] . "/status/status.template.php"); ?>
		</td>
		<td style="text-align: <?php echo __("right"); ?>; width:180px;">
			<form id="StatusbarForm" method="post" action="<?php echo $net2ftp_globals["action_url"]; ?>">
			<?php printLoginInfo(); ?>
			<input type="hidden" name="state"     value="">
			<input type="hidden" name="state2"    value="">
			<input type="hidden" name="directory" value="<?php echo $net2ftp_globals["directory_html"]; ?>">
			<input type="hidden" name="url"    value="<?php echo printPHP_SELF("bookmark"); ?>">
			<input type="hidden" name="text"   value="net2ftp <?php echo $net2ftp_globals["ftpserver"]; ?>">
<?php			if ($net2ftp_globals["state"] != "bookmark") { printActionIcon("bookmark", "document.forms['StatusbarForm'].state.value='bookmark';document.forms['StatusbarForm'].submit();"); } ?>
			<?php printActionIcon("refresh",  "window.location.reload();"); ?>
			<?php printActionIcon("help",     "void(window.open('" . $net2ftp_globals["application_rootdir_url"] . "/help.html','Help','location,menubar,resizable,scrollbars,status,toolbar'));"); ?>
			<?php printActionIcon("logout",   "document.forms['StatusbarForm'].state.value='logout';document.forms['StatusbarForm'].submit();"); ?>
			</form>
		</td>
	</tr>
</table>
<!-- Template /skins/drupal/statusbar.php end -->
