
<?php

session_start();

require_once 'DbOperations.php';

$response = array();

if($_SERVER['REQUEST_METHOD']=='POST'){
  print_r(isset($_POST['dishname']));
  if(isset($_POST['dishname']) and isset($_POST['price'])){
    $db = new DbOperations();
    $user = $db->getrestaurantname($_SESSION['email']);

    //Converting the checkbox value into boolean
    $isveg;
    if(isset($_POST['isveg'])){
      $isveg=1;
    }else{
      $isveg=0;
    }

    print_r($_POST);
    $FILES=$_POST['image'];
    $file=addslashes(file_get_contents($_FILES['image']["tmp_name"]));


    $res = $db->addfood($_POST['dishname'],$_POST['price'],$isveg,$_POST['image'],$user['name'],$_SESSION['email']);
    if($res == 1)
      $response['message'] = "Success";
    else
      $response['message'] = "Failed";

  }
  else{
    $response['error'] = true;
    $response['message'] = "Required fields are missing";
  }
}
echo json_encode($response);

//header("Location: http://localhost/skel/RestaurantHome.php");
die();
