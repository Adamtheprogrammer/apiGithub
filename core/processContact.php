
<?php 
include '../core/Adami/src/Validation/Validate.php';
include '../vendor/autoload.php';
require '../config/keys.php';

use Adami\Validation;
use Mailgun\Mailgun;


$mgClient = new Mailgun(MG_KEY);
$domain = MG_DOMAIN;


$filters = [
    'name'=>FILTER_SANITIZE_STRING,
    'email'=>FILTER_SANITIZE_EMAIL,
    'sub'=>FILTER_SANITIZE_STRING,
    'msg'=>FILTER_SANITIZE_STRING,
 ];
 $input = filter_input_array(INPUT_POST, $filters);//var_dump($input);die();

# You can see a record of this email in your logs: https://app.mailgun.com/app/logs

# Next, you should add your own domain so you can send 10,000 emails/month for free.
$valid = new Adami\Validation\Validate();


//$input = filter_input_array(INPUT_POST, $filters);
if(!empty($input)){
    $valid->validation = [
        'email'=>[[
            'rule'=>'email',
            'message'=>'Please enter a valid email'   
        ],[
            'rule'=>'notEmpty',
            'message'=>'Please enter an email'   
        ]],
        'name'=>[[
            'rule'=>'notEmpty',
            'message'=>'Please enter a name'     
        ]],
        'sub'=>[[
            'rule'=>'notEmpty',
            'message'=>'Please enter a Subject'     
        ]],

        'msg'=>[[
            'rule'=>'notEmpty',
            'message'=>'Please enter a message'     
        ]]

    ];
    $valid->check($input);
    if(empty($valid->errors)){
       // var_dump(MG_DOMAIN);
        # Instantiate the client.
        $mgClient = new Mailgun(MG_KEY);
        # Make the call to the client.
        $result = $mgClient->sendMessage(MG_DOMAIN,[
            'from'    => "{$input['name']} <{$input['email']}>",
            'to'      => 'AdamiYah <adami.hyeyah@gmail.com>',
            'subject' => $input['sub'],
            'text'    => $input['msg']
        ]);
        if($result->http_response_code == 200){
            return header('LOCATION: thanks.php');
        }
    }else{
        $message = '<div style="color:#ff0000">Your form has errors!</div>';
    }
}