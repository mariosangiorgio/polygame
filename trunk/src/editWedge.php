<?php
session_start();
?>
<head>
<style type="text/css" media="all">
	@import "css/info.css";
	@import "css/main.css";
	@import "css/widgEditor.css";
</style>
<script type="text/javascript" src="scripts/widgEditor.js"></script>
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
<TABLE>
<TR>
<TD>Wedge title</TD>
<TD><TEXTAREA name="title" rows="1" cols="80"><?php print $row['Title']; ?></TEXTAREA></TD>
</TR>
<TR>
<TD>Introduction</TD>
<TD><TEXTAREA class="widgEditor" name="introduction" rows="20" cols="80"><?php print $row['Introduction']; ?></TEXTAREA></TD>
</TR>
<TR>
<TD>History</TD>
<TD><TEXTAREA class="widgEditor" name="history" rows="20" cols="80"><?php print $row['History']; ?></TEXTAREA></TD>
</TR>
<TR>
<TD>Present use</TD>
<TD><TEXTAREA class="widgEditor" name="presentUse" rows="20" cols="80"><?php print $row['Present use']; ?></TEXTAREA></TD>
</TR>
<TR>
<TD>National situation</TD>
<TD><TEXTAREA class="widgEditor" name="nationalSituation" rows="20" cols="80"><?php print $row['National situation']; ?></TEXTAREA></TD>
</TR>
<TR>
<TD>Emission reduction</TD>
<TD><TEXTAREA class="widgEditor" name="emissionReduction"><?php print $row['Emission reduction']; ?></TEXTAREA></TD>
</TR
<TR>
<TD>References</TD>
<TD><TEXTAREA class="widgEditor" name="references" rows="20" cols="80"><?php print $row['References']; ?></TEXTAREA></TD>
</TR>
<TR>
<TD>Solution</TD>
<TD><INPUT type="text" name="solution" onkeyup="this.value = this.value.replace (/\D/, '');" value="<?php print $row['Solution']; ?>"></TD>
</TR>
<TR>
<TD>Tolerance</TD>
<TD><INPUT type="text" name="tolerance" onkeyup="this.value = this.value.replace (/\D/, '');" value="<?php print $row['Error Tolerance']; ?>"></TD>
</TR>
</TABLE>
<INPUT type="hidden" name="id" value="<?php print $row['Wedge ID']; ?>">
<INPUT TYPE="submit" VALUE="Insert">
</FORM>
<?php
}	
else {
	print "You must log in as an administrator to access this page!";
}
?>