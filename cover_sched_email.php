<?php
require'core/coreSessions.php';
require'core/db_connect.php';

$sql = "SELECT * FROM  shiftLaunch WHERE id = {$_SESSION['user']['id']}";

$results = mysqli_query($con, $sql);   
while($row = mysqli_fetch_object($results)){
    $companyName = -$row->companyName;
    $companyAddress = -$row->companyAddress;
    $zip = $row->zip;
    $jobTitle = $row->jobTitle;
    $shDay = $row->shDay;
    $shDate = $row->shDate;
    $shStart = $row->shStart;
    $shEnd = $row->shEnd;
    $ovHours = $row->ovHours;

    if($results){
        $output = [
            'success'=>true,
        ];
        echo json_encode($output);die();
    }else{
        $output = [
            'success'=>false,
            'errors'=>[] //return anyknow errors to the API
        ];
        echo json_encode($output);die();
    }

var_dump($row);
}

$content = <<<EOT

<html>
    <body>
      
        //schedule
        <h2>YOUR SCHEDULE COVERED SHIFT</h2>
        <p>Coverage Has been Authorized and Confirmed. Now Here Is Your Shift Details.</p>
        <p>{$companyName}, {$companyAddress},{$city},{$state} {$zip}</p>
        <label for="medassist">Your New Required Schedule Job Title</label>
        <br>{$jobTitle}
        <label for="medassist">Your New Required Schedule Day</label>
            <br>{$shDay}
        <label for="contactedAR">Your New Required Schedule Date</label>
            <br>{$shDate}
        <label for="authRepName">Your New Required Schedule Shift Start </label>
            <br>{$shStart}
        <label for="emergExplain">Your New Required Schedule Shift End</label>
            <br>{$shEnd}
        <label for="emergExplain">Your New Required Schedule Overall Hours </label>
            <br>{$ovHours}
    
    </body>
</html>
EOT;

