<? 
	$query = "SELECT `Wedge ID` as wedgeID ".
			"FROM `wedge groups` ".
			"WHERE `Game ID`='".$game['gameID']."';";
	$result = mysql_query( $query, $connection );
	$numberOfWedges = mysql_num_rows( $result );
	
	$wedgesSelected = array();
	$counter = 0;
	while(( $row = mysql_fetch_array( $result )))
	{
		$wedgesSelected[$counter] = $row['wedgeID'];
		$counter++;
	}
?>
<div id="divPhase2" class="phase2 phases">
	<p><? echo $TEXT['newGamePhase2-p_1']; ?></p>
	<form
		name="phase2Form"
		action="./backend/saveGameWedges.php"
		method="POST"
	>
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
	$query = "SELECT `Wedge ID` as wedgeID, `Title` ".
			 "FROM `wedges` ".
			 "WHERE `Language`='".$gData['lang']."';";
	$data = mysql_query( $query, $connection );
	
	$wedges = array();
	$counter = 0;
	while(( $wedge = mysql_fetch_array( $data )))
	{
		$wedges[$counter] = $wedge;
		$counter++;
	}
	
	srand((double) microtime() * 1000000);
	shuffle( $wedges );
	
	while( $counter > 0 )
	{
		$counter--;
?>
					<li
<?
		$isSelected = false;
		for( $index = 0; $index < $numberOfWedges && !$isSelected; $index++ )
			if( $wedgesSelected[$index] == $wedges[$counter]['wedgeID'] )
				$isSelected = true;
		
		if( $isSelected )
			echo "class=\"ui-corner-all ui-selected\"";
		else
			echo "class=\"ui-corner-all ui-selectee\"";;
?>					
					>
						<input type="hidden" name="wedge<? echo $index; ?>"	value="<? echo $wedges[$counter]['wedgeID'] ?>" />
						<? echo $wedges[$counter]['Title']; ?>
					</li>
<?
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
			var counter = 0;
			var dataToSend = "";
			$('#selectable li').each( function() 
			{
				if( $(this).attr('class') == "ui-corner-all ui-selected" )
				{
					dataToSend += "wedge" + counter + "=" +
						$('input[type="hidden"]', $(this)).attr('value') + "&";
					counter++;
				}
			});
			if( counter )
			{
				dataToSend += "wedgesSelected=" + counter + 
							"&phase=<? echo $currentPhase; ?>" + "&usingAjax=true";
				var url = $(form).attr('action');
				var formName = $(form).attr('name');
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
			$(this).toggleClass('ui-selected ui-selectee');
			$('table.tablePhase1_2 div.errorClass:visible').slideUp();
		});
		
		$('#selectAll').click( function() 
		{
			var elements = $('#selectable li');
			$(elements).removeClass('ui-selectee');
			$(elements).addClass('ui-selected');
			$('table.tablePhase1_2 div.errorClass:visible').slideUp();
		});
		
		$('#deselectAll').click( function() 
		{
			var elements = $('#selectable li');
			$(elements).removeClass('ui-selected');
			$(elements).addClass('ui-selectee');
		});
	});
})(jQuery);
</script>
