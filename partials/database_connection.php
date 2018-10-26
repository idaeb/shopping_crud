<?php

function getPDO() {
	return new PDO(
	    "mysql:host=localhost;dbname=mystore;charset=utf8",
	    "root", 
	    "root"  
	);
}

?>