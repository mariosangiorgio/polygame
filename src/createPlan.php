<?php

session_start();

?>

<body>
    <script type="application/javascript">
    
    function validate(currentWedge) {
    	var wedgesUsed = 0;
    	var i;
    	var rows = document.getElementById('WedgeTable').rows.length - 1;
    	var value;
    	document.getElementById(currentWedge).value
    		= document.getElementById(currentWedge).value.replace (/\D/, '');
    	
    	for($i=0; $i<rows; $i = $i+1){
    		value = document.getElementById('wedge'+$i).value;
    		value = parseInt(value);
    		if( !isNaN(value) ){
    			wedgesUsed = wedgesUsed + value;
    		}
    	}
    	if(wedgesUsed > 20){
    		document.getElementById('wedgesQuantity').innerHTML =
    			"<span style='color:red'>Quantity "
    			+ wedgesUsed + " of 20</span>";
    	}
    	else{
    		document.getElementById('wedgesQuantity').innerHTML =
    			"Quantity "+ wedgesUsed + " of 20";
    		if(wedgesUsed == 20){
    			document.getElementById('submitButton').disabled=false;
    			return;
    		}
    	}
    	document.getElementById('submitButton').disabled=true;

    }
    
    </script>
    <noscript>
      <p>Your browser either does not support JavaScript, or you have JavaScript turned off.</p>
    </noscript>
    
<?php

//Here I fill all the lines with the wedge data
require("./businessLogic/databaseLogin.php");
/*
 * If there are values for the plan I show them and ask user
 * if he wants to drop them.
 */
$query 	=
	"SELECT *
	 FROM `Plans`
	 WHERE `Player ID` = '".$_SESSION['username'] . "'";
$data	= mysql_query($query,$connection);

if(mysql_fetch_array($data)){
	//Just show
	print "<TABLE id=\"WedgeTable\">
			<TR><TD>Wedge</TD><TD id=wedgesQuantity>Quantity</TD></TR>";
	$query 	=
		"SELECT
				`Wedges`.`Wedge ID` as `Wedge ID`, `Title`,`Wedge Count`
		 FROM
		 		`Plans`, `Wedges`
		 WHERE
		 	   `Wedges`.`Wedge ID` = `Plans`.`Wedge ID` AND
			   `Plans`.`Player ID` = '".
				$_SESSION['username'] . "'";
	$data	= mysql_query($query,$connection);
	
	while($wedge = mysql_fetch_array($data)){
		print "<TR><TD>";
		print "<A HREF=showWedgeInformation.php?wedgeID=";
		print $wedge['Wedge ID'].">";
		print $wedge['Title'];
		print "</A>";
		print "</TD><TD>";
		print $wedge['Wedge Count'];
		print "</TD></TR>\n";
	}
	print "</TABLE>";
	print "<A HREF=businessLogic/deletePlan.php>Delete plan</A>";
}
else{
	print "<form name=\"Plan\"
				 method=\"POST\"
	  			 action=\"./businessLogic/submitPlan.php\">
		   <TABLE id=\"WedgeTable\">
			<TR><TD>Wedge</TD><TD id=wedgesQuantity>Quantity</TD></TR>";
	//Data insertion
	$query 	=
		"SELECT
			   `Wedges`.`Wedge ID` as `Wedge ID`, `Title`
		 FROM
			   `Game Players`,
			   `Game Wedges`,
			   `Wedges`
		 WHERE
			   `Game Wedges`.`Wedge ID` = `Wedges`.`Wedge ID` AND
			   `Game Wedges`.`Game ID` = `Game Players`.`Game ID` AND
			   `Game Players`.`Player ID` = '".
				$_SESSION['username'] . "'";
	$data	= mysql_query($query,$connection);
	
	$i = 0;
	while($wedge = mysql_fetch_array($data)){
		print "<TR><TD>";
		print "<A HREF=showWedgeInformation.php?wedgeID=";
		print $wedge['Wedge ID'].">";
		print $wedge['Title'];
		print "</A>";
		print " (<A HREF=showPoster.php?wedgeID=";
		print $wedge['Wedge ID'].">";
		print "poster</A>)";
		print "</TD><TD>";
		print "<input id=wedge".$i;
		print " name=".$wedge['Wedge ID'];
		print " onkeyup=\"this.value = this.value.replace (/\D/, ''); validate('wedge";
		print $i;
		print "');\" ";
		print " onkeypress=\"this.value = this.value.replace (/\D/, '');\">";
		print "</TD></TR>\n";
		
		$i = $i+1;
	}
	print "</TABLE>
	       <input type=\"submit\" id=\"submitButton\" disabled=\"true\">
	       </form>";
}
?>
</body>