<!-- Stretch Challenge 1: Make it so that the login buttons you created on the login page store the name "Administrator" or "Tester" as a session variable. -->

<?php
	session_start();

	if (isset($_POST["login-form"])) 
	{

		$_SESSION["user"] = $_POST["submit"];

		session_write_close(); 

		if (isset($_SESSION["user"])) 
		{
		    header("Location: home.php");
		}
	}
	else if (isset($_POST["logout-form"])) 
	{
		echo "logging out...";

		// remove all session variables
		session_unset();

		// destroy the session
		session_destroy(); 

		if (! isset($_SESSION["user"])) 
		{
		    header("Location: login.php");
		}
	}

?> 