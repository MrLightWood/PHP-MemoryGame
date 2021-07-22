<?php
include "db_connnection.php"; //Includes php file that executes connection to database
include "sanitize.php"; //Includes php file with sanitize function
$conn = OpenCon();

if($_POST && isset($_POST["username"]) && isset($_POST["time"]) && isset($_POST["difficulty"]) && $_POST["username"] != "")
{
    $username = sanitizeInputVar($conn, $_POST["username"]);  //Variable that stores Player's name
    $timeVal = $_POST["time"]; //Variable that stores the time of stopwatch
	$difficulty = $_POST["difficulty"]; //Variable that stores the game difficulty value
    $dateVal = date("Ymd"); //Variable that stores the current date

    $sql = "INSERT INTO leaderboards (name, difficulty, time, date)
    VALUES ('$username', $difficulty, $timeVal, '$dateVal');"; //SQL query that inserts the name, difficulty, time and date values to table

    mysqli_query($conn, $sql); //Make an SQL query

    CloseCon($conn); //Close the connection with database
}

$cardsOptions = array(4, 6, 8, 10, 12, 14, 16, 18, 20, 24, 28, 30, 32, 36, 40, 42, 56, 64); //Array that stores all possible card numbers options

if($_POST && isset($_POST["choose"]))
{
	foreach($cardsOptions as $item)
	{
		if($_POST["choose"] == $item)
		{
			$cardNumber = $_POST["choose"]; //Change card number variable with post value
			break;
		}
		else 
		{
			$cardNumber = 16; //Default number card is 16
		}
	}
} else 
{
	$cardNumber = 16; //Default number card is 16
}

//Function that defines the card numbers in one row
function CardsInRow($cardN)
{
    switch($cardN)
    {
        case 16:
        case 12: 
            return 4;
        break;

        case 24:
        case 36:
            return 6;
        break;
    }
    $result = 0;
    for($i = 1; $i < $cardN; $i++)
    {
        if(is_int($cardN / $i) && ($cardN / $i) != 1)
        {
            if($i < 9){
                $result = $i;
            }
        } elseif(($cardN / $i) == 1)
        {
            break;
        }
    }

    return $result;
}

$imagePath = "img/icons/"; //Path where the icons are saved

$imagesArr = array("001-smile","002-sad","003-happy","004-laughing","005-happy","006-crying","007-crying","008-wink","009-in love",
"010-laugh","011-dead","012-stress","013-tongue","014-sleep","015-shock","016-sad","017-creepy","018-shocked","019-greed",
"020-sick","021-grinning","022-suspicious","023-muted","024-kiss","025-kiss","026-kiss","027-sick","028-tongue","029-tongue",
"030-false","031-monocle","032-dissapointment","033-thinking","034-dead","035-famous","036-cynical","037-injury","038-angry",
"039-sleep","040-vomit","041-sick","042-cool","043-angry","044-hot","045-muted","046-angel","047-dizzy","048-nerd",
"049-father","050-secret"); //Array that defines all the emoji icons

$badge = "js-badge.svg"; //name of front side of card

$cardValue = 0; //Variable that defines the width and height of one card

//CardValue changes depending on value of total card number
switch($cardNumber)
{
    case 4:
        $cardValue = 400;
    break;

    case 6:
        $cardValue = 250;
    break;

    case 8:
    case 12:
    case 16:
        $cardValue = 200;
    break;

    case 10:
    case 20:
        $cardValue = 160;
    break;

    case 18:
    case 24:
    case 30:
    case 36:
        $cardValue = 130;
    break;

    case 14:
    case 28:
    case 42:
        $cardValue = 110;
    break;

    case 32:
    case 40:
    case 56:
    case 64:
        $cardValue = 100;
    break;
}

$cardWidth = $cardValue; //Width of one card
$cardHeight = $cardValue; //Height of one card

