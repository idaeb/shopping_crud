<?php

switch ($_GET["action"]) {

	case 'validate':
	// clear session data on cst to revalidate it
	unset($_SESSION['customer']);
 	// flag to indicate that all data is valid and we can proceed to checkout
	$do_redirect = true;

	// Name validation: can't be empty and should only contain letters and whitespaces 
	if (empty($_POST['name'])) {
		$invalidName = true;
		$nameErrMessage = 'Name cannot be empty';
		$do_redirect = false;
	} elseif (!preg_match("/^[a-zA-Z ]*$/",$_POST['name'])) {
		$invalidName = true;
		$nameErrMessage = 'Only letters and whitespaces allowed';
		$do_redirect = false;
	} else {
	// if the cst passes the validation, we save their input to the session as cst name.
		$_SESSION["customer"]['name'] = $_POST['name'];
	}

// Last name validation: can't be empty and should only contain letters and whitespaces 

	if (empty($_POST['lastname'])) {
		$invalidLastname = true;
		$nameErrMessage = 'Name cannot be empty';
		$do_redirect = false;
	} elseif (!preg_match("/^[a-zA-Z ]*$/",$_POST['lastname'])) {
		$invalidLastname = true;
		$nameErrMessage = 'Only letters and whitespaces allowed';
		$do_redirect = false;
	} else {
	// if the cst passes the validation, we save their input to the session as cst lastname.
		$_SESSION["customer"]['lastname'] = $_POST['lastname'];
	}

// Email validation: cannot be empty and needs to follow the correct format

	if (empty($_POST['email'])) {
		$invalidEmail = true;
		$emailErrMessage = 'Email address cannot be empty';
		$do_redirect = false;
	} elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		$invalidEmail = true;
		$emailErrMessage = 'Invalid email format';
		$do_redirect = false;
	} else {
	// if the cst passes the validation, we save their input to the session as cst email.
		$_SESSION["customer"]['email'] = $_POST['email'];
	}

// Phone number validation: cannot be empty

	if (empty($_POST['phone'])) {
		$invalidPhone = true;
		$phoneErrMessage = 'Phone number cannot be empty';
		$do_redirect = false;
	} else {
	// if the cst passes the validation, we save their input to the session as cst phone.
		$_SESSION["customer"]['phone'] = $_POST['phone'];
	}

// Address validation: Cannot be empty

	if (empty($_POST['address'])) {
		$invalidAddress = true;
		$addressErrMessage = 'Address cannot be empty';
		$do_redirect = false;
	} else {
	// if the cst passes the validation, we save their input to the session as cst address.
		$_SESSION["customer"]['address'] = $_POST['address'];
	}

// City validation: Cannot be empty

	if (empty($_POST['city'])) {
		$invalidCity = true;
		$cityErrMessage = 'City cannot be empty';
		$do_redirect = false;
	} else {
	// if the cst passes the validation, we save their input to the session as cst city.
		$_SESSION["customer"]['city'] = $_POST['city'];
	}

// Zip validation: Cannot be empty

	if (empty($_POST['zip'])) {
		$invalidZip = true;
		$zipErrMessage = 'Zip code cannot be empty';
		$do_redirect = false;
	} else {
	// if the cst passes the validation, we save their input to the session as cst zip.
		$_SESSION["customer"]['zip'] = $_POST['zip'];
	}

// If everything looks OK: redirect to checkout

	if ($do_redirect) {
		header('Location: ../partials/save_address_to_db.php');
	}

	break;
}

?>
