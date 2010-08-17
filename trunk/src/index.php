<?php 
	include_once("inc/db_connect.php");
	include_once("inc/common.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title><? echo $TEXT['main-page_title']; ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link href="css/main.css" type="text/css" rel="stylesheet" />
	<link type="text/css" href="css/ui-lightness/jquery-ui-1.8.4.custom.css" rel="stylesheet" />	
	<script type="text/JavaScript" src="lib/jquery-1.4.1.min.js"></script>
	<script type="text/Javascript" src="lib/jquery-ui-1.8.4.custom.min.js"></script> 
	<script type="text/javascript"> 
	( function($) {
		$(document).ready( function() 
		{
			var accordionOption = { collapsible: true, 
									active : false, 
									autoHeight: false, 
									animated: 'bounceslide' };
			
			$('#update').click( function() 
			{
				$.ajax({
					type: 'GET',
					url: 'backend/showWedges.php',
					dataType: 'json',
					success: function( json ) 
					{
						$("#accordion").replaceWith('<div id="accordion"></div>');
						$.each( json, function( index, wedge ) 
						{
							var result = '<h3><a>' + wedge.title + '</a></h3>' +
										'<div><img src="' + wedge.image + 
										'" width="66px" height="84px" />' + 
										'<p class="accordionText">' + wedge.summary +
										'</p><p class="accordionLink">' +
										'<a href="wedgeInfo.php?id=' + wedge.id +
										'">more info</a></p></div>';
							$("#accordion").append( result );
						})
						$("#accordion").accordion( accordionOption );	
						$("#update").remove();
					},
					error: function( xhr, textStatus, errorThrown ) 
					{
						$('accordion').html("");
						$('accordion').append('An error occurred! ' + errorThrown );
					}
				});
			});
			
			$("#login").find('a').click( function() 
			{
				$("#login").hide('blind');
				$("#newAccount").show('blind');
			});			
			
			$("#newAccount").find('a').click( function() 
			{
				$("#newAccount").hide('blind');
				$("#login").show('blind');
			});
			
			$("#accordion").accordion( accordionOption );
		});
	})(jQuery);
	</script>
</head>
<body>
	<div id="header">
		<div id="stripe" />
		<div id="logo">
			<img src="images/welcome-new.png" height="150px" />
		</div>
		<div id="languages"> 
			<a href="index.php?lang=en"><img src="images/en.png" /></a> 
			<a href="index.php?lang=it"><img src="images/it.png" /></a> 
		</div>
	</div>
	<div id="wrapper">
		<div id="columnLeft">
			<div class="top">
				<h1><? echo $TEXT['main-h1_1']; ?></h1>
				<p><? echo $TEXT['main-p_1']; ?></p>
			</div>
			<div class="bottom">
				<h1><? echo $TEXT['main-h1_2']; ?></h1>
			</div>
			<div id="accordion">
<? 
	$wedge_limit = 3;
	$number_of_wedges = 0;
	
	$query = "SELECT `Wedge ID` as id, Title, Summary, Image FROM Wedges WHERE Language='$lang' ORDER BY Preferences DESC";
	
	$data = mysql_query( $query, $connection );
	while(( $wedge = mysql_fetch_array( $data )) && 
			( $number_of_wedges < $wedge_limit ))
	{
?>
		<h3><a><? echo $wedge['Title']; ?></a></h3>
		<div>
			<img src="<? echo $wedge['Image']; ?>" width="66px" height="84px" />
			<p class="accordionText">
				<? echo $wedge['Summary']; ?>
			</p>
			<p class="accordionLink">
				<a href="wedgeInfo.php?id=<? echo $wedge['id']; ?>"><? echo $TEXT['main-a_1']; ?></a>
			</p>
		</div>
<?		
		$number_of_wedges++;
	}
?>
			</div>
		<div id="update">
			<a href="#"><? echo $TEXT['main-a_2']; ?></a>
		</div>
		</div>
		<div id="columnRight">
			<div id="login">
				<form method="post" action="./businesslogic/authentication.php">
				<fieldset>
					<legend>Login</legend>
					<table class="loginTable">
					<tbody>
						<tr>
							<td>Username</td>
							<td><input type="text" name="username"></td>
						</tr>
						<tr>
							<td>Password</td>
							<td><input type="password" name="password"></td>
						</tr>
					</tbody>
					</table>
					<input class="button" type="submit" value="login"/>
					<input class="button" type="reset" value="cancel"/>
					<p>... or <a href="#">request new account »</a></p>
				</fieldset>
				</form>
			</div>
			<div id="newAccount">
				<form method="post" action="./businesslogic/newAccount.php">
				<fieldset>
					<legend>New Account</legend>
					<table class="loginTable">
					<tbody>
						<tr>
							<td>Username</td>
							<td><input type="text" name="username"></td>
						</tr>
						<tr>
							<td>Email address</td>
							<td><input type="password" name="password"></td>
						</tr>
					</tbody>
					</table>
					<input class="button" type="submit" value="confirm"/>
					<input class="button" type="reset" value="cancel"/>
					<p>... already registered? <a href="#">Login here »</a></p>
				</fieldset>
				</form>
			</div>

		</div>
	</div>
</body>
</html>