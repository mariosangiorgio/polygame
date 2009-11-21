<?php
session_start();
?>
<link href="Design.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	margin-left: 10px;
	margin-top: 10px;
	margin-right: 10px;
	margin-bottom: 10px;
}
a:link {
	text-decoration: none;
}
a:visited {
	text-decoration: none;
}
a:hover {
	text-decoration: none;
	color: #CCCCCC;
}
a:active {
	text-decoration: none;
}
-->
</style>
<div align="center" class="Design">
  <div align="center" class="Design">
    <p>&nbsp;    </p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>
      <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="461" height="144">
        <param name="movie" value="Flash/dots.swf" />
        <param name="quality" value="high" />
        <embed src="Flash/dots.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="461" height="144"></embed>
      </object>
    </p>
    <p>&nbsp;</p>
    <p><A href=viewGroups.php>View existing groups</A> <A href=organize.php>Back</A>
      
      <script type="text/javascript">
<!--
    function alpha(e) {
        var k;
        document.all ? k = e.keyCode : k = e.which;
return ( k != 32 );
}
// -->
      </script>
      </p>
  </div>
</div>
<FORM METHOD="POST"
	  ACTION='./businessLogic/insertGroup.php'>
  
  
  <div align="center">
    <TABLE>
      <TR>
        <TD class="Design">Name</TD>
        <TD class="Design">          <span class="Design">
          <INPUT TYPE='text' NAME='name' onkeypress="return alpha(event)">        
        </span></TD>
      </TR>
        
          <span class="Design">
          <TR>
          </span>
      
      <TD class="Design">Phase</TD>
            
            <span class="Design">
            <TD>
            </span>
          
        
          <span class="Design">
          <SELECT NAME='phase'>
          </span>
      
      <OPTION VALUE='One'><span class="Design"> First Phase
      </span>
      <OPTION VALUE='Two'><span class="Design"> Second Phase
      </span>
        
          <span class="Design">
          </TD>
          </span>
      
        
          <span class="Design">
          </TR>
          </span>
      </TABLE>
      
    <span class="Design">
    <input type="submit" id="Insert">
    </span></div>
</FORM>
