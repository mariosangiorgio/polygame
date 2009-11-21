<?php
session_start();
?><head>
<style type="text/css" media="all">
	@import "css/info.css";
	@import "css/main.css";
	@import "css/widgEditor.css";
</style>
<script type="text/javascript" src="scripts/widgEditor.js"></script>
<link href="Design.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /><style type="text/css">
<!--
body {
	margin-left: 10px;
	margin-top: 10px;
	margin-right: 10px;
	margin-bottom: 10px;
}
a:hover {
	color: #CCCCCC;
	text-decoration: none;
}
a:link {
	text-decoration: none;
}
a:visited {
	text-decoration: none;
}
a:active {
	text-decoration: none;
}
-->
</style></head>
<?php

if( $_SESSION['loggedIn'] == "yes" and
	$_SESSION['role'] == "administrator"){
?>

<FORM METHOD="POST" ACTION="./businessLogic/insertNewWedge.php">
  
  
  <div align="center">
    <TABLE>
      <TR>
        <TD class="Design">Wedge title</TD>
        <TD class="Design">
          <span class="Design">
          <TEXTAREA name="title" rows="1" cols="80"></TEXTAREA>
          </span></TD>
      </TR>
      <TR>
        <TD class="Design">Introduction</TD>
        <TD class="Design">
          <span class="Design">
          <TEXTAREA class="widgEditor" name="introduction" rows="20" cols="80"></TEXTAREA>
          </span></TD>
      </TR>
      <TR>
        <TD class="Design">History</TD>
        <TD class="Design">
          <span class="Design">
          <TEXTAREA class="widgEditor" name="history" rows="20" cols="80"></TEXTAREA>
          </span></TD>
      </TR>
      <TR>
        <TD class="Design">Present use</TD>
        <TD class="Design">
          <span class="Design">
          <TEXTAREA class="widgEditor" name="presentUse" rows="20" cols="80"></TEXTAREA>
          </span></TD>
      </TR>
      <TR>
        <TD class="Design">National situation</TD>
        <TD class="Design">
          <span class="Design">
          <TEXTAREA class="widgEditor" name="nationalSituation" rows="20" cols="80"></TEXTAREA>
          </span></TD>
      </TR>
      <TR>
        <TD class="Design">Emission reduction</TD>
        <TD class="Design">
          <span class="Design">
          <TEXTAREA class="widgEditor" name="emissionReduction"></TEXTAREA>
          </span></TD>
      </TR
><TR>
        <TD class="Design">References</TD>
        <TD class="Design">
          <span class="Design">
          <TEXTAREA class="widgEditor" name="references" rows="20" cols="80"></TEXTAREA>
          </span></TD>
          </TR>
      <TR>
        <TD class="Design">Solution</TD>
        <TD class="Design">          <span class="Design">
          <INPUT type="text" name="solution" onkeyup="this.value = this.value.replace (/\D/, '');">        
        </span></TD>
      </TR>
      <TR>
        <TD class="Design">Tolerance</TD>
        <TD class="Design">          <span class="Design">
          <INPUT type="text" name="tolerance" onkeyup="this.value = this.value.replace (/\D/, '');">        
        </span></TD>
      </TR>
                      </TABLE>
      
    <p class="Design">&nbsp;</p>
    <p class="Design">&nbsp;</p>
    <p class="Design">
      <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="461" height="144">
        <param name="movie" value="Flash/dots.swf" />
        <param name="quality" value="high" />
        <embed src="Flash/dots.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="461" height="144"></embed>
      </object>
    </p>
    <p class="Design">&nbsp;</p>
    <p class="Design">
      <INPUT TYPE="submit" VALUE="Insert">
    </p>
  </div>
</FORM>


  
<div align="center">
  <span class="Design">
  <?php
}
else {
	print "You must log in as an administrator to access this page!";
}
?>
  </span></div>
<div align="center" class="Design"></div>
