<?php
    $continent_options = 
    array("na" => "North America", "sa" => "South America", "eu" => "Europe", 
        "as" => "Asia", "af" => "Africa", "au" => "Australia", "an" => "Antactica");
?>

<html>
    <head>
        <title>
            Your Info - Submission
        </title>
    </head>
    <body>
        <h1>
            Your Info (Submission Page)
        </h1>
        <form id="user" action="input.php" method="post">
            <b>Name</b>: <input type="text" name="name">
            </br>

            <b>E-mail</b>: <input type="text" name="email">
            </br>
            </br>

            <b>What is your major?</b>
            </br>
            <input type="radio" name="major" value="Computer Science"> Computer Science
            </br>
            <input type="radio" name="major"value="Web Design"> Web Design
            </br>
            <input type="radio" name="major" value="Computer Information Technology"> CIT
            </br>
            <input type="radio" name="major" value="Computer Engineering"> Computer Engineering
            </br>
            </br>

            <b>Where have you visited?</b>
            </br>

            <?php
                if( !empty($continent_options) )
                {
                    foreach ($continent_options as $continent_code => $continent) 
                    {
                        echo "<input type='checkbox' name='continents[]' value='$continent_code'> $continent
                            <br>";
                    }
                }
            ?>

            </br>

            <b>Feel free to leave a comment</b>:
            </br>
            <textarea name="comment" form="user" placeholder="Enter comment here..."></textarea>
            </br>
            </br>

            <input type="submit" value="Submit Information">
        </form>
    </body>
</html>
