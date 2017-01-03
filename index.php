<?php
session_start();
session_unset();
$_SESSION['login']=0;
if(!isset($_POST['send'])){
$start=<<<FORM
<html>
<head>
	<title>Login</title>
	<link href="./css/login.css" rel="stylesheet">
</head>
<body>
<form action="?" method="post">
<div>
<label for="Username">Username :</label>
<input type="text" name="username" id="Username" />
</div>
<div>
<label for="password">Password :</label>
<input type="password" name="password" id="password" />
</div>
<div>
<input type="submit" id="login" name="send" value="GO"/>
</div>
</form>
</body>
</html>
FORM;
echo $start;
}
else{
	 $user=$_POST['username'];
	$pass=$_POST['password'];

	//database connect
	require 'connect.php';
	$query="SELECT * from login where username='" . $user .  "' and password='" . $pass . "'";
	$result=mysql_query($query,$db) or die(mysql_error($db));
	$count = mysql_num_rows($result);

	
		if($count==1)
		{
			$_SESSION['username']= $user ;
		}
		else{
			echo '<html><head><title>Error</title>
			<link href="./css/login.css" rel="stylesheet"></head><body><div id="error">';
			echo '<b>Invalid Login Credentials</b>';
			echo '<p>Would you like to <a href="login.php?"> <i>retry<i></a></p><br>or<p>New user register <a href="register.php"><strong>here</strong></a></p>
			</div></body></html>';
		}
		if(isset($_SESSION['username']))
		{
			$_SESSION['login']=1;
			header('Location:upload.php');
		}
}
?>