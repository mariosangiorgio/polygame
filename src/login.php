<?php
session_start();

if( $_SESSION['loggedIn'] == "yes"){
	print "Already logged in!<BR>";
	print "<A HREF=logout.php>Logout</A>";
	}
else{
?>

<H2>PolyGame... Welcome!</H2>
<H3>Start here!</H3>
<FORM METHOD="POST" ACTION="./businessLogic/authentication.php">
<TABLE>
<TR><TD>Username</TD><TD>Password</TD></TR>
<TR>
<TD><INPUT TYPE="text" NAME="username"></TD>
<TD><INPUT TYPE="password" NAME="password"></TD>
</TR>
</TABLE>

<INPUT TYPE="submit" VALUE="Login">
</FORM><BR>

<H3>Wondering what PolyGame is?</H3>
PolyGame is a...<BR><BR>

<H3>Wondering who made it?</H3>
PolyGame was conceived by Prof... and it has been developed by two students from Alta Scuola Politecnica.<BR>



<?php
}
?>