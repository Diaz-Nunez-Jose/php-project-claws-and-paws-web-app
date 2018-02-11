<?php 
  $title = 'Sign In'; 
  $currentPage = 'sign-in.php'; 
?>

<!DOCTYPE html>
<html lang="en">

  <head>
    <?php
      include('head.php');
    ?>

    <!-- Custom styles for this template -->
    <link href="assets/bootstrap-4.0.0/docs/4.0/examples/sign-in/signin.css" rel="stylesheet">
  </head>

  <body class="bg-light">
    <?php
      include('nav-bar.php');
    ?>

    <main role="main">
      <form class="form-signin">
        <img class="mb-4" src="https://getbootstrap.com/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
        <h1 class="h3 mb-3 font-weight-normal">Please enter the following information</h1>

        <label for="inputFirstName" class="sr-only">First name</label>
        <input type="text" id="inputFirstName" class="form-control" placeholder="First name" required autofocus>

        <label for="inputLastName" class="sr-only">Last name</label>
        <input type="text" id="inputLastName" class="form-control" placeholder="Last name" required autofocus>

        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>

        <label for="inputUsername" class="sr-only">Username</label>
        <input type="text" id="inputUsername" class="form-control" placeholder="Username" required autofocus>
        
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" class="form-control" placeholder="Password" required>
        
        <label for="inputPasswordConfirm" class="sr-only">Confirm password</label>
        <input type="password" id="inputPasswordConfirm" class="form-control" placeholder="Confirm password" required>
       
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign up!</button>

        <p class="mt-5 mb-3 text-muted">&copy; 2017-2018</p>

        <form>
          <a href="sign-in.php">Already a member? Sign in now!</a>
        </form>
      </form>

    </main>

    <?php
      include('core-js.php');
    ?>
  </body>
</html>