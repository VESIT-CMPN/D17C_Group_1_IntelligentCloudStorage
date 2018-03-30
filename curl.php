<?php
	$target_url = "http://suzukinakamura.pythonanywhere.com/upload";           
    $fname = 'test.jpg';

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
        echo "Error sending" . $fname .  " " . curl_error($ch);
        curl_close ($ch);
    }else{
        curl_close ($ch);
        echo  "Result: " . $result;
    }
?>