<html>
	<head>
		<title>Registration</title>
	</head>
	<body>
		<form action='register_process.php' method='post'>
			<table>
				<tr><td>username:</td><td><input type='text' name='user' ></td></tr>
				<tr><td>password:</td><td><input type='password' name='pass' ></td></tr>
			    <tr><td>re-enter password:</td><td><input type='password' name='repass' ></td></tr>
			    <tr><td>address:</td><td><input type='text' name='address' ></td></tr>
				<tr><td>phone:</td><td><input type='text' name='phone' ></td></tr>
				<tr><td><input type='submit' value='Register'></td></tr>
			</table>
			<input type='hidden' name='h' value='1'>
		</form>
		<a href="index.php" style="width:160px;height:50px;padding:4 20px;border-radius:8px;text-decoration:none;background-color:#ad58b8;text-align:center;">go to home page</a>	
	</body>
</html>