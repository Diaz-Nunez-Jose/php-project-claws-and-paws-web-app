<?php 
  $title = 'Browse Cat Items'; 
  $currentPage = 'browse-items-cat.php'; 

  require "assets/scripts/get_db.php";
  $db = get_Db();
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
    <link href="assets/bootstrap-4.0.0-extra/shop-homepage.css" rel="stylesheet">
  </head>

  <body class="bg-light">
    <?php
      include('nav-bar.php');
    ?>

    <!-- Page Content -->
    <div class="container">

      <div class="row">

        <div class="col-lg-3">

          <h1 class="my-4">Shop By Pet</h1>
          <div class="list-group">
            <a href="browse-items-dog.php" class="list-group-item">Dogs</a>
            <a href="#" class="list-group-item active">Cats</a>
          </div>

        </div>
        <!-- /.col-lg-3 -->

        <div class="col-lg-9">
          <div id="carouselExampleIndicators" class="carousel slide my-4" data-ride="carousel">
            <ol class="carousel-indicators">
              <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
              <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
              <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner" role="listbox">
              <div class="carousel-item active">
                <img class="d-block img-fluid" src="http://placehold.it/900x350" alt="First slide">
              </div>
              <div class="carousel-item">
                <img class="d-block img-fluid" src="http://placehold.it/900x350" alt="Second slide">
              </div>
              <div class="carousel-item">
                <img class="d-block img-fluid" src="http://placehold.it/900x350" alt="Third slide">
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

          <div class="row">
            <?php
              $stmt = $db->prepare("SELECT price, product_name, product_description, product_image_url 
                                    FROM   product 
                                    WHERE  product_pet_type = 'C'");
              $stmt->execute();
              $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
              
              foreach($products as $product) 
              {
                $price = $product['price'];
                $productName = $product['product_name'];
                $productDescription = $product['product_description'];
                $productImageUrl = $product['product_image_url'];

                echo 
                "   
                <div class='col-lg-4 col-md-6 mb-4'>
                  <div class='card h-100'>
                    <a href='#'><img class='card-img-top' src='$productImageUrl' alt='$productName'></a>
                    <div class='card-body'>
                      <h4 class='card-title'>
                        <a href='#'>$productName</a>
                      </h4>
                      <h5>\$$price</h5>
                      <p class='card-text'>$productDescription</p>
                    </div>
                    <div class='card-footer'>
                      <small class='text-muted'>&#9733; &#9733; &#9733; &#9733; &#9734;</small>
                    </div>
                  </div>
                </div>
                ";
              }
            ?> 

          </div>
          <!-- /.row -->

        </div>
        <!-- /.col-lg-9 -->

      </div>
      <!-- /.row -->

    </div>
    <!-- /.container -->

    <?php
      include('footer.php');
      include('core-js.php');
    ?>
  </body>
</html>