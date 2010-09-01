<?php
	session_start();
	include_once("./inc/db_connect.php");
	include_once("./inc/common.php");
	include_once("./backend/utils.php");
	
	//TODO: check if the user has the rights to access this page
	//TODO: add multi language support to this page
	
	//Loading current organizers from the database
	$currentOrganizers = array();
	
	$query = "SELECT `username` FROM `Users` WHERE `role`='organizer' LIMIT 3";
	$result = mysql_query( $query, $connection );
	while($currentOrganizer = mysql_fetch_array( $result )){
		$currentOrganizers[] = $currentOrganizer;
	}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title>Administration page</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link href="css/main.css" type="text/css" rel="stylesheet" />
	<link type="text/css" href="css/ui-lightness/jquery-ui-1.8.4.custom.css" rel="stylesheet" />	
	<script type="text/JavaScript" src="lib/jquery-1.4.1.min.js"></script>
	<script type="text/JavaScript" src="lib/jquery-ui-1.8.4.custom.min.js"></script>
</head>
<body>
	<?
		include "header.php"; 
	?>
<div id="wrapper">
	<div id="singleColumn">
		<div id="organizers">
			<h1>Organizers of polygame</h1>
			<div id="pendingRequests">
				<h2>New requests</h2>
				//TODO: add pending requests
			</div>
			
			<div id="existingOrganizers">
				<h2>Existing orgnizers</h2>
				<?
					foreach($currentOrganizers as $organizer){
						echo "<DIV name='".$organizer['username']."'>".$organizer['username']."</DIV>";
					}
					echo "<DIV id='showAll' style='color: red;'>Show all</DIV>";
				?>
			</div>
		</div>
		
		<div id="wedges">
			<h1>Wedges proposal</h1>
			//TODO: add proposals
		</div>
	</div>
</div>

<!-- ajax script -->
<script type="text/JavaScript">
var more	   = $("#showAll");
var existingOrganizers = $("#existingOrganizers");

more.click(function(){
	//Getting the already displayed elements
	var names = new Array();
	var elements = existingOrganizers.children();
	$.each(elements,function(i,val){
						var name=val.getAttribute('name');
						if(name != null){names.push(name)}
	});
	
	//Getting the full list from the server
	$.getJSON("backend/getAllOrganizers.php",
        function(data){
          $.each(data, function(i,item){
          	var name = item.name;
          	if($.inArray(name,names) == -1){
          		existingOrganizers.append("<DIV name='"+name+"'>"+name+"</DIV>");
          	}
          });
         });
	more.remove();
});

</script>

</body>
</html>