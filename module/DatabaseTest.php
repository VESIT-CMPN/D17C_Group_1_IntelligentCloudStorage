<?php
	header('content-type: application/json; charset=utf-8');
	include 'class/Database.php';
	
	$db = new Database();
	
	if($db->connect()){
		$db->select('pb_candidate_details');
		$res = $db->getResult();
		echo json_encode($res);
	}else{
		echo 'connection failed\n';
	}
	
?>