<?php 
  session_start();
  // session_destroy();

  if(isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] != 0) 
  {
    require "assets/scripts/get_db.php";
    $db = get_Db();
  }
  else
  {
    header("Location: home.php");
    exit;
  }

  $title = 'Account'; 
  $currentPage = 'account.php'; 
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
      $id = $_SESSION['loggedIn'];

      $stmt = $db->prepare("SELECT first_name, middle_initial, last_name, email, username, password, purchases, address_id, user_image_url 
                            FROM   member 
                            WHERE  member_id = $id");
      $stmt->execute();
      $record = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];

      $userImage     = $record["user_image_url"];     /**/
      $firstName     = $record["first_name"    ];   // /**/
      $middleInitial = $record["middle_initial"];   /**/
      $lastName      = $record["last_name"     ];   // /**/
      $username      = $record["username"      ];   // /**/
      $email         = $record["email"         ];   // /**/
      $purchases     = $record["purchases"     ];   /**/
      $addressId     = $record["address_id"    ];
                                                    // password /**/

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

      // echo var_dump($pets);

      $petList = array();

      if ($pets != NULL) 
      {
        foreach ($pets as $pet) 
        {
          $petId = $pet["pet_id"];

          /*
          pet_type, breed, pet_sex, first_name, last_name, address_id, pet_dob
          */

          $stmtPet = $db->prepare("SELECT pet_id, pet_type, breed, pet_sex, first_name, last_name, address_id, pet_dob, pet_image_url
                                    FROM  pet 
                                    WHERE pet_id = $petId");
          $stmtPet->execute();
          $results = $stmtPet->fetchAll(PDO::FETCH_ASSOC)[0];
          $petList[$petId] = array($results);
        }
      }
      
      if ($_SERVER["REQUEST_METHOD"] != "POST")
      {
        echo 
        "
          <h1>Your account information:</h1>

          <form action='account.php' method='post'>
            Image: $userImage </br>
            <img src='$userImage' alt='' width='72' height='72'>
            <input type='submit' name='newImage' value='Change image'> </br></br>

            Username: $username </br>
            <input type='submit' name='newUsername' value='Change username'> </br></br>

            First name: $firstName </br>
            <input type='submit' name='newFirstName' value='Change first name'> </br></br>

            Middle initial: $middleInitial </br>
            <input type='submit' name='newMiddleInitial' value='Change middle initial'> </br></br>

            Last name: $lastName </br>
            <input type='submit' name='newLastName' value='Change last name'> </br></br>

            E-mail address: $email </br>
            <input type='submit' name='newEmail' value='Change e-mail address'> </br></br>

            Number of purchases: $purchases </br></br>

            <h2>Your registered home address:</h2>

            Line 1: $line1 </br>
            Line 2: $line2 </br>
            City: $city </br>
            State: $state </br>
            Zip code: $zip </br>
            <input type='submit' name='newAddress' value='Change or add address'> </br></br>
          </form>

            <h2>Your registered pet(s):</h2>
        ";

        foreach($petList as $pet)
        {
          $pet = $pet[0];
          $petId = $pet["pet_id"];
          $petType = $pet["pet_type"];
          $breed = $pet["breed"];
          $petSex = $pet["pet_sex"];
          $petFirstName = $pet["first_name"];
          $petLastName = $pet["last_name"];
          $petDob = $pet["pet_dob"];
          $petImage = $pet["pet_image_url"];

          $uniqueFormId = "removePetForm" . $petId;
          echo "uniqueFormId = " . $uniqueFormId . "<br>"; 

          echo 
          "
            Pet image: $petImage </br>
            First name: $petFirstName </br>
            Last name: $petLastName </br>
            Date of birth: $petDob </br>
            Type: $petType </br>
            Breed: $breed </br>
            Sex: $petSex </br>

            <form action='account.php' method='post' id='$uniqueFormId'>
              <input type='hidden' name='pet_id' value='$petId'>
            </form>
            <button type='submit' form='$uniqueFormId' value='999' name='removePetRegistration'>Un-register $petFirstName</button>
          ";
        }

        echo 
        "
          <form action='account.php' method='post'>
            <input type='submit' name='newPetRegistration' value='Regster a new pet'> </br></br>
          </form>
        ";
      }
      else
      {
        if(!empty($_POST["newFirstName"]))
        {
          echo
          "
            New first name:
            <form action='account.php' method='post'>
              <input type='text' name='newFirstNameValue' required autofocus/>
              <input type='submit' value='Submit change'>
            </form>
          ";
        }

        if(!empty($_POST["newFirstNameValue"]))
        {
          $newFirstNameValue = $_POST["newFirstNameValue"];
          $id = $_SESSION["loggedIn"];
          $stmtNewFirstName = $db->prepare("UPDATE member SET first_name = '$newFirstNameValue' WHERE member_id = $id");
          $stmtNewFirstName->execute();
          header("Location: account.php");
          exit;
        }







        if(!empty($_POST["newMiddleInitial"]))
        {
          echo
          "
            New middle initial:
            <form action='account.php' method='post'>
              <input type='text' name='newMiddleInitialValue' required autofocus/>
              <input type='submit' value='Submit change'>
            </form>
          ";
        }

        if(!empty($_POST["newMiddleInitialValue"]))
        {
          $newMiddleInitialValue = $_POST["newMiddleInitialValue"];
          $id = $_SESSION["loggedIn"];
          $stmtNewFirstName = $db->prepare("UPDATE member SET middle_initial = '$newMiddleInitialValue' WHERE member_id = $id");
          $stmtNewFirstName->execute();
          header("Location: account.php");
          exit;
        }







        if(!empty($_POST["newLastName"]))
        {
          echo
          "
            New last name:
            <form action='account.php' method='post'>
              <input type='text' name='newLastNameValue' required autofocus/>
              <input type='submit' value='Submit change'>
            </form>
          ";
        }

        if(!empty($_POST["newLastNameValue"]))
        {
          $newLastNameValue = $_POST["newLastNameValue"];
          $id = $_SESSION["loggedIn"];
          $stmtNewFirstName = $db->prepare("UPDATE member SET last_name = '$newLastNameValue' WHERE member_id = $id");
          $stmtNewFirstName->execute();
          header("Location: account.php");
          exit;
        }







        if(!empty($_POST["newEmail"]))
        {
          echo
          "
            New e-mail address:
            <form action='account.php' method='post'>
              <input type='text' name='newEmailValue' required autofocus/>
              <input type='submit' value='Submit change'>
            </form>
          ";
        }

        if(!empty($_POST["newEmailValue"]))
        {
          $newEmailValue = $_POST["newEmailValue"];
          $id = $_SESSION["loggedIn"];
          $stmtNewFirstName = $db->prepare("UPDATE member SET email = '$newEmailValue' WHERE member_id = $id");
          $stmtNewFirstName->execute();
          header("Location: account.php");
          exit;
        }







        if(!empty($_POST["newImage"]))
        {
          echo
          "
            New image file path:
            <form action='account.php' method='post'>
              <input type='text' name='newImageValue' required autofocus/>
              <input type='submit' value='Submit change'>
            </form>
          ";
        }

        if(!empty($_POST["newImageValue"]))
        {
          $newImageValue = $_POST["newImageValue"];
          $id = $_SESSION["loggedIn"];
          $stmtNewFirstName = $db->prepare("UPDATE member SET user_image_url = '$newImageValue' WHERE member_id = $id");
          $stmtNewFirstName->execute();
          header("Location: account.php");
          exit;
        }







        if(!empty($_POST["newUsername"]))
        {
          echo
          "
            New username:
            <form action='account.php' method='post'>
              <input type='text' name='newUsernameValue' required autofocus/>
              <input type='submit' value='Submit change'>
            </form>
          ";
        }

        if(!empty($_POST["newUsernameValue"]))
        {
          $newUsernameValue = $_POST["newUsernameValue"];
          $id = $_SESSION["loggedIn"];
          $stmtNewFirstName = $db->prepare("UPDATE member SET username = '$newUsernameValue' WHERE member_id = $id");
          $stmtNewFirstName->execute();
          header("Location: account.php");
          exit;
        }






        if(!empty($_POST["newAddress"]))
        {
          echo
          "
            <form action='account.php' method='post'>
              New line 1: <input type='text' name='newLine1Value' required autofocus/>
              New line 2: <input type='text' name='newLine2Value' autofocus/>
              New city:   <input type='text' name='newCityValue'  required autofocus/>
              New state:  <input type='text' name='newStateValue' required autofocus/>
              New zip:    <input type='text' name='newZipValue'   required autofocus/>

              <input type='submit' value='Submit change' name='newAddressValues'>
            </form>
          ";
        }

        if(!empty($_POST["newAddressValues"]))
        {
          $newLine1Value = $_POST["newLine1Value"];
          $newLine2Value = $_POST["newLine2Value"];
          $newCityValue  = $_POST["newCityValue" ];
          $newStateValue = $_POST["newStateValue"];
          $newZipValue   = $_POST["newZipValue"  ];

          if($addressId != NULL)
          {
            $stmtNewFirstName = $db->prepare("UPDATE address SET line_1 = '$newLine1Value',
                                                                 line_2 = '$newLine2Value',
                                                                 city = '$newCityValue',
                                                                 state = '$newStateValue',
                                                                 zip = '$newZipValue'
                                              WHERE address_id = $addressId");
            $stmtNewFirstName->execute();
            header("Location: account.php");
            exit;
          }
          else
          {
            echo "test";
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
                                                '$newLine1Value',
                                                '$newLine2Value',
                                                '$newCityValue',
                                                '$newStateValue',
                                                '$newZipValue'
                                              )");
            $stmtNewAddrInsert->execute();
            $newAddressId = $db->lastInsertId();
            $memberId = $_SESSION["loggedIn"];
            $stmtNewAddrInsertMember = $db->prepare("UPDATE member SET address_id = $newAddressId
                                                     WHERE  member_id = $memberId");
            $stmtNewAddrInsertMember->execute();
            header("Location: account.php");
            exit;
          }
        }



        if(!empty($_POST["removePetRegistration"]))
        {
          // echo "string";
          $petId = $_POST["pet_id"];
          echo $petId;
          $memberId = $_SESSION["loggedIn"];
          $stmtUnregisterPet = $db->prepare("DELETE FROM pet_member 
                                              WHERE  pet_id = $petId AND member_id = $memberId");
          $stmtUnregisterPet->execute();
          $stmtUnregisterPet = $db->prepare("DELETE FROM pet 
                                              WHERE  pet_id = $petId");
          $stmtUnregisterPet->execute();
          // header("Location: account.php");
          // exit;
        }



        if(!empty($_POST["newPetRegistration"]))
        {
          echo
          "
            <form action='account.php' method='post'>
              First name 1: <input type='text' name='newPetFirstNameValue' required autofocus/>
              Last name: <input type='text' name='newPetLastNameValue' required autofocus/>
              Pet type (D or C): <input type='text' name='newPetTypeValue' required autofocus/>
              Breed: <input type='text' name='newPetBreedValue' required autofocus/>
              Sex: <input type='text' name='newPetSexValue' required autofocus/>
              Date of birth: <input type='text' name='newPetDobValue' autofocus/>
              Pet image URL: <input type='text' name='newPetImageUrlValue' autofocus/>

              <input type='submit' value='Submit change' name='newPetRegistrationValues'>
            </form>
          ";
        }

        if(!empty($_POST["newPetRegistrationValues"]))
        {
          $petFirstName = $_POST['newPetFirstNameValue'];
          $petLastName = $_POST['newPetLastNameValue'];
          $petPetType = $_POST['newPetTypeValue'];
          $petBreed = $_POST['newPetBreedValue'];
          $petSex = $_POST['newPetSexValue'];
          $petDob = $_POST['newPetDobValue'];
          $petPetImageUrl = $_POST['newPetImageUrlValue'];
          
          $stmtNewPetInsert = $db->prepare("INSERT INTO pet 
                                            (
                                              pet_type,
                                              breed,
                                              pet_sex,
                                              first_name,
                                              last_name,
                                              pet_dob,
                                              pet_image_url
                                            )
                                            VALUES 
                                            (
                                              '$petPetType',
                                              '$petBreed',
                                              '$petSex',
                                              '$petFirstName',
                                              '$petLastName',
                                              null,
                                              '$petPetImageUrl'
                                            )");
          $stmtNewPetInsert->execute();


          $newPetId = $db->lastInsertId();
          $memberId = $_SESSION["loggedIn"];

          echo "TEST " . $newPetId;

          $stmtNewPetInsertPetMember = $db->prepare("INSERT INTO pet_member 
                                                     (
                                                        pet_id,
                                                        member_id
                                                     )
                                                     VALUES 
                                                     (
                                                        $newPetId, 
                                                        $memberId
                                                     )");
          $stmtNewPetInsertPetMember->execute();
          header("Location: account.php");
          exit;
        }
      }
    ?>

    <?php
      include('footer.php');
      include('footer-scripts.php');
    ?>    
  </body>
</html>