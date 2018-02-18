<?php 
  session_start();
  // session_destroy();

  require "assets/scripts/get_db.php";

  $db = get_Db();

  $title = 'View Cart'; 
  $currentPage = 'view-cart.php'; 

  echo (empty($_SESSION["cart"]) ? "The cart is empty" : "The cart is NOT empty");
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <?php
      include('head.php');
    ?>
  </head>

  <body>
    <?php
      include('nav-bar.php');
    ?>

    <div>
      <div>
        <div>
          <?php      

            if(isset($_SESSION["cart"]) && !empty($_SESSION["cart"]))
            {
              if ($_SERVER["REQUEST_METHOD"] == "POST")
              {
                if(!empty($_POST["productIdRemove"]))
                {
                  $productIdRemove = $_POST["productIdRemove"];
                  unset($_SESSION["cart"]["$productIdRemove"]);
                  if (empty($_SESSION["cart"])) 
                  {
                    header("Location: view-cart.php");
                    exit;
                  }
                }

                if(!empty($_POST["newQuantity"]))
                {
                  $newQuantity = NULL;
                  $newQuantityProductId = NULL;
                  $newQuantity = $_POST["newQuantity"];
                  if(!empty($_POST["productId"]))
                  {
                    $newQuantityProductId = $_POST["productId"];
                  }

                  $_SESSION["cart"][$newQuantityProductId] = $newQuantity;
                }
              }



              $subtotal = 0.00;
              $shippingCost = 7.99;

              $productsInCart = array();
              foreach ($_SESSION["cart"] as $productId => $quantity) 
              {
                // echo $productId . " - " . $quantity . "</br>";
                $productsInCart[$productId]["quantity"] = $quantity;
                // echo var_dump($productsInCart) . "</br>";

                $stmt = $db->prepare("SELECT price, product_name, product_description, product_image_url 
                                      FROM   product 
                                      WHERE  product_id = $productId");
                $stmt->execute();
                $dbProduct = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
                // echo var_dump("<br>" . $product["product_name"] . "<br><br>");
                $productsInCart[$productId]["price"] = $dbProduct["price"];
                $productsInCart[$productId]["product_name"] = $dbProduct["product_name"];
                $productsInCart[$productId]["product_description"] = $dbProduct["product_description"];
                $productsInCart[$productId]["product_image_url"] = $dbProduct["product_image_url"];
                $productsInCart[$productId]["product_id"] = $productId;
              }

              // echo var_dump($productsInCart);
              

              echo
              "
              <div class='container'>
              <div class='table-striped'>
                <table class='table'> 
                  <thead>
                    <tr>
                      <th>Item</th>
                      <th>Quantity</th>
                      <th>Price</th>
                      <th>Item Total</th>
                      <th> </th>
                    </tr>
                  </thead>

                  <tbody>
              ";

              $quantity = NULL;
              $price = NULL;
              $productName = NULL;
              $productDescription = NULL;
              $productImageUrl = NULL;
              $productIdCart = NULL;

              foreach ($productsInCart as $product) 
              {
                $quantity = $product["quantity"];
                $price = $product["price"];
                $productName = $product["product_name"];
                $productDescription = $product["product_description"];
                $productImageUrl = $product["product_image_url"];
                $productIdCart = $product["product_id"];

                $totalForItem = $quantity * $price;
                $subtotal += $totalForItem;

                echo 
                "     <tr>
                        <td>
                          <div>
                            <img src='$productImageUrl' style='width: 72px; height: 72px;'>
                            <div>
                              <h4>
                                $productName
                              </h4>
                              <h5>
                                $productDescription
                              </h5>
                              <span>
                                Status: 
                              </span>
                              <span>
                                <strong>  
                                  In Stock
                                </strong>
                              </span>
                            </div>
                          </div>
                        </td>

                        <td style='text-align: center'>

                          <form action='view-cart.php' method='post'>
                            <input type='number' name='newQuantity' min='1' max='100' value='$quantity'>
                            <input type='hidden' name='productId' value='$productIdCart'>
                            <input type='submit' value='Change quantity'>
                          </form>
                        </td>

                        <td>
                          <strong>
                            $$price
                          </strong>
                        </td>

                        <td>
                          <strong>
                            $$totalForItem
                          </strong>
                        </td>

                        <td>

                          <form action='view-cart.php' method='post'>
                            <input type='hidden' name='productIdRemove' value='$productIdCart'>
                            <input type='submit' value='Remove'>
                          </form>

                        </td>
                      </tr>
                ";
              }

              $total = $subtotal + $shippingCost;

              echo 
              "
                    <tr>
                      <td>   </td>
                      <td>   </td>
                      <td>   </td>
                      <td><h5>Subtotal</h5></td>
                      <td><h5><strong>$$subtotal</strong></h5></td>
                    </tr>
                    <tr>
                      <td>   </td>
                      <td>   </td>
                      <td>   </td>
                      <td><h5>Estimated shipping</h5></td>
                      <td><h5><strong>$$shippingCost</strong></h5></td>
                    </tr>
                    <tr>
                      <td>   </td>
                      <td>   </td>
                      <td>   </td>
                      <td><h3>Total</h3></td>
                      <td><h3><strong>$$total</strong></h3></td>
                    </tr>
                    <tr>
                      <td>   </td>
                      <td>   </td>
                      <td>   </td>
                      <td>
                        <a href='browse-items.php'>
                          <span></span> Continue Shopping
                        </a>
                      </td>
                      <td>
                        <a href='check-out.php'>
                          <span></span> Check Out
                        </a>
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
              echo "<h2>There are no items in your cart!</h2>";
            }
          ?>

        </div>
      </div>
    </div>

    <?php
      include('footer.php');
      include('footer-scripts.php');
    ?>
  </body>
</html>