<?php
	session_start();
	$i=0;

	if($_SESSION['login']===1)
	{
		$user=$_SESSION['username'];

		echo '
				<html>
				<head>
					<title>Download</title>
					<link href="./css/download.css" rel="stylesheet">
				</head>
				<body>
				<section>
					<article>
						<header>';
							echo '<p>Welcome! ' . $user . '</p>
						
						</header>
						<span style="float:right;margin-right:10px;"><a href="upload.php">Upload</a></span>
						<span style="float:right;margin-right:10px;"><a href="access.php">Logout</a></span>
					</article>
					<article>
						<table border=1>
						<tr><th> Sr NO </th><th> File name </th><th>Download link</th></tr>
			';

			require './module/class/Database.php';

			$db = new Database();
			
			if($db->connect()){
				$query="SELECT fname,filepath  from details where username='". $user. "'";

				$db->sql($query);
				$res = $db->getResult();

				$length = count($res);
				for($i=1;$i<=$length;$i++){
					echo '<tr><td>'
					. $i . '</td><td><p>'
					. $res[$i-1]['fname'] . '</p></td><td><a href="./get.php?file='
					. $res[$i-1]['filepath'] .'" targent="_blank">download</a></td></tr>';
				}

				echo '</table></body></html>';
				$db->disconnect();
			}else{
				echo 'Database connection error';
			}	
	}
	else
	{
		echo 'No permission to view this page';
	}
?>