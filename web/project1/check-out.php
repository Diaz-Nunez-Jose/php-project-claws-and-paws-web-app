<?php 
  session_start();

  require "assets/scripts/get_db.php";
  $db = get_Db();

  $title = 'Check Out'; 
  $currentPage = 'check-out.php'; 
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <?php require('head.php'); ?>
  </head>

  <body style="padding-top: 5%">
    <?php require('nav-bar.php'); ?>
    
    <?php
      if(empty($_SESSION["cart"]))
      {
        header("Location: view-cart.php");
        die();
      }
      else
      {
        if($_SESSION["loggedIn"] == 0)
        {
          if ($_SERVER["REQUEST_METHOD"] == "POST") 
          {
            if(! empty($_POST["guestCheckoutSubmit"]))
            {
              echo
              "
                <div class='container'>
                  <form action='check-out-validation.php' method='post'>
                    <h3>Billing address</h3>
                    <div class='form-group'>
                      <input type='text' class='form-control' name='line1' placeholder='Line 1' required>
                    </div>
                    <div class='form-group'>
                      <input type='text' class='form-control' name='line2' placeholder='Line 2 (Optional)' optional>
                    </div>
                    <div class='form-group'>
                      <input type='text' class='form-control' name='city' placeholder='City' required>
                    </div>
                    <div class='form-group'>
                      <select class='form-control' name='state' required>
                        <option value=''>State</option>
                        <option>Alabama </option>
                        <option>Alaska </option>
                        <option>Arizona </option>
                        <option>Arkansas </option>
                        <option>California </option>
                        <option>Colorado </option>
                        <option>Connecticut </option>
                        <option>Delaware </option>
                        <option>Florida </option>
                        <option>Georgia </option>
                        <option>Hawaii </option>
                        <option>Idaho </option>
                        <option>Illinois </option>
                        <option>Indiana </option>
                        <option>Iowa </option>
                        <option>Kansas </option>
                        <option>Kentucky </option>
                        <option>Louisiana </option>
                        <option>Maine </option>
                        <option>Maryland </option>
                        <option>Massachusetts </option>
                        <option>Michigan </option>
                        <option>Minnesota </option>
                        <option>Mississippi </option>
                        <option>Missouri </option>
                        <option>Montana Nebraska </option>
                        <option>Nevada </option>
                        <option>New Hampshire </option>
                        <option>New Jersey </option>
                        <option>New Mexico </option>
                        <option>New York </option>
                        <option>North Carolina </option>
                        <option>North Dakota </option>
                        <option>Ohio </option>
                        <option>Oklahoma </option>
                        <option>Oregon </option>
                        <option>Pennsylvania </option>
                        <option>Rhode Island </option>
                        <option>South Carolina </option>
                        <option>South Dakota </option>
                        <option>Tennessee </option>
                        <option>Texas </option>
                        <option>Utah </option>
                        <option>Vermont </option>
                        <option>Virginia </option>
                        <option>Washington </option>
                        <option>West Virginia </option>
                        <option>Wisconsin </option>
                        <option>Wyoming</option>
                      </select>
                    </div>
                    <div class='form-group'>
                      <input type='text' class='form-control' name='zip' placeholder='Zip code' required>
                    </div>
                    <div class='form-check'>
                      <input type='checkbox' class='form-check-input' name='sameShipping'>
                      <label class='form-check-label' for='exampleCheck1'>Shipping address is same as billing</label>
                    </div>
                    <br><br>

                    <h3>Payment information</h3>
                    <div class='form-group'>
                      <input type='text' class='form-control' name='cardName' placeholder='Name on card' required>
                    </div>
                    <div class='form-group'>
                      <input type='text' class='form-control' name='cardNumber' placeholder='Card number' required>
                    </div>
                    <div class='form-group'>
                      <input type='date' class='form-control' name='cardExpiration' placeholder='Expiration date' required>
                    </div>
                    <div class='form-group'>
                      <input type='text' class='form-control' name='cardCVV' placeholder='CVV' required>
                    </div>
                    <br>
                    <button type='submit' class='btn btn-success '>Complete purchase!</button>
                  </form>
                </div>
              ";
            }
          }
          else
          {
            echo 
            "
              <div class='container'>
                <br> 
                <h2>You are not logged in.</h2>
                <br><br>
                <h3>Purchases may be completed as a guest</h3> 
                <form action='check-out.php' method='post'>
                  <input class='btn btn-outline-info' type='submit' name='guestCheckoutSubmit' value='Check out as guest'>
                </form> 
                <br><br>
                <h3>Don't have an account?</h3>
                  <p>Creating an account is as easy as ever!</p>
                <form action='sign-up.php' method='post'>
                  <input class='btn btn-outline-info' type='submit' value='Sign up now!'>
                </form>
                <br><br>
                <h3>Already have an account?</h3> 
                <form action='sign-in.php' method='post'>
                  <p>Certain promos and rewards are available only to members!</p>
                  <input class='btn btn-outline-info' type='submit' value='Sign in now!'>
                </form>
                <br><br>
              </div>
            ";              
          }
        }
        else
        {
          $id = $_SESSION['loggedIn'];

          $stmt = $db->prepare("SELECT first_name, middle_initial, last_name, email, username, password, purchases, address_id 
                                FROM   member 
                                WHERE  member_id = $id");
          $stmt->execute();
          $record = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];

          $firstName     = $record["first_name"    ];  
          $middleInitial = $record["middle_initial"];  
          $lastName      = $record["last_name"     ];  
          $username      = $record["username"      ];  
          $email         = $record["email"         ];  
          $purchases     = $record["purchases"     ];  
          $addressId     = $record["address_id"    ];
                                                       
          $line1 = NULL;
          $line2 = NULL;
          $city  = NULL;
          $state = NULL;
          $zip   = NULL;

          if ($addressId != NULL) 
          {
            $stmtAddr = $db->prepare("SELECT line_1, line_2, city, state, zip
                                      FROM   address 
                                      WHERE  address_id = '$addressId'");
            $stmtAddr->execute();
            $address = $stmtAddr->fetchAll(PDO::FETCH_ASSOC)[0];

            $line1 = $address["line_1"];
            $line2 = $address["line_2"];
            $city  = $address["city"  ];
            $state = $address["state" ];
            $zip   = $address["zip"   ];
          }

          echo 
          "          
            <div class='container'>
              <form action='check-out-validation.php' method='post'>
                <h3>Billing address</h3>
                <div class='form-group'>
                  <input type='text' class='form-control' name='line1' placeholder='Line 1' value='$line1' required>
                </div>
                <div class='form-group'>
                  <input type='text' class='form-control' name='line2' placeholder='Line 2 (Optional)' value='$line2' optional>
                </div>
                <div class='form-group'>
                  <input type='text' class='form-control' name='city' placeholder='City' value='$city' required>
                </div>
                <div class='form-group'>
                  <select class='form-control' name='state' required>
                    <option value=''>State</option>
                    <option>Alabama </option>
                    <option>Alaska </option>
                    <option>Arizona </option>
                    <option>Arkansas </option>
                    <option>California </option>
                    <option>Colorado </option>
                    <option>Connecticut </option>
                    <option>Delaware </option>
                    <option>Florida </option>
                    <option>Georgia </option>
                    <option>Hawaii </option>
                    <option>Idaho </option>
                    <option>Illinois </option>
                    <option>Indiana </option>
                    <option>Iowa </option>
                    <option>Kansas </option>
                    <option>Kentucky </option>
                    <option>Louisiana </option>
                    <option>Maine </option>
                    <option>Maryland </option>
                    <option>Massachusetts </option>
                    <option>Michigan </option>
                    <option>Minnesota </option>
                    <option>Mississippi </option>
                    <option>Missouri </option>
                    <option>Montana Nebraska </option>
                    <option>Nevada </option>
                    <option>New Hampshire </option>
                    <option>New Jersey </option>
                    <option>New Mexico </option>
                    <option>New York </option>
                    <option>North Carolina </option>
                    <option>North Dakota </option>
                    <option>Ohio </option>
                    <option>Oklahoma </option>
                    <option>Oregon </option>
                    <option>Pennsylvania </option>
                    <option>Rhode Island </option>
                    <option>South Carolina </option>
                    <option>South Dakota </option>
                    <option>Tennessee </option>
                    <option>Texas </option>
                    <option>Utah </option>
                    <option>Vermont </option>
                    <option>Virginia </option>
                    <option>Washington </option>
                    <option>West Virginia </option>
                    <option>Wisconsin </option>
                    <option>Wyoming</option>
                  </select>
                </div>
                <div class='form-group'>
                  <input type='text' class='form-control' name='zip' placeholder='Zip code' value='$zip' required>
                </div>
                <div class='form-check'>
                  <input type='checkbox' class='form-check-input' name='sameShipping'>
                  <label class='form-check-label' for='exampleCheck1'>Shipping address is same as billing</label>
                </div>
                <br><br>
                <h3>Payment information</h3>
                <div class='form-group'>
                  <input type='text' class='form-control' name='cardName' placeholder='Name on card' required>
                </div>
                <div class='form-group'>
                  <input type='text' class='form-control' name='cardNumber' placeholder='Card number' required>
                </div>
                <div class='form-group'>
                  Expiration date <br>
                  <input type='date' class='form-control' name='cardExpiration' required>
                </div>
                <div class='form-group'>
                  <input type='text' class='form-control' name='cardCVV' placeholder='CVV' required>
                </div>
                <br>
                <button type='submit' class='btn btn-success '>Complete purchase!</button>
              </form>
            </div>
          ";
        }
      }
    ?>
    
    <?php require('footer.php'); ?>
  </body>
</html>