<?php
session_start();

if( $_SESSION['loggedIn'] == "yes"){
	print "Already logged in!<BR>";
	print "<A HREF=logout.php>Logout</A>";
	}
else{
?>
<link href="Design.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	margin-left: 10px;
	margin-top: 10px;
	margin-right: 10px;
	margin-bottom: 10px;
}
-->
</style>

<H2 align="center" class="Design"> Welcome!</H2>
<H2 align="center" class="Design">
  <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="461" height="144" title="Welcome Logo">
    <param name="movie" value="Flash/logostops.swf" />
    <param name="quality" value="high" />
    <embed src="Flash/logostops.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="461" height="144"></embed>
  </object>
</H2>
<H3 align="center" class="Design">Start here!</H3>
<FORM METHOD="POST" ACTION="./businessLogic/authentication.php">
  <div align="center">
  <TABLE>
    <TR><TD class="Design">Username</TD><TD class="Design">Password</TD></TR>
    <TR>
      <TD class="Design">
        <INPUT TYPE="text" NAME="username">
      </TD>
    <TD class="Design">
      <INPUT TYPE="password" NAME="password">
    </TD>
    </TR>
  </TABLE>
  <span class="Design">
  <INPUT TYPE="submit" VALUE="Login">
  </span></div>
</FORM>
<div align="center" class="Design"><BR>
</div>
<H3 align="center" class="Design">Wondering what PolyGame is?</H3>
<div align="center" class="Design">PolyGame is a...<BR>
  <BR>
</div>
<H3 align="center" class="Design">Wondering who made it?</H3>
<div align="center" class="Design">PolyGame was conceived by Prof... and it has been developed by Three students from Alta Scuola Politecnica.<BR>



  <?php
}
?>
</div>
