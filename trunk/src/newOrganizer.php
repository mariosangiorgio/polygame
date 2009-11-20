<?php
session_start();

if( $_SESSION['loggedIn'] == "yes" and
        $_SESSION['role'] == "administrator"){
?>
<link href="Design.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style1 {font-size: 9pt}
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
}
body {
	margin-left: 10px;
	margin-top: 10px;
	margin-right: 10px;
	margin-bottom: 10px;
}
-->
</style>

<FORM METHOD="POST" ACTION="./businessLogic/insertNewOrganizer.php">
  <div align="center" class="Design">
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p><br>
    </p>
    <p><img src="poly.png" alt="Poly" width="446" height="146"></p>
    <TABLE>
    <TR><TD class="Design">Name</TD>
    <TD class="Design"><div align="left" class="Design">Password</div></TD>
    </TR>
    <TR>
      <TD class="Design"><INPUT TYPE="text" NAME="username"></TD>
    <TD class="Design"><INPUT TYPE="password" NAME="password"></TD>
    </TR>
  </TABLE>
    <br>
    <INPUT TYPE="submit" VALUE="Insert">
  </div>
</FORM>
<div align="left">
  <?php
}
else {
        print "You must log in as an administrator to access this page!";
}
?>
</div>
