<?php 
  session_start();
  $_SESSION["loggedIn"] = 0; 
  session_destroy();

  $title = 'Sign Off'; 
  $currentPage = 'sign-off.php'; 
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <?php require('head.php'); ?>
  </head>

  <body>
    <?php require('nav-bar.php'); ?>

    <div class='container' style='text-align:center;padding-top:10%;'>
      <h2>Please come back soon!</h2>
      <br>
      <h4>Redirecting to homepage in <span id="countdown">5</span> seconds.</h4>
    <div>
    <br><br><br>

    <!-- JavaScript part -->
    <script type="text/javascript">
      // Source for countdown() function: 
      // https://gist.github.com/Joel-James/62d98e8cb3a1b6b05102   

      var seconds = 5; // Total seconds to wait

      function countdown() 
      {
        seconds = seconds - 1;
        if (seconds < 0) 
        {
            // Chnage your redirection link here
            window.location = "home.php";
        } else 
        {
            // Update remaining seconds
            document.getElementById("countdown").innerHTML = seconds;
            // Count down using javascript
            window.setTimeout("countdown()", 1000);
        }
      }      
      
      countdown(); // Run countdown function
    </script>
    
    <?php
      header("refresh:5;url=home.php");
      die();
    ?>    
  </body>
</html>