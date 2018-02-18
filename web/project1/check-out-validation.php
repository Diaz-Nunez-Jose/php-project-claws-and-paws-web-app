<?php 
  session_start();
  // session_destroy();

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
		// echo (empty($_POST["promoCode"]) ? "no promo" : "yes promo");
		if(! empty($_POST["promoCode"]))
		{
			$promoCode = $_POST["promoCode"];
		}
		if(! empty($_POST["firstName"]))
		{
			$firstName = $_POST["firstName"];
		}
		if(! empty($_POST["lastName"]))
		{
			$lastName = $_POST["lastName"];
		}
		if(! empty($_POST["email"]))
		{
			$email = $_POST["email"];
		}
		if(! empty($_POST["line1"]))
		{
			$line1 = $_POST["line1"];
		}
		if(! empty($_POST["line2"]))
		{
			$line2 = $_POST["line2"];
		}
		if(! empty($_POST["country"]))
		{
			$country = $_POST["country"];
		}
		if(! empty($_POST["state"]))
		{
			$state = $_POST["state"];
		}
		if(! empty($_POST["zip"]))
		{
			$zip = $_POST["zip"];
		}
		if(! empty($_POST["shippingSameAsBilling"]))
		{
			$shippingSameAsBilling = $_POST["shippingSameAsBilling"];
		}
		if(! empty($_POST["paymentMethod"]))
		{
			$paymentMethod = $_POST["paymentMethod"];
		}
		if(! empty($_POST["paymentMethod"]))
		{
			$paymentMethod = $_POST["paymentMethod"];
		}
		if(! empty($_POST["paymentMethod"]))
		{
			$paymentMethod = $_POST["paymentMethod"];
		}
		if(! empty($_POST["cardName"]))
		{
			$cardName = $_POST["cardName"];
		}
		if(! empty($_POST["cardNumber"]))
		{
			$cardNumber = $_POST["cardNumber"];
		}
		if(! empty($_POST["cardExpiration"]))
		{
			$cardExpiration = $_POST["cardExpiration"];
		}
		if(! empty($_POST["cardCVV"]))
		{
			$cardCVV = $_POST["cardCVV"];
		}
	}
?>

<!DOCTYPE html>
<html lang="en">

	<head>
		<?php
			include('head.php');
		?>
	</head>

  <body>
		<?php
			include('nav-bar.php');
		?>
    
    <h3>Thank you for your purchase!</h3>
    <p>A confirmation message has been sent to <?php echo $email; ?>.</p>
    <?php
    	unset($_SESSION["cart"]);
    	header("Location: home.php");
    	exit;
    ?>

		<?php
			include('footer.php');
      include('footer-scripts.php');
		?>    
	</body>
</html>