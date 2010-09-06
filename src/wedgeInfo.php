<?php
	include_once("./inc/common.php");
	include_once 'lang/'.$lang_file;
	include_once("./inc/db_connect.php");
	include_once("./backend/utils.php");
	
	$wedgeInfo = null;
	$wedgeId = null;
	
	$edit = false;
	if(isSet($_GET['edit']) && checkAuthorization("organizer")){
		$edit = true;
	}
	
	if( isSet( $_GET['id']) && !$edit)
	{
		$wedgeId = $_GET['id'];
		$lang = $_SESSION['lang'];
		$query = "SELECT `Title`, `Image`, `Introduction`, `Summary`, `History`, `Present use`,".
				 "`National situation`, `Emission reduction`, `References`". 
				 "FROM `Wedges` WHERE Language='$lang' AND `Wedge ID`=$wedgeId";
		$result = mysql_query( $query, $connection );
		$wedgeInfo = mysql_fetch_array( $result );		
	}
	
	$sections = array('Introduction', 'History', 'Present use',
					  'National situation', 'Emission reduction',
					  'References');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title>
	<? if($edit){ ?>Propose your wedge!<? } else{echo $wedgeInfo['Title'];} ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link href="css/main.css" type="text/css" rel="stylesheet" />
	<link type="text/css" href="css/ui-lightness/jquery-ui-1.8.4.custom.css" rel="stylesheet" />	
	<script type="text/JavaScript" src="lib/jquery-1.4.1.min.js"></script>
	<script type="text/Javascript" src="lib/jquery-ui-1.8.4.custom.min.js"></script>
	<script type="text/javascript" src="wymeditor/jquery.wymeditor.min.js"></script>
	<script type="text/javascript">$(function() {$('.wymeditor').wymeditor();});</script>
	<script type="text/Javascript"> 
	
	( function($) {
		$(document).ready( function() 
		{
			var accordionOption = { collapsible: true, 
									active : false, 
									autoHeight: false, 
									animated: 'bounceslide' };
			
			$("#wedgeList").accordion( accordionOption );
			
			$("#tabs").tabs();
		});
	})(jQuery);
	</script> 
</head>
<body>
	<?
		include "header.php"; 
	?>
	<div id="wrapper">
		<div class="title">
			<div class="columnLeft">
				<h1><?
				if($edit){
					?>
				<textarea
					id='editor-title'
					style='width: 40%'
					rows="1">Insert here the title of your wedge</textarea><?
				}
				else{
					echo $wedgeInfo['Title'];
				}
				?></h1>
			</div>
			<div class="columnRight">
			<?
			if(!$edit){
				echo "<h1>Other wedges...</h1>";
			}
			else{
				echo "<h1>Checklist</h1>";
			}
			?>
			</div>
		</div>
		<div class="columnLeft">
			<div id="tabs">
				<ul>
				<?
					$index = 1;
					foreach($sections as $tab){
					?>
						<li><a href="#tabs-<? echo $index; ?>"><? echo $tab; ?></a></li>
						<?
						$index++;
					}
				?>
				</ul>
				<?
					$index = 1;
					foreach($sections as $tab){
						?>
						<div id="tabs-<? echo $index; ?>"><p>
						<?
						if($edit){ ?>
							<TEXTAREA class='wymeditor' id='editor-<? echo str_replace(' ','-',$tab);?>'></TEXTAREA>
						<?
						}
						else{
							echo htmlentities($wedgeInfo[$tab]);
						}
						?>
						</p></div>				
						<?
						$index++;
					}
				?>
			</div>
		</div>
		<?
		if($edit){
			echo "<div id='checklist-title'>Title</div>";
			foreach($sections as $section){
				echo "<div id='checklist-".str_replace(' ','-',$section)."'>$section</div>";
			}
			?>
			<DIV id='submitButton'>
			<BUTTON class='wymupdate'>Submit</BUTTON>
			</DIV>
			<?
		}
		else{
			?>
			<div class="columnRight">
			<div id="wedgeList" class="accordion">
			<? 
			$query = "SELECT `Wedge ID` as id, Title, Summary, Image ". 
					 "FROM Wedges ".
			 		 "WHERE Language='$lang' AND ( `Wedge ID` <> $wedgeId )";
			$data = mysql_query( $query, $connection );
			
			$counter = 0;
			while( $wedge = mysql_fetch_array( $data )) 
			{
				$wedges[$counter] = array(  'Id' 		=> $wedge['id'],
											'Title' 	=> $wedge['Title'],
											'Summary' 	=> $wedge['Summary'],
											'Image' 	=> $wedge['Image'] );
				$counter++;
			}
			
			$vector = generateRandomSequence( 0, $counter );
			$index = 0;
			while( $counter > 0 )
			{
				$wedge = $wedges[$vector[$index]];
				?>
				<h3><a><? echo $wedges[$vector[$index]]['Title']; ?></a></h3>
				<div>
					<img src="<? echo $wedge['Image']; ?>" width="66px" height="84px" />
					<p class="accordionText">
						<? echo $wedge['Summary']; ?>
					</p>
					<p class="accordionLink">
						<a href="wedgeInfo.php?id=<? echo $wedge['Id']; ?>"><? echo $TEXT['main-a_1']; ?></a>
					</p>
				</div>
			<?
			$counter--;
			$index++;
			}
			?>
			</div>
		</div>
		<? } ?>
	</div>
</body>
<script type="text/javascript">
var edited = new Array();
edited.push('title')
<? foreach($sections as $section){ echo "\nedited.push('".str_replace(' ','-',$section)."');";}?>

$("[id^=checklist-]").css('color','red');

var submitButton = $('button',"#submitButton");
submitButton.button();
submitButton.click(
	function(){
		var i = 0;
		while(i < (edited.length-1)){
			$.wymeditors(i).update();
			i++;
		}

		var allOk = true;
		for(var item in edited){
			if($("#editor-"+edited[item]).val() != ""){
				$("#checklist-"+edited[item]).css('color','green');
			}
			else{
				$("#checklist-"+edited[item]).css('color','red');
				allOk = false;
			}
		}
	}
);
</script>
</html>