
<br>

<!DOCTYPE html>
    <head>
        <title><?php echo($pageName); ?></title>
        <link rel="stylesheet" type="text/css" href="home_style.css"/>
    </head>

    <body>
        <div class="menu-area">
        <ul>
            <li><a href="Homepage.php">Home</a></li>
            <li><a href="sendMail.php">Contact</a></li>
            <li><a href="#"><?php echo($user); ?></a></li>
            <li><a href="gameEntry.php">Game entry</a></li>
            <?php if(isset($_SESSION['admin'])) : ?>
                <li><a href="listEntries.php">Entries</a> </li>
            <?php endif ?>
            <li><a href="Logout.php">Logout</a></li>
            <form method="GET" action="searchResults.php">
            <li><input required maxlength="50" type="text" name="search" id="search-box" placeholder="Type to search a game"></li>
            <li><input class="buttonce" type="submit" name="searchButton" value="Search"></li>
            </form>
        </ul>
        </div>
    </body>