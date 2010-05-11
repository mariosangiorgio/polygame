TEST PAGE TO READ AN UPLOADED FILE<BR>
<?php
require("./businessLogic/businessLogicFunctions.php");

$filename = $_FILES['users']['tmp_name'];
$tempFile = file($filename);

echo "<TABLE>";
foreach ($tempFile as $line_num => $line) {
    $username = htmlspecialchars($line);
    $username = preg_replace("/[\n\r]/","",$username); 
    $password = generatePassword();
    
    echo "<TR><TD>" . $username . "</TD><TD>" . $password . "</TD></TR>";

    insertNewPlayer($username, $password);
}
echo "</TABLE>";

?>