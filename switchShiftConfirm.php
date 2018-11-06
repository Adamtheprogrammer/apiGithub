<?php
require'core/coreSessions.php';
require'core/db_connect.php';
$json = file_get_contents('php://input');


if(!empty($json)){
    
    $data =  json_decode($json, 1);

    if(!$con) {
        die("connection failed:".mysqli_connect_error());
    }


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
					'success'=>true//NavPush to Ionic Success Page
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
            /*else{					
				echo'There Was A Problem Charging Your Card. Please Re enter Your Card Details And Try Again';	
				header('Location: main_menu.php');
				
			}*/
				

        }
    }
?>
<!--- Display data in ionic format using ionic framework-->