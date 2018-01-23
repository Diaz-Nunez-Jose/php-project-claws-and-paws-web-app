<html>
    <head>
        <title>
            Your Info - Results
        </title>
    </head>
    <body>
        <?php
            $name = $email = $major = $comment =  "";
            $continents = array();
            $continent_options = 
                array("na" => "North America", "sa" => "South America", "eu" => "Europe", 
                    "as" => "Asia", "af" => "Africa", "au" => "Australia", "an" => "Antactica");

            if ($_SERVER["REQUEST_METHOD"] == "POST") 
            {
                $name    = test_input($_POST["name"   ]);
                $email   = test_input($_POST["email"  ]);
                $major   = test_input($_POST["major"  ]);
                $comment = test_input($_POST["comment"]);

                if(!empty($_POST['continents'])) 
                {
                    foreach($_POST['continents'] as $check) 
                    {
                        array_push($continents, test_input($check));
                    }
                }
            }

            function test_input($data) 
            {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
            }  

            echo "<h1>Your Info (Results Page)</h1>";
            echo "<div><b>Your name</b>: $name</div><br>";
            echo "<div><b>Your email</b>: $email</div><br>";
            echo "<div><b>Your major</b>: $major</div><br>";
            echo "<div><b>Your comment</b>: $comment</div><br>";

            if(!empty($continents)) 
            {
                echo "<b>You have visited the following continents</b>:<br>";
                foreach($continents as $check)
                {
                    $continent_fullname = $continent_options[$check];
                    echo "<i>$continent_fullname</i><br>";
                }
            }
            else
            {
                echo "You haven't been to any continent? Not even your home continent? <br>Weird... \u{1F914}";
            }
        ?>

    </body>
</html>