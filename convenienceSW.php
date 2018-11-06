<?php
require'core/coreSessions.php';
require'core/db_connect.php';
require'../config/keys.php';
$json = file_get_contents('php://input');

include 'core/Adami/src/Validation/Validate.php';
require 'vendor/autoload.php';

use Mailgun\Mailgun;

$mgClient = new Mailgun(MG_KEY);
$domain = MG_DOMAIN;



if(!empty($json)){
    
    $data =  json_decode($json, 1);
   
        if(!$con) {
            die("connection failed:".mysqli_connect_error());
        }
            $user_id = $_SESSION['user']['id'];   
            $stillCover = $data['stillCover'];
            $contactedAuthC = $data['contactedAuthC'];
            $convAuthRep = mysqli_real_escape_string($con, $data['convAuthRep']);
            $convExplain = mysqli_real_escape_string($con, $data['convExplain']);
            $convMessage = mysqli_real_escape_string($con, $data['convMessage']);
            
            
            $sql = "INSERT into convenienceSw 
                    (user_id, contactedAuthC, convAuthRep, 
                    convExplain, stillCover, 
                    convMessage) 
                    values 
                    ('{$user_id}', '{$contactedAuthC}',
                    '{$convAuthRep}', '{$convExplain}',
                    '{$stillCover}', 
                    '{$convMessage}')";

            $results = mysqli_query($con, $sql);
            //var_dump(mysqli_error($results));

        if($results){
            $user_id = $_SESSION['user']['id'];
            $switch_details_id = $data['switch_details_id'];

            $sql = "SELECT *
                    FROM  users 
                    WHERE id = {$user_id}";

            $results = mysqli_query($con, $sql); 

        while($row = mysqli_fetch_object($results)){

            $email = $row->email;
        }

            $sql = "SELECT * 
                    FROM  user_profile 
                    WHERE user_id = {$user_id}";

            $results = mysqli_query($con, $sql);   
        while($row = mysqli_fetch_object($results)){
            $fname = $row->fname;
            $lname = $row->lname;
            $photoid = $row->photoid;
        

        }


            $sql = "SELECT * 
                    FROM  switchLocation 
                    WHERE id = {$switch_details_id}";

            $results = mysqli_query($con, $sql);   
        while($row = mysqli_fetch_object($results)){
            $jobTitle = $row->jobTitle;

        }

        $sql = "SELECT * 
                FROM  switchDetails 
                WHERE id = {$switch_details_id}";

        $results = mysqli_query($con, $sql);   
            while($row = mysqli_fetch_object($results)){
                $authOff = $row->authOff;
                $swDate = $row->swDate;
                $swStart = $row->swStart;
                $swEnd = $row->swEnd;
                $ovHours = $row->ovHours;


        }
      
        $sql = "SELECT * 
                FROM  convenienceSw 
                WHERE switch_details_id = {$switch_details_id}";

        $results = mysqli_query($con, $sql);

            while($row = mysqli_fetch_object($results)){
                $contactedAuthC = $row->contactedAuthC;
                $convAuthRep = $row->convAuthRep;
                $convExplain = $row->convExplain;
                $stillCover = $row->stillCover;
                $convMessage = $row->convMessage;

            if($results){
                $output = [
                    'success'=>true,//nav push to thank you and waiting for authorization
                ];
                echo json_encode($output);
            }else{
                $output = [
                    'success'=>false,
                    'errors'=>[] //return anyknow errors to the API
                ];
                echo json_encode($output);
            }

        
            }
            
    $data = $_GET; 
    $id = $con->insert_id;
$html = <<<EOT




        <div style="width:150px; height:200px;">{$photoid}</div>
            // schedule
            <h3>{$fname}, {$lname} the {$jobTitle} at {$email} has placed a schedule on launch</h3>
            <p>{$swDate}, {$swStart}, {$swEnd}, {$ovHours} </p>
            // reasoning
            <h2>Reasoning Type</h2>
            <h4><b>Convenience</b></h4>  
            <strong for="contactedAR">Have you contacted A Company Authority Representative?</strong>
                <br>{$contactedAuthC}
            <strong for="convExplain">If no, Explain </strong>
                <br> {$convAuthRep}
            <strong for="convExplain">If no, Explain </strong>
                <br> {$convExplain}    
            <strong for="stillCover">Can you still fill your schedule, if no one is available to cover?</strong>
                <br>{$stillCover}
            <strong for="message">Message</strong>
                <br>{$convMessage}

        </div>


<a href="http://localhost/api/authorize.php?id={$id}&authorize=1" name="authorize" id="formControl">Authorization</a>
<a href="http://localhost/api/authorize.php?id={$id}&unauthorized=0" name="unauthorized" id="formControl">Decline Authorization</a> 

EOT;

    //var_dump($html);
    $authOffEmail = 'adami.hyeyah@gmail.com';
    $result = $mgClient->sendMessage("$domain",
        array('from'    => 'Shifty <shifty@gmail.com>',
                'to'      => $authOffEmail,
                'subject' => 'shift Notification',
                'text'    => 'You are being notified because you have a schedule In need of authorization.',
                'html'    => $html,
            ));//var_dump($result);
        }
    }

                                      
        $output = [
            'success'=>true,
            'id'=>$con->insert_id
        ];
        echo json_encode($output);die();
    
        $output = [
            'success'=>false,
            'errors'=>[] //return anyknow errors to the API
        ];
        echo json_encode($output);die();
    
    echo('{success:false, }');
   
    
?>

