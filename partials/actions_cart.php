<?php

require_once 'database_functions.php';

// Check if the person shopping is logged in or buys as a guest
function getUserIdOrGuest() {
	if (empty($_SESSION["username"])) {
		return -42; // Guest user ID
	} else {
		return $_SESSION["username"];
	}
}

switch ($_GET["action"]) {
	// if the action is add, execute the following:
	case 'add':

		$quantity = $_POST["quantity"]; // the number of items to add, min 0 and max 10.
		$productId = $_GET["id"]; // the id to identify the product in the database.
		$userId = getUserIdOrGuest(); // the id of the user that's logged in.

		// if the quantity of the chosen product is more than 0, execute the following code:
		if ($quantity > 0) {
			// Check if the product exists in the cart.
			$productFromCart = fetchProductFromCart($userId, $productId); // try to get the product from the cart for user
			if ($productFromCart) { // If the product exists in the cart, increase the quantity
				$updatedQuantity = $productFromCart["quantity"] + $quantity; // Calculate new quantity
				updateQuantityInCart($userId, $productId, $updatedQuantity); // Update the product's quantity in the database
			} else { // If the product doesn't exist in the database, add it to the cart
				addProductToCart($userId, $productId, $quantity); // add product to user's cart
			}
		}
		break;
		// end add action.

	case 'remove':
		$productId = $_GET["id"]; // the id to identify the product in the database.
		$userId = getUserIdOrGuest(); // the id of the user that's logged in/the guest id.

  		// this takes the quantity from the productId in the database and reduces it by 1
		$productFromCart = fetchProductFromCart($userId, $productId); // Fetch the product in the cart from the user
		$currentProductQuantity = $productFromCart["quantity"];
  		// if there's 0 or less of the product in the shopping cart,
		if ($currentProductQuantity - 1 <= 0) {
    	// remove the product from the shopping cart so it doesn't display in the checkout
			deleteProductFromCart($userId, $productId);
		} else {
			updateQuantityInCart($userId, $productId, $currentProductQuantity - 1);
		}
		break;

	case 'empty':
		$userId = getUserIdOrGuest(); // the id of the user that's logged in/the guest id.
		// remove all products from the cart for the logged in user (empties the cart)
		deleteAllProductsFromCart($userId);
		break;
	}

?>