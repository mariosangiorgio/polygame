<?php
	include_once("./inc/init.php");
	include_once("./lang/".$gData['langFile']);
	include_once("./inc/db_connect.php");
	include_once("./backend/utils.php");
	
	$wedgeInfo = null;
	$wedgeId = null;
	
	$edit = false;
	if(isSet($_GET['edit']) /*&& checkAuthorization("organizer") */ ){ //TODO uncomment!
		$edit = true;
	}
	
	if( isSet( $_GET['id']) && !$edit )
	{
		$wedgeId = $_GET['id'];
		$lang	 = $gData['lang'];
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
	<link href="css/wedgeInfo.css" type="text/css" rel="stylesheet" />
	<link type="text/css" href="css/ui-lightness/jquery-ui-1.8.4.custom.css" rel="stylesheet" />	
	<script type="text/JavaScript" src="lib/jquery-1.4.1.min.js"></script>
	<script type="text/Javascript" src="lib/jquery-ui-1.8.4.custom.min.js"></script>
	<script type='text/javascript' src="lib/ajaxfileupload.js"></script>
	<script type="text/javascript" src="wymeditor/jquery.wymeditor.min.js"></script>
<?
if( $edit ){
?>
	<script type="text/javascript">
		$(function() {
			$('.wymeditor').wymeditor(
				{
				  boxHtml:   "<div class='wym_box'>"
				  			+ "<div class='wym_area_top'>"
				  			+ WYMeditor.TOOLS
				  			+ "<button class='insert_image_button'>insert image</button>"
				  			+ "</div>"
				  			+ "<div class='wym_area_left'></div>"
				  			+ "<div class='wym_area_right'>"
				  			+ "</div>"
				  			+ "<div class='wym_area_main'>"
				  			//+ WYMeditor.HTML
				  			+ WYMeditor.IFRAME
				  			//+ WYMeditor.STATUS
				  			+ "</div>"
				  			+ "<div class='wym_area_bottom'>"
				  			+ "</div>"
				  			+ "</div>",
				  	postInit:
				  		function(wym){
				  			$(".insert_image_button").click(
				  				function(){
				  					$("#dialog").dialog("open");
				  				});
				  		}
              }
			);
		});
	</script>
<?
}
?>
	<script type="text/Javascript"> 
	
	( function($) {
		$(document).ready( function() 
		{
			var accordionOption = { collapsible: true, 
									active : false, 
									autoHeight: false, 
									animated: 'bounceslide' };
			
			$("#wedgeList").accordion( accordionOption );
			<? if( $edit ){?>$("#tabs").tabs();<? } ?>
		});
	})(jQuery);
	</script> 
</head>
<body>
	<?
		include "header.php"; 
	?>
	<div id="wedgeInfo-wrapper">
		<div class="title">
			<div class="wedgeInfo-columnLeft">
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
			<div class="wedgeInfo-columnRight">
				<h1>
				<?
				if(!$edit){
					echo "Other wedges...";
				}
				else{
					echo "Checklist";
				}
				?>
				</h1>
			</div>
		</div>
		<div class="wedgeInfo-columnLeft">
<?	
	if( $edit )
	{
?>
			<div id="tabs">
				<ul>
<?
		$index = 1;
		foreach( $sections as $tab ){
?>
					<li><a href="#tabs-<? echo $index; ?>"><? echo $tab; ?></a></li>
<?
			$index++;
		}
?>
				</ul>
<?
		$index = 1;
		foreach( $sections as $tab )
		{
?>
				<div id="tabs-<? echo $index; ?>">
					<p><textarea class='wymeditor' id='editor-<? echo str_replace(' ','-',$tab); ?>'></textarea></p>
				</div>				
<?
			$index++;
		}
	}
	else
	{
?>
			<div id="wedgeDetails">
<?
		foreach( $sections as $tab )
		{
?>
				<div>
					<h2><? echo $tab; ?></h2>
					<p><? echo htmlentities( $wedgeInfo[$tab] ); ?></p>
				</div>
<?
		}
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
			<div class="wedgeInfo-columnRight">
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

<!-- this enables the upload of images -->
<div id="dialog" title="Basic dialog">
	<p>This is the default dialog which is useful for displaying information. The dialog window can be moved, resized and closed with the 'x' icon.</p>
	<input	id="uploaded_image" type="file" name="uploaded_image" />
	<button id="upload_button">upload</button>
</div>

</body>
<script type="text/javascript">
$("#dialog").dialog({autoOpen: false});
$("#upload_button").click(
	function(){
		$.ajaxFileUpload({
			url:			'./storeImage.php',
    		secureuri:		false,
    		fileElementId:	'uploaded_image',
    		dataType:		'json',
    		success:	function (data, status){
    								if(typeof(data.error) != 'undefined'){
    									if(data.error != ''){alert(data.error);}
    									else{
    										var image_url =  data.msg;
    										var current_tab = $("#tabs").tabs('option', 'selected');
    										var wym = $.wymeditors(current_tab);
    										wym.insert('<img src="'+image_url+'" />');
    										wym.update();
    									}
    								}
    						},
    		error: function (data, status, e){
    								alert(e);
    						}
    	})
	}
);
</script>
<!-- this enables the upload of images -->
</html>