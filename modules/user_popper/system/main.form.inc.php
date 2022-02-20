<tr class="window">
<?php
	if ($this->config["view"] == MIN_VIEW) {
		$width = "1%";
		$style = "style=\"background-color: gray;\"";
	}
	else {
		$width = "25%";
	}

	echo("<td width=\"$width\" valign=\"top\" $style>");

		$this->show_folders();
		// Show the addresslist only in FULL_VIEW
		if ($this->config["view"] == FULL_VIEW) {
?>

<?php
		}
?>
	</td>
	<td width="75%">
<?php

include("mail.form.inc.php");

?>
	</td>
</tr>