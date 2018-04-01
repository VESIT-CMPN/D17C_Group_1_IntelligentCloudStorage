<?php
	session_start();
	session_unset();

	$_SESSION['login']=0;

	//UI code
	$start ='
					<!DOCTYPE html>
					<html>
					<head>
					<meta charset="UTF-8">
					<title>ICSSIC</title>
					<link rel="stylesheet" type="text/css" href="css/access.css">
					<link rel="shortcut icon" type="image/png" href="images/favi.png"/>
					</head>

					<body>
					    <div id="cloud-container1">
					        <div class=login-box>
					            <h2>login</h2>
					            <div class=logsubbox>
					                <form action="?" method="post">
					 

					                    <div class="container">
					                     
					                      <input type="text" placeholder="Username" name="username" required>
					                  
					                  
					                      <input type="password" placeholder="Password" name="password" required>
					                          
					                      <button type="submit" name="send">Login</button>
					                     
					                    </div>
					                  
					                  
					                  </form>
					            </div>

					            
					        </div>
					    </div>
					    <div id="cloud-container2">
					        <div class=reg-box>
					            <h2>registration</h2>
					            <div class=regsubbox>
					              <a href="register.php"><button type="submit">Register</button></a>
					            </div>

					            
					        </div>
					    </div>
					</body>

					</html>
				';

	if(!isset($_POST['send'])){

		echo $start;
	}
	else{

		$user=$_POST['username'];
		$pass=$_POST['password'];

		//database connect
		require './module/class/Database.php';

		$db = new Database();
		if($db->connect()){
			
			$query="SELECT * from login where username='" . $user .  "' and password='" . $pass . "'";
			
			$db->sql($query);
			
			$res = $db->getResult();
			$db->disconnect();
			if(count($res) == 1){
				
				$_SESSION['username']= $user ;
			
			}else{
				echo $start;
			}

			if(isset($_SESSION['username']))
			{
				$_SESSION['login']=1;
				header('Location:upload.php');
			}
		}else{
			echo 'connection failed\n';
		}
	}
?>