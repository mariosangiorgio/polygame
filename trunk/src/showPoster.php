<?php
session_start();
//Security check
if( $_SESSION['loggedIn'] == "yes" and
	( $_SESSION['role'] == "player" or
	  $_SESSION['role'] == "organizer" )){
	require("./businessLogic/databaseLogin.php");
	
	//Loading wedge information
	if($_GET['wedgeID']){
		$wedgeID	= intval($_GET['wedgeID']);
		if($_SESSION['role'] == "player"){
			$query		=
			"SELECT *
			 FROM  `Posters`,`Game Players`
			 WHERE `Posters`.`Wedge ID` = ".$wedgeID." AND 
				   `Posters`.`Game ID`=`Game Players`.`Game ID` AND
				   `Game Players`.`Player ID`='".$_SESSION['username']."'";
		}
		if($_SESSION['role'] == "organizer"){
			$query		=
			"SELECT *
			 FROM  `Posters`,`Game`
			 WHERE `Posters`.`Wedge ID` = ".$wedgeID." AND 
				   `Posters`.`Game ID`=`Game`.`Game ID` AND
				   `Organizer ID`='".$_SESSION['username']."'";

$query2 = "SELECT `Presentation time` FROM `Game`
		  WHERE `Organizer ID` = '".$_SESSION['username']."';";
$data	= mysql_query($query2,$connection);
$sec	= mysql_fetch_array($data);
		
		?><style type="text/css">
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
<link href="Design.css" rel="stylesheet" type="text/css" />

		 <div align="center" class="Design">
		   <p class="Design">&nbsp;	       </p>
		   <p class="Design">&nbsp;</p>
		   <p class="Design">&nbsp;</p>
		   <p class="Design">
		     <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="461" height="144">
		       <param name="movie" value="Flash/dots.swf" />
		       <param name="quality" value="high" />
		       <embed src="Flash/dots.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="461" height="144"></embed>
	         </object>
                                 </p>
		   <p class="Design">&nbsp;</p>
		   
		   <button type="button" onClick="display();">Start countdown</button>
		   <p>&nbsp;</p>
		 </div>
	    <form name="counter">
		   <div align="center">
		     <span class="Design">
		     <input type="text" size="8" 
name="d2">
	         </span></div>
	    </form> 
		 <div align="center">
           <span class="Design">
<?php
 $seconds = $sec['Presentation time'] % 60;
 $minutes = floor($sec['Presentation time'] / 60);
 
 print "<script>";
 //print "<!--";
 print "var seconds = ".$seconds."\n";
 print "var minutes = ".$minutes."\n";
 
 ?>
document.counter.d2.value = minutes+":"+seconds//+"."+millisec 
function display(){ 
 /*millisec-=1 
 if (millisec<=-1){ 
    millisec=9 
    seconds-=1 
 } */
 seconds-=1
 if (seconds <= 0 && minutes > 0) {
 	seconds = 59
 	minutes -= 1
 }  
    document.counter.d2.value=minutes+":"+seconds //+"."+millisec 
    if (seconds <= 0 && minutes <= 0) {    // && millisec <=0)
    //millisec = 0 
    seconds = 0
    minutes = 0
	//location.reload(true)
	window.location = "./organize.php";
	return
 	}
    setTimeout("display()",1000) 
} 
//display() 
//--> 
</script>
		
		<?php
		}
		
		$data	= mysql_query($query,$connection);
		$poster	= mysql_fetch_array($data);
		print "<B>PROS</B><BR>";
		print $poster['Pros']."<BR>
";
		print "<B>CONS</B><BR>
";
		print $poster['Cons']."<BR>
";
		print "<B>NOTES</B><BR>
";
		print $poster['Notes']."<BR>
";
		print "<A HREF=\"./\">Back</A>";
	}
	else{
		return;
	}
}</span></div>
         <div align="center" class="Design"></div>
