<div id="divPhase2">
	<p>Now choose the wedge that will be part of the game: in this part of the game every group of player is assigned a wedge, has to solve a problem linked to the wedge, and has to summarize in a poster the pros and cons of the wedge</p>
	<form
		name="phase12Form"
		action="./createNewGame.php"
		method="POST"
	>
		<input type="hidden" name="usingAjax" value="false" />
		<input type="hidden" name="phase" value="<? echo ( $phaseNumber + 1 ); ?>" />
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
					<li class="ui-corner-all ui-selectee">
						<input type="hidden" name="<? echo $wedges[$vector[$index]]['id']; ?>" value="false" />
						<? echo $wedges[$vector[$index]]['Title']; ?>
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
				<button id="forwardButton" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" >
					<span class="ui-button-text">I'm done with first phase!</span>
				</button>
			</td>
		</tr>
	</tfoot>					
	</table>					
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
			var $this = $(this);
			var url = $this.attr('action');
			var formName = $this.attr('name');
			var dataToSend = $this.serialize();
			var typeOfDataToReceive = 'html';
			var callback = function( response )
			{
				$("#phases").html( response );
				$('#organizerBar label[for="phase<? echo $phaseNumber; ?>"]').removeClass('ui-state-active');
				$('#organizerBar label[for="phase<? echo ( $phaseNumber + 1 ); ?>"]').addClass('ui-state-active');
				$('#organizerBar label[for="phase<? echo ( $phaseNumber + 1 ); ?>"]').toggleClass('unreachable reachable');
			};
			
			$.post( url, dataToSend, callback, typeOfDataToReceive );	
		});
		
		$('#selectable li').click( function() {
			$(this).toggleClass('ui-selected ui-selectee');
			if( $('input[type="hidden"]', this ).attr('value') == "true" )
				 $('input[type="hidden"]', this ).val("false");
			else
				 $('input[type="hidden"]', this ).val("true");
		});
		
		$('#selectAll').click( function() {
			$('#selectable li').removeClass('ui-selectee');
			$('#selectable li').addClass('ui-selected');
			$('#selectable li input[type="hidden"]').val("true");
		});
		
		$('#deselectAll').click( function() {
			$('#selectable li').removeClass('ui-selected');
			$('#selectable li').addClass('ui-selectee');
			$('#selectable li input[type="hidden"]').val("false");
		});
	});
})(jQuery);
</script>