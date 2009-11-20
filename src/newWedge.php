<?php
session_start();

if( $_SESSION['loggedIn'] == "yes" and
	$_SESSION['role'] == "administrator"){
?>
<FORM METHOD="POST" ACTION="./businessLogic/insertNewWedge.php">
<TABLE>
<TR><TD>Wedge title</TD><TD><INPUT TYPE="text" NAME="title"></TD></TR>
<TR><TD>Introduction</TD><TD><INPUT STYLE="width:200; height:800; background-color:yellow" TYPE="text" NAME="introduction"></TD></TR>
<TR><TD>History</TD><TD><INPUT  TYPE="text" NAME="history"></TD></TR>
<TR><TD>Present use</TD><TD><INPUT  TYPE="text" NAME="presentUse"></TD></TR>
<TR><TD>National situation</TD><TD><INPUT  TYPE="text" NAME="nationalSituation"></TD></TR>
<TR><TD>Emission reduction</TD><TD><INPUT  TYPE="text" NAME="emissionReduction"></TD></TR>
<TR><TD>Pro</TD><TD><INPUT  TYPE="text" NAME="pro"></TD></TR>
<TR><TD>Cons</TD><TD><INPUT  TYPE="text" NAME="cons"></TD></TR>
<TR><TD>References</TD><TD><INPUT  TYPE="text" NAME="references"></TD></TR>
</TABLE>

<INPUT TYPE="submit" VALUE="Insert">
</FORM>
<?php
}
else {
	print "You must log in as an administrator to access this page!";
}
?>