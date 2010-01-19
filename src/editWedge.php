<?php
session_start();
?><head>
<style type="text/css" media="all">
	@import "css/info.css";
	@import "css/main.css";
	@import "css/widgEditor.css";
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
</style>
<script type="text/javascript" src="scripts/widgEditor.js"></script>
<link href="Design.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /><style type="text/css">
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
	color: #DD137B;
	font-family: "HelveticaNeue LT 107 XBlkCn";
	font-size: 16pt;
}
-->
</style>
</head>
<?php

require("./businessLogic/databaseLogin.php");

if( $_SESSION['loggedIn'] == "yes" and
	$_SESSION['role'] == "administrator"){
	
	$wedge	= mysql_real_escape_string($_GET['wedge']);
	$query	= "SELECT * FROM `Wedges` WHERE `Title` = '".$wedge."';";
	$data	= mysql_query($query,$connection);
	$row	= mysql_fetch_array($data);
	
	?>
	
<FORM METHOD="POST" ACTION="./businessLogic/updateWedge.php">
  <div align="center" class="Design">
    <div align="center" class="Design">
      <TABLE>
        <TR>
          <TD><div align="center" class="style1">Wedge title</div></TD>
      <TD><TEXTAREA name="title" rows="1" cols="80"><?php print $row['Title']; ?></TEXTAREA></TD>
      </TR>
        <TR>
          <TD><div align="center" class="style1">Introduction</div></TD>
      <TD><TEXTAREA class="widgEditor" name="introduction" rows="20" cols="80"><?php print $row['Introduction']; ?></TEXTAREA></TD>
      </TR>
        <TR>
          <TD><div align="center" class="style1">History</div></TD>
      <TD><TEXTAREA class="widgEditor" name="history" rows="20" cols="80"><?php print $row['History']; ?></TEXTAREA></TD>
      </TR>
        <TR>
          <TD><div align="center" class="style1">Present use</div></TD>
      <TD><TEXTAREA class="widgEditor" name="presentUse" rows="20" cols="80"><?php print $row['Present use']; ?></TEXTAREA></TD>
      </TR>
        <TR>
          <TD><div align="center" class="style1">
            <p>National<br />
              situation</p>
            </div></TD>
      <TD><TEXTAREA class="widgEditor" name="nationalSituation" rows="20" cols="80"><?php print $row['National situation']; ?></TEXTAREA></TD>
      </TR>
        <TR>
          <TD><div align="center" class="style1">
            <p>Emission<br />
              reduction</p>
            </div></TD>
      <TD><TEXTAREA class="widgEditor" name="emissionReduction"><?php print $row['Emission reduction']; ?></TEXTAREA></TD>
      </TR
><TR>
        <TD><div align="center" class="style1">References</div></TD>
      <TD><TEXTAREA class="widgEditor" name="references" rows="20" cols="80"><?php print $row['References']; ?></TEXTAREA></TD>
      </TR>
        <TR>
          <TD><div align="center" class="style1">Solution</div></TD>
      <TD><INPUT type="text" name="solution" onkeyup="this.value = this.value.replace (/\D/, '');" value="<?php print $row['Solution']; ?>"></TD>
      </TR>
        <TR>
          <TD><div align="center" class="style1">Tolerance (%)</div></TD>
      <TD><INPUT type="text" name="tolerance" onkeyup="this.value = this.value.replace (/\D/, '');" value="<?php print $row['Error Tolerance']; ?>"></TD>
      </TR>
      </TABLE>
      <INPUT type="hidden" name="id" value="<?php print $row['Wedge ID']; ?>">
      <p>
        <INPUT TYPE="submit" VALUE="Update this wedge">
        <input type="button" value="Delete this wedge"
        	   onClick="location.href='./businessLogic/deleteWedge.php?wedgeID=<?php print $row['Wedge ID']; ?>'">
        <!-- <input type="button" value="Cancel" onClick="location.href='showWedges.php'"> -->
      </p>
    </div>
  </div>
</FORM>

<div align="center" class="Design"><BR><BR>
    <A HREF=manageWedges.php class="three style1">Back to wedge page (no changes applied)</A><BR>
</div>

<div align="center">
  <?php
}	
else {
	print "You must log in as an administrator to access this page!";
}
?>
</div>
