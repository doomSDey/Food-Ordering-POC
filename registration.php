<?php
  session_start();
  $con = mysqli_connect('localhost','confuse','password','confusion');

  if($con){
    echo "Connection Successful";
  }else{
    echo "No connection";
  }

  if(mysqli_select_db($con,'confusion'))
    echo "Yes";
    else {
      echo "No";
      // code...
    }

  $name = $_POST['uname'];
  $email = $_POST['email'];
  $pass = $_POST['psw'];

  $q = "select * from resturants where email = '$email' ";

  $result = mysqli_query($con,$q);

  $num = mysqli_num_rows($result);
  if($num == 1){
    echo "Duplicate Data";
  }
  else{
    $qy = "insert into resturants(name , email , password) values ('$name','$email','$pass')";
    mysqli_query($con,$qy);
  }

  if ($con->query($qy) === TRUE) {
  echo "New record created successfully";
  } else {
  echo "Error: " . $qy . "<br>" . $con->error;
  }
?>
