<?php

//Intitializing connection
class DbOperations
{
	private $con;

	public function __construct()
	{
		include_once 'DbConnect.php';

		$db = new DbConnect();

		$this->con = $db->connect();
	}

//Functions

//Create New Resturant user
	public function createRestaurantUser($uname, $psw, $email)
	{
		if ($this->isUserExistRestaurant($email)) {
			return 0;
		} else {
			$password = md5($psw);
			$stmt = $this->con->prepare("INSERT INTO `restaurants` (`name`, `password`, `email`) VALUES (?, ?, ?);");
			$stmt->bind_param("sss", $uname, $password, $email);
			if ($stmt->execute()) {
				return 1;
			} else {
				return 2;
			}
		}
	}

//Create new Foodie User
	public function createFoodieUser($uname, $psw, $email, $isveg, $address)
	{
		if ($this->isUserExistFoodie($email)) {
			return 0;
		} else {
			$password = md5($psw);
			$stmt = $this->con->prepare("INSERT INTO `foodies` (`name`, `password`, `email`,`isveg`,`address`) VALUES (?, ?, ?, ?, ?);");
			$stmt->bind_param("sssis", $uname, $password, $email, $isveg,$address);

			if ($stmt->execute()) {
				return 1;
			} else {
				return 2;
			}
		}
	}

//Check if a particular foodie exists using email
	public function isUserExistFoodie($email)
	{
		$stmt = $this->con->prepare("SELECT `email` FROM `foodies` WHERE `email` = ?");
		$stmt->bind_param("s", $email);
		$stmt->execute();
		$stmt->store_result();
		return $stmt->num_rows>0;
	}

	//Check if a particular resturants exist in the table using email
	public function isUserExistRestaurant($email)
	{
		$stmt = $this->con->prepare("SELECT `email` FROM `restaurants` WHERE `email` = ?");
		$stmt->bind_param("s", $email);
		$stmt->execute();
		$stmt->store_result();
		return $stmt->num_rows>0;
	}

//Retrieve data from either foodie or restaurant table for login
	public function userLogin($email, $psw)
	{
		//Salting Password
		$password = md5($psw);
		$stmt = $this->con->prepare("SELECT email FROM `restaurants` WHERE email = ? AND password = ?");
		$stmt->bind_param("ss", $email, $password);
		$stmt->execute();
		$stmt->store_result();
		if ($stmt->num_rows <=0) {
			$stmt = $this->con->prepare("SELECT email FROM `foodies` WHERE email = ? AND password = ?");
			$stmt->bind_param("ss", $email, $password);
			$stmt->execute();
			$stmt->store_result();
			echo $stmt->num_rows;

			if ($stmt->num_rows>0) {
				return 2;
			} else {
				return 0;
			}
		} else {
			return 1;
		}
	}

	//Get all data from menu
	public function menudata()
	{
		$stmt = $this->con->prepare("SELECT * FROM `menu` ");
		$stmt->execute();
		return $stmt;
	}

	//get name from foodies using email
	public function getName($email)
	{
		$stmt = $this->con->prepare("SELECT name FROM `foodies` where email=? ");
		$stmt->bind_param("s", $email);
		$stmt->execute();
		return $stmt->get_result()->fetch_assoc();
	}

	//get all the items in cart corresponding to the given email
	public function cartData($email)
	{
		$stmt = $this->con->prepare("SELECT * FROM `cart` where cust_email = ? ");
		$stmt->bind_param("s", $email);
		$stmt->execute();
		return $stmt;
	}

	//get all items in order corresponding to given email
	public function orderData($email)
	{
		$stmt = $this->con->prepare("SELECT * FROM `orders` where restaurant_email = ? ");
		$stmt->bind_param("s", $email);
		$stmt->execute();
		return $stmt;
	}

	//get all items from menu for given restaurant email address
	public function menudatares($email)
	{
		$stmt = $this->con->prepare("SELECT * FROM `menu` WHERE restaurant_email = ?");
		$stmt->bind_param("s", $email);
		$stmt->execute();
		return $stmt;
	}

	//Get all data from menu corresponding to a given keyword using Regex
	public function searchmenu($dish_name)
	{
		$stmt = $this->con->prepare("SELECT * FROM `menu` WHERE dish_name REGEXP ?");
		$stmt->bind_param("s", $dish_name);
		$stmt->execute();
		return $stmt;
	}

	//get restaurant name from restaurant table using email
	public function getrestaurantname($email)
	{
		$stmt = $this->con->prepare("SELECT name FROM `restaurants` WHERE email = ?");
		$stmt->bind_param("s", $email);
		$stmt->execute();
		return $stmt->get_result()->fetch_assoc();
	}

