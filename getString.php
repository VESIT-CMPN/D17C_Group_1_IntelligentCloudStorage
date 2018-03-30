<?php
define('ENV_STR', 'MYSQLCONNSTR_localdb');
$return = array('result' => false);
if (isset($_SERVER[ENV_STR])) {
    $connectStr = $_SERVER[ENV_STR];
    $return['connection'] = array(
        'host' => preg_replace("/^.*Data Source=(.+?);.*$/", "\\1", $connectStr),
        'database' => preg_replace("/^.*Database=(.+?);.*$/", "\\1", $connectStr),
        'user' => preg_replace("/^.*User Id=(.+?);.*$/", "\\1", $connectStr),
        'password' => preg_replace("/^.*Password=(.+?)$/", "\\1", $connectStr)
    );
    $return['result'] = true;
}
header('Content-Type: application/json; charset=utf-8');
echo json_encode($return);