<?php
ob_start();
session_start();
require 'connection.php';//connect to database
echo "<h2 style='text-align:center;color:brown'>successfully logged out of the web site <br>you will be redirected after 3 seconds</h2>";
$d=date("Y/m/d h:i:sa"); 
mysql_query("update users set last_visit_date='$d' where user_id='$_SESSION[user_id]'");
session_destroy();
header("Refresh:3;url=index.php");
ob_flush();	
?>