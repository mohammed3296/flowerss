<?php
ob_start();
session_start();
require 'connection.php';//connect to database

if($_POST['h'])
{
	$user=htmlentities($_POST['user']);
	$pass=htmlentities($_POST['pass']);
	$repass=htmlentities($_POST['repass']);
	$address=htmlentities($_POST['address']);
	$phone=htmlentities($_POST['phone']);
	$user=strtr($user,array("'"=>"\'","_" => "\_", "%" => "\%"));	//security
	$pass=strtr($pass,array("'"=>"\'","_" => "\_", "%" => "\%"));	//security
	$repass=strtr($repass,array("'"=>"\'","_" => "\_", "%" => "\%"));	//security
	$address=strtr($address,array("'"=>"\'","_" => "\_", "%" => "\%"));	//security
	$phone=strtr($phone,array("'"=>"\'","_" => "\_", "%" => "\%"));	//security

	if($err=validate())
	{
		show($err);
	}
	else
	{
		$q=mysql_query("select * from customers where username='$user'");
		if(mysql_num_rows($q)>0)	
		{
			echo "<h2>the username $user already registered <br>you will be redirected after 3 seconds</h2>";
			header("Refresh:3;url=register.php");
		}
		else
		{
			$q=mysql_query("insert into customers values('','$user','$pass','$address','$phone')");
			if($q)	
				{
					echo "<h2 style='text-align:center;color:green'>successfully registered the username $user <br>you will be redirected after 3 seconds</h2>";
					$_SESSION['user_id']=mysql_insert_id();
					header("Refresh:3;url=index.php");
				}
			else
				echo mysql_error();	
		}
	
	}

}
function validate()
{
	global $user,$pass,$repass;
	$err=array();
	if(strlen($pass)<=8||!preg_match('#[a-z]#',$pass)
	||!preg_match('#[A-Z]#',$pass)||!preg_match('#[\d]#',$pass))
		$err['pass']='the password should be strong longer than 8 symbols has capital and small letters, and numbers';
	if($pass!=$repass)
		$err['repass']='the two passwords must be identical';
	return $err;
}
function show($err)
{
	global $user,$pass,$repass,$address,$phone;
	?>
	<html>
		<head>
			<title>Registration</title>
		</head>
		<body>
			<form action='register_process.php' method='post'>
				<table>
					<tr><td>username:</td><td><input type='text' name='user' <?php echo "value='".$user."' ></td>"; if($err['user']) echo"<td style='color:red;'>".$err['user']."</td>"; ?> </tr>
					<tr><td>password:</td><td><input type='password' name='pass' <?php echo "value='".$pass."' ></td>"; if($err['pass']) echo"<td style='color:red;'>".$err['pass']."</td>"; ?> </tr>
					<tr><td>re-enter password:</td><td><input type='password' name='repass' <?php echo "value='".$repass."' ></td>"; if($err['repass']) echo"<td style='color:red;'>".$err['repass']."</td>"; ?></tr>
					<tr><td>address:</td><td><input type='text' name='address' <?php echo "value='".$address."' ></td>";?></tr>
					<tr><td>phone:</td><td><input type='text' name='phone' <?php echo "value='".$phone."' ></td>";?></tr>
					<tr><td colspan=2><input type='submit' value='Register'></td></tr>
				</table>
				<input type='hidden' name='h' value='1'>
			</form>
		</body>
	</html>
	<?php
}
ob_flush();	
?>