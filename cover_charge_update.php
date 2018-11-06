<?php
require'core/coreSessions.php';
require'core/db_connect.php';
require'../config/keys.php';
$data  = $_GET;
include 'core/Adami/src/Validation/Validate.php';
require 'vendor/autoload.php';

use Mailgun\Mailgun;

$mgClient = new Mailgun(MG_KEY);
$domain = MG_DOMAIN;




//$json = file_get_contents('php://input');

		if(isset($data['authorize'])){
			
			//data-key="<?php echo $stripe['publishable_key'];
			echo'<html>
					<body>
						<div>
							<form action="charge_card.php" method="post">
								<script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
									data-key="<?php echo $stripe[pk_test_wm1pDPaaf0ILfe7AC66JHIfC]"
									data-description="charge per fulfillment"
									data-amount="250"
									data-locale="auto">
								</script>
								
							</form>
						</div>
					</body>
				</html>';
		
			$token = $_POST['stripeToken'];
			$email = $_POST['stripeEmail'];
			
			$customer = \Stripe\Charge::create(array(
			'email' => $email,
			'source' => $token));
			
			$charge = \stripe\charge::create(array(
			'customer' => $customer->id, 
			'amount' => 300, 
			'currency' => 'usd'));
			echo'<h1>Successfully charged $3.00!</h1>';
			
			
					if($charge == true) {
						
						$sql = "Update shiftSwitch 
								SET $shDate='', $shStart='', 
								$shEnd='', $ovHours='' ";					
						$result = mysqli_query($con, $sql);
						
						if($result) {

							 $html  = file_get_contents('cover_sched_email.php'); // this will retrieve the html document

							 $mailResult = $mgClient->sendMessage("$domain",
                					array('from'    => 'Shifty <shifty@gmail.com>',
									'to'      =>  $email,
									'subject' => 'You Just Cover A Shift',
									'text'    => 'You are being notified because You confirmed You Will Be Covering A Scheduled Shift.',
									'html'    =>  $html,
									));
							
						}
						if($mailResults){
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


						
						
						
						}else{					
							echo'There Was A Problem Charging Your Card. Please Re enter Your Card Details And Try Again';	
							header('Location: index.php');
							
					}
				
			
			
				}	
							
		
		
		
					
	

?>