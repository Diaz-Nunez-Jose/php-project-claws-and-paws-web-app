<?php 
  session_start();

  require "assets/scripts/get_db.php";
  $db = get_Db();

  $title = 'Sign In'; 
  $currentPage = 'sign-in.php';   

  if ($_SERVER["REQUEST_METHOD"] == "POST")
  {
    if(!empty($_POST["username"])  && !empty($_POST["password"]))
    {
      $username = htmlspecialchars($_POST["username"]);
      $password = htmlspecialchars($_POST["password"]);

      $stmt = $db->prepare("SELECT member_id, username, password, first_name 
                            FROM member 
                            WHERE username = '$username'");
      $stmt->execute();
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);      
      $result = $result[0];

      if($result != NULL)
      {
        // The commented out line below is the actual line of code to be used with hashing.
        // The other will be used for the demo only.
        // if ($result["username"] == $username && password_verify($password, $result["password"]))
        if ($result["username"] == $username && $password == $result["password"])
        {
          $_SESSION["loggedIn"] = $result['member_id'];           
          $_SESSION["loggedInName"] = $result['first_name'];           

          if (!empty($_SESSION["referrer"]) && $_SESSION["referrer"] == "check-out")
          {
            header("Location: check-out.php");
            die();
          }
          else
          {
            header("Location: home.php");
            die();
          }
        }
        else
        {
          $_SESSION["loggedIn"] = 0; 
          header("Location: sign-in.php");
          die();
        }
      }
      else
      {
          $_SESSION["loggedIn"] = 0; 
          header("Location: sign-in.php");
          die();        
      }
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <?php require('head.php'); ?>

    <!-- Custom styles for this template -->
    <link href="assets/css/signin.css" rel="stylesheet">
  </head>

  <body>
    <?php
      require('nav-bar.php');
      $_SESSION["referrer"] = basename(parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH), ".php").PHP_EOL; 
    ?>

    <div class="container-fluid">
      <form class="form-signin" action="sign-in.php" method="post">      
        <h1 class="form-signin-heading">Please sign in</h1>
        <label for="inputUsername" class="sr-only">Username</label>
        <input type="text" id="inputUsername" class="form-control" placeholder="Username" name="username" required autofocus>

        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" class="form-control" placeholder="Password" name="password" required>

        <div class="checkbox">
          <label> <input type="checkbox" value="remember-me"> Remember me </label>
        </div>

        <div style="text-align:center;">
          <button class="btn btn-primary " type="submit">Sign in</button> <br><br>
          <a href="sign-up.php">Not a member? Sign up now!</a>  <br>
          <p style="text-align:center;">&copy; 2017-2018</p>
        </div>
      </form>
    </div> <!-- /container -->
  </body>
</html>