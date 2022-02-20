<?php

/*========================================================================
A POP3 web mail-client written in PHP
Copyright (C) 2000 by Jean-Pierre Bergamin

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License.

For more information see the file gpl.txt or go to
http://www.gnu.org/copyleft/gpl.html

==========================================================================*/

?>
<center>
<h2><?php echo($strings["l_SendReceive"]);?></h2>

<form method="post" action="<?php echo("$GLOBALS[REQUEST_URI]");?>">
	<h4><?php echo($strings["l_Action"]);?></h4>
	<p>
	<select name="what" class="button">
		<option value="getall"><?php echo($strings["l_GetAll"]);?></option>
		<option value="sendonly"><?php echo($strings["l_SendOnly"]);?></option>
		<option value="sendandreceive"><?php echo($strings["l_SendRecvAll"]);?></option>
	</select>
	</p>
	<p><input class="button" type="submit" value="<?php echo($strings["l_Go"]);?>"></p>
</form>
</center>