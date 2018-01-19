<!-- Core Requirement 1a: Create a PHP web application with a home.php page. -->

<!DOCTYPE html>

<html>
	<head>
		<title>		
		</title>
	</head>

	<body>
		<div>
			<?php 
				include 'header.php';
			?>
		</div>
		<div>
			<?php
				session_start();

				if (isset($_SESSION["user"])) 
				{
					echo 
					"
						<p style=\"margin-top:100px;\">
							Welcome. Logged in as " . 
							$_SESSION["user"] . 
						".</p>
					";
				}
				else if (! isset($_SESSION["user"])) 
				{
					echo 
					"
						<p style=\"margin-top:100px;\">
							Welcome. You are not logged in.
						</p>
					";
				}
			?>
		</div>

		<!-- Stretch Challenge 2: Add a Logout button or link to the home page. -->
		<div>
			<form action="handleSession.php" method="post">
			    <input type="hidden" name="logout-form" value="submit" />

			    <button id="logout-submit" type="submit" name="submit" value="Logout">
			    	Log Out
			    </button>
			</form>
		</div>
	</body>
</html>