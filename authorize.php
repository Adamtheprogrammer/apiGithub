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

$data = $_GET;




$htmlOffApprove = <<<EOT
<div class="jumbotron text-xs-center">
    <h1 class="display-3">Thank You!</h1>
    <h2 class="display-2">Your Authorization Declared</h2>
    <p class="lead"><strong>Your Approval Has Been Declared</strong> 
        We Will Contact You When Other Shift Need Authorization.</p>
    <hr>
</div>
EOT;

$htmlProceed = <<<EOT
<div class="jumbotron text-xs-center">
    <h1 class="display-3">Thank You!</h1>
    <h2 class="display-2">You have been Authorized</h2>
    <p class="lead"><strong>Proceed To ShiftMate To Search Compatible Shifts.</strong></p> 
    <hr>
</div>
EOT;

$htmlNoResults = <<<EOT
<div class="jumbotron text-xs-center">
    <h1 class="display-3">Thank You!</h1>
    <h2 class="display-2">You have been Authorized</h2>
    <p class="lead">Your Shift Is Now In the Portal Waiting for a shift mate.
    <strong>There are no shifts at the moment available. </strong>
    Please Seach Again Later.</p> 
    <hr>
</div>
EOT;

$htmlDisapprove = <<<EOT
<div class="jumbotron text-xs-center">
    <h1 class="display-3">Thank You!</h1>
    <h2 class="display-2">Your Unauthorization Was Declared</h2>
    <p class="lead"><strong>Your Disapproval Has Been Annouced</strong> 
        We Will Contact You When Other Shift Need Authorization.</p>
    <hr>
</div>
EOT;

    
   


    if(isset($data['authorize'])){
        
        $sql = "UPDATE launchDetails
        SET authorize = {$_GET['authorize']} 
        WHERE id={$_GET['id']}";
        
        $results = mysqli_query($con, $sql);
   
    if($results){//var_dump(mysqli_error($con));
           
        $chkData = "SELECT * 
        FROM switchLocation
        WHERE jobTitle like '%$jobTitle%'
        AND companyName LIKE '%$companyName%' 
        AND companyAddress LIKE '%$companyAddress%'
        AND city LIKE '%$city%'
        AND state LIKE '%$state%
        AND zip LIKE '%$zip%'";
    
        $checked = mysqli_query($con, $chkData);
    
        $queryResult = mysqli_num_rows($checked);
    
    //var_dump(mysqli_error($con));
    if($queryResult < 0){
        //Email this session user authorization confirmation
        $authOffEmail = 'adami.hyeyah@gmail.com';
        $result = $mgClient->sendMessage("$domain",
            array('from'    => 'Shifty <shifty@gmail.com>',
                    'to'      => $authOffEmail,
                    'subject' => 'shift Notification',
                    'text'    => 'Shift Authorized',
                    'html'    => $htmlNoResults,
                ));//var_dump($result);
            }
    
    
     }

   
    if($queryResult > 0){
        //Email this session user authorization confirmation
        $authOffEmail = 'adami.hyeyah@gmail.com';
        $result = $mgClient->sendMessage("$domain",
            array('from'    => 'Shifty <shifty@gmail.com>',
                    'to'      => $authOffEmail,
                    'subject' => 'shift Notification',
                    'text'    => 'Shift Authorized',
                    'html'    => $htmlProceed,
                ));//var_dump($result);
            }

       
 }

 if(isset($data['unauthorize'])){
    echo $htmlDisapprove;

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

