<?php 
  session_start();
  // session_destroy();

  require "assets/scripts/get_db.php";
  $db = get_Db();

  $title = 'Sign In'; 
  $currentPage = 'sign-in.php';   

  if ($_SERVER["REQUEST_METHOD"] == "POST")
  {
    if(!empty($_POST["username"])  && !empty($_POST["password"]))
    {
      $username = $_POST["username"];
      $password = $_POST["password"];
      $stmt = $db->prepare("SELECT member_id, username, password, first_name FROM member WHERE username = '$username'");
      $stmt->execute();
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
      
      // echo "This is a valid password and username";
      $result = $result[0];
      // echo "$result["username"] == " . $result["username"] . "and $result["password"] == " . $username && $result["password"];
      if($result != NULL)
      {
        if ($result["username"] == $username && $result["password"] == $password) 
        {
          echo "Form input is valid - username and password linked and valid.<br>";
          $_SESSION["loggedIn"] = $result['member_id'];           
          $_SESSION["loggedInName"] = $result['first_name'];           
          echo "_SESSION at logged in is " . $_SESSION["loggedIn"] . "END<br>";
          header("Location: home.php");
          exit;
        }
        else
        {
          echo "This password and username not in the DB";
          $_SESSION["loggedIn"] = 0; 
          header("Location: sign-in.php");
          exit;
        }
      }
      else
      {
          echo "This password and username not in the DB";
          $_SESSION["loggedIn"] = 0; 
          echo "loggedIn session var = " . $_SESSION["loggedIn"] . "<br>";
          header("Location: sign-in.php");
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

    <!-- Custom styles for this template -->
    <link href="assets/bootstrap-3.3.7-dist/css/signin.css" rel="stylesheet">
  </head>

  <body>
    <?php
      include('nav-bar.php');
    ?>


    <div class="container">

      <form class="form-signin" action="sign-in.php" method="post">
      <img src="https://getbootstrap.com/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
      
        <h2 class="form-signin-heading">Please sign in</h2>
        <label for="inputUsername" class="sr-only">Username</label>
        <input type="text" id="inputUsername" class="form-control" placeholder="Username" name="username" required autofocus>

        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" class="form-control" placeholder="Password" name="password" required>
        <div class="checkbox">
          <label>
            <input type="checkbox" value="remember-me"> Remember me
          </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>

        <p>&copy; 2017-2018</p>

        <a href="sign-up.php">Not a member? Sign up now!</a>    
      </form>

    </div> <!-- /container -->

    <?php
      include('footer-scripts.php');
    ?>
  </body>
</html>