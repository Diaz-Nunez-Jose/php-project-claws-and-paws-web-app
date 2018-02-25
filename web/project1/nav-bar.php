<nav class="navbar  navbar-expand-lg navbar-default navbar-light fixed-top" style="background-color: #f9f9f9;">
  <!-- <div class="container-fluid"> -->
  <div class="container">
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="navbar-nav navbar-left">
        <li class='nav-item'>
          <div class="navbar-brand"><strong>CLAWS &amp; PAWS</strong></div>
        </li>
        <li 
          <?php 
            if($currentPage == "home.php")
              echo "class='nav-item active'> <a href='#' class='nav-link'>"; 
            else
              echo "class='nav-item'> <a href='home.php' class='nav-link'>"; 
          ?>        
            Home <span class="sr-only">(current)</span>
          </a>
        </li>
        <li 
          <?php 
            if($currentPage == "browse-items.php")
              echo "class='nav-item active'> <a href='#' class='nav-link'>";
            else
              echo "class='nav-item'> <a href='browse-items.php' class='nav-link'>"; 
          ?>        
            Browse Items <span class="sr-only">(current)</span>
          </a>
        </li>
        <li class='nav-item'>
          <a href="#contact" class="nav-link">
            Contact <span class="sr-only">(current)</span>
          </a> 
        </li>
      </ul>
      <ul class="navbar-nav ml-auto">
        <?php
          if(!isset($_SESSION["loggedIn"]) || (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == 0))
          {
            echo "<li class='nav-item'><a href='sign-up.php' class='nav-link'>Welcome, Guest</a></li>"; 
            echo "<li class='nav-item'><a href='sign-in.php' class='nav-link'><span></span>Sign In</a></li>";
          }
          else
          {
            $idNav = $_SESSION['loggedIn'];
            $stmtNav = $db->prepare("SELECT first_name FROM member WHERE member_id = $idNav");
            $stmtNav->execute();
            $resultNav = $stmtNav->fetchAll(PDO::FETCH_ASSOC)[0];

            if($currentPage == "account.php")
              echo "<li class='nav-item active'><a href='#' class='nav-link'>Hello, " . $resultNav["first_name"] . "</a></li>";
            else
              echo "<li class='nav-item'><a href='account.php' class='nav-link'>Hello, " . $resultNav["first_name"] . "</a></li>";

            echo "<li class='nav-item'><a href='sign-off.php' class='nav-link'><span></span>Sign Off</a></li>";
          }
        ?>
        <li 
          <?php 
            if($currentPage == "view-cart.php")
              echo "class='nav-item active'> <a href='#' class='nav-link'>"; 
            else
              echo "class='nav-item'> <a href='view-cart.php' class='nav-link'>"; 
          ?>        
            Cart<span class="sr-only">(current)</span>
          </a>
        </li>
      </ul>
      <form class="navbar-form" role="search" action="browse-items.php" method="post">
        <div class="input-group" style="padding-left: 15px">
            <input type="text" class="form-control" placeholder="Search" name="search">
            <div class="input-group-btn">
                <button class="btn btn-outline-secondary my-2 my-sm-0" type="submit">Submit</button>
            </div>
        </div>
      </form>
    </div>  <!-- /.navbar-collapse -->
  </div>  <!--/.container-fluid-->
</nav>