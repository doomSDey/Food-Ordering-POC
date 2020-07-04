<?php

class DbOperations{

	private $con;

	function __construct(){

		require_once dirname(__FILE__).'/DbConnect.php';

		$db = new DbConnect();

		$this->con = $db->connect();

	}


	private function isUserExist($username, $email){
	$stmt = $this->con->prepare("SELECT id FROM users WHERE regdNo = ? OR email = ?");
	$stmt->bind_param("ss", $username, $email);
	$stmt->execute();
	$stmt->store_result();
	return $stmt->num_rows > 0;
}

}
