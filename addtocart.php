<?php
ob_start();
session_start();
$prod_id=$_GET['prod_id'];
if(!$_SESSION['cart_start'])	
	$_SESSION['cart_start'] = time();	//cart is starting
else if(time()>($_SESSION['cart_start']+60*60*1000))	//The cart information should be deleted after 1 hour.
	unset($_SESSION['cart']);	
if($_SESSION['cart'][$prod_id])
	$_SESSION['cart'][$prod_id]++;
else
	$_SESSION['cart'][$prod_id]=1;
header("Refresh:0;url=detail.php?prod_id=$prod_id");	//header("Location:detail.php?prod_id=$prod_id");	
ob_flush();
?>
