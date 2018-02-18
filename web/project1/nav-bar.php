<nav class="navbar navbar-default navbar-static-top" style="position: fixed; right: 0; left: 0; top: 0;">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <div class="navbar-brand">Claws &amp; Paws</div>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li 
          <?php 
            if($currentPage == "home.php")
              echo "class='active'> <a href='#'>"; 
            else
              echo " > <a href='home.php'>"; 
          ?>        
            Home
            <span class="sr-only">(current)
            </span>
          </a>
        </li>

        <li 
          <?php 
            if($currentPage == "browse-items.php")
              echo "class='active'> <a href='#'>";
            else
              echo " > <a href='browse-items.php'>"; 
          ?>        
            Browse Items
            <span class="sr-only">(current)
            </span>
          </a>
        </li>

        <li>
          <a href="#contact">
            Contact
            <span class="sr-only">(current)
            </span>
          </a> 
        </li>
      </ul>

      <form class="navbar-form navbar-right" action="browse-items.php" method="post">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Search" name="search">
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
      </form>

      <ul class="nav navbar-nav navbar-right">
        <?php
          if(!isset($_SESSION["loggedIn"]) || (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == 0))
          {
            echo "<li><a href='sign-up.php'>Welcome, Guest</a></li>"; 
            echo "<li><a href='sign-in.php'><span></span>Sign In</a></li>";
          }
          else
          {
            $idNav = $_SESSION['loggedIn'];
            $stmtNav = $db->prepare("SELECT first_name FROM member WHERE member_id = $idNav");
            $stmtNav->execute();
            $resultNav = $stmtNav->fetchAll(PDO::FETCH_ASSOC)[0];

            if($currentPage == "account.php")
              echo "<li class='active'><a href='#'>Hello, " . $resultNav["first_name"] . "</a></li>";
            else
              echo "<li><a href='account.php'>Hello, " . $resultNav["first_name"] . "</a></li>";

            echo "<li><a href='sign-off.php'><span></span>Sign Off</a></li>";
          }
        ?>

        <li 
          <?php 
            if($currentPage == "view-cart.php")
              echo "class='active'> <a href='#'>"; 
            else
              echo " > <a href='view-cart.php'>"; 
          ?>        
            Cart
            <span class="sr-only">(current)
            </span>
          </a>
        </li>

<!--         <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#">Action</a></li>
            <li><a href="#">Another action</a></li>
            <li><a href="#">Something else here</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#">Separated link</a></li>
          </ul>
        </li> -->

      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>