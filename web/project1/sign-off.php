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
    <?php
      include('head.php');
    ?>
  </head>

  <body>
    <?php
      include('nav-bar.php');
    ?>
    
    <div class="container" style="padding-top: 50px">
    <h4>
      Please come back soon! <br> Redirecting to homepage in <span id="countdown">5</span> seconds.
    </h4>
    </div>

    <!-- JavaScript part -->
    <script type="text/javascript">
      // Source for countdown() function: https://gist.github.com/Joel-James/62d98e8cb3a1b6b05102
        
        // Total seconds to wait
        var seconds = 5;
        
        function countdown() {
            seconds = seconds - 1;
            if (seconds < 0) {
                // Chnage your redirection link here
                window.location = "home.php";
            } else {
                // Update remaining seconds
                document.getElementById("countdown").innerHTML = seconds;
                // Count down using javascript
                window.setTimeout("countdown()", 1000);
            }
        }
        
        // Run countdown function
        countdown();
    </script>
    
    <?php
      include('footer-scripts.php');
      header( "refresh:5;url=home.php" );
      exit;
    ?>    
  </body>
</html>
