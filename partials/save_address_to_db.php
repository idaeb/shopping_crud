<?php 

session_start();


/* We want to save the address to the database
* We will do this by taking the customer's address in the session 
* and saving it to the database
*/

require_once 'database_functions.php';

if (isset($_SESSION["username"])) {
	saveAddressToDb($_SESSION["customer"]['name'], $_SESSION["customer"]['lastname'], $_SESSION["customer"]['email'], $_SESSION["customer"]['phone'], $_SESSION["customer"]['address'], $_SESSION["customer"]['city'], $_SESSION["customer"]['zip'], $_SESSION["username"]);
}
// Once the address has been validated, we inject it into the database. From the moment it's in the database, we retrieve it from the database and not the session. 
unset($_SESSION["customer"]);
header("Location: ../views/confirm.php");

?>
