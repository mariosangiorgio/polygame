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
    	if(wedgesUsed == 20){
    		document.getElementById('submitButton').disabled=false;
    		return;
    	}
    	document.getElementById('submitButton').disabled=true;
    	if(wedgesUsed > 20){
    		document.getElementById('wedgesQuantity').innerHTML =
    			"<span style='color:red'>Quantity "
    			+ wedgesUsed + " of 20</span>";
    	}
    	else{
    		document.getElementById('wedgesQuantity').innerHTML =
    			"Quantity "+ wedgesUsed + " of 20";
    	}

    }
    
    </script>
    <noscript>
      <p>Your browser either does not support JavaScript, or you have JavaScript turned off.</p>
    </noscript>

<form name="Plan"
	  method="POST"
	  action="./businessLogic/submitPlan.php">
<TABLE id="WedgeTable">
<TR><TD>Wedge</TD><TD id=wedgesQuantity>Quantity</TD></TR>

<?php

//Here I fill all the lines with the wedge data
require("./businessLogic/databaseLogin.php");
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
	print "</TD><TD>";
	print "<input id=wedge";
	print $i;
	print " name=wedge";
	print $wedge['Wedge ID'];
	print " onkeyup=\"this.value = this.value.replace (/\D/, ''); validate('wedge";
	print $i;
	print "');\" ";
	print " onkeypress=\"this.value = this.value.replace (/\D/, '');\">";
	print "</TD></TR>\n";
	
	$i = $i+1;
}

?>

</TABLE>
<input type="submit" id="submitButton" disabled="true">
</form>

</body>