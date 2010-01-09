<?php
session_start();

if( $_SESSION['loggedIn'] == "yes" and
	$_SESSION['role'] == "organizer"){
?>


<script type="text/javascript">

<!--
    function alpha(e) {
        var k;
        document.all ? k = e.keyCode : k = e.which;
return ( (k > 47 && k < 58) || k==8 || k==9 || (k > 36 && k < 41) || k==17);
}
// -->
</script>


<FORM METHOD="POST" ACTION="./businessLogic/insertNewGame.php" id="new" action="javascript://">
<link href="Design.css" rel="stylesheet" type="text/css" />
<style type="text/css">
p
{
	background-image: url(images/background.png);
	background-position: right bottom;
	background-repeat: repeat;
	background-attachment: fixed;
}
a.three:link {color: #DD137B}
a.three:visited {color: #DD137B}
a.three:hover {background: #DD137B}
<!--
a:link {
	text-decoration: none;
}
a:visited {
	text-decoration: none;
}
a:hover {
	text-decoration: none;
}
a:active {
	text-decoration: none;
}
-->
</style>
<link href="css/Design.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {
	font-family: "HelveticaNeue LT 107 XBlkCn";
	font-size: 16pt;
}
.style6 {color: #DD137B; font-weight: bold; font-family: "HelveticaNeue LT 107 XBlkCn"; font-size: 16pt; }
-->
</style>
<div align="center" class="Design">
  <p>&nbsp;  </p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>
    <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="431" height="144">
      <param name="movie" value="Flash/logostops.swf" />
      <param name="quality" value="high" />
      <embed src="Flash/logostops.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="431" height="144"></embed>
    </object>
  </p>
  <p>&nbsp;</p>
  <TABLE>
    <TR><TD><span class="style6">First phase</span></TD>
    </TR>
    <TR><TD>Delay (minutes) before complete information </TD><TD><INPUT TYPE="text" NAME="length1a" VALUE="20" onkeypress="return alpha(event)"></TD></TR>
    <TR><TD>Delay (minutes) before submit solution </TD><TD><INPUT TYPE="text" NAME="length1b" VALUE="20" onkeypress="return alpha(event)"></TD></TR>
    <TR><TD>Delay (minutes) before poster </TD><TD><INPUT TYPE="text" NAME="length1c" VALUE="60" onkeypress="return alpha(event)"></TD></TR>
    <TR><TD><span class="style6">Second phase</span></TD>
    </TR>
    <TR><TD>Length (minutes) of second phase </TD><TD><INPUT TYPE="text" NAME="length2" VALUE="120" onkeypress="return alpha(event)"></TD></TR>
    <TR><TD><span class="style6">Other values</span></TD>
    </TR>
    <TR><TD>Time (minutes) given for one poster presentation</TD><TD><INPUT TYPE="text" NAME="presentation" VALUE="3" onkeypress="return alpha(event)"></TD></TR>
  </TABLE>
  <p>
    <INPUT TYPE="submit" VALUE="Insert">
    <br />
    </FORM>
    <BR>
    <A HREF=organize.php class="three style1">Cancel</A><BR>
    
    <?php
}
else {
	?>
	You must log in as an organizer to access this page!<BR>
	"<A HREF=login.php class="three style1">Login</A><BR>
	<?php
}
?>
</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;  </p>
</div>
<div align="center" class="Design"></div>
