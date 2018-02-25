<?php 
  session_start();

  require "assets/scripts/get_db.php";
  $db = get_Db();

  $title = 'View Cart'; 
  $currentPage = 'view-cart.php'; 
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <?php require('head.php'); ?>
  </head>

  <body>
    <?php require('nav-bar.php'); ?>

    <div class="container" style="padding-top: 5%; padding-bottom: 15%">
      <?php
        if(isset($_SESSION["cart"]) && !empty($_SESSION["cart"]))
        {
          echo "<h2>Your shopping cart</h2><br>";

          if ($_SERVER["REQUEST_METHOD"] == "POST")
          {
            if(!empty($_POST["productIdRemove"]))
            {
              $productIdRemove = htmlspecialchars($_POST["productIdRemove"]);
              unset($_SESSION["cart"]["$productIdRemove"]);

              if (empty($_SESSION["cart"])) 
              {
                header("Location: view-cart.php");
                die();
              }
            }

            if(!empty($_POST["newQuantity"]))
            {
              $newQuantity = NULL;
              $newQuantityProductId = NULL;
              $newQuantity = htmlspecialchars($_POST["newQuantity"]);

              if(!empty($_POST["productId"]))
                $newQuantityProductId = htmlspecialchars($_POST["productId"]);

              $_SESSION["cart"][$newQuantityProductId] = $newQuantity;
            }
          }

          $subtotal     = 0.00;
          $shippingCost = 7.99;

          $productsInCart = array();
          foreach ($_SESSION["cart"] as $productId => $quantity) 
          {
            $productsInCart[$productId]["quantity"] = $quantity;

            $stmt = $db->prepare("SELECT price, product_name, product_description, product_image_url 
                                  FROM   product 
                                  WHERE  product_id = :product_id");
            $stmt->execute
            (
              array
              (
                ':product_id' => $productId
              )
            );
            $dbProduct = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];

            $productsInCart[$productId]["price"]               = $dbProduct["price"];
            $productsInCart[$productId]["product_name"]        = $dbProduct["product_name"];
            $productsInCart[$productId]["product_description"] = $dbProduct["product_description"];
            $productsInCart[$productId]["product_image_url"]   = $dbProduct["product_image_url"];
            $productsInCart[$productId]["product_id"]          = $productId;
          }             

          echo
          "
            <div class='container'>
            <div class='table-striped'>
              <table class='table'> 
                <thead>
                  <tr style='text-align: center'>
                    <th>Item</th>
                    <th style='text-align: left'>Quantity</th>
                    <th>Price</th>
                    <th style='text-align: left'>Item Total</th>
                    <th> </th>
                  </tr>
                </thead>
                <tbody>
          ";

          $quantity           = NULL;
          $price              = NULL;
          $productName        = NULL;
          $productDescription = NULL;
          $productImageUrl    = NULL;
          $productIdCart      = NULL;

          foreach ($productsInCart as $product) 
          {
            $quantity           = $product["quantity"];
            $price              = $product["price"];
            $productName        = $product["product_name"];
            $productDescription = $product["product_description"];
            $productImageUrl    = $product["product_image_url"];
            $productIdCart      = $product["product_id"];

            $totalForItem = $quantity * $price;
            $subtotal += $totalForItem;

            echo 
            "     
                  <tr  >
                    <td>
                      <div>
                        <img src='$productImageUrl' style='width: 72px; height: 72px;'>
                        <div>
                          <h4> $productName </h4>
                          <p> $productDescription </p>
                          <span> Status: </span> <span> <strong> In Stock </strong> </span>
                        </div>
                      </div>
                    </td>
                    <td style='vertical-align: middle'>
                      <form action='view-cart.php' method='post'>
                        <input type='number' style='width:25%; padding-left:1%' name='newQuantity' min='1' max='100' value='$quantity'>
                        <input type='hidden' name='productId' value='$productIdCart'>
                        <input class='btn btn-outline-info' style='margin-left:2%' type='submit' value='Change'>
                      </form>
                    </td>
                    <td style='vertical-align: middle'>
                      $$price
                    </td>
                    <td style='vertical-align: middle'>
                      <strong>
                        $$totalForItem
                      </strong>
                    </td>
                    <td style='vertical-align: middle'>
                      <form action='view-cart.php' method='post'>
                        <input type='hidden' name='productIdRemove' value='$productIdCart'>
                        <input class='btn btn-outline-danger' type='submit' value='Remove'>
                      </form>
                    </td>
                  </tr>
            ";
          }

          $total = $subtotal + $shippingCost;

          echo 
          "
                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><h5>Subtotal</h5></td>
                    <td><h5><strong>$$subtotal</strong></h5></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><h5>Estimated shipping</h5></td>
                    <td><h5><strong>$$shippingCost</strong></h5></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><h3>Total</h3></td>
                    <td><h3><strong>$$total</strong></h3></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                      <a href='browse-items.php' class='btn btn-info'>Continue Shopping </a>
                    </td>
                    <td>
                      <a href='check-out.php' class='btn btn-success'>Check Out </a>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          ";
        }
        else
        {
          echo 
          "
            <div class='container' style='text-align:center;padding-top:5%;'>
              <h2>There are currently no items in your cart</h2>
            <div>
            <br><br><br>
          ";
        }
      ?>
    </div>

    <?php 
      require('footer.php'); 
      require('bootstrap-core-js.php'); 
    ?>
  </body>
</html>