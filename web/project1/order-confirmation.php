<?php 
  $title = 'Order Confirmation'; 
  $currentPage = 'order-confirmation.php'; 
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

    <header>
      <div id="carouselExampleIndicators" class="carousel slide" >
        <div class="carousel-inner" >
          <div class="carousel-item active" style="background-image: url('assets/img/confirmation-dogs.jpg')">
            <div class="carousel-caption d-none d-md-block">
              <h1>Thank you for your purchase!</h1>
            </div>
          </div>
        </div>
      </div>
    </header>

    <!-- Page Content -->
    <section class="py-5">
      <div class="container">
        <h1>You should receive a confirmation email shortly</h1>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
      </div>
    </section>

    <?php require('footer.php'); ?>    
  </body>
</html>