<?php
require("./showUserInfo.php");

if($_SESSION['loggedIn'] != "yes" or
   $_SESSION['role']  != "player"){
	echo "You must be a player to access this page";
	return;
}
?>
<A HREF='./chooseMix.php?term=shortTerm'>Short term plan</A>
<BR>
<A HREF='./chooseMix.php?term=longTerm'>Long term plan</A>
<BR>
<A HREF='./logout.php'>Logout</A>