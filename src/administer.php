<?php
	session_start();
	include_once("./inc/db_connect.php");
	include_once("./inc/common.php");
	include_once("./backend/utils.php");
	
	//TODO: add multi language support to this page
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
	<style>
	.delete{
		float:right;
		}
	</style>
</head>
<body>
	<?
		include "header.php";
		if(!checkAuthorization("administrator")){
			?>
			<div id="wrapper">
			<div id="singleColumn">
			Please log in as an administrator
			</div>
			</div>
			<?
			return;
		}
		else{
			//Loading current organizers from the database
			//TODO: randomize list
			$currentOrganizers = array();
			
			$query = "SELECT `username` FROM `Users` WHERE `role`='organizer' LIMIT 3";
			$result = mysql_query( $query, $connection );
			while($currentOrganizer = mysql_fetch_array( $result )){
				$currentOrganizers[] = $currentOrganizer;
			}
		}
	?>
<div id="wrapper">
	<div class="singleColumn">
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
						$username = $organizer['username'];
						echo "<DIV name='$username'>$username";
						echo "<SPAN class=delete>DELETE</SPAN>";
						echo "</DIV>";
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

<!-- Confirmation dialog -->
<div id="dialog-confirm" title="Delete the organizer?">
<p>This operation cannot be undone, are you sure?</p>
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
	var parameters = {operation: 'getAllOrganizers'};
	$.getJSON("backend/administration.php",
			  parameters,
        function(data){
          $.each(data,function(i,item){
          	var name = item.name;
          	if($.inArray(name,names) == -1){
          		existingOrganizers.append("<DIV name='"+name+"'>"+name+"<SPAN class=delete>DELETE</SPAN></DIV>");
          	}
          });
          bindDeleteEvent();
         });
     more.remove();
});

var dialog = $("#dialog-confirm").dialog(
				{autoOpen: false,
				 resizable: false,
				 modal: true
				 }
				 );

function bindDeleteEvent(){
	var deleteOrganizer = $(".delete");
	deleteOrganizer.each(function(i,item){
		$(this).click(function(){
			var parentElement = $(this).parent();
			dialog.dialog(
				{
				buttons: {
				 	'Ok': function() {
				 		$(this).dialog('close');
				 		parentElement.css('background-color','red');
				 		parentElement.slideUp();
				 		},
				 	Cancel: function() {
				 		$(this).dialog('close');
				 		}
				 	}
				 }
				 );
			dialog.dialog("open");
		});
	});
}

bindDeleteEvent();


</script>
</body>
</html>