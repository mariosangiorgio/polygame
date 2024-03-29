<?php
	session_start();
	include_once("./inc/db_connect.php");
	include_once("./inc/common.php");
	include_once("./backend/utils.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title><? echo $TEXT['administration-page_title']; ?></title>
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
			<div class="singleColumn">
			<? echo $TEXT['administration-page_login-error-message']; ?>
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
			<h1><? echo $TEXT['administration-page_organizers-heading']; ?></h1>
			<div id="pendingRequests">
				<h2><? echo $TEXT['administration-page_pending-requests']; ?></h2>
				//TODO: add pending requests
			</div>
			
			<div id="existingOrganizers">
				<h2><? echo $TEXT['administration-page_active-organizers']; ?></h2>
				<?
					foreach($currentOrganizers as $organizer){
						$username = $organizer['username'];
						echo "<DIV name='$username'>$username";
						echo "<SPAN class=delete>".$TEXT['administration-page_delete']."</SPAN>";
						echo "</DIV>";
					}
					echo "<DIV id='showAll' style='color: red;'>".$TEXT['administration-page_show-all']."</DIV>";
				?>
			</div>
		</div>
		
		<div id="wedges">
			<h1><? echo $TEXT['administration-page_submitted-wedges']; ?></h1>
			//TODO: add proposals
		</div>
	</div>
</div>

<!-- Confirmation dialog -->
<div id="dialog-confirm" title="<? echo $TEXT['administration-page_dialog-title']; ?>">
<p><? echo $TEXT['administration-page_dialog-message']; ?></p>
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
          		existingOrganizers.append("<DIV name='"+name+"'>"+name+"<SPAN class=delete><? echo $TEXT['administration-page_delete']; ?></SPAN></DIV>");
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
				 		//Call to the backend to remove the organizer
				 		var username = parentElement.attr('name');

				 		var parameters = {
				 							operation:	'deleteOrganizer',
				 							username:	username
				 						 };
				 		$.getJSON("backend/administration.php",parameters);
				 		
				 		//Removing it also from the user interface
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