<!-- 
	This .php use the variable stripeImageUrl to set the URL of the image to show 
	on the stripe. If the variable isn't set, it will be used the default image.
-->
<div id="header">
	<div id="stripe">
<?
	if( $stripeImageUrl )
		$height = "150px";
	else
	{
		$stripeImageUrl = "./images/poly-new.png";
		$height = "75px";
	}
	
	if( $_SESSION['loggedIn'] == "yes" ) 
	{
?>
		<div id="name">
			<? echo $TEXT['header-div_1'].", ".$_SESSION['username']."!" ?>
		</div>
<?
	}
?>
		<div id="logo">
			<img src="<? echo $stripeImageUrl; ?>" height="<? echo $height; ?>" />
		</div>
		<div id="languages-head"> 
			<a href="index.php?lang=en"><img src="images/en.png" /></a> 
			<a href="index.php?lang=it"><img src="images/it.png" /></a> 
		</div>
<?
	if( $_SESSION['loggedIn'] == "yes" )
	{
?>
		<div id="logout">
			<a href="logout.php"><? echo $TEXT['header-a_1']; ?></a> 
		</div>
<?
	}
?>
	</div>
</div>