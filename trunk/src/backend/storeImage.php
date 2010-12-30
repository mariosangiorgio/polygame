<?php
// TODO: security checks
// TODO: make it work with relative path
$target	= '/var/www/html/polygame/2.0/wedge_images/';
$resarr	= array();
$type	= $_GET['type'];

if ($type=='afbeeldingen') {
	$handle=opendir($target);
	$i=0;
	while (false!==($file = readdir($handle))) {
		if(substr($file,-3,3)=='jpg'||substr($file,-3,3)=='png'||substr($file,-3,3)=='gif') {
			$resarr[$i]['url']	= 'bestanden/'.$file;
			$resarr[$i]['naam']	= $file;
			$i++;
		}
	}
}

else if ($type=='bestand') {
	$name = strtolower(basename($_FILES['bestand']['name']));
	$name = str_replace(' ', '-', $name);
	//TODO check for duplicates
	if(move_uploaded_file($_FILES['bestand']['tmp_name'], $target.$name)) {
		$resarr[0]	= array('name'=>$name,'url'=>$name);
		echo "document.lm_imgform.wym_src.value='".$target."'/".$name."';\n";
	} else{
		echo 'alert("Upload error");'."\n";
		die();
	}
}
else {
	die();
}
echo "var ddl = document.getElementById('lm_select');\n";
foreach($resarr as $item) {
	echo "var theOption = new Option;\n";
	echo "theOption.text 	= '".$item['name']."';\n";
	echo "theOption.value   = 'http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/".$item['url']."';\n";
	echo "ddl.add(theOption,null);\n";
}