<?php
ob_start();
session_start();
require 'connection.php';//connect to database
if(time()>$_SESSION['cart_start']+60*60*1000)
	unset($_SESSION['cart']);
header("Cache-Control: no-cache, must-revalidate");	//We shouldn’t permit the cashing of our pages
header("Expires: Thu, 31 May 1984 04:35:00 GMT");	
$prod_id=$_GET['prod_id'];
?>
<html>
	<head>
		<title>my e commerce web site</title>
		<link rel="stylesheet" href="style.css">
	</head>
	<body>
		<div id="container">
			<div id="header">
				<?php
					if($_SESSION['user_id'])
						{
							echo "<a href='logout.php'>log out</a><br>";
						}
						else
						{
							echo "<a href='register.php'>Register</a> or <a href='login.php'>log in</a><br>";
						}
				?>
				<div id=cart>
					<a href="viewcart.php"><img src="images/nb-vcO.gif"></a>
					<?php
						if($_SESSION['cart'])
						{
							$count=count($_SESSION['cart']);
							echo "$count item Total: ";
							$total=0;		
							foreach($_SESSION['cart'] as $k=>$v)
							{	
								$q=mysql_query("select * from products where prod_id=$k");
								$r=mysql_fetch_assoc($q);
								$tot_cost_single_prod=$r['price']*$v;
								$total+=$tot_cost_single_prod;
							}
							$shipping=20;	//or any calculation
							$total+=$shipping;
							echo "$total \$";
						}
						else
							echo "Total: 0.0";
							
					?>
				</div>
				
			</div>
			<br clear=both>
			<div id="content">
				<?php $q=mysql_query("select * from products where prod_id='$prod_id'");
				$r=mysql_fetch_assoc($q);
				if($q)
					{
						$prod_id=$r['prod_id'];
						$img=$r['img'];
						$name=$r['name'];
						$price=$r['price'];
						$offer_price=$r['offer_price'];
						$description=$r['description'];
						echo "<div style='width:280px;height:300px;text-align:center;float:left;margin-left:5px;'>
							<img src='$img'><br>$name<br>$description<br>";
						if($offer_price)
						{
							echo "<span  class='surprise'>Surprise it costs $offer_price \$ instead of $price \$</span>";
						}
						else
							echo "$price \$";
						echo "</div>";	
									
					}
				?>
				
				<?php 
				if($_POST['h'])
				{
					$name=strtr(htmlentities($_POST['name']),array("'"=>"\'","_" => "\_", "%" => "\%"));	//security
					$code=strtr(htmlentities($_POST['code']),array("'"=>"\'","_" => "\_", "%" => "\%"));	//security
					$company=strtr(htmlentities($_POST['company']),array("'"=>"\'","_" => "\_", "%" => "\%"));	//security
					$street=strtr(htmlentities($_POST['street']),array("'"=>"\'","_" => "\_", "%" => "\%"));	//security
					$line2=strtr(htmlentities($_POST['line2']),array("'"=>"\'","_" => "\_", "%" => "\%"));	//security
					$town=strtr(htmlentities($_POST['town']),array("'"=>"\'","_" => "\_", "%" => "\%"));	//security
					$country=strtr(htmlentities($_POST['country']),array("'"=>"\'","_" => "\_", "%" => "\%"));	//security
					$phone=strtr(htmlentities($_POST['phone']),array("'"=>"\'","_" => "\_", "%" => "\%"));	//security
					
					if($err=validate())
					{
						show($err);
					}
					else
					{
						//make an order
						if(!$_SESSION['user_id'])
						{
							echo "<br>you must <a href='register.php'>Register</a> or <a href='login.php'>log in</a><br>";
						}
						else
						{
							$date=time();
							$q=mysql_query("insert into orders values('',$_SESSION[user_id],
							'$name','$code','$company','$street','$line2','$town','$country','$phone','$date','$total')");
							if($q)
								{
									foreach($_SESSION['cart'] as $k=>$v)
										$q=mysql_query("update products set sales=sales+$v where prod_id='$k'");
									unset($_SESSION['cart']);
									echo "your order is successfully completed<br>Thank you<br>you will be redirected after 3 seconds";
									header("Refresh:3;url=index.php");
								}
						}
					}
				}
				else
					show();
				function show($err='')
				{
					echo "<div style='width:305px;height:300px;float:left;text-align:center;margin-left:30px;background-color:#ad59b9;'>	<h2>Delivery Details</h2>
						<table>
						<tr><td>Date: </td><td><input type='date' name='date'></td></tr>
						<tr><td>Delivery: </td><td>5.8</td></tr>
						<br>
						<tr><td>Type: </td>";
						global $prod_id;
						$q=mysql_query("select categories.name as cat_name,products.name as prod_name from categories,products where products.prod_id=$prod_id and categories.cat_id=products.cat_id");
						$r=mysql_fetch_assoc($q);
						echo "<td>$r[cat_name]</td></tr><tr><td>Item: </td><td>$r[prod_name]</tr>";
						echo "</table>
						<hr>
						<textarea rows=4 cols=34 style='overflow: scroll;'>
						
						</textarea>
						
					</div>";
					
					echo"<div style='width:350px;height:300px;float:left;text-align:center;margin-left:10px;background-color:#9cd14b;'>	<h2 style='margin-top:-2'>Delivery Address</h2>
					<form method='post' action='detail.php?prod_id=$prod_id' style='margin-top:-20'>
					<table>
						<tr><td>Name:* </td><td><input type=text name=name value='$_POST[name]' required></td>"; if($err['name']) echo "<td class='err'>$err[name]</td>";echo "</tr>
						<tr><td>Postal Code:* </td><td><input type=text name=code value='$_POST[code]' size=8 required></td>"; if($err['code']) echo "<td class='err'>$err[code]</td>";echo "</tr>
						<tr><td>company: </td><td><input type=text name=company value='$_POST[company]'></td></tr>
						<tr><td>street:* </td><td><input type=text name=street value='$_POST[street]' required></td>"; if($err['street']) echo "<td class='err'>$err[street]</td>";echo "</tr>
						<tr><td>line2: </td><td><input type=text name=line2 value='$_POST[line2]'></td></tr>
						<tr><td>town:* </td><td><input type=text name=town value='$_POST[town]' required></td>"; if($err['town']) echo "<td class='err'>$err[town]</td>";echo "</tr>
						<tr><td>country/state: </td><td><input type=text name=country value='$_POST[country]'></td></tr>
						<tr><td>Telephone: </td><td><input type=text name=phone value='$_POST[phone]'></td>"; if($err['phone']) echo "<td class='err'>$err[phone]</td>";echo "</tr>
					</table>
					<input type=hidden name=h value=1>
					<button type=submit style='width:130px;height:50px;padding:4 20px;border-radius:8px;background-color:#b8e356;margin-top:4px;margin-left:10px;'>
					<img src='images/pad-lock-symbol.gif'>Secure <br>Checkout</button>
				
					</form>	
				</div>";
				}
				function validate()
				{
					global $name,$code,$street,$town,$phone;
					$err=array();
					if(!preg_match("/[a-zA-Z\s\d]+/",$code))
						$err['code']='wrong code';
					if(!preg_match('/\d\d\d-\d\d-\d\d\d\d\d\d/',$phone))
						$err['phone']='wrong phone';
					if(strlen($name)==0)
						$err['name']='the name is required feild';
					if(strlen($code)==0)
						$err['code']='the postal code is required feild';
					if(strlen($street)==0)
						$err['street']='the street is required feild';
					if(strlen($town)==0)
						$err['phone']='the name is required feild';
						
					return $err;
				}
				?>
				
				<br clear=left><br>
				<a href="index.php" style="width:160px;height:50px;padding:4 20px;border-radius:8px;text-decoration:none;background-color:#ad58b8;text-align:center;">Continue Shopping</a>	
				<a href="viewcart.php" style="width:160px;height:50px;padding:4 20px;border-radius:8px;text-decoration:none;background-color:#ad58b8;text-align:center;">View Cart</a>	
			</div>
		</div>
	</body>
</html>	
<?php ob_flush();?>