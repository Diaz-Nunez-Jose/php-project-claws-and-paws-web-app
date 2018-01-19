<!-- Core Requirement 2: Add a common header / navbar for all of your pages. -->

<?php
	// Core Requirement 3: Change the navbar so that the current 
    // page is highlighted in some way.

	$currentPage   = $_SERVER['SCRIPT_NAME'];
	$linkStyleHome = $linkStyleAbout = $linkStyleLogin = "";
	
	if($currentPage == '/web/team02/home.php')
	{
		$linkStyleHome = "style=\"color: red\"";
	}
	else if($currentPage == '/web/team02/about-us.php')
	{
		$linkStyleAbout = "style=\"color: red\"";
	}
	else if($currentPage == '/web/team02/login.php')
	{
		$linkStyleLogin = "style=\"color: red\"";
	}

	echo 
	"
			<div>
				<p>
					Company Name, Inc.
				</p>
			
				<ul>
					<li>
						<a href=\"home.php\" $linkStyleHome>
							HOME
						</a>
					</li>
					<li>
						<a href=\"about-us.php\" $linkStyleAbout>
							ABOUT US
						</a>
					</li>
					<li>
						<a href=\"login.php\" $linkStyleLogin>
							LOG IN
						</a>
					</li>
				</ul>
			</div>
	";
?>