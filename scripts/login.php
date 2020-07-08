
<?php

session_start();

require_once 'DbOperations.php';

$response = array();

$addr;

if ($_SERVER['REQUEST_METHOD']=='POST') {
	if (isset($_POST['email']) and
	isset($_POST['psw'])) {
		//operate the data further

		$db = new DbOperations();
		$res=$db->userLogin($_POST['email'], $_POST['psw']);
		if ($res == 2) {
			$addr='../Menu.php';
			$_SESSION["email"] = $_POST['email'];
			$_SESSION["type"] = "foodies";
			$response['message'] = "Success";
		} elseif ($res == 1) {
			$addr='../RestaurantHome.php';
			$_SESSION["email"] = $_POST['email'];
			$_SESSION["type"] = "restaurants";
			$response['message'] = "Success";
		} else {
			$response['error'] = true;
			$response['message'] = "Invalid username or password";
		}
	} else {
		$response['error'] = true;
		$response['message'] = "Required fields are missing";
	}
} else {
	$response['error'] = true;
	$response['message'] = "Invalid Request";
}
$_SESSION['index']=0;

if($response['error'] == true && $_POST['id']==1){
	header("Location:../Index.php"."?msg=".urlencode(base64_encode($response['message'])));
}else{
	header("Location:../Menu.php"."?msg=".urlencode(base64_encode($response['message'])));
}

if ($addr) {
	header("Location: $addr"."?msg=".urlencode(base64_encode($response['message'])));
}

die();
