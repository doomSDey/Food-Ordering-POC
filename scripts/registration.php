<?php
  session_start();
  $con = mysqli_connect('localhost','confused','password','confusion');

  if($con){
    echo "Connection Successful";
  }else{
    echo "No connection";
  }

  if (isset($_POST['submit'])){
  $name = isset($_POST['uname']);
  $pass = isset($_POST['psw']);
  $email = isset($_POST['email']);
  echo $uname;
  echo $pass;
} else {
  echo "No submit detected!";
}

  $name = $_POST['uname'];
  $email = $_POST['email'];
  $pass = $_POST['psw'];

  $q = "select * from restaurants where email = '$email' ";

  $result = mysqli_query($con,$q);
  echo "'$uname' uname";
  $num = mysqli_num_rows($result);
  if($num == 1){
    echo "Duplicate Data";
  }
  else{
    $qy = "insert into restaurants(name , email , password) values ('$name','$email','$pass')";
    mysqli_query($con,$qy);
  }

  if ($con->query($qy) === TRUE) {
  echo "New record created successfully";
  } else {
  echo "Error: " . $qy . "<br>" . $con->error;
  }
?>
