<!-- Helper functions-->

<?php

// Calculate shipping based on the number of items in the cart

function calculateShippingPrice($cart) {
	if (empty($cart)) {
		return 0;
	}
	$numberOfProducts = 0;
	foreach ($cart as $product) {
		$numberOfProducts = $numberOfProducts + $product["quantity"];
	}
	if ($numberOfProducts <= 3) {
		return 50;
	} else {
		return 75;
	} 
}

// Function to hide the validation error messages

function get_class_for_error_message($hasError) {
	if ($hasError) {
		echo "d-block invalid-feedback";
	} else {
		echo "d-none";
	} 
}

?>

<!-- Cart functions -->

<?php 

function countProductsInCart($cart) {
	$count = 0;
	if (empty($cart)) {
		return $count;
	} else {
		// for each product in the shopping cart,
		foreach ($cart as $product) {
			// add the number of products in the cart to the count
			$count = $count + $product['quantity'];
		} 
		return $count;
	} 
}

/* this function will calculate the price depending on day of the week. 
*If it's Monday, all items are 50% off. 
*If it's Wednesday, all items will be 10% more expensive.
*If it's Friday, all items above 200 SEK will cost 20 SEK less.
*If none of these apply, we will return the regular price. 
*/

function calculate_price($price) {
	switch (date("l")) {
		case 'Monday':
		return $price / 2;
		break;

		case 'Wednesday':
		return $price * 1.1;
		break;

		case 'Friday':
		if ($price >= 200) {
			return $price - 20;
		} else {
			return $price;
		}
		break;
		default:
		return $price;
		break;
	}

}

// this function will strike through the regular price and display the discounted price on Mondays, Wednesdays and Fridays. 

function style_price($price) {
	switch (date("l")) {
		case 'Monday':
		case 'Wednesday':
		echo "<s>" . $price . " kr</s> " . calculate_price($price) . " kr";
		break;

		case 'Friday':
		if ($price >= 200) {
			echo "<s>" . $price . " kr</s> " . calculate_price($price) . " kr";
		} else {
			echo $price . " kr";
		}
		break;
		
		default:
		echo $price . " kr";
		break;
	}
}


?>

