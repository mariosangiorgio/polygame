<?php
session_start();
require("./businessLogic/databaseLogin.php");


if( $_SESSION['loggedIn'] == "yes"){		
	/* Start drawing table */
	if( $_SESSION['role'] == "administrator" or
		$_SESSION['role'] == "organizer" ){
		?>
		<FORM METHOD="POST" ACTION="./businessLogic/executeResetPassword.php">
    	<table border=".1.">
    	<?php
		$query_players		= "SELECT `username`, `role` FROM `Users` WHERE 								`role` = 'player'
								OR `role` = 'voter'
								ORDER BY `username`";
		$data_players		= mysql_query($query_players,$connection);
		$query_organizers		= "SELECT `username`, `role` FROM `Users` WHERE `role` = 'organizer'
									ORDER BY `username`";
		$data_organizers		= mysql_query($query_organizers,$connection);
		
		//print $query_players;
		//print $query_organizers;
		
		//print $data_players;
		//print $data_organizers;
		
		if( $_SESSION['role'] == "administrator"){
			print "Reset an organizer password<BR>";
			while( $row	= mysql_fetch_array($data_organizers)){
				print "<TR><TD><input name=user type=\"radio\" name=\"selectedUsers[]\" value=\"".$row['username']."\"></TD><TD>".$row['username']."</TD>";
		
			print "<TD>".$row['role'];
			print "</TD></TR>";
			}
		}
		else if( $_SESSION['role'] == "organizer"){
			print "Reset a player or a voter password<BR>";
			while( $row	= mysql_fetch_array($data_players)){
				print "<TR><TD><input name=user type=\"radio\" name=\"selectedUsers[]\" value=\"".$row['username']."\"></TD><TD>".$row['username']."</TD>";
		
			print "<TD>".$row['role'];
			print "</TD></TR>";
			}
		}
		
		?>
		</table>
		<INPUT TYPE="submit" VALUE="Reset user password">
		<?php
	}
	
	/* Restricted accesses */
	if( $_SESSION['role'] == "player"){
		print("Password reset is not available to players.");		
	}
	if( $_SESSION['role'] == "voter"){
		print("Password reset is not available to voters.");		
	}
	
}
else
{
	print("Password reset is not available to non-logged users.");
}

?>