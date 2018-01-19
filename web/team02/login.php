<!-- Core Requirement 1c: Create a PHP web application with a login.php page. -->

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
			<form action="handleSession.php" method="post">
			    <input type="hidden" name="login-form" value="submit" />

			    <button id="admin-submit" type="submit" name="submit" value="Administrator">
			    	Log in as Administrator
			    </button>

			    <button id="tester-submit" type="submit" name="submit" value="Tester">
			    	Log in as Tester
			    </button>
			</form>
		</div>
	</body>
</html>