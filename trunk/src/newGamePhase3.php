<? include "newGameBar.php"; ?>
<div id="divPhase3" class="phases">
	<form
		name="phase3Form"
		action="./createNewGame.php"
		method="POST"
		enctype="multipart/form-data"
	>
		<p>You can load a list of names from a file:
			<input type="file" name="playersList" size="28" id="playersList" />
		</p>
		<input type="hidden" name="usingAjax" value="false" />
		<input type="hidden" name="phase" value="<? echo ( $phaseNumber + 1 ); ?>" />
<?
	if( isSet( $_SESSION['phase2'] ))
	{
		foreach( $_SESSION['phase2']['wedges'] as $key_value => $wedgeId )
		{
			$query = "SELECT `Wedge ID` as id, Title ". 
				 "FROM Wedges ".
				 "WHERE Language='$lang' AND `Wedge ID`=".$wedgeId;
			$data = mysql_query( $query, $connection );
			$wedge = mysql_fetch_array( $data )
?>
	<div class="playerList ui-corner-all">
		<p><? echo $wedge['Title']?></p>
		<table class="playerTable">
		<tfoot>
			<tr class="firstRow">
				<th class="firstColumn">
					<input type="text" size="40" value="Insert the new player username here..." name="username"/>
				</th>
				<th class="secondColumn" rowspan="2">
					<button type="button" class="addPlayer icon-button ui-button ui-corner-all ui-widget ui-state-default" >
						<span class="ui-icon ui-icon-add"></span>
						<span class="small-button-text">Add</span>
					</button>
				</th>
				<th class="thirdColumn"></th>
			</tr>
			<tr>
				<th class="firstColumn">
					<input type="text"  size="40" value="Insert the new player email here..." name="email" />
				</th>
				<th class="thirdColumn"></th>
			</tr>			
		</tfoot>
		<tbody>
			<tr class="emptyRow">
				<td colspan="3">No players!</td>
			</tr>
		</tbody>
		</table>
	</div>
<?
		}
	}
?>
	<div id="nextPhaseButton">
		<button type="submit" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" >
			<span class="ui-button-text">I'm done with players!</span>
		</button>
	</div>
	</form>
