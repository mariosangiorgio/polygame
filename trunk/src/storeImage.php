<?php
//TODO: security check
	$images_path	= "uploaded_images/";
	$error	= "";
	$msg 	= "";
	
	$fileElementName = 'uploaded_image';
	if(!empty($_FILES[$fileElementName]['error']))
	{
		switch($_FILES[$fileElementName]['error'])
		{

			case '1':
				$error = 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
				break;
			case '2':
				$error = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
				break;
			case '3':
				$error = 'The uploaded file was only partially uploaded';
				break;
			case '4':
				$error = 'No file was uploaded.';
				break;

			case '6':
				$error = 'Missing a temporary folder';
				break;
			case '7':
				$error = 'Failed to write file to disk';
				break;
			case '8':
				$error = 'File upload stopped by extension';
				break;
			case '999':
			default:
				$error = 'No error code avaiable';
		}
	}elseif(empty($_FILES[$fileElementName]['tmp_name']) || $_FILES[$fileElementName]['tmp_name'] == 'none')
	{
		$error = 'No file was uploaded..';
	}else 
	{
		$extension= end(explode(".", $_FILES[$fileElementName]['name']));
		do $path = $images_path . uniqid().".".$extension;
		while (file_exists($path));
		if (move_uploaded_file($_FILES[$fileElementName]['tmp_name'], $path)){
		
			$msg = "http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/".$path;
			@unlink($_FILES[$fileElementName]);
		}
		else{
			$error = 'Error moving file';
		}
	}		
	echo "{";
	echo				"error: '" . $error . "',\n";
	echo				"msg: '" . $msg . "'\n";
	echo "}";
?>