<?php 
  session_start();

  if(isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] != 0) 
  {
    require "assets/scripts/get_db.php";
    $db = get_Db();
  }
  else
  {
    header("Location: home.php");
    die();
  }

  $title = 'Account'; 
  $currentPage = 'account.php'; 
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <?php require('head.php'); ?>

    <!-- Custom fonts for this template -->
    <link href="https://fonts.googleapis.com/css?family=Catamaran:100,200,300,400,500,600,700,800,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="assets/css/one-page-wonder.min.css" rel="stylesheet">
  </head>

  <body>
    <?php require('nav-bar.php'); ?>  

    <div class="container">
      <?php
        $id = $_SESSION['loggedIn'];

        $stmt = $db->prepare("SELECT first_name, middle_initial, last_name, email, username, password, purchases, address_id, user_image_url 
                              FROM   member 
                              WHERE  member_id = $id");
        $stmt->execute();
        $record = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];

        $userImage     = $record["user_image_url"]; 
        $firstName     = $record["first_name"    ]; 
        $middleInitial = $record["middle_initial"]; 
        $lastName      = $record["last_name"     ]; 
        $username      = $record["username"      ]; 
        $email         = $record["email"         ]; 
        $purchases     = $record["purchases"     ]; 
        $addressId     = $record["address_id"    ];
                                                    
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

        $stmtPet = $db->prepare("SELECT pet_member_id, pet_id, member_id
                                 FROM   pet_member 
                                 WHERE  member_id = $id");
        $stmtPet->execute();
        $pets = $stmtPet->fetchAll(PDO::FETCH_ASSOC);

        $petList = array();
        
        if ($_SERVER["REQUEST_METHOD"] != "POST")
        {
          echo 
          "
            <section>
              <div class='container' style='margin-top: 5%'>
                <div class='row align-items-center'>
                  <div class='col-lg-6 order-lg-2'>
                    <div class='p-5'>
                      <img class='img-fluid rounded-circle' src='$userImage' alt=''>
                    </div>
                  </div>
                  <div class='col-lg-6 order-lg-1'>
                    <div class='p-5'>
                      <h2 class='display-4'>$firstName $middleInitial. $lastName</h2>
                      <p style='font-size: 175%'>$line1 $line2 <br> $city, $state $zip <br> <a href='mailto:$email'>$email</a></p>
                    </div>
                  </div>
                </div>
              </div>
            </section>
          ";

          echo 
          "
            <div class='row' style='text-align: left; padding-left: 100px'>
              <table>
                <tr>
                  <th style='padding-bottom:10px'>              
                    <form action='account.php' method='post'>
                      Change image <br>
                      <input type='file' name='newImage' accept='image/*'>
                    </form>
                  </th>
                </tr>
                <tr>
                  <th style='padding-bottom:10px'>
                    <form action='account.php' method='post'>
                      <input class='btn btn-outline-info' style='width: 100%' type='submit' name='newFirstName' value='Change first name'>
                    </form>
                  </th>
                  <th style='padding-bottom:10px'>
                    <form action='account.php' method='post'>
                      <input class='btn  btn-outline-info' style='width: 100%' type='submit' name='newMiddleInitial' value='Change middle initial'>
                    </form>
                  </th>
                  <th style='padding-bottom:10px'>
                    <form action='account.php' method='post'>
                      <input class='btn  btn-outline-info' style='width: 100%' type='submit' name='newLastName' value='Change last name'>
                    </form>
                  </th>
                </tr>
                <tr>
                  <th style='padding-bottom:10px'>
                    <form action='account.php' method='post'>
                      <input class='btn btn-light btn-outline-info' style='width: 100%' type='submit' name='newUsername' value='Change username'>
                    </form>
                  </th>
                  <th style='padding-bottom:10px'>
                    <form action='account.php' method='post'>
                      <input class='btn btn-light btn-outline-info' style='width: 100%' type='submit' name='newEmail' value='Change e-mail address'>
                    </form>
                  </th>
                  <th style='padding-bottom:10px'>
                    <form action='account.php' method='post'>
                      <input class='btn btn-light btn-outline-info' style='width: 100%' type='submit' name='newAddress' value='Change home address'>
                    </form>
                  </th>
                </tr>
              </table>
            </div>
          ";

          if ($pets != NULL) 
          {
            echo 
            "
              <section>
                <div class='container'>
                  <div class='row align-items-center'>
                    <div class='col-lg-6 order-lg-1'>
                      <div class='p-5'>
                      <hr>
                        <h1>Registered pets</h1>
                        <hr>
                      </div>
                    </div>
                  </div>
                </div>
              </section>
            ";

            foreach ($pets as $pet) 
            {
              $petId = $pet["pet_id"];

              $stmtPet = $db->prepare("SELECT pet_id, pet_type, breed, pet_sex, first_name, last_name, address_id, pet_dob, pet_image_url
                                        FROM  pet 
                                        WHERE pet_id = $petId");
              $stmtPet->execute();
              $results = $stmtPet->fetchAll(PDO::FETCH_ASSOC)[0];
              $petList[$petId] = array($results);
            }
          }

          foreach($petList as $pet)
          {
            $pet          = $pet[0];
            $petId        = $pet["pet_id"];
            $petType      = $pet["pet_type"];
            $breed        = $pet["breed"];
            $petSex       = $pet["pet_sex"];
            $petFirstName = $pet["first_name"];
            $petLastName  = $pet["last_name"];
            $petDob       = $pet["pet_dob"];
            $petImage     = $pet["pet_image_url"];

            $uniqueFormId = "removePetForm" . $petId;

            echo 
            "
              <section>
                <div class='container'>
                  <div class='row align-items-center'>
                    <div class='col-lg-6'>
                      <div class='p-5'>
                        <img class='img-fluid rounded-circle' src='$petImage' alt=''>
                      </div>
                    </div>
                    <div class='col-lg-6'>
                      <div class='p-5'>
                        <h2 class='display-4'>$petFirstName $petLastName</h2>
                            <div ><h5>Registered information</h5></div>
                            <ul class='list-group'>
                              <li class='list-group-item'>
                                <i>Name</i> -  $petFirstName $petLastName
                              </li>
                              <li class='list-group-item'>
                                <i>Date of birth</i> - $petDob
                              </li>
                              <li class='list-group-item'>
                                <i>Type</i> - $petType
                              </li>
                              <li class='list-group-item'>
                                <i>Breed</i> - $breed
                              </li>
                              <li class='list-group-item'>
                                <i>Sex</i> - $petSex
                              </li>      
                            </ul>

                            <br>

                            <form action='account.php' method='post' id='$uniqueFormId'>
                              <input type='hidden' name='pet_id' value='$petId'>
                            </form>
                            <button class='btn btn-danger ' type='submit' form='$uniqueFormId' value='999' name='removePetRegistration'>Unregister $petFirstName</button>
                          </div>
                      </div>
                    </div>
                  </div>
                </div>
              </section>
            ";
          }

          echo 
          "
            <hr>

            <div style='padding:50px; text-align: center;'>
              <form action='account.php' method='post'>
                <input class='btn btn-success btn-lg' type='submit' name='newPetRegistration' value='Register a new pet'> </br></br>
              </form>
            </div>
          ";
        }
        else
        {
          if(!empty($_POST["newFirstName"]))
          {
            echo
            "
              <div class='container' style='padding-top: 10%;'>
                <form action='account.php' method='post' class='form-inline'>
                  <div class='form-group mb-2'>
                    <label >New first name</label>
                    <input class='form-control-plaintext' type='text' name='newFirstNameValue' required autofocus/> <br><br>
                    <input class='btn btn-info mb-2' type='submit' value='Submit change'>
                  </div>
                </form>
              </div>
            ";
          }

          if(!empty($_POST["newFirstNameValue"]))
          {
            $newFirstNameValue = htmlspecialchars($_POST["newFirstNameValue"]);
            $id = $_SESSION["loggedIn"];

            $stmtNewFirstName = $db->prepare("UPDATE member SET first_name = '$newFirstNameValue' WHERE member_id = $id");
            $stmtNewFirstName->execute();

            header("Location: account.php");
            die();
          }

          if(!empty($_POST["newMiddleInitial"]))
          {
            echo
            "
              <div class='container' style='padding-top: 10%;'>
                <form action='account.php' method='post' class='form-inline'>
                  <div class='form-group mb-2'>
                    <label >New middle initial</label>
                    <input class='form-control-plaintext' type='text' name='newMiddleInitialValue' required autofocus/> <br><br>
                    <input class='btn btn-info mb-2' type='submit' value='Submit change'>
                  </div>
                </form>
              </div>
            ";
          }

          if(!empty($_POST["newMiddleInitialValue"]))
          {
            $newMiddleInitialValue = htmlspecialchars($_POST["newMiddleInitialValue"]);
            $id = $_SESSION["loggedIn"];
            $stmtNewFirstName = $db->prepare("UPDATE member SET middle_initial = '$newMiddleInitialValue' WHERE member_id = $id");
            $stmtNewFirstName->execute();
            header("Location: account.php");
            die();
          }

          if(!empty($_POST["newLastName"]))
          {
            echo
            "
              <div class='container' style='padding-top: 10%;'>
                <form action='account.php' method='post' class='form-inline'>
                  <div class='form-group mb-2'>
                    <label >New last name</label>
                    <input class='form-control-plaintext' type='text' name='newLastNameValue' required autofocus/> <br><br>
                    <input class='btn btn-info mb-2' type='submit' value='Submit change'>
                  </div>
                </form>
              </div>
            ";
          }

          if(!empty($_POST["newLastNameValue"]))
          {
            $newLastNameValue = htmlspecialchars($_POST["newLastNameValue"]);
            $id = $_SESSION["loggedIn"];
            $stmtNewFirstName = $db->prepare("UPDATE member SET last_name = '$newLastNameValue' 
                                              WHERE member_id = $id");
            $stmtNewFirstName->execute();
            header("Location: account.php");
            die();
          }

          if(!empty($_POST["newEmail"]))
          {
            echo
            "
              <div class='container' style='padding-top: 10%;'>
                <form action='account.php' method='post' class='form-inline'>
                  <div class='form-group mb-2'>
                    <label >New e-mail address</label>
                    <input class='form-control-plaintext' type='email' name='newEmailValue' required autofocus/> <br><br>
                    <input class='btn btn-info mb-2' type='submit' value='Submit change'>
                  </div>
                </form>
              </div>
            ";
          }

          if(!empty($_POST["newEmailValue"]))
          {
            $newEmailValue = htmlspecialchars($_POST["newEmailValue"]);
            $id = $_SESSION["loggedIn"];
            $stmtNewFirstName = $db->prepare("UPDATE member SET email = '$newEmailValue' 
                                              WHERE member_id = $id");
            $stmtNewFirstName->execute();
            header("Location: account.php");
            die();
          }

          if(!empty($_POST["newImage"]))
          {
            echo
            "
              New image file path:
              <form action='account.php' method='post'>
                <input type='text' name='newImageValue' required autofocus/>
                <input class='btn btn-primary' type='submit' value='Submit change'>
              </form>
            ";
          }

          if(!empty($_POST["newImageValue"]))
          {
            $newImageValue = htmlspecialchars($_POST["newImageValue"]);
            $id = $_SESSION["loggedIn"];
            $stmtNewFirstName = $db->prepare("UPDATE member SET user_image_url = '$newImageValue' 
                                              WHERE member_id = $id");
            $stmtNewFirstName->execute();
            header("Location: account.php");
            die();
          }

          if(!empty($_POST["newUsername"]))
          {
            echo
            "
              <div class='container' style='padding-top: 10%;'>
                <form action='account.php' method='post' class='form-inline'>
                  <div class='form-group mb-2'>
                    <label >New username</label>
                    <input class='form-control-plaintext' type='text' name='newUsernameValue' required autofocus/> <br><br>
                    <input class='btn btn-info mb-2' type='submit' value='Submit change'>
                  </div>
                </form>
              </div>
            ";
          }

          if(!empty($_POST["newUsernameValue"]))
          {
            $newUsernameValue = htmlspecialchars($_POST["newUsernameValue"]);
            $id = $_SESSION["loggedIn"];
            $stmtNewFirstName = $db->prepare("UPDATE member SET username = '$newUsernameValue' 
                                              WHERE member_id = $id");
            $stmtNewFirstName->execute();
            header("Location: account.php");
            die();
          }

          if(!empty($_POST["newAddress"]))
          {
            echo
            "
              <div class='container' style='padding-top: 10%;'>
                <form action='account.php' method='post'>
                  <div class='form-row'>
                    <div class='col-md-4 mb-3'>
                      <label for='validationDefault01'>Line 1</label>
                      <input type='text' name='newLine1Value' class='form-control' id='validationDefault01' placeholder='Street address' required>
                    </div>
                  </div>
                  <div class='form-row'>
                    <div class='col-md-4 mb-3'>
                      <label for='validationDefault01'>Line 2</label>
                      <input type='text' name='newLine2Value' class='form-control' id='validationDefault01' placeholder='(Optional)' optional>
                    </div>
                  </div>
                  <div class='form-row'>
                    <div class='col-md-6 mb-3'>
                      <label for='validationDefault03'>City</label>
                      <input type='text' name='newCityValue' class='form-control' id='validationDefault03' placeholder='City' required>
                    </div>
                    <div class='col-md-3 mb-3'>
                      <label for='validationDefault04'>State</label>
                      <input type='text' name='newStateValue' class='form-control' id='validationDefault04' placeholder='State' required>
                    </div>
                    <div class='col-md-3 mb-3'>
                      <label for='validationDefault05'>Zip</label>
                      <input type='text' name='newZipValue' class='form-control' id='validationDefault05' placeholder='Zip' required>
                    </div>
                  </div>
                  <input class='btn btn-primary' type='submit' value='Submit change' name='newAddressValues'>
                </form>
              </div>
            ";
          }

          if(!empty($_POST["newAddressValues"]))
          {
            $newLine1Value = htmlspecialchars($_POST["newLine1Value"]);
            $newLine2Value = htmlspecialchars($_POST["newLine2Value"]);
            $newCityValue  = htmlspecialchars($_POST["newCityValue" ]);
            $newStateValue = htmlspecialchars($_POST["newStateValue"]);
            $newZipValue   = htmlspecialchars($_POST["newZipValue"  ]);

            if($addressId != NULL)
            {
              $stmtNewFirstName = $db->prepare("UPDATE address 
                                                SET line_1 = '$newLine1Value',
                                                    line_2 = '$newLine2Value',
                                                    city   = '$newCityValue',
                                                    state  = '$newStateValue',
                                                    zip    = '$newZipValue'
                                                WHERE address_id = $addressId");
              $stmtNewFirstName->execute();
              header("Location: account.php");
              die();
            }
            else
            {
              $stmtNewAddrInsert = $db->prepare("INSERT INTO address 
                                                (
                                                  line_1, 
                                                  line_2, 
                                                  city, 
                                                  state, 
                                                  zip
                                                )
                                                VALUES 
                                                (
                                                  ':new_line1_value',
                                                  ':new_line2_value',
                                                  ':new_city_value',
                                                  ':new_state_value',
                                                  ':new_zip_value'
                                                )");
              $stmtNewAddrInsert->execute
              (
                array
                (
                ':new_line1_value' => $newLine1Value,
                ':new_line2_value' => $newLine2Value,
                ':new_city_value' => $newCityValue,
                ':new_state_value' => $newStateValue,
                ':new_zip_value' => $newZipValue
                )
              );
              $newAddressId = $db->lastInsertId();
              $memberId = $_SESSION["loggedIn"];
              $stmtNewAddrInsertMember = $db->prepare("UPDATE member SET address_id = $newAddressId
                                                       WHERE  member_id = $memberId");
              $stmtNewAddrInsertMember->execute();
              header("Location: account.php");
              die();
            }
          }

          if(!empty($_POST["removePetRegistration"]))
          {
            $petId = htmlspecialchars($_POST["pet_id"]);
            echo $petId;
            $memberId = $_SESSION["loggedIn"];
            $stmtUnregisterPet = $db->prepare("DELETE FROM pet_member 
                                               WHERE pet_id = $petId AND member_id = $memberId");
            $stmtUnregisterPet->execute();
            $stmtUnregisterPet = $db->prepare("DELETE FROM pet 
                                               WHERE pet_id = $petId");
            $stmtUnregisterPet->execute();
            header("Location: account.php");
            die();
          }

          if(!empty($_POST["newPetRegistration"]))
          {
            echo
            "
              <div class='container' style='margin-top: 10%'>
                <form action='account.php' method='post'>
                  <h3>New pet registration information</h3>

                  <div class='form-group'>
                    <input type='text' class='form-control' name='newPetFirstNameValue' placeholder='First name' required>
                  </div>

                  <div class='form-group'>
                    <input type='text' class='form-control' name='newPetLastNameValue' placeholder='Last name' required>
                  </div>

                  <div class='form-group'>
                    <input type='text' class='form-control' name='newPetTypeValue' placeholder='Cat or dog' required>
                  </div>

                  <div class='form-group'>
                    <input type='text' class='form-control' name='newPetBreedValue' placeholder='Breed' required>
                  </div>

                  <div class='form-group'>
                    <input type='text' class='form-control' name='newPetSexValue' placeholder='Sex' required>
                  </div>

                  <div class='form-group'>
                  Date of birth
                    <input type='date' class='form-control' name='newPetDobValue' placeholder='Date of birth'>
                  </div>

                  <div class='form-group'>
                    Profile picture<br>
                    <input type='file' name='newPetImageUrlValue' accept='image/*'>
                  </div>

                  <input class='btn btn-primary' type='submit' value='Submit change' name='newPetRegistrationValues'>
                </form>
              </div>
            ";
          }

          if(!empty($_POST["newPetRegistrationValues"]))
          {
            $petFirstName   = htmlspecialchars($_POST['newPetFirstNameValue']);
            $petLastName    = htmlspecialchars($_POST['newPetLastNameValue']);
            $petPetType     = htmlspecialchars($_POST['newPetTypeValue']);
            $petBreed       = htmlspecialchars($_POST['newPetBreedValue']);
            $petSex         = htmlspecialchars($_POST['newPetSexValue']);
            $petDob         = htmlspecialchars($_POST['newPetDobValue']);
            $petPetImageUrl = htmlspecialchars($_POST['newPetImageUrlValue']);
            
            $stmtNewPetInsert = $db->prepare("INSERT INTO pet 
                                              (
                                                pet_type,
                                                breed,
                                                pet_sex,
                                                first_name,
                                                last_name,
                                                pet_image_url
                                              )
                                              VALUES 
                                              (
                                                :pet_pet_type,
                                                :pet_breed,
                                                :pet_sex,
                                                :pet_first_name,
                                                :pet_last_name,
                                                :pet_pet_image_url
                                              )");
            $stmtNewPetInsert->execute
            (
              array
              (
               ':pet_pet_type'      => $petPetType, 
               ':pet_breed'         => $petBreed, 
               ':pet_sex'           => $petSex, 
               ':pet_first_name'    => $petFirstName, 
               ':pet_last_name'     => $petLastName, 
               ':pet_pet_image_url' => $petPetImageUrl 
              )
            );

            $newPetId = $db->lastInsertId();
            $memberId = $_SESSION["loggedIn"];

            $stmtNewPetInsertPetMember = $db->prepare("INSERT INTO pet_member 
                                                       (
                                                          pet_id,
                                                          member_id
                                                       )
                                                       VALUES 
                                                       (
                                                          :new_pet_id, 
                                                          :member_id
                                                       )");
            $stmtNewPetInsertPetMember->execute
            (
              array
              (
                ':new_pet_id' => $newPetId,
                ':member_id'  => $memberId
              )
            );

            header("Location: account.php");
            die();
          }
        }
      ?>
    </div>

    <?php require('bootstrap-core-js.php'); ?>
  </body>
</html>