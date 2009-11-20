<?php
session_start();
?>
<A href=viewGroups.php>View existing groups</A> <A href=organize.php>Back</A>

<script type="text/javascript">
<!--
    function alpha(e) {
        var k;
        document.all ? k = e.keyCode : k = e.which;
return ( k != 32 );
}
// -->
</script>

<FORM METHOD="POST"
	  ACTION='./businessLogic/insertGroup.php'>
<TABLE>
<TR>
<TD>Name</TD>
<TD><INPUT TYPE='text' NAME='name' onkeypress="return alpha(event)"></TD>
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