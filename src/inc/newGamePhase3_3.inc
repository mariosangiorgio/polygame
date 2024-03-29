<p><? echo $TEXT['newGamePhase3_2-p_1']; ?></p>
<div id="changeDataType">
	<a class="link"><? echo $TEXT['newGamePhase3_2-a_1']; ?></a>
</div>
<form
	name="loadPlayers"
	action="./backend/importUsers.php"
	method="POST"
	enctype="multipart/form-data"
>
	<p><? echo $TEXT['newGamePhase3_2-p_2']; ?>
		<input type="file" name="playersList" size="28" id="playersList" />
		<input type="submit" value="Send" />
	</p>
</form>
<?
	$query = "SELECT g.`Wedge ID` as wedgeID, w.`Title`, `Group name` as groupName ".
			"FROM `wedge groups` g, `wedges` w ".
			"WHERE w.`Wedge ID`=g.`Wedge ID` ".
			"AND g.`Game ID`='".$game['gameID']."';";
	$result = mysql_query( $query, $connection );
	
	$counter = 0;
	while( $group = mysql_fetch_array( $result ))
	{
		if( $group['groupName'] )
			$groupName = $group['groupName'];
		else
			$groupName = $group['Title'];
?>
<div class="playerList ui-corner-all">
	<a name="<? echo $group['wedgeID']; ?>"></a>
	<p><? echo $groupName; ?></p>
	<table class="playerTable">
	<tfoot>
		<tr class="firstRow">
			<th class="firstColumn">
				<input type="text" size="40" value="<? echo $TEXT['newGamePhase3_2-input_1_1']; ?>" name="username" />
			</th>
			<th class="secondColumn">
				<button type="button" class="addButton" ><? echo $TEXT['newGamePhase3_2-button_add']; ?></button>
			</th>
			<th class="thirdColumn"></th>
		</tr>
	</tfoot>
	<tbody>
<?
		$query = "SELECT u.username ".
				"FROM `players` p, `users` u ".
				"WHERE p.`Game ID`='".$game['gameID']."' ".
				"AND p.`Player ID`=u.`User ID` ".
				"AND p.`Wedge ID`='".$group['wedgeID']."';";
		$innerResult = mysql_query( $query, $connection );
		
		$emptyTable = true;
		while(( $player = mysql_fetch_array( $innerResult )))
		{
			$emptyTable = false;
?>
		<tr>
			<td class="firstColumn"><? echo $player['username']; ?></td>
			<td class="secondColumn"><button type="button" class="removeButton" ><? echo $TEXT['newGamePhase3_2-button_delete']; ?></button></td>
			<td class="thirdColumn"><button type="button" class="moveButton" ><? echo $TEXT['newGamePhase3_2-button_move']; ?></button></td>
		</tr>
<?						
		}
		if( $emptyTable )
			echo "<tr class=\"emptyRow\"><td colspan=\"3\">".$TEXT['newGamePhase3_2-noPlayers_1']."</td></tr>";
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
?>
<div id="nextPhaseButton">
	<button type="button"><? echo $TEXT['newGamePhase3_2-button_1']; ?></button>
</div>
<script type="text/Javascript">
(function($) {
	var usernameDefaultValue = "<? echo $TEXT['newGamePhase3_2-input_1_1']; ?>";
	
	$(document).ready( function() 
	{
		var alreadyPosted = false;
		var deleteButton = "<button type=\"button\" class=\"removeButton\" ><? echo $TEXT['newGamePhase3_2-button_delete']; ?></button>";
		var moveButton = "<button type=\"button\" class=\"moveButton\" ><? echo $TEXT['newGamePhase3_2-button_move']; ?></button>";
		var emptyRow = "<tr class=\"emptyRow\"><td colspan=\"3\"><? echo $TEXT['newGamePhase3_2-noPlayers_1']; ?></td></tr>";
		
		var addPlayer = function( table )
		{
			var tbody = $('tbody', $(table));
			var tfoot = $('tfoot', $(table));
			
			if( checkForm( tfoot ))
			{
				$(tfoot).parents('div.playerList').find('div.errorClass strong').html('');
				$(tfoot).parents('div.playerList').find('div.errorClass:visible').slideUp();

				var username = $('input[name="username"]', $(tfoot)).val();
				var row = "<tr><td class=\"firstColumn\">" + username + "</td>" + 
						"<td class=\"secondColumn\">" + deleteButton + "</td>" + 
						"<td class=\"thirdColumn\">" + moveButton + "</td></tr>";
				if( !$('tr:not(.emptyRow)', $(tbody)).length )
					$(tbody).html('');
				$(tbody).append( row );
				
				$('button.removeButton').button( {
					icons: { primary: './ui-lightness/images/ui-icons_2e83ff_256x240.png'}
				});
				$('button.moveButton').button();	
				
				generateWedgesList($('tr:last', $(tbody)));					
				$('input[name="username"]', $(tfoot)).attr('value', usernameDefaultValue ).focus().select();
			}
		
		}
		var generateWedgesList = function( row ) 
		{
			var currentWedge = $(row).parents('div.playerList').find('p').text();
			var wedges = $('div.playerList p');
			var wedgesDiv = "<div class=\"wedgesList\">";
			$(wedges).each( function() {
				if( $(this).text() != currentWedge )
					wedgesDiv += "<button type=\"button\" class=\"moveButton\">" + $(this).text() + "</button>";
			});
			wedgesDiv += "</div>";
			$('td.thirdColumn', $(row)).append( wedgesDiv );
			$('td.thirdColumn button.moveButton', $(row)).button();
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
			
			$('button.removeButton').button( {
				icons: { primary: './ui-lightness/images/ui-icons_2e83ff_256x240.png'}
			});
			generateWedgesList($('tr:last', $(destinationTable)));
		};
		
		$('button.moveButton').each( function() {
			generateWedgesList( $(this).parents('tr'));
		});
		
		$('button.addButton').click( function() {
			addPlayer( $(this).parents('table'));
		});
				
		$('table.playerTable tbody td.secondColumn button.removeButton').live('click', function()
		{
			var table = $(this).parents('table');
			var tbody = $(this).parents('tbody');
			var row = $(this).parents('tr');
			$(row).remove();
			if( !$('tr', $(tbody)).length )
				$(table).append( emptyRow );
		});
		$('table.playerTable tbody td.thirdColumn').live('mouseover', function() {
			$('button.moveButton:first', $(this)).addClass('ui-state-hover');
			$(this).find('div.wedgesList:hidden').show();
			return false;
		});
		$('table.playerTable tbody td.thirdColumn').live('mouseout', function() {
			$('button.moveButton:first', $(this)).removeClass('ui-state-hover');
			$(this).find('div.wedgesList:visible').hide();
			return false;
		});
		$('button.addButton').button( {
			icons: { primary: './ui-lightness/images/ui-icons_2e83ff_256x240.png'}
		});
		$('button.removeButton').button( {
			icons: { primary: './ui-lightness/images/ui-icons_2e83ff_256x240.png'}
		});
		$('button.moveButton').button();
		
		$('input[name="username"]').click( function() {
			if( $(this).attr('value') == usernameDefaultValue )
				$(this).removeAttr('value');
		});
		$('input[name="username"]').blur( function() {
			if( !$(this).attr('value'))
			{
				$(this).attr('value', usernameDefaultValue );
				$(this).parents('div.playerList').find('div.errorClass strong').html('');
				$(this).parents('div.playerList').find('div.errorClass:visible').slideUp();
			}
		});
		$('input[name="username"]').keypress( function( event ) {
			if( event.which == '13' ) {
				addPlayer( $(this).parents('table'));
			}
		});
		$('#changeDataType a').click( function()
		{
			if( confirm('<? echo $TEXT['newGamePhase3_2-confirm_1']; ?>'))
			{
				var dataString = "phase=3&useEmail=true&usingAjax=true";
				var url = "./backend/saveUseEmail.php";
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
			if( !alreadyPosted )
			{
				if( checkWedgePlayers())
				{
					alreadyPosted = true;
					var tables = $('table.playerTable');
					var dataString = "phase=3";
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
					dataString += "&numberOfUsers=" + index + "&usingAjax=true";
					var url = "./backend/saveWedgeGroups.php";
					var dataToSend = dataString;
					var typeOfDataToReceive = 'html';
					var callback = function( response ) {
						$("#wrapper").html( response );
					};
					$.post( url, dataToSend, callback, typeOfDataToReceive );
				}
			}
		});
	});
	
	function checkForm( tfoot ) 
	{
		var username_re = /^[a-z0-9]{6,12}$/i;
		
		var username = $('input[name="username"]', $(tfoot)).val();
		if( username == usernameDefaultValue )
			username = "";
		var errorStr = "";
		if( !username )
			errorStr += " <? echo $TEXT['newGamePhase3_2-username_1']; ?>";
		else
		{
			if( username.length < 6 || username.length > 12 )
				errorStr += " <? echo $TEXT['newGamePhase3_2-username_2']; ?>";
			else if( !username_re.test( username ))
				errorStr += " <? echo $TEXT['newGamePhase3_2-username_3']; ?>";
		}
		if( !errorStr && !isUnique( username ))
			errorStr += " <? echo $TEXT['newGamePhase3_2-username_4']; ?>";
		
		if( errorStr )
		{
			$(tfoot).parents('div.playerList').find('div.errorClass strong').html( errorStr );
			$(tfoot).parents('div.playerList').find('div.errorClass:hidden').slideDown();
			$('input[name="username"]', $(tfoot)).focus().select();
			return false;
		}
		return true;
	}
	function isUnique( username )
	{
		var result = true;
		var rows = $('div.playerList table.playerTable tbody tr:not(emptyRow)');
		$(rows).each( function()
		{
			if( username == $('td.firstColumn', $(this)).text())
			{
				result = false;
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
			$('strong', $(errorDiv)).html("<? echo $TEXT['newGamePhase3_2-noPlayers_2']; ?>");
			$(errorDiv).slideDown();
			window.location.href = "./createNewGame.php#" + anchor;
			return false;
		}
		return true;
	}
})(jQuery);
</script>
