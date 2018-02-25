<?php 
  session_start();

  require "assets/scripts/get_db.php";
  $db = get_Db();

	$title = 'Check-out Validation';
	$currentPage = 'check-out-validation.php'; 

	$promoCode = NULL;
	$firstName = NULL;
	$lastName = NULL;
	$email = NULL;
	$line1 = NULL;
	$line2 = NULL;
	$country = NULL;
	$state = NULL;
	$zip = NULL;
	$shippingSameAsBilling = NULL;
	$paymentMethod = NULL;
	$paymentMethod = NULL;
	$paymentMethod = NULL;
	$cardName = NULL;
	$cardNumber = NULL;
	$cardExpiration = NULL;
	$cardCVV = NULL;

	if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		if(! empty($_POST["line1"]))
		{
			$line1 = htmlspecialchars($_POST["line1"]);
		}
		if(! empty($_POST["line2"]))
		{
			$line2 = htmlspecialchars($_POST["line2"]);
		}
		if(! empty($_POST["state"]))
		{
			$state = htmlspecialchars($_POST["state"]);
		}
		if(! empty($_POST["zip"]))
		{
			$zip = htmlspecialchars($_POST["zip"]);
		}
		if(! empty($_POST["shippingSameAsBilling"]))
		{
			$shippingSameAsBilling = htmlspecialchars($_POST["shippingSameAsBilling"]);
		}
		if(! empty($_POST["cardName"]))
		{
			$cardName = htmlspecialchars($_POST["cardName"]);
		}
		if(! empty($_POST["cardNumber"]))
		{
			$cardNumber = htmlspecialchars($_POST["cardNumber"]);
		}
		if(! empty($_POST["cardExpiration"]))
		{
			$cardExpiration = htmlspecialchars($_POST["cardExpiration"]);
		}
		if(! empty($_POST["cardCVV"]))
		{
			$cardCVV = htmlspecialchars($_POST["cardCVV"]);
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<?php require('head.php'); ?>
	</head>

  <body>
		<?php 
			require('nav-bar.php');

    	unset($_SESSION["cart"]);
    	header("Location: order-confirmation.php");
    	die();
    ?>
	</body>
</html>