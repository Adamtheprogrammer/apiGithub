<?php
require'core/coreSessions.php';
require'core/config_stripe.php';
require'core/db_connect.php';
include'core/Adami/src/Validation/Validate.php';
require'vendor/autoload.php';
require'../config/keys.php';
$data  = $_GET;

use Mailgun\Mailgun;

$mgClient = new Mailgun(MG_KEY);
$domain = MG_DOMAIN;



$json = file_get_contents('php://input');

$htmlApprove = <<<EOT
<div class="jumbotron text-xs-center">
  <h1 class="display-3">Thank You!</h1>
  <h2 class="display-2">Your Authorization Declared</h2>
  <p class="lead"><strong>Your Approval Has Been Declared</strong> 
  	We Will Contact You When Other Shift Need Authorization.</p>
  <hr>
</div>

EOT;




if(isset($data['authorize'])){
 //if authorization submit return true charge card 
	echo $htmlApproval;
	$chkData = 
	"SELECT * 
	FROM shiftSwitch 
	WHERE jobTitle 
	like '%$jobTitle%' AND companyName 
	LIKE '%$companyName%' AND companyAddress 
	LIKE '%$companyAddress%' AND city 
	LIKE '%$city%' AND state 
	LIKE '%$state% AND zip LIKE '%$zip%'";

	$checked = mysqli_query($con, $chkData);

	$queryResult = mysqli_num_rows($checked);

	if($queryResult > 0) {	
		if($queryResult){
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
/*
$content = <<<EOT

<html>
<body>
<form action="charge_switch_email.php" method="post">

	<div class="form-group">
		<label class="formControlSelect1">Please Select a Schedule and switch</label>
		<select class="form-control" id="formControlSelect1">
			
				<?php while($row = mysqli_fetch_array($result)): var_dump($row);?>
				
				<option value="<?php echo $row;?>">
					<?php echo $row;?>				  
				</option>
				
				<?php endwhile;?>
		</select>
	
	<button class="btn btn-primary" name="confirm" type="submit">Confirm</button>	
</form>
	
</body>


</html>

EOT;


	if(isset($data['confirm'])){

	
		//data-key="<?php echo $stripe['publishable_key'];
		echo'<html>
				<body>
					<div>
						<form action="your-server-side-code" method="POST">
							<script
							src="https://checkout.stripe.com/checkout.js" class="stripe-button"
							data-key="pk_test_wm1pDPaaf0ILfe7AC66JHIfC"
							data-amount="999"
							data-name="Stripe.com"
							data-description="Example charge"
							data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
							data-locale="auto"
							data-zip-code="true">
							</script>
				  		</form>
					</div>
				</body>
			</html>';
				
					// Set your secret key: remember to change this to your live secret key in production
			// See your keys here: https://dashboard.stripe.com/account/apikeys
			\Stripe\Stripe::setApiKey("pk_test_wm1pDPaaf0ILfe7AC66JHIfC");

			// Token is created using Checkout or Elements!
			// Get the payment token ID submitted by the form:
			$token = $_POST['stripeToken'];

			$charge = \Stripe\Charge::create([
				'amount' => 999,
				'currency' => 'usd',
				'description' => 'Example charge',
				'source' => $token,
			]);
		echo'<h1>Successfully charged $3.00!</h1>';
		
	
		if($charge == true) {
		
		$sql = "Update shiftSwitch 
				SET $swDay='', $swDate='', 
				$swStart='', $swEnd='',
				$ovHours='' 
				WHERE  user_id = {$_SESSION['user']['id']}";					
		$result = mysqli_query($con, $sql);
		
		if($result) {
		$html  = file_get_contents('switch_sched_email.php'); // this will retrieve the html document
		$mailResult = $mgClient->sendMessage("$domain",
			array('from'    => 'Shifty <shifty@gmail.com>',
			'to'      =>  $email,
			'subject' => 'SHIFT EXCHANGE ACCEPTED',
			'text'    => 'You are being notified because you had a shift in que for switch. Your Schedule has been authorized.',
			'html'    =>  $html,
			));
						
			}
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
						
				
				
			}else{					
				echo'There Was A Problem Charging Your Card. Please Re enter Your Card Details And Try Again';	
				header('Location: main_menu.php');
				
			}
				
			}
			
		}		
				
				
		if(isset($data['unauthorize'])){

			$html  = file_get_contents('cover_sched_email.php'); // this will retrieve the html document

			$mailResult = $mgClient->sendMessage("$domain",
					array('from'    => 'Shifty <shifty@gmail.com>',
					'to'      =>  $email,
					'subject' => 'You Just Cover A Shift',
					'text'    => 'You are being notified because You confirmed You Will Be Covering A Scheduled Shift.',
					'html'    =>  $html,
					));

				}
		
		
		
					
	*/

?>