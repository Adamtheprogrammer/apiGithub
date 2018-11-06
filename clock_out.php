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
            
            $clockOutTime = $data['clockOutTime'];
            $clockOutDate = $data['clockOutDate'];
            $photoDutyOut = $data['photoDutyOut'];
            $photoLogoOut = $data['photoLogoOut'];
            $clocked_Out = $data['clocked_Out'];
            
            $sql = "INSERT into clock_out 
                    (clockOutTime, clockOutDate, 
                    photoDutyOut, photoLogoOut, 
                    clocked_Out) 
                    values ('{$clockOutTime}', '{$clockOutDate}', 
                    '{$photoDutyOut}', '{$photoLogoOut}', 
                    '{$clocked_Out}')";
        
        
            if(mysqli_query($con, $sql)){
                $html  = file_get_contents('clock_out_email.php'); // this will retrieve the html document
                
                $result = $mgClient->sendMessage("$domain",
                    array('from'    => 'Shifty <shifty@gmail.com>',
                          'to'      => $authOffEmail,
                          'subject' => 'Ending Shift Notification',
                          'text'    => 'You are being notified because A Schedule You authorized has ended.',
                          'html'    =>  $html,
                          ));
            
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