<?php
session_start();
?>
<FORM METHOD="POST"
	  ACTION='./businessLogic/insertGroup.php'>
<TABLE>
<TR>
<TD>Name</TD>
<TD><INPUT TYPE='text' NAME='name'></TD>
</TR>
<TR>
<TD>Phase</TD>
<TD>
	<SELECT NAME='phase'>
	<OPTION VALUE='One'> First Phase
	<OPTION VALUE='Two'> Second Phase
</TD>
</TR>
</TABLE>
<input type="submit" id="Insert">
</FORM>