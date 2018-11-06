
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
        $launch_location_id = mysqli_real_escape_string($con, $data['launch_location_id']);
        $authOff = mysqli_real_escape_string($con, $data['authOff']);
        $authOffEmail = mysqli_real_escape_string($con, $data['authOffEmail']);
        $shDate = $data['shDate'];
        $shStart = $data['shStart'];
        $shEnd = $data['shEnd'];
        $ovHours = mysqli_real_escape_string($con, $data['ovHours']);
        

        $sql = "INSERT into launchDetails 
                (user_id, launch_location_id, 
                authOff, authOffEmail, 
                shDate, shStart, 
                shEnd, ovHours)
                values ('{$user_id}','{$launch_location_id}',
                '{$authOff}', '{$authOffEmail}', 
                '{$shDate}', '{$shStart}',
                '{$shEnd}', '{$ovHours}')";

        $result = mysqli_query($con, $sql);
        //var_dump(mysqli_error($con));
        //var_dump(mysqli_error($result));
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