<html>
<title> Upload Form </title>
<body>
<?php
$dir="c:/xampp/htdocs/upload/docs/";
$user='pro';
$new_dir=$dir . $user;
if(mkdir($new_dir, 0700))
{
	echo 'folder created';
}
else
{
	echo 'folder creation failed';
}
?>
</body>
</html>