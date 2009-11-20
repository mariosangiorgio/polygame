<?php
session_start();

if( $_SESSION['loggedIn'] == "yes" and
	$_SESSION['role'] == "organizer"){
?>


<script type="text/javascript">
<!--
    function alpha(e) {
        var k;
        document.all ? k = e.keyCode : k = e.which;
return ( (k > 47 && k < 58) || k==8 || k==9 || (k > 36 && k < 41) || k==17);
}
// -->
</script>


<FORM METHOD="POST" ACTION="./businessLogic/insertNewGame.php" id="new" action="javascript://">
<TABLE>
<TR><TD><b>First phase</b></TD></TR>
<TR><TD>Delay (minutes) before complete information </TD><TD><INPUT TYPE="text" NAME="length1a" VALUE="20" onkeypress="return alpha(event)"></TD></TR>
<TR><TD>Delay (minutes) before submit solution </TD><TD><INPUT TYPE="text" NAME="length1b" VALUE="20" onkeypress="return alpha(event)"></TD></TR>
<TR><TD>Delay (minutes) before poster </TD><TD><INPUT TYPE="text" NAME="length1c" VALUE="60" onkeypress="return alpha(event)"></TD></TR>
<TR><TD><b>Second phase</b></TD></TR>
<TR><TD>Length (minutes) of second phase </TD><TD><INPUT TYPE="text" NAME="length2" VALUE="120" onkeypress="return alpha(event)"></TD></TR>
<TR><TD><b>Other values</b></TD></TR>
<TR><TD>Time (minutes) given for one poster presentation</TD><TD><INPUT TYPE="text" NAME="presentation" VALUE="3" onkeypress="return alpha(event)"></TD></TR>
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