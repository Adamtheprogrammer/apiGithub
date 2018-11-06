<?php
require'core/coreSessions.php';
require'core/db_connect.php';

$sql = "SELECT * FROM  users WHERE id = {$_SESSION['user']['id']}";

$results = mysqli_query($con, $sql);   
while($row = mysqli_fetch_object($results)){
    $email = $row->email;

//var_dump($row);
}


$sql = "SELECT * FROM  user_profile WHERE id = {$_SESSION['user']['id']}";

$results = mysqli_query($con, $sql);   
while($row = mysqli_fetch_object($results)){
    $fname = $row->fname;
    $lname = $row->lname;
    $photoid = $row->photoid;
  
//var_dump($row);
}




$sql = "SELECT * FROM  clocked_out WHERE id = {$_SESSION['user']['id']}";

$results = mysqli_query($con, $sql);   
while($row = mysqli_fetch_object($results)){
    $clockOutTime = -$row->clockOutTime;
    $clockOutDate = -$row->clockOutDate;
    $photoDutyOut = $row->photoDutyOut;
    $photoLogoOut = $row->photoLogoOut;
   

    if($results){
        $output = [
            'success'=>true,
        ];
        echo json_encode($output);
    }else{
        $output = [
            'success'=>false,
            'errors'=>[] //return anyknow errors to the API
        ];
        echo json_encode($output);
    }
    
//var_dump($row);
}



$content = <<<EOT

<html>
    <body>
            <div style="width:150px; height:200px;">{$photoid}</div>
            // schedule
            <p>{$fname}, {$lname} the {$jobTitle} at {$email} has Finished a scheduled Shift at:</p>
            <p>{$companyName}, {$companyAddress}, {$zip}</p>
            <p>On {$clockOutTime}, {$clockOutDate}, {$photoDutyOut}, {$photoLogoOut}</p>
            <p>Time Clocked Out: </p>

	</body>
</html>
EOT;
echo $content;
