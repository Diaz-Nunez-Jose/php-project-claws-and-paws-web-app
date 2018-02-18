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
    <?php
      include('head.php');
    ?>
  </head>

  <body>
    <?php
      include('nav-bar.php');
    ?>
    
    <?php
      if(empty($_SESSION["cart"]))
      {
        header("Location: view-cart.php");
        exit;
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
              <div class='containier'>
                <form action='check-out-validation.php' method='post'>
                  <div>
                    <img src='https://getbootstrap.com/assets/brand/bootstrap-solid.svg' alt='' width='72' height='72'>
                    <h2>Check Out as Guest</h2>
                  </div>

                  <div>
                    <div>
                      <input type='text' placeholder='Promo code'>
                      <div>
                        <input type='text' name='promoCode'>Redeem</input>
                      </div>
                    </div>

                    <!-- Checkout information -->
                    <div>
                      <h4>Billing address</h4>
                        <div>
                          <div>
                            <label for='firstName'>First name</label>
                            <input type='text' id='firstName' placeholder='' value='' name='firstName' required>
                            <div>
                              Valid first name is required.
                            </div>
                          </div>
                          <div>
                            <label for='lastName'>Last name</label>
                            <input type='text' placeholder='' value='' name='lastName' required>
                            <div>
                              Valid last name is required.
                            </div>
                          </div>
                        </div>

                        <div>
                          <label for='email'>Email <span>(Optional)</span></label>
                          <input type='email' id='email' name='email' placeholder='you@example.com'>
                          <div>
                            Please enter a valid email address for shipping updates.
                          </div>
                        </div>

                        <div>
                          <label for='address'>Address</label>
                          <input type='text' id='address' name='line1' placeholder='1234 Main St' required>
                          <div>
                            Please enter your shipping address.
                          </div>
                        </div>

                        <div>
                          <label for='address2'>Address 2 <span>(Optional)</span></label>
                          <input type='text' id='address2' name='line2' placeholder='Apartment or suite'>
                        </div>

                        <div>
                          <div>
                            <label for='country'>Country</label>
                            <select id='country' required>
                              <option value='' name='country'>Choose...</option>
                              <option>United States</option>
                            </select>
                            <div>
                              Please select a valid country.
                            </div>
                          </div>
                          <div>
                            <label for='state'>State</label>
                            <select id='state' name='state' required>
                              <option value=''>Choose...</option>
                              <option>California</option>
                            </select>
                            <div>
                              Please provide a valid state.
                            </div>
                          </div>
                          <div>
                            <label for='zip'>Zip</label>
                            <input type='text' id='zip' name='zip' placeholder='' required>
                            <div>
                              Zip code required.
                            </div>
                          </div>
                        </div>
                        <hr>
                        <div custom-checkbox'>
                          <input type='checkbox' name='shippingSameAsBilling' id='same-address'>
                          <label for='same-address'>Shipping address is the same as my billing address</label>
                        </div>

                        <hr>

                        <h4>Payment</h4>

                        <div>
                          <div>
                            <input id='credit' name='paymentMethod' type='radio'  checked required>
                            <label for='credit'>Credit card</label>
                          </div>
                          <div>
                            <input id='debit' name='paymentMethod' type='radio' required>
                            <label for='debit'>Debit card</label>
                          </div>
                          <div>
                            <input id='paypal' name='paymentMethod' type='radio' required>
                            <label for='paypal'>Paypal</label>
                          </div>
                        </div>
                        <div>
                          <div>
                            <label for='cc-name'>Name on card</label>
                            <input type='text' id='cc-name' placeholder='' name='cardName' required>
                            <small>Full name as displayed on card</small>
                            <div>
                              Name on card is required
                            </div>
                          </div>
                          <div>
                            <label for='cc-number'>Credit card number</label>
                            <input type='text' id='cc-number' name='cardNumber' placeholder='' required>
                            <div>
                              Credit card number is required
                            </div>
                          </div>
                        </div>
                        <div>
                          <div>
                            <label for='cc-expiration'>Expiration</label>
                            <input type='text' id='cc-expiration' name='cardExpiration' placeholder='' required>
                            <div>
                              Expiration date required
                            </div>
                          </div>
                          <div>
                            <label for='cc-expiration'>CVV</label>
                            <input type='text' id='cc-cvv' name='cardCVV' placeholder='' required>
                            <div>
                              Security code required
                            </div>
                          </div>
                        </div>
                        <hr>
                        <input type='submit' value='Confirm order'>
                        </hr>
                    </div>
                  </div>
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
                <h3>You are not logged in.</h3>

                <form action='check-out.php' method='post'>
                  <input type='submit' name='guestCheckoutSubmit' value='Check out as guest'>
                </form>

                <h3>Already have an account?</h3>

                <form action='sign-in.php' method='post'>
                  <input type='submit' value='Log in'>
                </form>

                <h3>Don't have an account?</h3>

                <form action='sign-up.php' method='post'>
                  <input type='submit' value='Create account'>
                </form>
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

          $firstName     = $record["first_name"    ];   // /**/
          $middleInitial = $record["middle_initial"];   /**/
          $lastName      = $record["last_name"     ];   // /**/
          $username      = $record["username"      ];   // /**/
          $email         = $record["email"         ];   // /**/
          $purchases     = $record["purchases"     ];   /**/
          $addressId     = $record["address_id"    ];
                                                        // password /**/
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
              <div>
                <img src='https://getbootstrap.com/assets/brand/bootstrap-solid.svg' alt='' width='72' height='72'>
                <h2>Check Out with Account</h2>
              </div>

              <div>
                <div>
                  <input type='text' placeholder='Promo code'>
                  <div>
                    <input type='text' name='promoCode'>Redeem</input>
                  </div>
                </div>

                <!-- Checkout information -->
                <div>
                  <h4>Billing address</h4>
                    <div>
                      <div>
                        <label for='firstName'>First name</label>
                        <input type='text' id='firstName' placeholder='' value='$firstName' name='firstName' required>
                        <div>
                          Valid first name is required.
                        </div>
                      </div>
                      <div>
                        <label for='lastName'>Last name</label>
                        <input type='text' placeholder='' value='$lastName' name='lastName' required>
                        <div>
                          Valid last name is required.
                        </div>
                      </div>
                    </div>

                    <div>
                      <label for='email'>Email <span>(Optional)</span></label>
                      <input type='email' id='email' value='$email' name='email' placeholder='you@example.com'>
                      <div>
                        Please enter a valid email address for shipping updates.
                      </div>
                    </div>

                    <div>
                      <label for='address'>Address</label>
                      <input type='text' id='address' value='$line1' name='line1' placeholder='1234 Main St' required>
                      <div>
                        Please enter your shipping address.
                      </div>
                    </div>

                    <div>
                      <label for='address2'>Address 2 <span>(Optional)</span></label>
                      <input type='text' id='address2' name='line2' value='$line2' placeholder='Apartment or suite'>
                    </div>

                    <div>
                      <div>
                        <label for='country'>Country</label>
                        <select id='country' required>
                          <option value='' name='country'>Choose...</option>
                          <option>United States</option>
                        </select>
                        <div>
                          Please select a valid country.
                        </div>
                      </div>
                      <div>
                        <label for='state'>State</label>
                        <select id='state' name='state' required>
                          <option value=''>$state</option>
                          <option>California</option>
                        </select>
                        <div>
                          Please provide a valid state.
                        </div>
                      </div>
                      <div>
                        <label for='zip'>Zip</label>
                        <input type='text' id='zip' value='$zip' name='zip' placeholder='' required>
                        <div>
                          Zip code required.
                        </div>
                      </div>
                    </div>
                    <hr>
                    <div custom-checkbox'>
                      <input type='checkbox' name='shippingSameAsBilling' id='same-address'>
                      <label for='same-address'>Shipping address is the same as my billing address</label>
                    </div>

                    <hr>

                    <h4>Payment</h4>

                    <div>
                      <div>
                        <input id='credit' name='paymentMethod' type='radio'  checked required>
                        <label for='credit'>Credit card</label>
                      </div>
                      <div>
                        <input id='debit' name='paymentMethod' type='radio' required>
                        <label for='debit'>Debit card</label>
                      </div>
                      <div>
                        <input id='paypal' name='paymentMethod' type='radio' required>
                        <label for='paypal'>Paypal</label>
                      </div>
                    </div>
                    <div>
                      <div>
                        <label for='cc-name'>Name on card</label>
                        <input type='text' id='cc-name' placeholder='' name='cardName' required>
                        <small>Full name as displayed on card</small>
                        <div>
                          Name on card is required
                        </div>
                      </div>
                      <div>
                        <label for='cc-number'>Credit card number</label>
                        <input type='text' id='cc-number' name='cardNumber' placeholder='' required>
                        <div>
                          Credit card number is required
                        </div>
                      </div>
                    </div>
                    <div>
                      <div>
                        <label for='cc-expiration'>Expiration</label>
                        <input type='text' id='cc-expiration' name='cardExpiration' placeholder='' required>
                        <div>
                          Expiration date required
                        </div>
                      </div>
                      <div>
                        <label for='cc-expiration'>CVV</label>
                        <input type='text' id='cc-cvv' name='cardCVV' placeholder='' required>
                        <div>
                          Security code required
                        </div>
                      </div>
                    </div>
                    <hr>
                    <input type='submit' value='Confirm order'>
                    </hr>
                </div>
              </div>
            </form>
            </div>
          ";
        }
      }
    ?>
    
    <?php
      include('footer.php');
      include('footer-scripts.php');
    ?>
  </body>
</html>