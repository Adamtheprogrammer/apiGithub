
<?php
require'core/coreSessions.php';
require'core/db_connect.php';


$sql = "SELECT * 
		FROM shiftSwitch 
		WHERE jobTitle like '%$jobTitle%' 
		AND companyName LIKE '%$companyName%'
		AND companyAddress LIKE '%$companyAddress%' 
		AND city LIKE '%$city%' 
		AND state LIKE '%$state% 
		AND zip LIKE '%$zip%'";

		
$result = mysqli_query($con, $sql);
if($result){
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

?>
<!--- Display data in ionic format using ionic framework-->
