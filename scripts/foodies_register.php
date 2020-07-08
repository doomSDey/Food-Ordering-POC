
<?php

session_start();

require_once 'DbOperations.php';

$response = array();

if ($_SERVER['REQUEST_METHOD']=='POST') {
	if (isset($_POST['uname']) and
	isset($_POST['email']) and
	isset($_POST['psw'])) {
		//operate the data further

		$db = new DbOperations();
		$isveg;
		if (isset($_POST['isveg'])) {
			$isveg=1;
		} else {
			$isveg=0;
		}

		$result = $db->createFoodietUser(
			$_POST['uname'],
			$_POST['psw'],
			$_POST['email'],
			$isveg
		);

		if ($result == 1) {
			$response['error'] = false;
			$response['message'] = "Success";
			$_SESSION["email"] = $_POST['email'];
			$_SESSION["type"] = "foodies";
		} elseif ($result == 2) {
			$response['error'] = true;
			$response['message'] = "Error";
		} elseif ($result == 0) {
			$response['error'] = true;
			$response['message'] = "Already registered";
		}
	} else {
		$response['error'] = true;
		$response['message'] = "Required fields are missing";
	}
} else {
	$response['error'] = true;
	$response['message'] = "Invalid Request";
}

echo json_encode($response);

if($_POST['id']==1 && 	$response['error'] == true){
	header("Location: ../Index.php"."?msg=".urlencode(base64_encode($response['message'])));
}else{
	header("Location:../Menu.php"."?msg=".urlencode(base64_encode($response['message'])));
}

die();
