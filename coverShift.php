<?php
require'core/coreSessions.php';
require'core/db_connect.php';
$json = file_get_contents('php://input');

if(!empty($json)){
    
    $data =  json_decode($json, 1);
    
    if(!$con) {
        die("connection failed:".mysqli_connect_error());
    }
            $user_id=1;
            $jobTitle = mysqli_real_escape_string($con, $data['jobTitle']);
            $companyName = mysqli_real_escape_string($con, $data['companyName']);
            $companyAddress = mysqli_real_escape_string($con, $data['companyAddress']);
            $city = mysqli_real_escape_string($con, $data['city']);
            $state = mysqli_real_escape_string($con, $data['state']);
            $zip = mysqli_real_escape_string($con, $data['zip']);

            $sqlSert = "INSERT into coverShift 
                        (user_id, jobTitle, 
                        companyName, companyAddress, 
                        city, state, 
                        zip)
                        values 
                        ('{$user_id}','{$jobTitle}',
                        '{$companyName}', '{$companyAddress}', 
                        '{$city}', '{$state}', 
                        '{$zip}')";

            $results = mysqli_query($con, $sqlSert);    
            
            if($results){

            $sql = "SELECT * 
                    FROM launchLocation 
                    WHERE jobTitle LIKE '%$jobTitle%' 
                    AND companyName LIKE '%$companyName%' 
                    AND companyAddress LIKE '%$companyAddress%' 
                    AND city LIKE '%$city%' 
                    AND state LIKE '%$state%' 
                    AND zip LIKE '%$zip%'";
        
            $result = mysqli_query($con, $sql);
            }

            if($result){
                $output = [
                    'success'=>true,
                    'results'=>$result
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

 
    echo('{success:false, }');

