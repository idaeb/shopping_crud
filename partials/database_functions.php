<?php 

// Product functions 

require_once 'database_connection.php';

// This function will fetch all products from the database

function fetchAllProductsFromDB() {

	$statement = getPDO()->prepare("SELECT * FROM products");
	$statement->execute();
	return $statement->fetchAll(PDO::FETCH_ASSOC);
}

// This function will fetch a single product from the DB using its ID.

function fetchProductFromDB($productId) {

	$statement = getPDO()->prepare("SELECT * FROM products WHERE id = :id");
	$statement->execute([
		":id"     => $productId
	]);
	return $statement->fetch(PDO::FETCH_ASSOC);
}

// This function will fetch all the products from the shopping cart

function fetchAllProductsFromCart($userId) {
	$statement = getPDO()->prepare("SELECT products.name, products.price, cart.quantity, products.id FROM orders AS cart JOIN products on products.id = cart.product_id WHERE user_id = :user_id");
	$statement->execute([
		":user_id" => $userId
	]);
	return $statement->fetchAll(PDO::FETCH_ASSOC);
}

// This function will fetch a single product from the shopping card using its ID

function fetchProductFromCart($userId, $productId) {
	$statement = getPDO()->prepare("SELECT * FROM orders WHERE user_id = :user_id AND product_id = :product_id");
	$statement->execute([
		":user_id" => $userId,
		":product_id" => $productId
	]);
	return $statement->fetch(PDO::FETCH_ASSOC);
}

// This function will add a product to the card

function addProductToCart($userId, $productId, $quantity) {
	$statement = getPDO()->prepare("INSERT INTO orders (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity)");
	$statement->execute([
		":user_id"     => $userId,
		":product_id" => $productId,
		":quantity" => $quantity
	]);
}

// Change the quantity of one product in the database

function updateQuantityInCart($userId, $productId, $quantity) {
	$statement = getPDO()->prepare("UPDATE orders SET quantity = :quantity WHERE user_id = :user_id AND product_id = :product_id");
	$statement->execute([
		":user_id"     => $userId,
		":product_id" => $productId,
		":quantity" => $quantity
	]);
}

// Delete a single product from the cart

function deleteProductFromCart($userId, $productId) {
	$statement = getPDO()->prepare("DELETE FROM orders WHERE product_id = :product_id AND user_id = :user_id");
	$statement->execute([
		":user_id"     => $userId,
		":product_id" => $productId
	]);
}

// Delete all products from the cart

function deleteAllProductsFromCart($userId) {
	$statement = getPDO()->prepare("DELETE FROM orders WHERE user_id = :user_id");
	$statement->execute([
		":user_id" => $userId
	]);
}

// User functions below

// Get the user's address

function getUserAddress($userId) {
	$statement = getPDO()->prepare("SELECT * FROM address WHERE user_id = :user_id");
	$statement->execute([
		":user_id" => $userId
	]);
	return $statement->fetch(PDO::FETCH_ASSOC);
}

// Save the user's address in the database 

function saveAddressToDb($first_name, $last_name, $email, $phone, $address, $city, $zip, $user_id) {
	$statement = getPDO()->prepare("INSERT INTO address (first_name, last_name, email, phone, address, city, zip, user_id) VALUES (:first_name, :last_name, :email, :phone, :address, :city, :zip, :user_id)");
	$statement->execute([
		":first_name" => $first_name,
		":last_name" => $last_name,
		":email" => $email,
		":phone" => $phone,
		":address" => $address,
		":city" => $city,
		":zip" => $zip,
		":user_id" => $user_id
	]);
}

// Check if the user exists in the database

function user_exists_in_db($username) {

	$statement = getPDO()->prepare("SELECT * FROM users WHERE username = :username");
	$statement->execute([
		":username" => $username
	]);
	return ($statement->rowCount() > 0);
}

// Check if the email exists in the database

function email_exists_in_db($email) {

	$statement = getPDO()->prepare("SELECT * FROM users WHERE email = :email");
	$statement->execute([
		":email" => $email
	]);
	return ($statement->rowCount() > 0);
}

// Add a new user to the database 

function addUserToDb($username, $email, $password) {
	$hashed_password = password_hash($password, PASSWORD_DEFAULT);
	
	$statement = getPDO()->prepare(
		"INSERT INTO users (email, username, password) 
		VALUES (:email, :username, :password)"
	);
	$statement->execute([
		":email"     => $email,
		":username"  => $username,
		":password"  => $hashed_password
	]);
}

// Get the user from the database

function fetchUserFromDB($usernameOrEmail) {
	$statement = getPDO()->prepare("SELECT * FROM users WHERE username = :username OR email = :email");
	$statement->execute([
		":username" => $usernameOrEmail,
		":email" => $usernameOrEmail
	]);

	return $statement->fetch(PDO::FETCH_ASSOC);
}

?>