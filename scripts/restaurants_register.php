
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

        $result = $db->createRestaurantUser(
            $_POST['uname'],
            $_POST['psw'],
            $_POST['email']
        );
        if ($result == 1) {
            $response['error'] = false;
            $response['message'] = "User registered successfully";
            $_SESSION["email"] = $_POST['email'];
            $_SESSION["type"] = "restaurants";
        } elseif ($result == 2) {
            $response['error'] = true;
            $response['message'] = "Some error occurred please try again";
        } elseif ($result == 0) {
            $response['error'] = true;
            $response['message'] = "It seems you are already registered, please choose a different email and username";
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

if ($_POST['id']==1 && 	$response['error'] == true) {
    header("Location: ../Index.php"."?msg=".urlencode(base64_encode($response['message'])));
} else {
    header("Location:../RestaurantHome.php"."?msg=".urlencode(base64_encode($response['message'])));
}
die();
