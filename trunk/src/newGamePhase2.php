<? include "newGameBar.php"; ?>
<div id="divPhase2" class="phases">
	<p>Now choose the wedge that will be part of the game: in this part of the game every group of player is assigned a wedge, has to solve a problem linked to the wedge, and has to summarize in a poster the pros and cons of the wedge</p>
	<form
		name="phase2Form"
		action="./createNewGame.php"
		method="POST"
	>
		<input type="hidden" name="usingAjax" value="false" />
		<input type="hidden" name="phase" value="<? echo ( $phaseNumber + 1 ); ?>" />
		<input type="hidden" 
			   name="wedgesSelected"
<?
	if( isSet( $_SESSION['phase2'] ))
		echo "value=\"".$_SESSION['phase2']['wedgesSelected']."\" ";
	else
		echo "value=\"0\""
?> 		
		/>
	<table>
	<tbody>
		<tr>
			<td>
				<div id="selectingButton">
					<a id="selectAll" class="link">Select all</a>
					<a id="deselectAll" class="link">Deselect all</a>
				</div>
				<ol id="selectable">
<? 
	$query = "SELECT `Wedge ID` as id, Title ". 
			 "FROM Wedges ".
			 "WHERE Language='$lang'";
	$data = mysql_query( $query, $connection );
	
	$counter = 0;
	while( $wedge = mysql_fetch_array( $data )) 
	{
		$wedges[$counter] = array(  'id' 		=> $wedge['id'],
									'Title' 	=> $wedge['Title'] );
		$counter++;
	}
	
	$vector = generateRandomSequence( 0, $counter );
	$index = 0;
	while( $counter > 0 )
	{
		$wedge = $wedges[$vector[$index]];
?>
					<li class="ui-corner-all 
<?
		if( isSet( $_SESSION['phase2'] )&& $_SESSION['phase2']['wedge'.$wedge['id']] )
			echo "ui-selected \">";
		else
			echo "ui-selectee \">";
?>					
						<input 
							type="checkbox"
							name="wedge<? echo $index; ?>"
							value="<? echo $wedge['id']; ?>" 
							class="ui-helper-hidden-accessible" 
<?
		if( isSet( $_SESSION['phase2'] )&& $_SESSION['phase2']['wedge'.$wedge['id']] )
			echo "checked";
?>			
						/>
						<? echo $wedge['Title']; ?>
					</li>
<?
		$counter--;
		$index++;
	}
?>
				</ol>
			</td>
		</tr>
	</tbody>					
	<tfoot>
		<tr>
			<td colspan="2">
				<button type="submit" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" >
					<span class="ui-button-text">I'm done with wedges!</span>
				</button>
			</td>
		</tr>
	</tfoot>					
	</table>				
	</form>				
	</div>
</div>
<script type="text/javascript">
(function($) {
	$(document).ready( function() 
	{
		$('#divPhase2 form').submit( function( event )
		{
			event.preventDefault();
			$('input[name="usingAjax"]', this ).val('true');
			var checkbox = $('input[type="checkbox"]');
			for( var index = 0, counter = 0; index < checkbox.length; index++ )
			{
				if( $(checkbox[index]).attr('checked'))
				{
					$(checkbox[index]).attr('name', 'wedge' + counter );
					counter++;
				}
			}
			var $this = $(this);
			var url = $this.attr('action');
			var formName = $this.attr('name');
			var dataToSend = $this.serialize();
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
		
		$('#selectable li').click( function() 
		{
			var wedgesSelected = $('#divPhase2 form input[name="wedgesSelected"]').val();
			$(this).toggleClass('ui-selected ui-selectee');
			var checkbox = $('input[type="checkbox"]', this );
			if( $(checkbox).attr('checked'))
			{
				$(checkbox).removeAttr('checked');
				$('#divPhase2 form input[name="wedgesSelected"]').val( --wedgesSelected );
			}
			else
			{
				$(checkbox).attr('checked', true );
				$('#divPhase2 form input[name="wedgesSelected"]').val( ++wedgesSelected );
			}
		});
		
		$('#selectAll').click( function() 
		{
			var elements = $('#selectable li');
			$(elements).removeClass('ui-selectee');
			$(elements).addClass('ui-selected');
			$('input[type="checkbox"]', $(elements)).attr('checked', true );
			$('#divPhase2 form input[name="wedgesSelected"]').val( elements.length );
		});
		
		$('#deselectAll').click( function() 
		{
			var elements = $('#selectable li');
			$(elements).removeClass('ui-selected');
			$(elements).addClass('ui-selectee');
			$('input[type="checkbox"]', $(elements)).removeAttr('checked');
			$('#divPhase2 form input[name="wedgesSelected"]').val('0');
		});
	});
})(jQuery);
</script>