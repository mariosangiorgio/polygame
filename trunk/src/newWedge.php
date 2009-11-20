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

if( $_SESSION['loggedIn'] == "yes" and
	$_SESSION['role'] == "administrator"){
?>
<FORM METHOD="POST" ACTION="./businessLogic/insertNewWedge.php">
<TABLE>
<TR>
<TD>Wedge title</TD>
<TD><TEXTAREA name="title" rows="1" cols="80"></TEXTAREA></TD>
</TR>
<TR>
<TD>Introduction</TD>
<TD><TEXTAREA class="widgEditor" name="introduction" rows="20" cols="80"></TEXTAREA></TD>
</TR>
<TR>
<TD>History</TD>
<TD><TEXTAREA class="widgEditor" name="history" rows="20" cols="80"></TEXTAREA></TD>
</TR>
<TR>
<TD>Present use</TD>
<TD><TEXTAREA class="widgEditor" name="presentUse" rows="20" cols="80"></TEXTAREA></TD>
</TR>
<TR>
<TD>National situation</TD>
<TD><TEXTAREA class="widgEditor" name="nationalSituation" rows="20" cols="80"></TEXTAREA></TD>
</TR>
<TR>
<TD>Emission reduction</TD>
<TD><TEXTAREA class="widgEditor" name="emissionReduction"></TEXTAREA></TD>
</TR
<TR>
<TD>References</TD>
<TD><TEXTAREA class="widgEditor" name="references" rows="20" cols="80"></TEXTAREA></TD>
</TR>
<TR>
<TD>Solution</TD>
<TD><INPUT type="text" name="solution" onkeyup="this.value = this.value.replace (/\D/, '');"></TD>
</TR>
<TR>
<TD>Tolerance</TD>
<TD><INPUT type="text" name="tolerance" onkeyup="this.value = this.value.replace (/\D/, '');"></TD>
</TR>
</TABLE>

<INPUT TYPE="submit" VALUE="Insert">
</FORM>
<?php
}
else {
	print "You must log in as an administrator to access this page!";
}
?>