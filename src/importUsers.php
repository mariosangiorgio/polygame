<?php
require("./businessLogic/databaseLogin.php");

$filename = $_FILES['users']['tmp_name'];
$tempFile = file($filename);

echo "IMPORT SUCCESSFUL<BR>";

foreach ($tempFile as $line_num => $line) {
    $username = htmlspecialchars($line);
    $username = preg_replace("/[\n\r]/","",$username); 
    $username = mysql_real_escape_string($username);
    
    echo $username;
    echo "<BR>";
    
    $query = "INSERT INTO `Users`
    		  (`Username`,`PasswordValid`,`Role`)
    		  VALUES
    		  ('".$username."',0,'Player')";
    mysql_query($query,$connection);
}

echo "<A HREF='./organize.php'>Back to organizer page</A>";


?>