<?php
include "db_connnection.php";
$conn = OpenCon(); //Open the connection with database

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>
            Leaderboards
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
                <a href = "index.php" target = "_self" class = "menu-link">HOME</a>
                <a href = "#" target = "_self" class = "menu-link">LEADERBOARDS</a>
                <a href = "about.php" target = "_self" class = "menu-link">ABOUT</a>
            </nav>
        </div>
    </header>

    <main>
        <div class = "container">
            <div class = "about-box">
                <?php
                //PHP Code that asks for data from leaderboard table from the database

                $sql = "SELECT name, difficulty, time, date FROM leaderboards"; //Open the table
                $result = $conn->query($sql); //Save the query result to variable
                //Create table
                echo "<table>";
                echo "<tr>";
                echo "<th>Name</th>";
                echo "<th style = \"text-shadow: 1px 1px black;\">Difficulty</th>";
                echo "<th>Time</th>";
                echo "<th>Date</th>";
                echo "</tr>";
                if ($result->num_rows > 0) {
                    // Output data of each row
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['name'] . "</td>"; //Output players name
                        echo "<td>" . $row['difficulty'] . " cards" . "</td>"; //Output difficulty level
                        echo "<td>" . gmdate('H:i:s', $row["time"]) . "</td>"; //Output time value
                        echo "<td>" . $row["date"] . "</td>"; //Output date
                        echo "</tr>";
                    }
                } else {
                    //If no data found in table output 0 results
                    echo "0 results";
                }

                CloseCon($conn); //Close the connection with database
                echo "</table>";
                ?>
            </div>
        </div>
    </main>
    <footer>
        <!--Just footer-->        
        <div class = "footer-content">
            <span class = "footer-text">Made by Alikhan Sailekeyev & Fakhri Ramazan</span>
            <span class = "footer-text">2020 All Rights Reserved</span>
        </div>
    </footer>
</body>
</html>