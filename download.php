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
		<span style="float:right;margin-right:10px;"><a href="index.php">Logout</a></span>
	</article>
	<article>
		<table border=1>
		<tr><th> Sr NO </th><th> File name </th><th>Download link</th></tr>';

			require 'connect.php';
			$query="SELECT fname,filepath  from details where username='". $user. "'";
			$result=mysql_query($query,$db) or die(mysql_error($db));
			while($row=mysql_fetch_array($result))
			{
				extract($row);
				echo '<tr><td>'.++$i . '</td><td><p>'.$fname. '</p></td><td><a href="./get.php?file='. $filepath .'" targent="_blank">download</a></td></tr>';
			}

echo '
</table>
</body>
</html>';
}
else
{
	echo 'No permission to view this page';
}
?>