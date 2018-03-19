<?php
header('content-type: application/json; charset=utf-8');
include('class/Database.php');
$db = new Database();
$db->connect();
$db->select('pb_candidate_details',
'pb_candidate_details.c_id,name,degree,experience,photo,c_rank',
'pb_candidate_list',
'pb_candidate_list.c_id=pb_candidate_details.c_id');

$res = $db->getResult();

echo json_encode($res);

$db->disconnect();