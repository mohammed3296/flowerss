<?php
session_start();
require 'connection.php';//connect to database
if(time()>$_SESSION['cart_start']+60*60*1000)	//The cart information should be deleted after 1 hour.
	unset($_SESSION['cart']);
header("Cache-Control: no-cache, must-revalidate");	//We shouldn’t permit the cashing of our pages
header("Expires: Thu, 31 May 1984 04:35:00 GMT");	
if($_SESSION['cart'])
{
	echo "<table border=3><tr><th>name</th><th>img</th><th>price</th><th>quantity</th><th>total</th></tr>
			";
	$total=0;		
	foreach($_SESSION['cart'] as $k=>$v)
	{	
		$q=mysql_query("select * from products where prod_id='$k'");
		$r=mysql_fetch_assoc($q);
		$tot_cost_single_prod=$r['price']*$v;
		$total+=$tot_cost_single_prod=$r['price']*$v;
		echo "<tr><td>$r[name]</td><td><img src=$r[img] width=100px height=100px></td>
		<td>$r[price] \$</td><td>$v</td><td>$tot_cost_single_prod \$</td></tr>";
	}
	echo "</table>";
	$shipping=20;	//or any calculation
	$total+=$shipping;
	echo "<h2>total cost: $total \$</h2>";
	
}
else
	echo "Empty Cart <br>";
echo "<a href='index.php' style='width:160px;height:50px;padding:4 20px;border-radius:8px;
text-decoration:none;background-color:#ad58b8;text-align:center;'>Continue Shopping</a>";	
				
?>