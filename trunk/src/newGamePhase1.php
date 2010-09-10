<div id="divPhase1">
	<p>As a first thing you should decide the timing for the three phases of the game</p>
	<table>
	<tbody>
		<tr>
			<td class="firstCol">
				<h1>First phase: learn about a wedge</h1>
				<p></p>
				<br />
				<div id="slider1">
					<p><strong></strong></p>
				</div>
				<br />
				<div id="advancedButton">
					<a>Advanced options</a>
				</div>
				<div id="advancedOptions">
					<p>Time before complete wedge information is shown to players</p>
					<div id="slider2">
						<p><strong></strong></p>
					</div>
					<br />
					<p>Time before it is possible to submit a solution to the problem players have to solve</p>
					<div id="slider3">
						<p><strong></strong></p>
					</div>
				</span>
			</td>
			<td class="secondCol">
				<h1>What happens during this phase?</h1>
				<p>In this part of the game every group of player is assigned a wedge, has to solve a problem linked to the wedge, and has to summarize in a poster the pros and cons of the wedge</p>
			</td>
		</tr>
		<tr>
			<td class="firstCol">
				<h1>Show and tell</h1>
				<p>Pick the time for a single presentation</p>
				<div id="slider4">
					<p><strong></strong></p>
				</div>
			</td>
			<td class="secondCol">
				<h1>What happens during this phase?</h1>
				<p>In this part of the game every group presents the poster prepared in the previous phase</p>
			</td>
		</tr>
		<tr>
			<td class="firstCol">
				<h1>Discuss and plan</h1>
				<p></p>
				<br />
				<div id="slider5">
					<p><strong></strong></p>
				</div>
			</td>
			<td class="secondCol">
				<h1>What happens during this phase?</h1>
				<p>In this part new groups are created and they have to come up with a plan including the studied wedges Votations will follow</p>
			</td>
		</tr>
	</tbody>					
	<tfoot>
		<tr>
			<td colspan="2">
				<button id="forwardButton" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" >
					<span class="ui-button-text">I'm done with durations!</span>
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
					$("#phases").html( response );
					$('#organizerBar label[for="phase<? echo $phaseNumber; ?>"]').removeClass('ui-state-active');
					$('#organizerBar label[for="phase<? echo ( $phaseNumber + 1 ); ?>"]').addClass('ui-state-active');
				},
				error: function( xhr, textStatus, errorThrown ) 
				{
					// TODO: catch error states
				}
			});
		
		});
	});
</script>