	//add food to menu
	public function addfood($dish_name, $price, $isveg, $image, $name, $email)
	{
		$stmt = $this->con->prepare("INSERT INTO `menu` (`dish_name`, `price`, `isveg`, `image`,`restaurant`,`restaurant_email`) VALUES (?, ?, ?, ?, ?, ?);");
		//echo '<img src = "data:image/jpeg;base64,'.base64_encode($image).'" />';
		$stmt->bind_param("sdisss", $dish_name, $price, $isveg, $image, $name, $email);
		if ($stmt->execute()) {
			return 1;
		} else {
			return 2;
		}
	}

	//delete data from menu using Email and dishname And IN EFFECT DELETE DATA FROM ORDERS AND CART
	public function menu_data_delete($email, $dish_name)
	{
		$stmt = $this->con->prepare("DELETE FROM `menu` WHERE restaurant_email = ? AND dish_name=?");
		$stmt->bind_param("ss", $email, $dish_name);
		if ($stmt->execute()) {
			$stmt = $this->con->prepare("DELETE FROM `orders` WHERE restaurant_email = ? AND dish_name=?");
			$stmt->bind_param("ss", $email, $dish_name);
			if ($stmt->execute()) {
				$stmt = $this->con->prepare("DELETE FROM `cart` WHERE restaurant_email = ? AND dish_name=?");
				$stmt->bind_param("ss", $email, $dish_name);
				if ($stmt->execute()) {
					return 1;
				} else {
					return 2;
				}
			} else {
				return 2;
			}
		} else {
			return 2;
		}
	}

	//Find out if the dish name already exists in menu for a given email
	public function uniquefood($dish_name, $email)
	{
		$stmt = $this->con->prepare("SELECT dish_name FROM `menu` WHERE restaurant_email = ? AND dish_name = ?");
		$stmt->bind_param("ss", $email, $dish_name);
		$stmt->execute();
		$stmt->store_result();
		return $stmt->num_rows == 0;
	}

	//Delete data from orders for given customer email and dishname after order is prepared
	public function order_done($dish_name, $email)
	{
		$stmt = $this->con->prepare("DELETE FROM `orders` WHERE cust_email = ? AND dish_name=?");
		$stmt->bind_param("ss", $email, $dish_name);
		if ($stmt->execute()) {
			return 1;
		} else {
			return 2;
		}
	}

	//Add to cart table for given input or update the number of items if the dish already exists in the cart
	public function addToCart($dish_name, $price, $user_email, $restaurant, $restaurant_email)
	{
		$stmt = $this->con->prepare("SELECT count FROM `cart` WHERE restaurant_email = ? AND dish_name = ?");
		$stmt->bind_param("ss", $restaurant_email, $dish_name);
		$stmt->execute();
		$res=$stmt->get_result()->fetch_assoc();
		$items;
		if ($res['count'] >= 1) {
			$items=$res['count'] +1;
			$stmt = $this->con->prepare("UPDATE `cart` SET  `count` = ? where dish_name = ?");
			$stmt->bind_param("is", $items, $dish_name);
		} else {
			$items=1;
			$stmt = $this->con->prepare("INSERT INTO `cart` (`dish_name`, `price`, `cust_email`, `count`,`restaurant`,`restaurant_email`) VALUES (?, ?, ?, ?, ?, ?);");
			$stmt->bind_param("sdsiss", $dish_name, $price, $user_email, $items, $restaurant, $restaurant_email);
		}
		if ($stmt->execute()) {
			return 1;
		} else {
			return 2;
		}
	}

	public function addToOrder($cust_email)
	{
		$stmt = $this->con->prepare("INSERT INTO `orders` SELECT * FROM `cart` WHERE cust_email=?");
		$stmt->bind_param("s", $cust_email);
		if ($stmt->execute()) {
			$stmt = $this->con->prepare("DELETE FROM `cart` WHERE cust_email = ? ");
			$stmt->bind_param("s", $cust_email);
			if ($stmt->execute()) {
				return 1;
			} else {
				return 2;
			}
		} else {
			return 2;
		}
	}

	//delete item from cart for given dish name and customer email
	public function rem_frm_cart($dish_name, $cust_email)
	{
		$stmt = $this->con->prepare("DELETE FROM `cart` WHERE cust_email = ? AND dish_name=?");
		$stmt->bind_param("ss", $cust_email, $dish_name);
		if ($stmt->execute()) {
			return 1;
		} else {
			return 2;
		}
	}

	//get image from the menu for given dish name
	public function get_image($dish_name)
	{
		$stmt = $this->con->prepare("SELECT image FROM `menu` WHERE dish_name = ?");
		$stmt->bind_param("s", $dish_name);
		$stmt->execute();
		return $stmt->get_result()->fetch_assoc();
	}

	//get address from foodies for the given email
	public function get_addr($email){
		$stmt = $this->con->prepare("SELECT address FROM `foodies` WHERE email = ?");
		$stmt->bind_param("s", $email);
		$stmt->execute();
		return $stmt->get_result()->fetch_assoc();
	}
}
