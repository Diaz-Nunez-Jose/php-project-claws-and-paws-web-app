<?php 
  $title = 'Order Confirmation'; 
  $currentPage = 'order-confirmation.php'; 
?>

<!DOCTYPE html>
<html lang="en">

  <head>
    <?php
      include('head.php');
    ?>

    <!-- Bootstrap core CSS -->
    <link href="assets/bootstrap-4.0.0-extra/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="assets/bootstrap-4.0.0-extra/full-width-pics.css" rel="stylesheet">
  </head>

  <body>
    <?php
      include('nav-bar.php');
    ?>

    <!-- Header - set the background image for the header in the line below -->
    <header class="py-5 bg-image-full" style="background-image: url('https://s.abcnews.com/images/US/cute-dogs-gty-01-jpo-171116_12x5_992.jpg');">
      <img class="img-fluid d-block mx-auto" src="http://placehold.it/200x200&text=Logo" alt="">
    </header>

    <!-- Content section -->
    <section class="py-5">
      <div class="container">
        <h1>Section Heading</h1>
        <p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid, suscipit, rerum quos facilis repellat architecto commodi officia atque nemo facere eum non illo voluptatem quae delectus odit vel itaque amet.</p>
      </div>
    </section>

    <?php
      include('footer.php');
      include('core-js.php');
    ?>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  </body>
</html>