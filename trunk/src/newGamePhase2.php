<div id="divPhase2">
	<p>Now choose the wedge that will be part of the game: in this part of the game every group of player is assigned a wedge, has to solve a problem linked to the wedge, and has to summarize in a poster the pros and cons of the wedge</p>
	<table>
	<tbody>
		<tr>
			<td>
				<ul>
<? 
	$query = "SELECT `Wedge ID` as id, Title ". 
			 "FROM Wedges ".
			 "WHERE Language='$lang'";
	$data = mysql_query( $query, $connection );
	
	$counter = 0;
	while( $wedge = mysql_fetch_array( $data )) 
	{
		$wedges[$counter] = array(  'Id' 		=> $wedge['id'],
									'Title' 	=> $wedge['Title'] );
		$counter++;
	}
	
	$vector = generateRandomSequence( 0, $counter );
	$index = 0;
	while( $counter > 0 )
	{
		$wedge = $wedges[$vector[$index]];
?>
					<li><? echo $wedges[$vector[$index]]['Title']; ?></li>
<?
		$counter--;
		$index++;
	}
?>
				</ul>
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
	$(function() {
		$("#slider1").slider({
			range: "min",
			value: 55,
			min: 10,
			max: 100,
			slide: function(event, ui) {
				$("#slider1 p strong").text( ui.value + ' min');
			}
		});
		$("#slider2").slider({
			range: "min",
			value: 25,
			min: 5,
			max: 50,
			slide: function(event, ui) {
				$("#slider2 p strong").text( ui.value + ' min');
			}
		});
		$("#slider3").slider({
			range: "min",
			value: 25,
			min: 5,
			max: 50,
			slide: function(event, ui) {
				$("#slider3 p strong").text( ui.value + ' min');
			}
		});
		$("#slider4").slider({
			range: "min",
			value: 5,
			min: 1,
			max: 10,
			slide: function(event, ui) {
				$("#slider4 p strong").text( ui.value + ' min');
			}
		});
		$("#slider5").slider({
			range: "min",
			value: 150,
			min: 10,
			max: 300,
			slide: function(event, ui) {
				$("#slider5 p strong").text( ui.value + ' min');
			}
		});
		$("#slider1 p strong").text( $("#slider1").slider("value") + ' min' );
		$("#slider2 p strong").text( $("#slider2").slider("value") + ' min' );
		$("#slider3 p strong").text( $("#slider3").slider("value") + ' min' );
		$("#slider4 p strong").text( $("#slider4").slider("value") + ' min' );
		$("#slider5 p strong").text( $("#slider5").slider("value") + ' min' );

		$('#advancedButton a').click( function() {
			if( $('#advancedOptions').css('display') == 'none' )
			{
				$('#advancedButton a').text("Basic options");	
				$('#advancedOptions').show('blind');
			}
			else
			{			
				$('#advancedButton a').text("Advanced options");	
				$('#advancedOptions').hide('blind');
			}
		});
		
		$('#forwardButton').click( function() 
		{
			$.ajax({
				type: 'GET',
				url: './createNewGame.php',
				data: { phase: '<? echo ( $phaseNumber + 1 ); ?>',
						usingAjax: 'true' },
				dataType: 'html',
				success: function( response ) 
				{
					$("#phases").replaceWith( response );
				},
				error: function( xhr, textStatus, errorThrown ) 
				{
					// TODO: catch error states
				}
			});
		
		});
	});
</script>