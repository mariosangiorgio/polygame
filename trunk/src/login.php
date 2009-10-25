<?php
session_start();

if( $_SESSION['loggedIn'] == "yes"){
	print "Already logged in!<BR>";
	print "<A HREF=logout.php>Logout</A>";
	}
else{
?>

<FORM METHOD="POST" ACTION="./businessLogic/authentication.php">
<TABLE>
<TR><TD>Username</TD><TD>Password</TD></TR>
<TR>
<TD><INPUT TYPE="text" NAME="username"></TD>
<TD><INPUT TYPE="password" NAME="password"></TD>
</TR>
</TABLE>

<INPUT TYPE="submit" VALUE="Login">
</FORM>

<?php
}
?>