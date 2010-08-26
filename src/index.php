<?php 
	include_once("./inc/db_connect.php");
	include_once("./inc/common.php");
	include_once("./backend/utils.php");
	
	session_start();
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
			
			$("#accordion").accordion( accordionOption );
			
			$('#update').click( function() 
			{
				$.ajax({
					type: 'GET',
					url: 'backend/showWedges.php',
					dataType: 'json',
					success: function( json ) 
					{
						$("#accordion").replaceWith('<div id="accordion" class="accordion"></div>');
						$.each( json, function( index, wedge ) 
						{
							var result = '<h3><a>' + wedge.title + '</a></h3>' +
										'<div><img src="' + wedge.image + 
										'" width="66px" height="84px" />' + 
										'<p class="accordionText">' + wedge.summary +
										'</p><p class="accordionLink">' +
										'<a href="backend/wedgeInfo.php?id=' + wedge.id + '">' +
										'<? echo $TEXT['main-js_1']; ?>' +
										'</a></p></div>';
							$("#accordion").append( result );
						})
						$("#accordion").accordion( accordionOption );	
						$("#update").remove();
					},
					error: function( xhr, textStatus, errorThrown ) 
					{
						$('accordion').html("");
						$('accordion').append( '<? echo $TEXT['main-js_2']; ?>' + errorThrown );
					}
				});
			});
			
			$('#login').find('form input:first').focus();
			
			$('#login').find('a').click( function() 
			{
				$('#login div').hide();
				$('#login').hide('blind');
				$('#newAccount').show('blind', function() {
					$('#newAccount form').find('input:first').focus();
				});
			});
			
			$('#newAccount').find('a').click( function() 
			{
				$('#newAccount div').hide();
				$('#newAccount').hide('blind');
				$('#login').show('blind', function() 
				{
					$('#login form').find('input:first').focus();
				});
			});

			$('form').submit( function( event )
			{
				event.preventDefault();
				
				if( checkForm( this ))
				{
					$('input[name="usingAjax"]', this ).val('true');
					var $this = $(this);
					var url = $this.attr('action');
					var dataToSend = $this.serialize();
					var typeOfDataToReceive = 'json';
					var callback = function( response ){
						if( response.code != "200" )
						{
							$('div strong', $this ).text( response.message );
							$('div', $this ).show('blind', function() 
							{
								if( response.code == "401" )
									$('input[name="password"]', $this ).focus();
								else if( response.code == "402" )
									$('input[name="username"]', $this ).focus();
							});
						}
						else
							location.assign("./index.php");
					};
					
					$.post( url, dataToSend, callback, typeOfDataToReceive );
				}
				return false;
			});
		});
	})(jQuery);
	
	function checkForm( form ) 
	{
		var firstInput = true, secondInput = true;
		var errorStr = "";
		
		if( form.name == "loginForm" )
		{
			if( !form.username.value )
			{
				firstInput = false;
				errorStr += " <? echo $TEXT['main-js_3']; ?>";
				if( !form.password.value )
				{
					secondInput = false;
					errorStr += " <? echo $TEXT['main-js_4']; ?>";
				}
				errorStr += " <? echo $TEXT['main-js_5']; ?>";
			}
			else if( !form.password.value )
			{
				secondInput = false;
				errorStr += "<? echo $TEXT['main-js_6']; ?>";
			}	
		}
		if( form.name == "newAccountForm" )
		{
			if( !form.username.value )
			{
				firstInput = false;
				errorStr += " <? echo $TEXT['main-js_3']; ?>";
				if( !form.mail.value )
				{
					secondInput = false;
					errorStr += " <? echo $TEXT['main-js_7']; ?>";
				}
				errorStr += " <? echo $TEXT['main-js_5']; ?>";
			}
			else if( !form.mail.value )
			{
				secondInput = false;
				errorStr += "<? echo $TEXT['main-js_8']; ?>";
			}	
		}
		
		if( errorStr )
		{
			$(form).find('div strong').text( errorStr );
			$(form).find('div').show('blind', function() {
				if( !firstInput )
					$(form).find('input[name="username"]').focus();
				else if( !secondInput )
				{
					if( form.name == "loginForm" )
						$(form).find('input[name="password"]').focus();
					else
						$(form).find('input[name="mail"]').focus();
				}
			});
			return false;
		}
		
		return true;
	}
	
	function resetForm( form ) 
	{
		$(form).find('div strong').text('');
		$(form).find('div:visible').hide('blind');
		$(form).find('input:first').focus();
	}		
	</script>
