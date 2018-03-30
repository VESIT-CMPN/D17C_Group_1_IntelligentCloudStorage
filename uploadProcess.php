<html>
    <head>
        <title>
            ||upload status||
        </title>
    </head>
    <body>
        <?php
            ini_set('max_execution_time', 3000);
            session_start();
            
            function getLabel($fname){
                $target_url = "http://suzukinakamura.pythonanywhere.com/upload";

                $cfile = new CURLFile(realpath($fname));

                    $post = array (
                            'image' => $cfile
                            );    

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $target_url);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
                curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible;)");   
                curl_setopt($ch, CURLOPT_HTTPHEADER,array('Content-Type: multipart/form-data'));
                curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);   
                curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);  
                curl_setopt($ch, CURLOPT_TIMEOUT, 100);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

                $result = curl_exec ($ch);

                if ($result === FALSE) {
                    curl_close ($ch);
                     return "Error sending";
                }else{
                    curl_close ($ch);
                    return $result;
                }
            }
           
            if(isset($_GET["debug"])){
                echo 'debug mode';
            }else {
                # code...
                if($_SESSION['login']===1)
                {
                    $name=$_SESSION['username'];
                    $fname=trim($_POST['name']);
                    $question=$_POST['quest'];
                    $answer=$_POST['ans'];

                    /*
                    * connetion setup with the database
                    */

                    require './module/class/Database.php';

                    /*
                    * check for user folder is not exist create new one
                    */


                    $dir="./drive/";
                    $user=$name;
                    $mix = "/mix";
                    $base_dir=$dir . $user;
                    $new_dir=$dir . $user . $mix;
                    if(!file_exists($new_dir))
                    {
                        mkdir($new_dir, 0700);
                        echo 'folder created<br/>Now you can upload your file<br>';
                    }

                    /*
                    * checking for the file whether it exist or not 
                    * if it exist give error and request for new file name
                    * else upload the file
                    */
                    $target_dir = $new_dir . '/';
                    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
                    $fileName=basename($_FILES["fileToUpload"]["name"]);
                    $uploadOk = 1;
                    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
                    
                    // Check if file is a actual or fake file
                    if(isset($_POST["submit"])) {
                        $check = filesize($_FILES["fileToUpload"]["tmp_name"]);
                        if($check !== false) {
                            echo "File is valid - " . $check["mime"] . ".";
                            $uploadOk = 1;
                        } else {
                            echo "File is not in valid format.";
                            $uploadOk = 0;
                        }
                    }
                    
                    /*
                    // Check if file already exists
                    if (file_exists($target_file)) {
                        echo "Sorry, file already exists.";
                        $uploadOk = 0;
                    }
                    */
                    
                    // Check file size
                    if ($_FILES["fileToUpload"]["size"] > 500000000) {
                        echo "Sorry, your file is too large.";
                        $uploadOk = 0;
                    }
                    
                    // Check if $uploadOk is set to 0 by an error
                    if ($uploadOk == 0) {
                        echo "Sorry, your file was not uploaded.";
                    
                        // if everything is ok, try to upload file
                    } else {
                        $new_folder = getLabel($target_file);
                        echo '<br>Target File name: ' . $target_file;
                        echo '<br>new folder label: ' . $new_folder;

                        $new_path = $base_dir . '/Images/' . $new_folder . '/' . $fileName;
                        echo "<br>new path: $new_path";

                        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $new_path)) {
                            echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
                        } else {
                            echo "Sorry, there was an error uploading your file.";
                        }
                    }
                        
                    /*
                    * when file is uploaded save the corresponding data in the database
                    */
                    $db = new Database();
                    
                    if($db->connect()){
                        $query="INSERT INTO details(fname,question,answer,username,filepath) VALUES
                                ('" .$fname. "','".$question."','" .$answer. "','" .$name. "','" .$fileName. "')";
                        $db->sql($query);
                        $res = $db->getResult();
                        print_r($res);

                        $db->disconnect();
                        echo '<script language="javascript">';
                        echo 'alert("uploaded to => ' . $new_folder . '");';
                        echo 'window.location = "upload.php"';
                        echo '</script>';
                        //header('Location:upload.php');
                    }else{
                        echo 'Database Connection error';
                    }
                }
                else
                {
                    echo 'no permission to view this page';
                }
            }

            
        ?>
        <br>
        <span style="float:center;color:red;"><a href="index.php">Logout</a></span>
    </body>
</html>