<?php
session_start();

//Security check
if( $_SESSION['loggedIn'] == "yes" and
	($_SESSION['role'] == "administrator" or
	 $_SESSION['role'] == "organizer")
	)
	{
	 $image = $_FILES['image'];
	 $wedge = $_POST['wedge'];
	 
	 //Ensuring that the file type is an image
	 if(!eregi('image/', $image['type'])) {
	 	echo 'The uploaded file is not an image please upload a valide file!';
	 	return;
	 }
	 
	 //Copying the file in the destination folder
	 $uploaddir	 = '../images/uploaded/'.$wedge."/";
	 if(!file_exists($uploaddir)){
	 	mkdir($uploaddir);
	 }
	 $basename	 = basename($image['name']);
	 $uploadfile = $uploaddir.$basename;
	 
	 //Check to avoid that the image is overwritten
	 while(file_exists($uploadfile)){
	 	//Finding the . and adding a random character before it
	 	$dotPosition = strrpos($basename,'.');
	 	$extension  = substr($basename,$dotPosition);
	 	$basename	= substr($basename,0,$dotPosition);
	 	$randomCharacter = rand(0,9);
	 	$basename	= $basename.$randomCharacter.$extension;
	 	$uploadfile = $uploaddir.$basename;
	 }
	 
	 if (move_uploaded_file($image['tmp_name'], $uploadfile)) {
	 	echo "Upload OK";
	 	echo "<BR>";
	 	echo "Use this as the image URL: ";
	 	echo substr($uploadfile,1);
	 }
	 else{
	 	echo "Possible file upload attack!\n";
	 }
	}
else{
	echo "Permission denied";
}
?>