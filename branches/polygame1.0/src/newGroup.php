<?php
session_start();
?>
<link href="Design.css" rel="stylesheet" type="text/css" />
<style type="text/css">
p
{
	background-image: url(images/background.png);
	background-position: right bottom;
	background-repeat: repeat;
	background-attachment: fixed;
}
a.three:link {color: #DD137B}
a.three:visited {color: #DD137B}
a.three:hover {background: #DD137B}
<!--
a:link {
	text-decoration: none;
}
a:visited {
	text-decoration: none;
}
a:hover {
	text-decoration: none;
}
a:active {
	text-decoration: none;
}
-->
</style>
<link href="css/Design.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {
	font-family: "HelveticaNeue LT 107 XBlkCn";
	font-size: 16pt;
}
-->
</style>
<div align="center" class="Design">
  <div align="center" class="Design">
    <p align="center">&nbsp;    </p>
    <p align="center">&nbsp;</p>
    <p align="center">&nbsp;</p>
    <p align="center">
      
      <span class="Design">
      <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="461" height="144">
        <param name="movie" value="Flash/dots.swf" />
        <param name="quality" value="high" />
        <embed src="Flash/dots.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="461" height="144"></embed>
      </object>
      </span></p>
    <p align="center">&nbsp;</p>
   <p align="center" class="Design"> Add a new group | <A href=viewGroups.php class="three style1">View existing groups</A><BR><BR>
      
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
          <TD class="Design">            <span class="Design">
          <INPUT TYPE='text' NAME='name' onkeypress="return alpha(event)">          
          </span></TD>
        </TR>
                
                    <span class="Design"><span class="Design">                    </span>
              
                  
                  <span class="Design">
                  <TR>
                  </span>
                
                    <span class="Design"></span>                    </span>
              
                
              <TD class="Design">Phase</TD>
              
                <span class="Design"><span class="Design">                </span>
          
                  
                  <span class="Design">
                  <TD>
                  </span>
                
                    <span class="Design"></span>                    </span>
              
                
                
                    <span class="Design"><span class="Design">                    </span>
              
                  
                  <span class="Design">
                  <SELECT NAME='phase'>
                  </span>
                
                    <span class="Design"></span>                    </span>
              
                
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
  </div>
  <p align="center" class="Design"><br />
    <input type="submit" id="Insert">
  </p>
  
 </FORM>


<BR><BR> <p align="center" class="Design">
<A href=organize.php class="three style1">Back to organizer page</A> 
</p>
