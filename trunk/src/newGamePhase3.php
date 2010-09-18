<? include "newGameBar.php"; ?>
<div id="divPhase3" class="phase3 phases">
<?
	if( isSet( $_SESSION['phase3'] ))
		include "./newGamePhase3_2.php";
	else
		include "./newGamePhase3_1.php";
?>
</div>