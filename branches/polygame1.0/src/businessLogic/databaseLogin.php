<?php
$host		= "mysql.netsons.com";
$database	= "polygame";
$username	= "polygame_user";
$password	= "12qwaszx";
$connection	= mysql_connect($host,$username,$password);
mysql_select_db($database,$connection);
?>