</head>
<body>
	<? 
		$stripeImageUrl = "./images/welcome-new.png";
		include "header.php"; 
	?>
	<div id="wrapper">
		<div id="columnLeft">
			<div class="top">
				<h1><? echo $TEXT['main-h1_1']; ?></h1>
				<p><? echo $TEXT['main-p_1']; ?></p>
			</div>
			<div class="middle">
				<h1><? echo $TEXT['main-h1_2']; ?></h1>
				<div id="accordion" class="accordion">
<? 
	$wedgeLimit = 2;
	$numberOfWedges = 0;
	
	$query = "SELECT min(`Wedge ID`) as min, max(`Wedge ID`) as max FROM `Wedges`";
	$result = mysql_query( $query, $connection );
	$wedgeIdLimit = mysql_fetch_array( $result );
	
	$counter = 0;
	$vector = generateRandomSequence( $wedgeIdLimit['min'], $wedgeIdLimit['max'] );
	
	$query = "SELECT `Wedge ID` as id, Title, Summary, Image ". 
			 "FROM Wedges ".
			 "WHERE Language='$lang' AND ( ";
	while( $counter < $wedgeLimit )
	{
		$query = $query."`Wedge ID`=".$vector[$counter];
		$counter++;
		if( $counter == $wedgeLimit )
			$query = $query." )";
		else
			$query = $query." OR ";
	}
	
	$data = mysql_query( $query, $connection );
	while(( $wedge = mysql_fetch_array( $data )) && 
			( $numberOfWedges < $wedgeLimit ))
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
		$numberOfWedges++;
	}
?>
				</div>
				<div id="update">
					<a href="#"><? echo $TEXT['main-a_2']; ?></a>
				</div>
			</div>
		</div>
<?
	if( !( $_SESSION['loggedIn'] == "yes" )) 
	{
?>
		<div id="columnRight">
			<div id="login">
				<form 
					name="loginForm"
					method="post"
					action="./backend/authentication.php"
					onreset="resetForm(this)"
				>
				<fieldset class="ui-corner-all">
					<legend><? echo $TEXT['main-legend_1']; ?></legend>
					<div class="errorClass ui-corner-all">
						<p>
							<span class="ui-icon ui-icon-info"></span> 
							<strong></strong>
						</p>
					</div>
					<table class="loginTable">
					<tbody>
						<tr>
							<td><? echo $TEXT['main-td_1']; ?></td>
							<td><input type="text" name="username"></td>
						</tr>
						<tr>
							<td><? echo $TEXT['main-td_2']; ?></td>
							<td><input type="password" name="password"></td>
						</tr>
					</tbody>
					</table>
					<input class="button" type="submit" value="<? echo $TEXT['main-button_1']; ?>" />
					<input class="button" type="reset" value="<? echo $TEXT['main-button_2']; ?>" />
					<input type="hidden" name="usingAjax" value="false" />
					<p><? echo $TEXT['main-p_2']; ?><a href="#"><? echo $TEXT['main-a_3']; ?></a></p>
				</fieldset>
				</form>
			</div>
			<div id="newAccount">
				<form
					name="newAccountForm" 
					method="post"
					action="./businesslogic/authentication.php"
					onreset="resetForm(this)"
				>
				<fieldset class="ui-corner-all">
					<legend><? echo $TEXT['main-legend_2']; ?></legend>
					<div class="errorClass ui-corner-all">
						<p>
							<span class="ui-icon ui-icon-info"></span> 
							<strong></strong>
						</p>
					</div>
					<table class="loginTable">
					<tbody>
						<tr>
							<td><? echo $TEXT['main-td_3']; ?></td>
							<td><input type="text" name="username"></td>
						</tr>
						<tr>
							<td><? echo $TEXT['main-td_4']; ?></td>
							<td><input type="text" name="mail"></td>
						</tr>
					</tbody>
					</table>
					<input class="button" type="submit" value="<? echo $TEXT['main-button_3']; ?>"/>
					<input class="button" type="reset" value="<? echo $TEXT['main-button_2']; ?>"/>
					<input type="hidden" name="usingAjax" value="false" />
					<p><? echo $TEXT['main-p_3']; ?><a href="#"><? echo $TEXT['main-a_4']; ?></a></p>
				</fieldset>
				</form>
			</div>
		</div>
<?
	}
?>
	</div>
</body>
</html>