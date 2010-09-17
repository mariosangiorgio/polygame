<? include "newGameBar.php"; ?>
<div id="divPhase4" class="phase4 phases">
	<form
		name="phase4Form"
		action="./createNewGame.php"
		method="POST"
	>
		<input type="hidden" name="usingAjax" value="false" />
		<input type="hidden" name="phase" value="<? echo ( $_SESSION['phaseNumber'] + 1 ); ?>" />
<?
	if( isSet( $_SESSION['phase3'] ))
	{
		$vector = generateRandomSequence( 0, $_SESSION['phase3']['numberOfUsers'] - 1 );
		$userPerGroup = intval( $_SESSION['phase3']['numberOfUsers'] / $_SESSION['phase2']['wedgesSelected'] );
		$remainingUsers = $_SESSION['phase3']['numberOfUsers'] % $_SESSION['phase2']['wedgesSelected'];
		$userIndex = 0;
		for( $index = 0; $index < $_SESSION['phase2']['wedgesSelected']; $index++ )
		{
			
?>
	<div class="playerList ui-corner-all">
		<p>Group<? echo ( $index + 1 ); ?></p>
		<table class="playerTable">
		<tbody>
<?			
			for( $counter = 0; $counter < $userPerGroup; $counter++ )
			{
?>
			<tr>
				<td class="firstColumn"><? echo $_SESSION['phase3']['user'][$vector[$userIndex]]['username']; ?></td>
				<td class="secondColumn"><button type="button" class="movePlayer" >Move to...</button></td>
			</tr>
<?
				$userIndex++;
			}
			if( $remainingUsers > 0 )
			{
?>			
			<tr>
				<td class="firstColumn"><? echo $_SESSION['phase3']['user'][$vector[$userIndex]]['username']; ?></td>
				<td class="secondColumn"><button type="button" class="movePlayer" >Move to...</button></td>
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
					<input type="text"  size="40" value="Insert the new group here..." name="newGroupName" />
				</td>			
				<td class="secondColumn">
					<button type="button" class="addPlayer" >Add</button>
				</td>
			</tr>
		</tbody>
		</table>
	</div>
	<div id="nextPhaseButton">
		<button type="submit">I'm done with second phase!</button>
	</div>
	</form>
</div>
<script type="text/javascript">
	(function($) {
		$(document).ready( function() 
		{
			var moveButton = "<button type=\"button\" class=\"movePlayer\" >Move to...</button>";
			var groupDefaultValue = "Insert the new group here...";
			
			var generateGroupsList = function( row ) 
			{
				var currentGroup = $(row).parents('div.playerList').find('p').text();
				var groups = $('div.playerList p');
				var groupsDiv = "<div class=\"groupsList\">";
				$(groups).each( function() {
					if( $(this).text() != currentGroup )
						groupsDiv += "<button type=\"button\" class=\"movePlayer\">" + $(this).text() + "</button>";
				});
				groupsDiv += "</div>";
				$('td.secondColumn', $(row)).append( groupsDiv );
				$('td.secondColumn button.movePlayer', $(row)).button();
				$('td.secondColumn div.groupsList button', $(row)).button().click( function() {
					movePlayer( this );
				});
			}
			
			var movePlayer = function( buttonElement ) 
			{
				var originTable = $(buttonElement).parents('tbody');
				var originGroup = $(originTable).parents('div.playerList').find('p').text();
				var destinationGroup = $(buttonElement).find('span').text();
				var destinationTable = $('div.playerList p:contains("' + destinationGroup + '")').parent().find('tbody');
				$(buttonElement).parents('div.groupsList').hide();
				$(buttonElement).find('span').text( originGroup );

				var username = $(buttonElement).parents('tr').find('td.firstColumn').text();
				var row = "<tr><td class=\"firstColumn\">" + username +
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
			
			$('div.playerList p').click( function()
			{
				var pElement = $(this);
				var groupName = $(this).text();
				$(this).html('<input type="text" name="groupName" value="' + groupName + '" />');
				
				$('input[name="groupName"]', $(this)).focus().blur( function()
				{
					var newGroupName = $(this).val();
					$(pElement).html( newGroupName );
					$('td.secondColumn div.groupsList button span:contains("' + groupName + '")').text( newGroupName );
				});
			});
			
			$('button.movePlayer').each( function() {
				generateGroupsList( $(this).parents('tr'));
			});
			$('table.playerTable tbody td.secondColumn').live('mouseover', function() {
				$('button.movePlayer:first', $(this)).addClass('ui-state-hover');
				$(this).find('div.groupsList:hidden').show();
				return false;
			});
			$('table.playerTable tbody td.secondColumn').live('mouseout', function() {
				$('button.movePlayer:first', $(this)).removeClass('ui-state-hover ui-state-focus');	
				$(this).find('div.groupsList:visible').hide();
				return false;
			});
			$('div.addGroup button.addPlayer').button( {
				icons: { primary: './ui-lightness/images/ui-icons_2e83ff_256x240.png'}
			});
			$('div.addGroup button.addPlayer').click( function()
			{
				var newGroupName = $('div.addGroup input[name="newGroupName"]').val();
				var newGroupDiv = "<div class=\"playerList ui-corner-all\">" + "<p>" + newGroupName + 
								"</p><table class=\"playerTable\"><tbody></tbody></table></div>";
								
				$('div.addGroup').before( newGroupDiv );
				
				var groupsList = $('div.playerList table.playerTable tbody td.secondColumn div.groupsList');
				$(groupsList).each( function() {
					$(this).append('<button type="button" class="movePlayer">' + newGroupName + '</button>');
					$('button.movePlayer:last', $(this)).button().click( function() {
						movePlayer( this );
					});
				});
			});
			$('div.addGroup input[name="newGroupName"]').focus( function() {
				$(this).removeAttr('value');
			});
			$('div.addGroup input[name="newGroupName"]').blur( function() {
				if( !$(this).attr('value'))
					$(this).attr('value', groupDefaultValue );
			});
			$('#nextPhaseButton button[type="submit"]').button().click( function( event )
			{
				event.preventDefault();
				var groups = $('div.playerList');
				var dataString = "usingAjax=true&phase=5";
				var index = 0;
				var numberOfGroups = 0;
				$(groups).each( function() 
				{
					var groupName = $('p', $(this)).text();
					var rows = $('tbody', $(this));
					$(rows).each( function()
					{
						var username = $('td.firstColumn', $(this)).text();
						dataString += "&user" + index + "=" + username + "&group" + index + "=" + groupName;
						index++;
					});
					if( rows.length )
						numberOfGroups++;
				});
				dataString += "&numberOfGroups=" + numberOfGroups;
				var form = $('form[name="phase4Form"]');
				var url = $(form).attr('action');
				var formName = $(form).attr('name');
				var dataToSend = dataString;
				var typeOfDataToReceive = 'html';
				var callback = function( response ) {
					$("#wrapper").html( response );
				};
				$.post( url, dataToSend, callback, typeOfDataToReceive );
			});
		});
	})(jQuery);
</script>