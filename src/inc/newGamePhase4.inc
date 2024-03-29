<div id="divPhase4" class="phase4 phases">
<p><? echo $TEXT['newGamePhase4-p_1']; ?></p>
<?
	$query = "SELECT `Plan ID` as planID, `Group name` as groupName ".
			"FROM `plan groups` WHERE `Game ID`='".$game['gameID']."';";
	$result = mysql_query( $query, $connection );
	$numberOfPlans = mysql_num_rows( $result );
		
	if( $numberOfPlans )
	{
		while(( $plan = mysql_fetch_array( $result )))
		{		
?>
	<div class="playerList ui-corner-all">
		<p><? echo $plan['groupName']; ?></p>
		<table class="playerTable">
		<tbody>
<?			
			$query = "SELECT u.username ".
				"FROM `players` p, `users` u ".
				"WHERE p.`Game ID`='".$game['gameID']."' ".
				"AND p.`Player ID`=u.`User ID` ".
				"AND p.`Plan ID`='".$plan['planID']."';";
			$innerResult = mysql_query( $query, $connection );
			while(( $user = mysql_fetch_array( $innerResult )))
			{
?>
			<tr>
				<td class="firstColumn"><? echo $user['username']; ?></td>
				<td class="secondColumn"><button type="button" class="moveButton" ><? echo $TEXT['newGamePhase3_2-button_move']; ?></button></td>
			</tr>
<?
			}
?>
		</tbody>
		</table>
	</div>
<?
		}
	}
	else
	{
		$query = "SELECT count(*) as counter ".
			"FROM `wedge groups` WHERE `Game ID`='".$game['gameID']."';";
		$result = mysql_query( $query, $connection );
		$row = mysql_fetch_array( $result );
		$numberOfWedges = $row['counter'];
		
		$query = "SELECT u.username ".
				"FROM `players` p, `users` u ".
				"WHERE p.`Game ID`='".$game['gameID']."' ".
				"AND p.`Player ID`=u.`User ID`;";
		$userRow = mysql_query( $query, $connection );
		$numberOfUsers = mysql_num_rows( $userRow );
		
		$vector = generateRandomSequence( 0, $numberOfUsers - 1 );
		$userPerGroup = intval( $numberOfUsers / $numberOfWedges );
		$remainingUsers = $numberOfUsers % $numberOfWedges;
		$userIndex = 0;
		$index = 0;
		while(( $user = mysql_fetch_array( $userRow )))
		{
			$userVector[$index] = $user['username'];
			$index++;
		}
		for( $index = 0; $index < $numberOfWedges; $index++ )
		{
			
?>
	<div class="playerList ui-corner-all">
		<p><? echo $TEXT['newGamePhase4-p_2']; ?><? echo ( $index + 1 ); ?></p>
		<table class="playerTable">
		<tbody>
<?			
			for( $counter = 0; $counter < $userPerGroup; $counter++ )
			{
?>
			<tr>
				<td class="firstColumn"><? echo $userVector[$vector[$userIndex]]; ?></td>
				<td class="secondColumn"><button type="button" class="moveButton" ><? echo $TEXT['newGamePhase3_2-button_move']; ?></button></td>
			</tr>
<?
				$userIndex++;
			}
			if( $remainingUsers > 0 )
			{
?>			
			<tr>
				<td class="firstColumn"><? echo $userVector[$vector[$userIndex]]; ?></td>
				<td class="secondColumn"><button type="button" class="moveButton" ><? echo $TEXT['newGamePhase3_2-button_move']; ?></button></td>
			</tr>
<?
				$remainingUsers--;
				$userIndex++;
			}
?>
		</tbody>
		</table>
	</div>
<?
		}
	}
