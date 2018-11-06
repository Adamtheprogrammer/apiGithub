<?php   

require_once('vendor/autoload.php');

	$stripe = array(
	
	"secret_key" => "sk_test_jlotYWW2cfwy2ff8AsrMasJO",	
	
	"publishable_key" => "pk_test_wm1pDPaaf0ILfe7AC66JHIfC");
	
	\Stripe\Stripe::setApiKey($stripe['secret_key']);

?>