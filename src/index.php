<?php 
	include_once("./inc/db_connect.php");
	include_once("./inc/init.php");
	include_once("./lang/".$gData['langFile']);
	include_once("./backend/utils.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title><? echo $TEXT['main-page_title']; ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link href="css/main.css" type="text/css" rel="stylesheet" />
	<link href="css/index.css" type="text/css" rel="stylesheet" />
	<link href="css/ui-lightness/jquery-ui-1.8.4.custom.css" type="text/css" rel="stylesheet" />	
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
			
			$('#accordion').accordion( accordionOption );
			
			$('button').button();
			
			$('.roleButton button').click( function() {
				location.href = $('a', $(this)).attr('href');
			});
			
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
										'<a href="wedgeInfo.php?id=' + wedge.id + '">' +
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
			
			$('#login a.link').click( function() 
			{
				$('#login div.errorClass').hide();
				$('#login').hide('blind');
				$('#newAccount').show('blind', function(){
					$('#newAccount form').find('input:first').focus();
				});
			});
			
			$('#newAccount a.link').click( function() 
			{
				$('#newAccount div.errorClass').hide();
				$('#newAccount').hide('blind');
				$('#login').show('blind', function(){
					$('#login form').find('input:first').focus();
				});
			});

			$('form').submit( function( event )
			{
				event.preventDefault();
				
				if( checkForm( this ))
				{
					var $this = $(this);
					var url = $this.attr('action');
					var formName = $this.attr('name');
					var dataToSend = $this.serialize();
					var typeOfDataToReceive = 'json';
					var callback;
					if( formName == "loginForm" )
					{
						callback = function( response ){
							if( response.code != "200" )
							{
								$('div.errorClass strong', $this ).html( response.message );
								$('div.errorClass', $this ).show('blind', function() 
								{
									if( response.code == "302" )
										$('input[name="password"]', $this ).focus();
									else if( response.code == "303" )
										$('input[name="username"]', $this ).focus();
								});
							}
							else
								location.assign("./index.php");
						};
					}
					else if( formName == "newAccountForm" )
					{
						callback = function( response ){
							if( response.code != "200" )
							{
								$('div.errorClass strong', $this ).html( response.message );
								$('div.errorClass', $this ).show('blind', function() 
								{
									if( response.code == "402" )
										$('input[name="username"]', $this ).focus();
									else if( response.code == "403" || response.code == "404" )
										$('input[name="mail"]', $this ).focus();
								});
							}
							else
								location.assign("./index.php");
						};
					}
					$.post( url, dataToSend, callback, typeOfDataToReceive );
				}
				return false;
			});
		});
	})(jQuery);
	
	function checkForm( form ) 
	{
		var username_re = /^[a-z0-9]{6,12}$/i;
		var password_re = /^[a-z0-9]{6,12}$/i;
		var mail_re = /^.+@.+\..+$/i;
		var firstInput = "", secondInput = "";
		
		if( form.name == "loginForm" )
		{
			if( !form.username.value )
				firstInput += " <? echo $TEXT['main-username_1']; ?>";
			else
			{
				var username = form.username.value;
				if( username.length < 6 || username.length > 12 )
					firstInput += " <? echo $TEXT['main-username_2']; ?>";
				else if( !username_re.test( username ))
					firstInput += " <? echo $TEXT['main-username_3']; ?>";
			}
			if( !firstInput )
			{
				if( !form.password.value )
					secondInput += " <? echo $TEXT['main-password_1']; ?>";
				else
				{
					var password = form.password.value;
					if( password.length < 6 || password.length > 12 )
						secondInput += " <? echo $TEXT['main-password_2']; ?>";
					else if( !password_re.test( password ))
						secondInput += " <? echo $TEXT['main-password_3']; ?>";
				}
			}
		}
		if( form.name == "newAccountForm" )
		{
			if( !form.username.value )
				firstInput += " <? echo $TEXT['main-username_1']; ?>";
			else
			{
				var username = form.username.value;
				if( username.length < 6 || username.length > 12 )
					firstInput += " <? echo $TEXT['main-username_2']; ?>";
				else if( !username_re.test( username ))
					firstInput += " <? echo $TEXT['main-username_3']; ?>";
			}
			if( !firstInput )
			{
				if( !form.mail.value )
					secondInput += " <? echo $TEXT['main-mail_1']; ?>";
				else if( !mail_re.test( form.mail.value ))
					secondInput += " <? echo $TEXT['main-mail_2']; ?>";
			}
		}
		
		if( firstInput || secondInput )
		{
			$(form).find('div.errorClass strong').html( firstInput + secondInput );
			$(form).find('div.errorClass').show('blind', function() {
				if( firstInput )
					$(form).find('input[name="username"]').focus();
				else if( secondInput )
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
		$(form).find('div.errorClass:visible').hide('blind', function() {
			$(form).find('div.errorClass strong').html('');
			$(form).find('input:first').focus();
		});
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
			<div>
				<h1><? echo $TEXT['main-h1_1']; ?></h1>
				<p><? echo $TEXT['main-p_1']; ?></p>
			</div>
			<div>
				<h1><? echo $TEXT['main-h1_2']; ?></h1>
				<div id="accordion" class="accordion">
<? 
	$counter = 0;
	$index = 0;
	$wedgeLimit = 3;
	
	$query = "SELECT `Wedge ID` as id, Title, Summary, Image FROM Wedges WHERE Language='".$gData['lang']."';";
	$result = mysql_query( $query, $connection );
	
	while( $row = mysql_fetch_array( $result ))
	{
		$wedges[$counter] = array(  'id' 		=> $row['id'],
									'title' 	=> $row['Title'],
									'summary' 	=> $row['Summary'],
									'image' 	=> $row['Image'] );
		$counter++;
	}
	
	$vector = generateRandomSequence( 0, $counter - 1 );
	while( $wedgeLimit > 0 && $counter > 0 )
	{
?>
					<h3><a><? echo $wedges[$vector[$index]]['title']; ?></a></h3>
					<div>
						<img src="<? echo $wedges[$vector[$index]]['image']; ?>" width="66px" height="84px" />
						<p class="accordionText">
							<? echo $wedges[$vector[$index]]['summary']; ?>
						</p>
						<p class="accordionLink">
							<a href="wedgeInfo.php?id=<? echo $wedges[$vector[$index]]['id']; ?>"><? echo $TEXT['main-a_1']; ?></a>
						</p>
					</div>
<?		
		$wedgeLimit--;
		$counter--;
		$index++;
	}
?>
				</div>
				<div id="update">
					<a class="link"><? echo $TEXT['main-a_2']; ?></a>
				</div>
			</div>
		</div>
		<div id="columnRight">
<?
	if( !$gData['logged'] )
	{
?>
			<div id="login" class="ui-corner-all">
				<h2><? echo $TEXT['main-legend_1']; ?></h2>
				<form 
					name="loginForm"
					method="post"
					action="./backend/authentication.php"
					onreset="resetForm(this)"
				>
					<div class="errorClass ui-corner-all">
						<p>
							<span class="ui-icon ui-icon-info"></span>
							<strong></strong>
						</p>
					</div>
					<div class="formTable">
						<div>
							<label for="username"><? echo $TEXT['main-td_1']; ?></label>
							<input type="text" name="username" />
							<br style="clear:both" />
						</div>
						<div>
							<label for="password"><? echo $TEXT['main-td_2']; ?></label>
							<input type="password" name="password" />
							<br style="clear:both" />
						</div>
						<div class="formButton">
							<button type="submit">
								<? echo $TEXT['main-button_1']; ?>
							</button>
							<button type="reset">
								<? echo $TEXT['main-button_2']; ?>
							</button>
							<br style="clear:both" />
						</div>
					</div>
					<div>
						<? echo $TEXT['main-p_2']; ?><a class="link"><? echo $TEXT['main-a_3']; ?></a>
					</div>
				</form>
			</div>
			<div id="newAccount" class="ui-corner-all" style="display:none">
				<h2><? echo $TEXT['main-legend_2']; ?></h2>
				<form
					name="newAccountForm" 
					method="post"
					action="./backend/newUser.php"
					onreset="resetForm(this)"
				>
					<div class="errorClass ui-corner-all">
						<p>
							<span class="ui-icon ui-icon-info"></span>
							<strong></strong>
						</p>
					</div>
					<div class="formTable">
						<div>
							<label for="username"><? echo $TEXT['main-td_3']; ?></label>
							<input type="text" name="username" />
							<br style="clear:both" />
						</div>
						<div>
							<label for="email"><? echo $TEXT['main-td_4']; ?></label>
							<input type="email" name="email" />
							<br style="clear:both" />
						</div>
						<div class="formButton">
							<button type="submit">
								<? echo $TEXT['main-button_3']; ?>
							</button>
							<button type="reset">
								<? echo $TEXT['main-button_2']; ?>
							</button>
							<br style="clear:both" />
						</div>
					</div>
					<div>
						<? echo $TEXT['main-p_3']; ?><a class="link"><? echo $TEXT['main-a_4']; ?></a>
					</div>
				</form>
			</div>
<?
	}
	else if( $gData['role'] == "organizer" )
	{
		$organizerAction = $TEXT['main-button_6'];
		$link = "./createNewGame.php";
		
		$query = "SELECT Defined, Started FROM `game` WHERE `Organizer ID`='".$gData['username']."';";
		$result = mysql_query( $query, $connection );
		
		if(( $row = mysql_fetch_array( $result )))
		{
			if( $row['Defined'] )
			{
				$link = "./play.php";
				if( $row['Started'] )
					$organizerAction = $TEXT['main-button_4'];
				else
					$organizerAction = $TEXT['main-button_5'];
			}
		}
?>		
			<div class="roleButton">
				<button type="button"><a href="<? echo $link; ?>"><? echo $organizerAction; ?></a></button>
			</div>
<?
	}
	else if( $gData['role'] == "player" )
	{
?>
			<div class="roleButton">
				<button type="button"><a href="./playerPlay.php"><? echo $TEXT['main-button_7']; ?></a></button>
			</div>			
<?
	}
?>
		</div>
		<br style="clear:both" />
	</div>
</body>
</html>
