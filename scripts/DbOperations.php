<?php

class DbOperations{

		private $con;

		function __construct(){

		include_once 'DbConnect.php';

		$db = new DbConnect();

		$this->con = $db->connect();

	}

	public function createResturantUser($uname, $psw, $email){
		if($this->isUserExistResturant($email)){
			return 0;
		}else{
			$password = md5($psw);
			$stmt = $this->con->prepare("INSERT INTO `restaurants` (`name`, `password`, `email`) VALUES (?, ?, ?);");
			$stmt->bind_param("sss",$uname,$password,$email);

			if($stmt->execute()){
				return 1;
			}else{
				return 2;
			}
		}
	}


	public function createFoodietUser($uname, $psw, $email,$isveg){
		if($this->isUserExistFoodie($email)){
			return 0;
		}else{
			$password = md5($psw);
			$stmt = $this->con->prepare("INSERT INTO `foodies` (`name`, `password`, `email`,`isveg`) VALUES (?, ?, ?, ?);");
			$stmt->bind_param("sssi",$uname,$password,$email,$isveg);

			if($stmt->execute()){
				return 1;
			}else{
				return 2;
			}
		}
	}

	public function isUserExistFoodie($email){
		$stmt = $this->con->prepare("SELECT `email` FROM `foodies` WHERE `email` = ?");
		$stmt->bind_param("s",  $email);
		$stmt->execute();
		$stmt->store_result();
		return $stmt->num_rows>0;
	}
	public function isUserExistResturant($email){
		$stmt = $this->con->prepare("SELECT `email` FROM `restaurants` WHERE `email` = ?");
		$stmt->bind_param("s",  $email);
		$stmt->execute();
		$stmt->store_result();
		return $stmt->num_rows>0;
	}

	public function userLogin($email,$psw){
		$password = md5($psw);
		$stmt = $this->con->prepare("SELECT email FROM `restaurants` WHERE email = ? AND password = ?");
		$stmt->bind_param("ss",$email,$password);
		$stmt->execute();
		$stmt->store_result();
		if( $stmt->num_rows <=0){
			$stmt = $this->con->prepare("SELECT email FROM `foodies` WHERE email = ? AND password = ?");
			$stmt->bind_param("ss",$email,$password);
			$stmt->execute();
			$stmt->store_result();
			echo $stmt->num_rows;

			if($stmt->num_rows>0)
				return 2;
			else {
				return 0;
			}
		}
		else{
			return 1;
		}
	}

	public function menudata(){
		$stmt = $this->con->prepare("SELECT * FROM `menu` ");
		$stmt->execute();
		return $stmt;
	}

	public function menudatares($email){
		$stmt = $this->con->prepare("SELECT * FROM `menu` WHERE resturant_email = ?");
		$stmt->bind_param("s",$email);
		$stmt->execute();
		return $stmt;
	}

	public function searchmenu($dish_name){
		$stmt = $this->con->prepare("SELECT * FROM `menu` WHERE dish_name = ?");
		$stmt->bind_param("s",$dish_name);
		$stmt->execute();
		return $stmt;
	}


}
