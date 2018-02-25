<?php 
  session_start();
  
  $title = 'Browse Items'; 
  $currentPage = 'browse-items.php'; 

  require "assets/scripts/remove_common_words.php";
  require "assets/scripts/php_array_to_postgres_array.php";
  
  require "assets/scripts/get_db.php";
  $db = get_Db();

  $postgresArray = "";
  $searchText    = "";
  $searchTerms   = array();

  if ($_SERVER["REQUEST_METHOD"] == "POST") 
  {
    if(! empty($_POST["addToCart"])) 
    {
      $productId = htmlspecialchars($_POST["product_id"]);
      $_SESSION["cart"][$productId] = 1;
    }

    if(! empty($_POST["search"]))
    {
      $_SESSION["search"] = true;

      $searchText = htmlspecialchars($_POST["search"]);
      $searchText = trim($searchText);
      $searchText = stripslashes($searchText);

      if($searchText != NULL || $searchText != "")
      {
        $simplifiedSearchText = removeCommonWords($searchText);
        $searchTerms = explode(" ", $simplifiedSearchText);

        if($searchTerms > 0 && $searchTerms[0] != "")
          $postgresArray = phpToPostgresArray($searchTerms);
      }
    }
    else
    {
      $_SESSION["search"] = false;

      if(empty($_SESSION["category"])) 
        $_SESSION["category"] = "all";
      else
      {
        if($_POST["category"] == "dogs")
          $_SESSION["category"] = "dogs";
        else if($_POST["category"] == "cats")
          $_SESSION["category"] = "cats";
        else if($_POST["category"] == "all")
          $_SESSION["category"] = "all";
      }
    }
  }
  else
    $_SESSION["category"] = "all";
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <?php require('head.php'); ?>

    <link rel="stylesheet" type="text/css" href="assets/css/cart_toast.css">
    <script type="text/javascript" src="assets/scripts/cart_toast.js"></script>

    <!-- Custom styles for this template -->
    <link href="assets/css/small-business.css" rel="stylesheet">
  </head>

  <body>
    <?php require('nav-bar.php'); ?>

    <!-- Page Content -->
    <div class="container">

      <!-- Heading Row -->
      <div class="row my-4">
        <div class="col-lg-8">
          <img class="img-fluid rounded" 
            <?php
              if($_POST["category"] == "cats")
                echo "src='assets/img/browse-cats.jpg'";
              else if($_POST["category"] == "dogs")
                echo "src='assets/img/browse-dogs.jpg'";
              else
                echo "src='assets/img/browse-all.jpg'";
            ?>
          alt="">
        </div>
        <!-- /.col-lg-8 -->

        <div class="col-lg-4">
          <br>
          <h1>Shop by category</h1>
          <p>Browse our vast assortment of top-rated brands.</p>
          <form class="list-group" action="browse-items.php" method="post" id="categoryForm">
            <input 
              <?php 
                if($_SESSION["category"] == "all") 
                  echo "class='active btn-success list-group-item'"; 
                else 
                  echo "class='list-group-item'";
              ?> 
            style="width: 100%; text-transform: capitalize;" type="submit" name="category" value="all">
            <input 
              <?php 
                if($_SESSION["category"] == "dogs") 
                  echo "class='active btn-success list-group-item'"; 
                else 
                  echo "class='list-group-item'";
              ?> 
            style="width: 100%; text-transform: capitalize;" type="submit" name="category" value="dogs">
            <input 
              <?php 
                if($_SESSION["category"] == "cats") 
                  echo "class='active btn-success list-group-item'"; 
                else 
                  echo "class='list-group-item'";
              ?> 
            style="width: 100%; text-transform: capitalize;" type="submit" name="category" value="cats">
          </form>
        </div>
        <!-- /.col-md-4 -->
      </div>

      <div class="row">
        <?php
          $whereClause = "";

          if($_SESSION["search"] == false)
          {
            $category = $_SESSION["category"];

            if($category == "dogs")
              $whereClause = "WHERE product_pet_type = 'D'";
            else if($category == "cats")
              $whereClause = "WHERE product_pet_type = 'C'";
          }
          else
          {
            $whereClause = "WHERE UPPER(product_description) LIKE ANY($postgresArray) OR 
                                  UPPER(product_name) LIKE ANY($postgresArray)";
            $_SESSION["search"] = false;
          }

          $stmt = $db->prepare("SELECT product_id, price, product_name, product_description, product_image_url 
                                FROM   product 
                                $whereClause");
          $stmt->execute();
          $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
          
          foreach($products as $product)
          {
            $price              = $product['price'];
            $productName        = $product['product_name'];
            $productDescription = $product['product_description'];
            $productImageUrl    = $product['product_image_url'];
            $productId          = $product['product_id'];

            $uniqueFormId = "cartForm" . $productId;

            echo 
            "  
              <div class='col-md-4 mb-4'>
                <div class='card h-100'>
                  <img class='card-img-top' src='$productImageUrl' alt='$productName'>
                  <div class='card-body'>
                    <h4 class='card-title'> <div class='lead'>$productName</div> </h4>
                    <h5>$$price</h5>
                    <p class='card-text'>$productDescription</p>
                  </div>
                  <div class='card-footer text-center'>
                    <iframe style='display:none' name='hidden-iframe'></iframe>
                    <form target='hidden-iframe' action='browse-items.php' method='post' id='$uniqueFormId'>
                      <input type='hidden' value='$productId' name='product_id'>
                      <div id='snackbar' class='btn btn-primary btn-lg'>Item added to cart!</div> 
                      <button class='btn btn-outline-success ' form='$uniqueFormId' value='999' type='submit' name='addToCart' onclick='cartToast()'>Add to cart</button>
                    </form>
                  </div>            
                </div>
              </div>
            ";
          }
        ?>
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container -->

    <?php
      require("footer.php");
      require("bootstrap-core-js.php")
    ?>
  </body>
</html>