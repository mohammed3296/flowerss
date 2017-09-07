<html>
	<head>
		<title>Log in</title>
	</head>
	<body>
		<form action='login_process.php' method='post'>
			<table>
				<tr><td>username:</td><td><input type='text' name='user' ></td></tr>
				<tr><td>password:</td><td><input type='password' name='pass' ></td></tr>
			    <tr><td><input type='submit' value='Log in'></td></tr>
			</table>
			<input type='hidden' name='h' value='1'>
		</form>
		<a href="index.php" style="width:160px;height:50px;padding:4 20px;border-radius:8px;text-decoration:none;background-color:#ad58b8;text-align:center;">go to home page</a>	
	</body>
</html>