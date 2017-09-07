<?php
session_start();
$server='localhost';	//require 'DB.php';
$username='root';
$password='root';
$database='flowers';
$con=mysql_connect($server,$username,$password,$database);	////$con=DB::connect("mysql://root:root@localhost/$database");
mysql_select_db('flowers');	

if(!con)	//$con->setErrorHandling(PEAR_ERROR_DIE);$db->setFetchMode(DB_FETCHMODE_ASSOC);
	die("can not connect to the database $database on the server $server");

?>