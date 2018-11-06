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

   
$htmlDisapprove = <<<EOT
<div class="jumbotron text-xs-center">
    <h1 class="display-3">Thank You!</h1>
    <h2 class="display-2">Your Unauthorization Was Declared</h2>
    <p class="lead"><strong>Your Disapproval Has Been Annouced</strong> 
        We Will Contact You When Other Shift Need Authorization.</p>
    <hr>
</div>
EOT;

if(isset($data['unauthorized'])){
    echo $htmlDisapprove;

    $sql = "UPDATE launchDetails
    SET unauthorized = {$_GET['unauthorized']} 
    WHERE id={$_GET['id']}";
    
    $results = mysqli_query($con, $sql);

    if($results){
        //Email this session user authorization confirmation
        $authOffEmail = 'adami.hyeyah@gmail.com';
        $result = $mgClient->sendMessage("$domain",
            array('from'    => 'Shifty <shifty@gmail.com>',
                    'to'      => $authOffEmail,
                    'subject' => 'shift Notification',
                    'text'    => 'Shift Authorized',
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

echo('{success:false, }') 

?>