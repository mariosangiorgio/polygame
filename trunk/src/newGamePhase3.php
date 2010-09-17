<? include "newGameBar.php"; ?>
<div id="divPhase3" class="phases">
	<form
		name="loadPlayers"
		action="./createNewGame.php"
		method="POST"
		enctype="multipart/form-data"
	>
		<p>You can load a list of names from a file:
			<input type="file" name="playersList" size="28" id="playersList" />
		</p>
	</form>
<?
	if( isSet( $_SESSION['phase2'] ))
	{
		foreach( $_SESSION['phase2']['wedges'] as $key_value => $wedgeId )
		{
			$query = "SELECT `Wedge ID` as Id, Title ". 
				 "FROM Wedges ".
				 "WHERE Language='$lang' AND `Wedge ID`=".$wedgeId;
			$data = mysql_query( $query, $connection );
			$wedge = mysql_fetch_array( $data )
?>
	<div class="playerList ui-corner-all">
		<p>
			<? echo $wedge['Title']?>
			<input type="hidden" name="wedgeId" value="<? echo $wedge['Id']?>" />
		</p>
		<table class="playerTable">
		<tfoot>
			<tr class="firstRow">
				<th class="firstColumn">
					<input type="text" size="40" value="Insert the new player username here..." name="username"/>
				</th>
				<th class="secondColumn" rowspan="2">
					<button type="button" class="addPlayer" >Add</button>
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
<?
			if( isSet( $_SESSION['phase3'] ))
			{
				$emptyTable = true;
				foreach( $_SESSION['phase3']['user'] as $user )
				{
					if( $user['wedgeId'] == $wedge['Id'] )
					{
						$emptyTable = false;
?>
			<tr>
				<td class="firstColumn"><? echo $user['username']; ?></td>
				<td class="secondColumn"><button type="button" class="removePlayer" >Delete</button></td>
				<td class="thirdColumn"><button type="button" class="movePlayer" >Move to...</button></td>
			</tr>
<?						
					}
				}
				if( $emptyTable )
					echo "<tr class=\"emptyRow\"><td colspan=\"3\">No players!</td></tr>";
			}
			else
				echo "<tr class=\"emptyRow\"><td colspan=\"3\">No players!</td></tr>";
?>
		</tbody>
		</table>
	</div>
<?
		}
	}
?>
	<div id="nextPhaseButton">
		<button type="submit">I'm done with players!</button>
	</div>
