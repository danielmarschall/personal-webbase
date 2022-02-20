<?php

require 'includes/main.inc.php';

?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
   <title>ViaThinkSoft Personal WebBase</title>
   <link href="style.css.php" rel="stylesheet" type="text/css">
</head>

<body class="dark">

<?php

if ((isset($mitscrolling)) && ($mitscrolling == 'yes'))
{

?><script language="JavaScript" type="text/javascript">
<!--

var SCR_OBJ = [];
function GLOBAL_SCROLL( o, i )
{
	SCR_OBJ[o].scroll( i );
}

function scroll(objElement)
{
	this.obj = objElement;
	this.timerID = -1;
	SCR_OBJ[SCR_OBJ.length] = this; // SCR_OBJ.push(this);
	this.objID = SCR_OBJ.length -1;

	this.scroll = function( iOff ) {with(this){
		if( obj.scrollBy )
		{
			obj.scrollBy(0,iOff);
			return;
		}
		if( iOff < 0 )
		{
			var i = obj.scrollTop + iOff;

			if( i<0 ){
				obj.scrollTop = 0;
				stop();
			}
			else{
				obj.scrollTop = i;
			}
		}
		else
		{
			if( obj.scrollTop + iOff < obj.scrollHeight )
			{
				obj.scrollTop += iOff;
			}
			else
			{
				obj.scrollTop = obj.scrollHeight;
				stop();
			}
		}
	}};

	this.stop = function() {with(this){
		if (timerID!=-1)
		{
			window.clearInterval(timerID);
		}
	}};

	this.start = function( iOff ){ with(this){
		stop();
		timerID = window.setInterval( "GLOBAL_SCROLL("+objID+","+iOff+")", 25 );
	}};
}

var srollObject = null;
var objElement = parent.frames.Navigation;
srollObject = new scroll(objElement);

// -->
</script>

<table cellspacing="0" cellpadding="0" border="0" width="180">
<tr>
<td align="left" valign="top"><img src="design/spacer.gif" width="1" height="2" alt=""><br><a href="#" onmouseover="srollObject.start(-4);" onmouseout="srollObject.stop();"><img src="<?php echo $design_ordner; ?>rauf.gif" border="0" alt=""></a></td>
<td align="center" valign="top"><span style="font-size:0.85em">Men&uuml;scrollen</span></td>
<td align="right" valign="top"><img src="design/spacer.gif" width="1" height="2" alt=""><br><a href="#" onmouseover="srollObject.start(4);" onmouseout="srollObject.stop();"><img src="<?php echo $design_ordner; ?>runter.gif" border="0" alt=""></a></td>
</tr>
</table>

<?php

}

?>

</body>

</html>
