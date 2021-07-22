<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>
            About
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
                <a href = "leaderboards.php" target = "_self" class = "menu-link">LEADERBOARDS</a>
                <a href = "#" target = "_self" class = "menu-link">ABOUT</a>
            </nav>
        </div>
    </header>

    <main>
        <div class = "container">
            <div class = "about-box">
                <!--Instruction of how to play this game-->
                <h2 id = "about-header">How to play</h2>
                <p id = "about-text">At the beginning of the game, all the cards are mixed up and laid in rows, face down on the screen.
                 The player starts and turns over two cards.
                 If the cards don’t match (it’s not a pair), he turns them back over.
                 However, if the two cards match, it’s a pair! He keeps the cards and continues playing.
                 When the player have found all the pairs, the game is over. Good luck! The players results are available on
                 leaderboards page</p>
                 <img id=example src="img/example.png">
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