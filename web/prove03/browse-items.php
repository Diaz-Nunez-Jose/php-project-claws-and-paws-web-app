<?php
	session_start();

	$path_parts = pathinfo($_SERVER['HTTP_REFERER']);
	$referrer_page = $path_parts['filename'];
	if ($referrer_page == 'confirmation')
	{
		session_destroy();
	}

	$games = array(
		0 => array(
			'title' => 'Super Mario Bros. 3',
			'description' => 'Super Mario Bros. 3 centers on plumbers Mario and Luigi who embark on a quest to save Princess Toadstool and the rulers of seven different kingdoms from the antagonist Bowser and his children, the Koopalings.',
			'image' => 'https://upload.wikimedia.org/wikipedia/en/a/a5/Super_Mario_Bros._3_coverart.png'
		),
		1 => array(
			'title' => 'The Legend of Zelda',
			'description' => 'Set in the fantasy land of Hyrule, the plot centers on a boy named Link, the playable protagonist, who aims to collect the eight fragments of the Triforce of Wisdom in order to rescue Princess Zelda from the antagonist, Ganon.',
			'image' => 'https://upload.wikimedia.org/wikipedia/en/4/41/Legend_of_zelda_cover_%28with_cartridge%29_gold.png'
		),
		2 => array(
			'title' => 'Kirby\'s Adventure',
			'description' => 'The game centers around Kirby traveling across Dream Land to repair the Star Rod after King Dedede breaks it apart and gives the pieces to his minions.',
			'image' => 'https://upload.wikimedia.org/wikipedia/en/a/ae/Kirby%27s_Adventure_Coverart.png'
		),
		3 => array(
			'title' => 'Mega Man 2',
			'description' => 'After his initial defeat Dr. Wily, the series\' main antagonist, creates his own set of Robot Masters in an attempt to counter Mega Man: Metal Man, Air Man, Bubble Man, Quick Man, Crash Man, Flash Man, Heat Man, and Wood Man; along with a new fortress and army of robotic henchmen. Mega Man is sent by his creator, Dr. Light, to defeat Dr. Wily and his Robot Masters.',
			'image' => 'https://upload.wikimedia.org/wikipedia/en/b/be/Megaman2_box.jpg'
		),
		4 => array(
			'title' => 'Metroid',
			'description' => 'Set on the planet Zebes, the story follows Samus Aran as she attempts to retrieve the parasitic Metroid organisms that were stolen by Space Pirates, who plan to replicate the Metroids by exposing them to beta rays and then use them as biological weapons to destroy Samus and all who oppose them.',
			'image' => 'https://upload.wikimedia.org/wikipedia/en/5/5d/Metroid_boxart.jpg'
		),
		5 => array(
			'title' => 'Castlevania II: Simon\'s Quest',
			'description' => 'Set sometime after the events of the first installment, the player once again assumes the role of vampire hunter Simon Belmont, who is on a journey to undo a curse placed on him by Dracula at the end of their previous encounter.',
			'image' => 'https://upload.wikimedia.org/wikipedia/en/8/8a/Castlevania_II_Simon%27s_Quest.jpg'
		),
		6 => array(
			'title' => 'Kid Icarus',
			'description' => 'The plot of Kid Icarus revolves around protagonist Pit\'s quest for three sacred treasures, which he must equip to rescue the Grecian fantasy world Angel Land and its ruler, the goddess Palutena.',
			'image' => 'https://upload.wikimedia.org/wikipedia/en/b/b1/Kid_Icarus_NES_box_art.png'
		),
		7 => array(
			'title' => 'Dr. Mario',
			'description' => 'In this falling block puzzle game, the player\'s objective is to destroy the viruses populating the on-screen playing field by using colored capsules that are tossed into the field by Mario, who assumes the role of a doctor.',
			'image' => 'https://upload.wikimedia.org/wikipedia/en/f/f8/Dr._Mario_box_art.jpg'
		)
	);

	if( !isset($_SESSION['games']) )
	{
		$_SESSION['games'] = array();
	}
	else if(isset($_SESSION['games']))
	{
		if ($_SERVER["REQUEST_METHOD"] == "POST")
		{
			$title       = $_POST['title'      ];
			$description = $_POST['description'];
			$image       = $_POST['image'      ];
			$new_game = array("title" => $title, "description" => $description, "image" => $image);

			$_SESSION['games'][] = $new_game;
	        header("Location: browse-items.php");
	        exit;
		}
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>
			NES Classics | Browse Items
		</title> <meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="assets/css/nesclassics.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<script src="assets/js/nesclassics.js"></script>
	</head>
	<body>
		<header  class="navbar navbar-light navbar-static-top" style="background-color: #eeeeee;">
			<div class="container">
				<a href="#" class="navbar-brand">
					<strong>NES Classics</strong>
				</a>		
				<ul class="nav navbar-nav navbar-right">
					<li class="active">
						<a href="#">
							<strong>Browse Items</strong>
						</a>
					</li>
					<li>
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
			<h1>
				Buy classic Nintendo Entertainment System games.
			</h1>
			<p>
				Choose from our wide collection of classic NES 8-bit cartridges.
			</p>
			<div class="row">
				<?php
            		if(!empty($games))
            		{
						foreach ($games as $game_id => $game)
						{
							echo
							"								
								<div class='col-lg-3 col-md-4 col-sm-6 col-xs-12'>
									<div class='jumbotron' width='200%'>
										<iframe style='display:none' name='hidden-iframe'></iframe>
										<form target='hidden-iframe' action='
							";
							echo htmlspecialchars($_SERVER["PHP_SELF"]);
							echo 
							"
										' method='post'>
											<input type='hidden' name='uniqid' value='
							";
							echo uniqid();
							$title = $game['title'];
							$description = $game['description'];
							$image = $game['image'];
							echo 
								"
											'/>
											<input type='hidden' name='title' value=\"$title\" />
											<input type='hidden' name='description' value=\"$description\" />
											<input type='hidden' name='image' value=\"$image\" />
											
											<div id='snackbar'>Added game to cart</div> 
											<button value='Add to cart' onclick='cartToast()'>Add to cart</button>
											<br>
											<br>
											<img src='$image' height='100%' width='100%'>	
											<h2>$title</h2>
											<p style='font-size: 82%; text-align: justify'>$description</p>
										</form>
									</div>	
								</div> 
							";
						}
					}
				?>
			</div>
		</div>
	</body>
</html>