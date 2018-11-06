<?php
require '../core/coreSessions.php';
require '../core/db_connect.php';
$user_id = 0;
$data = [];
$sql = "SELECT * FROM  users WHERE user_id = {$user_id}";


$results = mysqli_query($con, $sql);   
while($row = mysqli_fetch_object($results)){
   

$data[] = $row;
}

echo json_encode($data);