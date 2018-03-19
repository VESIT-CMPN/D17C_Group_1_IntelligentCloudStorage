<?php
session_start();
$user=$_SESSION['username'];
function sendHeaders($file, $type, $name=NULL)
{
    if (empty($name))
    {
        $name = basename($file);
    }
    header('Pragma: public');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Cache-Control: private', false);
    header('Content-Transfer-Encoding: binary');
    header('Content-Disposition: attachment; filename="'.$name.'";');
    header('Content-Type: ' . $type);
    header('Content-Length: ' . filesize($file));
}

/*
* detect mime of the file type
*/
require 'mime_type_lib.php';
$mime_type = get_file_mime_type( './mix/'. $user . '/'. $_GET['file']);
$file ='./mix/' . $user . '/' . $_GET['file'];
if (is_file($file))
{
    sendHeaders($file,$mime_type,$user .'-'. $_GET['file']);
    ob_clean();
    flush();
	@readfile($file);
	exit;
}
?>