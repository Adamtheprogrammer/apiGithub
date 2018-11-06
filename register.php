<?php


require'core/db_connect.php';
$json = file_get_contents('php://input');


if(!empty($json)){
    
    $data =  json_decode($json, 1);
     
    $username = $data['username'];
    $password1 = $data['password1'];
    $password2 = $data['password2'];
    $email = $data['email'];

    if($password1 != $password2)
        header('Location: register.php');
        if(strlen($username) > 30)
            header('Location: register.php');

            $hash = hash('sha256', $password1);
            
            function createSalt(){
                    $text = md5(uniqid(rand(), true));
                    return substr($text, 0, 3);
                
            }
            
            $salt = createSalt();
            $password = hash('sha256', $salt.$hash);
            $username = mysqli_real_escape_string($con, $username);
            
            $query = "INSERT INTO users 
                      (username, password, 
                      email, salt) 
                      VALUES ('$username', $password, 
                      $email, $salt')"; 
            
            mysqli_query($con, $query);
            
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
?>




<!--"Create TABLE 'users' (
    'id' INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY, 
    'username' VARCHAR(30) NOT NULL'
    'password' VARCHAR(128) NOT NULL,
    'email' VARCHAR(50) NOT NULL,
    'salt' VARCHAR(128) NOT NULL,
    'trn_date' TIMESTAMP  
    )";-->

