<?php
session_start();
?>

<FORM METHOD="POST" ACTION="./authentication.php">
<TABLE>
<TR><TD>Username</TD><TD>Password</TD></TR>
<TR>
<TD><INPUT TYPE="text" NAME="username"></TD>
<TD><INPUT TYPE="password" NAME="password"></TD>
</TR>
</TABLE>

<INPUT TYPE="submit" VALUE="Login">
</FORM>