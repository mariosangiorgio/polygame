<? include "newGameBar.php"; ?>
<div id="divPhase1" class="phases">
	<p>As a first thing you should decide the timing for the three phases of the game</p>
	<form
		name="phase1Form"
		action="./createNewGame.php"
		method="POST"
	>
		<input type="hidden" name="usingAjax" value="false" />
		<input type="hidden" name="phase" value="<? echo ( $_SESSION['phaseNumber'] + 1 ); ?>" />
	<table class="phaseTable">
	<tbody>
		<tr>
			<td class="firstCol">
				<h1>First phase: learn about a wedge</h1>
				<p></p>
				<br />
				<div id="slider1">
					<p><strong></strong></p>
					<input type="hidden" name="time1" value="" />
				</div>
				<br />
<?
	if( isSet( $_SESSION['phase1'] ) && $_SESSION['phase1']['time2'] )
	{			
?>
				<div id="advancedButton">
					<a class="link">Basic options</a>
					<input type="hidden" name="advanced" value="true" />
				</div>
<?	
	}
	else {
?>
				<div id="advancedButton">
					<a class="link">Advanced options</a>
					<input type="hidden" name="advanced" value="false" />
				</div>
<?
	}
?>				
				<div id="advancedOptions" 
<?
	if( isSet( $_SESSION['phase1'] ) && $_SESSION['phase1']['time2'] )
		echo "style=\"display:block\" ";
?>				
				>
					<p>Time before complete wedge information is shown to players</p>
					<div id="slider2">
						<p><strong></strong></p>
						<input type="hidden" name="time2" value="" />
					</div>
					<br />
					<p>Time before it is possible to submit a solution to the problem players have to solve</p>
					<div id="slider3">
						<p><strong></strong></p>
						<input type="hidden" name="time3" value="" />
					</div>
				</div>
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
					<input type="hidden" name="time4" value="" />
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
					<input type="hidden" name="time5" value="" />
				</div>
			</td>
			<td class="secondCol">
				<h1>What happens during this phase?</h1>
				<p>In this part new groups are created and they have to come up with a plan including the studied wedges Votations will follow</p>
			</td>
		</tr>
	</tbody>					
	</table>					
	<div id="nextPhaseButton">
		<button type="submit" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" >
			<span class="ui-button-text">I'm done with durations!</span>
		</button>
	</div>
	</form>
</div>
<script type="text/javascript">
(function($) {
	$(document).ready( function() 
	{
		$("#slider1").slider({
			range: "min",
			value: 
<?	
	if( isSet( $_SESSION['phase1'] ))
		echo $_SESSION['phase1']['time1'].", ";
	else
		echo "55, ";
?>
			min: 10,
			max: 100,
			slide: function(event, ui) {
				$('#slider1 p strong').text( ui.value + ' min');
				$('#slider1 input[type="hidden"]').attr("value", ui.value );
			}
		});
		$("#slider2").slider({
			range: "min",
			value: 
<?	
	if( isSet( $_SESSION['phase1'] ) && $_SESSION['phase1']['time2'] )
		echo $_SESSION['phase1']['time2'].", ";
	else
		echo "25, ";
?>
			min: 5,
			max: 50,
			slide: function(event, ui) {
				$('#slider2 p strong').text( ui.value + ' min');
				$('#slider2 input[type="hidden"]').attr("value", ui.value );
			}
		});
		$("#slider3").slider({
			range: "min",
			value: 
<?	
	if( isSet( $_SESSION['phase1'] ) && $_SESSION['phase1']['time2'] )
		echo $_SESSION['phase1']['time3'].", ";
	else
		echo "25, ";
?>
			min: 5,
			max: 50,
			slide: function(event, ui) {
				$('#slider3 p strong').text( ui.value + ' min');
				$('#slider3 input[type="hidden"]').attr("value", ui.value );
			}
		});
		$("#slider4").slider({
			range: "min",
			value: 
<?	
	if( isSet( $_SESSION['phase1'] ))
		echo $_SESSION['phase1']['time4'].", ";
	else
		echo "5, ";
?>			
			min: 1,
			max: 10,
			slide: function(event, ui) {
				$('#slider4 p strong').text( ui.value + ' min');
				$('#slider4 input[type="hidden"]').attr("value", ui.value );
			}
		});
		$("#slider5").slider({
			range: "min",
			value:
<?	
	if( isSet( $_SESSION['phase1'] ))
		echo $_SESSION['phase1']['time5'].", ";
	else
		echo "150, ";
?>			
			min: 10,
			max: 300,
			slide: function(event, ui) {
				$('#slider5 p strong').text( ui.value + ' min');
				$('#slider5 input[type="hidden"]').attr("value", ui.value );
			}
		});
		
		$('#slider1 p strong').text( $('#slider1').slider("value") + ' min' );
		$('#slider1 input[type="hidden"]').attr("value", $('#slider1').slider("value"));
		$('#slider2 p strong').text( $('#slider2').slider("value") + ' min' );
		$('#slider2 input[type="hidden"]').attr("value", $('#slider2').slider("value"));
		$('#slider3 p strong').text( $('#slider3').slider("value") + ' min' );
		$('#slider3 input[type="hidden"]').attr("value", $('#slider3').slider("value"));
		$('#slider4 p strong').text( $('#slider4').slider("value") + ' min' );
		$('#slider4 input[type="hidden"]').attr("value", $('#slider4').slider("value"));
		$('#slider5 p strong').text( $('#slider5').slider("value") + ' min' );
		$('#slider5 input[type="hidden"]').attr("value", $('#slider5').slider("value"));

		$('#advancedButton a').click( function() {
			if( $('#advancedOptions').css('display') == 'none' )
			{
				$('#advancedButton a').text("Basic options");	
				$('#advancedButton input[type="hidden"]').attr("value", "true");
				$('#advancedOptions').show('blind');
			}
			else
			{			
				$('#advancedButton a').text("Advanced options");	
				$('#advancedButton input[type="hidden"]').attr("value", "false");
				$('#advancedOptions').hide('blind');
			}
		});
		
		$('#divPhase1 form').submit( function( event )
		{
			event.preventDefault();
			$('input[name="usingAjax"]', this ).val('true');
			var $this = $(this);
			var url = $this.attr('action');
			var formName = $this.attr('name');
			var dataToSend = $this.serialize();
			var typeOfDataToReceive = 'html';
			var callback = function( response ) {
				$("#wrapper").html( response );
			};
			
			$.post( url, dataToSend, callback, typeOfDataToReceive );	
		});
	});
})(jQuery);
</script>