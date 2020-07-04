
<?php

session_start();

require_once 'DbOperations.php';

$response = array();
$addr;
if($_SERVER['REQUEST_METHOD']=='POST'){
	if(isset($_POST['email']) and
				isset($_POST['psw']))
		{
		//operate the data further

		   $db = new DbOperations();
       $res=$db->userLogin($_POST['email'], $_POST['psw']);
       if($res == 2){
   			$addr='http://localhost/skel/Menu.php';
				$_SESSION["email"] = $_POST['email'];
				$_SESSION["type"] = "foodies";
   		}else if($res == 1){
        $addr='http://localhost/skel/index.php';
				$_SESSION["email"] = $_POST['email'];
				$_SESSION["type"] = "restaurants";
      }
      else {
   			$response['error'] = true;
   			$response['message'] = "Invalid username or password";
   		}

  	}else{
  		$response['error'] = true;
  		$response['message'] = "Required fields are missing";
  }
}else{
	$response['error'] = true;
	$response['message'] = "Invalid Request";
  }
echo $_SESSION["email"];
echo json_encode($response);
header("Location: $addr");
die();
