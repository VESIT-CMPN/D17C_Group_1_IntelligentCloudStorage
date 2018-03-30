<?php
    session_start();
    $user = $_SESSION["username"];
    $path = "drive/$user/Image_Classification_Clustering.py";
    $path2 = "test.py";
    echo ">> ";
    system('D:\Python27\python.exe ' . $path2);
    echo " <<";
?>