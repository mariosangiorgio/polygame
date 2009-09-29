<?php
session_start();

if( $_SESSION['loggedIn'] == "yes" and
	$_SESSION['role'] == "organizer"){
?>

Please enter username and password for the new player: <BR>

<FORM METHOD="POST" ACTION="./insertNewPlayer.php">
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
	print "You must log in as an organizer to access this page!";
}
?>