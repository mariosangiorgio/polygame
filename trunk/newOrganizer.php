<?php
session_start();

if( $_SESSION['loggedIn'] == "yes" and
	$_SESSION['role'] == "administrator"){
?>
<FORM METHOD="POST" ACTION="./insertNewOrganizer.php">
<TABLE>
<TR><TD>Name</TD><TD>Password</TD></TR>
<TR>
<TD><INPUT TYPE="text" NAME="username"></TD>
<TD><INPUT TYPE="password" NAME="password"></TD>
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