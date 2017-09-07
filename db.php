<?php
$server='localhost';	//require 'DB.php';
$username='root';
$password='root';
$con=mysql_connect($server,$username,$password);	//$con=DB::connect('mysql://root:root@localhost/');
if(!con)					//$con->setErrorHandling(PEAR_ERROR_DIE);
	die("can not connect to the server $server");
$q=mysql_query('CREATE DATABASE IF NOT EXISTS flowers',$con);	//$q=$con->query('CREATE DATABASE IF NOT EXISTS flowers')
if(!$q)
	die("failed to create the database");	
mysql_select_db('flowers');
$sql="
CREATE TABLE IF NOT EXISTS customers (
cust_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
username VARCHAR(100) NOT NULL,
password VARCHAR(100) NOT NULL,
phone varchar(11),
address varchar(100)
)
";
$q=mysql_query($sql);	//$q=$con->query($sql);
if(!$q)
	echo mysql_error();	
$sql="
CREATE TABLE IF NOT EXISTS categories (
cat_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(100) NOT NULL
)
";
mysql_query($sql);	//$con->query($sql);

mysql_query("insert into categories values('','Next Day Flowers'),('','Bset Sellers'),('','Birthday Flowers'),('','Sympathy Flowers')");

$sql="
CREATE TABLE IF NOT EXISTS products (
prod_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
cat_id INT NOT NULL,
name VARCHAR(100) NOT NULL,
img VARCHAR(100) NOT NULL,
price DECIMAL(4,2) NOT NULL,
offer_price DECIMAL(4,2) NOT NULL,
sales INT,
description TEXT NOT NULL,
origin VARCHAR(50) NOT NULL,
foreign key products(cat_id) references categories(cat_id)
)
";
mysql_query($sql);
//---initial insert here---
mysql_query("insert into products values('',1,'name1','images/12-red-roses-bouquet.jpg',50.35,28.45,3,'this is a flower description','paris')
,('',1,'name2','images/40-roses_1.jpg',50.35,28.45,3,'this is a flower description','England')
,('',1,'name3','images/DD090516-free-plant.jpg',44.50,24.70,3,'this is a flower description','paris')
,('',1,'name4','images/DD021115.jpg',44.50,24.70,3,'this is a flower description','England')
,('',2,'name1','images/12-red-roses-bouquet.jpg',50.35,28.45,3,'this is a flower description','paris')
,('',2,'name2','images/40-roses_1.jpg',50.35,28.45,3,'this is a flower description','England')
,('',2,'name3','images/DD090516-free-plant.jpg',50.35,28.45,3,'this is a flower description','paris')
,('',2,'name4','images/DD021115.jpg',44.50,24.70,3,'this is a flower description','paris')
,('',3,'name1','images/12-red-roses-bouquet.jpg',50.35,28.45,3,'this is a flower description','paris')
,('',3,'name2','images/40-roses_1.jpg',50.35,28.45,3,'this is a flower description','England')
,('',3,'name3','images/DD090516-free-plant.jpg',50.35,28.45,7,'this is a flower description','paris')
,('',4,'name4','images/DD021115.jpg',50.35,28.45,3,'this is a flower description','paris')
,('',4,'name1','images/12-red-roses-bouquet.jpg',44.50,24.70,3,'this is a flower description','paris')
,('',2,'name2','images/40-roses_1.jpg',50.35,28.45,3,'this is a flower description','paris')
,('',3,'name3','images/DD090516-free-plant.jpg',44.50,24.70,3,'this is a flower description','paris')
,('',3,'name4','images/DD021115.jpg',50.35,28.45,3,'this is a flower description','England')
,('',3,'name1','images/12-red-roses-bouquet.jpg',44.50,24.70,3,'this is a flower description','paris')
,('',2,'name2','images/40-roses_1.jpg',50.35,28.45,3,'this is a flower description','paris')
,('',1,'name3','images/DD090516-free-plant.jpg',50.35,28.45,3,'this is a flower description','paris')
,('',1,'name4','images/DD021115.jpg',44.50,24.70,3,'this is a flower description','England')
");
mysql_query("create table orders (
order_id int not null auto_increment primary key,
cust_id int not null,
name varchar(100) not null,
code varchar(50) not null,
company varchar(100),
street varchar(100) not null,
line2 varchar(100),
town varchar(100) not null,
country varchar(100) not null,
phone varchar(13),
date varchar(50),
price decimal(6,2),
foreign key orders(cust_id) references customers(cust_id)
)");

?>