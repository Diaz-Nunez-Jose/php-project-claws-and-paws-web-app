<?php
	session_start();
?>

<!DOCTYPE html>
	<html>
	<head>
		<title>
			NES Classics | Check Out
		</title> <meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	</head>
	<body>
		<header  class="navbar navbar-light navbar-static-top" style="background-color: #dddddd;">
			<div class="container">
				<a href="#" class="navbar-brand">
					<strong>NES Classics</strong>
				</a>		
				<ul class="nav navbar-nav navbar-right">
					<li>
						<a href="browse-items.php">
							<strong>Browse Items</strong>
						</a>
					</li>
					<li>
						<a href="view-cart.php">
							<strong>View Cart</strong>
						</a>
					</li>
					<li class="active">
						<a href="check-out.php">
							<strong>Check Out</strong>
						</a>
					</li>
				</ul>		
			</div>			
		</header>
		<div class="container">
			<?php
				if(isset($_SESSION['games']) and !empty($_SESSION['games']))
				{	
					echo
					"
						<h1>
							Almost there - please enter your personal information.
						</h1>
						<p>
							Below, enter your name, phone, and the address that you would like to ship your games to.
						</p>
						<form style='width: 50%' action='confirmation.php' method='post'>
							<div class='form-row'>
								<div class='col-md-4 mb-3'>
									<label for='f_name'>First name</label>
									<input type='text' class='form-control is-valid' name='f_name' placeholder='Jane' required>
								</div>
								<div class='col-md-4 mb-3'>
									<label for='l_name'>Last name</label>
									<input type='text' class='form-control is-valid' name='l_name' placeholder='Doe' required>
								</div>
							</div>
							<div class='form-row'>
								<div class='col-md-8 mb-3'>
									<br />
									<label for='email'>E-mail</label>
									<input type='text' class='form-control is-valid' name='email' placeholder='janedoe@gmail.com' required>
								</div>
							</div>
							<div class='form-row'>
								<div class='col-md-8 mb-3'>
									<br/>
									<label for='city'>Address</label>
									<input type='text' class='form-control is-invalid' name='address' placeholder='123 Main St.' required>
								</div>
							</div>
							<div class='form-row'>
								<div class='col-md-6 mb-3'>
									<br/>
									<label for='city'>City</label>
									<input type='text' class='form-control is-invalid' name='city' placeholder='Anyplace' required>
								</div>
								<div class='col-md-3 mb-3'>
									<br/>
									<label for='state'>State</label>
									<input type='text' class='form-control is-invalid' name='state' placeholder='ST' required>
								</div>
								<div class='col-md-3 mb-3'>
									<br/>
									<label for='zip'>Zip</label>
									<input type='text' class='form-control is-invalid' name='zip' placeholder='12345' required>
								</div>
							</div>
							<div class='form-row'>
								<div class='col-md-3 mb-3' >
									<br/>
									<button class='btn btn-primary' type='submit'>Complete purchase</button>
								</div>
							</div>
						</form>
						<div class='form-row'>
							<div class='col-md-3 mb-3' >
								<br/>
								<a href='view-cart.php'>
									<button class='btn btn-primary' 
									style='margin-left: 30%; background-color: #dddddd; color: #337AB7'>
										Return to cart
									</button>
								</a>
							</div>
						</div>
					";
				}
				else
				{
					echo 
					"
						<br/><br/>
						<h4 align='middle'>There are no games in your cart to check out.</h4>
					";
				}
			?>
		</div>
	</body>
</html>