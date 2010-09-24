<? include "newGameBar.php"; ?>
<div id="divPhase1" class="phase1 phases">
	<p><? echo $TEXT['newGamePhase1-p_1']; ?></p>
	<form
		name="phase1Form"
		action="./createNewGame.php"
		method="POST"
	>
		<input type="hidden" name="usingAjax" value="false" />
		<input type="hidden" name="destinationPhase" value="<? echo ( $_SESSION['phaseNumber'] + 1 ); ?>" />
		<input type="hidden" name="comingPhase" value="<? echo $_SESSION['phaseNumber']; ?>" />
	<table class="tablePhase1_2">
	<tbody>
		<tr>
			<td class="firstCol">
				<h1><? echo $TEXT['newGamePhase1-h_1']; ?></h1>
				<p></p>
				<br />
				<div id="slider1" class="slider">
					<p><strong></strong></p>
					<input type="hidden" name="time1" value="" />
				</div>
				<br />
<?
	if( isSet( $_SESSION['phase1'] ) && $_SESSION['phase1']['time2'] )
	{			
?>
				<div id="advancedButton">
					<a class="link"><? echo $TEXT['newGamePhase1-a_1']; ?></a>
					<input type="hidden" name="advanced" value="true" />
				</div>
<?	
	}
	else {
?>
				<div id="advancedButton">
					<a class="link"><? echo $TEXT['newGamePhase1-a_2']; ?></a>
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
					<p><? echo $TEXT['newGamePhase1-p_2']; ?></p>
					<div id="slider2" class="slider">
						<p><strong></strong></p>
						<input type="hidden" name="time2" value="" />
					</div>
					<br />
					<p><? echo $TEXT['newGamePhase1-p_3']; ?></p>
					<div id="slider3" class="slider">
						<p><strong></strong></p>
						<input type="hidden" name="time3" value="" />
					</div>
				</div>
			</td>
			<td class="secondCol">
				<h1><? echo $TEXT['newGamePhase1-h_2']; ?></h1>
				<p><? echo $TEXT['newGamePhase1-p_4']; ?></p>
			</td>
		</tr>
		<tr>
			<td class="firstCol">
				<h1><? echo $TEXT['newGamePhase1-h_3']; ?></h1>
				<p><? echo $TEXT['newGamePhase1-p_5']; ?></p>
				<div id="slider4" class="slider">
					<p><strong></strong></p>
					<input type="hidden" name="time4" value="" />
				</div>
			</td>
			<td class="secondCol">
				<h1><? echo $TEXT['newGamePhase1-h_2']; ?></h1>
				<p><? echo $TEXT['newGamePhase1-p_6']; ?></p>
			</td>
		</tr>
		<tr>
			<td class="firstCol">
				<h1><? echo $TEXT['newGamePhase1-h_5']; ?></h1>
				<p></p>
				<br />
				<div id="slider5" class="slider">
					<p><strong></strong></p>
					<input type="hidden" name="time5" value="" />
				</div>
			</td>
			<td class="secondCol">
				<h1><? echo $TEXT['newGamePhase1-h_2']; ?></h1>
				<p><? echo $TEXT['newGamePhase1-p_7']; ?></p>
			</td>
		</tr>
	</tbody>					
	</table>					
	<div id="nextPhaseButton">
		<button type="button"><? echo $TEXT['newGamePhase1-button_1']; ?></button>
	</div>
	</form>
</div>
<script type="text/javascript">
(function($) {
	$(document).ready( function() 
	{

		var slider = $('div.slider');
		$(slider).each( function()
		{
			switch( $(this).attr('id'))
			{
				case "slider1":
					minValue = 10;
					maxValue = 100;
					sliderValue =
<?	
	if( isSet( $_SESSION['phase1'] ))
		echo $_SESSION['phase1']['time1']."; ";
	else
		echo "55; ";
?>			
					break;
				case "slider2":
					minValue = 5;
					maxValue = 50;
					sliderValue =
<?	
	if( isSet( $_SESSION['phase1'] ) && $_SESSION['phase1']['time2'] )
		echo $_SESSION['phase1']['time2']."; ";
	else
		echo "25; ";
?>				
					break;
				case "slider3":
					minValue = 5;
					maxValue = 50;
					sliderValue =
<?	
	if( isSet( $_SESSION['phase1'] ) && $_SESSION['phase1']['time2'] )
		echo $_SESSION['phase1']['time3']."; ";
	else
		echo "25; ";
?>			
					break;
				case "slider4":
					minValue = 1;
					maxValue = 10;
					sliderValue =
<?	
	if( isSet( $_SESSION['phase1'] ))
		echo $_SESSION['phase1']['time4']."; ";
	else
		echo "5; ";
?>				
					break;
				case "slider5":
					minValue = 10;
					maxValue = 300;
					sliderValue =
<?	
	if( isSet( $_SESSION['phase1'] ))
		echo $_SESSION['phase1']['time5']."; ";
	else
		echo "150; ";
?>					
					break;
			}
			$(this).slider({
				range: "min",
				value: sliderValue,
				min: minValue,
				max: maxValue,
				slide: function( event, ui ) {
					$('p strong', $(this)).text( ui.value + ' min');
					$('input[type="hidden"]', $(this)).attr("value", ui.value );
				}
			});
		});
		
		$('p strong', $(slider)).each( function() {
			$(this).text( $(this).parents('div.slider').slider("value") + ' min' );
		});
		$('input[type="hidden"]', $(slider)).each( function(){
			$(this).attr("value", $(this).parents('div.slider').slider("value"));
		});
		
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
		
		$('#nextPhaseButton button').button().click( function( event )
		{
			event.preventDefault();
			var form = $('#divPhase1 form');
			$('input[name="usingAjax"]', $(form)).val('true');
			var url = $(form).attr('action');
			var formName = $(form).attr('name');
			var dataToSend = $(form).serialize();
			var typeOfDataToReceive = 'html';
			var callback = function( response ) {
				$("#wrapper").html( response );
			};
			$.post( url, dataToSend, callback, typeOfDataToReceive );	
		});
	});
})(jQuery);
</script>