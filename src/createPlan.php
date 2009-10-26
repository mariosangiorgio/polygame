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
for ($i=0; $i<10;$i++){
	print "<TR><TD>Fakename</TD><TD>";
	print "<input id=wedge";
	print $i;
	print " onkeyup=\"this.value = this.value.replace (/\D/, ''); validate('wedge";
	print $i;
	print "');\" ";
	print " onkeypress=\"this.value = this.value.replace (/\D/, '');\">";
	print "</TD></TR>\n";
}
?>

</TABLE>
<input type="submit">
</form>

</body>