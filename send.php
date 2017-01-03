<?php
$success=<<<SUCCESS
<html>
<head>
<title>Welcome | Registeration</title>
</head>
<body>
	<form action="?" method="post">
	<fieldset>
	<legend>Request Send SuccessFully</legend>
	<p>Kindly wait for our <i>response</i>!
	<p>for any query:</p>
	<p>E-mail :friendforever@gmail.com</p>
	</fieldset>
	</form>
</body>
</html>
SUCCESS;
if(isset($_POST['submit']))
		{
	  $type=$_GET['type'];
	  $name=$_POST['fname'] . ' ' . $_POST['mname']. ' ' . $_POST['lname'];
	  $dob=$_POST['dob'];
	  $gender=$_POST['gender'];
	  $dor='1995-10-15';
	  $email=$_POST['email'];
	  $add=$_POST['add'];
	  $username=$_POST['uname'];
	  $password=$_POST['password'];
	  require 'connect.php';
		if($type=='free')
	  {
		  
		  $query="INSERT INTO free(name,DoB,DoR,gender,email,address) values ('" . $name . "','" .$dob. "','" .$dor. "','" .$gender. "','" . $email . "','" . $add . "')";
	  }
	  else if($type=='premium')
	  {
		  
		  $query="INSERT INTO premium(name,DoB,DoR,gender,email,address) values ('" . $name ."','" . $dob . "','" . $dor . "','" . $gender . "','" . $email . "','" . $add . "')";
	  }
	  else
	  {
		  echo 'Some error occured\nPlease fill again you are redirected to registration page within 5 sec...';
		  //sleep(5);
		  header("Location:register.php?try=false");
		  exit();
	  }
			mysql_query($query,$db) or die('some error occur');
			echo $success;
			$query="INSERT INTO login(username,password) VALUES('" .$username. "','" . $password . "')";
			mysql_query($query,$db) or die('Try with Different username.');
	}
?>