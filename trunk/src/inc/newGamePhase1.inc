<? 
	$query = "SELECT `Length 1` as l1, `Length 1a` as l1a, ".
					"`Length 1b` as l1b, `Length 1c` as l1c, ".
					"`Length 2` as l2, `Length 3` as l3, Advanced ".
			"FROM `game` WHERE `Game ID`='".$game['gameID']."';";
	$result = mysql_query( $query, $connection );
	$row = mysql_fetch_array( $result );
?>
<div id="divPhase1" class="phase1 phases">
	<p><? echo $TEXT['newGamePhase1-p_1']; ?></p>
	<form
		name="phase1Form"
		action="./backend/saveTimings.php"
		method="POST"
	>
		<input type="hidden" name="phase" value="<? echo $currentPhase; ?>" />
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
					<div id="advancedButton">
	<?
		if( $row['Advanced'] )
		{			
	?>
						<a class="link"><? echo $TEXT['newGamePhase1-a_1']; ?></a>
						<input type="hidden" name="advanced" value="true" />
	<?	
		}
		else {
	?>
						<a class="link"><? echo $TEXT['newGamePhase1-a_2']; ?></a>
						<input type="hidden" name="advanced" value="false" />
	<?
		}
	?>				
					</div>
					<div id="advancedOptions" 
	<?
		if( $row['Advanced'] )
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
						<p><? echo $TEXT['newGamePhase1-p_8']; ?></p>
						<div id="slider4" class="slider">
							<p><strong></strong></p>
							<input type="hidden" name="time4" value="" />
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
					<div id="slider5" class="slider">
						<p><strong></strong></p>
						<input type="hidden" name="time5" value="" />
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
					<div id="slider6" class="slider">
						<p><strong></strong></p>
						<input type="hidden" name="time6" value="" />
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
					maxValue = 180;
					sliderValue = <? echo $row['l1'].";"; ?>
					break;
				case "slider2":
					minValue = 0;
					maxValue = 30;
					sliderValue = <? echo $row['l1a'].";"; ?>
					break;
				case "slider3":
					minValue = 0;
					maxValue = 30;
					sliderValue = <? echo $row['l1b'].";"; ?>
					break;
				case "slider4":
					minValue = 0;
					maxValue = 30;
					sliderValue = <? echo $row['l1c'].";"; ?>
					break;
				case "slider5":
					minValue = 1;
					maxValue = 20;
					sliderValue = <? echo $row['l2'].";"; ?>
					break;
				case "slider6":
					minValue = 10;
					maxValue = 300;
					sliderValue = <? echo $row['l3'].";"; ?>
					break;
			}
			$(this).slider({
				range: "min",
				value: sliderValue,
				min: minValue,
				max: maxValue,
				slide: function( event, ui ) 
				{
					$('p strong', $(this)).text( ui.value + ' min');
					$('input[type="hidden"]', $(this)).attr("value", ui.value );
				}
			});
		});
		
		$('#slider1').bind("slide", function( event, ui )
		{
			var time1 = ui.value;
			var time2 = $('#slider2').slider("value");
			var time3 = $('#slider3').slider("value");
					
			if( time1 < time2 + time3 )
			{			
				var delta = Math.ceil((( time2 + time3 ) - time1 ) / 2 );
				$('#slider2').slider("value", time2 - delta );
				$('#slider2 p strong').text( time2 - delta + ' min');
				$('#slider2 input[type="hidden"]').attr("value", time2 - delta );
				
				$('#slider3').slider("value", ( ui.value - ( time2 - delta )));
				$('#slider3 p strong').text(( ui.value - ( time2 - delta )) + ' min');
				$('#slider3 input[type="hidden"]').attr("value", ( ui.value - ( time2 - delta )));
			}
		});
		$('#slider2').bind("slide", function( event, ui )
		{
			var time1 = $('#slider1').slider("value");
			var time2 = ui.value;
			var time3 = $('#slider3').slider("value");
					
			if( time1 < time2 + time3 )
			{			
				$('#slider3').slider("value", time1 - time2 );
				$('#slider3 p strong').text( time1 - time2 + ' min');
				$('#slider3 input[type="hidden"]').attr("value", time1 - time2 );
			}
		});
		$('#slider3').bind("slide", function( event, ui )
		{
			var time1 = $('#slider1').slider("value");
			var time2 = $('#slider2').slider("value");
			var time3 = ui.value;
			if( time1 < time2 + time3 )
			{			
				$('#slider2').slider("value", time1 - time3 );
				$('#slider2 p strong').text( time1 - time3 + ' min');
				$('#slider2 input[type="hidden"]').attr("value", time1 - time3 );
			}
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
			var url = $(form).attr('action');
			var formName = $(form).attr('name');
			var dataToSend = $(form).serialize() + "&usingAjax=true";
			var typeOfDataToReceive = 'html';
			var callback = function( response ) {
				$("#wrapper").html( response );
			};
			$.post( url, dataToSend, callback, typeOfDataToReceive );	
		});
	});
})(jQuery);
</script>
