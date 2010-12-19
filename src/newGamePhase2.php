<? include "newGameBar.php"; ?>
<div id="divPhase2" class="phase2 phases">
	<p><? echo $TEXT['newGamePhase2-p_1']; ?></p>
	<form
		name="phase2Form"
		action="./createNewGame.php"
		method="POST"
	>
		<input type="hidden" name="usingAjax" value="false" />
		<input type="hidden" name="destinationPhase" value="<? echo ( $_SESSION['phaseNumber'] + 1 ); ?>" />
		<input type="hidden" name="comingPhase" value="<? echo $_SESSION['phaseNumber']; ?>" />
		<input type="hidden" 
			   name="wedgesSelected"
<?
	if( isSet( $_SESSION['phase2'] ))
		echo "value=\"".$_SESSION['phase2']['wedgesSelected']."\" ";
	else
		echo "value=\"0\""
?> 		
		/>
	<table class="tablePhase1_2">
	<tbody>
		<tr>
			<td>
				<div id="selectingButton">
					<a id="selectAll" class="link"><? echo $TEXT['newGamePhase2-a_1']; ?></a>
					<a id="deselectAll" class="link"><? echo $TEXT['newGamePhase2-a_2']; ?></a>
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
	
	$vector = generateRandomSequence( 0, $counter - 1 );
	$index = 0;
	while( $counter > 0 )
	{
		$wedge = $wedges[$vector[$index]];
?>
					<li
<?
		if( isSet( $_SESSION['phase2'] )&& $_SESSION['phase2']['wedges']['wedge'.$wedge['id']] )
			echo "class=\"ui-corner-all ui-selected\"";
		else
			echo "class=\"ui-corner-all ui-selectee\"";
?>					
					>
						<input 
							type="checkbox"
							name="wedge<? echo $index; ?>"
							value="<? echo $wedge['id']; ?>" 
							class="ui-helper-hidden-accessible" 
<?
		if( isSet( $_SESSION['phase2'] )&& $_SESSION['phase2']['wedges']['wedge'.$wedge['id']] )
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
		<tr>
			<td>
				<div class="errorClass ui-corner-all">
					<span class="ui-icon ui-icon-info"></span>
					<strong></strong>
				</div>
			</td>
		</tr>
	</tbody>									
	</table>				
	<div id="nextPhaseButton">
		<button type="button"><? echo $TEXT['newGamePhase2-button_1']; ?></button>
	</div>
	</form>				
	</div>
</div>
<script type="text/javascript">
(function($) {
	$(document).ready( function() 
	{
		$('#nextPhaseButton button').button().click( function( event )
		{
			event.preventDefault();
			var form = $('#divPhase2 form');
			$('input[name="usingAjax"]', $(form)).val('true');
			var checkboxes = $('input[type="checkbox"]');
			var counter = 0;
			$(checkboxes).each( function() 
			{
				if( $(this).attr('checked'))
				{
					$(this).attr('name', 'wedge' + counter );
					counter++;
				}
			});
			if( counter )
			{
				var url = $(form).attr('action');
				var formName = $(form).attr('name');
				var dataToSend = $(form).serialize();
				var typeOfDataToReceive = 'html';
				var callback = function( response ) {
					$("#wrapper").html( response );
				};
				$.post( url, dataToSend, callback, typeOfDataToReceive );
			}
			else
			{
				$('table.tablePhase1_2 div.errorClass strong').text("<? echo $TEXT['newGamePhase2-error_1']; ?>");
				$('table.tablePhase1_2 div.errorClass:hidden').slideDown();
			}			
		});
		
		$('#selectable li').click( function() 
		{
			var wedgesSelected = $('#divPhase2 form input[name="wedgesSelected"]').val();
			$(this).toggleClass('ui-selected ui-selectee');
			$('table.tablePhase1_2 div.errorClass:visible').slideUp();
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
			$('table.tablePhase1_2 div.errorClass:visible').slideUp();
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