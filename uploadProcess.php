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
            
            function startIntelligentAnalysis(){
                $python='C:\\Python27\\python.exe';
                $file = 'C:\\xampp\\htdocs\\CloudStorage\\drive\\' . $_SESSION["username"] . '\\Image_Classification_Clustering.py';
                $cmd= "$python  $file";
                echo $cmd;
                exec("$cmd",$output);
                print_r($output);
            }

            if(isset($_GET["debug"])){
                echo "analysis started<br>";
                startIntelligentAnalysis();
                echo "<br>Analysis Ended";
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
                    
                    // Check if file already exists
                    if (file_exists($target_file)) {
                        echo "Sorry, file already exists.";
                        $uploadOk = 0;
                    }
                    
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
                        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                            echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
                            $fileName=basename($_FILES["fileToUpload"]["name"]);
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
                        startIntelligentAnalysis();
                        header('Location:upload.php');
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