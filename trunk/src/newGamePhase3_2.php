<div id="changeDataType">
	<a class="link">I want to specify just the
<?
	if( $_SESSION['phase3']['dataType'] == "username" )
		echo "email!";
	else if( $_SESSION['phase3']['dataType'] == "email" )
		echo "username!";
?>
	</a>
</div>
<form
	name="loadPlayers"
	action="./backend/importUsers.php"
	method="POST"
	enctype="multipart/form-data"
>
	<p>You can load a list of names from a file:
		<input type="file" name="playersList" size="28" id="playersList" />
		<input type="submit" value="Send" />
	</p>
</form>
<?
if( isSet( $_SESSION['phase2'] ))
{
	foreach( $_SESSION['phase2']['wedges'] as $keyValue => $wedgeId )
	{
		$query = "SELECT `Wedge ID` as Id, Title ". 
			 "FROM Wedges ".
			 "WHERE Language='$lang' AND `Wedge ID`=".$wedgeId;
		$data = mysql_query( $query, $connection );
		$wedge = mysql_fetch_array( $data )
?>
<div class="playerList ui-corner-all">
	<a name="<? echo $wedge['Id']?>"></a>
	<p>
		<? echo $wedge['Title']?>
	</p>
	<table class="playerTable">
	<tfoot>
		<tr class="firstRow">
			<th class="firstColumn">
				<input type="text" size="40" value="Insert the new player <? echo $_SESSION['phase3']['dataType']; ?> here..." name="userId"/>
			</th>
			<th class="secondColumn">
				<button type="button" class="addPlayer" >Add</button>
			</th>
			<th class="thirdColumn"></th>
		</tr>
	</tfoot>
	<tbody>
<?
		if( isSet( $_SESSION['phase3']['users'] ))
		{
			$emptyTable = true;
			foreach( $_SESSION['phase3']['users'] as $userId => $user )
			{
				if( $user['wedgeId'] == $wedge['Id'] )
				{
					$emptyTable = false;
?>
		<tr>
			<td class="firstColumn"><? echo $userId; ?></td>
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
	<div class="errorClass ui-corner-all">
		<span class="ui-icon ui-icon-info"></span>
		<strong></strong>
	</div>
</div>
<?
	}
}
?>
<div id="nextPhaseButton">
	<button type="button">I'm done with first phase!</button>
</div>
<script type="text/javascript">
	(function($) {
		var userIdDefaultValue = "Insert the new player <? echo $_SESSION['phase3']['dataType']; ?> here...";
		$(document).ready( function() 
		{
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
				});
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
				
				if( checkForm( tfoot ))
				{
					$(tfoot).parents('div.playerList').find('div.errorClass strong').html('');
					$(tfoot).parents('div.playerList').find('div.errorClass:visible').slideUp();
					var userId = $('input[name="userId"]', $(tfoot)).val();
					var row = "<tr><td class=\"firstColumn\">" + userId + "</td><td class=\"secondColumn\">" + 
							deleteButton + "</td>" + "<td class=\"thirdColumn\">" + moveButton + "</td></tr>";
					if( !$('tr:not(.emptyRow)', $(tbody)).length )
						$(tbody).html('');
					$(tbody).append( row );
					
					$('button.removePlayer').button( {
						icons: { primary: './ui-lightness/images/ui-icons_2e83ff_256x240.png'}
					});
					$('button.movePlayer').button();	
					
					generateWedgesList($('tr:last', $(tbody)));
					
					$('input[name="userId"]', $(tfoot)).attr('value', userIdDefaultValue );
				}
			});
			$('table.playerTable tbody td.secondColumn button.removePlayer').live('click', function()
			{
				var table = $(this).parents('table');
				var tbody = $(this).parents('tbody');
				var row = $(this).parents('tr');
				$(row).remove();
				if( !$('tr', $(tbody)).length )
					$(table).append( emptyRow );
			});
			$('table.playerTable tbody td.thirdColumn').live('mouseover', function() {
				$('button.movePlayer:first', $(this)).addClass('ui-state-hover');
				$(this).find('div.wedgesList:hidden').show();
				return false;
			});
			$('table.playerTable tbody td.thirdColumn').live('mouseout', function() {
				$('button.movePlayer:first', $(this)).removeClass('ui-state-hover');
				$(this).find('div.wedgesList:visible').hide();
				return false;
			});
			$('button.addPlayer').button( {
				icons: { primary: './ui-lightness/images/ui-icons_2e83ff_256x240.png'}
			});
			$('button.removePlayer').button( {
				icons: { primary: './ui-lightness/images/ui-icons_2e83ff_256x240.png'}
			});
			$('button.movePlayer').button();
			
			$('input[name="userId"]').click( function() {
				if( $(this).attr('value') == userIdDefaultValue )
					$(this).removeAttr('value');
			});
			$('input[name="userId"]').blur( function() {
				if( !$(this).attr('value'))
				{
					$(this).attr('value', userIdDefaultValue );
					$(this).parents('div.playerList').find('div.errorClass strong').html('');
					$(this).parents('div.playerList').find('div.errorClass:visible').slideUp();
				}
			});
			$('#changeDataType a').click( function()
			{
				if( confirm('If you continue, all data inserted about users will be lost. Are you sure?'))
				{
					var dataString = "usingAjax=true&comingPhase=3&destinationPhase=3&numberOfUsers=0";
					var url = "./createNewGame.php";
					var dataToSend = dataString;
					var typeOfDataToReceive = 'html';
					var callback = function( response ) {
						$("#wrapper").html( response );
					};
					$.post( url, dataToSend, callback, typeOfDataToReceive );
				}
			});
			$('#nextPhaseButton button').button().click( function( event )
			{
				event.preventDefault();
				if( checkWedgePlayers())
				{
					var tables = $('table.playerTable');
					var dataString = "usingAjax=true&comingPhase=3&destinationPhase=4";
					var index = 0;
					$(tables).each( function() 
					{
						var wedgeId = $(this).parents('div.playerList').find('a').attr('name');
						var rows = $('tbody tr:not(.emptyRow)', $(this));
						$(rows).each( function()
						{
							var userId = $('td.firstColumn', $(this)).text();
							dataString += "&user" + index + "=" + userId + "&wedge" + index + "=" + wedgeId;
							index++;
						});
					});
					dataString += "&numberOfUsers=" + index;
					var url = "./createNewGame.php";
					var dataToSend = dataString;
					var typeOfDataToReceive = 'html';
					var callback = function( response ) {
						$("#wrapper").html( response );
					};
					$.post( url, dataToSend, callback, typeOfDataToReceive );
				}
			});
		});
		
		function checkForm( tfoot ) 
		{
			<? 	echo "var dataType = \"".$_SESSION['phase3']['dataType']."\";"; ?>
			var userId_re;
			if( dataType == "username" )
				userId_re = /^[a-z0-9]{6,12}$/i;
			else
				userId_re = /^.+@.+\..+$/i
			var userId = $('input[name="userId"]', $(tfoot)).val();
			if( userId == userIdDefaultValue )
				userId = "";
			var errorStr = "";
			if( !userId )
				errorStr += " User identifier missing.";
			else
			{
				if( dataType == "username" )
				{
					if( userId.length < 6 || userId.length > 12 )
						errorStr += " <? echo $TEXT['main-username_2']; ?>";
					else if( !userId_re.test( userId ))
						errorStr += " <? echo $TEXT['main-username_3']; ?>";
				}
				else 
					if( !userId_re.test( userId ))
						errorStr += " <? echo $TEXT['main-mail_2']; ?>";
				if( isUnique( userId ))
					errorStr += " User identifier already used";
			}
			
			if( errorStr )
			{
				$(tfoot).parents('div.playerList').find('div.errorClass strong').html( errorStr );
				$(tfoot).parents('div.playerList').find('div.errorClass:hidden').slideDown( function() {
					$('input[name="userId"]', $(tfoot)).focus().select();
				});
				return false;
			}
			return true;
		}
		function isUnique( userId )
		{
			var result = false;
			var rows = $('div.playerList table.playerTable tbody tr:not(emptyRow)');
			$(rows).each( function()
			{
				if( userId == $('td.firstColumn', $(this)).text())
				{
					result = true;
					return ;
				}
			});
			return result;
		}
		function checkWedgePlayers()
		{
			if( $('div.playerList table.playerTable tbody tr.emptyRow').length )
			{
				var row = $('div.playerList table.playerTable tbody tr.emptyRow:first');
				var errorDiv = $(row).parents('div.playerList').find('div.errorClass');
				var anchor = $(row).parents('div.playerList').find('a').attr('name');
				$('strong', $(errorDiv)).html( "No players specified for this wedge" );
				$(errorDiv).slideDown();
				window.location.href = "./createNewGame.php#" + anchor;
				return false;
			}
			return true;
		}
	})(jQuery);
</script>