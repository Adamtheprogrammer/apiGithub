<?php
require'core/coreSessions.php';
require'core/db_connect.php';

$json = file_get_contents('php://input');

if(!empty($json)){
    
    $data =  json_decode($json, 1);
  //var_dump($data);

    if(!$con) {
        die("connection failed:".mysqli_connect_error());
    }
    $user_id = $_SESSION['user']['id'];
    $switch_location_id = mysqli_real_escape_string($con, $data['switch_location_id']);
    $authOff = mysqli_real_escape_string($con, $data['authOff']);
    $authOffEmail = mysqli_real_escape_string($con, $data['authOffEmail']);
    $swDate = $data['swDate'];
    $swStart = $data['swStart'];
    $swEnd = $data['swEnd'];
    $ovHours = mysqli_real_escape_string($con, $data['ovHours']);
    

    $sql = "INSERT into switchDetails 
            (user_id, switch_location_id, 
            authOff, authOffEmail, 
            swDate, swStart, 
            swEnd, ovHours)
            values ('{$user_id}','{$switch_location_id}',
            '{$authOff}', '{$authOffEmail}', 
            '{$swDate}', '{$swStart}',
            '{$swEnd}', '{$ovHours}')";
    
      
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