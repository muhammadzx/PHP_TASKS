<?php

header("content-Type: application/json charset=utf-8");
require_once "db.php";
$db = new DB_con();
$users = $db->fetchdata();
echo json_encode($users);

?>