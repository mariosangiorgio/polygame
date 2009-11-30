<?php
session_start();

if( $_SESSION['loggedIn'] == "yes" and
        $_SESSION['role'] == "administrator"){
?>
<link href="Design.css" rel="stylesheet" type="text/css">
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
.style1 {font-size: 9pt}
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
    <p><br>
      <INPUT TYPE="submit" VALUE="Insert">
      <br />  
      <br />  
      <br />  
      <br />  
      <br />  
      <br />  
      <br />  
      <br />  
    </p>
    <p><br />  
      <br />  
      <br />  
      <br />
    </p>
  </div>
</FORM>

<div align="center">
  <p>
    <?php
}
else {
        print "You must log in as an administrator to access this page!";
}
?>
  </p>
  <p class="Design">&nbsp;</p>
  <p class="Design">&nbsp;</p>
  <p class="Design">&nbsp;</p>
  <p class="Design">&nbsp;</p>
  <p class="Design">&nbsp;</p>
</div>
  <div align="center" class="Design"></div>
