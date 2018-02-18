<?php 
  session_start();
  // session_destroy();

  require "assets/scripts/get_db.php";
  $db = get_Db();

  $title = 'Sign In'; 
  $currentPage = 'sign-in.php'; 

  if ($_SERVER["REQUEST_METHOD"] == "POST")
  {
    if(!empty($_POST["firstName"]) && !empty($_POST["lastName"]) && !empty($_POST["email"]) && 
       !empty($_POST["username"])  && !empty($_POST["password"]) && !empty($_POST["passwordConfirm"]))
    {
      $username = $_POST["username"];
      $email = $_POST["email"];
      $password = $_POST["password"];
      $passwordConfirm = $_POST["passwordConfirm"];
      $stmtUsername = $db->prepare("SELECT username FROM member WHERE username = '$username'");
      $stmtUsername->execute();
      $stmtEmail = $db->prepare("SELECT email FROM member WHERE email = '$email'");
      $stmtEmail->execute();
      if(empty($stmtUsername->fetchAll(PDO::FETCH_ASSOC)) && empty($stmtEmail->fetchAll(PDO::FETCH_ASSOC)) && $passwordConfirm == $password)
      {
        // echo "This is a unique email and username";
        $firstName = $_POST["firstName"];
        $lastName = $_POST["lastName"];

        $stmtNewUser = $db->prepare("INSERT INTO member (first_name, last_name, email, username, password) VALUES (:first_name, :last_name, :email, :username, :password)");
        $stmtNewUser->execute
        (
          array
          (
          ':first_name' => $firstName,
          ':last_name'  => $lastName,
          ':email'      => $email,
          ':username'   => $username,
          ':password'   => $password
          )
        );
        $stmtNewUsername = $db->prepare("SELECT username FROM member WHERE username = '$username'");
        $stmtNewUsername->execute();
        echo "A new user was added: " . $stmtNewUsername->fetchAll(PDO::FETCH_ASSOC) . "<br>";
        // $stmtUsername = $db->prepare("SELECT username FROM member WHERE username = '$username'");
        // $stmtUsername->execute();

        $last_id = $db->lastInsertId();
        echo "The id is " . $last_id;
        $_SESSION["loggedIn"] = $last_id; 
        echo "_SESSION at logged in is " . $_SESSION["loggedIn"] . "<br>";
        header("Location: home.php");
        exit;
      }
      else
      {
        echo "This email and username already exist in the DB";
        $_SESSION["loggedIn"] = 0; 
        header("Location: sign-up.php");
        exit;
      }
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <?php
      include('head.php');
    ?>
    <link href="assets/bootstrap-3.3.7-dist/css/signin.css" rel="stylesheet">
  </head>

  <body>
    <?php
      include('nav-bar.php');
    ?>

    <div class="container">
      <form class="form-signin"  action="sign-up.php" method="post">
        <img src="https://getbootstrap.com/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
        <h1>Please enter the following information to sign up!</h1>

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
       
        <button type="submit">Sign up</button>

        <p>&copy; 2017-2018</p>

        <a href="sign-in.php">Already a member? Sign in now!</a>
      </form>
    </div>
    
    <?php
      include('footer-scripts.php');
    ?>
  </body>
</html>