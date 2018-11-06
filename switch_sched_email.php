<?php
require'core/coreSessions.php';
require'core/db_connect.php';

$sql = "SELECT * 
        FROM  shiftSwitch 
        WHERE id = {$_SESSION['user']['id']}";

$results = mysqli_query($con, $sql);   
while($row = mysqli_fetch_object($results)){
    $jobTitle = $row->jobTitle;
    $swDay = $row->swDay; 
    $swDate = $row->swDate;
    $swStart = $row->swStart;
    $swEnd = $row->swEnd;
    $ovHours = $row->ovHours;

//var_dump($row);
}

$content = <<<EOT

<html>
    <body>
      
        //schedule
        <h2>YOUR CONFIRMED SWITCHED SCHEDULE</h2>
        <p>Exchange Has been Authorized and Confirmed. Now Here Is Your Shift Details.</p>
        <p>{$companyName}, {$companyAddress}, {$zip}</p>
        
        <label for="medassist">Your New Required Schedule Day</label>
            <br>{$swDay}
        <label for="contactedAR">Your New Required Schedule Date</label>
            <br>{$swDate}
        <label for="authRepName">Your New Required Schedule Shift Start </label>
            <br>{$swStart}
        <label for="emergExplain">Your New Required Schedule Shift End</label>
            <br>{$swEnd}
        <label for="emergExplain">Your New Required Schedule Overall Hours </label>
            <br>{$ovHours}
    
    </body>
</html>
EOT;