?>
	<div class="addGroup ui-corner-all">
		<table>
		<tbody>
			<tr>
				<td class="firstColumn">
					<input type="text"  size="40" value="<? echo $TEXT['newGamePhase4-input_1']; ?>" name="newGroupName" />
				</td>			
				<td class="secondColumn">
					<button type="button" class="addButton" ><? echo $TEXT['newGamePhase3_2-button_add']; ?></button>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<div class="errorClass ui-corner-all">
						<span class="ui-icon ui-icon-info"></span>
						<strong></strong>
					</div>
				</td>
			</tr>
		</tbody>
		</table>
	</div>
	<div id="nextPhaseButton">
		<button type="submit"><? echo $TEXT['newGamePhase4-button_1']; ?></button>
	</div>
</div>
<script type="text/javascript">
	(function($) {
		$(document).ready( function() 
		{
			var alreadyPosted = false;
			var moveButton = "<button type=\"button\" class=\"moveButton\" ><? echo $TEXT['newGamePhase3_2-button_move']; ?></button>";
			var groupDefaultValue = "<? echo $TEXT['newGamePhase4-input_1']; ?>";
			
			var addGroup = function()
			{
				var newGroupName = $('div.addGroup input[name="newGroupName"]').val();
				var errorStr = checkGroupName( newGroupName, $('div.addGroup'));
				if( !errorStr )
				{
					$('div.addGroup div.errorClass strong').html('');
					$('div.addGroup div.errorClass:visible').slideUp();
					$('div.addGroup input[name="newGroupName"]').attr('value', groupDefaultValue );
					var newGroupDiv = "<div class=\"playerList ui-corner-all\">" + "<p>" + newGroupName + 
									"</p><table class=\"playerTable\"><tbody></tbody></table></div>";
									
					$('div.addGroup').before( newGroupDiv );
					
					var groupsList = $('div.playerList table.playerTable tbody td.secondColumn div.groupsList');
					$(groupsList).each( function() {
						$(this).append('<button type="button" class="moveButton">' + newGroupName + '</button>');
						$('button.moveButton:last', $(this)).button().click( function() {
							movePlayer( this );
						});
					});
				}
				else
				{
					$('div.addGroup div.errorClass strong').html( errorStr );
					$('div.addGroup div.errorClass').slideDown();
				}
			};
			
			var generateGroupsList = function( row ) 
			{
				var currentGroup = $(row).parents('div.playerList').find('p').text();
				var groups = $('div.playerList p');
				var groupsDiv = "<div class=\"groupsList\">";
				$(groups).each( function() {
					if( $(this).text() != currentGroup )
						groupsDiv += "<button type=\"button\" class=\"moveButton\">" + $(this).text() + "</button>";
				});
				groupsDiv += "</div>";
				$('td.secondColumn', $(row)).append( groupsDiv );
				$('td.secondColumn button.moveButton', $(row)).button();
				$('td.secondColumn div.groupsList button', $(row)).button().click( function() {
					movePlayer( this );
				});
			};
			
			var movePlayer = function( buttonElement ) 
			{
				var originTable = $(buttonElement).parents('tbody');
				var originGroup = $(originTable).parents('div.playerList').find('p').text();
				var destinationGroup = $(buttonElement).find('span').text();
				var destinationTable = $('div.playerList p:contains("' + destinationGroup + '")').parent().find('tbody');
				$(buttonElement).parents('div.groupsList').hide();
				$(buttonElement).find('span').text( originGroup );

				var userId = $(buttonElement).parents('tr').find('td.firstColumn').text();
				var row = "<tr><td class=\"firstColumn\">" + userId +
							"</td><td class=\"secondColumn\">" + moveButton + "</td></tr>";
				
				$(buttonElement).parents('tr').remove();
				if( !( $('tr', $(originTable)).length ))
				{
					$(originTable).parents('div.playerList').remove();
					$('td.secondColumn div.groupsList button span:contains("' + originGroup + '")').parent().remove();
				}
				$(destinationTable).append(row);
				generateGroupsList($('tr:last', $(destinationTable)));		
			};
			
			var changeGroupName = function( pElement )
			{
				var groupName;
				if( $('input[name="groupName"]', $(pElement)).length )
					groupName = $('input[name="groupName"]', $(pElement)).val();
				else
					groupName = $(pElement).text();
				var groupDiv = $(pElement).parents('div.playerList')
				$(pElement).html('<input type="text" name="groupName" value="' + groupName + '" />');
				
				$('input[name="groupName"]', $(pElement)).focus().select().blur( function()
				{
					var newGroupName = $(this).val();
					if( !checkGroupName( newGroupName, groupDiv ))
					{
						$(pElement).html( newGroupName );
						$('td.secondColumn div.groupsList button span:contains("' + groupName + '")').text( newGroupName );
					}
					else
					{
						if( !$('span', $(pElement)).length )
							$(this).after("<span><? echo $TEXT['newGamePhase4-span_1']; ?></span>");
						$(this).focus().select();
					}
				});
			}
			
			$('div.playerList p').live('click', function() {
				changeGroupName( $(this));
			});
			
			$('button.moveButton').each( function() {
				generateGroupsList( $(this).parents('tr'));
			});
			$('table.playerTable tbody td.secondColumn').live('mouseover', function() {
				$('button.moveButton:first', $(this)).addClass('ui-state-hover');
				$(this).find('div.groupsList:hidden').show();
				return false;
			});
			$('table.playerTable tbody td.secondColumn').live('mouseout', function() {
				$('button.moveButton:first', $(this)).removeClass('ui-state-hover ui-state-focus');	
				$(this).find('div.groupsList:visible').hide();
				return false;
			});
			$('div.addGroup button.addButton').button( {
				icons: { primary: './ui-lightness/images/ui-icons_2e83ff_256x240.png'}
			});
			$('div.addGroup button.addButton').click( function() {
				addGroup();
			});
			$('div.addGroup input[name="newGroupName"]').focus( function() {
				$(this).removeAttr('value');
			});
			$('div.addGroup input[name="newGroupName"]').blur( function() {
				if( !$(this).attr('value'))
					$(this).attr('value', groupDefaultValue );
			});
			$('div.addGroup input[name="newGroupName"]').keypress( function( event )
			{
				if( event.which == '13' )
				{
					addGroup();
					$(this).val('');
				}
			});
			$('#nextPhaseButton button[type="submit"]').button().click( function( event )
			{
				event.preventDefault();
				if( !alreadyPosted )
				{
					alreadyPosted = true;
					var groups = $('div.playerList');
					var dataString = "phase=4";
					var groupIndex = 0;
					var userIndex = 0;
					$(groups).each( function() 
					{
						var groupName = $('p', $(this)).text();
						dataString += "&groupName" + groupIndex + "=" + groupName;
						var rows = $('tbody tr', $(this));
						$(rows).each( function()
						{
							var username = $('td.firstColumn', $(this)).text();
							dataString += "&" + username + "=" + groupName;
							userIndex++;
						});
						if( rows.length )
							groupIndex++;
					});
					dataString += "&numberOfGroups=" + groupIndex + "&usingAjax=true";
					var url = "./backend/savePlanGroups.php";
					var dataToSend = dataString;
					var typeOfDataToReceive = 'html';
					var callback = function( response ) {
						$("#wrapper").html( response );
					};
					$.post( url, dataToSend, callback, typeOfDataToReceive );
				}
			});
			
			function checkGroupName( currentGroupName, currentDiv )
			{
				if( currentGroupName == groupDefaultValue )
					return "No value inserted.";
				var result = "";
				var groups = $('div.playerList').not( currentDiv );
				$(groups).each( function() 
				{
					var groupName = $('p', $(this)).text();
					if( groupName == currentGroupName )
					{
						result = "<? echo $TEXT['newGamePhase4-span_1']; ?>";
						return ;
					}
				});
				return result;
			}
		});
	})(jQuery);
</script>
