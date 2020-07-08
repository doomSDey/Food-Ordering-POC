
<?php

session_start();

require_once 'DbOperations.php';

$response = array();

if($_SERVER['REQUEST_METHOD']=='POST'){
	if(isset($_POST['uname']) and
			isset($_POST['email']) and
				isset($_POST['psw']))
		{
		//operate the data further

		   $db = new DbOperations();
			 $isveg;
			 if(isset($_POST['isveg'])){
				 $isveg=1;
			 }else{
				 $isveg=0;
			 }

		   $result = $db->createFoodietUser( $_POST['uname'],
									$_POST['psw'],
									$_POST['email'],
									$isveg );

  		if($result == 1){
  			$response['error'] = false;
  			$response['message'] = "User registered successfully";
				$_SESSION["name"] = "$uname";
				$_SESSION["email"] = "$email";
				$_SESSION["type"] = "foodies";
  		}elseif($result == 2){
  			$response['error'] = true;
  			$response['message'] = "Some error occurred please try again";
  		}elseif($result == 0){
  			$response['error'] = true;
  			$response['message'] = "It seems you are already registered, please choose a different email and username";
  		}
  	}else{
  		$response['error'] = true;
  		$response['message'] = "Required fields are missing";
  }
}else{
	$response['error'] = true;
	$response['message'] = "Invalid Request";
  }

echo json_encode($response);

header("Location:../Menu.php?msg=".urlencode(base64_encode("Success!")));
die();
