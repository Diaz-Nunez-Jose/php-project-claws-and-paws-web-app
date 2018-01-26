<?php
	session_start();
	
	function test_input($data) 
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

	if(isset($_SESSION['games']))
	{
		if ($_SERVER["REQUEST_METHOD"] == "POST")
		{
			$f_name  = test_input($_POST['f_name' ]);
			$l_name  = test_input($_POST['l_name' ]);
			$email   = test_input($_POST['email'  ]);
			$address = test_input($_POST['address']);
			$city    = test_input($_POST['city'   ]);
			$state   = test_input($_POST['state'  ]);
			$zip     = test_input($_POST['zip'    ]);
		}
	}
?>

<!DOCTYPE html>
	<html>
	<head>
		<title>
			NES Classics | Confirmation
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
				</ul>		
			</div>			
		</header>
		<div class="container">
			<div class="form-row">
				<h1>
					Thank you for your order.
				</h1>
				<p>
					You will receive an email confirmation shortly at <?php echo $email . "."; ?>
				</p>
			</div>
			<div class="form-row">
				<br />
				<br />
				<h4>
					Personal information and shipping address:
				</h4>
				<div class='table-responsive' style='width: 50%'>  
					<table class='table' 
					style='border-bottom-style: solid; border-bottom-color: #eeeeee; border-bottom-width: 1;'>
						<tr>
							<td style="font-weight: bold">
								Full name
							</td>
							<td>
								<?php echo $l_name . ", " . $f_name; ?> <br />
							</td>
						</tr>
						<tr>
							<td style="font-weight: bold">
								E-mail
							</td>
							<td>
								<?php echo $email; ?> <br />
							</td>
						</tr>
						<tr>
							<td style="font-weight: bold">
								Shipping address
							</td>
							<td>
								<?php echo $address . "<br />" . $city . ", " . $state . " " . $zip; ?> 
							</td>
						</tr>
					</table>
				</div>
			</div>
			<div class="form-row">
				<br />
				<br />
				<h4>
					Order details:
				</h4>
			</div>
			<div class="form-row">
				<?php
					if(isset($_SESSION['games']) and !empty($_SESSION['games']))
					{	
						$items_msg = (sizeof($_SESSION['games']) > 1 ? "Items" : "Item");
						echo
						"
							<div class='table-responsive' style='width: 50%'>       
								<table class='table table-hover' 
								style='border-bottom-style: solid; border-bottom-color: #eeeeee; border-bottom-width: 1;'>
									<thead>
										<tr>
											<th>
												$items_msg
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
		</div>
	</body>
</html>