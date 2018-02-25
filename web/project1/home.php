<?php 
  session_start();

  require "assets/scripts/get_db.php";
  $db = get_Db();

	$title = 'Home';
	$currentPage = 'home.php'; 
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<?php require('head.php'); ?>

    <!-- Custom styles for this template -->
    <link href="assets/css/half-slider.css" rel="stylesheet">
	</head>

  <body>
		<?php require('nav-bar.php'); ?>

    <header >
      <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
          <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
          <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
          <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner" role="listbox">
          <!-- Slide One - Set the background image for this slide in the line below -->
          <div class="carousel-item active" style="background-image: url('assets/img/carousel1.jpg')">
            <div class="carousel-caption d-none d-md-block">
              <h2 style="color: black">Sign up now for 20% off your first purchase!</h2>
              <p style="color: black">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
            </div>
          </div>
          <!-- Slide Two - Set the background image for this slide in the line below -->
          <div class="carousel-item" style="background-image: url('assets/img/carousel2.jpg')">
            <div class="carousel-caption d-none d-md-block">
              <h2 style="color: black">Don't miss out on our seasonal store-wide sales!</h2>
              <p style="color: black">Lorem ipsum dolor sit amet, consectetur adipisicing elit.<br>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
            </div>
          </div>
          <!-- Slide Three - Set the background image for this slide in the line below -->
          <div class="carousel-item" style="background-image: url('assets/img/carousel3.jpg')">
            <div class="carousel-caption d-none d-md-block">
              <h2 style="color: black">Discounts for popular brands and much more!</h2>
            </div>
          </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
    </header>

    <!-- Page Content -->
    <section class="py-5">
      <div class="container">
        <h1>500+ name-brand items in stock!</h1>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
      </div>
    </section>

		<?php
      require('footer.php');
      require('bootstrap-core-js.php');
		?>    
	</body>
</html>