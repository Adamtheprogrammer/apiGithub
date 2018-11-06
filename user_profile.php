<?php
require'core/coreSessions.php';
require'core/db_connect.php';
$json = file_get_contents('php://input');

if(!empty($json)){
    
    $data =  json_decode($json, 1);
    
    if(!$con){
            die("connection failed:".mysqli_connect_error());
        }

                $fname = mysqli_real_escape_string($con, $data['fname']);
                $lname = mysqli_real_escape_string($con, $data['lname']);
                $address = mysqli_real_escape_string($con, $data['address']);
                $city = mysqli_real_escape_string($con, $data['city']);
                $state = mysqli_real_escape_string($con, $data['state']);
                $zip = mysqli_real_escape_string($con, $data['zip']);
                $cphone = mysqli_real_escape_string($con, $data['cphone']);
                $photoId = mysqli_real_escape_string($con, $data['photoId']);
                $user_Id = $data['user_Id'];
                


                $sql = "INSERT into users_profile 
                        (fname, lname, 
                        address, city, 
                        state, zip, cphone, 
                        photoId, user_Id) 
                        VALUES ('{$fname}','{$lname}', 
                        '{$address}', '{$city}', 
                        '{$state}', '{$zip}', 
                        '{$cphone}', '{$photoId}', 
                        '{$user_Id}')";

                $result = mysqli_query($con, $sql);

                if($result){
                    $output = [
                        'success'=>true
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

            
?>