<?php 
session_start();

require_once 'database_functions.php';

switch ($_GET["action"]) {
	case 'register':
	$username = $_POST["username"];
	$email = $_POST["email"];
	$password = $_POST["password"];
	$confirmPassword = $_POST["confirmPassword"];

	$successfulRegistration = false;

	// Email validation: cannot be empty and needs to follow the correct format
	if(empty($email)) {
		$invalidEmail = true;
		$emailErr = "Email address cannot be empty";
	} elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		$invalidEmail = true;
		$emailErr = "Invalid email format";
	}

	// Username validation: can't be empty and should only contain letters
	if (empty($username)) {
		$invalidUsername = true;
		$userNameErr = "Name cannot be empty";
	} elseif (!preg_match("/^[a-zA-Z]*$/",$_POST["username"])){
		$invalidUsername = true;	
		$userNameErr = 'Only letters allowed';
	} 

	// Password validation: can't be empty

	if (empty($password)) {
		$invalidPassword = true;
		$passwordErr = "Password cannot be empty";
	} 

	// Confirm password validation: Cannot be empty and must match

	if (empty($confirmPassword)) {
		$invalidConfirmedPassword = true;
		$passwordErr = "Password cannot be empty";
	} elseif ($password != $confirmPassword) {
		$invalidConfirmedPassword = true;
		$confirmPasswordErr = "Password doesn't match";
	}	

	// if email, username or password is invalid, don't continue with the registration.
	if ($invalidEmail || $invalidUserName || $invalidPassword || $invalidConfirmedPassword) {
		break;
	} 

	if (user_exists_in_db($username)) {
		$invalidUsername = true;
		$userNameErr = "Username is already taken";
	}

	if (email_exists_in_db($email)) {
		$invalidEmail = true;
		$emailErr = "A user already exists with this email";
	}

	if ($invalidUsername || $invalidUsername) {
		break;
	}

	addUserToDB($username, $email, $password);

	$successfulRegistration = true;
	break;

	case 'login':
	$usernameOrEmail = $_POST["username"];
    $password = $_POST["password"];

	$fetchedUser = fetchUserFromDB($usernameOrEmail);

	// Compare

	// if true, we want to store the username and email in a session, NOT the password
	if ($fetchedUser && password_verify($password, $fetchedUser["password"])) {
		// save user globally
		$_SESSION["username"] = $fetchedUser["id"];
		// Direct to user account page 
		header("Location: ../views/useraccount.php");
	} else {
		$invalidCredentials = true;
		$credentialsErr = "Wrong credentials";
	}
	break;

}


?>





