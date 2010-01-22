<?php
session_start();
if($_SESSION['loggedIn'] == "PasswordReset"){
	echo "Insert the new password for: ".$_SESSION['username'];
	?>
	<FORM
		METHOD="POST"
		ACTION="./businessLogic/setNewPassword.php">
		<INPUT TYPE="password" NAME="password">
		<INPUT TYPE="submit" VALUE="Submit">
	</FORM>
	<?php
}
else{
	print "Ask the administrator to reset your password.";
}

?>
