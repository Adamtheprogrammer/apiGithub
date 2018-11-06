<?php
require'core/coreSessions.php';
require'core/db_connect.php';
$json = file_get_contents('php://input');



include '../core/Adami/src/Validation/Validate.php';
require 'vendor/autoload.php';
use Mailgun\Mailgun;

$mgClient = new Mailgun(MG_KEY);
$domain = MG_DOMAIN;




if(!empty($json)){
    
    $data =  json_decode($json, 1);
        
    if(!$con) {
        die("connection failed:".mysqli_connect_error());
        }
            $user_id=1;
            $clockInTime = $data['clockInTime'];
            $clockInDate = $data['clockInDate'];
            $photoDutyIn = $data['photoDutyIn'];	
            $photoLogoIn = $data['photoLogoIn'];
            $clocked_in = $data['clocked_in'];
            
            $sql = "INSERT into clocked_in 
                    (clockInTime, clockInDate, 
                    photoDutyIn, photoLogoIn, 
                    clocked_in) 
            values ('{$clockInTime}', '{$clockInDate}', 
                    '{$photoDutyIn}', '{$photoLogoIn}', 
                    '{$clocked_in}')";
        
              
            if(mysqli_query($con, $sql)){
                $html  = file_get_contents('clock_in_email.php'); // this will retrieve the html document
                
                $result = $mgClient->sendMessage("$domain",
                    array('from'    => 'Shifty <shifty@gmail.com>',
                          'to'      => $authOffEmail,
                          'subject' => 'Starting Shift Notification',
                          'text'    => 'You are being notified because A Schedule You authorized is about to start.',
                          'html'    =>  $html,
                          ));
                  
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
      

}
echo('{success:false, }')
?>