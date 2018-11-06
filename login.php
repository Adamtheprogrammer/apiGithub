<?php
session_start();
require'core/db_connect.php';
$json = file_get_contents('php://input');


if (!empty($_POST)){
	
		session_start();
		$_SESSION =[];
		$_SESSION['user'] = [];
		$_SESSION['user']['id'] = 1;
		header('LOCATION:launchDetails.php');

}


$username = $password = "";
$username_err = $password_err = "";

	if ($_SERVER["REQUEST_METHOD"] == "POST"){
		
		if(empty(trim($_POST["username"]))) {
			
			$username_err = 'Please enter your username.';
		
		}else{
			
			$username = trim($_POST['username']);
		}
		
				if(empty(trim($_POST['password']))){
					$password = 'Please enter your password';
				}else{
					
					$password = trim($_POST['password']);
				}
				
						if(empty($username_err) && empty($password_err)){
			
								$sql = "SELECT username, password FROM users WHERE username = ?";
	
	
														if($stmt = mysqli_prepare($con, $sql)) {
															
															mysqli_stmt_bind_param($stmt, "s", $param_username);
															
															$param_username = $username;
															
																if(mysqli_stmt_execute($stmt)){
																	
																	mysqli_stmt_store_result($stmt);
																	
																	
																			if(mysqli_stmt_num_rows($stmt) == 1) {
																				
																				mysqli_stmt_bind_result($stmt, $username, $hashed_password); 
																					
													
																						
																						if(mysqli_stmt_fetch($stmt)){
																							
																							if($password_verify($password, $hashed_password)){
																							
																							session_start();
																							$_SESSION['username'] = $username;
																							header("location: main_menu.php");
																							
																							
																						}else{
																							
																							$password_err = 'The password you entered is not valid';
																							
																					}
																						
																				}
																				
																			}else {
																				
																				
																				$username = 'No account found with that username.';
																		}
														
																}else{
																	
																	echo "Oops! Something went wrong. Please try again later";
																}
					
					
					
														}
														
														mysqli_stmt_close($stmt);
														
													}
					
											mysqli_close($con);

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
											
					
				}

$meta = [];
$meta['title']='login';


$content =<<<EOT


                
                
                <form action="login.php" method="post">
                    <input type="hidden" name="_subject" value="Log In">
                    <input type="hidden" name="_next" value="main.php" />
                
                    
                        <div class="form-row">
                            <div class="col-md-4 mb-3">
                            <label for="username">Username</label>
                                <input type="text" name="username" class="form-control" placeholder="username" required>
                            
                            </div>
                                
                            <div class="col-md-4 mb-3">
                            <label for="email">password</label>
                                <input type="text" name="password" class="form-control" placeholder="password" required>
                            
                            </div>
                            
                            
                            <div class="col-md-4 mb-3">
                                <input type="submit" name="login" class="form-control">
                            </div>
                    </form>  

EOT;

?>
<form method="post">
<input name="id" value="1">
<input type="submit">
</form>



