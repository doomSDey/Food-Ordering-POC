
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
		} elseif ($res == 1) {
			$addr='../RestaurantHome.php';
			$_SESSION["email"] = $_POST['email'];
			$_SESSION["type"] = "restaurants";
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
echo $_SESSION["email"];
echo json_encode($response);
if ($addr) {
	header("Location: $addr"."?msg=".urlencode(base64_encode("Success!")));
} else {
	header("Location:../index.php?msg=". urlencode(base64_encode("Error!")));
}
die();
