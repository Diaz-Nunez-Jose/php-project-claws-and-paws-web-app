<header>
  <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <a class="navbar-brand" href="home.php">Claws and Paws</a>
    
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarCollapse">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a 
          <?php 
            if($currentPage == "home.php")
            {
              echo "class='nav-link active'";
            }
            else
            {
              echo "class='nav-link'";
            }
          ?>
          href="home.php">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a 
          <?php 
            if($currentPage == "browse-items-dog.php" || 
               $currentPage == "browse-items-cat.php" || 
               $currentPage == "browse-items-search.php")
            {
              echo "class='nav-link active'";
            }
            else
            {
              echo "class='nav-link'";
            }
          ?> href="browse-items-dog.php">Browse Items</a>
        </li>
      </ul>

      <form class="form-inline mt-2 mt-md-0" action="browse-items-search.php" method="post">
        <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search" name="search">
        <button class="btn fas fa-search" type="submit"></button>
      </form>

      <ul class="nav navbar-nav navbar-right">
        <li><a href="sign-in.php"><span class="btn fas fa-sign-in-alt"></span>Sign In</a></li>
        <li><a href="view-cart.php"><span class="btn fas fa-shopping-cart"></span>Cart</a></li>
      </ul>
    </div>
  </nav>
</header>