<?php 
session_start();

require_once '../partials/actions_cart.php';
require_once '../partials/functions.php';
require_once '../partials/actions_user.php';

$productsFromCart = fetchAllProductsFromCart(getUserIdOrGuest()); // The products added to the cart

?>

<!doctype html>
<html lang="en">
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

	<!--my css-->

	<link rel="stylesheet" type="text/css" href="../css/style.css">

	<!-- fonts-->

	<link href="https://fonts.googleapis.com/css?family=EB+Garamond|Niramit|Playfair+Display" rel="stylesheet">

	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

	<title>My Store</title>
</head>
<body>
	<!-- Navigation-->
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
		<a class="navbar-brand" href="../index.php">My Store</a>
		<!-- Go to user account-->
		<a href="useraccount.php" id="myaccount-link">My Account</a>
		<!-- Log in / register-->
		<?php if (isset($_SESSION["username"])) { ?>
			<a href="../partials/logout.php" id="logout-link">Log out</a>
		<?php } else { ?>
			<a href="login.php" id="login-link">Login / Register</a>
		<?php } ?>
		<!-- Button trigger modal -->
		<button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#exampleModal" id="view-bag">
			<i class="fas fa-shopping-cart"></i> <span class="badge badge-light"><?php echo countProductsInCart($productsFromCart); ?></span>
		</button>

		<!-- Modal -->
		<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Your shopping bag</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<?php if (empty($productsFromCart)) { ?>
							<div class="basket-empty text-center">
								<p>Unfortunately, your shopping bag is empty</p>
							</div>
						<?php } else { ?>
							<div class="shopping-cart table-responsive">
								<table class="table">
									<thead class="table-light">
										<tr class="text-center">
											<th scope="col">Product name</th>
											<th scope="col">Unit price</th>
											<th scope="col">Quantity</th>
											<th scope="col">Subtotal</th>
											<th scope="col">Remove</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($productsFromCart as $product) {
											?>
											<tr class="text-center">
												<td><?php echo $product['name'];?></td>
												<td><?php echo $product['price'];?> kr</td>
												<td><?php echo $product['quantity'];?></td>
												<td><?php echo $product['price'] * $product['quantity'];?> kr</td>
												<td><a href="login.php?action=remove&id=<?php echo $product["id"]?>"><i class="fas fa-trash-alt"></i></a></td>
											</tr>
										<?php }?>
									</tbody>
								</table>
							</div> <!-- end of the shopping cart-->
						<?php } ?>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary btn-md" data-dismiss="modal">Close</button>
						<a class="btn btn-primary btn-md" href="cart.php">View cart</a>
					</div>
				</div>
			</div>
		</div> <!-- End of modal-->
	</nav>
	<main>
		<div class="container">
			<!-- Start of checkout page-->
			<section class="login-page">
				<div class="login-page-heading text-center"><h2>Login / Register</h2></div>
				<div class="row">
					<div class="col-md-6">
						<form method="POST" action="login.php?action=login" id="login-form">
							<div class="form-group">
								<label for="inputEmailLogin">Email address or username</label>
								<input type="username" class="form-control" id="inputUsernameLogin" placeholder="Enter username" name="username">
							</div>
							<div class="form-group">
								<label for="inputPasswordLogin">Password</label>
								<input type="password" class="form-control" id="inputPasswordLogin" placeholder="Password" name="password">
							</div>
							<button type="submit" class="btn btn-primary btn-md">Log in</button>
							<div class="<?php get_class_for_error_message($invalidCredentials)?>"><?php echo $credentialsErr;?></div>
						</form>
					</div> <!-- end of col-->
					<div class="col-md-6">
						<form method="POST" action="login.php?action=register" id="register-form">
							<div class="form-group">
								<label for="inputEmailRegister">Email address</label>
								<input type="text" class="form-control" id="inputEmailRegister" placeholder="Enter email" name="email">
								<div class="<?php get_class_for_error_message($invalidEmail)?>"><?php echo $emailErr;?></div>
							</div>
							<div class="form-group">
								<label for="inputUsernameRegister">Username</label>
								<input type="text" class="form-control" id="inputUsernameRegister" placeholder="Enter username" name="username">
								<div class="<?php get_class_for_error_message($invalidUsername)?>"><?php echo $userNameErr;?></div>
							</div>
							<div class="form-group">
								<label for="inputPasswordRegister">Password</label>
								<input type="password" class="form-control" id="inputPasswordRegister" placeholder="Password" name="password">
								<div class="<?php get_class_for_error_message($invalidPassword)?>"><?php echo $passwordErr;?></div>
							</div>
							<div class="form-group">
								<label for="confirmPasswordRegister">Confirm password</label>
								<input type="password" class="form-control" id="confirmPasswordRegister" placeholder="Password" name="confirmPassword">
								<div class="<?php get_class_for_error_message($invalidConfirmedPassword)?>"><?php echo $confirmPasswordErr;?></div>
							</div>
							<button type="submit" class="btn btn-primary btn-md">Submit</button>
							<?php if ($successfulRegistration) {?>
								<div class="successfulRegistration"><p>Your registration was successful. You can now log in.</p></div>
							<?php } ?>
						</form>
					</div>
				</div> <!-- end of row-->
			</section>
		</div>
	</main>
	<footer>
		<div class="card text-center">
			<div class="card-footer text-muted">
				<p class="card-text">© Copyright 2018. All Right Reserved.</p>
				<div class="payment-methods-icons">
					<i class="fab fa-cc-visa"></i>
					<i class="fab fa-cc-mastercard"></i>
					<i class="fab fa-cc-paypal"></i>
				</div>
			</div>
		</div>
	</footer>
	<?php
	require_once '../partials/bootstrap_scripts.php';
	?>
</body>
</html>
