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

a:hover {
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
</style>
<link href="css/Design.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {
	font-family: "HelveticaNeue LT 107 XBlkCn";
	font-size: 16pt;
	color: #DD137B;
}
-->
</style>
</head>
<?php

if( $_SESSION['loggedIn'] == "yes" and
	$_SESSION['role'] == "administrator"){
?>

<FORM METHOD="POST" ACTION="./businessLogic/insertNewWedge.php">
  
  
                    <div align="center">
                      <TABLE>
                        <TR>
                          <TD class="Design"><div align="center" class="three style1">Wedge title</div></TD>
          <TD class="Design">
            <span class="Design">
            <TEXTAREA name="title" rows="1" cols="80"></TEXTAREA>
            </span></TD>
        </TR>
                        <TR>
                          <TD class="Design"><div align="center" class="style1">Introduction</div></TD>
          <TD class="Design">
            <span class="Design">
            <TEXTAREA class="widgEditor" name="introduction" rows="20" cols="80"></TEXTAREA>
            </span></TD>
        </TR>
                        <TR>
                          <TD class="Design"><div align="center" class="style1">History</div></TD>
          <TD class="Design">
            <span class="Design">
            <TEXTAREA class="widgEditor" name="history" rows="20" cols="80"></TEXTAREA>
            </span></TD>
        </TR>
                        <TR>
                          <TD class="Design"><div align="center" class="style1">Present use</div></TD>
          <TD class="Design">
            <span class="Design">
            <TEXTAREA class="widgEditor" name="presentUse" rows="20" cols="80"></TEXTAREA>
            </span></TD>
        </TR>
                        <TR>
                          <TD class="Design"><div align="center" class="style1">National<br />
                          situation</div></TD>
          <TD class="Design">
            <span class="Design">
            <TEXTAREA class="widgEditor" name="nationalSituation" rows="20" cols="80"></TEXTAREA>
            </span></TD>
        </TR>
                        <TR>
                          <TD class="Design"><div align="center" class="style1">Emission<br />
                          reduction</div></TD>
          <TD class="Design">
            <span class="Design">
            <TEXTAREA class="widgEditor" name="emissionReduction"></TEXTAREA>
            </span></TD>
        </TR
><TR>
          <TD class="Design"><div align="center" class="style1">References</div></TD>
          <TD class="Design">
            <span class="Design">
            <TEXTAREA class="widgEditor" name="references" rows="20" cols="80"></TEXTAREA>
            </span></TD>
            </TR>
                        <TR>
                          <TD class="Design"><div align="center" class="style1">Solution</div></TD>
          <TD class="Design">            <span class="Design">
          <INPUT type="text" name="solution" onkeyup="this.value = this.value.replace (/\D/, '');">          
          </span></TD>
        </TR>
                        <TR>
                          <TD class="Design"><div align="center" class="style1">Tolerance</div></TD>
          <TD class="Design">            <span class="Design">
          <INPUT type="text" name="tolerance" onkeyup="this.value = this.value.replace (/\D/, '');">          
          </span></TD>
        </TR>
                          </TABLE>
  </div>
  <p align="center" class="Design">
    <span class="Design">
    <INPUT TYPE="submit" VALUE="Insert">
    <!-- <input type="button" value="Cancel" onClick="location.href='admin.php'"> -->
  </span></p>
</FORM>

<div align="center" class="Design"><BR>
    <A HREF=manageWedges.php class="three style1">Back to wedge page</A><BR>
</div>


<div align="center">
  <p class="Design">
    <?php
}
else {
	print "You must log in as an administrator to access this page!";
}
?>
    <br />
  </p>
  <p class="Design">&nbsp;</p>
  <p class="Design">&nbsp;</p>
  <p class="Design">&nbsp;</p>
  <p class="Design">&nbsp;</p>
  <p class="Design">&nbsp;</p>
</div>
<div align="center" class="Design"></div>
