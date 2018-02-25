<?php 
  session_start();

  require "assets/scripts/get_db.php";
  $db = get_Db();

  $title = 'Sign In'; 
  $currentPage = 'sign-in.php'; 

  if ($_SERVER["REQUEST_METHOD"] == "POST")
  {
    if(!empty($_POST["firstName"]) && !empty($_POST["lastName"]) && !empty($_POST["email"]) && 
       !empty($_POST["username"])  && !empty($_POST["password"]) && !empty($_POST["passwordConfirm"]))
    {
      $username        = htmlspecialchars($_POST["username"]);
      $email           = htmlspecialchars($_POST["email"]);
      $password        = htmlspecialchars($_POST["password"]);
      $passwordConfirm = htmlspecialchars($_POST["passwordConfirm"]);

      $stmtUsername = $db->prepare("SELECT username 
                                    FROM member 
                                    WHERE username = '$username'");
      $stmtUsername->execute();

      $stmtEmail = $db->prepare("SELECT email 
                                 FROM member 
                                 WHERE email = '$email'");
      $stmtEmail->execute();

      if(empty($stmtUsername->fetchAll(PDO::FETCH_ASSOC)) && 
         empty($stmtEmail->fetchAll(PDO::FETCH_ASSOC)) && 
         $passwordConfirm == $password)
      {
        $firstName = htmlspecialchars($_POST["firstName"]);
        $lastName  = htmlspecialchars($_POST["lastName"]);
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $stmtNewUser = $db->prepare("INSERT INTO member 
                                     (
                                         first_name, 
                                         last_name, 
                                         email, 
                                         username, 
                                         password
                                      ) 
                                      VALUES 
                                      (
                                         :first_name, 
                                         :last_name, 
                                         :email, 
                                         :username, 
                                         :password
                                      )");
        $stmtNewUser->execute
        (
          array
          (
          ':first_name' => $firstName,
          ':last_name'  => $lastName,
          ':email'      => $email,
          ':username'   => $username,
          ':password'   => $passwordHash
          )
        );

        $stmtNewUsername = $db->prepare("SELECT username FROM member WHERE username = '$username'");
        $stmtNewUsername->execute();

        $last_id = $db->lastInsertId();
        $_SESSION["loggedIn"] = $last_id; 
        header("Location: home.php");
        die();
      }
      else
      {
        $_SESSION["loggedIn"] = 0; 
        header("Location: sign-up.php");
        die();
      }
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <?php require('head.php'); ?>

    <!-- Stylesheet for this page -->
    <link href="assets/css/signin.css" rel="stylesheet">
  </head>

  <body>
    <?php require('nav-bar.php'); ?>

    <div class="container-fluid" style="margin-top: 5%">
      <form class="form-signin align-items-center"  action="sign-up.php" method="post">
        <h1>Enter the following to sign up now!</h1>

        <label for="inputFirstName" class="sr-only">First name</label>
        <input type="text" id="inputFirstName"  class="form-control" placeholder="First name" name="firstName" required autofocus>

        <label for="inputLastName" class="sr-only">Last name</label>
        <input type="text" id="inputLastName"  class="form-control" placeholder="Last name" name="lastName" required autofocus>

        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="email" id="inputEmail"  class="form-control" placeholder="Email address" name="email" required autofocus>

        <label for="inputUsername" class="sr-only">Username</label>
        <input type="text" id="inputUsername"  class="form-control" placeholder="Username" name="username" required autofocus>
        
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword"  class="form-control" placeholder="Password" name="password" required>
        
        <label for="inputPasswordConfirm" class="sr-only">Confirm password</label>
        <input type="password" id="inputPasswordConfirm"  class="form-control" placeholder="Confirm password" name="passwordConfirm" required>

        <div style="text-align:center;">
          <button class="btn btn-primary" type="submit">Sign up</button> <br><br>
          <a href="sign-in.php">Already a member? Sign in now!</a>  <br>
          <p style="text-align:center;">&copy; 2017-2018</p>
        </div>
      </form>
    </div>
  </body>
</html>