</div>
<script type="text/javascript">
	(function($) {
		$(document).ready( function() 
		{
			var usernameDefaultValue = "Insert the new player username here...";
			var emailDefaultValue = "Insert the new player email here...";
			var deleteButton = "<button type=\"button\" class=\"removePlayer\" >Delete</button>";
			var moveButton = "<button type=\"button\" class=\"movePlayer\" >Move to...</button>";
			var emptyRow = "<tr class=\"emptyRow\"><td colspan=\"3\">No players!</td></tr>";
			
			var generateWedgesList = function( row ) 
			{
				var currentWedge = $(row).parents('div.playerList').find('p').text();
				var wedges = $('div.playerList p');
				var wedgesDiv = "<div class=\"wedgesList\">";
				$(wedges).each( function() {
					if( $(this).text() != currentWedge )
						wedgesDiv += "<button type=\"button\" class=\"movePlayer\">" + $(this).text() + "</button>";
				})
				wedgesDiv += "</div>";
				$('td.thirdColumn', $(row)).append( wedgesDiv );
				$('td.thirdColumn button.movePlayer', $(row)).button();
				$('td.thirdColumn div.wedgesList button', $(row)).button().click( function() {
					movePlayer( this );
				});
			}
			
			var movePlayer = function( buttonElement ) 
			{					
				var originTable = $(buttonElement).parents('tbody');
				var originWedge = $(originTable).parents('div.playerList').find('p').text();
				var destinationWedge = $(buttonElement).find('span').text();
				var destinationTable = $('div.playerList p:contains("' + destinationWedge + '")').parent().find('tbody');
				$(buttonElement).parents('div.wedgesList').hide();
				$(buttonElement).find('span').text( originWedge );
				
				$(buttonElement).parents('tr').remove();
				if( !$('tr:not(.emptyRow)', $(originTable)).length )
					$(originTable).append( emptyRow );
				
				var username = $(buttonElement).parents('tr').find('td.firstColumn').text();
				var row = "<tr><td class=\"firstColumn\">" + username +
							"</td><td class=\"secondColumn\">" + deleteButton + "</td>" + 
							"<td class=\"thirdColumn\">" + moveButton + "</td></tr>";
							
				if( !$('tr:not(.emptyRow)', $(destinationTable)).length )
					$(destinationTable).html('');
				$(destinationTable).append(row);
				
				$('button.removePlayer').button( {
					icons: { primary: './ui-lightness/images/ui-icons_2e83ff_256x240.png'}
				});
				generateWedgesList($('tr:last', $(destinationTable)));
			};
			
			$('button.movePlayer').each( function() {
				generateWedgesList( $(this).parents('tr'));
			});
			
			$('button.addPlayer').click( function()
			{
				var table = $(this).parents('table');
				var tbody = $('tbody', $(table));
				var tfoot = $('tfoot', $(table));
				
				if( true )
				{
					var username = $('input[name="username"]', $(tfoot)).val();
					var email = $('input[name="email"]', $(tfoot)).val();
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
					if( !$('tr:not(.emptyRow)', $(tbody)).length )
						$(tbody).html('');
					$(tbody).append( row );
					
					$('button.removePlayer').button( {
						icons: { primary: './ui-lightness/images/ui-icons_2e83ff_256x240.png'}
					});
					$('button.movePlayer').button();	
					
					generateWedgesList($('tr:last', $(tbody)));
					
					$('input[name="username"]', $(tfoot)).attr('value', usernameDefaultValue );
					$('input[name="email"]', $(tfoot)).attr('value', emailDefaultValue );
				}
			});
			$('table.playerTable tbody td.secondColumn button').live('click', function()
			{
				var table = $(this).parents('table');
				var tbody = $(this).parents('tbody');
				var row = $(this).parents('tr');
				$(row).remove();
				if( !$('tr', $(tbody)).length )
					$(table).append( emptyRow );
			});
			$('table.playerTable tbody td.thirdColumn').live('mouseover', function() {
				$(this).find('div.wedgesList:hidden').show();
				return false;
			});
			$('table.playerTable tbody td.thirdColumn').live('mouseout', function() {
				$(this).find('div.wedgesList:visible').hide();
				return false;
			});
			
			$('button[type="submit"]').button();
			$('button.addPlayer').button( {
				icons: { primary: './ui-lightness/images/ui-icons_2e83ff_256x240.png'}
			});
			$('button.removePlayer').button( {
				icons: { primary: './ui-lightness/images/ui-icons_2e83ff_256x240.png'}
			});
			$('button.movePlayer').button();
			
			$('input[type="text"]').focus( function() {
				$(this).removeAttr('value');
			});
			$('input[name="username"]').blur( function() {
				if( !$(this).attr('value'))
					$(this).attr('value', usernameDefaultValue );
			});
			$('input[name="email"]').blur( function() {
				if( !$(this).attr('value'))
					$(this).attr('value', emailDefaultValue);
			});
			
			$('#nextPhaseButton button[type="submit"]').click( function()
			{
				var tables = $('table.playerTable');
				var dataString = "usingAjax=true&phase=4";
				var index = 0;
				$(tables).each( function() 
				{
					var wedgeId = $(this).parents('div.playerList').find('input[name="wedgeId"]').val();
					var rows = $('tbody tr:not(.emptyRow)', $(this));
					$(rows).each( function()
					{
						var username = $('td.firstColumn', $(this)).text();
						dataString += "&user" + index + "=" + username + "&wedge" + index + "=" + wedgeId;
						index++;
					});
				});
				dataString += "&numberOfUsers=" + index;
				var $this = $(this);
				var url = $this.attr('action');
				var formName = $this.attr('name');
				var dataToSend = dataString;
				var typeOfDataToReceive = 'html';
				var callback = function( response ) {
					$("#wrapper").html( response );
				};
				
				$.post( url, dataToSend, callback, typeOfDataToReceive );	
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
	})(jQuery);
</script>