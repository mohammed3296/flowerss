<?php
session_start();
require 'connection.php';//connect to database
if(time()>$_SESSION['cart_start']+60*60*1000)	//The cart information should be deleted after 1 hour.
	unset($_SESSION['cart']);
header("Cache-Control: no-cache, must-revalidate");	//We shouldn’t permit the cashing of our pages
header("Expires: Thu, 31 May 1984 04:35:00 GMT");	
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
							foreach($_SESSION['cart'] as $k => $v)
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
					<a href="index.php" style="width:160px;height:50px;
					                           padding:4 20px;border-radius:8px;
											   text-decoration:none;
											   background-color:#ad58b8;
											   text-align:center;">Continue Shopping</a>	
			
				</div>
				
			</div>
			<br clear=both>
			<form method=get action="search.php">
				<input type="text" name="key" placeholder="Search for...">
				<input type="submit" value="Search" style="width:70px;height:24px;
				                   padding:3px 18px;background-color:green;color:white;line-height:10px;">
			</form>
			<div id="content">
				
				<div id=con1>
					<div id="best">
						<?php
							$q=mysql_query("select * from products order by sales desc limit 1");	//$q=$con->query("select * from products order by sales desc limit 1");
							if($q)
							{
								$r=mysql_fetch_assoc($q);	//$r=$q->fetchRow();
								$prod_id=$r['prod_id'];
								$img=$r['img'];
								$name=$r['name'];
								$price=$r['price'];
								$offer_price=$r['offer_price'];
								$description=$r['description'];
								echo "<img src='$img'><br>$name<br>";
								if($offer_price)
								{
									echo "<del><span  class='price'>$price \$</span></del><span  class='offer_price'> $offer_price \$</span>";
								}
								echo "<br>$description<br><a class='order_now' href='addtocart.php?prod_id=$prod_id'>Order Now</a>";
							}
						?>
					</div>
					<img class="c" src="images/236x304x40_roses_callout.jpg">
					<img class="c" src="images/236x304x40_roses_callout.jpg">
					
				</div>
				<?php
					$qc=mysql_query("select * from categories");
					if($qc)
					{
						while($rc=mysql_fetch_assoc($qc))
						{
							$cat_id=$rc['cat_id'];
							$cat_name=$rc['name'];
							$qp=mysql_query("select * from products where cat_id=$cat_id order by prod_id desc limit 1");
							if($qp)
							{
								$rp=mysql_fetch_assoc($qp);	
								$img=$rp['img'];
								$name=$rp['name'];
								$price=$rp['price'];
								$offer_price=$rp['offer_price'];
								$description=$rp['description'];
								echo "<div class='product'>
									<h3>$cat_name</h3>
									<img src='$img'><br>$name<br>$description<br>";
								if($offer_price)
								{
									echo "from <del><span  class='price'>$price \$</span></del> <span  class='offer_price'>$offer_price \$</span>";
								}
								else
									echo "<span  class='price'>$price \$</span>";
								echo "<br><a class='order_now' href='addtocart.php?prod_id=$rp[prod_id]'>Order Now</a></div>";
							}
						}
					
					}
				?>
				<br clear=left>
				<?php
					$q=mysql_query("select * from products order by prod_id desc limit 3");	//latest 3 products
					if($q)
					{
						while($r=mysql_fetch_assoc($q))
						{
							$prod_id=$r['prod_id'];
							$img=$r['img'];
							$name=$r['name'];
							$price=$r['price'];
							$offer_price=$r['offer_price'];
							$description=$r['description'];
							echo "<div class='product2'>
								<img src='$img'><br>$name<br>$description<br>";
							if($offer_price)
							{
								echo "from <del><span  class='price'>$price \$</span></del> <span  class='offer_price'>$offer_price \$</span>";
							}
							else
								echo "<span  class='price'>$price \$</span>";
							echo "<br><a class='order_now' href='addtocart.php?prod_id=$prod_id'>Order Now</a></div>";
						}					
					}
				?>
			</div>
			<div id="footer">
			</div>
		</div>
	</body>
</html>	