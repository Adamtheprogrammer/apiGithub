<?php
require'core/coreSessions.php';
require'core/db_connect.php';
$json = file_get_contents('php://input');

if(!empty($json)){
    
    $data =  json_decode($json, 1);
    
    if(!$con) {
        die("connection failed:".mysqli_connect_error());
    }
        $user_id = $_SESSION['user']['id'];
        $jobTitle = mysqli_real_escape_string($con, $data['jobTitle']);
        $companyName = mysqli_real_escape_string($con, $data['companyName']);
        $companyAddress = mysqli_real_escape_string($con, $data['companyAddress']);
        $city = mysqli_real_escape_string($con, $data['city']);
        $state = mysqli_real_escape_string($con, $data['state']);
        $zip = mysqli_real_escape_string($con, $data['zip']);


        $sql = "INSERT into launchLocation 
                (user_id, jobTitle, 
                companyName, companyAddress,    
                city, state, 
                zip)
                values ('{$user_id}','{$jobTitle}',
                '{$companyName}', '{$companyAddress}', 
                '{$city}', '{$state}', 
                '{$zip}')";
            
        $result = mysqli_query($con, $sql);
        //var_dump(mysqli_error($con));
        //var_dump($con->insert_id);die();
        if($result){
            $output = [
                'success'=>true,
                'id'=>$con->insert_id
            ];
            echo json_encode($output);die();
        }else{
            $output = [
                'success'=>false,
                'errors'=>[] //return anyknow errors to the API
            ];
            echo json_encode($output);die();
        }

    }


    echo('{success:false, }')
?>