$boxWidth = 860; //The total size of box on which all cards are displayed
$boxHeight = ($cardValue * ($cardNumber / CardsInRow($cardNumber))) + 60; //Box height that changes depending on card numbers
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>
            Picture Memory Game
        </title>
        <link href="css/styles.css" rel="stylesheet">
    </head>
<body>
    <header>
        <!--Just Header with 3 links-->
        <div class = "header-title">
            <h1 class = "header-title-text">Picture Memory Game</h1>
        </div>

        <div class = "header">
            <nav class = "menu">
                <a href = "#" target = "_self" class = "menu-link">HOME</a>
                <a href = "leaderboards.php" target = "_self" class = "menu-link">LEADERBOARDS</a>
                <a href = "about.php" target = "_self" class = "menu-link">ABOUT</a>
            </nav>
        </div>
    </header>

    <main>
        <div class = "container">
            <!--Form that is used to change the game difficulty-->
            <form action="index.php" method="POST" id = "difficulty"> 
                <label for = "choose">Choose cards number: </label>
                <select id = "choose" name = "choose">
                    <?php
                    //Loop to add all possible difficulty values into HTML dropdown list
                        foreach($cardsOptions as $item)
                        {
                            echo "<option value = \"$item\">$item</option>";
                        }
                    ?>
                </select>
                <input type = "submit" value = "Submit" id = "submit-button">
            </form>

            <!--Stopwatch-->            
            <div id="stopwatch">
                <span>Your time: </span>
                <span class="stopwatch-time">00:00:00</span>
            </div>
            <!--PHP code that adds cards and shuffle them-->
            <?php
            echo "<div class = \"memory-game\" style = \"height: $boxHeight", "px; width: $boxWidth", "px;\">";
                shuffle($imagesArr);
                $val = 0;
                for($i = 0; $i < $cardNumber; $i++)
                {
                    if($i % 2 == 0)
                    {
                        $val += 1;
                    }
                    echo "<div class = \"memory-card\" data-framework = \"$imagesArr[$val]\" style=\"width: $cardWidth", "px; height: $cardHeight", "px;\">";
                    echo "<img class = \"front-face\" src = \"$imagePath$imagesArr[$val]", ".svg\" alt = \"$imagesArr[$val]\">";
                    echo "<img class = \"back-face\" src = \"img/", "$badge\" alt = \"Badge\">";
                    echo "</div>";
                }
            echo "</div>";
            ?>
            <!--The Congratulations window that appears after the player wins-->
            <div class = "win-box">
                <div class = "win-content">
                    <h1>Congratulations, You won!</h1>
                    <div id="stopwatch-end">
                    <span>Your time: </span>
                    <span class="stopwatch-time">00:00:00</span>
                    </div>
                    <!--Form that is used to submit the results to the server database. It just asks for username because other
                    values are already provided-->
                    <form action="index.php" method="POST" id = "win-form">
                        <input type="hidden" class = "stopwatch-time" value = "" name = "time">
                        <?php
                        //PHP code that passes cardNumber value as difficulty level 
						echo "<input type=\"hidden\" id = \"difficulty\" value = \"$cardNumber\" name = \"difficulty\">";
						?>
                        <label for = "username" id = "username" style = "padding: 0">Type your name</label>
                        <input type = "text" maxlength = "32" size = "32" id = "username" name = "username" required />
                        <input type = "submit" value = "Submit" id = "submit-button" style = "margin-top: 25px;" />
                    </form>
                </div>
            </div>
        </div>
    </main>
    <footer>
        <!--Just footer-->
        <div class = "footer-content">
            <span class = "footer-text">Made by Alikhan Sailekeyev</span>
            <span class = "footer-text">2020 All Rights Reserved</span>
        </div>
    </footer>
</body>
<script type="text/javascript">
    var cardNumber = <?php echo json_encode($cardNumber); ?>; //This code passes php variable cardNumber to javascript
</script>
<script type="text/javascript" src = "scripts/script.js" async></script>
</html>