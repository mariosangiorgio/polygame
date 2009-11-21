<?php
session_start();

if( $_SESSION['loggedIn'] == "yes" and
        $_SESSION['role'] == "administrator"){
?>
<link href="Design.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style1 {font-size: 9pt}
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
}
body {
	margin-left: 10px;
	margin-top: 10px;
	margin-right: 10px;
	margin-bottom: 10px;
}
a:link {
	text-decoration: none;
}
a:visited {
	text-decoration: none;
}
a:hover {
	text-decoration: none;
	color: #CCCCCC;
}
a:active {
	text-decoration: none;
}
-->
</style>

<FORM METHOD="POST" ACTION="./businessLogic/insertNewOrganizer.php">
  <div align="center" class="Design">
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>
      <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="461" height="144">
        <param name="movie" value="Flash/logostops.swf" />
        <param name="quality" value="high" />
        <embed src="Flash/logostops.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="461" height="144"></embed>
      </object>
    </p>
    <TABLE>
    <TR><TD class="Design">Name</TD>
    <TD class="Design"><div align="left" class="Design">Password</div></TD>
    </TR>
    <TR>
      <TD class="Design"><INPUT TYPE="text" NAME="username"></TD>
    <TD class="Design"><INPUT TYPE="password" NAME="password"></TD>
    </TR>
  </TABLE>
    <br>
    <INPUT TYPE="submit" VALUE="Insert">
  </div>
</FORM>
<div align="left">
  <?php
}
else {
        print "You must log in as an administrator to access this page!";
}
?>
</div>
<div align="center" class="Design"></div>