</div>
<script type="text/javascript">
	(function($) {
		$(document).ready( function() 
		{
			var usernameDefaultValue = "Insert the new player username here...";
			var emailDefaultValue = "Insert the new player email here...";
			
			$('#divPhase3 form').submit( function( event )
			{
				event.preventDefault();
				var data = "usingAjax=true&phase=<? echo ( $phaseNumber + 1 ); ?>";
				var table = $('#playerList tbody');
				var rowVector = $('tr:not(.emptyRow)', $(table));
				for( var index = 0; index < rowVector.length; index++ )
					data +=  '&username' + index + '=' + $('tr:eq(' + index + ') td.firstColumn', $(table)).text() +
							 '&password' + index + '=' + $('tr:eq(' + index + ') td.secondColumn', $(table)).text();
				var $this = $(this);
				var url = $this.attr('action');
				var formName = $this.attr('name');
				var dataToSend = data;
				var typeOfDataToReceive = 'html';
				var callback = function( response )
				{
					$("#wrapper").html( response );
					$('#organizerBar label[for="phase<? echo $phaseNumber; ?>"]').removeClass('ui-state-active');
					$('#organizerBar label[for="phase<? echo ( $phaseNumber + 1 ); ?>"]').addClass('ui-state-active');
					$('#organizerBar label[for="phase<? echo ( $phaseNumber + 1 ); ?>"]').toggleClass('unreachable reachable');
				};
				
				$.post( url, dataToSend, callback, typeOfDataToReceive );	
			});
			$('button.addPlayer').click( function()
			{
				var table = $(this).parents('table');
				var tbody = $('tbody', $(table));
				var tfoot = $(this).parents('tfoot');
				
				if( true )
				{
					var rowVector = $('tr:not(.emptyRow)', $(tbody));
					var index = rowVector.length - 1;
					var username = $('input[name="username"]', $(tfoot)).val();
					var email = $('input[name="email"]', $(tfoot)).val();
					var deleteButton = "<button type=\"button\" class=\"icon-button ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only\" >" +
										"<span class=\"ui-icon ui-icon-remove\"></span>" + 
										"<span class=\"small-button-text\">Delete</span></button>";
					var moveButton = "<button type=\"button\" class=\"ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only\" >" +
										"<span class=\"small-button-text ui-button-text\">Move to...</span></button>";
					var row = "<tr><td class=\"firstColumn\">";
					
					if( username != usernameDefaultValue )
						row += username;
					if( username != usernameDefaultValue &&
						email != emailDefaultValue )
						row += " - ";
					if( email != emailDefaultValue )
						row += email;
					
					row += "</td><td class=\"secondColumn\">" + deleteButton + "</td>" + 
							"<td class=\"thirdColumn\">" + moveButton + "</td></tr>";
					if( index < 0 )
						$(tbody).html('');
					$(tbody).append( row );
					index++;
					
					$('tr:last td.secondColumn', $(tbody)).click( function() {
						$(this).parent().remove();
						var rowVector = $('tr', $(tbody));
						if( !rowVector.length )
							$(table).append("<tr class=\"emptyRow\"><td colspan=\"3\">No players!</td></tr>");
					});
					$('tr:last td.thirdColumn', $(tbody)).mouseover( function() 
					{
						var wedgeList = $('div.wedgesList', $(this));
						if( !wedgeList.length )
						{
							var currentWedge = $(table).parent().find('p').text();
							var wedges = $('div.playerList p');
							var wedgesDiv = "<div class=\"wedgesList\">";
							for( var index = 0; index < wedges.length; index++ )
								if( $(wedges).eq(index).text() != currentWedge )
									wedgesDiv += "<h3 class=\"ui-corner-all\">" + $(wedges).eq(index).text() + "</h3>";
							wedgesDiv += "</div>";
							$(this).append( wedgesDiv );
							$('div.wedgesList h3', $(this)).click( function()
							{
								var user = $(this).parents('tr').find('td.firstColumn').text();
								var wedgeSelected = $(this).text();
								var destinationTable = $('div.playerList p:contains("' + wedgeSelected + '")').parent().find('tbody');
								alert(destinationTable);
								$(destinationTable).append( $(this).parents('tr') );
								$(this).parents('tr').remove();
							});
						}
						$(wedgeList).show();
					
					});
					$('tr:last td.thirdColumn', $(tbody)).mouseout( function() {
						$('div.wedgesList', $(this)).hide();
					});
				}
			});	
			$('input[type="text"]').focus( function() {
				$(this).removeAttr('value');
			});
			$('input[name="username"]').blur( function() {
				if( !$(this).attr('value'))
					$(this).attr('value', 'Insert the new player username here...');
			});
			$('input[name="email"]').blur( function() {
				if( !$(this).attr('value'))
					$(this).attr('value', 'Insert the new player email here...');
			});
			$('#resetPlayer').click( function() {
				resetForm();
			});		
		});
		function checkForm( tfoot ) 
		{
			var username_re = /^[a-z0-9]{6,12}$/i;
			var mail_re = /^.+@.+\..+$/i;
			var firstInput = "", secondInput = "";
			
			var username = $('input[name="username"]', $(tfoot)).val();
			var email = $('input[name="email"]', $(tfoot)).val();
				
			if( !username && !email )
				firstInput += " Username and/or password missing.";
			else if( username )
			{
				if( username.length < 6 || username.length > 12 )
					firstInput += " <? echo $TEXT['main-username_2']; ?>";
				else if( !username_re.test( username ))
					firstInput += " <? echo $TEXT['main-username_3']; ?>";
				else if( email && !mail_re.test( email ))
					secondInput += " <? echo $TEXT['main-mail_2']; ?>";
			}
			else if( email && !mail_re.test( email ))
				secondInput += " <? echo $TEXT['main-mail_2']; ?>";
			
			if( firstInput || secondInput )
			{
				$('#insertUser div.errorClass strong').html( firstInput + secondInput );
				$('#insertUser div.errorClass').show('blind', function() {
					if( firstInput )
						$('#insertUser input[name="username"]').focus();
					else if( secondInput )
						$('#insertUser input[name="email"]').focus();
				});
				return false;
			}
			return true;
		}
		function resetForm()
		{
			$('#insertUser div.errorClass:visible').hide('blind', function() {
				$('#insertUser div.errorClass strong').html('');
			});
			$('#insertUser input').removeAttr('value');
			$('#insertUser input:first').focus();
		}
	})(jQuery);
</script>