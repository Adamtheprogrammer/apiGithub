<?php
require'core/coreSessions.php';
require'core/db_connect.php';
//require'../config/keys.php';
$json = file_get_contents('php://input');


if(!empty($json)){
    
    $data =  json_decode($json, 1);
    
        if(!$con) {
            die("connection failed:".mysqli_connect_error());
        }
        

        $user_id = $_SESSION['user']['id'];
        $base64 = $data['base64'];

        $sql = "INSERT into documentation 
                (user_id, launch_details_id, base64)
                values 
                ('{$user_id}','{$base64}')";
                

        $results = mysqli_query($con, $sql);


        if($results){
            console.log('Success');
        }


    }