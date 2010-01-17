<?php
session_start();

if( $_SESSION['loggedIn'] == "yes"){
	print "Already logged in!<BR>";
	print "<A HREF=logout.php>Logout</A>";
	}
else{
?>
<link href="css/Design.css" rel="stylesheet" type="text/css" /><style type="text/css">
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
<link href="css/Mainstyle.css" rel="stylesheet" type="text/css" />
<H2 align="center" class="Design">&nbsp;</H2>
<H2 align="center" class="Design">&nbsp;</H2>
<H2 align="center" class="Design">&nbsp;</H2>
<H2 align="center" class="Design">
  
  <span class="Design">
  <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="461" height="144" title="Welcome Logo">
    <param name="movie" value="Flash/logostops.swf" />
    <param name="quality" value="high" />
    <embed src="Flash/logostops.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="461" height="144"></embed>
  </object>
  </span></H2>
<H3 align="center" class="Mainstyle">Welcome! Start here!</H3>
<FORM METHOD="POST" ACTION="./businessLogic/authentication.php">
  <div align="center">
  <TABLE>
    <TR><TD class="Design">Username</TD><TD class="Design">Password</TD></TR>
    <TR>
      <TD class="Design">        <span class="Design">
        <INPUT TYPE="text" NAME="username">        
        </span></TD>
    <TD class="Design">      <span class="Design">
      <INPUT TYPE="password" NAME="password">      
      </span></TD>
    </TR>
  </TABLE>
  
  <p class="Design">
    <INPUT TYPE="submit" VALUE="Login">
  </p>
  </div>
</FORM>
<div align="center" class="Design">
  <p>&nbsp;</p>
  <p>&nbsp;</p>
</div>

    <?php
}
?>
  </p>
  <p class="Design">&nbsp;</p>
  <p class="Design">&nbsp;</p>
  <p class="Design">&nbsp;</p>
</div>
<div align="center" class="Design"></div>
<div align="center">
  <p>&nbsp;</p>
</div>
