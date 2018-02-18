<?php 

	session_start();
	// session_destroy();

	echo var_dump($_SESSION["cart"]);

	foreach ($_SESSION["cart"] as $key => $value)
	{
		echo "key = " . $key . "<br> value = " . $value . "<br>";
	}

?>