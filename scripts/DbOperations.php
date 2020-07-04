<?php

class DbOperations{

		private $con;

		function __construct(){

		include_once 'DbConnect.php';

		$db = new DbConnect();

		$this->con = $db->connect();

	}

	public function createUser($uname, $psw, $email){
		if($this->isUserExist($email)){
			return 0;
		}else{
			$password = md5($psw);
			$stmt = $this->con->prepare("INSERT INTO `restaurants` (`name`, `password`, `email`) VALUES (?, ?, ?);");
			$stmt->bind_param("sss",$uname,$psw,$email);

			if($stmt->execute()){
				return 1;
			}else{
				return 2;
			}
		}
	}

	public function isUserExist($email){
		$stmt = $this->con->prepare("SELECT `email` FROM `restaurants` WHERE `email` = ?");
		$stmt->bind_param("s",  $email);
		$stmt->execute();
		$stmt->store_result();
		return $stmt->num_rows>0;
	}

}
