<?php
	session_start();

	if(isset($_SESSION['games']))
	{
		if ($_SERVER["REQUEST_METHOD"] == "POST")
		{
			$title       = $_POST['title'      ];
			$description = $_POST['description'];
			$image       = $_POST['image'      ];

			foreach ($_SESSION['games'] as $s_game_id => $s_game)
			{
				if ($s_game['title'      ] == $title       and
					$s_game['description'] == $description and
					$s_game['year'       ] == $year)
				{
					unset($_SESSION['games'][$s_game_id]);
					break;
				}
			}

	        header("Location: view-cart.php");
	        exit;
		}
	}
?>

<!DOCTYPE html>
	<html>
	<head>
		<title>
			NES Classics | View Cart
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
					<li class="active">
						<a href="view-cart.php">
							<strong>View Cart</strong>
						</a>
					</li>
					<li>
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
					$num_games = sizeof($_SESSION['games']);
					$msg = ($num_games > 1 ? "There are $num_games games currently in your cart." : "There is $num_games game currently in your cart.");
					echo
					"
						<h1>
							$msg
						</h1>
						<p>
							To remove an item, simply click 'Remove.'
						</p>
						<div class='table-responsive'>       
							<table class='table table-hover' 
							style='border-bottom-style: solid; border-bottom-color: #eeeeee; border-bottom-width: 1;'>
								<thead>
									<tr>
										<th>
										</th>
										<th>
											Game Information
										</th>
										<th>											
										</th>
									</tr>
								</thead>
								<tbody>
					";				
					$games = $_SESSION['games'];
					foreach ($games as $game_id => $game)
					{			
						$title       = $game['title'      ];
						$description = $game['description'];
						$image       = $game['image'      ];
						echo
						"
									<tr>
										<td>
											<img src='$image' height='50%' width='50%' />
										</td>
										<td>
											<h2>$title</h2>
											<p style='font-size: 80%; text-align: justify'>$description</p>
										</td>
										<td align='middle'>
											<iframe style='display:none' name='hidden-iframe' id='hidden-iframe'></iframe>
											<form target='hidden-iframe' action='
						";
						echo htmlspecialchars($_SERVER["PHP_SELF"]);
						echo 
						"
											' method='post' >
												<input type='hidden' name='uniqid' value='
						";
						echo uniqid();
						echo 
						"						'/>
												<input type='hidden' name='title' value=\"$title\" />
												<input type='hidden' name='description' value=\"$description\" />
												<input type='hidden' name='image' value=\"$image\" />
												<input type='image' src='assets/image/bin.svg' alt='Remove Item' width='50%' height='50%' name='submit'/>		
												<p align='left'>Remove</p>
											</form>
										</td>
									</tr>
						";
					}
					echo
					"
								</tbody>
							</table>
						</div>
					";				
				}
				else
				{
					echo 
					"
						<br/><br/>
						<h4 align='middle'>There are no games in your cart to display.</h4>
					";
				}
			?>
		</div>
	</body>
</html>