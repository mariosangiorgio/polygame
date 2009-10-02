<?php
session_start();

if( $_SESSION['loggedIn'] == "yes" and
	$_SESSION['role'] == "organizer"){
?>
<FORM METHOD="POST" ACTION="./insertNewGame.php">
<TABLE>
<TR><TD>Delay (minutes) before complete information </TD><TD><INPUT TYPE="text" NAME="length1a" VALUE="20"></TD></TR>
<TR><TD>Delay (minutes) before submit solution </TD><TD><INPUT TYPE="text" NAME="length1b" VALUE="20"></TD></TR>
<TR><TD>Delay (minutes) before poster </TD><TD><INPUT TYPE="text" NAME="length1c" VALUE="60"></TD></TR>
<TR><TD>Length (minutes) final phase </TD><TD><INPUT TYPE="text" NAME="length2" VALUE="120"></TD></TR>
</TABLE>

<INPUT TYPE="submit" VALUE="Insert">
</FORM><BR>
<A HREF=organize.php>Cancel</A><BR>

<?php
}
else {
	print "You must log in as an organizer to access this page!<BR>";
	print "<A HREF=login.php>Login</A><BR>";
}
?>